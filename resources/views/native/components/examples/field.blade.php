@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="With validation" description="The error line only renders when it's filled. Type a valid address to clear it." align="stretch">
        <ui:field label="Email" description="We'll never share it." :error="$emailError">
            <ui:input ref="email" native:model="email" keyboard="email" icon="mail" placeholder="you@example.com" :invalid="filled($emailError)" />
        </ui:field>
    </ui:example>

    <ui:example title="Wrapping any control" align="stretch">
        <ui:field label="Bio" description="Max 160 characters.">
            <ui:textarea ref="bio" native:model="bio" placeholder="Tell us about yourself" max-length="160" />
        </ui:field>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
