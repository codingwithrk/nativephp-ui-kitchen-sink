# Contributing

Thanks for helping improve the NativePHP UI Kitchen Sink. Bug reports, fixes, new examples and templates are all welcome.

## Before you start

- **Bugs and ideas:** search the [issues](https://github.com/codingwithrk/nativephp-ui-kitchen-sink/issues) first, then open a new one with steps to reproduce, the platform (iOS or Android) and the device or emulator.
- **Bugs in a component itself,** such as how a `<ui:*>` tag renders, belong to NativePHP UI. Report them to connect@codingwithrk.com.
- **Security issues:** don't open an issue. Follow [SECURITY.md](SECURITY.md).
- **Bigger changes:** open an issue to discuss it before you write the code.

## Development setup

Follow [Getting started](README.md#getting-started) in the README. You'll need a NativePHP UI license to install dependencies.

## Making a change

1. Fork the repository and create a branch from `main`, for example `fix/otp-caret` or `feature/checkout-template`.
2. Follow the existing structure and naming:
   - Screens are `NativeComponent` classes in `app/NativeComponents`, with views in `resources/views/native`.
   - Style with Tailwind classes and theme tokens (`bg-theme-ui-card`, `text-theme-ui-muted-foreground`), never hard-coded colors.
   - Give every icon both an SF Symbol (iOS) and a Material name (Android).
   - New component pages start from `php artisan showcase:component {slug}`, after adding the component to `config/showcase.php`.
3. Add or update tests for behavior you change.
4. Run the checks:

   ```bash
   vendor/bin/pint
   php artisan test --compact
   ```

5. Try your change on a device or emulator if it affects what's on screen. Say which platform(s) you tested in the pull request.
6. Open a pull request against `main` with a clear description, and screenshots for visual changes.

## Commit messages

Write the subject line in the imperative ("Add checkout template", "Fix OTP caret on Android") and keep it under about 72 characters.

## Code of Conduct

By taking part you agree to follow our [Code of Conduct](CODE_OF_CONDUCT.md).

## License

By contributing, you agree that your contributions are licensed under the [MIT license](LICENSE).
