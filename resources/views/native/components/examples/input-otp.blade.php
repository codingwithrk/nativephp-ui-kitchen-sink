@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    {{-- hides the typed digits until nativephp-ui fixes text-transparent on bare-text-input (see errors-1.1.0.md). --}}
    <ui:example title="Input OTP" description="One native input under the boxes, so paste and SMS autofill work.">
        <ui:input-otp ref="code" native:model="code" @submit="verify" />
    </ui:example>

    <ui:example title="With a separator">
        <ui:input-otp ref="code-separated" native:model="codeWithSeparator" separator="3" />
    </ui:example>

    <ui:example title="Length and invalid" description="Any 4-digit PIN except 1234 shows the invalid state.">
        <ui:input-otp ref="pin" native:model="pin" length="4" :invalid="$isWrongPin" />
        @if ($isWrongPin)
            <native:text class="text-sm text-theme-ui-destructive">That PIN is incorrect.</native:text>
        @endif
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
