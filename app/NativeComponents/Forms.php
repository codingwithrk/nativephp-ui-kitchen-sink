<?php

namespace App\NativeComponents;

use App\Showcase\BannerAds;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * A create-account form demonstrating field, input, textarea, switch,
 * checkbox and radio group with two-way `native:model` binding and
 * Laravel validation.
 */
class Forms extends NativeComponent
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $bio = '';

    public string $plan = 'free';

    public bool $wantsMarketingEmails = false;

    public bool $hasAcceptedTerms = false;

    /** @var array<string, string> */
    public array $fieldErrors = [];

    public bool $isSubmitted = false;

    public function updatedEmail(): void
    {
        unset($this->fieldErrors['email']);
    }

    public function updatedName(): void
    {
        unset($this->fieldErrors['name']);
    }

    public function updatedPassword(): void
    {
        unset($this->fieldErrors['password']);
    }

    public function updatedHasAcceptedTerms(): void
    {
        unset($this->fieldErrors['hasAcceptedTerms']);
    }

    public function submit(): void
    {
        $validator = Validator::make([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'hasAcceptedTerms' => $this->hasAcceptedTerms,
        ], [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
            'hasAcceptedTerms' => ['accepted'],
        ], [
            'hasAcceptedTerms.accepted' => 'You must accept the terms to continue.',
        ]);

        $this->fieldErrors = collect($validator->errors()->messages())
            ->map(fn (array $messages): string => $messages[0])
            ->all();

        $this->isSubmitted = $this->fieldErrors === [];
    }

    public function resetForm(): void
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->bio = '';
        $this->plan = 'free';
        $this->wantsMarketingEmails = false;
        $this->hasAcceptedTerms = false;
        $this->fieldErrors = [];
        $this->isSubmitted = false;
    }

    public function render(): View
    {
        return view('native.forms', [
            'hasBannerSpace' => BannerAds::shouldShowOn($this, null),
        ]);
    }
}
