<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Stocks;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i = 0; $i<20; $i++){
            $product = Product::create( [
                'name' =>  $faker->name,
                'uuid' =>  $faker->uuid,
                'sku' => Str::random(10),
                'price' => rand(10,1000),
                'points' => rand(10,1000),
                'created_at' => now(),
                'created_by' => 1,
            ]);
        }
    }
}
