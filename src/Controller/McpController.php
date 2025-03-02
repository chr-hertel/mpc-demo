<?php

declare(strict_types=1);

namespace App\Controller;

use App\Mcp\Server;
use App\Mcp\Server\Transport\Sse\StreamTransport;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsController]
#[Route('/mcp', name: 'mcp_')]
final class McpController
{
    public function __construct(
        private readonly Server $server,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly LoggerInterface $logger,
    ) {
    }

    #[Route('/sse', name: 'sse', methods: ['GET'])]
    public function sse(): StreamedResponse
    {
        $transport = new StreamTransport(
            // TODO: Attach session ID to the URL?
            $this->urlGenerator->generate('mcp_messages', [], UrlGeneratorInterface::ABSOLUTE_URL),
        );

        return new StreamedResponse(fn() => $this->server->connect($transport), headers: [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    #[Route('/messages', name: 'messages', methods: ['POST'])]
    public function messages(Request $request): Response
    {
        $this->logger->info('INCOMING MESSAGE', [
            'content' => $request->getContent(),
        ]);

        // TODO: Push messages to session specific a stack

        return new Response();
    }
}
