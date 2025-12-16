<?php

use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('welcome');


Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])->name('quizzes.results');

Auth::routes();

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return 'Admin Dashboard'; // Placeholder
    })->name('dashboard');

    Route::resource('quizzes', AdminQuizController::class);
    Route::resource('quizzes.questions', AdminQuestionController::class);
});
