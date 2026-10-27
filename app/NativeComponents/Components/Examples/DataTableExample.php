<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class DataTableExample extends ExampleScreen
{
    /** Its examples show toasts, which the banner would cover. */
    protected bool $hidesBannerAd = true;

    public function openCustomer(mixed $customerId): void
    {
        $this->toast('Customer #'.$customerId);
    }

    /**
     * @return array{customers: list<array{id: int, name: string, spent: string}>}
     */
    protected function viewData(): array
    {
        return [
            'customers' => [
                ['id' => 1, 'name' => 'Olivia Martin', 'spent' => '$1,999.00'],
                ['id' => 2, 'name' => 'Jackson Lee', 'spent' => '$39.00'],
                ['id' => 3, 'name' => 'Isabella Nguyen', 'spent' => '$299.00'],
                ['id' => 4, 'name' => 'William Kim', 'spent' => '$99.00'],
                ['id' => 5, 'name' => 'Sofia Davis', 'spent' => '$450.00'],
                ['id' => 6, 'name' => 'Liam Johnson', 'spent' => '$725.00'],
                ['id' => 7, 'name' => 'Emma Brown', 'spent' => '$1,250.00'],
            ],
        ];
    }
}
