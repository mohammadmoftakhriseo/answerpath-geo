<?php
declare(strict_types=1);

use App\Core\Env;

/**
 * GitHub Integration & Auto-Sync Configuration
 * Repository: https://github.com/mohammadmoftakhriseo/answerpath-geo
 */
return [
    'token'       => (string)Env::get('GITHUB_TOKEN', ''),
    'owner'       => (string)Env::get('GITHUB_OWNER', 'mohammadmoftakhriseo'),
    'repo'        => (string)Env::get('GITHUB_REPO', 'answerpath-geo'),
    'branch'      => (string)Env::get('GITHUB_BRANCH', 'main'),
    'enabled'     => (bool)Env::get('GITHUB_ENABLED', true),
    'api_url'     => (string)Env::get('GITHUB_API_URL', 'https://api.github.com'),
    'api_version' => '2022-11-28',
    'user_agent'  => 'MaaadMR-CMS-SyncEngine/1.0 (PHP ' . PHP_VERSION . ')',
    'timeout'     => 15, // seconds
];
