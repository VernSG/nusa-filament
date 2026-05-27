<?php

namespace Vernsg\NusaFilament\Tables\Filters;

use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Vernsg\NusaFilament\Forms\Components\NusaAddress;
use Vernsg\NusaFilament\Support\NusaConfig;

class NusaLocationFilter extends Filter
{
    protected string $provinceField;

    protected string $regencyField;

    protected string $districtField;

    protected string $villageField;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provinceField = NusaConfig::field('province');
        $this->regencyField = NusaConfig::field('regency');
        $this->districtField = NusaConfig::field('district');
        $this->villageField = NusaConfig::field('village');

        $this
            ->label('Wilayah')
            ->form(fn (): array => [
                NusaAddress::make()
                    ->province($this->provinceField)
                    ->regency($this->regencyField)
                    ->district($this->districtField)
                    ->village($this->villageField)
                    ->withoutAddressLine()
                    ->withoutPostalCode(),
            ])
            ->query(function (Builder $query, array $data): Builder {
                foreach ([
                    $this->provinceField,
                    $this->regencyField,
                    $this->districtField,
                    $this->villageField,
                ] as $field) {
                    $value = data_get($data, $field);

                    if (filled($value)) {
                        $query->where($field, $value);
                    }
                }

                return $query;
            });
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
