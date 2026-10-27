# nativephp-ui recipes

## Sign in

```blade
<ui:page :scroll="false" class="justify-center">
    <native:column class="w-full gap-2 items-center">
        <ui:h3>Welcome back</ui:h3>
        <ui:muted>Sign in to your account</ui:muted>
    </native:column>

    <ui:field label="Email" :error="$errors['email'] ?? null">
        <ui:input native:model="email" keyboard="email" autocapitalize="none" placeholder="you@example.com"
                  :invalid="isset($errors['email'])" />
    </ui:field>
    <ui:field label="Password" :error="$errors['password'] ?? null">
        <ui:input native:model="password" secure revealable @submit="login" :invalid="isset($errors['password'])" />
    </ui:field>

    <ui:button class="w-full" :loading="$busy" @press="login">Sign in</ui:button>
    <ui:button variant="link" @navigate='/forgot-password'>Forgot your password?</ui:button>
</ui:page>
```

Keep validation errors in a public array property (e.g. `public array $errors = []`), fill it from a
`Validator` in the action, and read it in the view as shown above.

## List with an empty state and a loading skeleton

```blade
<ui:page>
    <native:row class="w-full items-center justify-between">
        <ui:h3>Projects</ui:h3>
        <ui:button size="sm" icon="plus" @press="create">New</ui:button>
    </native:row>

    @if ($loading)
        @foreach (range(1, 4) as $i)
            <native:row class="w-full gap-4 items-center" native:key="sk-{{ $i }}">
                <ui:skeleton class="h-10 w-10 rounded-full" />
                <native:column class="flex-1 gap-2">
                    <ui:skeleton class="h-4 w-[180]" />
                    <ui:skeleton class="h-3 w-[120]" />
                </native:column>
            </native:row>
        @endforeach
    @elseif (count($projects) === 0)
        <ui:empty icon="folder" title="No projects yet" description="Create your first project to get started.">
            <ui:button @press="create">Create project</ui:button>
        </ui:empty>
    @else
        <ui:item-group>
            @foreach ($projects as $project)
                <ui:item native:key="p-{{ $project['id'] }}" icon="folder" :title="$project['name']"
                         :description="$project['status']" chevron @navigate="'/projects/'.$project['id']" />
            @endforeach
        </ui:item-group>
    @endif
</ui:page>
```

## Detail screen with tabs

```blade
<ui:page>
    <native:row class="w-full gap-4 items-center">
        <ui:avatar :src="$user['photo']" :fallback="$user['initials']" size="xl" />
        <native:column class="flex-1 gap-1">
            <ui:h4>{{ $user['name'] }}</ui:h4>
            <ui:muted>{{ $user['email'] }}</ui:muted>
        </native:column>
        <ui:badge variant="secondary">{{ $user['role'] }}</ui:badge>
    </native:row>

    <ui:tabs native:model="tab">
        <ui:tabs-list>
            <ui:tabs-trigger value="activity">Activity</ui:tabs-trigger>
            <ui:tabs-trigger value="settings">Settings</ui:tabs-trigger>
        </ui:tabs-list>
        <ui:tabs-content value="activity">…</ui:tabs-content>
        <ui:tabs-content value="settings">…</ui:tabs-content>
    </ui:tabs>
</ui:page>
```

## Settings rows

```blade
<ui:item-group>
    <ui:item variant="outline" icon="notifications" title="Notifications" description="Push and email">
        <ui:switch ref="notifications" native:model="notifications" />
    </ui:item>
    <ui:item variant="outline" icon="language" title="Language" chevron @navigate='/settings/language'>
        <ui:muted>{{ $language }}</ui:muted>
    </ui:item>
</ui:item-group>
```

## Filter sheet

```blade
<ui:button variant="outline" icon="tune" @press="openFilters">Filters</ui:button>

<ui:sheet native:model="filtersOpen" detents="medium,large">
    <ui:dialog-header>
        <ui:dialog-title>Filters</ui:dialog-title>
    </ui:dialog-header>
    <ui:toggle-group type="multiple" native:model="statuses" variant="outline">
        <ui:toggle-group-item value="open">Open</ui:toggle-group-item>
        <ui:toggle-group-item value="closed">Closed</ui:toggle-group-item>
    </ui:toggle-group>
    <ui:dialog-footer>
        <ui:button @press="applyFilters">Apply</ui:button>
    </ui:dialog-footer>
</ui:sheet>
```

## Common mistakes

| Mistake | Fix |
|---|---|
| `<ui:*>` in a Livewire/web Blade view | They only compile in `NativeComponent` views. Build the screen natively. |
| `:variant="$x ? "a" : "b""` | Single quotes inside expressions: `:variant="$x ? 'a' : 'b'"`. |
| `radio-group-item` / `tabs-trigger` / `accordion-item` in an `@include` partial | Keep items in the same file as their group. `@foreach` is fine. |
| `@navigate="/terms"` (ParseError) | `@navigate='/terms'` or `@navigate="'/projects/'.$id"`. Double-quoted values are PHP arguments. |
| Lucide icon names (`circle-check`, `loader-2`) | NativePHP icon names (`check`, `warning`, `info`, `chevron_right`) or SF Symbols with a dot. |
| Raw colors (`bg-zinc-900`, `text-[#737373]`) | Theme tokens (`bg-theme-ui-primary`, `text-theme-ui-muted-foreground`) so dark mode works. |
| `@press="$set('open', false)"` | No `$set` magic. Call a public method, or bind with `native:model` and let the sheet's dismiss close it. |
| Expecting `ui:dialog` to be a centred modal | It is a native bottom sheet, which is shadcn's mobile pattern. Use `detents` to size it. |
| Mixing text and markup as button content (`Save <native:icon …/>`) | Use the `icon` / `icon-trailing` attributes. Mixed content skips the label styling. |
| Disabled button still "works" in tests | It doesn't: tapping a disabled or loading `ui:button` fails `Native::test()->tap()` by design. |
