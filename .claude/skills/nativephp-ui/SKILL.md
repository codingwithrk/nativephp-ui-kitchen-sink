---
name: nativephp-ui
description: "Builds shadcn/ui-styled native screens for NativePHP Mobile v4 with the codingwithrk/nativephp-ui package. Activate when writing or editing NativeComponent (SuperNative) Blade views that use <ui:*> tags — ui:page, ui:button, ui:card, ui:input, ui:field, ui:switch, ui:checkbox, ui:radio-group, ui:tabs, ui:toggle-group, ui:accordion, ui:dialog, ui:sheet, ui:item, ui:empty, typography (ui:h1, ui:muted…) — when the user asks for a shadcn look in a NativePHP app, when theming with bg-theme-ui-* tokens or config/nativephp-ui.php, or when testing such screens with Native::test()."
---

# NativePHP UI (shadcn/ui for SuperNative)

`codingwithrk/nativephp-ui` gives NativePHP Mobile v4 **SuperNative** screens a shadcn/ui look. You write
`<ui:*>` tags in a `NativeComponent`'s Blade view; at compile time each tag expands into ordinary
`<native:*>` EDGE elements styled with shadcn's tokens, so the result renders as real SwiftUI / Jetpack
Compose views.

## Ground rules

1. **Native views only.** `<ui:*>` tags compile only inside a `NativeComponent` render. In web, Livewire
   or Inertia views they are left as literal text. Never use them in HTML pages.
2. **Prefer `<ui:*>` over hand-styled EDGE** for anything shadcn has (buttons, cards, inputs, tabs…).
   Drop to `<native:*>` for layout (`native:row`, `native:column`, `native:scroll-view`) and for
   elements this package doesn't cover.
3. **Start every screen with `<ui:page>`**. It gives the scrolling root, the shadcn background, 16dp
   padding and 24dp vertical rhythm. Use `<ui:page :scroll="false">` for fixed screens.
4. **Use the theme tokens, not raw colors**: `bg-theme-ui-card`, `text-theme-ui-muted-foreground`,
   `border-theme-ui-border`. They switch automatically between light and dark mode.
5. **Single-quoted strings inside `:prop="…"` expressions.** A double quote inside a dynamic expression
   is a compile error: `:variant="$x ? 'destructive' : 'default'"`.
6. **Your `class` wins.** It is appended after the component's own classes:
   `<ui:button class="w-full h-12">`.
7. **Unknown attributes are forwarded** to the underlying native element: `ref`, `a11y-label`,
   `@navigate`, `@longPress`, `native:key`, and on inputs `placeholder`, `secure`, `keyboard`,
   `@submit`, `native:model.debounce.300ms`, …
8. **Keep group items in the same Blade file as their group.** Items find their parent tag at compile
   time, so they can't be in an `@include` partial or a child component. This applies to
   `radio-group-item`, `tabs-trigger`, `tabs-content`, `toggle-group-item` and `accordion-item`.
   `@foreach` loops inside the group are fine.
9. **`@navigate` takes PHP arguments.** Single-quote a static path, `@navigate='/terms'`, or write an
   expression, `@navigate="'/projects/'.$project->id"`. `@navigate="/terms"` is a PHP parse error.
10. **Icons use NativePHP icon names**, not Lucide: `plus`, `trash`, `person`, `settings`, `warning`,
   `info`, `check`, `chevron_right`, `format_bold`… An SF Symbol with a dot (`car.side.fill`) is used
   as-is on iOS.

## Binding state

Stateful components bind exactly like native inputs:

```blade
<ui:switch native:model="notifications" />                    {{-- two-way --}}
<ui:switch :checked="$wifi" @change="setWifi" />              {{-- controlled: setWifi(bool $on) --}}
<ui:tabs :value="$tab" @change="selectTab('home')">…</ui:tabs> {{-- selectTab('home', $newValue) --}}
```

| Component | Controlled prop | Handler |
|---|---|---|
| `switch`, `checkbox` | `:checked` | `@change` |
| `toggle` | `:pressed` | `@change` |
| `radio-group`, `tabs`, `toggle-group`, `accordion` | `:value` | `@change` |
| `dialog`, `sheet`, `drawer` | `:open` | `@close` |

`native:model` writes go through the same `__syncProperty` path as native inputs, so `updatedFoo()` hooks
and `#[Locked]` apply. With `type="multiple"`, `toggle-group` and `accordion` bind an **array**. In
single mode, tapping the active item clears the value to `''`.

## A complete screen

```php
namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class Settings extends NativeComponent
{
    public string $name = '';
    public bool $notifications = true;
    public string $plan = 'free';
    public bool $confirmingDelete = false;
    public bool $saving = false;

    public function save(): void { /* … */ }
    public function delete(): void { $this->confirmingDelete = false; /* … */ }
    public function cancelDelete(): void { $this->confirmingDelete = false; }
    public function askDelete(): void { $this->confirmingDelete = true; }

    public function render(): View
    {
        return view('native.settings');
    }
}
```

