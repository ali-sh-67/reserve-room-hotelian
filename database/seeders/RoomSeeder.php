<?php

namespace Database\Seeders;

use App\Enums\RoomEnum;
use App\Models\Room;
use Illuminate\Database\Seeder;

/**
 *
 */
class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Room::factory(RoomEnum::ExecutiveOceanView->inventory(), ['type' => RoomEnum::ExecutiveOceanView])->create();
        Room::factory(RoomEnum::ExecutiveSuperior->inventory(), ['type' => RoomEnum::ExecutiveSuperior])->create();
        Room::factory(RoomEnum::HoneymoonSuite->inventory(), ['type' => RoomEnum::HoneymoonSuite])->create();
        Room::factory(RoomEnum::GardenView->inventory(), ['type' => RoomEnum::GardenView])->create();
        Room::factory(RoomEnum::LuxuryOceanView->inventory(), ['type' => RoomEnum::LuxuryOceanView])->create();
        Room::factory(RoomEnum::Standard->inventory(), ['type' => RoomEnum::Standard])->create();
        Room::factory(RoomEnum::StandardCityView->inventory(), ['type' => RoomEnum::StandardCityView])->create();
    }
}
