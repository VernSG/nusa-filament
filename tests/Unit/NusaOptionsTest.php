<?php

use Vernsg\NusaFilament\Support\NusaOptions;
use Vernsg\NusaFilament\Support\NusaRegion;

it('searches province options by name or code', function (): void {
    $results = NusaOptions::search(NusaRegion::Province, 'jawa');

    expect($results)->not->toBeEmpty();
});

it('returns default options for a selected parent region', function (): void {
    expect(NusaOptions::options(NusaRegion::Regency, '64'))
        ->toHaveKey('64.74', 'Kota Bontang')
        ->and(NusaOptions::options(NusaRegion::District, '64.74'))
        ->toHaveKey('64.74.01', 'Bontang Utara')
        ->and(NusaOptions::options(NusaRegion::Village, '64.74.01'))
        ->toHaveKey('64.74.01.1002', 'Bontang Baru');
});

it('returns a label for an existing province code', function (): void {
    expect(NusaOptions::label(NusaRegion::Province, '33'))->toBeString();
});

it('returns null for a missing label', function (): void {
    expect(NusaOptions::label(NusaRegion::Province, 'missing'))->toBeNull();
});