```blade
{{-- resources/views/native/settings.blade.php --}}
<ui:page>
    <native:column class="gap-1">
        <ui:h3>Settings</ui:h3>
        <ui:muted>Manage your account and preferences.</ui:muted>
    </native:column>

    <ui:card>
        <ui:card-header>
            <ui:card-title>Profile</ui:card-title>
            <ui:card-description>How others see you.</ui:card-description>
        </ui:card-header>
        <ui:card-content>
            <ui:field label="Name">
                <ui:input native:model="name" placeholder="Jane Doe" icon="person" />
            </ui:field>
            <ui:switch native:model="notifications">Push notifications</ui:switch>
        </ui:card-content>
        <ui:card-footer>
            <ui:button class="flex-1" :loading="$saving" @press="save">Save changes</ui:button>
        </ui:card-footer>
    </ui:card>

    <ui:radio-group native:model="plan">
        <ui:radio-group-item value="free">Free</ui:radio-group-item>
        <ui:radio-group-item value="pro">Pro</ui:radio-group-item>
    </ui:radio-group>

    <ui:button variant="destructive" @press="askDelete">Delete account</ui:button>

    <ui:dialog native:model="confirmingDelete">
        <ui:dialog-header>
            <ui:dialog-title>Delete account?</ui:dialog-title>
            <ui:dialog-description>This permanently removes your data.</ui:dialog-description>
        </ui:dialog-header>
        <ui:dialog-footer>
            <ui:button variant="destructive" @press="delete">Delete</ui:button>
            <ui:button variant="outline" @press="cancelDelete">Cancel</ui:button>
        </ui:dialog-footer>
    </ui:dialog>
</ui:page>
```

## Component quick reference

Every attribute, with examples: [references/components.md](references/components.md).
Screen recipes (login, list, detail, empty, forms with validation) and common mistakes:
[references/recipes.md](references/recipes.md).

| Tag | Key attributes |
|---|---|
| `ui:page` | `:scroll="false"` |
| `ui:h1` `h2` `h3` `h4` `p` `lead` `large` `small` `muted` `code` | text content |
| `ui:button` | `variant` default·secondary·destructive·outline·ghost·link, `size` default·sm·lg·icon·icon-sm·icon-lg, `icon`, `icon-trailing`, `disabled`, `loading`, `@press` |
| `ui:badge` | `variant` default·secondary·destructive·outline, `icon` |
| `ui:card` + `-header` `-title` `-description` `-action` `-content` `-footer` | — |
| `ui:alert` + `-title` `-description` | `variant` default·destructive, `icon` |
| `ui:separator` | `orientation` horizontal·vertical |
| `ui:label`, `ui:field` | field: `label`, `description`, `error` (shown only when filled) |
| `ui:input`, `ui:textarea` | `icon`, `invalid`, `disabled` + forwarded input attributes |
| `ui:switch`, `ui:checkbox` | binding, `disabled`, switch `size` default·sm, checkbox `invalid`, label as content |
| `ui:radio-group` › `ui:radio-group-item` | item `value`, `disabled` |
| `ui:tabs` › `-list` › `-trigger`, `ui:tabs-content` | trigger/content `value`, trigger `icon` |
| `ui:toggle`, `ui:toggle-group` › `-item` | `type` single·multiple, `variant` default·outline, `size`, `icon` |
| `ui:accordion` › `ui:accordion-item` | `type` single·multiple, item `value`, `title` |
| `ui:dialog` / `ui:sheet` / `ui:drawer` + `dialog-header` `-title` `-description` `-footer` | binding, forwarded `detents`, `permanent` |
| `ui:avatar` | `src`, `fallback`, `alt`, `size` sm·default·lg·xl |
| `ui:progress` `ui:skeleton` `ui:spinner` `ui:kbd` | progress `value` 0–100 |
| `ui:item-group` › `ui:item` | `icon`, `title`, `description`, `chevron`, `variant` default·outline·muted, `size` default·sm, trailing content |
| `ui:empty` | `icon`, `title`, `description`, actions as content |

## Theming

`config/nativephp-ui.php` (publish with `php artisan vendor:publish --tag=nativephp-ui-config`):

```php
'base_color' => 'zinc',    // neutral | zinc | slate | stone | gray
'accent'     => 'violet',  // null | blue | green | orange | red | rose | violet | yellow
'radius'     => 10,        // shadcn --radius; sm = r-4, md = r-2, lg = r, xl = r+4
'tokens'     => ['light' => ['primary' => '#4F46E5'], 'dark' => ['primary' => '#818CF8']],
```

Tokens (use as `bg-theme-ui-{token}`, `text-theme-ui-{token}`, `border-theme-ui-{token}`, with opacity
modifiers like `bg-theme-ui-primary/20`): `background` `foreground` `card` `card-foreground` `popover`
`popover-foreground` `primary` `primary-foreground` `secondary` `secondary-foreground` `muted`
`muted-foreground` `accent` `accent-foreground` `destructive` `destructive-foreground` `border` `input`
`ring`.

These are separate from the app's own `native-ui` tokens (`primary`, `surface`, …), which are left alone.
Native chrome (top bar, bottom nav, the bottom sheet's background) still uses the `native-ui` tokens.
Align those in `config/native-ui.php` if they should match.

## Testing

Put a `ref` on the tag. It is forwarded to the pressable part, so `Native::test()` can tap it:

```php
Native::test(Settings::class)
    ->tap('notifications')                 // <ui:switch ref="notifications" native:model="notifications" />
    ->assertSet('notifications', false)
    ->input('name', 'Jane')                // forwarded native:model on <ui:input>
    ->assertSet('name', 'Jane');
```

A disabled or loading `ui:button` has no press handler, so tapping it fails the test. That's the
expected behaviour.
