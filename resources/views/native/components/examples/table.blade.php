@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Invoices" description="Tap a row." align="stretch" class="px-2">
        <ui:table>
            <ui:table-header>
                <ui:table-row>
                    <ui:table-head class="w-[90]">Invoice</ui:table-head>
                    <ui:table-head>Status</ui:table-head>
                    <ui:table-head align="right">Amount</ui:table-head>
                </ui:table-row>
            </ui:table-header>
            <ui:table-body>
                @foreach ($invoices as $invoice)
                    <ui:table-row ref="invoice-{{ $invoice['id'] }}" native:key="inv-{{ $invoice['id'] }}" @press="open({{ $invoice['id'] }})">
                        <ui:table-cell class="w-[90]">{{ $invoice['number'] }}</ui:table-cell>
                        <ui:table-cell>{{ $invoice['status'] }}</ui:table-cell>
                        <ui:table-cell align="right">{{ $invoice['total'] }}</ui:table-cell>
                    </ui:table-row>
                @endforeach
            </ui:table-body>
            <ui:table-footer>
                <ui:table-row>
                    <ui:table-cell>Total</ui:table-cell>
                    <ui:table-cell align="right">$1,200.00</ui:table-cell>
                </ui:table-row>
            </ui:table-footer>
            <ui:table-caption>A list of your recent invoices.</ui:table-caption>
        </ui:table>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
