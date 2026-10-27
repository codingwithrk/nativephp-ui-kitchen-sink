<?php

namespace App\Ui;

use Codingwithrk\NativephpUi\Compiler\Tag;
use Codingwithrk\NativephpUi\Components\Component;

/**
 * A custom `<ui:stat>` tag registered by the app, showing how to extend
 * NativePHP UI with your own shadcn-styled components.
 *
 * <ui:stat label="Revenue" :value="$revenue" :change="$revenueChange" />
 */
class Stat extends Component
{
    /**
     * @return array{trend: string}
     */
    public function props(): array
    {
        return ['trend' => 'up'];
    }

    public function render(Tag $tag): string
    {
        $out = '<native:column '.$tag->cls().$tag->forward('label', 'value', 'change').'>';
        $out .= '<native:text '.$tag->cls('label').' '.Tag::bind('text', $tag->expr('label')).' />';
        $out .= '<native:text '.$tag->cls('value').' '.Tag::bind('text', $tag->expr('value')).' />';

        if ($tag->has('change')) {
            $isDown = "({$tag->expr('trend', "'up'")}) === 'down'";

            $out .= '<native:row '.$tag->cls('change').'>'
                .'<native:icon '
                .Tag::bind('name', "({$isDown}) ? 'trending_down' : 'trending_up'").' '
                .Tag::bind('ios', "({$isDown}) ? 'chart.line.downtrend.xyaxis' : 'chart.line.uptrend.xyaxis'")
                .' :size="14" '.$tag->cls('trend-icon').' />'
                .'<native:text '.$tag->cls('trend-text').' '.Tag::bind('text', $tag->expr('change')).' />'
                .'</native:row>';
        }

        return $out.'</native:column>';
    }

    /**
     * @param  array{trend: string}  $props
     */
    public function classes(string $tag, string $part, array $props): string
    {
        $trendColor = $props['trend'] === 'down' ? 'text-theme-ui-destructive' : 'text-theme-success';

        return match ($part) {
            'label' => 'text-sm text-theme-ui-muted-foreground',
            'value' => 'text-2xl font-bold text-theme-ui-card-foreground',
            'change' => 'items-center gap-1',
            'trend-icon', 'trend-text' => 'text-xs font-medium '.$trendColor,
            default => 'flex-1 gap-1 p-4 border border-theme-ui-border bg-theme-ui-card '.$this->rounded('xl'),
        };
    }
}
