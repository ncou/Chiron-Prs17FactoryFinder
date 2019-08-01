<?php

declare(strict_types=1);

namespace Http\Factory;

use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

/**
 * Discover the Server Request Creator libraries presents.
 */
final class ServerRequestCreator
{
    /**
     * @var array
     */
    private static $providers = [
        'nyholm/psr7-server' => [
            'condition' => ['Nyholm\Psr7Server\ServerRequestCreator', 'Nyholm\Psr7\Factory\Psr17Factory'],
            'callable' => [self::class, 'wrapFromGlobalsMethod'],
        ],
        'guzzlehttp/psr7' => [
            'condition' => 'GuzzleHttp\Psr7\ServerRequest',
            'callable' => ['GuzzleHttp\Psr7\ServerRequest','fromGlobals'],
        ],
        'slim/psr7' => [
            'condition' => 'Slim\Psr7\Factory\ServerRequestFactory',
            'callable' => ['Slim\Psr7\Factory\ServerRequestFactory','createFromGlobals'],
        ],
        'zendframework/zend-diactoros' => [
            'condition' => 'Zend\Diactoros\ServerRequestFactory',
            'callable' => ['Zend\Diactoros\ServerRequestFactory','fromGlobals'],
        ],
    ];

    /**
     * Internal cache to store the first provider detected.
     *
     * @var array
     */
    private static $provider;

    /**
     * @throws RuntimeException
     *
     * @return ServerRequestInterface
     */
    public static function fromGlobals(): ServerRequestInterface
    {
        $provider = self::detectProvider();

        return call_user_func($provider['callable']);
    }

    /**
     * @throws RuntimeException
     *
     * @return array The provider datas
     */
    private static function detectProvider(): array
    {
        if (isset(self::$provider)) {
            return self::$provider;
        }

        foreach (self::$providers as $provider) {
            if (! self::evaluateCondition($provider['condition'])) {
                continue;
            }

            return self::$provider = $provider;
        }

        throw new RuntimeException(
            'Could not detect any ServerRequest creator implementations.' .
            'Please install one of the following supported package : ' .
            implode(', ', array_keys(self::$providers))
        );
    }

    /**
     * Evaluates conditions to boolean.
     *
     * @param string[]|string $condition
     *
     * @return bool
     */
    private static function evaluateCondition($condition): bool
    {
        if (is_string($condition)) {
            return class_exists($condition);
        }

        if (is_array($condition)) {
            foreach ($condition as $c) {
                if (self::evaluateCondition($c) === false) {
                    // Immediately stop execution if the condition is false
                    return false;
                }
            }
            return true;
        }

        return false;
    }

    /**
     * Proxy used to convert the Nyholm "fromGlobals" method as "static".
     *
     * @throws RuntimeException If no PSR17 factories are found.
     *
     * @return ServerRequestInterface
     */
    private static function wrapFromGlobalsMethod(): ServerRequestInterface
    {
        $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

        $creator = new \Nyholm\Psr7Server\ServerRequestCreator(
            $psr17Factory, // ServerRequestFactory
            $psr17Factory, // UriFactory
            $psr17Factory, // UploadedFileFactory
            $psr17Factory  // StreamFactory
        );

        return $creator->fromGlobals();
    }
}
