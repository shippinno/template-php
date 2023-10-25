<?php
declare(strict_types=1);

namespace Shippinno\Template;

use League\Flysystem\Filesystem;
use Throwable;
use Twig\Environment as Twig_Environment;
use Twig\Loader\ArrayLoader as Twig_Loader_Array;

class Twig extends Template
{
    /**
     * @var Twig_Environment
     */
    private $environment;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct($filesystem);
        $this->environment = new Twig_Environment(new Twig_Loader_Array());
    }

    /**
     * @param string $source
     * @param array $variables
     * @return string
     * @throws RenderFailedException
     */
    public function renderSource(string $source, array $variables): string
    {
        try {
            return $this->environment->createTemplate($source)->render($variables);
        } catch (Throwable $e) {
            throw new RenderFailedException($source, $e);
        }
    }


    /**
     * @param string $templateName
     * @return string
     */
    protected function fileName(string $templateName): string
    {
        return $templateName . '.twig';
    }
}
