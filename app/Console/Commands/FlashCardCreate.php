<?php

namespace App\Console\Commands;

use App\Repositories\Repository;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class FlashCardCreate extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:create {username}';

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
    public function __construct(\App\Models\FlashCard $flashcard)
    {
        parent::__construct();
        $this->model = new Repository($flashcard);
    }

    public function validate($data)
    {
        $validator = Validator::make([
            'question' => $data['question'],
            'answer' => $data['answer'],
        ], [
            'question' => ['required'],
            'answer' => ['required'],

        ]);
        if ($validator->fails()) {
            $this->info('You have error to fill data. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
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
        $data = [];
        $data['username'] = $this->argument('username');
        $data['question'] = $this->ask('insert your question');
        $data['answer'] = $this->ask('insert your answer');
        if($this->validate($data)) {
            $this->handle();
           return;
        }
        try {
            $this->model->create($data);
        }catch (QueryException $e) {
            $this->error('An database error has been occurred.');
            return;
        }

        $this->info('Your flashcard created successfully');
        if($this->confirm('Do you want create another flashcard?')) {
            $this->call('flashcard:create', ['username' => $data['username']]);
        }
        $this->call('flashcard:interactive', ['username' => $data['username']]);
    }
}
