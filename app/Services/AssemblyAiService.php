<?php
declare(strict_types=1);

namespace App\Services;

/**
 * سرویس یکپارچه‌ساز اختصاصی پردازش صوت، ویس و تبدیل گفتار به متن فارسی با موتور هوشمند AssemblyAI
 */
class AssemblyAiService
{
    public const API_KEY = 'f022cd6007c0404db01c08fc10071320';
    private const UPLOAD_URL = 'https://api.assemblyai.com/v2/upload';
    private const TRANSCRIPT_URL = 'https://api.assemblyai.com/v2/transcript';

    /**
     * تبدیل دیتای باینری ویس تلگرام به متن دقیق فارسی با موتور هوشمند AssemblyAI
     *
     * @param string $binaryAudio فایل باینری ویس تلگرام
     * @return string|null متن استخراج‌شده یا null در صورت خطا
     */
    public static function transcribe(string $binaryAudio): ?string
    {
        if (empty($binaryAudio)) {
            return null;
        }

        // ۱. آپلود فایل صوتی به مخزن موقت AssemblyAI
        $ch = curl_init(self::UPLOAD_URL);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $binaryAudio,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTPHEADER     => [
                'Authorization: ' . self::API_KEY,
                'Content-Type: application/octet-stream'
            ]
        ]);

        $uploadRes = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($httpCode !== 200 || empty($uploadRes)) {
            error_log("[AssemblyAI] Upload failed with HTTP {$httpCode}: {$uploadRes} {$err}");
            return null;
        }

        $uploadData = json_decode((string)$uploadRes, true);
        $audioUrl = $uploadData['upload_url'] ?? null;
        if (empty($audioUrl)) {
            return null;
        }

        // ۲. ارسال درخواست تبدیل صوت به متن با تشخیص خودکار زبان
        $payload = [
            'audio_url'          => $audioUrl,
            'language_detection' => true
        ];

        $ch = curl_init(self::TRANSCRIPT_URL);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_HTTPHEADER     => [
                'Authorization: ' . self::API_KEY,
                'Content-Type: application/json'
            ]
        ]);

        $transRes = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || empty($transRes)) {
            error_log("[AssemblyAI] Transcript request failed with HTTP {$httpCode}: {$transRes}");
            return null;
        }

        $transData = json_decode((string)$transRes, true);
        $transcriptId = $transData['id'] ?? null;
        if (empty($transcriptId)) {
            return null;
        }

        // ۳. بررسی و پولینگ وضعیت پیاده‌سازی صوت (حداکثر ۱۵ ثانیه)
        $pollUrl = self::TRANSCRIPT_URL . '/' . $transcriptId;
        $maxAttempts = 12;

        for ($i = 0; $i < $maxAttempts; $i++) {
            sleep(1);

            $ch = curl_init($pollUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT        => 8,
                CURLOPT_HTTPHEADER     => [
                    'Authorization: ' . self::API_KEY
                ]
            ]);

            $pollRes = curl_exec($ch);
            curl_close($ch);

            if (!empty($pollRes)) {
                $statusData = json_decode((string)$pollRes, true);
                $status = $statusData['status'] ?? '';

                if ($status === 'completed') {
                    $text = trim((string)($statusData['text'] ?? ''));
                    return !empty($text) ? $text : null;
                }

                if ($status === 'error') {
                    error_log("[AssemblyAI] Transcript failed: " . ($statusData['error'] ?? 'Unknown error'));
                    return null;
                }
            }
        }

        return null;
    }
}
