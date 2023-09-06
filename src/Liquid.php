<?php
declare(strict_types=1);

namespace Shippinno\Template;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
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
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem = null)
    {
        parent::__construct($filesystem);
        if (!is_null($filesystem) && $filesystem->getAdapter() instanceof LocalFilesystemAdapter) {
            $path = $filesystem->getAdapter()->getPathPrefix();
        } else {
            $path = null;
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
}
