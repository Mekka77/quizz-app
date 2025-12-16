@extends('layouts.app')

@section('title', 'Quiz App – Strona główna')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card page-card border-0 mb-4">
                <div class="card-body p-4 p-md-5">
                    <p class="text-uppercase text-muted mb-2 small fw-semibold">Witaj</p>
                    <h1 class="fw-bold display-5 mb-3">Sprawdź swoją wiedzę z HTML, CSS oraz Laravela</h1>
                    <p class="text-muted mb-4">
                        Rozwiązuj krótkie quizy, które pomogą Ci przygotować się do zajęć i kolokwium.
                        Zacznij od podstaw HTML, przejdź przez CSS i sprawdź, jak dobrze ogarniasz routing w Laravelu.
                    </p>

                    <a href="{{ route('quizzes.index') }}" class="btn btn-primary btn-lg">
                        Przejdź do listy quizów
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
