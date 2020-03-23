<?php

namespace App\Console\Commands;

use App\Mail\FoodExpires;
use Illuminate\Console\Command;

use App\User;
use Illuminate\Support\Facades\Mail;

class RemindExpiredFood extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:expires';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind users that food is about expire.';

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
        $users = User::where('reminder_expired_food', true)
            ->get();

        foreach ($users as $user) {
            $foodAboutToExpire = $user->foodAboutToExpire();

            if (count($foodAboutToExpire) === 0) {
                continue;
            }

            Mail::to($user)->send(new FoodExpires($foodAboutToExpire));
        }
    }
}
