<?php

namespace App\Ui;

use Codingwithrk\NativephpUi\Compiler\Tag;
use Codingwithrk\NativephpUi\Components\Component;

/**
 * A section heading with an optional description and a trailing link.
 *
 * <ui:section-header title="New in 1.1.0" description="26 components" action="See all" @navigate='/components' />
 *
 * `@navigate` / `@press` go to the trailing link, so the heading itself
 * isn't tappable.
 */
class SectionHeader extends Component
{
    public function render(Tag $tag): string
    {
        $out = '<native:row '.$tag->cls().'>';
        $out .= '<native:column '.$tag->cls('content').'>';
        $out .= '<native:text '.$tag->cls('title').' '.Tag::bind('text', $tag->expr('title', "''")).' />';

        if ($tag->has('description')) {
            $out .= '<native:text '.$tag->cls('description').' '.Tag::bind('text', $tag->expr('description')).' />';
        }

        $out .= '</native:column>';

        if ($tag->has('action')) {
            $out .= '<native:row '.$tag->cls('action').$tag->forward('title', 'description', 'action').'>'
                .'<native:text '.$tag->cls('action-text').' '.Tag::bind('text', $tag->expr('action')).' />'
                .'<native:icon name="chevron_right" ios="chevron.right" :size="12" '.$tag->cls('action-text').' />'
                .'</native:row>';
        }

        return $out.$tag->content().'</native:row>';
    }

    public function classes(string $tag, string $part, array $props): string
    {
        return match ($part) {
            'content' => 'flex-1 gap-1',
            'title' => 'text-xl font-semibold text-theme-ui-foreground',
            'description' => 'text-sm text-theme-ui-muted-foreground',
            'action' => 'items-center gap-1 py-1',
            'action-text' => 'text-sm font-medium text-theme-ui-primary',
            default => 'w-full items-end gap-3',
        };
    }
}
