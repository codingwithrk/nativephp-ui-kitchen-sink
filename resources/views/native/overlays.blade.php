<native:top-bar title="Projects" subtitle="Template" back>
    <native:top-bar-action id="filters" label="Filters" icon="tune" @tap="openFilters" />
</native:top-bar>

<ui:page>
    {{-- Item list with a confirm dialog --}}
    <native:column class="w-full gap-3">
        <native:row class="w-full items-center justify-between">
            <ui:h3>Projects</ui:h3>
            <ui:badge variant="secondary">{{ count($visibleProjects) }}</ui:badge>
        </native:row>

        @if (count($visibleProjects) > 0)
            <ui:item-group>
                @foreach ($visibleProjects as $project)
                    <ui:item variant="outline" icon="folder" :title="$project['name']" :description="$project['status']" native:key="project-{{ $project['id'] }}">
                        <ui:button ref="delete-{{ $project['id'] }}" variant="ghost" size="icon-sm" icon="delete" a11y-label="Delete {{ $project['name'] }}" @press="confirmDelete({{ $project['id'] }})" />
                    </ui:item>
                @endforeach
            </ui:item-group>
        @else
            <ui:empty icon="folder_off" title="No projects to show" description="Restore the sample projects to keep exploring.">
                <ui:button ref="restore" icon="restore" @press="restoreProjects">Restore projects</ui:button>
            </ui:empty>
        @endif
    </native:column>

    <ui:separator />

    {{-- Triggers --}}
    <native:column class="w-full gap-3">
        <ui:h3>Sheet &amp; Drawer</ui:h3>
        <ui:muted>Presented as native bottom sheets — swipe down to dismiss.</ui:muted>
        <ui:button ref="open-filters" variant="outline" icon="tune" class="w-full" @press="openFilters">Open filters sheet</ui:button>
        <ui:button ref="open-share" variant="secondary" icon="share" class="w-full" @press="openShareDrawer">Open share drawer</ui:button>
    </native:column>

    <ui:separator />

    {{-- Settings-style list --}}
    <native:column class="w-full gap-3">
        <ui:h3>Item</ui:h3>
        <ui:item-group>
            <ui:item icon="person" title="Profile" description="Name, photo and bio" chevron @navigate='/templates/sign-up' />
            <ui:item icon="tune" title="Preferences" description="Toggles and tabs" chevron @navigate='/templates/preferences' />
            <ui:item variant="muted" icon="info" title="Version" description="NativePHP UI demo 1.0" />
        </ui:item-group>
    </native:column>

    @include('native.partials.banner-ad-space')
</ui:page>

{{-- Confirm dialog --}}
<ui:dialog ref="delete-dialog" :open="$isConfirmingDelete" @close="cancelDelete">
    <ui:dialog-header>
        <ui:dialog-title>Delete {{ $pendingProject['name'] ?? 'project' }}?</ui:dialog-title>
        <ui:dialog-description>This action cannot be undone. The project and its deployments will be permanently removed.</ui:dialog-description>
    </ui:dialog-header>
    <ui:dialog-footer>
        <ui:button ref="confirm-delete" variant="destructive" @press="deleteProject">Delete</ui:button>
        <ui:button ref="cancel-delete" variant="outline" @press="cancelDelete">Cancel</ui:button>
    </ui:dialog-footer>
</ui:dialog>

{{-- Filters sheet (controlled) --}}
<ui:sheet ref="filters-sheet" :open="$isFiltersOpen" @close="closeFilters" detents="medium,large">
    <ui:dialog-header>
        <ui:dialog-title>Filters</ui:dialog-title>
        <ui:dialog-description>Choose how projects are listed.</ui:dialog-description>
    </ui:dialog-header>
    <ui:label>Sort by</ui:label>
    <ui:radio-group native:model="sortBy">
        <ui:radio-group-item ref="sort-recent" value="recent">Most recent</ui:radio-group-item>
        <ui:radio-group-item ref="sort-name" value="name">Name</ui:radio-group-item>
    </ui:radio-group>
    <ui:switch ref="show-archived" native:model="showsArchived">Show archived</ui:switch>
    <ui:button ref="apply-filters" class="w-full" @press="closeFilters">Apply</ui:button>
</ui:sheet>

{{-- Share drawer (two-way bound) --}}
<ui:drawer ref="share-drawer" native:model="isShareDrawerOpen">
    <ui:dialog-header>
        <ui:dialog-title>Share project</ui:dialog-title>
        <ui:dialog-description>Anyone with the link can view.</ui:dialog-description>
    </ui:dialog-header>
    <ui:input value="https://example.com/p/demo" icon="link" />
    <ui:dialog-footer>
        <ui:button class="w-full" icon="content_copy" @press="closeShareDrawer">Copy link</ui:button>
    </ui:dialog-footer>
</ui:drawer>
