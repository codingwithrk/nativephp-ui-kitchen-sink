<native:top-bar title="About" display-mode="large" />

<ui:page>
    {{-- App identity --}}
    <native:column class="w-full items-center gap-3 pt-2">
        <native:image src="icon.png" class="w-24 h-24 rounded-[22]" a11y-label="{{ $appName }} icon" />
        <native:column class="items-center gap-1">
            <ui:h3 class="text-center">{{ $appName }}</ui:h3>
            <ui:muted class="text-center">Version {{ $appVersion }}</ui:muted>
        </native:column>
        <native:row class="gap-2">
            <ui:badge variant="secondary">nativephp-ui v{{ $pluginVersion }}</ui:badge>
            <ui:badge variant="outline">{{ $componentCount }} components</ui:badge>
        </native:row>
    </native:column>

    <ui:p class="text-center text-theme-ui-muted-foreground">{{ $description }}</ui:p>

    {{-- Links --}}
    <native:column class="w-full gap-3">
        <ui:section-header title="Links" />
        <ui:nav-list>
            @foreach ($links as $key => $link)
                @if (! $loop->first)
                    <ui:separator />
                @endif
                <ui:nav-row
                    ref="link-{{ $key }}"
                    native:key="link-{{ $key }}"
                    :icon="$link['icon']"
                    :title="$link['label']"
                    :description="$link['description']"
                    @press="openLink('{{ $key }}')"
                />
            @endforeach
        </ui:nav-list>
    </native:column>

    {{-- App details --}}
    <native:column class="w-full gap-3">
        <ui:section-header title="App details" />
        <ui:item-group>
            <ui:item variant="outline" size="sm" icon="info" title="Version">
                <ui:muted>{{ $appVersion }}</ui:muted>
            </ui:item>
            <ui:item variant="outline" size="sm" icon="description" title="Package" :description="$packageName" />
            <ui:item variant="outline" size="sm" icon="dashboard" title="NativePHP UI">
                <ui:muted>v{{ $pluginVersion }}</ui:muted>
            </ui:item>
        </ui:item-group>
    </native:column>

    {{-- Ads --}}
    <native:column class="w-full gap-3">
        <ui:section-header title="Ads" />
        <ui:alert icon="info">
            <ui:alert-title>{{ $adsEnabled ? 'This app shows Google AdMob banners' : 'Ads are turned off' }}</ui:alert-title>
            <ui:alert-description>{{ $adsEnabled
                ? 'A small banner appears at the bottom of component and template pages, never over the tab bar.'.($adsInTestMode ? ' Test mode is on, so these are Google demo ads.' : '')
                : 'No ads are shown in this build.' }}</ui:alert-description>
        </ui:alert>
    </native:column>

    {{-- Licenses --}}
    <native:column class="w-full gap-3">
        <ui:section-header title="Licenses" description="Built on these libraries. Tap one to visit it." />
        <ui:nav-list>
            @foreach ($credits as $credit)
                @if (! $loop->first)
                    <ui:separator />
                @endif
                <native:row ref="credit-{{ $credit['key'] }}" native:key="credit-{{ $credit['key'] }}" class="w-full items-center gap-3 px-4 py-3" @press="openCredit('{{ $credit['key'] }}')">
                    <native:column class="flex-1 gap-[2]">
                        <native:text class="text-base font-medium text-theme-ui-card-foreground">{{ $credit['name'] }}</native:text>
                        <native:text class="text-sm text-theme-ui-muted-foreground">{{ collect([$credit['note'], $credit['version']])->filter()->implode(' · ') ?: 'Library' }}</native:text>
                    </native:column>
                    <ui:badge variant="outline">{{ $credit['license'] }}</ui:badge>
                </native:row>
            @endforeach
        </ui:nav-list>
    </native:column>

    <native:column class="w-full items-center gap-1 pb-4">
        <ui:muted>© {{ $year }} CodingwithRK</ui:muted>
        <ui:muted>Made with NativePHP UI</ui:muted>
    </native:column>
</ui:page>
