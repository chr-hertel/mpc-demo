<?php

declare(strict_types=1);

namespace App\Mcp\Server\Transport\Sse;

use App\Mcp\Server\Transport\SseTransport;

final class StreamTransport implements SseTransport
{
    private bool $initialized = false;

    public function __construct(
        private readonly string $messageEndpoint,
    ) {
    }

    public function initialize(): void
    {
        ignore_user_abort(true);
        $this->flushEvent('endpoint', $this->messageEndpoint);
    }

    public function isConnected(): bool
    {
        return 0 === connection_aborted();
    }

    public function receive(): \Generator
    {
        if (false === $this->initialized) {
            $this->initialized = true;
            yield '{"jsonrpc":"2.0","id":0,"method":"initialize"}';
        }

        // TODO: Pop session specific messages from a stack
    }

    public function send(string $data): void
    {
        $this->flushEvent('message', $data);
    }

    public function close(): void
    {
    }

    private function flushEvent(string $event, string $data): void
    {
        echo sprintf('event: %s', $event).PHP_EOL;
        echo sprintf('data: %s', $data).PHP_EOL;
        echo PHP_EOL;
        ob_flush();
        flush();
    }
}
