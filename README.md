# NativePHP UI — Kitchen Sink

A native mobile showcase for [**NativePHP UI**](https://nativephp-ui.codingwithrk.com) (`codingwithrk/nativephp-ui`): shadcn/ui-styled components for [NativePHP Mobile](https://nativephp.com/mobile) SuperNative screens. Every component in the plugin is shown here live, rendered as real **SwiftUI** on iOS and **Jetpack Compose** on Android. There's no web view.

The app is the native counterpart of the documentation site. Use it to see every component on a real device, try themes, and read working code for each example.

> **Heads up:** this app's source is MIT licensed, but it depends on **NativePHP UI**, a commercial plugin. To build it yourself you need a NativePHP UI license from the [CodingwithRK Marketplace](https://marketplace.codingwithrk.com/products/nativephp-ui). See [Requirements](#requirements).

## Features

- **52 components, 129 tags.** Every NativePHP UI component, with the same examples as the docs, all interactive: forms validate, sheets open, toasts float, tables sort.
- **Version switcher.** Browse the catalog as of 1.0.0, 1.0.1 or 1.1.0, with *New* and *Updated* badges for that release.
- **Theme playground.** Pick a base color, accent, radius and light/dark mode; it applies to the whole app instantly and is remembered across launches.
- **Templates.** Complete screens (dashboard, sign up, preferences, project list) built only from `<ui:*>` tags.
- **Native chrome.** A real tab bar, top bars with large titles, bottom sheets and a native side drawer.
- **In-app updates.** Checks your own endpoint for the latest Play Store / App Store release: an optional update shows a dialog the user can skip, and a forced update blocks the app until they update.
- **Google AdMob banners** on pushed screens, through `bhargavdetroja/nativephp-google-mobile-ads`. Optional; you can switch ads off.
- **Tested.** Pest feature tests cover every component page, both platforms' icons, theming, the version switcher and ads.

## Tech stack

| Package | Role |
|---|---|
| [Laravel](https://laravel.com) 13 | Application framework |
| [NativePHP Mobile](https://nativephp.com/mobile) 4.6 | PHP runtime on the device, SuperNative screens, EDGE elements |
| [nativephp/mobile-ui](https://github.com/NativePHP/mobile-ui) | Native controls, theming, side drawer |
| [codingwithrk/nativephp-ui](https://nativephp-ui.codingwithrk.com) 1.1 | The `<ui:*>` components (commercial) |
| [codingwithrk/package-info](https://github.com/codingwithrk/package-info) | App name, version and build on the About tab |
| [nativephp/mobile-browser](https://github.com/NativePHP/mobile-browser) | Opens links in the in-app browser |
| [bhargavdetroja/nativephp-google-mobile-ads](https://github.com/bhargavdetroja/nativephp-google-mobile-ads) | Google AdMob |

## Requirements

- PHP 8.3+ and Composer
- A **NativePHP UI license** and its marketplace credentials ([get one](https://marketplace.codingwithrk.com/products/nativephp-ui))
- For iOS: macOS with Xcode. For Android: Android Studio with an SDK, on macOS, Windows or Linux.
- A device or emulator. Ads need a real iPhone, or an Android emulator with a **Google APIs** system image.

## Getting started

1. **Clone the repository.**

   ```bash
   git clone https://github.com/codingwithrk/nativephp-ui-kitchen-sink.git
   cd nativephp-ui-kitchen-sink
   ```

2. **Add your marketplace credentials.** They're stored in `auth.json`, which is git-ignored, so they never get committed.

   ```bash
   composer config http-basic.marketplace.codingwithrk.com <username> <password>
   ```

3. **Install dependencies and create your environment file.**

   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set your app ID** in `.env`. It's the bundle / application ID, and it must be unique to you:

   ```dotenv
   NATIVEPHP_APP_ID=com.yourname.nativephpui
   ```

5. **Install the native projects and run the app.**

   ```bash
   php artisan native:install
   php artisan native:run android   # or: php artisan native:run ios
   ```

   For hot reload while you edit, use `php artisan native:run android --watch`.

## Ads

Banners are served through Google AdMob. While `APP_ENV` isn't `production`, the plugin uses **Google's test ads**, so you can build and run without an AdMob account.

To serve your own ads, create a **Banner** ad unit in AdMob and set these in `.env`:

```dotenv
ADMOB_APP_ID=ca-app-pub-XXXXXXXXXXXXXXXX~XXXXXXXXXX                      # Android App ID
ADMOB_IOS_APP_ID=ca-app-pub-XXXXXXXXXXXXXXXX~XXXXXXXXXX                  # iOS App ID (required for iOS builds)
ADMOB_ANCHORED_ADAPTIVE_BANNER_AD_UNIT_ID=ca-app-pub-XXXXXXXXXXXXXXXX/XXXXXXXXXX
```

Then set `APP_ENV=production` and run `php artisan native:install --force` before building.

- **Turn ads off:** set `ADMOB_ENABLED=false`.
- **Where banners appear:** at the bottom of component, group and template pages. They're never on tab screens, where the banner would cover the tab bar. A screen opts out with `protected bool $hidesBannerAd = true;`.

## In-app updates

When the app opens, it asks an endpoint you host for the latest store release, and compares it with the installed version (read on the device by `codingwithrk/package-info`). Set the URL in `.env`:

```dotenv
APP_UPDATE_URL=https://your-api.example.com/app-version
```

The app sends `GET {APP_UPDATE_URL}?platform=android&version=1.0.0` (or `platform=ios`). The endpoint can answer with just that platform's release:

```json
{ "version": "1.2.0", "force_update": false, "store_url": "https://play.google.com/store/apps/details?id=com.yourname.nativephpui", "message": null }
```

or with both platforms, keyed by name:

```json
{
  "android": {
    "version": "1.2.0",
    "force_update": false,
    "store_url": "https://play.google.com/store/apps/details?id=com.yourname.nativephpui",
    "message": null
  },
  "ios": {
    "version": "1.2.0",
    "force_update": true,
    "store_url": "https://apps.apple.com/app/id0000000000",
    "message": "This release fixes an important bug."
  }
}
```

| Field | Meaning |
|---|---|
| `version` | The latest version on that platform's store. Nothing happens unless it's newer than the installed app. |
| `force_update` | `true`: a full-screen "Update required" page that can't be dismissed. `false`: a dialog with *Update*, *Not now* and *Skip this version*. |
| `store_url` | The store page the *Update* button opens. Must be `https://`. |
| `message` | Optional text shown instead of the default. |

- **Caching:** the response is cached for 6 hours (`showcase.updates.cache_minutes`).
- **Failures are silent:** a failed or invalid request means "no update".
- **Offline:** while `nativephp/mobile-network` reports no connection, the API isn't called. A response cached from an earlier check still applies, so a forced update can't be bypassed in airplane mode.
- **Skipping:** *Skip this version* stays quiet until a newer version ships. Forced updates can't be skipped.
- **Turning it off:** leave `APP_UPDATE_URL` empty.

## Project structure

```
app/
├── NativeComponents/          # SuperNative screens
│   ├── Home.php, Themes.php, About.php
│   ├── Components/            # Component browser, group lists, sidebar demo
│   │   └── Examples/          # One screen per component (ButtonExample, …)
│   └── Templates/             # Template browser
├── NativeLayouts/             # The tab bar layout
├── Showcase/                  # Catalog, theme settings, docs version, banner ads
└── Ui/                        # The app's own <ui:*> tags (tiles, rows, chips, …)
config/
└── showcase.php               # The registry: groups, components, versions, templates, About content
resources/views/native/        # Blade views for every screen
routes/mobile.php              # Native routes, generated from the registry
tests/Feature/                 # Pest tests
```

### Adding a component page

The catalog is driven by `config/showcase.php`. To add a component:

1. Add an entry under `components` with its name, group, description, tags, `since` version and icon pair.
2. Scaffold its screen and view:

   ```bash
   php artisan showcase:component my-component
   ```

3. Write the examples in `resources/views/native/components/examples/my-component.blade.php`.

The route, the group listing, search, counts and *New* badges all follow from the registry.

## Testing

```bash
php artisan test --compact
```

Run `vendor/bin/pint` before committing to keep the code style consistent.

## Contributing

Contributions are welcome. Please read [CONTRIBUTING.md](CONTRIBUTING.md) and our [Code of Conduct](CODE_OF_CONDUCT.md) first.

## Security

Please don't open public issues for security problems. See [SECURITY.md](SECURITY.md) for how to report them privately.

## License

The source code of this app is open-sourced under the [MIT license](LICENSE).

**NativePHP UI** (`codingwithrk/nativephp-ui`) is **not** part of this repository and isn't covered by that license. It's commercial software, licensed separately through the [CodingwithRK Marketplace](https://marketplace.codingwithrk.com/products/nativephp-ui). Other dependencies keep their own licenses; the app's About tab lists them.

## Credits

- Built by [CodingwithRK](https://codingwithrk.com)
- Design system by [shadcn/ui](https://ui.shadcn.com)
- Powered by [NativePHP](https://nativephp.com) and [Laravel](https://laravel.com)
