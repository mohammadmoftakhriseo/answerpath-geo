<?php
declare(strict_types=1);

namespace App\Services;

/**
 * سرویس یکپارچه‌ساز ارتباط با پروتکل MCP و پلتفرم Composio جهت مدیریت و انتشار مستقیم پست‌ها در لینکدین
 */
class McpLinkedInService
{
    private const MCP_ENDPOINT = 'https://connect.composio.dev/mcp';
    private const API_KEY      = 'ck_06T2x-M2km1igEv4sR-5';
    private const AUTHOR_URN   = 'urn:li:person:56kDDRCJsB';

    /**
     * انتشار مستقیم پست در پروفایل رسمی لینکدین
     *
     * @param string $commentary متن کامل پست
     * @param string $visibility وضعیت انتشار (PUBLIC پیش‌فرض)
     * @return array [ok => bool, postId => string, error => string]
     */
    public static function publishPost(string $commentary, string $visibility = 'PUBLIC'): array
    {
        $cleanCommentary = trim($commentary);
        if (empty($cleanCommentary)) {
            return [
                'ok'    => false,
                'error' => 'متن پست خالی است و امکان انتشار در لینکدین وجود ندارد.'
            ];
        }

        // رعایت سقف ۳۰۰۰ کاراکتر رسمی لینکدین
        if (mb_strlen($cleanCommentary) > 2950) {
            $cleanCommentary = mb_substr($cleanCommentary, 0, 2950) . '...';
        }

        $payload = [
            'jsonrpc' => '2.0',
            'id'      => time(),
            'method'  => 'tools/call',
            'params'  => [
                'name'      => 'COMPOSIO_MULTI_EXECUTE_TOOL',
                'arguments' => [
                    'tools' => [
                        [
                            'tool_slug' => 'LINKEDIN_CREATE_LINKED_IN_POST',
                            'arguments' => [
                                'author'     => self::AUTHOR_URN,
                                'commentary' => $cleanCommentary,
                                'visibility' => $visibility
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $ch = curl_init(self::MCP_ENDPOINT);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT        => 45,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . self::API_KEY,
                'Content-Type: application/json; charset=utf-8',
                'Accept: application/json, text/event-stream'
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($httpCode !== 200 || empty($response)) {
            error_log("[McpLinkedInService] HTTP Error: {$httpCode}, cURL Error: {$curlError}");
            return [
                'ok'    => false,
                'error' => "خطای ارتباط با سرور MCP (کد وضعیت: {$httpCode}). " . ($curlError ?: 'پاسخی دریافت نشد.')
            ];
        }

        // پردازش خطوط Server-Sent Events (SSE) یا فرمت خالص JSON
        $jsonStr = '';
        $lines = explode("\n", (string)$response);
        foreach ($lines as $line) {
            $line = trim($line);
            if (str_starts_with($line, 'data:')) {
                $candidate = trim(substr($line, 5));
                if (!empty($candidate)) {
                    $jsonStr = $candidate;
                }
            }
        }

        if (empty($jsonStr)) {
            $jsonStr = (string)$response;
        }

        $data = json_decode($jsonStr, true);
        if (!is_array($data)) {
            return [
                'ok'    => false,
                'error' => 'پاسخ نامعتبر از سرور MCP: ' . mb_substr($jsonStr, 0, 200)
            ];
        }

        if (!empty($data['error'])) {
            $errMessage = $data['error']['message'] ?? 'خطای پروتکل MCP JSON-RPC';
            return [
                'ok'    => false,
                'error' => $errMessage
            ];
        }

        $toolResText = $data['result']['content'][0]['text'] ?? '';
        $toolData = json_decode($toolResText, true);

        if (!empty($toolData['successful'])) {
            $results = $toolData['data']['results'] ?? [];
            $postResult = $results[0]['response']['data'] ?? [];
            $postId = $postResult['x_restli_id'] ?? $postResult['id'] ?? 'published_ok';

            return [
                'ok'      => true,
                'postId'  => (string)$postId,
                'details' => $postResult
            ];
        }

        $errorMessage = $toolData['error'] 
            ?? ($toolData['data']['results'][0]['response']['error'] ?? 'خطا در انتشار پست لینکدین');

        if (is_array($errorMessage)) {
            $errorMessage = json_encode($errorMessage, JSON_UNESCAPED_UNICODE);
        }

        return [
            'ok'    => false,
            'error' => (string)$errorMessage
        ];
    }
}
