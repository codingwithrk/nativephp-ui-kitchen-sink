{{-- Needs nativephp-ui 1.1.0: dialog-trigger and dialog-close. --}}
    <ui:example title="Trigger and close parts" description="dialog-trigger stays on the screen and opens the dialog; dialog-close closes it. No open or close methods needed." align="stretch">
        <ui:dialog ref="parts-dialog" native:model="isConfirmingWithParts">
            <ui:dialog-trigger>
                <ui:button ref="open-parts" variant="destructive" icon="delete" class="w-full">Delete project</ui:button>
            </ui:dialog-trigger>
            <ui:dialog-header>
                <ui:dialog-title>Delete project?</ui:dialog-title>
                <ui:dialog-description>This action cannot be undone.</ui:dialog-description>
            </ui:dialog-header>
            <ui:dialog-footer>
                <ui:button variant="destructive" @press="deleteProject">Delete</ui:button>
                <ui:dialog-close class="w-full">
                    <ui:button ref="close-parts" variant="outline">Cancel</ui:button>
                </ui:dialog-close>
            </ui:dialog-footer>
        </ui:dialog>
    </ui:example>
