<?php

declare(strict_types=1);

namespace Http\Factory;

class Psr17FactoryFinderTest extends \PHPUnit\Framework\TestCase
{
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
    }
}
