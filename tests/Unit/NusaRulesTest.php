<?php

use Creasi\Nusa\Models\District;
use Creasi\Nusa\Models\Regency;
use Creasi\Nusa\Models\Village;
use Illuminate\Support\Facades\Validator;
use Vernsg\NusaFilament\Rules\NusaRules;

it('validates existing region codes', function (): void {
    $validator = Validator::make([
        'province_code' => '33',
    ], [
        'province_code' => [NusaRules::province()],
    ]);

    expect($validator->passes())->toBeTrue();
});

it('rejects invalid region codes', function (): void {
    $validator = Validator::make([
        'province_code' => 'missing',
    ], [
        'province_code' => [NusaRules::province()],
    ]);

    expect($validator->passes())->toBeFalse();
});

it('validates address hierarchy consistency', function (): void {
    $regency = Regency::query()->where('province_code', '33')->firstOrFail();
    $district = District::query()->where('regency_code', $regency->code)->firstOrFail();
    $village = Village::query()->where('district_code', $district->code)->firstOrFail();

    $validator = Validator::make([
        'province_code' => '33',
        'regency_code' => $regency->code,
        'district_code' => $district->code,
        'village_code' => $village->code,
    ], [
        'village_code' => [NusaRules::addressHierarchy()],
    ]);

    expect($validator->passes())->toBeTrue();
});

it('rejects mismatched address hierarchy', function (): void {
    $regency = Regency::query()->where('province_code', '33')->firstOrFail();

    $validator = Validator::make([
        'province_code' => '31',
        'regency_code' => $regency->code,
    ], [
        'regency_code' => [NusaRules::addressHierarchy()],
    ]);

    expect($validator->passes())->toBeFalse();
});
