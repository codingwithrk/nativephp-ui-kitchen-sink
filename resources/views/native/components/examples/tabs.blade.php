@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Account settings" align="stretch" class="p-4">
        <ui:tabs native:model="tab">
            <ui:tabs-list>
                <ui:tabs-trigger ref="tab-account" value="account">Account</ui:tabs-trigger>
                <ui:tabs-trigger ref="tab-password" value="password">Password</ui:tabs-trigger>
            </ui:tabs-list>
            <ui:tabs-content value="account">
                <ui:card>
                    <ui:card-header>
                        <ui:card-title>Account</ui:card-title>
                        <ui:card-description>Make changes to your account here.</ui:card-description>
                    </ui:card-header>
                    <ui:card-content>
                        <ui:field label="Name">
                            <ui:input ref="name" native:model="name" />
                        </ui:field>
                    </ui:card-content>
                    <ui:card-footer>
                        <ui:button>Save changes</ui:button>
                    </ui:card-footer>
                </ui:card>
            </ui:tabs-content>
            <ui:tabs-content value="password">
                <ui:card>
                    <ui:card-header>
                        <ui:card-title>Password</ui:card-title>
                        <ui:card-description>Change your password here.</ui:card-description>
                    </ui:card-header>
                    <ui:card-content>
                        <ui:field label="New password">
                            <ui:input ref="new-password" native:model="newPassword" placeholder="••••••••" secure />
                        </ui:field>
                    </ui:card-content>
                    <ui:card-footer>
                        <ui:button>Save password</ui:button>
                    </ui:card-footer>
                </ui:card>
            </ui:tabs-content>
        </ui:tabs>
    </ui:example>

    <ui:example title="With icons" align="stretch">
        <ui:tabs native:model="view">
            <ui:tabs-list>
                <ui:tabs-trigger ref="view-home" value="home" icon="home">Home</ui:tabs-trigger>
                <ui:tabs-trigger ref="view-inbox" value="inbox" icon="inbox">Inbox</ui:tabs-trigger>
                <ui:tabs-trigger ref="view-settings" value="settings" icon="settings">Settings</ui:tabs-trigger>
            </ui:tabs-list>
        </ui:tabs>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
