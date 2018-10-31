<?php
declare(strict_types=1);

namespace Shippinno\Template;

use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;

abstract class TemplateLoader
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param string $templateName
     * @return Template
     * @throws TemplateNotFoundException
     */
    public function load(string $templateName): Template
    {
        try {
            $template = $this->filesystem->read($this->fileName($templateName));
        } catch (FileNotFoundException $e) {
            throw new TemplateNotFoundException($e->getPath());
        }

        return $this->template($template);
    }

    /**
     * @param string $templateName
     * @return string
     */
    abstract protected function fileName(string $templateName): string;

    /**
     * @param string $template
     * @return Template
     */
    abstract protected function template(string $template): Template;
}
