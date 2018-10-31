<?php
declare(strict_types=1);

namespace Shippinno\Template;

abstract class Template
{
    /**
     * @var string
     */
    protected $template;

    /**
     * @param string $template
     */
    public function __construct(string $template)
    {
        $this->template = $template;
    }

    /**
     * @param array $variables
     * @return string
     */
    abstract public function render(array $variables): string;
}
