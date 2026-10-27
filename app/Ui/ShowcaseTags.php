<?php

namespace App\Ui;

use Codingwithrk\NativephpUi\Components\Component;
use Codingwithrk\NativephpUi\Ui;

/**
 * The app's own `<ui:*>` tags, built on nativephp-ui's Component API.
 */
final class ShowcaseTags
{
    /**
     * @var array<string, class-string<Component>>
     */
    public const array Tags = [
        'example' => Example::class,
        'stat' => Stat::class,
        'icon-tile' => IconTile::class,
        'nav-list' => NavRow::class,
        'nav-row' => NavRow::class,
        'tile' => Tile::class,
        'section-header' => SectionHeader::class,
        'chip' => Chip::class,
        'gallery-tile' => GalleryTile::class,
    ];

    public static function register(): void
    {
        foreach (self::Tags as $name => $component) {
            Ui::register($name, $component);
        }
    }
}
