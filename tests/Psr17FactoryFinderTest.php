<?php

declare(strict_types=1);

namespace Http\Factory;

use RuntimeException;

class Psr17FactoryFinderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getFactories
     */
    public function testFind($method, $interface)
    {
        $callable = [Psr17FactoryFinder::class, $method];
        $client = $callable();
        $this->assertInstanceOf($interface, $client);
    }

    /**
     * @group NothingInstalled
     * @dataProvider getFactories
     */
    public function testNotFound($method)
    {
        $callable = [Psr17FactoryFinder::class, $method];
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No PSR-17 implementations found for');
        $callable();
    }

    public function getFactories()
    {
        yield ['findRequestFactory', RequestFactoryInterface::class];
        yield ['findResponseFactory', ResponseFactoryInterface::class];
        yield ['findServerRequestFactory', ServerRequestFactoryInterface::class];
        yield ['findStreamFactory', StreamFactoryInterface::class];
        yield ['findUploadedFileFactory', UploadedFileFactoryInterface::class];
        yield ['findUriFactory', UriFactoryInterface::class];
    }

    /*
    public function testCanFindRequestFactory(): void
    {
        static::assertEquals(Psr17FactoryFinder::findRequestFactory(), Psr17FactoryFinder::findRequestFactory());
    }

    public function testCanFindResponseFactory(): void
    {
        static::assertEquals(Psr17FactoryFinder::findResponseFactory(), Psr17FactoryFinder::findResponseFactory());
    }

    public function testCanFindServerRequestFactory(): void
    {
        static::assertEquals(Psr17FactoryFinder::findServerRequestFactory(), Psr17FactoryFinder::findServerRequestFactory());
    }

    public function testCanFindStreamFactory(): void
    {
        static::assertEquals(Psr17FactoryFinder::findStreamFactory(), Psr17FactoryFinder::findStreamFactory());
    }

    public function testCanFindUploadedFileFactory(): void
    {
        static::assertEquals(Psr17FactoryFinder::findUploadedFileFactory(), Psr17FactoryFinder::findUploadedFileFactory());
    }

    public function testCanFindUriFactory(): void
    {
        static::assertEquals(Psr17FactoryFinder::findUriFactory(), Psr17FactoryFinder::findUriFactory());
    }*/
}
