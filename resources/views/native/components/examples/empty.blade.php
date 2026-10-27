@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="No projects">
        <ui:empty icon="folder" title="No projects yet" description="You haven't created any projects yet. Get started by creating your first project.">
            <ui:button>Create project</ui:button>
            <ui:button variant="link">Import project</ui:button>
        </ui:empty>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
