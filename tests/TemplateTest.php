<?php

namespace Shippinno\Template;

use League\Flysystem\Filesystem;
use Mockery;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    /**
     * @expectedException \Shippinno\Template\LoadFailedException
     * @expectedExceptionMessage TemplateName.test
     */
    public function test()
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive(['read' => false]);
        $template = new TestTemplate($filesystem);
        $template->render('TemplateName', []);
    }
}

class TestTemplate extends Template
{
    public function renderSource(string $source, array $variables): string {}

    protected function fileName(string $templateName): string
    {
        return $templateName . '.test';
    }
}