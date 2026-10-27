<native:top-bar title="Templates" :subtitle="$templateCount.' ready-made screens'" display-mode="large" />

<ui:page>
    <ui:p class="text-theme-ui-muted-foreground">Full screens built only from nativephp-ui tags, with real state, validation and sheets. Open one to try it.</ui:p>

    @forelse ($categories as $category => $templates)
        <native:column class="w-full gap-3" native:key="category-{{ str($category)->slug() }}">
            <ui:section-header :title="$category" />
            <ui:nav-list>
                @foreach ($templates as $template)
                    @if (! $loop->first)
                        <ui:separator />
                    @endif
                    <ui:nav-row
                        ref="open-{{ $template->slug }}"
                        native:key="template-{{ $template->slug }}"
                        :icon="$template->icon"
                        :title="$template->name"
                        :description="$template->description"
                        @navigate="$template->url()"
                    />
                @endforeach
            </ui:nav-list>
        </native:column>
    @empty
        <ui:empty icon="description" title="No templates yet" description="Templates you add to config/showcase.php show up here." />
    @endforelse

    <native:column class="w-full items-center gap-2 p-6 border border-theme-ui-border rounded-[16]">
        <native:icon name="auto_awesome" ios="sparkles" :size="20" class="text-theme-ui-muted-foreground" />
        <ui:small>More templates are on the way</ui:small>
        <ui:muted class="text-center">Sign-in flows, dashboards, settings and checkout screens.</ui:muted>
    </native:column>
</ui:page>
