<?php

namespace Vernsg\NusaFilament\Forms\Components;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Vernsg\NusaFilament\Support\NusaConfig;
use Vernsg\NusaFilament\Support\NusaOptions;
use Vernsg\NusaFilament\Support\NusaRegion;

class VillageSelect extends Select
{
    protected string $districtField;

    protected ?string $postalCodeField = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->districtField = NusaConfig::field('district');

        $this
            ->label(NusaConfig::label('village'))
            ->native(NusaConfig::native())
            ->searchable()
            ->live()
            ->disabled(fn (Get $get): bool => blank($get($this->districtField)))
            ->getSearchResultsUsing(fn (string $search, Get $get): array => NusaOptions::search(
                NusaRegion::Village,
                $search,
                $get($this->districtField),
            ))
            ->getOptionLabelUsing(fn (mixed $value): ?string => NusaOptions::label(NusaRegion::Village, $value))
            ->afterStateUpdated(function (Set $set, mixed $state): void {
                if ($this->postalCodeField === null) {
                    return;
                }

                $set($this->postalCodeField, NusaOptions::postalCode($state));
            });
    }

    public function districtField(string $field): static
    {
        $this->districtField = $field;

        return $this;
    }

    public function fillPostalCode(?string $field = null): static
    {
        $this->postalCodeField = $field ?? NusaConfig::field('postal_code');

        return $this;
    }
}
