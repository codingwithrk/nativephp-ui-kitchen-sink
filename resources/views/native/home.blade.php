<native:top-bar title="NativePHP UI" />

<ui:page class="gap-10">
    {{-- Hero --}}
    <native:column class="w-full gap-5 pt-2">
        <native:row class="w-full items-center justify-between">
            <native:row class="items-center gap-2 px-3 py-[6] border border-theme-ui-border rounded-full">
                <native:column class="w-2 h-2 bg-theme-ui-primary rounded-full" />
                <native:text class="text-xs text-theme-ui-muted-foreground">For NativePHP Mobile v4.5+</native:text>
            </native:row>
            @include('native.components.partials.version-picker')
        </native:row>

        <native:column class="w-full gap-0">
            <native:text class="text-4xl font-bold text-theme-ui-foreground">shadcn/ui, rendered</native:text>
            <native:text class="text-4xl font-bold text-theme-ui-primary">natively.</native:text>
        </native:column>
        <ui:p class="text-theme-ui-muted-foreground">Write ui:button, ui:card and ui:tabs in your NativePHP SuperNative screens. You get shadcn's look as real SwiftUI and Jetpack Compose views, not HTML in a web view.</ui:p>

        <native:row class="w-full gap-2">
            <ui:button ref="browse-components" class="flex-1" icon-trailing="arrow_forward" @navigate='/components'>Browse components</ui:button>
            <ui:button ref="open-themes" variant="outline" class="flex-1" @navigate='/themes'>Themes</ui:button>
        </native:row>
    </native:column>

    {{-- Live hero example --}}
    <ui:card>
        <ui:card-header>
            <ui:card-title>Create project</ui:card-title>
            <ui:card-description>Deploy your new project in one click.</ui:card-description>
        </ui:card-header>
        <ui:card-content>
            <ui:field label="Name">
                <ui:input ref="project-name" native:model="projectName" placeholder="Name of your project" />
            </ui:field>
            <ui:switch ref="private" native:model="isPrivate">Private repository</ui:switch>
        </ui:card-content>
        <ui:card-footer>
            <ui:button ref="cancel" variant="outline" @press="cancel">Cancel</ui:button>
            <ui:button ref="deploy" class="flex-1" :loading="$isDeploying" @press="deploy">Deploy</ui:button>
        </ui:card-footer>
    </ui:card>

    {{-- Why --}}
    <native:column class="w-full gap-4">
        <native:column class="w-full gap-2">
            <native:text class="text-xs font-semibold text-theme-ui-muted-foreground">WHY NATIVEPHP UI</native:text>
            <ui:h3>Everything you like about shadcn. On a phone. For real.</ui:h3>
        </native:column>
        <native:column class="w-full border border-theme-ui-border bg-theme-ui-card rounded-[16]">
            @foreach ($features as $feature)
                @if (! $loop->first)
                    <ui:separator />
                @endif
                <native:row class="w-full items-start gap-4 p-5" native:key="feature-{{ $loop->index }}">
                    <native:column class="w-10 h-10 items-center justify-center border border-theme-ui-border bg-theme-ui-muted/50 rounded-[12]">
                        <native:icon :name="$feature['android']" :ios="$feature['ios']" :android="$feature['android']" :size="20" class="text-theme-ui-foreground" />
                    </native:column>
                    <native:column class="flex-1 gap-1">
                        <native:text class="text-base font-semibold text-theme-ui-card-foreground">{{ $feature['title'] }}</native:text>
                        <native:text class="text-sm text-theme-ui-muted-foreground">{{ $feature['text'] }}</native:text>
                    </native:column>
                </native:row>
            @endforeach
        </native:column>
    </native:column>

    {{-- Gallery --}}
    <native:column class="w-full gap-4">
        <native:column class="w-full gap-2">
            <native:text class="text-xs font-semibold text-theme-ui-muted-foreground">COMPONENTS</native:text>
            <ui:h3>{{ $componentCount }} components. {{ $tagCount }} tags.</ui:h3>
            <ui:p class="text-theme-ui-muted-foreground">{{ $hasV110Gallery ? 'Everything you need for real app screens: forms, selects, menus, dialogs, tables, charts, chat and toasts.' : 'Everything you need for real app screens: forms, lists, tabs, dialogs, feedback and more.' }} Every preview here is live.</ui:p>
        </native:column>

        <ui:gallery-tile ref="gallery-button" title="Button" :badge="$galleryBadges['button'] ?? null" @navigate='/components/button'>
            <native:row class="flex-wrap justify-center gap-2">
                <ui:button size="sm">Default</ui:button>
                <ui:button size="sm" variant="outline">Outline</ui:button>
                <ui:button size="sm" variant="secondary">Secondary</ui:button>
            </native:row>
        </ui:gallery-tile>

        <ui:gallery-tile ref="gallery-switch" title="Switch" :badge="$galleryBadges['switch'] ?? null" @navigate='/components/switch'>
            <native:column class="gap-3">
                <ui:switch ref="wifi" native:model="isWifiOn">Wi-Fi</ui:switch>
                <ui:switch ref="bluetooth" native:model="isBluetoothOn">Bluetooth</ui:switch>
            </native:column>
        </ui:gallery-tile>

        <ui:gallery-tile ref="gallery-tabs" title="Tabs" :badge="$galleryBadges['tabs'] ?? null" @navigate='/components/tabs'>
            <ui:tabs native:model="range" class="w-[240]">
                <ui:tabs-list>
                    <ui:tabs-trigger ref="range-day" value="day">Day</ui:tabs-trigger>
                    <ui:tabs-trigger ref="range-week" value="week">Week</ui:tabs-trigger>
                    <ui:tabs-trigger ref="range-month" value="month">Month</ui:tabs-trigger>
                </ui:tabs-list>
            </ui:tabs>
        </ui:gallery-tile>

        <ui:gallery-tile ref="gallery-badge" title="Badge" :badge="$galleryBadges['badge'] ?? null" @navigate='/components/badge'>
            <native:row class="flex-wrap justify-center gap-2">
                <ui:badge>New</ui:badge>
                <ui:badge variant="secondary" icon="check">Verified</ui:badge>
                <ui:badge variant="outline">Draft</ui:badge>
            </native:row>
        </ui:gallery-tile>

        <ui:gallery-tile ref="gallery-toggle-group" title="Toggle Group" :badge="$galleryBadges['toggle-group'] ?? null" @navigate='/components/toggle-group'>
            <ui:toggle-group type="multiple" native:model="styles" variant="outline">
                <ui:toggle-group-item value="bold" icon="format_bold" a11y-label="Bold" />
                <ui:toggle-group-item value="italic" icon="format_italic" a11y-label="Italic" />
                <ui:toggle-group-item value="underline" icon="format_underlined" a11y-label="Underline" />
            </ui:toggle-group>
        </ui:gallery-tile>

        <ui:gallery-tile ref="gallery-radio-group" title="Radio Group" :badge="$galleryBadges['radio-group'] ?? null" @navigate='/components/radio-group'>
            <ui:radio-group native:model="plan" class="w-auto">
                <ui:radio-group-item ref="plan-free" value="free">Free</ui:radio-group-item>
                <ui:radio-group-item ref="plan-pro" value="pro">Pro</ui:radio-group-item>
            </ui:radio-group>
        </ui:gallery-tile>

        <ui:gallery-tile ref="gallery-alert" title="Alert" :badge="$galleryBadges['alert'] ?? null" @navigate='/components/alert'>
            <ui:alert icon="info" class="w-[260]">
                <ui:alert-title>Heads up!</ui:alert-title>
                <ui:alert-description>Your build is ready.</ui:alert-description>
            </ui:alert>
        </ui:gallery-tile>

        <ui:gallery-tile ref="gallery-avatar" title="Avatar & Progress" :badge="$galleryBadges['avatar'] ?? null" @navigate='/components/avatar'>
            <native:column class="w-[220] gap-4">
                <native:row class="items-center gap-3">
                    <ui:avatar fallback="RK" size="lg" />
                    <native:column class="gap-1">
                        <ui:small>Rajkumar</ui:small>
                        <ui:muted>Uploading…</ui:muted>
                    </native:column>
                </native:row>
                <ui:progress :value="66" />
            </native:column>
        </ui:gallery-tile>

        @includeWhen($hasV110Gallery, 'native.home.gallery-v110')

        <ui:button ref="see-all" variant="outline" icon="dashboard" @navigate='/components'>See all components</ui:button>
    </native:column>

    {{-- Theming --}}
    <native:column class="w-full gap-4">
        <native:column class="w-full gap-2">
            <native:text class="text-xs font-semibold text-theme-ui-muted-foreground">THEMING</native:text>
            <ui:h3>One config file. Every shadcn theme.</ui:h3>
            <ui:p class="text-theme-ui-muted-foreground">Pick a base color and an accent, and set the radius. Light and dark values ship together, so your app follows the device automatically.</ui:p>
        </native:column>
        <native:column class="w-full gap-4 p-5 border border-theme-ui-border bg-theme-ui-card rounded-[16]">
            <native:row class="w-full items-center justify-between">
                <ui:small>Current theme</ui:small>
                <ui:switch :checked="true" size="sm" />
            </native:row>
            <ui:progress :value="55" />
            <ui:button size="sm" class="self-start">Continue</ui:button>
        </native:column>
        <ui:button ref="theme-playground" variant="outline" icon="palette" @navigate='/themes'>Open the theme playground</ui:button>
    </native:column>

    {{-- Templates --}}
    <native:column class="w-full gap-3">
        <ui:section-header title="Templates" description="Complete screens built only from ui tags." action="All" @navigate='/templates' />
        <ui:nav-list>
            @foreach (array_slice($templates, 0, 3) as $template)
                @if (! $loop->first)
                    <ui:separator />
                @endif
                <ui:nav-row
                    native:key="home-template-{{ $template->slug }}"
                    :icon="$template->icon"
                    :title="$template->name"
                    :description="$template->description"
                    @navigate="$template->url()"
                />
            @endforeach
        </ui:nav-list>
    </native:column>

    @if ($upcomingCount > 0)
        <ui:alert icon="info">
            <ui:alert-title>{{ $upcomingCount }} more components in {{ $latestVersion }}</ui:alert-title>
            <ui:alert-description>Update codingwithrk/nativephp-ui to {{ $latestVersion }} and they appear here automatically.</ui:alert-description>
        </ui:alert>
    @endif

    {{-- Call to action --}}
    <native:column class="w-full items-center gap-4 px-6 py-10 bg-theme-ui-foreground rounded-[24]">
        <native:text class="text-2xl font-semibold text-center text-theme-ui-background">Build beautiful native screens today.</native:text>
        <native:text class="text-sm text-center text-theme-ui-background/70">Get a license on the CodingwithRK Marketplace. Install with Composer, register the plugin, and start writing ui tags.</native:text>
        <native:row ref="open-marketplace" class="items-center gap-2 px-4 py-2 bg-theme-ui-primary rounded-[12]" @press="openMarketplace" a11y-label="Open the CodingwithRK Marketplace">
            <native:icon name="shopping_bag" ios="bag" :size="16" class="text-theme-ui-primary-foreground" />
            <native:text class="text-sm font-medium text-theme-ui-primary-foreground">marketplace.codingwithrk.com</native:text>
        </native:row>
    </native:column>

    <native:column class="w-full items-center gap-1 pb-4">
        <ui:muted>NativePHP UI v{{ $viewingVersion }} · {{ $groupCount }} groups</ui:muted>
        <ui:muted>by CodingwithRK</ui:muted>
    </native:column>
</ui:page>

@include('native.components.partials.version-sheet')

<ui:dialog ref="update-dialog" native:model="isUpdateDialogOpen">
    <ui:dialog-header>
        <ui:dialog-title>Update available</ui:dialog-title>
        <ui:dialog-description>{{ $updateMessage ?? 'Version '.$updateVersion.' is available on '.$updateStoreName.', with the latest components and fixes.' }}</ui:dialog-description>
    </ui:dialog-header>
    <ui:dialog-footer>
        <ui:button ref="update-now" icon="download" @press="updateNow">Update to {{ $updateVersion }}</ui:button>
        <ui:button ref="update-later" variant="outline" @press="remindLater">Not now</ui:button>
        <ui:button ref="update-skip" variant="ghost" @press="skipUpdate">Skip this version</ui:button>
    </ui:dialog-footer>
</ui:dialog>
