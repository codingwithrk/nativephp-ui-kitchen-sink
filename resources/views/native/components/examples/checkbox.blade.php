@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="With label">
        <ui:checkbox ref="terms" native:model="hasAcceptedTerms">Accept terms and conditions</ui:checkbox>
    </ui:example>

    <ui:example title="States">
        <native:column class="gap-3">
            <ui:checkbox ref="newsletter" native:model="wantsNewsletter">Subscribe to newsletter</ui:checkbox>
            <ui:checkbox :checked="true" disabled>Required cookies</ui:checkbox>
            <ui:checkbox ref="agree" native:model="hasAgreedToPolicy" invalid>I agree to the policy</ui:checkbox>
        </native:column>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
