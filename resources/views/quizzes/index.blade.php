@extends('layouts.app')

@section('title', 'Lista quizów')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Lista quizów</h1>
            <p class="text-muted mb-0">Wybierz quiz, od którego chcesz zacząć.</p>
        </div>
        <span class="badge text-bg-light border">
            Łącznie quizów: <strong>{{ count($quizzes) }}</strong>
        </span>
    </div>

    <div class="row g-3">
        @foreach($quizzes as $quiz)
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex flex-column">
                        <span class="badge rounded-pill text-bg-primary align-self-start mb-2">
                            Quiz #{{ $quiz['id'] }}
                        </span>

                        <h5 class="card-title fw-semibold mb-2">{{ $quiz['title'] }}</h5>
                        <p class="text-muted small flex-grow-1 mb-3">
                            Krótki quiz sprawdzający podstawy tego tematu.
                        </p>

                        <a href="{{ route('quizzes.show', $quiz['id']) }}"
                           class="btn btn-outline-primary mt-auto">
                            Rozpocznij →
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
