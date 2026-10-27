@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Collapsible" align="stretch">
        <ui:collapsible native:model="showsRepositories">
            <ui:collapsible-trigger ref="repos">@codingwithrk starred 2 repositories</ui:collapsible-trigger>
            <ui:collapsible-content>
                <ui:code>codingwithrk/nativephp-ui</ui:code>
                <ui:code>laravel/boost</ui:code>
            </ui:collapsible-content>
        </ui:collapsible>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
