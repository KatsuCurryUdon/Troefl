@extends('layouts.main')

@section('container')
    <div class="py-3">
        <small>
            <a href="/" class="text-decoration-none text-secondary">Home</a>
            /
            <a href="/discussions" class="text-decoration-none text-secondary">Discussions</a>
            /
            <a href="/discussions/start-discussion" class="text-decoration-none text-secondary">Start a New Discussion</a>
        </small>
    </div>
    <div class="d-flex flex-column">
        <h1 class="pb-5">Start a New Discussion</h1>
        <div class="col-lg-8">
            <form action="/discussions/start-discussion" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        id="title" placeholder="Enter a Title" required value="{{ old('title') }}">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror d-none"
                        id="slug" placeholder="Slug" required value="{{ old('slug') }}">
                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-5">
                    <input id="body" type="hidden" name="body">
                    <trix-editor input="body" class="form-control @error('body') is-invalid @enderror" required placeholder="Say something..."></trix-editor>
                    @error('body')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="d-flex flex-row-reverse">
                    <button type="submit" class="btn btn-dark">Post Discussion</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        const title = document.querySelector("#title");
        const slug = document.querySelector("#slug");
    
        title.addEventListener("keyup", function() {
            let preslug = title.value;
            preslug = preslug.replace(/ /g,"-").toLowerCase();
            
            // AJAX request to get a unique slug
            fetch(`/generate-slug?title=${preslug}`)
                .then(response => response.json())
                .then(data => {slug.value = data.slug;});
        });

        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        })
    </script>
@endsection