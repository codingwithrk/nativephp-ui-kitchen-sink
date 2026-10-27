<?php

namespace App\NativeComponents;

use App\Showcase\ThemeSettings;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * The Themes tab — the docs site's theme playground. Picks apply to the
 * whole app at once and persist across launches.
 */
class Themes extends NativeComponent
{
    public string $appearance = 'system';

    public string $baseColor = 'zinc';

    public string $accent = 'violet';

    public int $radius = 10;

    public string $previewTab = 'overview';

    public bool $isRollingOut = false;

    public bool $isConfirmingPause = false;

    public bool $hasAutomaticUpdates = true;

    public bool $hasCrashReporting = true;

    public string $rollout = 'staged';

    public string $alignment = 'center';

    public bool $isPreviewSwitchOn = true;

    public function mount(): void
    {
        $this->syncFrom(ThemeSettings::load());
    }

    public function setBaseColor(string $baseColor): void
    {
        $this->applyTheme(baseColor: $baseColor);
    }

    public function setAccent(string $accent): void
    {
        $this->applyTheme(accent: $accent);
    }

    public function setRadius(int $radius): void
    {
        $this->applyTheme(radius: $radius);
    }

    public function setAppearance(string $appearance): void
    {
        $this->applyTheme(appearance: $appearance);
    }

    public function resetTheme(): void
    {
        $defaults = ThemeSettings::defaults()->apply();
        $defaults->forget();

        $this->syncFrom($defaults);
    }

    public function toggleRollout(): void
    {
        $this->isRollingOut = ! $this->isRollingOut;
    }

    public function confirmPause(): void
    {
        $this->isConfirmingPause = true;
    }

    public function closePause(): void
    {
        $this->isConfirmingPause = false;
        $this->isRollingOut = false;
    }

    /**
     * Save and apply the current picks with one value changed. Unknown
     * values are ignored, keeping the current choice.
     */
    private function applyTheme(?string $appearance = null, ?string $baseColor = null, ?string $accent = null, ?int $radius = null): void
    {
        $settings = new ThemeSettings(
            appearance: in_array($appearance, ThemeSettings::Appearances, true) ? $appearance : $this->appearance,
            baseColor: in_array($baseColor, ThemeSettings::baseColors(), true) ? $baseColor : $this->baseColor,
            accent: in_array($accent, array_keys((new ThemeSettings)->accentSwatches()), true) ? $accent : $this->accent,
            radius: in_array($radius, ThemeSettings::Radii, true) ? $radius : $this->radius,
        );

        $settings->save()->apply();

        $this->syncFrom($settings);
    }

    private function syncFrom(ThemeSettings $settings): void
    {
        $this->appearance = $settings->appearance;
        $this->baseColor = $settings->baseColor;
        $this->accent = $settings->accent;
        $this->radius = $settings->radius;
    }

    public function render(): View
    {
        return view('native.themes', [
            'baseSwatches' => ThemeSettings::baseSwatches(),
            'accentSwatches' => (new ThemeSettings(baseColor: $this->baseColor))->accentSwatches(),
            'radii' => ThemeSettings::Radii,
            'appearances' => ['system' => 'Follow system', 'light' => 'Light', 'dark' => 'Dark'],
            'isCustom' => ! (new ThemeSettings($this->appearance, $this->baseColor, $this->accent, $this->radius))->isDefault(),
        ]);
    }
}
