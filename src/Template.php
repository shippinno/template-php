<?php
declare(strict_types=1);

namespace Shippinno\Template;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\InMemory\InMemoryFilesystemAdapter;
use League\Flysystem\UnableToReadFile;

abstract class Template
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param Filesystem|null $filesystem
     */
    public function __construct(Filesystem $filesystem = null)
    {
        $this->filesystem = is_null($filesystem) ? new Filesystem(new InMemoryFilesystemAdapter) : $filesystem;
    }

    /**
     * @param string $templateName
     * @param array $variables
     * @return string
     * @throws FilesystemException
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
     * @throws TemplateNotFoundException
     * @throws FilesystemException
     */
    protected function readFile(string $templateName): string
    {
        $fileName = $this->fileName($templateName);
        try {
            $content = $this->filesystem->read($fileName);
        } catch (UnableToReadFile $e) {
            throw new TemplateNotFoundException($e->location());
        }

        return $content;
    }

    /**
     * @param string $templateName
     * @return string
     */
    abstract protected function fileName(string $templateName): string;
}
