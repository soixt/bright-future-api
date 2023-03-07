<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sport;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sports = ["Men's Alpine Skiing","Women's Alpine Skiing","Men's Baseball","Women's Baseball","Men's Basketball","Women's Basketball","Men's Beach Volleyball","Women's Beach Volleyball","Men's Bowling","Women's Bowling","Men's Cheer & Spirit","Women's Cheer & Spirit","Men's Cheerleader / Dance","Women's Cheerleader / Dance","Men's Cross Country","Women's Cross Country","Men's Dance","Women's Dance","Men's Field Hockey","Women's Field Hockey","Men's Football","Women's Football","Men's Golf","Women's Golf","Men's Hockey","Women's Hockey","Men's Ice Hockey","Women's Ice Hockey","Men's Indoor Track","Women's Indoor Track","Men's Lacrosse","Women's Lacrosse","Men's Rugby","Women's Rugby","Men's Swimming","Women's Swimming","Men's Swimming and Diving","Women's Swimming and Diving","Men's Tennis","Women's Tennis","Men's Track & Field/Cross Country","Women's Track & Field/Cross Country","Men's Nordic Skiing","Women's Nordic Skiing","Men's Rifle","Women's Rifle","Men's Soccer","Women's Soccer","Men's Squash","Women's Squash","Men's Volleyball","Women's Volleyball","Men's Skiing","Women's Skiing","Men's Softball","Women's Softball","Men's Wrestling","Women's Wrestling"];
        foreach ($sports as $sport) {
            Sport::create(['name' => $sport]);
        }
    }
}
