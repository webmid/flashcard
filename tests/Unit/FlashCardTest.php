<?php


use PHPUnit\Framework\TestCase;

class FlashCardTest extends \Tests\TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('flashcards')->truncate();
        \Illuminate\Support\Facades\DB::table('practices')->truncate();
        \Illuminate\Support\Facades\DB::table('practices')->insert([
            'card_id' => 1,
            'username' => 'omid@omid.com',
            'status' => 1,
        ]);


        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        $this->assertTrue(true);
    }

    public function test_flashcard_exit()
    {
        $this->artisan('flashcard:interactive omid@omid.com')
            ->expectsOutput('Hello omid@omid.com . Please choose a number from the below items.')
            ->expectsOutput('1- Create a flashcard')
            ->expectsOutput('2- List all flashcards')
            ->expectsOutput('3- Practice')
            ->expectsOutput('4- Stats')
            ->expectsOutput('5- Reset')
            ->expectsOutput('6- Exit')
            ->expectsQuestion('choose a number from list', 6)
            ->expectsOutput('Hope to see you soon.')
            ->assertExitCode(0);
    }
    public function test_flashcard_create()
    {
        $this->artisan('flashcard:interactive omid@omid.com')
            ->expectsOutput('Hello omid@omid.com . Please choose a number from the below items.')
            ->expectsOutput('1- Create a flashcard')
            ->expectsOutput('2- List all flashcards')
            ->expectsOutput('3- Practice')
            ->expectsOutput('4- Stats')
            ->expectsOutput('5- Reset')
            ->expectsOutput('6- Exit')
            ->expectsQuestion('choose a number from list', 1)
            ->expectsQuestion('insert your question', 'my question')
            ->expectsQuestion('insert your answer', 'my answer')
            ->expectsOutput('Your flashcard created successfully')
            ->expectsConfirmation('Do you want create another flashcard?', 'no')
            ->expectsOutput('Hello omid@omid.com . Please choose a number from the below items.')
            ->expectsOutput('1- Create a flashcard')
            ->expectsOutput('2- List all flashcards')
            ->expectsOutput('3- Practice')
            ->expectsOutput('4- Stats')
            ->expectsOutput('5- Reset')
            ->expectsOutput('6- Exit')
            ->expectsQuestion('choose a number from list', 6)
            ->expectsOutput('Hope to see you soon.')
            ->assertExitCode(0);
    }
    public function test_flashcard_create_error()
    {
        $this->artisan('flashcard:interactive omid@omid.com')
            ->expectsOutput('Hello omid@omid.com . Please choose a number from the below items.')
            ->expectsOutput('1- Create a flashcard')
            ->expectsOutput('2- List all flashcards')
            ->expectsOutput('3- Practice')
            ->expectsOutput('4- Stats')
            ->expectsOutput('5- Reset')
            ->expectsOutput('6- Exit')
            ->expectsQuestion('choose a number from list', 1)
            ->expectsQuestion('insert your question', '')
            ->expectsQuestion('insert your answer', '')
            ->expectsOutput('You have error to fill data. See error messages below:')
            ->expectsOutput('The question field is required.')
            ->expectsOutput('The answer field is required.')
            ->expectsQuestion('insert your question', 'my question 2')
            ->expectsQuestion('insert your answer', 'my answer 2')
            ->expectsOutput('Your flashcard created successfully')
            ->expectsConfirmation('Do you want create another flashcard?', 'no')
            ->expectsOutput('Hello omid@omid.com . Please choose a number from the below items.')
            ->expectsOutput('1- Create a flashcard')
            ->expectsOutput('2- List all flashcards')
            ->expectsOutput('3- Practice')
            ->expectsOutput('4- Stats')
            ->expectsOutput('5- Reset')
            ->expectsOutput('6- Exit')
            ->expectsQuestion('choose a number from list', 6)
            ->expectsOutput('Hope to see you soon.')
            ->assertExitCode(0);
    }
    public function test_flashcard_list()
    {
        $this->artisan('flashcard:interactive omid@omid.com')
            ->expectsOutput('Hello omid@omid.com . Please choose a number from the below items.')
            ->expectsOutput('1- Create a flashcard')
            ->expectsOutput('2- List all flashcards')
            ->expectsOutput('3- Practice')
            ->expectsOutput('4- Stats')
            ->expectsOutput('5- Reset')
            ->expectsOutput('6- Exit')
            ->expectsQuestion('choose a number from list', 2)
            ->expectsTable(['Question', 'Answer'],[['my question', 'my answer']])
            ->expectsQuestion('for back to main menu please enter -1', -1)
            ->expectsOutput('Hello omid@omid.com . Please choose a number from the below items.')
            ->expectsOutput('1- Create a flashcard')
            ->expectsOutput('2- List all flashcards')
            ->expectsOutput('3- Practice')
            ->expectsOutput('4- Stats')
            ->expectsOutput('5- Reset')
            ->expectsOutput('6- Exit')
            ->expectsQuestion('choose a number from list', 6)
            ->expectsOutput('Hope to see you soon.')
            ->assertExitCode(0);
    }
    public function test_flashcard_stats()
    {
        $this->artisan('flashcard:interactive omid@omid.com')
            ->expectsOutput('Hello omid@omid.com . Please choose a number from the below items.')
            ->expectsOutput('1- Create a flashcard')
            ->expectsOutput('2- List all flashcards')
            ->expectsOutput('3- Practice')
            ->expectsOutput('4- Stats')
            ->expectsOutput('5- Reset')
            ->expectsOutput('6- Exit')
            ->expectsQuestion('choose a number from list', 4)
            ->expectsTable(['The total amount of question', '% of questions that have an answer', '% of questions that have a correct answer'],[[2,50,50]])
            ->expectsQuestion('for back to main menu please enter -1', -1)
            ->expectsOutput('Hello omid@omid.com . Please choose a number from the below items.')
            ->expectsOutput('1- Create a flashcard')
            ->expectsOutput('2- List all flashcards')
            ->expectsOutput('3- Practice')
            ->expectsOutput('4- Stats')
            ->expectsOutput('5- Reset')
            ->expectsOutput('6- Exit')
            ->expectsQuestion('choose a number from list', 6)
            ->expectsOutput('Hope to see you soon.')
            ->assertExitCode(0);
    }
    public function test_flashcard_reset()
    {
        $this->artisan('flashcard:interactive omid@omid.com')
            ->expectsOutput('Hello omid@omid.com . Please choose a number from the below items.')
            ->expectsOutput('1- Create a flashcard')
            ->expectsOutput('2- List all flashcards')
            ->expectsOutput('3- Practice')
            ->expectsOutput('4- Stats')
            ->expectsOutput('5- Reset')
            ->expectsOutput('6- Exit')
            ->expectsQuestion('choose a number from list', 5)
            ->expectsConfirmation('are you sure?', 'yes')
            ->expectsOutput('Hello omid@omid.com . Please choose a number from the below items.')
            ->expectsOutput('1- Create a flashcard')
            ->expectsOutput('2- List all flashcards')
            ->expectsOutput('3- Practice')
            ->expectsOutput('4- Stats')
            ->expectsOutput('5- Reset')
            ->expectsOutput('6- Exit')
            ->expectsQuestion('choose a number from list', 6)
            ->expectsOutput('Hope to see you soon.')
            ->assertExitCode(0);
    }
}
