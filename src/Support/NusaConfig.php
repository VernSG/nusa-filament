<?php

namespace Vernsg\NusaFilament\Support;

class NusaConfig
{
    public static function field(string $key): string
    {
        return (string) config("nusa-filament.fields.{$key}", match ($key) {
            'province' => 'province_code',
            'regency' => 'regency_code',
            'district' => 'district_code',
            'village' => 'village_code',
            'postal_code' => 'postal_code',
            'address_line' => 'address_line',
            default => $key,
        });
    }

    public static function label(string $key): string
    {
        return (string) config("nusa-filament.labels.{$key}", match ($key) {
            'province' => 'Provinsi',
            'regency' => 'Kabupaten/Kota',
            'district' => 'Kecamatan',
            'village' => 'Desa/Kelurahan',
            'postal_code' => 'Kode Pos',
            'address_line' => 'Alamat',
            default => str($key)->headline()->toString(),
        });
    }

    public static function searchLimit(): int
    {
        return max(1, (int) config('nusa-filament.search_limit', 50));
    }

    public static function native(): bool
    {
        return (bool) config('nusa-filament.native', false);
    }

    public static function selectPosition(): ?string
    {
        $position = config('nusa-filament.select_position', 'bottom');

        return blank($position) ? null : (string) $position;
    }
}
