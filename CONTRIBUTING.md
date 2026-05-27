# Contributing

Thank you for considering a contribution to Nusa Filament.

This package is intended to stay small, predictable, and easy to use inside Filament resources. Contributions are welcome when they improve compatibility, correctness, documentation, tests, or the developer experience without adding unnecessary complexity.

## Development Setup

Install dependencies:

```bash
composer install
```

Run the test suite:

```bash
composer test
```

Run static analysis:

```bash
composer analyse
```

Check code style:

```bash
composer format:test
```

Fix code style:

```bash
composer format
```

## Pull Request Guidelines

- Keep changes focused on one concern.
- Add or update tests for behavior changes.
- Update the README when public APIs or usage examples change.
- Keep public method names consistent with the existing component style.
- Avoid breaking changes unless they are necessary and clearly documented.

## Coding Style

This project uses Laravel Pint. Run `composer format` before opening a pull request.

## Reporting Bugs

When reporting a bug, include:

- package version;
- Laravel version;
- Filament version;
- PHP version;
- a short reproduction snippet;
- expected behavior and actual behavior.

## Feature Requests

Feature requests are welcome. Please describe the Filament use case clearly and explain why it belongs in this package instead of application code.
