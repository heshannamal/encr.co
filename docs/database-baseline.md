# Database compatibility baseline

The 2026-11-26 structure-only export contains 263 tables. The opt-in baseline migration creates 262 application tables, plus Laravel's own migration repository. It applies four original ALTER TABLE statements (five foreign keys). It imports no business or master records. The users table uses InnoDB to support transactional bootstrap; other explicit storage engines and column definitions are preserved until module-level review. Eight tables without explicit engines continue to use the database/server defaults. Use MySQL 8.4 with InnoDB and utf8mb4 defaults for this test.

## Local installation only

Create a new empty database named `encorecu_refactor` with a dedicated local database user. Do not point the application at a production database. Keep the existing `.env` outside version control. Set `APP_ENV=local`, `DB_CONNECTION=mysql`, `DB_DATABASE=encorecu_refactor` and the appropriate local database credentials. Set `BOOTSTRAP_ADMIN_EMAIL` and `BOOTSTRAP_ADMIN_PASSWORD` locally. Never commit passwords or live credentials; disable live payment, shipping, email and external integrations during testing.

From the project root, after installing the existing application's Composer dependencies:

```bash
php artisan config:clear
php artisan migrate --path=database/migrations/baseline
php artisan db:seed
```

The administrator seeder is intended for an empty users table and creates the Super Admin role and its assignment. Other master records remain empty. Do not run ordinary `php artisan migrate` against the baseline database until the legacy migration history has been reconciled. Do not run `migrate:fresh` against an existing database.

## Verification

- Confirm the selected database is the isolated refactor database.
- Confirm 262 application tables and Laravel's migrations table exist.
- Confirm all five original foreign keys exist and users uses InnoDB.
- Confirm only the bootstrap administrator and required role/assignment are created by the seeder; no business data.
- Test administrator login and permission checks before migrating modules.
- If MySQL rejects a statement, record its exact error and use a new empty scratch database for the corrected migration. MySQL DDL is not atomic across the entire baseline.

## Next steps

Treat this baseline as a compatibility reference, not the final normalized schema. Reconcile legacy migrations, then use Laravel Schema Builder and explicit forward migrations to normalize tables, keys, money types, date types, charset/collation and relationships in dependency order. Maintain an old-to-new field map and characterization tests for each module. The baseline intentionally lives in a subdirectory so ordinary existing migration runs do not execute it automatically.
