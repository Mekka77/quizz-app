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
    public function index(Quiz $quiz)
    {
        return redirect()->route('admin.quizzes.edit', $quiz);
    }
    public function create(Quiz $quiz)
    {
        return view('admin.questions.create', compact('quiz'));
    }
    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255',
            'answers' => ['required', 'array', 'min:2'],
            'answers.*.text' => 'required|string|max:255',
            'answers.*.is_correct' => 'nullable|boolean',
        ]);


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


    public function show(string $id)
    {

    }
    public function edit(Quiz $quiz, Question $question)
    {
        $question->load('answers');
        return view('admin.questions.edit', compact('quiz', 'question'));
    }
    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255',
            'answers' => ['required', 'array', 'min:2'],
            'answers.*.text' => 'required|string|max:255',
            'answers.*.is_correct' => 'nullable|boolean',
        ]);

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

        $question->answers()->delete();
        foreach ($validated['answers'] as $answerData) {
            $question->answers()->create([
                'text' => $answerData['text'],
                'is_correct' => isset($answerData['is_correct']),
            ]);
        }

        return redirect()->route('admin.quizzes.edit', $quiz)->with('success', 'Pytanie zostało pomyślnie zaktualizowane.');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();

        return redirect()->route('admin.quizzes.edit', $quiz)->with('success', 'Pytanie zostało pomyślnie usunięte.');
    }
}
