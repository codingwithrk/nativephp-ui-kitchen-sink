<?php

namespace App\Showcase;

use App\Ui\ShowcaseTags;
use Codingwithrk\NativephpUi\Theme\Palette;
use Codingwithrk\NativephpUi\Ui;
use Illuminate\Support\Facades\File;
use Native\Mobile\Edge\TailwindParser;
use Native\Mobile\UI\Theme;

/**
 * The theme a viewer picked in Settings — appearance, base color, accent
 * and radius — saved to a small JSON file and applied at runtime.
 */
final class ThemeSettings
{
    /** @var list<string> */
    public const array Appearances = ['system', 'light', 'dark'];

    /** @var list<int> */
    public const array Radii = [0, 4, 6, 8, 10, 12, 16];

    /**
     * native-ui token => nativephp-ui token, so native chrome and controls
     * (top bar, tab bar, sheets, pickers) follow the shadcn palette too.
     *
     * @var array<string, string>
     */
    public const array NativeTokens = [
        'primary' => 'primary',
        'on-primary' => 'primary-foreground',
        'secondary' => 'secondary-foreground',
        'on-secondary' => 'secondary',
        'surface' => 'background',
        'on-surface' => 'foreground',
        'background' => 'background',
        'on-background' => 'foreground',
        'surface-variant' => 'muted',
        'on-surface-variant' => 'muted-foreground',
        'outline' => 'input',
        'outline-variant' => 'border',
        'destructive' => 'destructive',
        'on-destructive' => 'destructive-foreground',
    ];

    public function __construct(
        public string $appearance = 'system',
        public string $baseColor = 'zinc',
        public string $accent = 'violet',
        public int $radius = 10,
    ) {}

    public static function defaults(): self
    {
        return new self(
            baseColor: (string) config('showcase.theme.base_color', 'zinc'),
            accent: (string) (config('showcase.theme.accent') ?? 'default'),
            radius: (int) config('showcase.theme.radius', 10),
        );
    }

    /**
     * The saved settings, or the defaults when nothing valid is saved.
     */
    public static function load(): self
    {
        $defaults = self::defaults();
        $path = self::path();

        if (! File::exists($path)) {
            return $defaults;
        }

        $saved = json_decode((string) File::get($path), true);

        if (! is_array($saved)) {
            return $defaults;
        }

        return (new self(
            appearance: (string) ($saved['appearance'] ?? $defaults->appearance),
            baseColor: (string) ($saved['baseColor'] ?? $defaults->baseColor),
            accent: (string) ($saved['accent'] ?? $defaults->accent),
            radius: (int) ($saved['radius'] ?? $defaults->radius),
        ))->sanitized();
    }

    public static function hasSaved(): bool
    {
        return File::exists(self::path());
    }

    public static function path(): string
    {
        return (string) config('showcase.theme.path', storage_path('app/showcase-theme.json'));
    }

    public function save(): self
    {
        File::ensureDirectoryExists(dirname(self::path()));
        File::put(self::path(), json_encode($this->toArray(), JSON_PRETTY_PRINT));

        return $this;
    }

    public function forget(): void
    {
        File::delete(self::path());
    }

    /**
     * Push the theme to the native side and refresh every cache that holds
     * resolved colors or radii, so the next render picks it up.
     */
    public function apply(): self
    {
        config([
            'nativephp-ui.base_color' => $this->baseColor,
            'nativephp-ui.accent' => $this->accent === 'default' ? null : $this->accent,
            'nativephp-ui.radius' => $this->radius,
        ]);

        Theme::merge($this->tokens());
        TailwindParser::clearCache();

        self::clearResolvedClasses();

        return $this;
    }

    /**
     * nativephp-ui 1.1.0+ clears only its class cache; older versions can
     * only flush the whole registry, so the app's own tags go back in.
     */
    private static function clearResolvedClasses(): void
    {
        if (method_exists(Ui::class, 'clearClassCache')) {
            Ui::clearClassCache();

            return;
        }

        Ui::flush();
        ShowcaseTags::register();
    }

    /**
     * The `ui-*` palette plus the showcase's `tint-*` colors, with
     * native-ui's own tokens pointed at the palette. A forced appearance
     * gives both modes the same colors.
     *
     * @return array{light: array<string, string>, dark: array<string, string>}
     */
    public function tokens(): array
    {
        $palette = Palette::tokens($this->baseColor, $this->accent === 'default' ? null : $this->accent);

        foreach (['light', 'dark'] as $mode) {
            foreach (self::NativeTokens as $nativeToken => $uiToken) {
                $palette[$mode][$nativeToken] = $palette[$mode]['ui-'.$uiToken];
            }

            foreach ((array) config('showcase.tints', []) as $name => $tint) {
                $palette[$mode]['tint-'.$name] = $tint[$mode];
            }
        }

        return match ($this->appearance) {
            'light' => ['light' => $palette['light'], 'dark' => $palette['light']],
            'dark' => ['light' => $palette['dark'], 'dark' => $palette['dark']],
            default => $palette,
        };
    }

    /**
     * Swatch colors for the accent picker: `default` shows the base color's
     * own primary.
     *
     * @return array<string, string> accent => hex
     */
    public function accentSwatches(): array
    {
        return collect(['default', ...Palette::accents()])
            ->mapWithKeys(fn (string $accent): array => [
                $accent => Palette::tokens($this->baseColor, $accent === 'default' ? null : $accent)['light']['ui-primary'],
            ])
            ->all();
    }

    /**
     * Swatch colors for the base color picker: each base's own primary.
     *
     * @return array<string, string> base => hex
     */
    public static function baseSwatches(): array
    {
        return collect(Palette::bases())
            ->mapWithKeys(fn (string $base): array => [$base => Palette::tokens($base)['light']['ui-primary']])
            ->all();
    }

    public function isDefault(): bool
    {
        return $this->toArray() === self::defaults()->toArray();
    }

    /**
     * @return list<string>
     */
    public static function baseColors(): array
    {
        return Palette::bases();
    }

    /**
     * @return array{appearance: string, baseColor: string, accent: string, radius: int}
     */
    public function toArray(): array
    {
        return [
            'appearance' => $this->appearance,
            'baseColor' => $this->baseColor,
            'accent' => $this->accent,
            'radius' => $this->radius,
        ];
    }

    private function sanitized(): self
    {
        $defaults = self::defaults();

        return new self(
            appearance: in_array($this->appearance, self::Appearances, true) ? $this->appearance : $defaults->appearance,
            baseColor: in_array($this->baseColor, Palette::bases(), true) ? $this->baseColor : $defaults->baseColor,
            accent: in_array($this->accent, ['default', ...Palette::accents()], true) ? $this->accent : $defaults->accent,
            radius: in_array($this->radius, self::Radii, true) ? $this->radius : $defaults->radius,
        );
    }
}
