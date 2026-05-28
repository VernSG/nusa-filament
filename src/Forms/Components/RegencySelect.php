<?php

namespace Vernsg\NusaFilament\Forms\Components;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Vernsg\NusaFilament\Support\NusaConfig;
use Vernsg\NusaFilament\Support\NusaOptions;
use Vernsg\NusaFilament\Support\NusaRegion;

class RegencySelect extends Select
{
    protected string $provinceField;

    protected string $districtField;

    protected string $villageField;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provinceField = NusaConfig::field('province');
        $this->districtField = NusaConfig::field('district');
        $this->villageField = NusaConfig::field('village');

        $this
            ->label(NusaConfig::label('regency'))
            ->native(NusaConfig::native())
            ->position(NusaConfig::selectPosition())
            ->searchable()
            ->preload()
            ->live()
            ->disabled(fn (Get $get): bool => blank($get($this->provinceField)))
            ->options(fn (Get $get): array => filled($get($this->provinceField))
                ? NusaOptions::options(NusaRegion::Regency, $get($this->provinceField))
                : [])
            ->getSearchResultsUsing(fn (string $search, Get $get): array => NusaOptions::search(
                NusaRegion::Regency,
                $search,
                $get($this->provinceField),
            ))
            ->getOptionLabelUsing(fn (mixed $value): ?string => NusaOptions::label(NusaRegion::Regency, $value))
            ->afterStateUpdated(function (Set $set): void {
                $set($this->districtField, null);
                $set($this->villageField, null);
            });
    }

    public function provinceField(string $field): static
    {
        $this->provinceField = $field;

        return $this;
    }

    public function clearDistrictField(string $field): static
    {
        $this->districtField = $field;

        return $this;
    }

    public function clearVillageField(string $field): static
    {
        $this->villageField = $field;

        return $this;
    }
}
