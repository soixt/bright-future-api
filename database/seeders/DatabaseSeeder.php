<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SportSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(SchoolSeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(ConfigurationSeeder::class);

        $user = User::create([
            "name" => "Sasa Orasanin",
            "email" => "drsasaorasanin@gmail.com",
            "password" => bcrypt("sasasasa"),
            "role" => User::setRole("athlete"),
            "username" => User::generateUsername("Sasa Orasanin")
        ]);
        $user->extended()->create([
            "location" => "Belgrade, Serbia",
            "gender" => "male",
            "bday" => "1996-06-22 16:00:25"
        ]);
        $user->sports()->attach(1);

        $user = User::create([
            "name" => "Darko Zurnic",
            "email" => "darecare@gmail.com",
            "password" => bcrypt("daredare"),
            "role" => User::setRole("athlete"),
            "username" => User::generateUsername("Darko Zurnic")
        ]);
        $user->extended()->create([
            "location" => "Belgrade, Serbia",
            "gender" => "male",
            "bday" => "2020-08-31 16:00:25"
        ]);
        $user->sports()->attach(1);

        
        $user = User::create([
            "name" => "Sasa Orasanin",
            "email" => "sorasanin@jaggaer.com",
            "password" => bcrypt("sasasasa"),
            "role" => User::setRole("recruiter"),
            "username" => User::generateUsername("Sasa Orasanin")
        ]);
        $user->extended()->create([
            "website" => "https://www.brightfuture.rs/",
            "settings" => [
                'notifyOnNew' => false,
                'notifyOnFavorites' => true,
                'instantSportFilter' => true
            ]
        ]);
        $user->sports()->attach(1);
        $user->sports()->attach(2);

        \Artisan::call('passport:install');
    }
}
