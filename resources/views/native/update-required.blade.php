<ui:page :scroll="false" class="flex-1 justify-center gap-8 safe-area">
    <native:column class="w-full items-center gap-5">
        <native:column class="w-20 h-20 items-center justify-center bg-theme-ui-primary/15 rounded-[24]">
            <native:icon name="system_update" ios="arrow.down.circle.fill" :size="40" class="text-theme-ui-primary" />
        </native:column>
        <native:column class="w-full items-center gap-2">
            <ui:h3 class="text-center">Update required</ui:h3>
            <ui:p class="text-center text-theme-ui-muted-foreground">{{ $message ?? 'A new version of '.config('app.name').' is available. Update to keep using the app.' }}</ui:p>
        </native:column>
        @if ($latestVersion !== '')
            <native:row class="items-center gap-2">
                <ui:badge variant="outline">v{{ $installedVersion }}</ui:badge>
                <native:icon name="arrow_forward" ios="arrow.right" :size="14" class="text-theme-ui-muted-foreground" />
                <ui:badge>v{{ $latestVersion }}</ui:badge>
            </native:row>
        @endif
    </native:column>

    <native:column class="w-full gap-3">
        <ui:button ref="update-now" class="w-full h-12" icon="download" :disabled="$storeUrl === ''" @press="openStore">Update on {{ $storeName }}</ui:button>
        <ui:button ref="check-again" variant="ghost" class="w-full" @press="checkAgain">I've updated — check again</ui:button>
    </native:column>
</ui:page>
