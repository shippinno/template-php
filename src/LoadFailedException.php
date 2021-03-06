<?php
declare(strict_types=1);

namespace Shippinno\Template;

class LoadFailedException extends TemplateException
{
    /**
     * @var string
     */
    private $fileName;

    /**
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        parent::__construct(sprintf('Failed to load file: %s', $this->fileName()));
    }

    /**
     * @return string
     */
    public function fileName(): string
    {
        return $this->fileName;
    }
}
