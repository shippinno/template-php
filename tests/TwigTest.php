<?php

namespace Shippinno\Template;

use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use PHPUnit\Framework\TestCase;

class TwigTest extends TestCase
{
    public function testRender()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        $filesystem->write('SomeTemplate.twig', 'A template for {{ name }}.');
        $twig = new Twig($filesystem);
        $output = $twig->render('SomeTemplate', ['name' => "Shippinno"]);
        $this->assertSame('A template for Shippinno.', $output);
    }

    /**
     * @expectedException \Shippinno\Template\TemplateNotFoundException
     * @expectedExceptionMessage ThisDoesNotExist.twig
     */
    public function testRenderFailsIfFileDoesNotExist()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        $twig = new Twig($filesystem);
        $twig->render('ThisDoesNotExist', ['name' => "Shippinno"]);
    }

    public function testRenderSource()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        $twig = new Twig($filesystem);
        $output = $twig->renderSource('Hello {{ name }} !!', ['name' => "Shippinno"]);
        $this->assertSame('Hello Shippinno !!', $output);
    }

    /**
     * @expectedException \Shippinno\Template\RenderFailedException
     * @expectedExceptionMessage Hello {% if
     */
    public function testRenderSourceFailsIfSourceIsMalformed()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        $twig = new Twig($filesystem);
        $twig->renderSource('Hello {% if', ['name' => "Shippinno"]);
    }
}
