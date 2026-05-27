<?php

namespace Vernsg\NusaFilament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Vernsg\NusaFilament\Support\NusaConfig;
use Vernsg\NusaFilament\Support\NusaOptions;
use Vernsg\NusaFilament\Support\NusaRegion;

class ProvinceColumn extends TextColumn
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
