<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Quiz::create([
            'title' => 'Math Quiz',
            'description' => 'A quiz about basic math.',
        ]);

        Quiz::create([
            'title' => 'History Quiz',
            'description' => 'A quiz about world history.',
        ]);

        $this->call([
            QuestionSeeder::class,
        ]);
    }
}
