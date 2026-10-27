@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Create project" align="stretch" class="p-4">
        <ui:card>
            <ui:card-header>
                <ui:card-title>Create project</ui:card-title>
                <ui:card-description>Deploy your new project in one click.</ui:card-description>
            </ui:card-header>
            <ui:card-content>
                <ui:field label="Name">
                    <ui:input ref="project-name" native:model="projectName" placeholder="Name of your project" />
                </ui:field>
                <ui:switch ref="private" native:model="isPrivate">Private repository</ui:switch>
            </ui:card-content>
            <ui:card-footer>
                <ui:button ref="cancel" variant="outline" @press="cancel">Cancel</ui:button>
                <ui:button ref="deploy" class="flex-1" :loading="$isDeploying" @press="deploy">Deploy</ui:button>
            </ui:card-footer>
        </ui:card>
    </ui:example>

    <ui:example title="With header action" description="A card action inside the header is laid out beside the title block, top-aligned." align="stretch" class="p-4">
        <ui:card>
            <ui:card-header>
                <ui:card-title>Notifications</ui:card-title>
                <ui:card-description>You have 3 unread messages.</ui:card-description>
                <ui:card-action>
                    <ui:button size="sm" variant="outline">View</ui:button>
                </ui:card-action>
            </ui:card-header>
            <ui:card-content>
                <ui:item size="sm" class="p-0" icon="mail" title="Your call has been confirmed." description="1 hour ago" />
                <ui:item size="sm" class="p-0" icon="notifications" title="You have a new message!" description="2 hours ago" />
            </ui:card-content>
        </ui:card>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
