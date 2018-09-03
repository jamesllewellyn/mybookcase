<?php

namespace App\Jobs\User;

use App\User;
use App\ShelfBook;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateDefaultShelves implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shelves = collect([
            ['name' => 'Favorites', 'public' => true],
            ['name' => 'To Read', 'public' => false],
        ]);

        $shelves->map(function ($shelf) {
             return $this->user->shelves()->create([
                'name'   => $shelf['name'],
                'public' => $shelf['public']
            ]);
        })->map(function ($shelf) {
            if(! $this->user->is_test_data){
                return false;
            }
            return $this->assignShelfBooks($shelf);
        });
    }

    private function assignShelfBooks($shelf)
    {
        return factory(UserBooks::class, 10)->create([
            'shelf_id' => $shelf->id,
        ]);
    }
}
