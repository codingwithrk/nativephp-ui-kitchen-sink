<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class DialogExample extends ExampleScreen
{
    /** Its examples show toasts, which the banner would cover. */
    protected bool $hidesBannerAd = true;

    public bool $isConfirmingDelete = false;

    public bool $isConfirmingWithParts = false;

    public bool $isFiltersOpen = false;

    public bool $isInStockOnly = true;

    public string $sort = 'new';

    public function confirmDelete(): void
    {
        $this->isConfirmingDelete = true;
    }

    public function cancelDelete(): void
    {
        $this->isConfirmingDelete = false;
    }

    public function deleteProject(): void
    {
        $this->isConfirmingDelete = false;
        $this->isConfirmingWithParts = false;
        $this->toast('Project deleted', 'Not really — this is a demo.', 'destructive');
    }

    public function openFilters(): void
    {
        $this->isFiltersOpen = true;
    }

    public function closeFilters(): void
    {
        $this->isFiltersOpen = false;
    }
}
