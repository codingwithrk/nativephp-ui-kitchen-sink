<native:top-bar title="Sign up" subtitle="Template" back />

<ui:page>
    @if ($isSubmitted)
        <ui:alert icon="check_circle">
            <ui:alert-title>Account created</ui:alert-title>
            <ui:alert-description>Welcome aboard, {{ $name }}! You're on the {{ ucfirst($plan) }} plan.</ui:alert-description>
        </ui:alert>
    @elseif (filled($fieldErrors))
        <ui:alert variant="destructive" icon="error">
            <ui:alert-title>Please fix {{ count($fieldErrors) }} {{ str('error')->plural(count($fieldErrors)) }}</ui:alert-title>
            <ui:alert-description>Check the highlighted fields below.</ui:alert-description>
        </ui:alert>
    @endif

    <ui:card>
        <ui:card-header>
            <ui:card-title>Create an account</ui:card-title>
            <ui:card-description>Enter your details below to get started.</ui:card-description>
        </ui:card-header>
        <ui:card-content>
            <ui:field label="Name" :error="$fieldErrors['name'] ?? null">
                <ui:input ref="name" native:model="name" placeholder="Jane Doe" icon="person" :invalid="isset($fieldErrors['name'])" />
            </ui:field>

            <ui:field label="Email" description="We'll never share your email." :error="$fieldErrors['email'] ?? null">
                <ui:input ref="email" native:model="email" placeholder="you@example.com" keyboard="email" icon="mail" :invalid="isset($fieldErrors['email'])" />
            </ui:field>

            <ui:field label="Password" description="At least 8 characters." :error="$fieldErrors['password'] ?? null">
                <ui:input ref="password" native:model="password" placeholder="Password" secure revealable icon="lock" :invalid="isset($fieldErrors['password'])" />
            </ui:field>

            <ui:field label="Bio">
                <ui:textarea ref="bio" native:model.debounce.300ms="bio" placeholder="Tell us a little about yourself" />
            </ui:field>
        </ui:card-content>
    </ui:card>

    <ui:card>
        <ui:card-header>
            <ui:card-title>Plan</ui:card-title>
            <ui:card-description>You can change this at any time.</ui:card-description>
        </ui:card-header>
        <ui:card-content>
            <ui:radio-group native:model="plan">
                <ui:radio-group-item ref="plan-free" value="free">Free — 1 project</ui:radio-group-item>
                <ui:radio-group-item ref="plan-pro" value="pro">Pro — unlimited projects</ui:radio-group-item>
                <ui:radio-group-item ref="plan-team" value="team">Team — shared workspaces</ui:radio-group-item>
            </ui:radio-group>
        </ui:card-content>
    </ui:card>

    <ui:card>
        <ui:card-content>
            <ui:switch ref="marketing" native:model="wantsMarketingEmails">Send me product updates</ui:switch>
            <ui:separator />
            <ui:checkbox ref="terms" native:model="hasAcceptedTerms">Accept terms and conditions</ui:checkbox>
            @isset($fieldErrors['hasAcceptedTerms'])
                <native:text class="text-sm text-theme-ui-destructive">{{ $fieldErrors['hasAcceptedTerms'] }}</native:text>
            @endisset
        </ui:card-content>
        <ui:card-footer>
            <ui:button ref="reset" variant="outline" @press="resetForm">Reset</ui:button>
            <ui:button ref="submit" class="flex-1" @press="submit">Create account</ui:button>
        </ui:card-footer>
    </ui:card>

    @include('native.partials.banner-ad-space')
</ui:page>
