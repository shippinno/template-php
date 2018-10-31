<?php
declare(strict_types=1);

namespace Shippinno\Template;

class LiquidTemplateLoader extends TemplateLoader
{
    /**
     * {@inheritdoc}
     */
    protected function fileName(string $templateName): string
    {
        return $templateName . '.liquid';
    }

    /**
     * {@inheritdoc}
     */
    protected function template(string $template): Template
    {
        return new LiquidTemplate($template);
    }
}
