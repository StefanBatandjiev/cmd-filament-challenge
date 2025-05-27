<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ServiceType: string implements HasLabel, HasColor
{
    case CLEANING = 'cleaning';
    case MAINTENANCE = 'maintenance';
    case INSPECTIONS = 'inspections';

    public function getLabel(): string
    {
        return match ($this) {
            self::CLEANING => 'Cleaning',
            self::MAINTENANCE => 'Maintenance',
            self::INSPECTIONS => 'Inspections',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::CLEANING => 'info',
            self::MAINTENANCE => 'warning',
            self::INSPECTIONS => 'danger',
        };
    }

    public function getPrice(): int
    {
        return match ($this) {
            self::CLEANING => 40,
            self::MAINTENANCE => 50,
            self::INSPECTIONS => 70,
        };
    }
}
