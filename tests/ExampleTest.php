<?php

declare(strict_types=1);

namespace Http\Factory;

class ExampleTest extends \PHPUnit\Framework\TestCase
{
    public function testCanFindRequestFactory(): void
    {
        $this->assertSame(Psr17FactoryFinder::findRequestFactory(), Psr17FactoryFinder::findRequestFactory());
    }
    public function testCanFindResponseFactory(): void
    {
        $this->assertSame(Psr17FactoryFinder::findResponseFactory(), Psr17FactoryFinder::findResponseFactory());
    }
    public function testCanFindServerRequestFactory(): void
    {
        $this->assertSame(Psr17FactoryFinder::findServerRequestFactory(), Psr17FactoryFinder::findServerRequestFactory());
    }
    public function testCanFindStreamFactory(): void
    {
        $this->assertSame(Psr17FactoryFinder::findStreamFactory(), Psr17FactoryFinder::findStreamFactory());
    }
    public function testCanFindUploadedFileFactory(): void
    {
        $this->assertSame(Psr17FactoryFinder::findUploadedFileFactory(), Psr17FactoryFinder::findUploadedFileFactory());
    }
    public function testCanFindUriFactory(): void
    {
        $this->assertSame(Psr17FactoryFinder::findUriFactory(), Psr17FactoryFinder::findUriFactory());
    }
}
