@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Radio group">
        <ui:radio-group native:model="plan" class="w-auto">
            <ui:radio-group-item ref="plan-free" value="free">Free</ui:radio-group-item>
            <ui:radio-group-item ref="plan-pro" value="pro">Pro</ui:radio-group-item>
            <ui:radio-group-item ref="plan-team" value="team" :disabled="! $areTeamsEnabled">Team</ui:radio-group-item>
        </ui:radio-group>
    </ui:example>

    <ui:example title="Choice cards" description="Items are ordinary rows, so classes turn them into cards." align="stretch">
        <ui:radio-group native:model="shipping">
            <ui:radio-group-item ref="shipping-standard" value="standard" class="p-4 border border-theme-ui-border rounded-[10]">Standard · 4–10 days</ui:radio-group-item>
            <ui:radio-group-item ref="shipping-express" value="express" class="p-4 border border-theme-ui-border rounded-[10]">Express · 2–5 days</ui:radio-group-item>
        </ui:radio-group>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
