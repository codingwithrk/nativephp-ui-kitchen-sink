<native:top-bar title="Themes" display-mode="large" />

<ui:page>
    <native:column class="w-full gap-3">
        <native:text class="text-xs font-semibold text-theme-ui-muted-foreground">THEME PLAYGROUND</native:text>
        <ui:h2>Make it yours.</ui:h2>
        <ui:p class="text-theme-ui-muted-foreground">Pick a base color, accent and radius. The previews use the exact palette the plugin pushes to the device, and your choice is applied to every screen in this app.</ui:p>
    </native:column>

    {{-- Base color --}}
    <native:column class="w-full gap-3">
        <native:text class="text-xs font-semibold text-theme-ui-muted-foreground">BASE COLOR</native:text>
        <native:row class="w-full flex-wrap gap-2">
            @foreach ($baseSwatches as $base => $swatch)
                <ui:chip ref="base-{{ $base }}" native:key="base-{{ $base }}" :active="$baseColor === $base" :swatch="$swatch" @press="setBaseColor('{{ $base }}')">{{ $base }}</ui:chip>
            @endforeach
        </native:row>
    </native:column>

    {{-- Accent --}}
    <native:column class="w-full gap-3">
        <native:text class="text-xs font-semibold text-theme-ui-muted-foreground">ACCENT</native:text>
        <native:row class="w-full flex-wrap gap-2">
            @foreach ($accentSwatches as $swatchAccent => $swatch)
                <ui:chip ref="accent-{{ $swatchAccent }}" native:key="accent-{{ $swatchAccent }}" :active="$accent === $swatchAccent" :swatch="$swatch" @press="setAccent('{{ $swatchAccent }}')">{{ $swatchAccent }}</ui:chip>
            @endforeach
        </native:row>
    </native:column>

    {{-- Radius --}}
    <native:column class="w-full gap-3">
        <native:text class="text-xs font-semibold text-theme-ui-muted-foreground">RADIUS</native:text>
        <native:row class="w-full flex-wrap gap-2">
            @foreach ($radii as $radiusOption)
                <ui:chip ref="radius-{{ $radiusOption }}" native:key="radius-{{ $radiusOption }}" :active="$radius === $radiusOption" @press="setRadius({{ $radiusOption }})">{{ $radiusOption }}</ui:chip>
            @endforeach
        </native:row>
    </native:column>

    {{-- Appearance --}}
    <native:column class="w-full gap-3">
        <native:text class="text-xs font-semibold text-theme-ui-muted-foreground">APPEARANCE</native:text>
        <native:row class="w-full flex-wrap gap-2">
            @foreach ($appearances as $mode => $label)
                <ui:chip ref="appearance-{{ $mode }}" native:key="appearance-{{ $mode }}" :active="$appearance === $mode" @press="setAppearance('{{ $mode }}')">{{ $label }}</ui:chip>
            @endforeach
        </native:row>
    </native:column>

    <ui:button ref="reset-theme" variant="ghost" size="sm" icon="refresh" class="self-start" :disabled="! $isCustom" @press="resetTheme">Reset to defaults</ui:button>

    <ui:separator />

    {{-- The docs site's showcase screen --}}
    <native:column class="w-full gap-5 p-5 border border-theme-ui-border bg-theme-ui-background rounded-[24]">
        <native:row class="w-full items-center gap-3">
            <ui:avatar fallback="AM" size="lg" />
            <native:column class="flex-1 gap-1">
                <ui:large>Acme Mobile</ui:large>
                <ui:muted>Production · iOS & Android</ui:muted>
            </native:column>
            <ui:badge variant="secondary" icon="check">Live</ui:badge>
        </native:row>

        <ui:tabs native:model="previewTab">
            <ui:tabs-list>
                <ui:tabs-trigger ref="preview-overview" value="overview">Overview</ui:tabs-trigger>
                <ui:tabs-trigger ref="preview-settings" value="settings">Settings</ui:tabs-trigger>
            </ui:tabs-list>
            <ui:tabs-content value="overview">
                <ui:card>
                    <ui:card-header>
                        <ui:card-title>Release 2.4.0</ui:card-title>
                        <ui:card-description>Rolling out to 64% of users.</ui:card-description>
                        <ui:card-action><ui:button size="icon-sm" variant="ghost" icon="more_horiz" a11y-label="More" /></ui:card-action>
                    </ui:card-header>
                    <ui:card-content>
                        <ui:progress :value="64" />
                        <native:row class="gap-2">
                            <ui:badge variant="outline">ios</ui:badge>
                            <ui:badge variant="outline">android</ui:badge>
                            <ui:badge>stable</ui:badge>
                        </native:row>
                    </ui:card-content>
                    <ui:card-footer>
                        <ui:button ref="pause" variant="outline" class="flex-1" @press="confirmPause">Pause</ui:button>
                        <ui:button ref="roll-out" class="flex-1" :loading="$isRollingOut" @press="toggleRollout">Roll out</ui:button>
                    </ui:card-footer>
                </ui:card>
                <ui:alert icon="info">
                    <ui:alert-title>Crash-free sessions: 99.8%</ui:alert-title>
                    <ui:alert-description>Up 0.3% since the last release.</ui:alert-description>
                </ui:alert>
                <ui:item-group class="gap-0">
                    <ui:item size="sm" icon="notifications" title="Notifications" chevron class="px-0" />
                    <ui:separator />
                    <ui:item size="sm" icon="shield" title="Security" chevron class="px-0" />
                </ui:item-group>
            </ui:tabs-content>
            <ui:tabs-content value="settings">
                <ui:field label="App name">
                    <ui:input value="Acme Mobile" />
                </ui:field>
                <ui:switch native:model="hasAutomaticUpdates">Automatic updates</ui:switch>
                <ui:checkbox native:model="hasCrashReporting">Crash reporting</ui:checkbox>
                <ui:separator />
                <ui:radio-group native:model="rollout">
                    <ui:radio-group-item value="instant">Release instantly</ui:radio-group-item>
                    <ui:radio-group-item value="staged">Staged rollout</ui:radio-group-item>
                </ui:radio-group>
                <ui:button variant="destructive" icon="delete">Delete app</ui:button>
            </ui:tabs-content>
        </ui:tabs>
    </native:column>

    {{-- Component panel --}}
    <native:column class="w-full gap-5 p-6 border border-theme-ui-border rounded-[24]">
        <native:row class="w-full flex-wrap gap-2">
            <ui:button size="sm">Primary</ui:button>
            <ui:button size="sm" variant="secondary">Secondary</ui:button>
            <ui:button size="sm" variant="outline">Outline</ui:button>
            <ui:button size="sm" variant="destructive">Delete</ui:button>
        </native:row>
        <native:row class="w-full flex-wrap items-center gap-4">
            <ui:switch native:model="isPreviewSwitchOn" />
            <ui:checkbox :checked="true">Checked</ui:checkbox>
            <ui:toggle-group type="single" native:model="alignment" variant="outline" size="sm">
                <ui:toggle-group-item value="left" icon="format_align_left" a11y-label="Align left" />
                <ui:toggle-group-item value="center" icon="format_align_center" a11y-label="Align center" />
                <ui:toggle-group-item value="right" icon="format_align_right" a11y-label="Align right" />
            </ui:toggle-group>
        </native:row>
        <ui:input icon="search" placeholder="Search…" />
        <ui:progress :value="72" />
    </native:column>

    <ui:muted class="text-center">On your own app, set the same values in config/nativephp-ui.php.</ui:muted>
</ui:page>

<ui:dialog ref="pause-dialog" native:model="isConfirmingPause">
    <ui:dialog-header>
        <ui:dialog-title>Pause the rollout?</ui:dialog-title>
        <ui:dialog-description>Users who already updated keep 2.4.0. You can resume at any time.</ui:dialog-description>
    </ui:dialog-header>
    <ui:dialog-footer>
        <ui:button ref="confirm-pause" @press="closePause">Pause rollout</ui:button>
        <ui:button variant="outline" @press="closePause">Cancel</ui:button>
    </ui:dialog-footer>
</ui:dialog>
