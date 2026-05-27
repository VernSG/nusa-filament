<?php

use Vernsg\NusaFilament\Forms\Components\DistrictSelect;
use Vernsg\NusaFilament\Forms\Components\NusaAddress;
use Vernsg\NusaFilament\Forms\Components\ProvinceSelect;
use Vernsg\NusaFilament\Forms\Components\RegencySelect;
use Vernsg\NusaFilament\Forms\Components\VillageSelect;
use Vernsg\NusaFilament\Infolists\Components\NusaAddressEntry;
use Vernsg\NusaFilament\Tables\Columns\ProvinceColumn;
use Vernsg\NusaFilament\Tables\Filters\NusaLocationFilter;

it('creates form components with default field names', function (): void {
    expect(ProvinceSelect::make('province_code'))->toBeInstanceOf(ProvinceSelect::class)
        ->and(RegencySelect::make('regency_code'))->toBeInstanceOf(RegencySelect::class)
        ->and(DistrictSelect::make('district_code'))->toBeInstanceOf(DistrictSelect::class)
        ->and(VillageSelect::make('village_code'))->toBeInstanceOf(VillageSelect::class);
});

it('creates the address form group', function (): void {
    expect(NusaAddress::make())->toBeInstanceOf(NusaAddress::class);
});

it('creates table and infolist components', function (): void {
    expect(ProvinceColumn::make('province_code'))->toBeInstanceOf(ProvinceColumn::class)
        ->and(NusaLocationFilter::make('location'))->toBeInstanceOf(NusaLocationFilter::class)
        ->and(NusaAddressEntry::make())->toBeInstanceOf(NusaAddressEntry::class);
});
