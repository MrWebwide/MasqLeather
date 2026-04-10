<?php
/**
 * env.php — Lightweight .env file loader for MASQ Leather.
 *
 * Parses the .env file and loads values into $_ENV and putenv().
 * No Composer dependency needed.
 *
 * Usage:
 *   require_once __DIR__ . '/env.php';
 *   $value = env('DB_HOST', 'localhost');
 */

(function () {
    $envFile = __DIR__ . '/.env';

    if (!file_exists($envFile)) {
        return; // Silently skip if .env doesn't exist (e.g. production with real env vars)
    }

    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Skip comments
        $line = trim($line);
        if ($line === '' || $line[0] === '#') {
            continue;
        }

        // Parse KEY=VALUE
        if (strpos($line, '=') === false) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $key   = trim($key);
        $value = trim($value);

        // Don't overwrite existing environment variables
        if (getenv($key) !== false) {
            continue;
        }

        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
})();

/**
 * Retrieve an environment variable with an optional default.
 */
function env(string $key, $default = null)
{
    $value = getenv($key);
    if ($value !== false) {
        return $value;
    }
    return $_ENV[$key] ?? $default;
}
