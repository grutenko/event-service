<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\CarbonImmutable;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1, 10) as $i) {
            DB::table('events')->insert([
                'name' => Str::random(10),
                'city' => Str::random(10),
                'date' => CarbonImmutable::now()->addDays(random_int(1, 30))
            ]);
        }
    }
}
