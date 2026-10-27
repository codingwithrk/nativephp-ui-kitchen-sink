@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Image and fallback" description="When src is blank, the fallback text is shown on a muted circle.">
        <native:row class="items-center gap-3">
            <ui:avatar src="https://github.com/shadcn.png" fallback="CN" alt="shadcn" />
            <ui:avatar fallback="RK" />
        </native:row>
    </ui:example>

    <ui:example title="Sizes">
        <native:row class="items-center gap-3">
            <ui:avatar size="sm" fallback="SM" />
            <ui:avatar fallback="MD" />
            <ui:avatar size="lg" fallback="LG" />
            <ui:avatar size="xl" fallback="XL" />
        </native:row>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
