@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="16 / 9" description="Keeps its content at a fixed width-to-height ratio." align="stretch">
        <ui:aspect-ratio ratio="16/9" class="overflow-hidden rounded-[12]">
            <native:image src="https://images.unsplash.com/photo-1588345921523-c2dcdb7f1dcd?w=800&dpr=2&q=80" class="w-full h-full object-cover" />
        </ui:aspect-ratio>
    </ui:example>

    <ui:example title="Square" align="stretch">
        <ui:aspect-ratio ratio="1/1" class="bg-theme-ui-primary/15 rounded-[12] items-center justify-center">
            <ui:large class="text-theme-ui-primary">1 : 1</ui:large>
        </ui:aspect-ratio>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
