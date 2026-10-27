<native:column class="w-full gap-4 pt-2">
    <native:row class="w-full items-center gap-4">
        <ui:icon-tile :icon="$component->icon" :color="$group->color" size="lg" />
        <native:column class="flex-1 gap-1">
            <native:text class="text-xs font-semibold text-theme-ui-muted-foreground">{{ strtoupper($group->label) }}</native:text>
            <ui:h3>{{ $component->name }}</ui:h3>
        </native:column>
        @if ($isNew)
            <ui:badge>New</ui:badge>
        @elseif (filled($updateNote))
            <ui:badge variant="secondary">Updated</ui:badge>
        @endif
    </native:row>
    <ui:p class="text-theme-ui-muted-foreground">{{ $component->description }}</ui:p>
</native:column>

@if (filled($updateNote))
    <ui:alert icon="info">
        <ui:alert-title>Updated in {{ $viewingVersion }}</ui:alert-title>
        <ui:alert-description>{{ $updateNote }}</ui:alert-description>
    </ui:alert>
@endif
