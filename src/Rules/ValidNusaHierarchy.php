<?php

namespace Vernsg\NusaFilament\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Vernsg\NusaFilament\Support\NusaConfig;
use Vernsg\NusaFilament\Support\NusaOptions;
use Vernsg\NusaFilament\Support\NusaRegion;

class ValidNusaHierarchy implements DataAwareRule, ValidationRule
{
    /**
     * @var array<string, mixed>
     */
    private array $data = [];

    public function __construct(
        private readonly ?string $provinceField = null,
        private readonly ?string $regencyField = null,
        private readonly ?string $districtField = null,
        private readonly ?string $villageField = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $provinceCode = data_get($this->data, $this->provinceField ?? NusaConfig::field('province'));
        $regencyCode = data_get($this->data, $this->regencyField ?? NusaConfig::field('regency'));
        $districtCode = data_get($this->data, $this->districtField ?? NusaConfig::field('district'));
        $villageCode = data_get($this->data, $this->villageField ?? NusaConfig::field('village'));

        if (filled($regencyCode) && ! NusaOptions::belongsTo(NusaRegion::Regency, $regencyCode, $provinceCode)) {
            $fail('Kabupaten/kota tidak sesuai dengan provinsi yang dipilih.');

            return;
        }

        if (filled($districtCode) && ! NusaOptions::belongsTo(NusaRegion::District, $districtCode, $regencyCode)) {
            $fail('Kecamatan tidak sesuai dengan kabupaten/kota yang dipilih.');

            return;
        }

        if (filled($villageCode) && ! NusaOptions::belongsTo(NusaRegion::Village, $villageCode, $districtCode)) {
            $fail('Desa/kelurahan tidak sesuai dengan kecamatan yang dipilih.');
        }
    }
}
