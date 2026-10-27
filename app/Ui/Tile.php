<?php

namespace App\Ui;

use Codingwithrk\NativephpUi\Compiler\Tag;
use Codingwithrk\NativephpUi\Components\Component;

/**
 * A square-ish card for a grid or carousel: icon tile, title, subtitle and
 * an optional badge in the corner.
 *
 * <ui:tile :icon="$group->icon" :color="$group->color" :title="$group->label"
 *          :subtitle="$count.' components'" badge="New" @navigate="$group->url()" />
 */
class Tile extends Component
{
    /**
     * @return array{color: string}
     */
    public function props(): array
    {
        return ['color' => 'ui-primary'];
    }

    public function render(Tag $tag): string
    {
        $out = '<native:column '.$tag->cls().$tag->forward('icon', 'title', 'subtitle', 'badge').'>';
        $out .= '<native:row '.$tag->cls('top').'>';
        $out .= IconTile::markup($tag->expr('icon'), $tag->expr('color', "'ui-primary'"), 'md');

        if ($tag->has('badge')) {
            $badge = $tag->expr('badge');
            $out .= "@if(filled({$badge}))<native:row ".$tag->cls('badge').'><native:text '.$tag->cls('badge-text').' '.Tag::bind('text', $badge).' /></native:row>@endif';
        }

        $out .= '</native:row>';
        $out .= '<native:column '.$tag->cls('content').'>';
        $out .= '<native:text '.$tag->cls('title').' '.Tag::bind('text', $tag->expr('title', "''")).' />';

        if ($tag->has('subtitle')) {
            $out .= '<native:text '.$tag->cls('subtitle').' '.Tag::bind('text', $tag->expr('subtitle')).' :max-lines="2" />';
        }

        return $out.'</native:column>'.$tag->content().'</native:column>';
    }

    /**
     * @param  array{color: string}  $props
     */
    public function classes(string $tag, string $part, array $props): string
    {
        return match ($part) {
            'top' => 'w-full items-start justify-between',
            'content' => 'w-full gap-[2]',
            'title' => 'text-base font-semibold text-theme-ui-card-foreground',
            'subtitle' => 'text-sm text-theme-ui-muted-foreground',
            'badge' => 'px-2 py-[2] bg-theme-ui-primary/15 '.$this->rounded('full'),
            'badge-text' => 'text-xs font-semibold text-theme-ui-primary',
            default => 'gap-4 p-4 border border-theme-ui-border bg-theme-ui-card '.$this->rounded('xl'),
        };
    }
}
