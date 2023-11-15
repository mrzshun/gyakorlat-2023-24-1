@extends('layouts.app')
@section('title', 'Create post')

@section('content')
    <div class="container">
        <h1>Create post</h1>
        <div class="mb-4">
            <a href="."><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        </div>

        @if (Session::has('post_created'))
            <div class="alert alert-primary" role="alert">
                Post is created.<br />
            </div>
        @endif

        @guest
        <div class="alert alert-primary" role="alert">
            You have to be logged in to create a new post.<br />
        </div>            
        @endguest

        @auth

            {{-- TODO: action, method, enctype --}}
            <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- TODO: Validation --}}

                <div class="form-group row mb-3">
                    <label for="title" class="col-sm-2 col-form-label">Title*</label>
                    <div class="col-sm-10">
                        <input type="text"
                            class="form-control @error('title') is-invalid @else @if (old('title')) is-valid @endif @enderror"
                            id="title" name="title" value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="valid-feedback">Looks good!</div>
                        @enderror

                    </div>
                </div>

                {{--
            Handling invalid input fields:

            <input type="text" class="form-control is-invalid" ...>
            <div class="invalid-feedback">
                Message
            </div>
        --}}

                <div class="form-group row mb-3">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <input type="text"
                            class="form-control @error('description') is-invalid @else @if (old('description')) is-valid @endif @enderror"
                            id="description" name="description" value="{{ old('description') }}">
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="valid-feedback">Looks good!</div>
                        @enderror

                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="text" class="col-sm-2 col-form-label">Text*</label>
                    <div class="col-sm-10">
                        <textarea rows="5"
                            class="form-control @error('text') is-invalid @else @if (old('text')) is-valid @endif @enderror"
                            id="text" name="text">{{ old('text') }}</textarea>
                        @error('text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="valid-feedback">Looks good!</div>
                        @enderror

                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="categories" class="col-sm-2 col-form-label py-0">Categories</label>
                    <div class="col-sm-10">
                        {{-- TODO: Read post categories from DB --}}
                        @forelse ($categories as $category)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" value="{{ $category->id }}"
                                    id="category{{ $category->id }}" name="categories[]" @checked(in_array($category->id, old('categories', [])))>
                                {{-- TODO --}}
                                <label for="category{{ $category->id }}" class="form-check-label">
                                    <span class="badge bg-{{ $category->style }}">{{ $category->name }}</span>
                                </label>
                            </div>
                        @empty
                            <p>No categories found</p>
                        @endforelse
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="cover_image" class="col-sm-2 col-form-label">Cover image</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <input type="file" class="form-control-file @error('cover_image') is-invalid @enderror"
                                        id="cover_image" name="cover_image">
                                    @error('cover_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @enderror

                                </div>
                                <div id="cover_preview" class="col-12 d-none">
                                    <p>Cover preview:</p>
                                    <img id="cover_preview_image" src="#" alt="Cover preview" width="300px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Store</button>
                </div>
            </form>
        @endauth
    </div>
@endsection

@section('scripts')
    <script>
        const coverImageInput = document.querySelector('input#cover_image');
        const coverPreviewContainer = document.querySelector('#cover_preview');
        const coverPreviewImage = document.querySelector('img#cover_preview_image');

        coverImageInput.onchange = event => {
            const [file] = coverImageInput.files;
            if (file) {
                coverPreviewContainer.classList.remove('d-none');
                coverPreviewImage.src = URL.createObjectURL(file);
            } else {
                coverPreviewContainer.classList.add('d-none');
            }
        }
    </script>
@endsection
