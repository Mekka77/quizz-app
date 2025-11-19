<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quiz = Quiz::create([
            'title' => 'My First Quiz',
            'description' => 'This is a quiz about general knowledge.',
        ]);

        $question1 = Question::create([
            'quiz_id' => $quiz->id,
            'text' => 'What is the capital of France?',
        ]);

        Answer::create(['question_id' => $question1->id, 'text' => 'London', 'is_correct' => false]);
        Answer::create(['question_id' => $question1->id, 'text' => 'Paris', 'is_correct' => true]);
        Answer::create(['question_id' => $question1->id, 'text' => 'Berlin', 'is_correct' => false]);
        Answer::create(['question_id' => $question1->id, 'text' => 'Madrid', 'is_correct' => false]);

        $question2 = Question::create([
            'quiz_id' => $quiz->id,
            'text' => 'What is 2 + 2?',
        ]);

        Answer::create(['question_id' => $question2->id, 'text' => '3', 'is_correct' => false]);
        Answer::create(['question_id' => $question2->id, 'text' => '4', 'is_correct' => true]);
        Answer::create(['question_id' => $question2->id, 'text' => '5', 'is_correct' => false]);
        Answer::create(['question_id' => $question2->id, 'text' => '6', 'is_correct' => false]);
    }
}
