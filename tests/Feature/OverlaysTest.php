<?php

use App\NativeComponents\Overlays;
use Native\Mobile\Testing\Native;

it('lists active projects and hides archived ones', function () {
    Native::test(Overlays::class)
        ->assertSee('Marketing site')
        ->assertDontSee('Legacy dashboard');
});

it('deletes a project after confirming in the dialog', function () {
    Native::test(Overlays::class)
        ->tap('delete-2')
        ->assertSet('isConfirmingDelete', true)
        ->assertSee('Delete Mobile app?')
        ->tap('confirm-delete')
        ->assertSet('isConfirmingDelete', false)
        ->assertDontSee('Mobile app');
});

it('cancels the delete dialog when the sheet is dismissed', function () {
    Native::test(Overlays::class)
        ->tap('delete-1')
        ->dismissSheet('delete-dialog')
        ->assertSet('isConfirmingDelete', false)
        ->assertSee('Marketing site');
});

it('shows the empty state when every project is gone, then restores them', function () {
    Native::test(Overlays::class)
        ->set('projects', [])
        ->assertSee('No projects to show')
        ->tap('restore')
        ->assertSee('Marketing site');
});

it('applies filters from the sheet', function () {
    Native::test(Overlays::class)
        ->tap('open-filters')
        ->assertSet('isFiltersOpen', true)
        ->tap('show-archived')
        ->tap('sort-name')
        ->tap('apply-filters')
        ->assertSet('isFiltersOpen', false)
        ->assertSee('Legacy dashboard');
});

it('opens and dismisses the share drawer', function () {
    Native::test(Overlays::class)
        ->tap('open-share')
        ->assertSet('isShareDrawerOpen', true)
        ->dismissSheet('share-drawer')
        ->assertSet('isShareDrawerOpen', false);
});
