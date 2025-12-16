@extends('layouts.app')

@section('title', 'Wyniki quizu: ' . $quiz->title)

@php
    $score = round($results['score']);

    $colorClass = 'text-danger';
    $message = 'Warto jeszcze poćwiczyć.';

    if ($score >= 80) {
        $colorClass = 'text-success';
        $message = 'Świetnie! Jesteś ekspertem.';
    } elseif ($score >= 50) {
        $colorClass = 'text-warning';
        $message = 'Całkiem nieźle, ale możesz być jeszcze lepszy.';
    }
@endphp

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card page-card border-0 mb-4 text-center">
                <div class="card-body p-4 p-md-5">
                    <p class="text-uppercase text-muted mb-2 small fw-semibold">Wyniki dla: {{ $quiz->title }}</p>
                    
                    <div class="my-5">
                        <h1 class="fw-bold display-4 mb-3 {{ $colorClass }}">{{ $message }}</h1>
                        <p class="text-muted fs-5 mb-4">
                            Twój wynik to:
                        </p>

                        <p class="display-2 fw-bold {{ $colorClass }} mb-4">{{ $score }}%</p>

                        <p class="fs-5">
                            Poprawne odpowiedzi:
                            <strong>{{ $results['correct_answers'] }} / {{ $results['total_questions'] }}</strong>
                        </p>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('quizzes.index') }}" class="btn btn-outline-secondary btn-lg">
                    ← Wróć do listy
                </a>
                <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-primary btn-lg">
                    Spróbuj ponownie →
                </a>
            </div>
        </div>
    </div>
@endsection

