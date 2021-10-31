<?php

namespace App\Console\Commands;

use App\Models\Practice;
use App\Repositories\Repository;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;

class FlashCardPractice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:practice {username}';

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

    public function validate($data, $id)
    {
        $validId = [];
        foreach ($data as $row) {
            if ($row['status'] == 'Correct') {
                continue;
            }
            $validId[] = $row['id'];
        }
        $validator = Validator::make([
            'id' => $id,
        ], [
            'id' => ['required', 'in:' . implode(',', $validId)],

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
        try {
            $flashcard = $this->flashcard->getModel()->with(['practices'])->get();
        }catch (QueryException $e) {
            $this->error('An database error has been occurred.');
            return;
        }
        $flashcard_count = $flashcard->count();
        $headers = ['id', 'Question', 'status'];
        $data = [];
        $table = new Table($this->output);

        // Set the table headers.
        $table->setHeaders($headers);
        $correct_count = 0;
        foreach ($flashcard as $row) {
            $status = 'Not Answered';
            foreach ($row->practices as $row2) {
                if ($row2->username != $user) {
                    continue;
                }
                switch ($row2->status) {
                    case 1:
                        $status = "Correct";
                        $correct_count +=1;
                        break;
                    case 2:
                        $status = "Incorrect";
                        break;
                }

            }

            $data[] = array(
                'id' => $row->id,
                'question' => $row->question,
                'status' => $status
            );
            $table->setRows($data);
        }

        // Create a new TableSeparator instance.
        $separator = new TableSeparator;

        // Set the contents of the table.
        $table->addRow($separator);
        $table->addRows([[new TableCell('% of Completion', ['colspan' => 2]), round(($correct_count/$flashcard_count)*100, 2)]]);

        // Render the table to the output.
        $table->render();

        $id = $this->ask('choose a number from list or for back to main menu enter -1 ');
        if($id == -1) {
            $this->call('flashcard:interactive', ['username' => $user]);
        }
        if ($this->validate($data, $id)) {
            $this->handle();
           return ;
        }
        try {
            $answer = $this->ask('Please enter Your answer:');
            $correct_answer = $this->flashcard->show($id)->answer;
            $newStatus = 2;
            if ($answer == $correct_answer) {
                $newStatus = 1;
            }
            $this->practice->getModel()->updateOrCreate(['card_id' => $id, 'username' => $user], ['status' => $newStatus]);
        }catch (QueryException $e) {
            $this->error('An database error has been occurred.');
            exit;
        }

        $newStatus == 1 ? $this->alert('Your answer is correct') : $this->alert('Your answer is incorrenct');
            $this->call('flashcard:practice', ['username' => $user]);
    }
}
