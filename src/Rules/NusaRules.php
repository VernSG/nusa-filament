<?php

namespace Vernsg\NusaFilament\Rules;

use Vernsg\NusaFilament\Support\NusaRegion;

class NusaRules
{
    public static function province(): ValidNusaCode
    {
        return new ValidNusaCode(NusaRegion::Province);
    }

    public static function regency(): ValidNusaCode
    {
        return new ValidNusaCode(NusaRegion::Regency);
    }

    public static function district(): ValidNusaCode
    {
        return new ValidNusaCode(NusaRegion::District);
    }

    public static function village(): ValidNusaCode
    {
        return new ValidNusaCode(NusaRegion::Village);
    }

    public static function addressHierarchy(
        ?string $provinceField = null,
        ?string $regencyField = null,
        ?string $districtField = null,
        ?string $villageField = null,
    ): ValidNusaHierarchy {
        return new ValidNusaHierarchy($provinceField, $regencyField, $districtField, $villageField);
    }
}
