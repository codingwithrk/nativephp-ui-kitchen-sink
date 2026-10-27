@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Combobox" description="Tap the trigger, then search. Choosing the selected option again clears it." align="stretch">
        <ui:field label="Framework">
            <ui:combobox ref="fw" native:model="framework" placeholder="Select framework…"
                search-placeholder="Search framework…" empty="No framework found."
                :options="['laravel' => 'Laravel', 'livewire' => 'Livewire', 'nativephp' => 'NativePHP', 'filament' => 'Filament', 'inertia' => 'Inertia']" />
        </ui:field>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
