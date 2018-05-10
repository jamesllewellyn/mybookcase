<?php

namespace App\Console\Commands;

use App\InterestedUser;
use Illuminate\Console\Command;

class InviteInterestedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invite:interested-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all interested users and send them an email invite';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        InterestedUser::toInvite()->map(function($interestedUser){
            $interestedUser->invite();
        });
    }
}
