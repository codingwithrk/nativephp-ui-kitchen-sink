<?php

use App\NativeComponents\Forms;
use Native\Mobile\Testing\Native;

it('shows validation errors for an empty submission', function () {
    Native::test(Forms::class)
        ->tap('submit')
        ->assertSet('isSubmitted', false)
        ->assertSee('Please fix 4 errors')
        ->assertSee('You must accept the terms to continue.');
});

it('clears a field error once the field changes', function () {
    $screen = Native::test(Forms::class)->tap('submit');

    $screen->input('email', 'rk@example.com');

    expect($screen->get('fieldErrors'))->not->toHaveKey('email');
});

it('creates an account with valid input', function () {
    Native::test(Forms::class)
        ->input('name', 'Jane Doe')
        ->input('email', 'jane@example.com')
        ->input('password', 'secret-password')
        ->tap('plan-pro')
        ->tap('marketing')
        ->tap('terms')
        ->tap('submit')
        ->assertSet('isSubmitted', true)
        ->assertSet('plan', 'pro')
        ->assertSet('wantsMarketingEmails', true)
        ->assertSee("Welcome aboard, Jane Doe! You're on the Pro plan.");
});

it('resets the form', function () {
    Native::test(Forms::class)
        ->input('name', 'Jane Doe')
        ->tap('terms')
        ->tap('reset')
        ->assertSet('name', '')
        ->assertSet('hasAcceptedTerms', false);
});
