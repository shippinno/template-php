<?php

namespace Shippinno\Template;

use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use PHPUnit\Framework\TestCase;

class LiquidTemplateLoaderTest extends TestCase
{
    public function testItLoadsTemplateOfName()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        $filesystem->write('SomeTemplate.liquid', 'A template for {{ name }}.');
        $templateLoader = new LiquidTemplateLoader($filesystem);
        $template = $templateLoader->load('SomeTemplate');
        $this->assertSame(
            'A template for Shippinno.',
            $template->render(['name' => 'Shippinno'])
        );
    }

    /**
     * @expectedException \Shippinno\Template\TemplateNotFoundException
     * @expectedExceptionMessage ThisDoesNotExist.liquid
     */
    public function testItThrowsExceptionIfTemplateOfNameDoesNotExist()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        $templateLoader = new LiquidTemplateLoader($filesystem);
        $templateLoader->load('ThisDoesNotExist');
    }
}
