<?php

namespace Shippinno\Template;

use League\Flysystem\Filesystem;
use League\Flysystem\InMemory\InMemoryFilesystemAdapter;
use PHPUnit\Framework\TestCase;

class TwigTest extends TestCase
{
    public function testRender()
    {
        $filesystem = new Filesystem(new InMemoryFilesystemAdapter);
        $filesystem->write('SomeTemplate.twig', 'A template for {{ name }}.');
        $twig = new Twig($filesystem);
        $output = $twig->render('SomeTemplate', ['name' => "Shippinno"]);
        $this->assertSame('A template for Shippinno.', $output);
    }

    /** @test  */
    public function testRenderFailsIfFileDoesNotExist()
    {
        $this->expectException(\Shippinno\Template\TemplateNotFoundException::class);
        $this->expectExceptionMessage("ThisDoesNotExist.twig");
        $filesystem = new Filesystem(new InMemoryFilesystemAdapter);
        $twig = new Twig($filesystem);
        $twig->render('ThisDoesNotExist', ['name' => "Shippinno"]);
    }

    public function testRenderSource()
    {
        $filesystem = new Filesystem(new InMemoryFilesystemAdapter);
        $twig = new Twig($filesystem);
        $output = $twig->renderSource('Hello {{ name }} !!', ['name' => "Shippinno"]);
        $this->assertSame('Hello Shippinno !!', $output);
    }

    /** @test  */
    public function testRenderSourceFailsIfSourceIsMalformed()
    {
        $this->expectException(\Shippinno\Template\RenderFailedException::class);
        $this->expectExceptionMessage("Hello {% if");
        $filesystem = new Filesystem(new InMemoryFilesystemAdapter);
        $twig = new Twig($filesystem);
        $twig->renderSource('Hello {% if', ['name' => "Shippinno"]);
    }
}
