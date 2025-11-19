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

    @foreach ($quiz->questions as $index => $q)
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="question-chip">
                        {{ $index + 1 }}
                    </span>
                    <h5 class="fw-semibold mb-0">{{ $q->text }}</h5>
                </div>

                @foreach ($q->answers as $answer)
                    <button type="button"
                            class="answer-btn btn btn-outline-primary w-100 text-start mb-2">
                        {{ $answer->text }}
                    </button>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
