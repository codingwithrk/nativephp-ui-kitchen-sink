# Security Policy

## Supported versions

Security fixes are made on the latest release of the app (the `main` branch). Older builds aren't patched.

## Reporting a vulnerability

**Please don't report security problems in public GitHub issues, discussions or pull requests.**

Report them privately, by either:

- [Opening a private security advisory](https://github.com/codingwithrk/nativephp-ui-kitchen-sink/security/advisories/new) on GitHub, or
- Emailing **connect@codingwithrk.com** with the subject "Security: nativephp-ui-kitchen-sink".

Please include:

- What the issue is and where it is (file, screen or dependency)
- Steps to reproduce it, or a proof of concept
- The impact you think it has
- The app version, platform (iOS or Android) and OS version, if relevant

## What to expect

- We'll acknowledge your report within **3 business days**.
- We'll keep you updated as we investigate, and aim to release a fix within **30 days** for confirmed issues, depending on severity.
- Once it's fixed, we'll credit you in the release notes unless you'd rather stay anonymous.

## Scope

In scope: the code in this repository.

Out of scope, so please report these to their maintainers:

- **NativePHP UI** (`codingwithrk/nativephp-ui`): report to connect@codingwithrk.com.
- **NativePHP Mobile** and **nativephp/mobile-ui**: see [nativephp.com](https://nativephp.com).
- **Google Mobile Ads SDK** and the AdMob plugin: report to their maintainers.

## Keeping your build safe

- Never commit `.env`, `auth.json` (your marketplace credentials), or anything in `credentials/` (keystores, signing keys). All of them are git-ignored; keep it that way.
- Keep `APP_DEBUG=false` and `APP_ENV=production` in release builds.
