<?php

use Vernsg\NusaFilament\Support\NusaOptions;
use Vernsg\NusaFilament\Support\NusaRegion;

it('searches province options by name or code', function (): void {
    $results = NusaOptions::search(NusaRegion::Province, 'jawa');

    expect($results)->not->toBeEmpty();
});

it('returns a label for an existing province code', function (): void {
    expect(NusaOptions::label(NusaRegion::Province, '33'))->toBeString();
});

it('returns null for a missing label', function (): void {
    expect(NusaOptions::label(NusaRegion::Province, 'missing'))->toBeNull();
});
