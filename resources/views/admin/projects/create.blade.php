@extends('layouts.app')

@section('page-title', 'projects Create')

@section('main-content')
<h1>
    Projects Create
</h1>

<div class="row text-white">
    <div class="col py-4">
        <div class="mb-4">
            <a href="{{ route('admin.projects.index') }}" class="btn btn-primary">
                Torna all'index dei Project
            </a>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            {{--
                C   Cross
                S   Site
                R   Request
                F   Forgery
            --}}
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Titolo <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Inserisci il titolo..." maxlength="255" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Contenuto</label>
                <textarea class="form-control" id="content" name="content" rows="3" placeholder="Inserisci il contenuto..." required>{{ old('content') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="cover_img" class="form-label">Cover image</label>
                <input class="form-control" type="file" id="cover_img" name="cover_img">
            </div>

            <div class="mb-3">
                <label for="type_id" class="form-label">Categoria</label>
                <select name="type_id" id="type_id" class="form-select">
                    <option
                        value="
                        {{ old('type_id') == null ? 'selected' : '' }}">
                        Seleziona una categoria...
                    </option>
                    @foreach ($types as $type)
                        <option
                            value="{{ $type->id }}"
                            {{ old('type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 text-white">
                <label class="form-label">technology</label>

                <div>
                    @foreach ($technologies as $technology)
                        <div class="form-check form-check-inline">
                            <input
                                {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}
                                class="form-check-input"
                                type="checkbox"
                                id="technology-{{ $technology->id }}"
                                name="technologies[]"
                                value="{{ $technology->id }}">
                            <label class="form-check-label" for="technology-{{ $technology->id }}">{{ $technology->title }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-success w-100">
                    + Aggiungi
                </button>
            </div>

        </form>
    </div>
</div>
@endsection