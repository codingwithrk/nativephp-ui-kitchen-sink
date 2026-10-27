<?php

use App\NativeComponents\Gallery;
use Native\Mobile\Testing\Native;

it('renders the component gallery', function () {
    Native::test(Gallery::class)
        ->assertSee('Build native, look shadcn.')
        ->assertSee('Revenue')
        ->assertSee('$45,231')
        ->assertSee('Heads up!')
        ->assertSee('Notifications');
});

it('steps the progress bar within bounds', function () {
    Native::test(Gallery::class)
        ->tap('progress-up')->assertSet('progress', 50)
        ->set('progress', 100)
        ->tap('progress-up')->assertSet('progress', 100)
        ->set('progress', 0)
        ->tap('progress-down')->assertSet('progress', 0);
});

it('shows a loading button while deploying', function () {
    Native::test(Gallery::class)
        ->tap('deploy')
        ->assertSet('isDeploying', true)
        ->assertSet('deployCount', 1)
        ->assertSee('Stop')
        ->assertSee('1 deploys');
});

it('swaps the skeleton for loaded content', function () {
    Native::test(Gallery::class)
        ->assertDontSee('Loaded profile preview')
        ->tap('toggle-preview')
        ->assertSee('Loaded profile preview');
});
