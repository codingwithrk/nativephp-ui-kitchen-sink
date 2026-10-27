@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Carousel" description="Material 3 carousel on Android, a snapping strip on iOS." align="stretch" class="px-0">
        <ui:carousel item-width="240" item-spacing="12">
            @foreach ($slides as $slide)
                <ui:carousel-item native:key="slide-{{ $loop->index }}" class="p-6 gap-2">
                    <ui:large>{{ $slide['title'] }}</ui:large>
                    <ui:muted>{{ $slide['text'] }}</ui:muted>
                </ui:carousel-item>
            @endforeach
        </ui:carousel>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
