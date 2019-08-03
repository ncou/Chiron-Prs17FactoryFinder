<?php

declare(strict_types=1);

namespace Http\Factory;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use RuntimeException;

/**
 * Finds PSR-17 factories.
 */
final class Psr17FactoryFinder
{
    /**
     * @var array
     */
    private static $candidates = [
        RequestFactoryInterface::class => [
            'Nyholm\Psr7\Factory\Psr17Factory',
            'GuzzleHttp\Psr7\HttpFactory',
            'Zend\Diactoros\RequestFactory',
            'Slim\Psr7\Factory\RequestFactory',
        ],
        ResponseFactoryInterface::class => [
            'Nyholm\Psr7\Factory\Psr17Factory',
            'GuzzleHttp\Psr7\HttpFactory',
            'Zend\Diactoros\ResponseFactory',
            'Slim\Psr7\Factory\ResponseFactory',
        ],
        ServerRequestFactoryInterface::class => [
            'Nyholm\Psr7\Factory\Psr17Factory',
            'GuzzleHttp\Psr7\HttpFactory',
            'Zend\Diactoros\ServerRequestFactory',
            'Slim\Psr7\Factory\ServerRequestFactory',
        ],
        StreamFactoryInterface::class => [
            'Nyholm\Psr7\Factory\Psr17Factory',
            'GuzzleHttp\Psr7\HttpFactory',
            'Zend\Diactoros\StreamFactory',
            'Slim\Psr7\Factory\StreamFactory',
        ],
        UploadedFileFactoryInterface::class => [
            'Nyholm\Psr7\Factory\Psr17Factory',
            'GuzzleHttp\Psr7\HttpFactory',
            'Zend\Diactoros\UploadedFileFactory',
            'Slim\Psr7\Factory\UploadedFileFactory',
        ],
        UriFactoryInterface::class => [
            'Nyholm\Psr7\Factory\Psr17Factory',
            'GuzzleHttp\Psr7\HttpFactory',
            'Zend\Diactoros\UriFactory',
            'Slim\Psr7\Factory\UriFactory',
        ],
    ];

    /**
     * Internal cache to store the instance of each factory called the first time.
     *
     * @var array
     */
    private static $cache = [];

    /**
     * @throws \RuntimeException
     *
     * @return \Psr\Http\Message\RequestFactoryInterface
     */
    public static function findRequestFactory(): RequestFactoryInterface
    {
        $requestFactory = self::makeInstance(RequestFactoryInterface::class);

        return $requestFactory;
    }

    /**
     * @throws \RuntimeException
     *
     * @return \Psr\Http\Message\ResponseFactoryInterface
     */
    public static function findResponseFactory(): ResponseFactoryInterface
    {
        $responseFactory = self::makeInstance(ResponseFactoryInterface::class);

        return $responseFactory;
    }

    /**
     * @throws \RuntimeException
     *
     * @return \Psr\Http\Message\ServerRequestFactoryInterface
     */
    public static function findServerRequestFactory(): ServerRequestFactoryInterface
    {
        $serverRequestFactory = self::makeInstance(ServerRequestFactoryInterface::class);

        return $serverRequestFactory;
    }

    /**
     * @throws \RuntimeException
     *
     * @return \Psr\Http\Message\StreamFactoryInterface
     */
    public static function findStreamFactory(): StreamFactoryInterface
    {
        $streamFactory = self::makeInstance(StreamFactoryInterface::class);

        return $streamFactory;
    }

    /**
     * @throws \RuntimeException
     *
     * @return \Psr\Http\Message\UploadedFileFactoryInterface
     */
    public static function findUploadedFileFactory(): UploadedFileFactoryInterface
    {
        $uploadedFileFactory = self::makeInstance(UploadedFileFactoryInterface::class);

        return $uploadedFileFactory;
    }

    /**
     * @throws \RuntimeException
     *
     * @return \Psr\Http\Message\UriFactoryInterface
     */
    public static function findUriFactory(): UriFactoryInterface
    {
        $uriFactory = self::makeInstance(UriFactoryInterface::class);

        return $uriFactory;
    }

    /**
     * Finds a class implementing the given PSR-17 interface and instanciate it.
     *
     * @param string $interface
     *
     * @throws \RuntimeException
     *
     * @return mixed
     */
    private static function makeInstance(string $interface)
    {
        // Look in the cache first.
        if (! empty(self::$cache[$interface])) {
            return self::$cache[$interface];
        }

        foreach (self::$candidates[$interface] as $candidate) {
            if (! class_exists($candidate)) {
                continue;
            }

            return self::$cache[$interface] = new $candidate();
        }

        throw new RuntimeException("No PSR-17 implementations found for $interface");
    }
}
