<?php

namespace Shippinno\Template;

use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use PHPUnit\Framework\TestCase;

class LiquidTest extends TestCase
{
    public function testRender()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        $filesystem->write('SomeTemplate.liquid', 'A template for {{ name }}.');
        $liquid = new Liquid($filesystem);
        $output = $liquid->render('SomeTemplate', ['name' => "Shippinno"]);
        $this->assertSame('A template for Shippinno.', $output);
    }

    /**
     * @expectedException \Shippinno\Template\TemplateNotFoundException
     * @expectedExceptionMessage ThisDoesNotExist.liquid
     */
    public function testRenderFailsIfFileDoesNotExist()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        $liquid = new Liquid($filesystem);
        $liquid->render('ThisDoesNotExist', ['name' => "Shippinno"]);
    }

    public function testRenderSource()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        $liquid = new Liquid($filesystem);
        $output = $liquid->renderSource('Hello {{ name }} !!', ['name' => "Shippinno"]);
        $this->assertSame('Hello Shippinno !!', $output);
    }

    /**
     * @expectedException \Shippinno\Template\RenderFailedException
     * @expectedExceptionMessage {% capture %}
     */
    public function testRenderSourceFailsIfSourceIsMalformed()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        $liquid = new Liquid($filesystem);
        $liquid->renderSource('{% capture %}', ['name' => "Shippinno"]);
    }
}
