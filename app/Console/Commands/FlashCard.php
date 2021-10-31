<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class FlashCard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:interactive {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'flash card command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function validateEmail($data)
    {
        $validator = Validator::make([
            'email' => $data,
        ], [
            'email' => ['email'],

        ]);
        if ($validator->fails()) {
            $this->alert('Your username is invalid!');

            return true;
        }
    }

    public function validate($data)
    {
        $validator = Validator::make([
            'choice' => $data,
        ], [
            'choice' => ['required', 'in:1,2,3,4,5,6'],

        ]);
        if ($validator->fails()) {
            $this->alert('Your Choice is invalid!');

            return true;
        }
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = $this->argument('username');
        if($this->validateEmail($user)) {
            $this->error('You must enter a valid email address');
            return;
        }
        $this->info("Hello $user . Please choose a number from the below items.");
        $this->info('1- Create a flashcard');
        $this->info('2- List all flashcards');
        $this->info('3- Practice');
        $this->info('4- Stats');
        $this->info('5- Reset');
        $this->info('6- Exit');

        $choice = $this->ask('choose a number from list');
        if($this->validate($choice)) {
            $this->handle();
            return ;
        }
        switch ($choice) {
            case 1:
                $this->call('flashcard:create', ['username'=>$user]);
                break;
            case 2:
                $this->call('flashcard:list', ['username'=>$user]);
                break;
            case 3:
                $this->call('flashcard:practice', ['username'=>$user]);
                break;
            case 4:
                $this->call('flashcard:stats', ['username'=>$user]);
                break;
            case 5:
                $this->call('flashcard:reset', ['username'=>$user]);
                break;
            case 6:
                $this->info('Hope to see you soon.');
                  return;
        }

    }
}
