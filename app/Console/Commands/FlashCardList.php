<?php

namespace App\Console\Commands;

use App\Models\Practice;
use App\Repositories\Repository;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class FlashCardList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:list {username}';

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
    protected $model;
    public function __construct(Practice $model)
    {
        parent::__construct();
        $this->model = new Repository($model);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $user = $this->argument('username');
        $headers = ['Question', 'Answer'];
        try {
            $flashcards = $this->model->getModel()->with(['flashcard'])->where('username', '=', $user)->where('status', '=', 1)->get();
        }catch (QueryException $e) {
            $this->error('An database error has been occurred.');
            return ;
        }
        $data = [];
        foreach ($flashcards as $row) {
            $data[] = array(
              'question' => $row->flashcard->question,
              'answer' => $row->flashcard->answer,
            );
        }
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
