@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Pagination">
        <ui:pagination native:model="page" :total="12" />
        <ui:muted>Page {{ $page }} of 12</ui:muted>
    </ui:example>

    <ui:example title="Controlled, more siblings">
        <ui:pagination :value="$controlledPage" @change="goToPage" :total="20" :siblings="2" />
        <ui:muted>Page {{ $controlledPage }} of 20</ui:muted>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
