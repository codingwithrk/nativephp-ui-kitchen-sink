<native:top-bar :title="$group->label" back />

<ui:page>
    <native:column class="w-full gap-4 pt-2">
        <ui:icon-tile :icon="$group->icon" :color="$group->color" size="lg" />
        <native:column class="w-full gap-2">
            <ui:h3>{{ $group->label }}</ui:h3>
            <ui:p class="text-theme-ui-muted-foreground">{{ $group->description }}</ui:p>
        </native:column>
        <native:row class="gap-2">
            <ui:badge variant="secondary">{{ count($components) }} {{ str('component')->plural(count($components)) }}</ui:badge>
            <ui:badge variant="outline">{{ $tagCount }} {{ str('tag')->plural($tagCount) }}</ui:badge>
            <ui:badge variant="outline">v{{ $viewingVersion }}</ui:badge>
        </native:row>
    </native:column>

    <ui:nav-list>
        @foreach ($components as $component)
            @if (! $loop->first)
                <ui:separator />
            @endif
            <ui:nav-row
                ref="open-{{ $component->slug }}"
                native:key="component-{{ $component->slug }}"
                :icon="$component->icon"
                :color="$group->color"
                :title="$component->name"
                :description="$component->description"
                :badge="$badges[$component->slug]"
                @navigate="$component->url()"
            />
        @endforeach
    </ui:nav-list>

    @include('native.partials.banner-ad-space')
</ui:page>
