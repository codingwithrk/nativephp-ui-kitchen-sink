@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Confirm dialog" description="Tap Delete project. Swiping the sheet down sets the bound property back to false." align="stretch" class="h-[220] justify-center">
        <native:column class="gap-2">
            <ui:h4>Project settings</ui:h4>
            <ui:muted>Danger zone</ui:muted>
        </native:column>
        <ui:button ref="open-delete" variant="destructive" icon="delete" @press="confirmDelete">Delete project</ui:button>
    </ui:example>

    @includeWhen($component->hasTag('dialog-trigger'), 'native.components.examples.partials.dialog-parts')

    <ui:example title="Controlled sheet with detents" description="Bind open and handle close yourself. Attributes the sheet doesn't use, such as detents, go to the native bottom sheet." align="stretch" class="h-[220] justify-center">
        <native:column class="gap-2">
            <ui:h4>Products</ui:h4>
            <ui:muted>128 results</ui:muted>
        </native:column>
        <ui:button ref="open-filters" variant="outline" icon="settings" @press="openFilters">Filters</ui:button>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>

<ui:dialog ref="delete-dialog" native:model="isConfirmingDelete">
    <ui:dialog-header>
        <ui:dialog-title>Delete project?</ui:dialog-title>
        <ui:dialog-description>This action cannot be undone. This will permanently delete the project and its data.</ui:dialog-description>
    </ui:dialog-header>
    <ui:dialog-footer>
        <ui:button ref="confirm-delete" variant="destructive" @press="deleteProject">Delete</ui:button>
        <ui:button ref="cancel-delete" variant="outline" @press="cancelDelete">Cancel</ui:button>
    </ui:dialog-footer>
</ui:dialog>

<ui:sheet ref="filters-sheet" :open="$isFiltersOpen" @close="closeFilters" detents="medium,large">
    <ui:dialog-header>
        <ui:dialog-title>Filters</ui:dialog-title>
    </ui:dialog-header>
    <ui:switch ref="in-stock" native:model="isInStockOnly">In stock only</ui:switch>
    <ui:radio-group native:model="sort">
        <ui:radio-group-item ref="sort-new" value="new">Newest first</ui:radio-group-item>
        <ui:radio-group-item ref="sort-price" value="price">Price: low to high</ui:radio-group-item>
    </ui:radio-group>
    <ui:button ref="show-results" @press="closeFilters">Show results</ui:button>
</ui:sheet>
