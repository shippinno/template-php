<?php
declare(strict_types=1);

namespace Shippinno\Template;

use Exception;
use Throwable;

class TemplateNotFoundException extends TemplateException
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     * @param Throwable|null $previous
     */
    public function __construct(string $path, Throwable $previous = null)
    {
        $this->path = $path;
        parent::__construct(sprintf('Template file not found: %s', $this->path()), 0, $previous);
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }
}
