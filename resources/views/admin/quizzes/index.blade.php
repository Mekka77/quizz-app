@extends('layouts.admin')

@section('title', 'Zarządzaj Quizami')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Zarządzaj Quizami</h1>
        <a href="{{ route('admin.quizzes.create') }}" class="btn btn-primary">Dodaj nowy quiz</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tytuł</th>
                        <th scope="col">Liczba pytań</th>
                        <th scope="col">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($quizzes as $quiz)
                        <tr>
                            <th scope="row">{{ $quiz->id }}</th>
                            <td>{{ $quiz->title }}</td>
                            <td>{{ $quiz->questions_count }}</td>
                            <td>
                                <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-sm btn-outline-secondary">Edytuj</a>
                                <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć ten quiz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Usuń</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Brak quizów do wyświetlenia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $quizzes->links() }}
    </div>
</div>
@endsection
