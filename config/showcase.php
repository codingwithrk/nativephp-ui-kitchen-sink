<?php

use App\NativeComponents\Forms;
use App\NativeComponents\Gallery;
use App\NativeComponents\Interactive;
use App\NativeComponents\Overlays;

/**
 * The showcase registry: every group, component and template the app
 * shows. Add a component here, then scaffold its example screen with
 * `php artisan showcase:component {slug}`.
 */

return [

    /*
    | The newest nativephp-ui version this catalog documents. The app only
    | shows components whose `since` is at or below the installed plugin
    | version, and badges the ones added in that version as new.
    */

    'version' => '1.1.0',

    /*
    | Plugin versions the version switcher offers, newest first — the same
    | list as the documentation site.
    */

    'versions' => [
        ['version' => '1.1.0', 'status' => 'stable', 'released' => '2026-10-24'],
        ['version' => '1.0.1', 'status' => 'stable', 'released' => '2026-10-18'],
        ['version' => '1.0.0', 'status' => 'stable', 'released' => '2026-10-18'],
    ],

    /*
    | Pretend a different plugin version is installed, e.g. to preview the
    | catalog for an older release. Null reads it from Composer.
    */

    'plugin_version' => env('SHOWCASE_PLUGIN_VERSION'),

    /*
    | The theme the app starts with, and where Settings saves the viewer's
    | own choice.
    */

    'theme' => [
        'base_color' => 'zinc',
        'accent' => 'violet',
        'radius' => 10,
        'path' => storage_path('app/showcase-theme.json'),
        'version_path' => storage_path('app/showcase-version.json'),
    ],

    /*
    | Identity colors for groups, added to the theme as `tint-*` tokens so
    | they work as `bg-theme-tint-blue/15`, with a dark-mode pair each.
    */

    'tints' => [
        'indigo' => ['light' => '#4F46E5', 'dark' => '#818CF8'],
        'violet' => ['light' => '#7C3AED', 'dark' => '#A78BFA'],
        'blue' => ['light' => '#2563EB', 'dark' => '#60A5FA'],
        'sky' => ['light' => '#0284C7', 'dark' => '#38BDF8'],
        'teal' => ['light' => '#0D9488', 'dark' => '#2DD4BF'],
        'green' => ['light' => '#16A34A', 'dark' => '#4ADE80'],
        'amber' => ['light' => '#D97706', 'dark' => '#FBBF24'],
        'orange' => ['light' => '#EA580C', 'dark' => '#FB923C'],
        'pink' => ['light' => '#DB2777', 'dark' => '#F472B6'],
        'rose' => ['light' => '#E11D48', 'dark' => '#FB7185'],
        'cyan' => ['light' => '#0891B2', 'dark' => '#22D3EE'],
    ],

    /*
    | The About tab: links that open in the in-app browser, and the open
    | source packages credited under Licenses. Composer packages read their
    | license and homepage from vendor/composer/installed.json; anything
    | else (design systems, icon sets) sets them here.
    */

    'about' => [
        'description' => 'A native showcase for codingwithrk/nativephp-ui: every component, live, with the same examples as the documentation. Built with NativePHP Mobile and rendered as real SwiftUI and Jetpack Compose views.',

        'links' => [
            'docs' => ['label' => 'Documentation', 'description' => 'nativephp-ui.codingwithrk.com', 'url' => 'https://nativephp-ui.codingwithrk.com', 'icon' => ['ios' => 'book', 'android' => 'menu_book']],
            'license' => ['label' => 'Get a license', 'description' => 'CodingwithRK Marketplace', 'url' => 'https://marketplace.codingwithrk.com/products/nativephp-ui', 'icon' => ['ios' => 'cart', 'android' => 'shopping_cart']],
            'source' => ['label' => 'Source code', 'description' => 'This app on GitHub', 'url' => 'https://github.com/codingwithrk/nativephp-ui-kitchen-sink', 'icon' => ['ios' => 'chevron.left.forwardslash.chevron.right', 'android' => 'code']],
            'author' => ['label' => 'Made by CodingwithRK', 'description' => 'codingwithrk.com', 'url' => 'https://codingwithrk.com', 'icon' => ['ios' => 'person', 'android' => 'person']],
        ],

        'credits' => [
            'codingwithrk/nativephp-ui' => ['name' => 'NativePHP UI', 'note' => 'UI components'],
            'nativephp/mobile' => ['name' => 'NativePHP Mobile', 'note' => 'Native runtime'],
            'nativephp/mobile-ui' => ['name' => 'NativePHP Mobile UI', 'note' => 'Native controls and theming'],
            'nativephp/mobile-browser' => ['name' => 'NativePHP Browser', 'note' => 'In-app browser'],
            'nativephp/mobile-network' => ['name' => 'NativePHP Network', 'note' => 'Connectivity status'],
            'codingwithrk/package-info' => ['name' => 'Package Info', 'note' => 'App version and build'],
            'bhargavdetroja/nativephp-google-mobile-ads' => ['name' => 'Google Mobile Ads for NativePHP', 'note' => 'AdMob banners'],
            'laravel/framework' => ['name' => 'Laravel', 'note' => 'Framework'],
            'shadcn/ui' => ['name' => 'shadcn/ui', 'license' => 'MIT', 'url' => 'https://ui.shadcn.com', 'note' => 'Design system'],
            'material-icons' => ['name' => 'Material Icons', 'license' => 'Apache-2.0', 'url' => 'https://fonts.google.com/icons', 'note' => 'Android icons'],
            'sf-symbols' => ['name' => 'SF Symbols', 'license' => 'Apple', 'url' => 'https://developer.apple.com/sf-symbols/', 'note' => 'iOS icons'],
        ],
    ],

    /*
    | In-app update check. The app GETs `url` (with ?platform=android|ios and
    | ?version=<installed>) and expects one entry per platform:
    |
    |   {
    |     "android": {"version": "1.2.0", "force_update": false,
    |                 "store_url": "https://play.google.com/store/apps/details?id=…",
    |                 "message": null},
    |     "ios":     {"version": "1.2.0", "force_update": true,
    |                 "store_url": "https://apps.apple.com/app/id…",
    |                 "message": "Optional text shown to the user"}
    |   }
    |
    | A newer `version` than the installed app shows an update dialog the
    | user can skip, or a blocking update screen when `force_update` is
    | true. No `url` turns the check off.
    */

    'updates' => [
        'url' => env('APP_UPDATE_URL'),
        'timeout' => 4,
        'cache_minutes' => 360,
    ],

    /*
    | Banner ads (Google AdMob through bhargavdetroja/nativephp-google-mobile-ads).
    | Shown on pushed screens only — tab screens would put the banner over
    | the tab bar. The plugin's own config (google-mobile-ads.enabled,
    | test_mode, slots) still decides whether ads run and which IDs to use.
    */

    'ads' => [
        'banner_slot' => 'anchored_adaptive_banner',
    ],

    'groups' => [
        'layout' => [
            'label' => 'Layout',
            'description' => 'Screen roots, type scale and spacing primitives.',
            'icon' => ['ios' => 'square.split.2x2', 'android' => 'view_quilt'],
            'color' => 'tint-indigo',
        ],
        'actions' => [
            'label' => 'Actions',
            'description' => 'Buttons, toggles and native menus.',
            'icon' => ['ios' => 'hand.tap', 'android' => 'touch_app'],
            'color' => 'tint-violet',
        ],
        'forms' => [
            'label' => 'Forms',
            'description' => 'Inputs, fields and controls bound with native:model.',
            'icon' => ['ios' => 'pencil.and.list.clipboard', 'android' => 'edit_note'],
            'color' => 'tint-blue',
        ],
        'selection' => [
            'label' => 'Selection',
            'description' => 'Pickers, searchable lists and command palettes.',
            'icon' => ['ios' => 'checklist', 'android' => 'checklist'],
            'color' => 'tint-sky',
        ],
        'display' => [
            'label' => 'Display',
            'description' => 'Cards, badges, avatars, list rows and media.',
            'icon' => ['ios' => 'rectangle.on.rectangle', 'android' => 'dashboard'],
            'color' => 'tint-teal',
        ],
        'data' => [
            'label' => 'Data',
            'description' => 'Tables, paginated data and charts.',
            'icon' => ['ios' => 'tablecells', 'android' => 'table_chart'],
            'color' => 'tint-green',
        ],
        'navigation' => [
            'label' => 'Navigation',
            'description' => 'Breadcrumbs, menus and the side drawer.',
            'icon' => ['ios' => 'signpost.right', 'android' => 'explore'],
            'color' => 'tint-amber',
        ],
        'feedback' => [
            'label' => 'Feedback',
            'description' => 'Progress, loading states and toasts.',
            'icon' => ['ios' => 'bell', 'android' => 'notifications_active'],
            'color' => 'tint-orange',
        ],
        'disclosure' => [
            'label' => 'Disclosure',
            'description' => 'Tabs, accordions and collapsible sections.',
            'icon' => ['ios' => 'chevron.down.square', 'android' => 'unfold_more'],
            'color' => 'tint-pink',
        ],
        'overlays' => [
            'label' => 'Overlays',
            'description' => 'Dialogs, sheets, drawers and popovers.',
            'icon' => ['ios' => 'square.stack', 'android' => 'layers'],
            'color' => 'tint-rose',
        ],
        'chat' => [
            'label' => 'Chat',
            'description' => 'Message lists, bubbles and attachments.',
            'icon' => ['ios' => 'bubble.left.and.bubble.right', 'android' => 'forum'],
            'color' => 'tint-cyan',
        ],
    ],

    'components' => [
        'page' => [
            'name' => 'Page',
            'group' => 'layout',
            'description' => 'The screen root. It applies shadcn\'s background color, page padding and vertical rhythm, and scrolls by default.',
            'tags' => ['page'],
            'since' => '1.0.0',
            'updated' => ['1.1.0' => 'A <ui:toaster /> placed inside the page floats over the bottom of the screen instead of scrolling with the content.'],
            'icon' => ['ios' => 'doc.plaintext', 'android' => 'article'],
        ],
        'typography' => [
            'name' => 'Typography',
            'group' => 'layout',
            'description' => 'shadcn\'s type scale as native text: headings, paragraphs, lead, muted and inline code.',
            'tags' => ['h1', 'h2', 'h3', 'h4', 'p', 'lead', 'large', 'small', 'muted', 'code'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'textformat', 'android' => 'text_fields'],
        ],
        'separator' => [
            'name' => 'Separator',
            'group' => 'layout',
            'description' => 'A hairline that visually separates content, horizontally or vertically.',
            'tags' => ['separator'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'minus', 'android' => 'horizontal_rule'],
        ],
        'aspect-ratio' => [
            'name' => 'Aspect Ratio',
            'group' => 'layout',
            'description' => 'A full-width box at a fixed ratio, for images and video.',
            'tags' => ['aspect-ratio'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'aspectratio', 'android' => 'aspect_ratio'],
        ],
        'button' => [
            'name' => 'Button',
            'group' => 'actions',
            'description' => 'A pressable button in six variants and six sizes, with optional icons and a loading state.',
            'tags' => ['button'],
            'since' => '1.0.0',
            'updated' => ['1.1.0' => 'Inside a <ui:button-group>, buttons square off the corners where they meet their neighbours.'],
            'icon' => ['ios' => 'hand.tap', 'android' => 'smart_button'],
        ],
        'toggle' => [
            'name' => 'Toggle',
            'group' => 'actions',
            'description' => 'A two-state button that can be either on or off.',
            'tags' => ['toggle'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'togglepower', 'android' => 'toggle_off'],
        ],
        'toggle-group' => [
            'name' => 'Toggle Group',
            'group' => 'actions',
            'description' => 'A set of toggles where one item (single) or any number of items (multiple) can be on.',
            'tags' => ['toggle-group', 'toggle-group-item'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'rectangle.split.3x1', 'android' => 'view_week'],
        ],
        'button-group' => [
            'name' => 'Button Group',
            'group' => 'actions',
            'description' => 'Joins buttons into one control by squaring off the corners where they meet.',
            'tags' => ['button-group'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'rectangle.split.2x1', 'android' => 'view_column'],
        ],
        'dropdown-menu' => [
            'name' => 'Dropdown Menu',
            'group' => 'actions',
            'description' => 'A menu of actions that opens from a trigger, using the platform\'s native menu.',
            'tags' => ['dropdown-menu', 'dropdown-menu-item', 'dropdown-menu-sub', 'dropdown-menu-separator', 'dropdown-menu-label'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'chevron.down.circle', 'android' => 'arrow_drop_down_circle'],
        ],
        'context-menu' => [
            'name' => 'Context Menu',
            'group' => 'actions',
            'description' => 'Long-press a trigger to open a bottom-sheet list of actions.',
            'tags' => ['context-menu', 'context-menu-item', 'context-menu-sub', 'context-menu-separator', 'context-menu-label'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'contextualmenu.and.cursorarrow', 'android' => 'menu_open'],
        ],
        'menubar' => [
            'name' => 'Menubar',
            'group' => 'actions',
            'description' => 'A bordered row of native menus, like a desktop menubar.',
            'tags' => ['menubar', 'menubar-menu', 'menubar-item', 'menubar-sub', 'menubar-separator', 'menubar-label'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'menubar.rectangle', 'android' => 'menu'],
        ],
        'field' => [
            'name' => 'Field',
            'group' => 'forms',
            'description' => 'Stacks a label, a control, help text and a validation error with the right spacing.',
            'tags' => ['field'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'rectangle.and.pencil.and.ellipsis', 'android' => 'edit_note'],
        ],
        'label' => [
            'name' => 'Label',
            'group' => 'forms',
            'description' => 'Small, medium-weight text that labels a control.',
            'tags' => ['label'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'tag', 'android' => 'label'],
        ],
        'input' => [
            'name' => 'Input',
            'group' => 'forms',
            'description' => 'A bordered text field with shadcn\'s look, built on NativePHP\'s chromeless native text input.',
            'tags' => ['input'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'character.cursor.ibeam', 'android' => 'input'],
        ],
        'textarea' => [
            'name' => 'Textarea',
            'group' => 'forms',
            'description' => 'A multiline input. It shows three lines by default and grows with its content.',
            'tags' => ['textarea'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'text.alignleft', 'android' => 'notes'],
        ],
        'switch' => [
            'name' => 'Switch',
            'group' => 'forms',
            'description' => 'A control that lets the user toggle between checked and not checked.',
            'tags' => ['switch'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'switch.2', 'android' => 'toggle_on'],
        ],
        'checkbox' => [
            'name' => 'Checkbox',
            'group' => 'forms',
            'description' => 'A control that lets the user toggle between checked and not checked.',
            'tags' => ['checkbox'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'checkmark.square', 'android' => 'check_box'],
        ],
        'radio-group' => [
            'name' => 'Radio Group',
            'group' => 'forms',
            'description' => 'A set of options where only one can be selected at a time.',
            'tags' => ['radio-group', 'radio-group-item'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'smallcircle.filled.circle', 'android' => 'radio_button_checked'],
        ],
        'input-group' => [
            'name' => 'Input Group',
            'group' => 'forms',
            'description' => 'One bordered field that holds a chromeless input with text, icon or button addons.',
            'tags' => ['input-group', 'input-group-addon', 'input-group-input', 'input-group-textarea'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'rectangle.and.text.magnifyingglass', 'android' => 'manage_search'],
        ],
        'input-otp' => [
            'name' => 'Input OTP',
            'group' => 'forms',
            'description' => 'One-time code entry: a row of boxes over one native number input, with paste and SMS autofill.',
            'tags' => ['input-otp'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'number.square', 'android' => 'pin'],
        ],
        'slider' => [
            'name' => 'Slider',
            'group' => 'forms',
            'description' => 'The native slider from nativephp/mobile-ui, full width and themed to match.',
            'tags' => ['slider'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'slider.horizontal.3', 'android' => 'tune'],
        ],
        'date-picker' => [
            'name' => 'Date Picker & Calendar',
            'group' => 'forms',
            'description' => 'The platform\'s native date and time picker, compact or as an inline calendar.',
            'tags' => ['date-picker', 'calendar'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'calendar', 'android' => 'calendar_today'],
        ],
        'select' => [
            'name' => 'Select',
            'group' => 'selection',
            'description' => 'A shadcn trigger that opens the platform\'s native menu, with a check mark next to the selected option.',
            'tags' => ['select'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'chevron.up.chevron.down', 'android' => 'unfold_more'],
        ],
        'native-select' => [
            'name' => 'Native Select',
            'group' => 'selection',
            'description' => 'nativephp/mobile-ui\'s native picker control, themed to match.',
            'tags' => ['native-select'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'list.bullet.circle', 'android' => 'list'],
        ],
        'combobox' => [
            'name' => 'Combobox',
            'group' => 'selection',
            'description' => 'A searchable select: the trigger opens a bottom sheet with a search field and a filtered list.',
            'tags' => ['combobox'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'magnifyingglass.circle', 'android' => 'search'],
        ],
        'command' => [
            'name' => 'Command',
            'group' => 'selection',
            'description' => 'An inline command palette: a search field over grouped, filterable items.',
            'tags' => ['command'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'command', 'android' => 'terminal'],
        ],
        'card' => [
            'name' => 'Card',
            'group' => 'display',
            'description' => 'A container with a header, content and footer.',
            'tags' => ['card', 'card-header', 'card-title', 'card-description', 'card-action', 'card-content', 'card-footer'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'rectangle.portrait', 'android' => 'crop_portrait'],
        ],
        'alert' => [
            'name' => 'Alert',
            'group' => 'display',
            'description' => 'Displays a callout for user attention.',
            'tags' => ['alert', 'alert-title', 'alert-description'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'exclamationmark.triangle', 'android' => 'warning'],
        ],
        'badge' => [
            'name' => 'Badge',
            'group' => 'display',
            'description' => 'A small status label.',
            'tags' => ['badge'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'seal', 'android' => 'verified'],
        ],
        'avatar' => [
            'name' => 'Avatar',
            'group' => 'display',
            'description' => 'A circular image, with initials as a fallback when there is no image.',
            'tags' => ['avatar'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'person.crop.circle', 'android' => 'account_circle'],
        ],
        'item' => [
            'name' => 'Item',
            'group' => 'display',
            'description' => 'A list row with media, a title, a description and a trailing slot, for settings screens and lists.',
            'tags' => ['item', 'item-group'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'list.bullet.rectangle', 'android' => 'view_list'],
        ],
        'empty' => [
            'name' => 'Empty',
            'group' => 'display',
            'description' => 'An empty state with an icon, a title, a description and actions.',
            'tags' => ['empty'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'tray', 'android' => 'inbox'],
        ],
        'kbd' => [
            'name' => 'Kbd',
            'group' => 'display',
            'description' => 'Displays a keyboard key or shortcut.',
            'tags' => ['kbd'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'keyboard', 'android' => 'keyboard'],
        ],
        'carousel' => [
            'name' => 'Carousel',
            'group' => 'display',
            'description' => 'nativephp/mobile-ui\'s native carousel: a snapping strip on iOS and a Material 3 carousel on Android.',
            'tags' => ['carousel', 'carousel-item'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'rectangle.stack', 'android' => 'view_carousel'],
        ],
        'table' => [
            'name' => 'Table',
            'group' => 'data',
            'description' => 'A table built from native rows, with header, body, footer and caption parts.',
            'tags' => ['table', 'table-header', 'table-body', 'table-footer', 'table-row', 'table-head', 'table-cell', 'table-caption'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'tablecells', 'android' => 'table_chart'],
        ],
        'data-table' => [
            'name' => 'Data Table',
            'group' => 'data',
            'description' => 'A table with search, sortable columns and paging, from an array of rows.',
            'tags' => ['data-table'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'tablecells.badge.ellipsis', 'android' => 'dataset'],
        ],
        'pagination' => [
            'name' => 'Pagination',
            'group' => 'data',
            'description' => 'Page navigation with previous and next buttons, and ellipses for long ranges.',
            'tags' => ['pagination'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'ellipsis.rectangle', 'android' => 'last_page'],
        ],
        'chart' => [
            'name' => 'Chart',
            'group' => 'data',
            'description' => 'Vertical and horizontal bar charts drawn with native views, colored with the chart tokens.',
            'tags' => ['chart'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'chart.bar', 'android' => 'bar_chart'],
        ],
        'breadcrumb' => [
            'name' => 'Breadcrumb',
            'group' => 'navigation',
            'description' => 'Shows where the current screen sits in a hierarchy, with chevron separators.',
            'tags' => ['breadcrumb', 'breadcrumb-item', 'breadcrumb-page', 'breadcrumb-ellipsis', 'breadcrumb-separator'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'chevron.right.2', 'android' => 'chevron_right'],
        ],
        'navigation-menu' => [
            'name' => 'Navigation Menu',
            'group' => 'navigation',
            'description' => 'A horizontally scrolling row of pill links.',
            'tags' => ['navigation-menu', 'navigation-menu-item'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'menucard', 'android' => 'menu_book'],
        ],
        'sidebar' => [
            'name' => 'Sidebar',
            'group' => 'navigation',
            'description' => 'Content for the native side drawer from nativephp/mobile-ui: header, grouped menu and footer.',
            'tags' => ['sidebar', 'sidebar-header', 'sidebar-content', 'sidebar-footer', 'sidebar-group', 'sidebar-group-label', 'sidebar-menu', 'sidebar-menu-item', 'sidebar-separator'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'sidebar.left', 'android' => 'view_sidebar'],
        ],
        'progress' => [
            'name' => 'Progress',
            'group' => 'feedback',
            'description' => 'An indicator showing how far a task has got.',
            'tags' => ['progress'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'percent', 'android' => 'percent'],
        ],
        'skeleton' => [
            'name' => 'Skeleton',
            'group' => 'feedback',
            'description' => 'A placeholder shown while content loads. You size and shape it with classes.',
            'tags' => ['skeleton'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'rectangle.dashed', 'android' => 'crop_free'],
        ],
        'spinner' => [
            'name' => 'Spinner',
            'group' => 'feedback',
            'description' => 'The platform activity indicator, tinted to the muted foreground color.',
            'tags' => ['spinner'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'arrow.triangle.2.circlepath', 'android' => 'autorenew'],
        ],
        'toaster' => [
            'name' => 'Toaster',
            'group' => 'feedback',
            'description' => 'shadcn-style toasts, queued with $this->toast() from the InteractsWithUi trait.',
            'tags' => ['toaster'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'bell.badge', 'android' => 'notifications_active'],
        ],
        'tabs' => [
            'name' => 'Tabs',
            'group' => 'disclosure',
            'description' => 'A segmented control that switches between panels of content.',
            'tags' => ['tabs', 'tabs-list', 'tabs-trigger', 'tabs-content'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'rectangle.split.3x1.fill', 'android' => 'tab'],
        ],
        'accordion' => [
            'name' => 'Accordion',
            'group' => 'disclosure',
            'description' => 'A vertically stacked set of collapsible sections.',
            'tags' => ['accordion', 'accordion-item'],
            'since' => '1.0.0',
            'icon' => ['ios' => 'list.bullet.indent', 'android' => 'expand_circle_down'],
        ],
        'collapsible' => [
            'name' => 'Collapsible',
            'group' => 'disclosure',
            'description' => 'A panel that expands and collapses from a trigger row.',
            'tags' => ['collapsible', 'collapsible-trigger', 'collapsible-content'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'arrow.up.and.down.square', 'android' => 'unfold_less'],
        ],
        'dialog' => [
            'name' => 'Dialog, Sheet & Drawer',
            'group' => 'overlays',
            'description' => 'A modal panel presented as a native bottom sheet, which is how shadcn itself shows dialogs on mobile.',
            'tags' => ['dialog', 'sheet', 'drawer', 'dialog-trigger', 'dialog-close', 'dialog-header', 'dialog-title', 'dialog-description', 'dialog-footer'],
            'tags_since' => ['dialog-trigger' => '1.1.0', 'dialog-close' => '1.1.0'],
            'since' => '1.0.0',
            'updated' => ['1.1.0' => 'With sync_native_theme on (the default) the sheet\'s background follows the shadcn palette. New dialog-trigger and dialog-close parts open and close it without any methods.'],
            'icon' => ['ios' => 'rectangle.bottomhalf.inset.filled', 'android' => 'call_to_action'],
        ],
        'popover' => [
            'name' => 'Popover',
            'group' => 'overlays',
            'description' => 'Rich content in a medium-height bottom sheet, opened from a trigger that stays on screen.',
            'tags' => ['popover', 'popover-trigger', 'popover-content', 'popover-close'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'text.bubble', 'android' => 'chat_bubble'],
        ],
        'message' => [
            'name' => 'Message & Bubble',
            'group' => 'chat',
            'description' => 'Chat messages: a bottom-pinned scroller, messages with avatars and meta, and sent or received bubbles.',
            'tags' => ['message-scroller', 'message', 'bubble'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'bubble.left.and.bubble.right', 'android' => 'forum'],
        ],
        'attachment' => [
            'name' => 'Attachment',
            'group' => 'chat',
            'description' => 'A file chip with a type icon or thumbnail, size, and an optional remove button.',
            'tags' => ['attachment'],
            'since' => '1.1.0',
            'icon' => ['ios' => 'paperclip', 'android' => 'attach_file'],
        ],
    ],

    'templates' => [
        'dashboard' => [
            'name' => 'Dashboard',
            'category' => 'Analytics',
            'description' => 'Stats, progress, alerts and a notifications card.',
            'icon' => ['ios' => 'chart.bar.doc.horizontal', 'android' => 'space_dashboard'],
            'screen' => Gallery::class,
        ],
        'sign-up' => [
            'name' => 'Sign up',
            'category' => 'Authentication',
            'description' => 'A validated create-account form with plans and terms.',
            'icon' => ['ios' => 'person.badge.plus', 'android' => 'person_add'],
            'screen' => Forms::class,
        ],
        'preferences' => [
            'name' => 'Preferences',
            'category' => 'Settings',
            'description' => 'Tabs, toggles, a controlled switch and FAQs.',
            'icon' => ['ios' => 'slider.horizontal.3', 'android' => 'tune'],
            'screen' => Interactive::class,
        ],
        'projects' => [
            'name' => 'Projects',
            'category' => 'Lists',
            'description' => 'A project list with a confirm dialog, filters sheet and share drawer.',
            'icon' => ['ios' => 'folder', 'android' => 'folder'],
            'screen' => Overlays::class,
        ],
    ],

];
