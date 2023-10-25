<?php

namespace Shippinno\Template;

use League\Flysystem\Filesystem;
use League\Flysystem\UnableToReadFile;
use Mockery;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    /** @test */
    public function test()
    {
        $this->expectException(\Shippinno\Template\TemplateNotFoundException::class);
        $this->expectExceptionMessage("TemplateName.test");
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem
            ->shouldReceive('read')
            ->andThrow(UnableToReadFile::fromLocation("TemplateName.test", ''));
        $template = new TestTemplate($filesystem);
        $template->render('TemplateName', []);
    }
}

class TestTemplate extends Template
{
    public function renderSource(string $source, array $variables): string
    {
        return '';
    }

    protected function fileName(string $templateName): string
    {
        return $templateName . '.test';
    }
}
