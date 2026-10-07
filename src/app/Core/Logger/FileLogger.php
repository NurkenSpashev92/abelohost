<?php

declare(strict_types=1);

namespace App\Core\Logger;

use App\Contracts\LoggerInterface;
use RuntimeException;
use Stringable;

final readonly class FileLogger implements LoggerInterface
{
    public function __construct(private string $file)
    {
        $dir = dirname($file);

        if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
            throw new RuntimeException(sprintf('Не удалось создать папку для логов: %s', $dir));
        }
    }

    public function error(string|Stringable $message, array $context = []): void
    {
        $this->log('error', $message, $context);
    }

    private function log(string $level, string|Stringable $message, array $context = []): void
    {
        $line = sprintf('[%s] %s: %s', date('Y-m-d H:i:s'), strtoupper($level), $message);

        if ($context !== []) {
            $line .= ' ' . json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        file_put_contents($this->file, $line . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}
