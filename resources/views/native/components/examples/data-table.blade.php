@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Customers" description="Search, sort by tapping a header, and page through rows." align="stretch" class="px-2">
        <ui:data-table ref="customers" searchable :per-page="5" row-key="id" @row-press="openCustomer"
            empty="No customers found."
            :columns="['name' => 'Name', ['key' => 'spent', 'label' => 'Spent', 'align' => 'right']]"
            :rows="$customers" />
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
