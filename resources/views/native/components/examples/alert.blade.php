@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Default" align="stretch">
        <ui:alert icon="info">
            <ui:alert-title>Heads up!</ui:alert-title>
            <ui:alert-description>You can add components to your app using the CLI.</ui:alert-description>
        </ui:alert>
    </ui:example>

    <ui:example title="Destructive" description="The title, description and icon all pick up the destructive color from the enclosing alert." align="stretch">
        <ui:alert variant="destructive" icon="warning">
            <ui:alert-title>Payment failed</ui:alert-title>
            <ui:alert-description>Check your card details and try again.</ui:alert-description>
        </ui:alert>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
