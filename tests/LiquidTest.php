<?php

namespace Shippinno\Template;

use League\Flysystem\Filesystem;
use League\Flysystem\InMemory\InMemoryFilesystemAdapter;
use PHPUnit\Framework\TestCase;

class LiquidTest extends TestCase
{
    /** @test  */
    public function testRender()
    {
        $filesystem = new Filesystem(new InMemoryFilesystemAdapter);
        $filesystem->write('SomeTemplate.liquid', 'A template for {{ name }}.');
        $liquid = new Liquid($filesystem);
        $output = $liquid->render('SomeTemplate', ['name' => "Shippinno"]);
        $this->assertSame('A template for Shippinno.', $output);
    }

    /** @test  */
    public function testRenderFailsIfFileDoesNotExist()
    {
        $this->expectException(\Shippinno\Template\TemplateNotFoundException::class);
        $this->expectExceptionMessage("ThisDoesNotExist.liquid");
        $filesystem = new Filesystem(new InMemoryFilesystemAdapter);
        $liquid = new Liquid($filesystem);
        $liquid->render('ThisDoesNotExist', ['name' => "Shippinno"]);
    }

    /** @test  */
    public function testRenderSource()
    {
        $filesystem = new Filesystem(new InMemoryFilesystemAdapter);
        $liquid = new Liquid($filesystem);
        $output = $liquid->renderSource('Hello {{ name }} !!', ['name' => "Shippinno"]);
        $this->assertSame('Hello Shippinno !!', $output);
    }

    /** @test  */
    public function testRenderSourceFailsIfSourceIsMalformed()
    {
        $this->expectException(\Shippinno\Template\RenderFailedException::class);
        $this->expectExceptionMessage("{% capture %}");
        $filesystem = new Filesystem(new InMemoryFilesystemAdapter);
        $liquid = new Liquid($filesystem);
        $liquid->renderSource('{% capture %}', ['name' => "Shippinno"]);
    }
}
