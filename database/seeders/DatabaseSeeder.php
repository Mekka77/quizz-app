<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);


        $quizHtml = Quiz::create([
            'title' => 'Podstawy HTML',
            'description' => 'Sprawdź swoją wiedzę na temat podstaw języka HTML.',
        ]);

        $q1_1 = Question::create([
            'quiz_id' => $quizHtml->id,
            'text' => 'Co oznacza skrót HTML?',
        ]);
        Answer::create(['question_id' => $q1_1->id, 'text' => 'HyperText Markup Language', 'is_correct' => true]);
        Answer::create(['question_id' => $q1_1->id, 'text' => 'High-Level Text Management Language', 'is_correct' => false]);
        Answer::create(['question_id' => $q1_1->id, 'text' => 'Hyperlink and Text Markup Language', 'is_correct' => false]);
        Answer::create(['question_id' => $q1_1->id, 'text' => 'Home Tool Markup Language', 'is_correct' => false]);

        $q1_2 = Question::create([
            'quiz_id' => $quizHtml->id,
            'text' => 'Który tag HTML służy do tworzenia nieuporządkowanej listy?',
        ]);
        Answer::create(['question_id' => $q1_2->id, 'text' => '<ul>', 'is_correct' => true]);
        Answer::create(['question_id' => $q1_2->id, 'text' => '<ol>', 'is_correct' => false]);
        Answer::create(['question_id' => $q1_2->id, 'text' => '<li>', 'is_correct' => false]);
        Answer::create(['question_id' => $q1_2->id, 'text' => '<list>', 'is_correct' => false]);

        $q1_3 = Question::create([
            'quiz_id' => $quizHtml->id,
            'text' => 'Który atrybut określa adres docelowy linku w tagu <a>?',
        ]);
        Answer::create(['question_id' => $q1_3->id, 'text' => 'href', 'is_correct' => true]);
        Answer::create(['question_id' => $q1_3->id, 'text' => 'src', 'is_correct' => false]);
        Answer::create(['question_id' => $q1_3->id, 'text' => 'link', 'is_correct' => false]);
        Answer::create(['question_id' => $q1_3->id, 'text' => 'url', 'is_correct' => false]);


        $quizCss = Quiz::create([
            'title' => 'Podstawy CSS',
            'description' => 'Sprawdź, jak dobrze znasz podstawy arkuszy stylów.',
        ]);

        $q2_1 = Question::create([
            'quiz_id' => $quizCss->id,
            'text' => 'Co oznacza skrót CSS?',
        ]);
        Answer::create(['question_id' => $q2_1->id, 'text' => 'Cascading Style Sheets', 'is_correct' => true]);
        Answer::create(['question_id' => $q2_1->id, 'text' => 'Creative Style Sheets', 'is_correct' => false]);
        Answer::create(['question_id' => $q2_1->id, 'text' => 'Computer Style Sheets', 'is_correct' => false]);
        Answer::create(['question_id' => $q2_1->id, 'text' => 'Colorful Style Sheets', 'is_correct' => false]);

        $q2_2 = Question::create([
            'quiz_id' => $quizCss->id,
            'text' => 'Jak odwołać się w CSS do wszystkich elementów <p> wewnątrz <div>?',
        ]);
        Answer::create(['question_id' => $q2_2->id, 'text' => 'div p', 'is_correct' => true]);
        Answer::create(['question_id' => $q2_2->id, 'text' => 'div > p', 'is_correct' => false]);
        Answer::create(['question_id' => $q2_2->id, 'text' => 'div + p', 'is_correct' => false]);
        Answer::create(['question_id' => $q2_2->id, 'text' => 'p div', 'is_correct' => false]);

        $q2_3 = Question::create([
            'quiz_id' => $quizCss->id,
            'text' => 'Która właściwość CSS służy do zmiany rozmiaru czcionki?',
        ]);
        Answer::create(['question_id' => $q2_3->id, 'text' => 'font-size', 'is_correct' => true]);
        Answer::create(['question_id' => $q2_3->id, 'text' => 'font-style', 'is_correct' => false]);
        Answer::create(['question_id' => $q2_3->id, 'text' => 'text-size', 'is_correct' => false]);
        Answer::create(['question_id' => $q2_3->id, 'text' => 'font-weight', 'is_correct' => false]);


        $quizLaravel = Quiz::create([
            'title' => 'Laravel - Routing',
            'description' => 'Pytania dotyczące podstaw routingu w frameworku Laravel.',
        ]);

        $q3_1 = Question::create([
            'quiz_id' => $quizLaravel->id,
            'text' => 'W którym pliku domyślnie definiuje się trasy dla aplikacji webowej?',
        ]);
        Answer::create(['question_id' => $q3_1->id, 'text' => 'routes/web.php', 'is_correct' => true]);
        Answer::create(['question_id' => $q3_1->id, 'text' => 'routes/api.php', 'is_correct' => false]);
        Answer::create(['question_id' => $q3_1->id, 'text' => 'app/Http/routes.php', 'is_correct' => false]);
        Answer::create(['question_id' => $q3_1->id, 'text' => 'config/routes.php', 'is_correct' => false]);

        $q3_2 = Question::create([
            'quiz_id' => $quizLaravel->id,
            'text' => 'Jak poprawnie zdefiniować trasę, która przyjmuje parametr "id"?',
        ]);
        Answer::create(['question_id' => $q3_2->id, 'text' => 'Route::get(\'/users/{id}\', ...)', 'is_correct' => true]);
        Answer::create(['question_id' => $q3_2->id, 'text' => 'Route::get(\'/users?id={id}\', ...)', 'is_correct' => false]);
        Answer::create(['question_id' => $q3_2->id, 'text' => 'Route::get(\'/users/{id?}\', ...)', 'is_correct' => false]);
        Answer::create(['question_id' => $q3_2->id, 'text' => 'Route::get(\'/users/:id\', ...)', 'is_correct' => false]);

        $q3_3 = Question::create([
            'quiz_id' => $quizLaravel->id,
            'text' => 'Która metoda pozwala na nadanie nazwy trasie?',
        ]);
        Answer::create(['question_id' => $q3_3->id, 'text' => '->name(\'nazwa\')', 'is_correct' => true]);
        Answer::create(['question_id' => $q3_3->id, 'text' => '->set_name(\'nazwa\')', 'is_correct' => false]);
        Answer::create(['question_id' => $q3_3->id, 'text' => '->route_name(\'nazwa\')', 'is_correct' => false]);
        Answer::create(['question_id' => $q3_3->id, 'text' => '->as(\'nazwa\')', 'is_correct' => false]);
    }
}
