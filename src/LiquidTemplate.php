<?php
declare(strict_types=1);

namespace Shippinno\Template;

use Liquid\Template as Liquid;

class LiquidTemplate extends Template
{
    /**
     * @var Liquid
     */
    private static $liquid;

    /**
     * {@inheritdoc}
     */
    public function render(array $variables): string
    {
        if (is_null(self::$liquid)) {
            self::$liquid = new Liquid;
        }

        return self::$liquid->parse($this->template)->render($variables);
    }
}
