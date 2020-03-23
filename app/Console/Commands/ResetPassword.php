<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-password {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the password of a user';

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
        $user = User::where('id', $this->argument('user'))->firstOrFail();

        $password = Str::random(12);
        $user->password = Hash::make($password);
        $user->save();

        $this->info("New password for {$user->email}: {$password}");

        return true;
    }
}
