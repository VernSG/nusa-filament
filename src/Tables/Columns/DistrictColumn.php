<?php

namespace Vernsg\NusaFilament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Vernsg\NusaFilament\Support\NusaConfig;
use Vernsg\NusaFilament\Support\NusaOptions;
use Vernsg\NusaFilament\Support\NusaRegion;

class DistrictColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(NusaConfig::label('district'))
            ->formatStateUsing(fn (mixed $state): ?string => NusaOptions::label(NusaRegion::District, $state))
            ->placeholder('-');
    }
}
