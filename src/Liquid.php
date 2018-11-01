<?php
declare(strict_types=1);

namespace Shippinno\Template;

use League\Flysystem\Filesystem;
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
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct($filesystem);
        $this->liquid = new LiquidTemplate;
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
