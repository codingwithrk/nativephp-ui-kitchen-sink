<?php

namespace App\Ui;

use Codingwithrk\NativephpUi\Compiler\Tag;
use Codingwithrk\NativephpUi\Components\Component;

/**
 * A titled preview canvas for one example on a component showcase page.
 *
 * <ui:example title="Variants" description="Optional help text.">…</ui:example>
 * <ui:example title="Form" align="stretch">…</ui:example>
 */
class Example extends Component
{
    /**
     * @return array{align: string}
     */
    public function props(): array
    {
        return ['align' => 'center'];
    }

    public function render(Tag $tag): string
    {
        $out = '<native:column '.$tag->cls('section', [], false).'>';
        $out .= '<native:text '.$tag->cls('title').' '.Tag::bind('text', $tag->expr('title', "''")).' />';

        if ($tag->has('description')) {
            $out .= '<native:text '.$tag->cls('description').' '.Tag::bind('text', $tag->expr('description')).' />';
        }

        $out .= '<native:column '.$tag->cls().$tag->forward('title', 'description').'>'.$tag->content().'</native:column>';

        return $out.'</native:column>';
    }

    /**
     * @param  array{align: string}  $props
     */
    public function classes(string $tag, string $part, array $props): string
    {
        return match ($part) {
            'section' => 'w-full gap-3',
            'title' => 'text-lg font-semibold text-theme-ui-foreground',
            'description' => 'text-sm leading-normal text-theme-ui-muted-foreground',
            default => implode(' ', [
                'w-full min-h-[120] gap-4 px-5 py-8 border border-theme-ui-border bg-theme-ui-muted/40',
                $props['align'] === 'stretch' ? 'items-stretch justify-center' : 'items-center justify-center',
                $this->rounded('2xl'),
            ]),
        };
    }
}
