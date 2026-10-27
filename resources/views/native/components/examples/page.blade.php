@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Settings screen" align="stretch" class="p-0">
        <native:column class="w-full gap-6 p-4">
            <native:column class="gap-2">
                <ui:h2>Settings</ui:h2>
                <ui:muted>Manage your account preferences.</ui:muted>
            </native:column>

            <ui:item-group>
                <ui:item icon="person" title="Profile" description="Name, photo, bio" chevron />
                <ui:item icon="notifications" title="Notifications" chevron />
                <ui:item icon="lock" title="Privacy" chevron />
            </ui:item-group>

            <ui:button variant="outline" icon="logout">Sign out</ui:button>
        </native:column>
    </ui:example>

    <ui:example title="Fixed, centered screen" description="A screen that doesn't scroll, such as a sign-in or splash screen. Your class goes on the inner column, so layout utilities apply to the content." align="stretch" class="h-[320] justify-center">
        <native:column class="w-full gap-6">
            <native:column class="gap-2">
                <ui:h3 class="text-center">Welcome back</ui:h3>
                <ui:muted class="text-center">Sign in to continue</ui:muted>
            </native:column>
            <ui:button>Continue with email</ui:button>
        </native:column>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
