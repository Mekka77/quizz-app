@extends('layouts.admin')

@section('title', 'Edytuj quiz')

@section('content')
<div class="container">
    <h1 class="fw-bold mb-4">Edytuj quiz: {{ $quiz->title }}</h1>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-bold">Szczegóły quizu</div>
        <div class="card-body">
            <form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Tytuł</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $quiz->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Opis</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $quiz->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Zapisz zmiany quizu</button>
                <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Wróć do listy quizów</a>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
            Pytania do quizu
            <a href="{{ route('admin.quizzes.questions.create', $quiz) }}" class="btn btn-primary btn-sm">Dodaj nowe pytanie</a>
        </div>
        <div class="card-body">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Pytanie</th>
                        <th scope="col">Liczba odpowiedzi</th>
                        <th scope="col">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($quiz->questions as $question)
                        <tr>
                            <th scope="row">{{ $question->id }}</th>
                            <td>{{ $question->text }}</td>
                            <td>{{ $question->answers->count() }}</td>
                            <td>
                                <a href="{{ route('admin.quizzes.questions.edit', [$quiz, $question]) }}" class="btn btn-sm btn-outline-secondary">Edytuj</a>
                                <form action="{{ route('admin.quizzes.questions.destroy', [$quiz, $question]) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć to pytanie?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Usuń</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Brak pytań do wyświetlenia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
