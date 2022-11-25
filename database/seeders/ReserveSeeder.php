<?php

namespace Database\Seeders;

use App\Enums\RoomEnum;
use App\Models\Reserve;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReserveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 31; $i++) {
            $user = User::find($i);
            $j = $i + rand(1, 139);
            $room = Room::find($j);
            Reserve::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
                'price' => $room->type->price(),
                'breakfast' => $room->type->breakfast(),
                'from_date'=>now(),
                'to_date'=>now()->addDays(rand(1,15)),
            ]);
        }
    }
}
