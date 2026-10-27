<native:top-bar title="Dashboard" subtitle="Template" back />

<ui:page>
    {{-- Typography --}}
    <native:column class="w-full gap-2">
        <ui:h1>Build native, look shadcn.</ui:h1>
        <ui:lead>Real SwiftUI and Jetpack Compose views, styled with shadcn's tokens.</ui:lead>
        <native:row class="gap-2 items-center">
            <ui:muted>Press</ui:muted>
            <ui:kbd>⌘K</ui:kbd>
            <ui:muted>to search, or write</ui:muted>
            <ui:code>&lt;ui:button&gt;</ui:code>
        </native:row>
    </native:column>

    {{-- Custom component registered by the app --}}
    <native:column class="w-full gap-3">
        <ui:h4>Custom tag: &lt;ui:stat&gt;</ui:h4>
        <native:row class="w-full gap-3">
            <ui:stat label="Revenue" value="$45,231" change="+20.1%" />
            <ui:stat label="Churn" value="2.4%" change="-0.6%" trend="down" />
        </native:row>
    </native:column>

    <ui:separator />

    {{-- Buttons --}}
    <native:column class="w-full gap-3">
        <ui:h3>Button</ui:h3>
        <native:row class="w-full gap-2 flex-wrap">
            <ui:button>Default</ui:button>
            <ui:button variant="secondary">Secondary</ui:button>
            <ui:button variant="destructive">Destructive</ui:button>
        </native:row>
        <native:row class="w-full gap-2 flex-wrap">
            <ui:button variant="outline">Outline</ui:button>
            <ui:button variant="ghost">Ghost</ui:button>
            <ui:button variant="link">Link</ui:button>
        </native:row>
        <native:row class="w-full gap-2 items-center">
            <ui:button size="sm" icon="add">Small</ui:button>
            <ui:button size="lg" icon-trailing="arrow_forward">Large</ui:button>
            <ui:button variant="outline" size="icon" icon="more_horiz" a11y-label="More" />
        </native:row>
        <ui:button ref="deploy" class="w-full" :loading="$isDeploying" @press="toggleDeploying">
            {{ $isDeploying ? 'Deploying…' : 'Deploy' }}
        </ui:button>
        @if ($isDeploying)
            <ui:button variant="outline" class="w-full" @press="toggleDeploying">Stop</ui:button>
        @endif
    </native:column>

    <ui:separator />

    {{-- Badges & avatars --}}
    <native:column class="w-full gap-3">
        <ui:h3>Badge &amp; Avatar</ui:h3>
        <native:row class="w-full gap-2 flex-wrap">
            <ui:badge>Default</ui:badge>
            <ui:badge variant="secondary">Secondary</ui:badge>
            <ui:badge variant="destructive">Destructive</ui:badge>
            <ui:badge variant="outline" icon="check">Verified</ui:badge>
            <ui:badge variant="secondary">{{ $deployCount }} deploys</ui:badge>
        </native:row>
        <native:row class="gap-3 items-center">
            <ui:avatar fallback="RK" size="sm" />
            <ui:avatar fallback="CN" />
            <ui:avatar fallback="JD" size="lg" />
            <ui:avatar fallback="AB" size="xl" />
        </native:row>
    </native:column>

    <ui:separator />

    {{-- Feedback --}}
    <native:column class="w-full gap-3">
        <ui:h3>Progress, Skeleton &amp; Spinner</ui:h3>
        <native:row class="w-full items-center justify-between">
            <ui:small>Uploading</ui:small>
            <ui:muted>{{ $progress }}%</ui:muted>
        </native:row>
        <ui:progress :value="$progress" />
        <native:row class="w-full gap-2">
            <ui:button ref="progress-down" variant="outline" size="sm" icon="remove" class="flex-1" @press="decreaseProgress">Less</ui:button>
            <ui:button ref="progress-up" variant="outline" size="sm" icon="add" class="flex-1" @press="increaseProgress">More</ui:button>
        </native:row>

        <native:row class="w-full gap-4 items-center p-4 border border-theme-ui-border rounded-[10]">
            @if ($isLoadingPreview)
                <ui:skeleton class="h-12 w-12 rounded-full" />
                <native:column class="flex-1 gap-2">
                    <ui:skeleton class="h-4 w-[200]" />
                    <ui:skeleton class="h-4 w-[140]" />
                </native:column>
            @else
                <ui:avatar fallback="SC" size="lg" />
                <native:column class="flex-1 gap-1">
                    <ui:large>shadcn</ui:large>
                    <ui:muted>Loaded profile preview</ui:muted>
                </native:column>
            @endif
        </native:row>
        <native:row class="w-full gap-3 items-center">
            <ui:button ref="toggle-preview" variant="secondary" size="sm" @press="togglePreview">
                {{ $isLoadingPreview ? 'Finish loading' : 'Show skeleton' }}
            </ui:button>
            <ui:spinner />
        </native:row>
    </native:column>

    <ui:separator />

    {{-- Alerts --}}
    <native:column class="w-full gap-3">
        <ui:h3>Alert</ui:h3>
        <ui:alert icon="info">
            <ui:alert-title>Heads up!</ui:alert-title>
            <ui:alert-description>You can add components to your app using plain Blade tags.</ui:alert-description>
        </ui:alert>
        <ui:alert variant="destructive" icon="warning">
            <ui:alert-title>Payment failed</ui:alert-title>
            <ui:alert-description>Your card was declined. Please update your billing details.</ui:alert-description>
        </ui:alert>
    </native:column>

    <ui:separator />

    {{-- Card --}}
    <native:column class="w-full gap-3">
        <ui:h3>Card</ui:h3>
        <ui:card>
            <ui:card-header>
                <ui:card-title>Notifications</ui:card-title>
                <ui:card-description>You have 3 unread messages.</ui:card-description>
                <ui:card-action><ui:badge>3</ui:badge></ui:card-action>
            </ui:card-header>
            <ui:card-content>
                <ui:item-group>
                    <ui:item size="sm" icon="mail" title="Your call has been confirmed." description="1 hour ago" />
                    <ui:item size="sm" icon="person" title="You have a new message!" description="2 hours ago" />
                    <ui:item size="sm" icon="schedule" title="Your subscription is expiring soon." description="3 hours ago" />
                </ui:item-group>
            </ui:card-content>
            <ui:card-footer>
                <ui:button class="flex-1" icon="check">Mark all as read</ui:button>
            </ui:card-footer>
        </ui:card>
    </native:column>

    @include('native.partials.banner-ad-space')
</ui:page>
