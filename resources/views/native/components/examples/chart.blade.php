@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Bar chart" description="Drawn with native views, no web view." align="stretch" class="px-3">
        <ui:card>
            <ui:card-header>
                <ui:card-title>Visitors</ui:card-title>
                <ui:card-description>January – June 2026</ui:card-description>
            </ui:card-header>
            <ui:card-content>
                <ui:chart :data="['Jan' => 186, 'Feb' => 305, 'Mar' => 237, 'Apr' => 73, 'May' => 209, 'Jun' => 214]" />
            </ui:card-content>
        </ui:card>
    </ui:example>

    <ui:example title="Horizontal, with values and colors" align="stretch">
        <ui:chart type="horizontal" show-values :data="[
            ['label' => 'Chrome', 'value' => 275, 'color' => 'chart-1'],
            ['label' => 'Safari', 'value' => 200, 'color' => 'chart-2'],
            ['label' => 'Firefox', 'value' => 187, 'color' => 'chart-3'],
            ['label' => 'Edge', 'value' => 173, 'color' => 'chart-4'],
            ['label' => 'Other', 'value' => 90, 'color' => 'chart-5'],
        ]" />
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
