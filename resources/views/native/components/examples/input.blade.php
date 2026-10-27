@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Default" align="stretch">
        <ui:input ref="email" native:model="email" placeholder="Email" keyboard="email" />
    </ui:example>

    <ui:example title="With icon" align="stretch">
        <ui:input ref="query" native:model.debounce.300ms="query" icon="search" placeholder="Search projects…" />
    </ui:example>

    <ui:example title="Password" description="Native input attributes are forwarded as-is, including secure, revealable and max-length." align="stretch">
        <ui:input ref="password" native:model="password" placeholder="Password" secure revealable />
    </ui:example>

    <ui:example title="Invalid and disabled" align="stretch">
        <ui:input ref="name" native:model="name" placeholder="Name" invalid />
        <ui:input native:model="lockedEmail" disabled />
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
