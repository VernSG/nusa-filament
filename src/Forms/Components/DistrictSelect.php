<?php

namespace Vernsg\NusaFilament\Forms\Components;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Vernsg\NusaFilament\Support\NusaConfig;
use Vernsg\NusaFilament\Support\NusaOptions;
use Vernsg\NusaFilament\Support\NusaRegion;

class DistrictSelect extends Select
{
    protected string $regencyField;

    protected string $villageField;

    protected function setUp(): void
    {
        parent::setUp();

        $this->regencyField = NusaConfig::field('regency');
        $this->villageField = NusaConfig::field('village');

        $this
            ->label(NusaConfig::label('district'))
            ->native(NusaConfig::native())
            ->searchable()
            ->live()
            ->disabled(fn (Get $get): bool => blank($get($this->regencyField)))
            ->getSearchResultsUsing(fn (string $search, Get $get): array => NusaOptions::search(
                NusaRegion::District,
                $search,
                $get($this->regencyField),
            ))
            ->getOptionLabelUsing(fn (mixed $value): ?string => NusaOptions::label(NusaRegion::District, $value))
            ->afterStateUpdated(fn (Set $set) => $set($this->villageField, null));
    }

    public function regencyField(string $field): static
    {
        $this->regencyField = $field;

        return $this;
    }

    public function clearVillageField(string $field): static
    {
        $this->villageField = $field;

        return $this;
    }
}
