<?php

namespace Vernsg\NusaFilament\Support;

use Creasi\Nusa\Models\District;
use Creasi\Nusa\Models\Province;
use Creasi\Nusa\Models\Regency;
use Creasi\Nusa\Models\Village;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NusaOptions
{
    /**
     * @return array<string, string>
     */
    public static function options(NusaRegion $region, ?string $parentCode = null): array
    {
        return self::search($region, '', $parentCode);
    }

    /**
     * @return array<string, string>
     */
    public static function search(NusaRegion $region, string $search = '', ?string $parentCode = null): array
    {
        return self::query($region, $parentCode)
            ->when($search !== '', fn (Builder $query) => $query->where(function (Builder $query) use ($search): void {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            }))
            ->orderBy('name')
            ->limit(NusaConfig::searchLimit())
            ->pluck('name', 'code')
            ->all();
    }

    public static function label(NusaRegion $region, mixed $code): ?string
    {
        if (blank($code)) {
            return null;
        }

        $name = self::model($region)::query()
            ->where('code', $code)
            ->value('name');

        return is_string($name) ? $name : null;
    }

    public static function postalCode(mixed $villageCode): ?string
    {
        if (blank($villageCode)) {
            return null;
        }

        /** @var mixed $postalCode */
        $postalCode = Village::query()
            ->where('code', $villageCode)
            ->value('postal_code');

        return filled($postalCode) ? (string) $postalCode : null;
    }

    public static function exists(NusaRegion $region, mixed $code): bool
    {
        if (blank($code)) {
            return false;
        }

        return self::model($region)::query()
            ->where('code', $code)
            ->exists();
    }

    public static function belongsTo(NusaRegion $region, mixed $code, mixed $parentCode): bool
    {
        if (blank($code) || blank($parentCode)) {
            return false;
        }

        $column = match ($region) {
            NusaRegion::Regency => 'province_code',
            NusaRegion::District => 'regency_code',
            NusaRegion::Village => 'district_code',
            NusaRegion::Province => null,
        };

        if ($column === null) {
            return false;
        }

        return self::model($region)::query()
            ->where('code', $code)
            ->where($column, $parentCode)
            ->exists();
    }

    public static function formattedAddress(
        mixed $provinceCode,
        mixed $regencyCode,
        mixed $districtCode,
        mixed $villageCode,
        ?string $separator = ', ',
    ): ?string {
        $parts = array_filter([
            self::label(NusaRegion::Village, $villageCode),
            self::label(NusaRegion::District, $districtCode),
            self::label(NusaRegion::Regency, $regencyCode),
            self::label(NusaRegion::Province, $provinceCode),
        ]);

        if ($parts === []) {
            return null;
        }

        return implode($separator, $parts);
    }

    /**
     * @return Builder<Model>
     */
    private static function query(NusaRegion $region, ?string $parentCode = null): Builder
    {
        return self::model($region)::query()
            ->when(filled($parentCode), function (Builder $query) use ($region, $parentCode): void {
                match ($region) {
                    NusaRegion::Regency => $query->where('province_code', $parentCode),
                    NusaRegion::District => $query->where('regency_code', $parentCode),
                    NusaRegion::Village => $query->where('district_code', $parentCode),
                    NusaRegion::Province => null,
                };
            });
    }

    /**
     * @return class-string<Model>
     */
    private static function model(NusaRegion $region): string
    {
        return match ($region) {
            NusaRegion::Province => Province::class,
            NusaRegion::Regency => Regency::class,
            NusaRegion::District => District::class,
            NusaRegion::Village => Village::class,
        };
    }
}
