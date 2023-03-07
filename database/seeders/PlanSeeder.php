<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\Promo;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create(['name' => 'Basic', 'price' => 5, 'presentations' => 1]);
        Plan::create(['name' => 'Advanced', 'price' => 45, 'presentations' => 10]);
        Plan::create(['name' => 'Professional', 'price' => 425, 'presentations' => 100]);

        Promo::create(['plan_id' => 1, 'code' => 'sasa1', 'multiple' => true]);
        Promo::create(['plan_id' => 2, 'code' => 'sasa2']);
    }
}
