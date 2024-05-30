@extends('layouts.main')

@section('container')
    <div class="d-flex flex-column">
        <h1 class="pb-5">Edit Question</h1>
        <form action="/manage-quiz/edit-question/{{ $question->id }}" method="POST">
            @csrf

            <div class="mb-3">
                <input type="text" class="form-control @error('question') is-invalid @enderror" id="question" name="question" placeholder="Question" value="{{ old('question', $question->question) }}" required>
                @error('question')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <input type="text" class="form-control @error('correct_answer') is-invalid @enderror" id="correct_answer" name="correct_answer" placeholder="Correct Answer" value="{{ old('correct_answer', $question->answers->where('is_correct', true)->first()->answer) }}" required>
                @error('correct_answer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div id="false-answers-container">
                @php 
                    $falseAnswers = old('false_answers', $question->answers->where('is_correct', false)->pluck('answer')->toArray());
                @endphp
                @foreach ($falseAnswers as $index => $falseAnswer)
                    <div class="mb-3" id="false-answer-{{ $index }}">
                        <div class="input-group">
                            <input type="text" class="form-control @error('false_answers.' . $index) is-invalid @enderror" id="false_answers_{{ $index }}" name="false_answers[]" placeholder="False Answer {{ $index + 1 }}" value="{{ $falseAnswer }}" required>
                            @if ($index > 0)
                                <button type="button" class="btn btn-danger remove-false-answer">Remove</button>
                            @endif
                            @error('false_answers.' . $index)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex flex-row-reverse">
                <button type="button" class="btn btn-secondary mb-5" id="add-false-answer">Add More False Answer</button>
            </div>
            <div class="d-flex flex-row-reverse">
                <button type="submit" class="btn btn-dark">Update Question</button>
                <a href="/manage-quiz" class="btn btn-dark me-3">Back</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let falseAnswerCount = {{ count($falseAnswers) }};

            document.getElementById('add-false-answer').addEventListener('click', function () {
                const container = document.getElementById('false-answers-container');
                const newIndex = container.children.length;

                const newFalseAnswerDiv = document.createElement('div');
                newFalseAnswerDiv.classList.add('mb-3');
                newFalseAnswerDiv.id = `false-answer-${newIndex}`;

                const newInputGroup = document.createElement('div');
                newInputGroup.classList.add('input-group');

                const newInput = document.createElement('input');
                newInput.type = 'text';
                newInput.classList.add('form-control');
                newInput.id = `false_answers_${newIndex}`;
                newInput.name = 'false_answers[]';
                newInput.placeholder = `False Answer ${newIndex + 1}`;
                newInput.required = true;

                const newRemoveButton = document.createElement('button');
                newRemoveButton.type = 'button';
                newRemoveButton.classList.add('btn', 'btn-danger', 'remove-false-answer');
                newRemoveButton.textContent = 'Remove';

                if (newIndex > 0) {
                    newInputGroup.appendChild(newRemoveButton);
                }
                newInputGroup.insertBefore(newInput, newInputGroup.firstChild);
                newFalseAnswerDiv.appendChild(newInputGroup);
                container.appendChild(newFalseAnswerDiv);

                falseAnswerCount++;
            });

            document.getElementById('false-answers-container').addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-false-answer')) {
                    const falseAnswerDiv = event.target.closest('.mb-3');
                    falseAnswerDiv.remove();
                    // Update placeholders
                    const falseAnswers = container.children;
                    for (let i = 0; i < falseAnswers.length; i++) {
                        const falseAnswer = falseAnswers[i];
                        const input = falseAnswer.querySelector('input');
                        input.placeholder = `False Answer ${i + 1}`;
                    }
                }
            });
        });
    </script>
@endsection
