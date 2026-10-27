@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Select" description="Opens a SwiftUI Menu on iOS and a Compose DropdownMenu on Android." align="stretch">
        <ui:select ref="fruit" native:model="fruit" placeholder="Select a fruit"
            :options="['apple' => 'Apple', 'banana' => 'Banana', 'blueberry' => 'Blueberry', 'grapes' => 'Grapes', 'pineapple' => 'Pineapple']" />
    </ui:example>

    <ui:example title="In a field, with validation" align="stretch">
        <ui:field label="Timezone" :error="$timezoneError">
            <ui:select ref="timezone" native:model="timezone" placeholder="Choose a timezone" :options="$timezones" :invalid="filled($timezoneError)" />
        </ui:field>
    </ui:example>

    <ui:example title="Option formats" description="value => label, a plain list, or a list of value and label pairs." align="stretch">
        <ui:select ref="size" native:model="size" size="sm" :options="['S', 'M', 'L', 'XL']" />
        <ui:select ref="plan" :value="$plan" @change="choosePlan"
            :options="[['value' => 1, 'label' => 'Free'], ['value' => 2, 'label' => 'Pro']]" />
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
