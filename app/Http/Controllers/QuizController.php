<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();
        return view('quizzes.index', compact('quizzes'));
    }

    public function show(Quiz $quiz)
    {
        $quiz->load('questions.answers');
        return view('quizzes.show', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $rules = [];
        foreach ($quiz->questions as $question) {
            $rules['answers.' . $question->id] = 'required';
        }

        $messages = [
            'answers.*.required' => 'Proszę wybrać odpowiedź na to pytanie.',
        ];

        $validated = $request->validate($rules, $messages);

        $quiz->load('questions.answers');

        $correctCount = 0;

        foreach ($quiz->questions as $question) {
            $correctAnswerId = $question->answers->where('is_correct', true)->first()->id;
            $userAnswerId = $validated['answers'][$question->id] ?? null;

            if ($userAnswerId == $correctAnswerId) {
                $correctCount++;
            }
        }

        $totalQuestions = $quiz->questions()->count();
        $score = ($totalQuestions > 0) ? ($correctCount / $totalQuestions) * 100 : 0;

        $request->session()->put('quiz_results', [
            'quiz_title' => $quiz->title,
            'score' => $score,
            'correct_answers' => $correctCount,
            'total_questions' => $totalQuestions,
        ]);

        return redirect()->route('quizzes.results', $quiz);
    }

    public function results(Request $request, Quiz $quiz)
    {
        $results = $request->session()->get('quiz_results');

        if (!$results || $results['quiz_title'] !== $quiz->title) {
            return redirect()->route('quizzes.show', $quiz);
        }

        return view('quizzes.results', [
            'quiz' => $quiz,
            'results' => $results
        ]);
    }
}
