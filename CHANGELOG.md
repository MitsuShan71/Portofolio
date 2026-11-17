# Changelog

## Portfolio feature update

- Added percentage-based hard/soft skills, editable profile and CV, project details/preview, certificates, and PLK/organization/competition experience management.
- Added visitor contact and feedback forms with admin inboxes, responsive navigation, theme switching, and project detail dialogs.
- Admin access: configure a Gmail address in `ADMIN_EMAIL` and set `ADMIN_PASSWORD` in `.env`, then sign in at `/admin/login`.
- Apply database updates with `php artisan migrate --force`; run frontend assets with `npm run build`.

- Added subtle section-entry reveals for one-page navigation, with reduced-motion support.

- Rebuilt the portfolio header with grouped actions, non-wrapping desktop links, and an accessible compact menu for smaller screens.

- Widened the home call-to-action buttons and prevented label wrapping across tablet and mobile layouts.

- Shifted the header logo slightly left to align with the requested spacing.

## 2026-11-15

- Added editable technology-interest/focus information to the About section.

- Smoothed anchor scrolling, made section reveals play once, and extended light/dark color transitions to 550 ms.
