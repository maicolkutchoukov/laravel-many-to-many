@extends('layouts.app')

@section('page-title', $project->title)

@section('main-content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center text-success">
                    {{$project->title}}
                </h1>

                @if ($project->cover_img != null)
                        <div class="my-3">
                            <img src="{{ asset('storage/'.$project->cover_img) }}" style="max-width: 400px;">
                        </div>
                    @endif
                <p>
                    {{ $project->content }}
                </p>

                <p> Type: 
                    @if ($project->type != null)
                        <a href="{{ route('admin.types.show', ['type' => $project->type->id]) }}" class="link-offset-2 link-underline link-underline-opacity-0">{{ $project->type->title }}</a>
                    @else
                        -
                    @endif
                </p>
                <p> Technologies: 
                    @forelse ($project->technologies as $technology)
                        <a href="{{ route('admin.technologies.show', ['technology' => $technology->id]) }}" class="link-offset-2 link-underline link-underline-opacity-0">{{ $technology->title }}</a>
                    @empty
                        -
                    @endforelse
                </p>
                <div class="mb-4">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-primary">
                        Torna all'index dei progetti
                    </a>
                    <a href="{{ route('admin.projects.edit', ['project' => $project->id]) }}" class="btn btn-xs btn-warning">
                        Modifica
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection