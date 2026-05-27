<?php

namespace Vernsg\NusaFilament\Support;

enum NusaRegion: string
{
    case Province = 'province';
    case Regency = 'regency';
    case District = 'district';
    case Village = 'village';
}
