<?php
declare(strict_types=1);

namespace Shippinno\Template;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\PathPrefixer;
use Liquid\Exception\ParseException;
use Liquid\Exception\RenderException;
use Liquid\Template as LiquidTemplate;

class Liquid extends Template
{
    /**
     * @var LiquidTemplate
     */
    private $liquid;

    /**
     * @param Filesystem|null $filesystem
     * @throws \Exception
     */
    public function __construct(Filesystem $filesystem = null)
    {
        parent::__construct($filesystem);
        $path = null;
        if (null !== $filesystem) {
            $adapter = $this->getAdapter($filesystem);
            if ($adapter instanceof LocalFilesystemAdapter) {
                $path = $this->getPath($adapter);
            }
        }
        $this->liquid = new LiquidTemplate($path);
    }

    /**
     * {@inheritdoc}
     */
    public function renderSource(string $source, array $variables): string
    {
        try {
            return $this->liquid->parse($source)->render($variables);
        } catch (ParseException|RenderException $e) {
            throw new RenderFailedException($source, $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function fileName(string $templateName): string
    {
        return $templateName . '.liquid';
    }

    /**
     * @param Filesystem|null $filesystem
     * @return FilesystemAdapter|null
     * @throws \Exception
     */
    private function getAdapter(Filesystem $filesystem = null): ?FilesystemAdapter
    {
        try {
            $reflection = new \ReflectionClass(\get_class($filesystem));
            $property = $reflection->getProperty('adapter');
            $property->setAccessible(true);

            return $property->getValue($filesystem);
        } catch (\ReflectionException $e) {
            throw new \Exception('Failed to get adapter from Filesystem', 0, $e);
        }
    }

    /**
     * @param FilesystemAdapter $adapter
     * @return string
     * @throws \Exception
     */
    private function getPath(FilesystemAdapter $adapter): string
    {
        try {
            $reflection = new \ReflectionClass(\get_class($adapter));
            $property = $reflection->getProperty('prefixer');
            $property->setAccessible(true);
            /** @var PathPrefixer $prefixer */
            $prefixer = $property->getValue($adapter);

            return $prefixer->prefixPath('/');

        } catch (\ReflectionException $e) {
            throw new \Exception('Failed to get path from FilesystemAdapter', 0, $e);
        }
    }
}
