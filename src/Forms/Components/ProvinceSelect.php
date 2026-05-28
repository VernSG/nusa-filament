<?php

namespace Vernsg\NusaFilament\Forms\Components;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Set;
use Vernsg\NusaFilament\Support\NusaConfig;
use Vernsg\NusaFilament\Support\NusaOptions;
use Vernsg\NusaFilament\Support\NusaRegion;

class ProvinceSelect extends Select
{
    protected string $regencyField;

    protected string $districtField;

    protected string $villageField;

    protected function setUp(): void
    {
        parent::setUp();

        $this->regencyField = NusaConfig::field('regency');
        $this->districtField = NusaConfig::field('district');
        $this->villageField = NusaConfig::field('village');

        $this
            ->label(NusaConfig::label('province'))
            ->native(NusaConfig::native())
            ->position(NusaConfig::selectPosition())
            ->searchable()
            ->preload()
            ->live()
            ->options(fn (): array => NusaOptions::options(NusaRegion::Province))
            ->getSearchResultsUsing(fn (string $search): array => NusaOptions::search(NusaRegion::Province, $search))
            ->getOptionLabelUsing(fn (mixed $value): ?string => NusaOptions::label(NusaRegion::Province, $value))
            ->afterStateUpdated(function (Set $set): void {
                $set($this->regencyField, null);
                $set($this->districtField, null);
                $set($this->villageField, null);
            });
    }

    public function clearRegencyField(string $field): static
    {
        $this->regencyField = $field;

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
