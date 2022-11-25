<?php

namespace App\Enums;


/**
 *
 */
enum RoomEnum: string
{
    case ExecutiveOceanView = 'Executive Ocean View';
    case ExecutiveSuperior = 'Executive Superior';
    case HoneymoonSuite = 'Honeymoon Suite';
    case GardenView = 'Garden View';
    case LuxuryOceanView = 'Luxury Ocean View';
    case Standard = 'Standard';
    case StandardCityView = 'Standard City View';

    /**
     * @return int
     */
    public function inventory(): int
    {
        return match ($this) {
            RoomEnum::ExecutiveOceanView => 10,
            RoomEnum::ExecutiveSuperior => 15,
            RoomEnum::LuxuryOceanView, RoomEnum::HoneymoonSuite => 20,
            RoomEnum::GardenView => 25,
            RoomEnum::Standard => 30,
            RoomEnum::StandardCityView => 50,
        };
    }

    /**
     * @return int|null
     */
    public function breakfast(): ?int
    {
        return match ($this) {
            RoomEnum::ExecutiveOceanView, RoomEnum::ExecutiveSuperior => 30,
            RoomEnum::HoneymoonSuite => 50,
            RoomEnum::GardenView => 20,
            RoomEnum::LuxuryOceanView => 10,
            RoomEnum::Standard, RoomEnum::StandardCityView => null,
        };
    }

    /**
     * @return int
     */
    public function price(): int
    {
        return match ($this) {
            RoomEnum::ExecutiveOceanView => 100,
            RoomEnum::ExecutiveSuperior => 90,
            RoomEnum::HoneymoonSuite => 80,
            RoomEnum::GardenView => 70,
            RoomEnum::LuxuryOceanView => 60,
            RoomEnum::Standard, RoomEnum::StandardCityView => 50,
        };
    }
}
