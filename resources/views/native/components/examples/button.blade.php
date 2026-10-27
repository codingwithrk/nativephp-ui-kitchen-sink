@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Variants">
        <native:row class="w-full flex-wrap items-center justify-center gap-2">
            <ui:button>Button</ui:button>
            <ui:button variant="secondary">Secondary</ui:button>
            <ui:button variant="destructive">Destructive</ui:button>
            <ui:button variant="outline">Outline</ui:button>
            <ui:button variant="ghost">Ghost</ui:button>
            <ui:button variant="link">Link</ui:button>
        </native:row>
    </ui:example>

    <ui:example title="Sizes">
        <native:row class="w-full flex-wrap items-center justify-center gap-2">
            <ui:button size="sm" variant="outline">Small</ui:button>
            <ui:button variant="outline">Default</ui:button>
            <ui:button size="lg" variant="outline">Large</ui:button>
            <ui:button size="icon-sm" variant="outline" icon="add" a11y-label="Add" />
            <ui:button size="icon" variant="outline" icon="add" a11y-label="Add" />
            <ui:button size="icon-lg" variant="outline" icon="add" a11y-label="Add" />
        </native:row>
    </ui:example>

    <ui:example title="With icons" description="icon goes before the label and icon-trailing after it.">
        <native:row class="w-full flex-wrap items-center justify-center gap-2">
            <ui:button variant="outline" size="sm" icon="add">New branch</ui:button>
            <ui:button icon-trailing="arrow_forward">Continue</ui:button>
            <ui:button variant="ghost" size="icon" icon="more_horiz" a11y-label="More" />
        </native:row>
    </ui:example>

    <ui:example title="Loading and disabled" description="While disabled or loading, the button dims and its press handler is removed. Tap Save changes to try it.">
        <native:row class="items-center gap-2">
            <ui:button ref="save" :loading="$isSaving" @press="save">{{ $isSaving ? 'Saving…' : 'Save changes' }}</ui:button>
            <ui:button variant="outline" disabled>Disabled</ui:button>
        </native:row>
    </ui:example>

    <ui:example title="Dynamic variant" description="Any prop can be bound with a colon, for example a destructive variant while confirming.">
        <native:row class="gap-2">
            <ui:button>Confirm</ui:button>
            <ui:button variant="destructive">Confirm</ui:button>
        </native:row>
    </ui:example>

    <ui:example title="Navigation and custom classes" description="Attributes the button doesn't use itself are forwarded to the native element. Your class is applied last, so it wins.">
        <native:column class="w-full items-center gap-2">
            <ui:button class="h-12 w-full">Get started</ui:button>
            <ui:button variant="link">Terms of service</ui:button>
        </native:column>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
