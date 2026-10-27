@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Profile placeholder">
        <native:row class="items-center gap-4">
            <ui:skeleton class="h-12 w-12 rounded-full" />
            <native:column class="gap-2">
                <ui:skeleton class="h-4 w-[200]" />
                <ui:skeleton class="h-4 w-[160]" />
            </native:column>
        </native:row>
    </ui:example>

    <ui:example title="Card placeholder" description="NativePHP sizes are in points, so w-[250] means 250pt.">
        <native:column class="gap-3">
            <ui:skeleton class="h-[125] w-[250] rounded-[14]" />
            <ui:skeleton class="h-4 w-[250]" />
            <ui:skeleton class="h-4 w-[200]" />
        </native:column>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
