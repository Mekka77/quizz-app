<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Quiz $quiz)
    {
        // This method is not directly used for a nested resource index view in our current setup,
        // as questions are listed on the quiz edit page. However, it's part of the resource controller.
        // If we were to have a standalone question list, this would be the place.
        // For now, let's just redirect to the quiz edit page.
        return redirect()->route('admin.quizzes.edit', $quiz);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Quiz $quiz)
    {
        return view('admin.questions.create', compact('quiz'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255',
            'answers' => ['required', 'array', 'min:2'],
            'answers.*.text' => 'required|string|max:255',
            'answers.*.is_correct' => 'nullable|boolean',
        ]);

        // Custom validation for exactly one correct answer
        $correctAnswersCount = collect($validated['answers'])->filter(function ($answer) {
            return isset($answer['is_correct']) && $answer['is_correct'];
        })->count();

        if ($correctAnswersCount !== 1) {
            throw ValidationException::withMessages([
                'answers' => ['Musisz zaznaczyć dokładnie jedną poprawną odpowiedź.'],
            ]);
        }

        $question = $quiz->questions()->create([
            'text' => $validated['text'],
        ]);

        foreach ($validated['answers'] as $answerData) {
            $question->answers()->create([
                'text' => $answerData['text'],
                'is_correct' => isset($answerData['is_correct']),
            ]);
        }

        return redirect()->route('admin.quizzes.edit', $quiz)->with('success', 'Pytanie zostało pomyślnie dodane.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz, Question $question)
    {
        $question->load('answers'); // Eager load answers for the question
        return view('admin.questions.edit', compact('quiz', 'question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255',
            'answers' => ['required', 'array', 'min:2'],
            'answers.*.text' => 'required|string|max:255',
            'answers.*.is_correct' => 'nullable|boolean',
        ]);

        // Custom validation for exactly one correct answer
        $correctAnswersCount = collect($validated['answers'])->filter(function ($answer) {
            return isset($answer['is_correct']) && $answer['is_correct'];
        })->count();

        if ($correctAnswersCount !== 1) {
            throw ValidationException::withMessages([
                'answers' => ['Musisz zaznaczyć dokładnie jedną poprawną odpowiedź.'],
            ]);
        }

        $question->update([
            'text' => $validated['text'],
        ]);

        // Delete existing answers and create new ones
        $question->answers()->delete(); // Delete all old answers
        foreach ($validated['answers'] as $answerData) {
            $question->answers()->create([
                'text' => $answerData['text'],
                'is_correct' => isset($answerData['is_correct']),
            ]);
        }

        return redirect()->route('admin.quizzes.edit', $quiz)->with('success', 'Pytanie zostało pomyślnie zaktualizowane.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();

        return redirect()->route('admin.quizzes.edit', $quiz)->with('success', 'Pytanie zostało pomyślnie usunięte.');
    }
}
