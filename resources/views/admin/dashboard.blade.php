@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('main-content')
    <div class="row">
        @foreach ($projects as $project )
            <div class="col-6">
                <div class="card mb-3" >
                    <div class="row g-0">
                        @if ($project->cover_img != null)
                            <div class="col-md-5 dash-card" style="background-image: url('{{ asset('storage/'.$project->cover_img) }}'); background-size: cover;background-repeat: no-repeat;background-position: center;">
                                <div class="my-3">
                                    {{-- <img src="{{ asset('storage/'.$project->cover_img) }}" class="img-fluid"> --}}
                                </div>
                            </div>
                        @endif
                        <div class="col-7">
                            <div class="card-body">
                            <h5 class="card-title">{{ $project->title }}</h5>
                            <p class="card-text">{{ $project->content }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        @endforeach
    </div>
@endsection
