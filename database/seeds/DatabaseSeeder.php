<?php

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
        // $this->call(UserSeeder::class);
        
        // namiesto toho vyssie mozeme spravit takyto for-cyklus 
        factory(App\User::class, 5)->create()->each(function ($user) {
            for ($i=0; $i < 5; $i++) { 
                $user->productCategories()->save(factory(App\ProductCategory::class)->make());
                $user->workPositions()->save(factory(App\WorkPosition::class)->make());
                $user->employees()->save(factory(App\Employee::class)->make());
                $user->orders()->save(factory(App\Order::class)->make());
                $user->products()->save(factory(App\Product::class)->make());
            }
        });
    }
}
