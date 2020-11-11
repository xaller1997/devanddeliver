<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RegisteredUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registered:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     */
    public function handle()
    {
        $helperController = new Controller();
        $users = DB::table('users')->select('email', 'hero_id')->get('email, hero_id');
        foreach($users as $user) {
            $name = $helperController->connectToAPI('GET', 'people/' . $user->hero_id);
            echo $user->email . ' - ' . $name->name . PHP_EOL;
        }
    }
}
