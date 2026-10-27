<?php

namespace App\Ui;

use Codingwithrk\NativephpUi\Compiler\Tag;
use Codingwithrk\NativephpUi\Components\Component;
use Codingwithrk\NativephpUi\Ui;

/**
 * A platform icon on a tinted, rounded tile.
 *
 * <ui:icon-tile :icon="$group->icon" :color="$group->color" size="lg" />
 *
 * `icon` is a PlatformIcon (SF Symbol + Material name). `color` is any
 * theme token: ui-primary (the default), tint-blue, tint-rose, …
 */
class IconTile extends Component
{
    /** @var array<string, array{tile: string, icon: int, rounded: string}> */
    private const array Sizes = [
        'sm' => ['tile' => 'w-8 h-8', 'icon' => 16, 'rounded' => 'md'],
        'md' => ['tile' => 'w-10 h-10', 'icon' => 20, 'rounded' => 'lg'],
        'lg' => ['tile' => 'w-14 h-14', 'icon' => 28, 'rounded' => 'xl'],
    ];

    /**
     * @return array{color: string, size: string}
     */
    public function props(): array
    {
        return ['color' => 'ui-primary', 'size' => 'md'];
    }

    public function render(Tag $tag): string
    {
        $size = $tag->static('size') ?? 'md';

        return self::markup($tag->expr('icon'), $tag->expr('color', "'ui-primary'"), $size, $tag->forward('icon'), $tag->userClass());
    }

    /**
     * Native markup for a tile — also used by the other showcase tags.
     */
    public static function markup(string $iconExpression, string $colorExpression, string $size = 'md', string $forwarded = '', string $userClass = 'null'): string
    {
        $props = "['color' => {$colorExpression}, 'size' => ".var_export($size, true).']';
        $iconSize = self::Sizes[$size]['icon'] ?? 20;

        return '<native:column :class="\\'.Ui::class."::cls('icon-tile', 'root', {$props}, {$userClass})\"{$forwarded}>"
            .'<native:icon :name="('.$iconExpression.')->android" :ios="('.$iconExpression.')->ios" :android="('.$iconExpression.')->android"'
            .' :size="'.$iconSize.'" :class="\\'.Ui::class."::cls('icon-tile', 'icon', {$props})\" />"
            .'</native:column>';
    }

    /**
     * @param  array{color: string, size: string}  $props
     */
    public function classes(string $tag, string $part, array $props): string
    {
        $size = self::Sizes[$props['size']] ?? self::Sizes['md'];

        return match ($part) {
            'icon' => 'text-theme-'.$props['color'],
            default => implode(' ', [
                $size['tile'],
                'items-center justify-center',
                'bg-theme-'.$props['color'].'/15',
                $this->rounded($size['rounded']),
            ]),
        };
    }
}
