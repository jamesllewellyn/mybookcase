<?php

use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** create 20 users */
        factory(App\User::class, 20)->create();
    }

//    private function createUserShelves($user)
//    {
//        $shelves = collect(['Reading', 'To Read', 'Read']);
//
//        return $shelves->map(function ($shelf) use ($user) {
//            return factory(App\Shelf::class)->create([
//                'user_id' => $user->id,
//                'name'    => $shelf
//            ]);
//        })->map(function ($shelf) {
//            return $this->assignShelfBooks($shelf);
//        });
//    }
//
//    private function assignShelfBooks($shelf)
//    {
//        return factory(App\ShelfBook::class, 10)->create([
//            'shelf_id' => $shelf->id,
//        ]);
//    }
}
