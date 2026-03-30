@extends('layouts.app')


@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{__('app.model_suggestions')}}</h4>
                </div>
                <div class="card-body">
                    @if(session('msg'))
                        <div class="alert alert-success">{{ session('msg') }}</div>
                    @endif

                    {{-- @if(isset($suggestions) && count($suggestions))
                        <ul class="list-group mb-4">
                            @foreach($suggestions as $suggestion)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $suggestion['title'] }}</strong>
                                        <p class="mb-1 text-muted">{{ $suggestion['description'] }}</p>
                                        <span class="badge bg-info">{{ $suggestion['model'] }}</span>
                                    </div>
                                    <a href="{{ $suggestion['link'] }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        View Model
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-info">
                            No AI model suggestions available at the moment.
                        </div>
                    @endif --}}

                    {!! $response !!}

                    <a href="/ai-suggestions" type="submit" class="btn btn-primary d-block mx-auto mt-2">
                        Refresh Suggestions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection