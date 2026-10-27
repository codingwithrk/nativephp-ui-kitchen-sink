{{-- Needs the PicksDocsVersion trait and its versionPickerData() in the view. --}}
<native:pressable ref="version-picker" @press="openVersionSheet" a11y-label="Change docs version">
    <native:row class="self-start items-center gap-2 px-3 py-[6] border border-theme-ui-border bg-theme-ui-card rounded-full">
        <native:text class="text-sm font-medium text-theme-ui-foreground">v{{ $viewingVersion }}</native:text>
        @if ($viewingStatus === 'beta')
            <native:row class="px-[6] py-[1] bg-theme-ui-primary/15 rounded-full">
                <native:text class="text-[10px] font-semibold text-theme-ui-primary">BETA</native:text>
            </native:row>
        @endif
        <native:icon name="expand_more" ios="chevron.down" :size="12" class="text-theme-ui-muted-foreground" />
    </native:row>
</native:pressable>
