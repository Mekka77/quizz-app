@extends('layouts.admin')

@section('title', 'Edytuj pytanie w quizie: ' . $quiz->title)

@section('content')
<div class="container">
    <h1 class="fw-bold mb-4">Edytuj pytanie w quizie: "{{ $quiz->title }}"</h1>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.quizzes.questions.update', [$quiz, $question]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="question_text" class="form-label">Treść pytania</label>
                    <input type="text" class="form-control @error('text') is-invalid @enderror" id="question_text" name="text" value="{{ old('text', $question->text) }}" required>
                    @error('text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                <h4 class="mb-3">Odpowiedzi</h4>
                <div id="answers-container">
                    @php $oldAnswers = old('answers', $question->answers->map(function($answer) {
                        return ['text' => $answer->text, 'is_correct' => $answer->is_correct];
                    })->toArray()); @endphp
                    @foreach($oldAnswers as $index => $oldAnswer)
                        <div class="input-group mb-3 answer-item">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0 @error('answers.' . $index . '.is_correct') is-invalid @enderror" type="checkbox" name="answers[{{ $index }}][is_correct]" value="1" @checked(old('answers.' . $index . '.is_correct', $oldAnswer['is_correct'] ?? false)) aria-label="Odpowiedź poprawna">
                            </div>
                            <input type="text" class="form-control @error('answers.' . $index . '.text') is-invalid @enderror" name="answers[{{ $index }}][text]" placeholder="Treść odpowiedzi" value="{{ old('answers.' . $index . '.text', $oldAnswer['text'] ?? '') }}" required>
                            <button class="btn btn-outline-danger remove-answer" type="button">Usuń</button>
                            @error('answers.' . $index . '.text')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('answers.' . $index . '.is_correct')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                </div>


                <button type="submit" class="btn btn-primary">Zapisz zmiany pytania</button>
                <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-secondary">Anuluj</a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const answersContainer = document.getElementById('answers-container');
        const addAnswerButton = document.querySelector('.add-answer');
        const answerErrorMessage = document.getElementById('answer-error-message');
        let answerIndex = answersContainer.children.length; // Start index from existing answers

        function updateRemoveButtons() {
            const removeButtons = answersContainer.querySelectorAll('.remove-answer');
            if (removeButtons.length <= 2) {
                removeButtons.forEach(btn => btn.style.display = 'none');
            } else {
                removeButtons.forEach(btn => btn.style.display = 'inline-block');
            }
        }

        function addAnswerField(text = '', isCorrect = false) {
            const newAnswer = document.createElement('div');
            newAnswer.classList.add('input-group', 'mb-3', 'answer-item');
            newAnswer.innerHTML = `
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="checkbox" name="answers[${answerIndex}][is_correct]" value="1" ${isCorrect ? 'checked' : ''} aria-label="Odpowiedź poprawna">
                </div>
                <input type="text" class="form-control" name="answers[${answerIndex}][text]" placeholder="Treść odpowiedzi" value="${text}" required>
                <button class="btn btn-outline-danger remove-answer" type="button">Usuń</button>
            `;
            answersContainer.appendChild(newAnswer);
            answerIndex++;
            updateRemoveButtons();
        }

        // Initialize with at least 2 answer fields if less than 2 from old input/question data
        if (answersContainer.children.length < 2) {
             for (let i = answersContainer.children.length; i < 2; i++) {
                addAnswerField();
            }
        }

        addAnswerButton.addEventListener('click', function () {
            addAnswerField();
        });

        answersContainer.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-answer')) {
                if (answersContainer.children.length > 2) {
                    event.target.closest('.answer-item').remove();
                    updateRemoveButtons();
                } else {
                    answerErrorMessage.style.display = 'block';
                    setTimeout(() => answerErrorMessage.style.display = 'none', 3000);
                }
            }
        });

        // Ensure only one checkbox is checked
        answersContainer.addEventListener('change', function (event) {
            if (event.target.type === 'checkbox' && event.target.name.includes('[is_correct]')) {
                answersContainer.querySelectorAll('input[type="checkbox"][name*="[is_correct]"]').forEach(checkbox => {
                    if (checkbox !== event.target) {
                        checkbox.checked = false;
                    }
                });
            }
        });

        updateRemoveButtons(); // Initial call
    });
</script>
@endpush
