@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Type scale" align="stretch">
        <native:column class="w-full gap-4">
            <ui:h1>Taxing Laughter</ui:h1>
            <ui:h2>The People of the Kingdom</ui:h2>
            <ui:h3>The Joke Tax</ui:h3>
            <ui:h4>People stopped telling jokes</ui:h4>
            <ui:lead>A modal dialog that interrupts the user with important content.</ui:lead>
            <ui:p>The king thought long and hard, and finally came up with a brilliant plan.</ui:p>
            <ui:large>Are you absolutely sure?</ui:large>
            <ui:small>Email address</ui:small>
            <ui:muted>Enter your email address.</ui:muted>
            <ui:code>php artisan native:run</ui:code>
        </native:column>
    </ui:example>

    <ui:example title="Dynamic text" description="Children are ordinary Blade, so echoes and directives work as usual." align="stretch">
        <native:column class="w-full gap-2">
            <ui:h3>Hello, Rajkumar</ui:h3>
            <ui:muted>You have 3 unread {{ str('message')->plural(3) }}.</ui:muted>
        </native:column>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
