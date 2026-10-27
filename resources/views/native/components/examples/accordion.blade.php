@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Single" description="One item is open at a time. Tapping the open item closes it." align="stretch">
        <ui:accordion native:model="faq">
            <ui:accordion-item ref="faq-shipping" value="shipping" title="Is shipping free?">Yes, on all orders over $50.</ui:accordion-item>
            <ui:accordion-item ref="faq-returns" value="returns" title="What is your return policy?">You can return any item within 30 days.</ui:accordion-item>
            <ui:accordion-item ref="faq-support" value="support" title="How do I contact support?">Email us any time; we reply within a day.</ui:accordion-item>
        </ui:accordion>
    </ui:example>

    <ui:example title="Multiple" description="type multiple binds an array, so several items can stay open at once." align="stretch">
        <ui:accordion type="multiple" native:model="openSections">
            <ui:accordion-item ref="section-notifications" value="notifications" title="Notifications">Choose what you're notified about.</ui:accordion-item>
            <ui:accordion-item ref="section-privacy" value="privacy" title="Privacy">Control who can see your profile.</ui:accordion-item>
        </ui:accordion>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
