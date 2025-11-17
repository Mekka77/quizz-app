<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/quizzes', function () {
    $quizzes = [
        ['id' => 1, 'title' => 'HTML Basics'],
        ['id' => 2, 'title' => 'CSS Fundamentals'],
        ['id' => 3, 'title' => 'Laravel Routing'],
    ];

    return view('quizzes.index', compact('quizzes'));
})->name('quizzes.index');

Route::get('/quizzes/{id}', function ($id) {


    $quizzes = [
        1 => [
            'title' => 'HTML Basics',
            'description' => 'Quiz sprawdzający podstawy HTML.',
            'questions' => [
                [
                    'text' => 'Co oznacza HTML?',
                    'answers' => ['HyperText Markup Language', 'Home Tool Markup Language'],
                ],
            ],
        ],
        2 => [
            'title' => 'CSS Fundamentals',
            'description' => 'Quiz o właściwościach CSS.',
            'questions' => [
                [
                    'text' => 'Jak zmienić kolor tekstu?',
                    'answers' => ['color: red;', 'text-color: red;'],
                ],
            ],
        ],
        3 => [
            'title' => 'Laravel Routing',
            'description' => 'Sprawdź wiedzę o trasach w Laravelu.',
            'questions' => [
                [
                    'text' => 'Która metoda służy do GET?',
                    'answers' => ['Route::get()', 'Route::post()'],
                ],
            ],
        ],
    ];


    if (!isset($quizzes[$id])) {
        abort(404);
    }

    $quiz = $quizzes[$id];

    return view('quizzes.show', compact('quiz', 'id'));

})->name('quizzes.show');
