<?php declare(strict_types=1);


namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CustomLinkExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('formatLinks', [$this, 'formatLinks']),
        ];
    }

    public function formatLinks($text)
    {
        return preg_replace_callback("/\[to=(.{1,4})\]/", "self::parseLink", $text);
    }

    private static function parseLink($matches) {
        if(mb_strtoupper($matches[1]) === 'BTG') {
            return "<a href='/'>BTG</a>";
        }
        if (is_numeric($matches[1])) {
            return "<a href='/item/".$matches[1]."'>$matches[1]</a>";
        }

        return $matches[0];
    }
}