@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Label" align="stretch">
        <native:column class="w-full gap-2">
            <ui:label>Username</ui:label>
            <ui:input ref="username" native:model="username" placeholder="@rk" />
        </native:column>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
