@extends('layouts.admin')

@section('title', 'Dodaj nowy quiz')

@section('content')
<div class="container">
    <h1 class="fw-bold mb-4">Dodaj nowy quiz</h1>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.quizzes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Tytuł</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Opis</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Zapisz</button>
                <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Anuluj</a>
            </form>
        </div>
    </div>
</div>
@endsection
