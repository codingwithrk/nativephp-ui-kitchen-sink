<?php

namespace App\Ui;

use Codingwithrk\NativephpUi\Compiler\Tag;
use Codingwithrk\NativephpUi\Components\Component;

/**
 * A selectable chip, like the theme playground's on the docs site: a
 * label with an optional color swatch, outlined while active.
 *
 * <ui:chip :active="$accent === 'blue'" swatch="#155DFC" @press="setAccent('blue')">blue</ui:chip>
 *
 * `swatch` is a hex color. Swatch colors are data, so they come from PHP
 * (ThemeSettings), never from a view.
 */
class Chip extends Component
{
    /**
     * @return array{active: bool}
     */
    public function props(): array
    {
        return ['active' => false];
    }

    public function render(Tag $tag): string
    {
        $active = $tag->has('active') ? $tag->expr('active', 'false') : 'false';
        $press = $tag->event('press', 'tap');

        $out = '<native:row '.$tag->cls().self::press($press).$tag->forward('swatch').'>';

        if ($tag->has('swatch')) {
            $swatch = $tag->expr('swatch');
            $out .= '<native:column '.Tag::bind('class', "'w-4 h-4 items-center justify-center rounded-full bg-['.{$swatch}.']'").'>'
                ."@if({$active})<native:icon name=\"check\" ios=\"checkmark\" :size=\"10\" class=\"text-white\" />@endif"
                .'</native:column>';
        }

        $out .= $tag->text('label');

        return $out.'</native:row>';
    }

    /**
     * @param  array{active: bool}  $props
     */
    public function classes(string $tag, string $part, array $props): string
    {
        $active = self::truthy($props['active']);

        return match ($part) {
            'label' => 'text-sm '.($active ? 'font-medium text-theme-ui-foreground' : 'text-theme-ui-muted-foreground'),
            default => implode(' ', [
                'h-9 items-center gap-2 px-3 border',
                $active ? 'border-theme-ui-foreground/60 bg-theme-ui-muted' : 'border-theme-ui-border bg-theme-ui-card',
                $this->rounded('lg'),
            ]),
        };
    }
}
