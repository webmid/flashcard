<?php

namespace App\Console\Commands;

use App\Models\Practice;
use App\Repositories\Repository;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class FlashCardStat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:stats {username}';

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
    protected $flashcard;
    protected $practice;

    public function __construct(\App\Models\FlashCard $flashcard, Practice $practice)
    {
        parent::__construct();
        $this->flashcard = new Repository($flashcard);
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
        try {
            $flashcard = $this->flashcard->all()->count();
            $all_answer = $this->practice->getModel()->where('username', '=', $user)->where('status', '<>', 3)->get()->count();
            $correct_answer = $this->practice->getModel()->where('username', '=', $user)->where('status', '=', 1)->get()->count();
        }catch (QueryException $e) {
            $this->error('An database error has been occurred.');
            return ;
        }

        $headers = ['The total amount of question', '% of questions that have an answer', '% of questions that have a correct answer'];
        $data =[];
        $data[] = array(
            'The total amount of question' => $flashcard,
            '% of questions that have an answer' => round(($all_answer/$flashcard)*100, 2),
            '% of questions that have a correct answer' => round(($correct_answer/$flashcard)*100, 2)
        );
        $this->table($headers, $data);
        $choice = $this->ask('for back to main menu please enter -1');
        if(validateBacktoMenu($choice)) {
            $this->alert('Your choice is invalid! You must enter -1');
            $this->handle();
            return;
        }
        $this->call('flashcard:interactive', ['username' => $user]);
    }
}
