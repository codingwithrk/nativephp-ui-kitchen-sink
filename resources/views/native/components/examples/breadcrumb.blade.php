@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Breadcrumb" description="Items navigate; the last one is the current page.">
        <ui:breadcrumb>
            <ui:breadcrumb-item @navigate='/'>Home</ui:breadcrumb-item>
            <ui:breadcrumb-ellipsis />
            <ui:breadcrumb-item @navigate='/components'>Components</ui:breadcrumb-item>
            <ui:breadcrumb-page>Breadcrumb</ui:breadcrumb-page>
        </ui:breadcrumb>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
