<?php
declare(strict_types=1);

namespace Shippinno\Template;

use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;

abstract class Template
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param string $templateName
     * @param array $variables
     * @return string
     * @throws LoadFailedException
     * @throws RenderFailedException
     * @throws TemplateNotFoundException
     */
    public function render(string $templateName, array $variables)
    {
        return $this->renderSource($this->readFile($templateName), $variables);
    }

    /**
     * @param string $source
     * @param array $variables
     * @return string
     * @throws RenderFailedException
     */
    abstract public function renderSource(string $source, array $variables): string;

    /**
     * @param string $templateName
     * @return string
     * @throws LoadFailedException
     * @throws TemplateNotFoundException
     */
    protected function readFile(string $templateName): string
    {
        $fileName = $this->fileName($templateName);
        try {
            $content = $this->filesystem->read($fileName);
        } catch (FileNotFoundException $e) {
            throw new TemplateNotFoundException($e->getPath());
        }
        if ($content === false) {
            throw new LoadFailedException($fileName);
        }

        return $content;
    }

    /**
     * @param string $templateName
     * @return string
     */
    abstract protected function fileName(string $templateName): string;
}
