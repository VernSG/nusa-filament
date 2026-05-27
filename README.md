# Nusa Filament

Ready-to-use Filament 4 components for Indonesian administrative regions powered by [`creasi/laravel-nusa`](https://github.com/creasico/laravel-nusa).

`vernsg/nusa-filament` helps Filament resources work with provinsi, kabupaten/kota, kecamatan, desa/kelurahan, postal codes, and address fields without rebuilding the same dependent selects, display columns, filters, and validation rules in every project.

## Features

- Filament 4 form components for cascading Indonesian region selects.
- A full address form group with sensible default field names.
- Table columns that display region names from stored region codes.
- Table filter for province, regency, district, and village fields.
- Infolist entries for readable address display.
- Laravel validation rules for valid region codes and address hierarchy consistency.
- Configurable labels, field names, search limit, and native select behavior.

## Requirements

- PHP 8.2 or higher.
- Laravel 11 or 12.
- Filament 4.
- PHP `sqlite3` extension.

Laravel Nusa stores its region dataset in SQLite, so the `sqlite3` PHP extension must be enabled in the application that installs this package.

## Installation

Install the package with Composer:

```bash
composer require vernsg/nusa-filament
```

Laravel package auto-discovery registers the service provider automatically.

Publish the config file when you want to change the default field names, labels, search limit, or select behavior:

```bash
php artisan vendor:publish --tag=nusa-filament-config
```

The published config will be available at `config/nusa-filament.php`.

## Quick Start

Use `NusaAddress` in a Filament resource form when you want the full address block:

```php
use Vernsg\NusaFilament\Forms\Components\NusaAddress;

public static function form(Schema $schema): Schema
{
    return $schema
        ->components([
            NusaAddress::make(),
        ]);
}
```

By default the component uses these model attributes:

```text
address_line
province_code
regency_code
district_code
village_code
postal_code
```

## Forms

### Full Address Group

```php
use Vernsg\NusaFilament\Forms\Components\NusaAddress;

NusaAddress::make();
```

Customize field names when your model uses different columns:

```php
NusaAddress::make()
    ->addressLine('shipping_address')
    ->province('shipping_province_code')
    ->regency('shipping_regency_code')
    ->district('shipping_district_code')
    ->village('shipping_village_code')
    ->postalCode('shipping_postal_code');
```

Hide optional fields:

```php
NusaAddress::make()
    ->withoutAddressLine()
    ->withoutPostalCode();
```

### Individual Selects

Use the individual components when you want to place fields manually:

```php
use Vernsg\NusaFilament\Forms\Components\DistrictSelect;
use Vernsg\NusaFilament\Forms\Components\ProvinceSelect;
use Vernsg\NusaFilament\Forms\Components\RegencySelect;
use Vernsg\NusaFilament\Forms\Components\VillageSelect;

ProvinceSelect::make('province_code');

RegencySelect::make('regency_code')
    ->provinceField('province_code');

DistrictSelect::make('district_code')
    ->regencyField('regency_code');

VillageSelect::make('village_code')
    ->districtField('district_code')
    ->fillPostalCode('postal_code');
```

The selects are searchable and load options remotely, so large village datasets are not preloaded into the page.

## Tables

Display region names from stored codes:

```php
use Vernsg\NusaFilament\Tables\Columns\DistrictColumn;
use Vernsg\NusaFilament\Tables\Columns\ProvinceColumn;
use Vernsg\NusaFilament\Tables\Columns\RegencyColumn;
use Vernsg\NusaFilament\Tables\Columns\VillageColumn;

return $table
    ->columns([
        ProvinceColumn::make('province_code'),
        RegencyColumn::make('regency_code'),
        DistrictColumn::make('district_code'),
        VillageColumn::make('village_code'),
    ]);
```

Add the location filter:

```php
use Vernsg\NusaFilament\Tables\Filters\NusaLocationFilter;

return $table
    ->filters([
        NusaLocationFilter::make('location'),
    ]);
```

Customize filter field names:

```php
NusaLocationFilter::make('shipping_location')
    ->provinceField('shipping_province_code')
    ->regencyField('shipping_regency_code')
    ->districtField('shipping_district_code')
    ->villageField('shipping_village_code');
```

## Infolists

Use the full address entry:

```php
use Vernsg\NusaFilament\Infolists\Components\NusaAddressEntry;

NusaAddressEntry::make();
```

Or use individual entries:

```php
use Vernsg\NusaFilament\Infolists\Components\DistrictEntry;
use Vernsg\NusaFilament\Infolists\Components\ProvinceEntry;
use Vernsg\NusaFilament\Infolists\Components\RegencyEntry;
use Vernsg\NusaFilament\Infolists\Components\VillageEntry;

ProvinceEntry::make('province_code');
RegencyEntry::make('regency_code');
DistrictEntry::make('district_code');
VillageEntry::make('village_code');
```

## Validation

```php
use Vernsg\NusaFilament\Rules\NusaRules;

[
    'province_code' => ['required', NusaRules::province()],
    'regency_code' => ['required', NusaRules::regency()],
    'district_code' => ['required', NusaRules::district()],
    'village_code' => [
        'required',
        NusaRules::village(),
        NusaRules::addressHierarchy(),
    ],
]
```

`addressHierarchy()` validates that:

- the regency belongs to the selected province;
- the district belongs to the selected regency;
- the village belongs to the selected district.

## Configuration

Publish the config:

```bash
php artisan vendor:publish --tag=nusa-filament-config
```

Available options:

```php
return [
    'fields' => [
        'province' => 'province_code',
        'regency' => 'regency_code',
        'district' => 'district_code',
        'village' => 'village_code',
        'postal_code' => 'postal_code',
        'address_line' => 'address_line',
    ],

    'labels' => [
        'province' => 'Provinsi',
        'regency' => 'Kabupaten/Kota',
        'district' => 'Kecamatan',
        'village' => 'Desa/Kelurahan',
        'postal_code' => 'Kode Pos',
        'address_line' => 'Alamat',
    ],

    'search_limit' => 50,

    'native' => false,
];
```

## Development

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

## Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for notable changes.

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for contribution guidelines.

## Security

Please see [SECURITY.md](SECURITY.md) for the security policy.

## License

The MIT License. Please see [LICENSE.md](LICENSE.md) for details.
