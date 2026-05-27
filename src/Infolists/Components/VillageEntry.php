<?php

namespace Vernsg\NusaFilament\Infolists\Components;

use Filament\Infolists\Components\TextEntry;
use Vernsg\NusaFilament\Support\NusaConfig;
use Vernsg\NusaFilament\Support\NusaOptions;
use Vernsg\NusaFilament\Support\NusaRegion;

class VillageEntry extends TextEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(NusaConfig::label('village'))
            ->formatStateUsing(fn (mixed $state): ?string => NusaOptions::label(NusaRegion::Village, $state))
            ->placeholder('-');
    }
}
