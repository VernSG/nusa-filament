<?php

namespace Vernsg\NusaFilament\Infolists\Components;

use Filament\Infolists\Components\TextEntry;
use Vernsg\NusaFilament\Support\NusaConfig;
use Vernsg\NusaFilament\Support\NusaOptions;
use Vernsg\NusaFilament\Support\NusaRegion;

class ProvinceEntry extends TextEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(NusaConfig::label('province'))
            ->formatStateUsing(fn (mixed $state): ?string => NusaOptions::label(NusaRegion::Province, $state))
            ->placeholder('-');
    }
}
