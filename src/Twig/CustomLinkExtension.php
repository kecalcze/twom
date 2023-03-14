<?php declare(strict_types=1);


namespace App\Twig;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CustomLinkExtension extends AbstractExtension
{
    private TranslatorInterface $translator;
    public function __construct(TranslatorInterface $translator) {
        $this->translator = $translator;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('formatLinks', [$this, 'formatLinks']),
        ];
    }

    public function formatLinks($text)
    {
        return preg_replace_callback("/\[to=(.{1,4})\]/", ['App\Twig\CustomLinkExtension', 'parseLink'], $text);
    }

    private function parseLink($matches): string
    {
        if(mb_strtoupper($matches[1]) === 'BTG') {
            return "<a href='/'>" . $this->translator->trans('btg') . "</a>";
        }
        if (is_numeric($matches[1])) {
            return "<a href='/item/".$matches[1]."'>$matches[1]</a>";
        }

        return $matches[0];
    }
}