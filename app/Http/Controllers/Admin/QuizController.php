<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('questions')->latest()->paginate(20);

        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Quiz::create($validated);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz został pomyślnie utworzony.');
    }

    public function show(string $id)
    {

    }

    public function edit(Quiz $quiz)
    {
        $quiz->load('questions.answers');

        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz->update($validated);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz został pomyślnie zaktualizowany.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz został pomyślnie usunięty.');
    }
}
