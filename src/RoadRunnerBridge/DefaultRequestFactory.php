<?php

declare(strict_types=1);

namespace Baldinof\RoadRunnerBundle\RoadRunnerBridge;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

final class DefaultRequestFactory implements HttpFoundationRequestFactoryInterface {
    public function buildRequest(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        return new SymfonyRequest($query, $request, $attributes, $cookies, $files, $server, $content);
    }
}