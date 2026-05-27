<?php

namespace Vernsg\NusaFilament\Infolists\Components;

use Filament\Infolists\Components\TextEntry;
use Vernsg\NusaFilament\Support\NusaConfig;
use Vernsg\NusaFilament\Support\NusaOptions;

class NusaAddressEntry extends TextEntry
{
    protected string $provinceField;

    protected string $regencyField;

    protected string $districtField;

    protected string $villageField;

    public static function make(?string $name = null): static
    {
        return parent::make($name ?? 'nusa_address');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->provinceField = NusaConfig::field('province');
        $this->regencyField = NusaConfig::field('regency');
        $this->districtField = NusaConfig::field('district');
        $this->villageField = NusaConfig::field('village');

        $this
            ->label('Wilayah')
            ->state(fn (mixed $record): ?string => NusaOptions::formattedAddress(
                data_get($record, $this->provinceField),
                data_get($record, $this->regencyField),
                data_get($record, $this->districtField),
                data_get($record, $this->villageField),
            ))
            ->placeholder('-');
    }

    public function provinceField(string $field): static
    {
        $this->provinceField = $field;

        return $this;
    }

    public function regencyField(string $field): static
    {
        $this->regencyField = $field;

        return $this;
    }

    public function districtField(string $field): static
    {
        $this->districtField = $field;

        return $this;
    }

    public function villageField(string $field): static
    {
        $this->villageField = $field;

        return $this;
    }
}
