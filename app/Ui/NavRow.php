<?php

namespace App\Ui;

use Codingwithrk\NativephpUi\Compiler\Tag;
use Codingwithrk\NativephpUi\Components\Component;

/**
 * A tappable catalog row: icon tile, title, one-line description, an
 * optional badge and a chevron. Group rows inside `<ui:nav-list>`.
 *
 * <ui:nav-list>
 *     <ui:nav-row :icon="$c->icon" :color="$group->color" :title="$c->name"
 *                 :description="$c->description" :badge="$isNew ? 'New' : null" @navigate="$c->url()" />
 * </ui:nav-list>
 */
class NavRow extends Component
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
        if ($tag->name() === 'nav-list') {
            return '<native:column '.$tag->cls().$tag->forward().'>'.$tag->content().'</native:column>';
        }

        $out = '<native:row '.$tag->cls().$tag->forward('icon', 'title', 'description', 'badge').'>';

        if ($tag->has('icon')) {
            $out .= IconTile::markup($tag->expr('icon'), $tag->expr('color', "'ui-primary'"), 'md');
        }

        $out .= '<native:column '.$tag->cls('content').'>';
        $out .= '<native:text '.$tag->cls('title').' '.Tag::bind('text', $tag->expr('title', "''")).' />';

        if ($tag->has('description')) {
            $description = $tag->expr('description');
            $out .= "@if(filled({$description}))<native:text ".$tag->cls('description').' '.Tag::bind('text', $description).' :max-lines="2" />@endif';
        }

        $out .= '</native:column>';

        if ($tag->has('badge')) {
            $badge = $tag->expr('badge');
            $out .= "@if(filled({$badge}))<native:row ".$tag->cls('badge').'><native:text '.$tag->cls('badge-text').' '.Tag::bind('text', $badge).' /></native:row>@endif';
        }

        $out .= $tag->content();
        $out .= '<native:icon name="chevron_right" ios="chevron.right" :size="14" '.$tag->cls('chevron').' />';

        return $out.'</native:row>';
    }

    /**
     * @param  array{color: string}  $props
     */
    public function classes(string $tag, string $part, array $props): string
    {
        if ($tag === 'nav-list') {
            return 'w-full border border-theme-ui-border bg-theme-ui-card '.$this->rounded('xl');
        }

        return match ($part) {
            'content' => 'flex-1 gap-[2]',
            'title' => 'text-base font-medium text-theme-ui-card-foreground',
            'description' => 'text-sm text-theme-ui-muted-foreground',
            'badge' => 'px-2 py-[2] bg-theme-ui-primary/15 '.$this->rounded('full'),
            'badge-text' => 'text-xs font-semibold text-theme-ui-primary',
            'chevron' => 'text-theme-ui-muted-foreground',
            default => 'w-full items-center gap-3 px-4 py-3',
        };
    }
}
