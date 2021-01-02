<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class student extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:student {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make A Registered User Student';

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
            User::where('email', $email)->update(['role' => 'student']);
            $this->info($email.' is now a Student.');
        }
    }
}
