# Josh Griffin Photography

PHP 8.1+ / MySQL 8+ photography website with private client galleries.

## Requirements
- PHP 8.1 or newer
- MySQL 8.0 or MariaDB equivalent
- PHP extensions: PDO, pdo_mysql, fileinfo, and GD (GD is recommended)
- HTTPS for any public production deployment

## Install
1. Upload the project to your PHP hosting account.
2. Create the database by importing `database/schema.sql` in phpMyAdmin or MySQL.
3. Edit `config.php` with your database credentials. Set `BASE_URL` if installed in a subdirectory or behind a URL prefix.
4. Create a private upload directory outside your public website root. By default the app uses `../jgp-private-uploads` relative to this project. Make it writable by the PHP process, but not publicly accessible.
5. From a terminal, run:
   `php scripts/create_admin.php admin@example.com "Use-A-Long-Unique-Password"`
   The password must be at least 14 characters. Delete `scripts/create_admin.php` after creating the administrator.
6. Visit `index.php`, sign in through Client Login, and use the admin dashboard.

## Typical workflow
1. Admin creates a client account in Admin → Manage clients.
2. Admin creates a gallery and assigns it to that client.
3. Admin opens the gallery and uploads JPG, PNG, or WebP photos (15 MB maximum each).
4. Client signs in and sees only galleries assigned to their account.
5. Client adds favorite photos in the gallery.

## Important production notes
- Use HTTPS. Do not run a photography client portal over plain HTTP.
- Keep `jgp-private-uploads` outside the public document root. Do not put private original photos in `assets/images`.
- Change database credentials and use a dedicated database user with only required permissions.
- Back up the database and private uploads.
- This starter includes secure login, prepared SQL statements, password hashing, CSRF checks, access checks, and random stored filenames. Before accepting paying clients, add rate limiting, password reset/invitation emails, audit logging, and tested backup/restore procedures.
- The public portfolio uses placeholder image paths in `assets/images/`: add `hero.jpg`, `about.jpg`, `events.jpg`, and `portraits.jpg`.
- The client photo view currently displays web-sized originals. For a large photo business, generate resized preview images and watermarked proofs, and provide controlled downloads as a separate feature.
- The app does not yet include payments, print ordering, bulk download, or automated email notifications.
