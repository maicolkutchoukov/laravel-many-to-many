@extends('layouts.app')

@section('page-title', $project->title.' Edit')

@section('main-content')
<h1 class="text-white">
    {{ $project->title }} Edit
</h1>

<div class="row text-white">
    <div class="col py-4">

        

        <div class="mb-4">
            <a href="{{ route('admin.projects.index') }}" class="btn btn-primary">
                Torna all'index dei progetti
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.projects.update', ['project' => $project->id]) }}" method="POST" enctype="multipart/form-data">
            {{--
                C   Cross
                S   Site
                R   Request
                F   Forgery
            --}}
            @csrf

            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Titolo <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $project->title) }}" placeholder="Inserisci il titolo..." maxlength="255" required>
            </div>

            <div class="mb-3">
                <label for="cover_img" class="form-label">Cover image</label>
                <input class="form-control" type="file" id="cover_img" name="cover_img">

                @if ($project->cover_img != null)
                    <div class="mt-2">
                        <h4>
                            Copertina attuale:
                        </h4>
                        <img src="/storage/{{ $project->cover_img }}" style="max-width: 400px;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="delete_cover_img" name="delete_cover_img">
                            <label class="form-check-label" for="delete_cover_img">
                                Rimuovi immagine
                            </label>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Contenuto</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="3" placeholder="Inserisci il contenuto..." required>{{ old('content', $project->content) }}</textarea>
                @error('content')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="type_id" class="form-label">Type</label>
                <select name="type_id" id="type_id" class="form-select">
                    <option value="" {{ old('type_id', $project->type_id) == null ? 'selected' : '' }}>Select a type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" {{ old('type_id', $project->type_id) == $type->id ? 'selected' : '' }}>{{ $type->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="technology" class="form-label">Technology</label>
                <div> 
                    @foreach ($technologies as $technology)
                        <div class="form-check form-check-inline">
                            <input  @if ($errors->any())
                                    {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}
                                    {{-- differently from in_array, we now check if an element ($technology->id) is present in a COLLECTION ($project->technologies) --}}
                                    @else
                                        {{ $project->technologies->contains($technology->id) ? 'checked' : '' }}
                                    @endif
                                    class="form-check-input"
                                    type="checkbox"
                                    id="tag-{{ $technology->id }}"
                                    name="technologies[]"
                                    value="{{ $technology->id }}">
                            <label class="form-check-label" for="tag-{{ $technology->id }}">{{ $technology->title }}</label>
                        </div> 
                    @endforeach
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-warning ">
                    Aggiorna
                </button>
            </div>

        </form>
    </div>
</div>
@endsection