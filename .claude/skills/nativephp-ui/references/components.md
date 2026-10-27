# nativephp-ui component reference

Notes that apply to every tag:

- **Attributes.** Any attribute not listed here is forwarded to the native element the tag renders.
- **Classes.** `class` / `:class` is appended last, so it overrides the component's classes.
- **Plain-text content.** Content that is plain text becomes a styled `<native:text>`. Content that
  contains markup (icons, `<native:*>`, other `<ui:*>`) is passed through untouched.

## Layout & typography

### `<ui:page>`
The screen root: a `native:scroll-view` filling the screen with `bg-theme-ui-background`, holding a
column with `p-4 gap-6`. Your `class` goes on that inner column.
- `:scroll="false"`: a non-scrolling, full-screen column instead.

```blade
<ui:page :scroll="false" class="justify-center">…</ui:page>
```

### Typography
`<ui:h1>` (4xl extrabold), `<ui:h2>` (3xl semibold), `<ui:h3>` (2xl semibold), `<ui:h4>` (xl semibold),
`<ui:p>` (base, relaxed), `<ui:lead>` (xl muted), `<ui:large>` (lg semibold), `<ui:small>` (sm medium),
`<ui:muted>` (sm muted), `<ui:code>` (mono on muted chip). Each renders one `<native:text>`.

### `<ui:separator />`
- `orientation`: `horizontal` (default, 1dp tall, full width) or `vertical` (1dp wide, full height).

## Actions

### `<ui:button>`
- `variant`: `default` · `secondary` · `destructive` · `outline` · `ghost` · `link`
- `size`: `default` (h 36) · `sm` (32) · `lg` (40) · `icon` (36²) · `icon-sm` · `icon-lg`
- `icon`, `icon-trailing`: icon names
- `disabled`, `loading`: booleans. The press handler is removed while either is true. `loading` shows a spinner.
- `@press` / `@tap`: a handler like `save` or `save('draft')`. `@navigate`, `@longPress` and `ref` are forwarded.

```blade
<ui:button variant="ghost" size="icon" icon="more_horiz" a11y-label="More" @press="openMenu" />
<ui:button class="w-full" :disabled="! $valid" :loading="$submitting" @press="submit">Continue</ui:button>
<ui:button variant="link" @navigate='/terms'>Terms of service</ui:button>
```

### `<ui:toggle>`
A pressable on/off button.
- Binding: `native:model`, or `:pressed` + `@change`
- `variant`: `default` · `outline`
- `size`: `sm` · `default` · `lg`
- `icon`, `disabled`

### `<ui:toggle-group>` › `<ui:toggle-group-item>`
- Group: binding (`native:model` / `:value` + `@change`)
- Group `type`: `single` (default; value is a string, and tapping the active item clears it to `''`) or
  `multiple` (value is an array)
- Group `variant` and `size` are inherited by the items
- Item: `value`, `icon`, `disabled`, optional label content

## Display

### `<ui:badge>`
- `variant`: `default` · `secondary` · `destructive` · `outline`
- `icon`
- Hugs its content (`self-start`).

### `<ui:card>`
Parts: `ui:card-header`, `ui:card-title`, `ui:card-description`, `ui:card-action`, `ui:card-content`,
`ui:card-footer`.
- **Header with an action.** Put `ui:card-action` inside `ui:card-header`. The header then becomes a row:
  title and description on the left, the action on the right.
- **Content** is padded (`px-6 gap-4`).
- **Footer** is a row (`px-6 gap-2`). Give a button `class="flex-1"` to stretch it.

### `<ui:alert>`
Parts: `ui:alert-title` and `ui:alert-description`. Both are coloured by the enclosing alert's `variant`.
- `variant`: `default` · `destructive`
- `icon`

### `<ui:avatar />`
- `src`: the image URL. Falls back to `fallback` text when `src` is empty.
- `fallback`: e.g. initials
- `alt`: becomes the a11y label
- `size`: `sm` (24) · `default` (32) · `lg` (40) · `xl` (64)

### `<ui:skeleton />`
A muted rounded block. Size it with classes: `class="h-4 w-[220]"`, `class="h-12 w-12 rounded-full"`.

### `<ui:progress />`
- `value`: 0–100, clamped

### `<ui:spinner />`
A small native activity indicator in the muted colour. Pass `size` to override the size.

### `<ui:kbd>`
A small key cap: `<ui:kbd>⌘K</ui:kbd>`.

### `<ui:empty>`
- `icon`, `title`, `description`
- Content: the action buttons, centred

### `<ui:item-group>` › `<ui:item>`
A list row.
- `icon`: shown in a small media box
- `title`, `description`
- `chevron`: shows a trailing `chevron_right`
- `variant`: `default` · `outline` · `muted`
- `size`: `default` · `sm`
- Content goes in the trailing slot: a switch, badge or button
- Forward `@press` or `@navigate` to make the row tappable.

```blade
<ui:item-group>
    @foreach ($projects as $project)
        <ui:item native:key="p-{{ $project->id }}" icon="folder" :title="$project->name"
                 :description="$project->updated_at->diffForHumans()" chevron
                 @navigate="'/projects/'.$project->id" />
    @endforeach
</ui:item-group>
```

## Forms

### `<ui:label>`
Small medium-weight text.

### `<ui:field>`
- `label`, `description`: text
- `error`: rendered in destructive red, only when `filled()`
- Content: the control

### `<ui:input />` and `<ui:textarea />`
A bordered row around NativePHP's chromeless `bare-text-input`.
- `icon`: a leading icon in the muted colour
- `invalid`: destructive border
- `disabled`
- Everything else is forwarded to the native input: `native:model` (with `.live`, `.blur`,
  `.debounce.300ms`), `placeholder`, `secure`, `revealable`, `keyboard` (`email`, `number`, `phone`,
  `url`…), `max-length`, `autofocus`, `@submit`, `autocapitalize`.
- `ui:textarea` is multiline, with 3 lines by default. Override with `min-lines` / `max-lines`.

### `<ui:switch>` and `<ui:checkbox>`
- Binding: `native:model`, or `:checked` + `@change` (the handler gets the new bool)
- `disabled`
- Switch `size`: `default` · `sm`
- Checkbox `invalid`
- Content: the label. The whole row is pressable.

### `<ui:radio-group>` › `<ui:radio-group-item>`
- Group: binding
- Item: `value`, `disabled`, label as content
- Items are compared loosely (`==`), so `value="1"` matches the integer `1`.

### `<ui:tabs>` › `<ui:tabs-list>` › `<ui:tabs-trigger>` and `<ui:tabs-content>`
- `ui:tabs`: binding
- `ui:tabs-list`: the full-width segmented control. Triggers share its width equally.
- `ui:tabs-trigger`: `value`, `icon`, `disabled`
- `ui:tabs-content`: `value`. Only the active panel is rendered (`@if`).

## Overlays

### `<ui:dialog>`, `<ui:sheet>`, `<ui:drawer>`
All three render NativePHP's native bottom sheet. `dialog` has `p-6` padding; `sheet` and `drawer` have
`p-4`.
- Binding: `native:model`, or `:open` + `@close` (`@dismiss` also works). Swiping the sheet away sets
  the model to `false` or calls the handler.
- Forwarded to the bottom sheet: `detents` (`small`, `medium`, `large`, `full`, comma lists like
  `medium,large`, or a fraction like `0.4`), `permanent`, `ref`.
- Parts: `ui:dialog-header`, `ui:dialog-title`, `ui:dialog-description`, `ui:dialog-footer`. The footer
  stacks its buttons vertically, at full width.
