@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Attachments" description="Tap to open, or remove with the close button." align="stretch">
        @forelse ($attachments as $attachment)
            <ui:attachment ref="attachment-{{ $attachment['id'] }}" native:key="att-{{ $attachment['id'] }}" :name="$attachment['name']" :size="$attachment['size']" @press="open({{ $attachment['id'] }})" @remove="detach({{ $attachment['id'] }})" />
        @empty
            <ui:muted class="text-center">All attachments removed.</ui:muted>
        @endforelse
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
