@extends('layouts.app')

@section('title', $quiz->title . ' – Quiz')

@section('content')
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('quizzes.index') }}" class="btn btn-outline-secondary">
            ← Powrót do listy quizów
        </a>
        <span class="text-muted small">
            Quiz ID: {{ $quiz->id }}
        </span>
    </div>

    <div class="card page-card border-0 mb-4">
        <div class="card-body p-4 p-md-5">
            <h1 class="fw-bold display-5 mb-2">{{ $quiz->title }}</h1>
            <p class="text-muted mb-0">{{ $quiz->description }}</p>
        </div>
    </div>

    <h3 class="fw-bold mb-3">Pytania</h3>

    <form action="{{ route('quizzes.submit', $quiz) }}" method="POST">
        @csrf

        @foreach ($quiz->questions as $index => $q)
            <div class="card shadow-sm border-0 mb-4 @error('answers.' . $q->id) border-danger @enderror">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="question-chip">
                            {{ $index + 1 }}
                        </span>
                        <h5 class="fw-semibold mb-0">{{ $q->text }}</h5>
                    </div>

                    @error('answers.' . $q->id)
                        <div class="ps-md-5 mb-2">
                            <small class="text-danger fw-semibold">{{ $message }}</small>
                        </div>
                    @enderror

                    <div class="ps-md-5">
                        @foreach ($q->answers as $answer)
                            <input type="radio" name="answers[{{ $q->id }}]" value="{{ $answer->id }}" id="answer-{{ $answer->id }}" class="answer-radio"
                                   @if(old('answers.' . $q->id) == $answer->id) checked @endif
                            >
                            <label for="answer-{{ $answer->id }}" class="answer-label">
                                {{ $answer->text }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">
                Zatwierdź i sprawdź wyniki
            </button>
        </div>
    </form>
@endsection
