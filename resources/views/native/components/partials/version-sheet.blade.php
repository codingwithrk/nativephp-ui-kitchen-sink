{{-- Place at the end of the screen's view, outside <ui:page>. --}}
<ui:sheet ref="version-sheet" native:model="isVersionSheetOpen" detents="medium">
    <ui:dialog-header>
        <ui:dialog-title>Docs version</ui:dialog-title>
        <ui:dialog-description>Browse the components as they are in an older release. New and Updated badges follow the version you pick.</ui:dialog-description>
    </ui:dialog-header>
    <ui:radio-group native:model="viewedVersion">
        @foreach ($versionOptions as $option)
            <ui:radio-group-item ref="version-{{ $option['version'] }}" native:key="version-{{ $option['version'] }}" :value="$option['version']" class="p-4 border border-theme-ui-border rounded-[10]">v{{ $option['version'] }} · {{ $option['status'] === 'beta' ? 'Beta' : 'Released '.$option['released'] }}</ui:radio-group-item>
        @endforeach
    </ui:radio-group>
</ui:sheet>
