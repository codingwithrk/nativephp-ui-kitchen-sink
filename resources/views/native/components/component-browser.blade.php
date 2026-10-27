<native:top-bar title="Components" :subtitle="$componentCount.' components · '.$tagCount.' tags'" display-mode="large" />

<ui:page>
    <native:row class="w-full items-center justify-between">
        <ui:muted>Showing the docs for</ui:muted>
        @include('native.components.partials.version-picker')
    </native:row>

    <native:row class="w-full gap-2 items-center">
        <ui:input ref="search" class="flex-1" native:model.debounce.250ms="search" icon="search" placeholder="Search components and tags" />
        @if ($isSearching)
            <ui:button ref="clear-search" variant="ghost" size="icon" icon="close" a11y-label="Clear search" @press="clearSearch" />
        @endif
    </native:row>

    @if ($isSearching)
        @if (count($results) > 0)
            <native:column class="w-full gap-3">
                <ui:section-header title="Results" :description="count($results).' '.str('match')->plural(count($results))" />
                <ui:nav-list>
                    @foreach ($results as $component)
                        @if (! $loop->first)
                            <ui:separator />
                        @endif
                        <ui:nav-row
                            ref="result-{{ $component->slug }}"
                            native:key="result-{{ $component->slug }}"
                            :icon="$component->icon"
                            :color="$groupColors[$component->group]"
                            :title="$component->name"
                            :description="$component->description"
                            :badge="$badges[$component->slug]"
                            @navigate="$component->url()"
                        />
                    @endforeach
                </ui:nav-list>
            </native:column>
        @else
            <ui:empty icon="search" title="No components found" description="Nothing matches {{ $search }}. Try a component name or a tag like input.">
                <ui:button variant="outline" @press="clearSearch">Clear search</ui:button>
            </ui:empty>
        @endif
    @else
        <native:column class="w-full gap-3">
            @foreach ($groupRows as $row)
                <native:row class="w-full gap-3" native:key="group-row-{{ $loop->index }}">
                    @foreach ($row as $group)
                        <ui:tile
                            ref="group-{{ $group->slug }}"
                            native:key="group-{{ $group->slug }}"
                            class="flex-1"
                            :icon="$group->icon"
                            :color="$group->color"
                            :title="$group->label"
                            :subtitle="$groupCounts[$group->slug].' '.str('component')->plural($groupCounts[$group->slug])"
                            :badge="$groupBadges[$group->slug] ?? null"
                            @navigate="$group->url()"
                        />
                    @endforeach
                    @if (count($row) === 1)
                        <native:spacer class="flex-1" />
                    @endif
                </native:row>
            @endforeach
        </native:column>
    @endif
</ui:page>

@include('native.components.partials.version-sheet')
