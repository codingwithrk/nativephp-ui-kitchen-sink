<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class TableExample extends ExampleScreen
{
    /** Its examples show toasts, which the banner would cover. */
    protected bool $hidesBannerAd = true;

    public function open(int $invoiceId): void
    {
        $this->toast('Invoice INV00'.$invoiceId);
    }

    /**
     * @return array{invoices: list<array{id: int, number: string, status: string, total: string}>}
     */
    protected function viewData(): array
    {
        return [
            'invoices' => [
                ['id' => 1, 'number' => 'INV001', 'status' => 'Paid', 'total' => '$250.00'],
                ['id' => 2, 'number' => 'INV002', 'status' => 'Pending', 'total' => '$150.00'],
                ['id' => 3, 'number' => 'INV003', 'status' => 'Unpaid', 'total' => '$350.00'],
                ['id' => 4, 'number' => 'INV004', 'status' => 'Paid', 'total' => '$450.00'],
            ],
        ];
    }
}
