<?php

namespace Vernsg\NusaFilament\Forms\Components;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Vernsg\NusaFilament\Support\NusaConfig;

class NusaAddress extends Group
{
    protected string $provinceField;

    protected string $regencyField;

    protected string $districtField;

    protected string $villageField;

    protected string $postalCodeField;

    protected string $addressLineField;

    protected bool $hasPostalCode = true;

    protected bool $hasAddressLine = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provinceField = NusaConfig::field('province');
        $this->regencyField = NusaConfig::field('regency');
        $this->districtField = NusaConfig::field('district');
        $this->villageField = NusaConfig::field('village');
        $this->postalCodeField = NusaConfig::field('postal_code');
        $this->addressLineField = NusaConfig::field('address_line');

        $this->columns(2);
        $this->schema(fn (): array => $this->buildSchema());
    }

    public function province(string $field): static
    {
        $this->provinceField = $field;

        return $this;
    }

    public function regency(string $field): static
    {
        $this->regencyField = $field;

        return $this;
    }

    public function district(string $field): static
    {
        $this->districtField = $field;

        return $this;
    }

    public function village(string $field): static
    {
        $this->villageField = $field;

        return $this;
    }

    public function postalCode(string $field): static
    {
        $this->postalCodeField = $field;
        $this->hasPostalCode = true;

        return $this;
    }

    public function addressLine(string $field): static
    {
        $this->addressLineField = $field;
        $this->hasAddressLine = true;

        return $this;
    }

    public function withoutPostalCode(): static
    {
        $this->hasPostalCode = false;

        return $this;
    }

    public function withoutAddressLine(): static
    {
        $this->hasAddressLine = false;

        return $this;
    }

    /**
     * @return array<int, mixed>
     */
    protected function buildSchema(): array
    {
        $schema = [];

        if ($this->hasAddressLine) {
            $schema[] = TextInput::make($this->addressLineField)
                ->label(NusaConfig::label('address_line'))
                ->columnSpanFull();
        }

        $schema[] = ProvinceSelect::make($this->provinceField)
            ->clearRegencyField($this->regencyField)
            ->clearDistrictField($this->districtField)
            ->clearVillageField($this->villageField);

        $schema[] = RegencySelect::make($this->regencyField)
            ->provinceField($this->provinceField)
            ->clearDistrictField($this->districtField)
            ->clearVillageField($this->villageField);

        $schema[] = DistrictSelect::make($this->districtField)
            ->regencyField($this->regencyField)
            ->clearVillageField($this->villageField);

        $village = VillageSelect::make($this->villageField)
            ->districtField($this->districtField);

        if ($this->hasPostalCode) {
            $village->fillPostalCode($this->postalCodeField);
        }

        $schema[] = $village;

        if ($this->hasPostalCode) {
            $schema[] = TextInput::make($this->postalCodeField)
                ->label(NusaConfig::label('postal_code'))
                ->maxLength(10);
        }

        return $schema;
    }
}
