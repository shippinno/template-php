<?php
declare(strict_types=1);

namespace Shippinno\Template;

use Throwable;

class RenderFailedException extends TemplateException
{
    /**
     * @var string
     */
    private $source;

    /**
     * @param string $source
     * @param Throwable|null $previous
     */
    public function __construct(string $source, Throwable $previous = null)
    {
        $this->source = $source;
        parent::__construct(sprintf('Failed to render source: %s', $this->source()), 0, $previous);
    }

    /**
     * @return string
     */
    public function source(): string
    {
        return $this->source;
    }
}
