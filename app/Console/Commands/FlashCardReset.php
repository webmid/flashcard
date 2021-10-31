<?php

namespace App\Console\Commands;

use App\Models\Practice;
use App\Repositories\Repository;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class FlashCardReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:reset {username}';

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
    protected $practice;

    public function __construct(Practice $practice)
    {
        parent::__construct();
        $this->practice = new Repository($practice);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = $this->argument('username');
        if ($this->confirm('are you sure?')) {
            try {
                $practice = $this->practice->getModel()->where('username', '=', $user)->get();
                if (count($practice) > 0) {
                    $practice->each->delete();
                    $this->alert('Your practice has been successfully reseted.');
                }else {
                    $this->alert('You do not have any practice!');
                }
            } catch (QueryException $e) {
                $this->error('An database error has been occurred.');
                return ;
            }
        }
        $this->call('flashcard:interactive', ['username' => $user]);
    }
}
