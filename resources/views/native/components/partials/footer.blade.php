<native:column class="w-full gap-3 pt-4">
    <ui:section-header title="Tags" :description="count($component->tags).' '.str('tag')->plural(count($component->tags)).' in this component'" />
    <native:row class="w-full gap-2 flex-wrap">
        @foreach ($component->tags as $tagName)
            <ui:code>ui:{{ $tagName }}</ui:code>
        @endforeach
    </native:row>
</native:column>

@if (count($related) > 0)
    <native:column class="w-full gap-3">
        <ui:section-header :title="'More in '.$group->label" />
        <ui:nav-list>
            @foreach ($related as $sibling)
                @if (! $loop->first)
                    <ui:separator />
                @endif
                <ui:nav-row
                    ref="related-{{ $sibling->slug }}"
                    native:key="related-{{ $sibling->slug }}"
                    :icon="$sibling->icon"
                    :color="$group->color"
                    :title="$sibling->name"
                    :description="$sibling->description"
                    :badge="$siblingBadges[$sibling->slug] ?? null"
                    @navigate.replace="$sibling->url()"
                />
            @endforeach
        </ui:nav-list>
    </native:column>
@endif

@include('native.partials.banner-ad-space')
