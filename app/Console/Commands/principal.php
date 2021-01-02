<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class principal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:principal {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make A Registered User Principal';

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
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();
        if(empty($user)){
            $this->error('Could not find the specfied user.');
        }
        else{
            $principal = User::where('role', 'principal')->first();
            if(!empty($principal)){
                $this->error('There can only be 1 Principal.');
            }
            else{
                User::where('email', $email)->update(['role' => 'principal']);
                $this->info($email.' is now Principal.');    
            }
        }
    }
}
