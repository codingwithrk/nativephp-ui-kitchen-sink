<?php

namespace App\Ui;

use Codingwithrk\NativephpUi\Compiler\Tag;
use Codingwithrk\NativephpUi\Components\Component;

/**
 * A gallery card like the docs home page's: a live preview on top and a
 * tappable name row below.
 *
 * <ui:gallery-tile title="Switch" :badge="$badge" @navigate='/components/switch'>
 *     <ui:switch native:model="wifi">Wi-Fi</ui:switch>
 * </ui:gallery-tile>
 *
 * `@navigate` / `@press` go to the name row, so the preview stays
 * interactive.
 */
class GalleryTile extends Component
{
    public function render(Tag $tag): string
    {
        $out = '<native:column '.$tag->cls().'>';
        $out .= '<native:column '.$tag->cls('preview').'>'.$tag->content().'</native:column>';
        $out .= '<native:row '.$tag->cls('footer').$tag->forward('title', 'badge').'>';
        $out .= '<native:text '.$tag->cls('title').' '.Tag::bind('text', $tag->expr('title', "''")).' />';

        if ($tag->has('badge')) {
            $badge = $tag->expr('badge');
            $out .= "@if(filled({$badge}))<native:row ".$tag->cls('badge').'><native:text '.$tag->cls('badge-text').' '.Tag::bind('text', $badge).' /></native:row>@endif';
        }

        $out .= '<native:spacer />';
        $out .= '<native:icon name="arrow_forward" ios="arrow.right" :size="14" '.$tag->cls('arrow').' />';

        return $out.'</native:row></native:column>';
    }

    public function classes(string $tag, string $part, array $props): string
    {
        return match ($part) {
            'preview' => 'w-full min-h-[150] items-center justify-center gap-3 px-6 py-8 bg-theme-ui-muted/40',
            'footer' => 'w-full items-center gap-2 px-4 py-3 border-t border-theme-ui-border',
            'title' => 'text-sm font-medium text-theme-ui-card-foreground',
            'badge' => 'px-2 py-[2] bg-theme-ui-primary/15 '.$this->rounded('full'),
            'badge-text' => 'text-xs font-semibold text-theme-ui-primary',
            'arrow' => 'text-theme-ui-muted-foreground',
            default => 'w-full overflow-hidden border border-theme-ui-border bg-theme-ui-card '.$this->rounded('xl'),
        };
    }
}
