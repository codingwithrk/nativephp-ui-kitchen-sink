{{-- No top bar on purpose: the drawer's ☰ button sits at the top leading corner. --}}
<ui:page class="safe-area-top pt-16">
    <native:row class="w-full items-start justify-between gap-3">
        <native:column class="flex-1 gap-1">
            <native:text class="text-xs font-semibold text-theme-ui-muted-foreground">ACME INC.</native:text>
            <ui:h2>{{ $current['title'] }}</ui:h2>
            <ui:muted>{{ $current['description'] }}</ui:muted>
        </native:column>
        <ui:button ref="exit-demo" variant="outline" size="sm" icon="close" @navigate.back>Exit demo</ui:button>
    </native:row>

    <ui:alert icon="info">
        <ui:alert-title>This is a real native drawer</ui:alert-title>
        <ui:alert-description>Tap the menu button at the top left, or swipe in from the left edge. The drawer's content is a ui:sidebar.</ui:alert-description>
    </ui:alert>

    @switch($section)
        @case('inbox')
            <ui:item-group>
                <ui:item variant="outline" icon="person" title="Olivia Martin" description="Can we move the review to Friday?"><ui:badge>New</ui:badge></ui:item>
                <ui:item variant="outline" icon="person" title="Jackson Lee" description="Build 42 is on TestFlight."><ui:badge>New</ui:badge></ui:item>
                <ui:item variant="outline" icon="person" title="Isabella Nguyen" description="Invoice for October attached." />
            </ui:item-group>
            @break

        @case('calendar')
            <ui:item-group>
                <ui:item variant="outline" icon="event" title="Design review" description="Today · 10:00 – 11:00" />
                <ui:item variant="outline" icon="event" title="Release 2.4.0" description="Tomorrow · 14:00" />
                <ui:item variant="outline" icon="event" title="Team lunch" description="Friday · 13:00" />
            </ui:item-group>
            @break

        @case('profile')
            <ui:card>
                <ui:card-header>
                    <ui:card-title>Rajkumar</ui:card-title>
                    <ui:card-description>rk@codingwithrk.com</ui:card-description>
                    <ui:card-action><ui:avatar fallback="RK" size="lg" /></ui:card-action>
                </ui:card-header>
                <ui:card-content>
                    <ui:switch ref="notifications" native:model="wantsNotifications">Push notifications</ui:switch>
                </ui:card-content>
            </ui:card>
            @break

        @case('billing')
            <ui:card>
                <ui:card-header>
                    <ui:card-title>Pro plan</ui:card-title>
                    <ui:card-description>Renews on 1 November 2026.</ui:card-description>
                    <ui:card-action><ui:badge variant="secondary">Active</ui:badge></ui:card-action>
                </ui:card-header>
                <ui:card-content>
                    <ui:progress :value="64" />
                    <ui:muted>64% of this month's builds used.</ui:muted>
                </ui:card-content>
            </ui:card>
            @break

        @default
            <native:row class="w-full gap-3">
                <ui:stat label="Projects" value="12" change="+2" />
                <ui:stat label="Builds" value="342" change="+18%" />
            </native:row>
            <ui:card>
                <ui:card-header>
                    <ui:card-title>Release 2.4.0</ui:card-title>
                    <ui:card-description>Rolling out to 64% of users.</ui:card-description>
                </ui:card-header>
                <ui:card-content>
                    <ui:progress :value="64" />
                </ui:card-content>
            </ui:card>
    @endswitch
</ui:page>
