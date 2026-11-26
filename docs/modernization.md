# Encore Cloud modernization

Target: PHP 8.4 and Laravel 13, subject to dependency compatibility. Keep the current application operational until replacements are verified.

## Implementation rules

- Inventory routes, controllers, models, views, assets, scheduled commands and integration contracts before removing code.
- Establish regression tests before consolidating duplicate implementations.
- Use Form Requests, Eloquent relationships, policies, named routes and focused services/actions. Keep helpers small and side-effect free where practical.
- Preserve existing public URLs, business calculations, authorization and responsive design.
- Consolidate Blade components, JavaScript modules and CSS; adopt modern libraries only after checking accessibility, compatibility and feature parity.
- Build a fresh schema with reversible migrations, InnoDB, utf8mb4, consistent keys and decimal money amounts. Document old-to-new field mappings. Do not import business records or seed master data without approval.
- Bootstrap only the development administrator; production provisioning must use a strong unique password. Never commit environment secrets.
- Keep payment and shipping integration tests isolated from live services.

## Delivery sequence

1. Repository hygiene, inventory and characterization tests.
2. Dependency compatibility and framework foundation.
3. Database migrations and authentication.
4. Shared UI and configuration.
5. CRM, catalog, orders, payments, shipping, team store, customer portal, remaining modules.
6. Regression, responsive, security and performance verification.

Each change must be independently reviewable. Do not deploy a partially migrated module or run destructive migrations against an existing database.
