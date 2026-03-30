@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ __('feedbacks.feedback_details') }}</h1>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $feedback->en_name }}</h5>
            <p class="card-text"><strong>{{ __('feedbacks.stars') }}:</strong> {{ $feedback->stars }}</p>
            <p class="card-text"><strong>{{ __('feedbacks.comment') }}:</strong> {{ $feedback->en_comment }}</p>
            <p class="card-text"><strong>{{ __('feedbacks.date') }}:</strong> {{ $feedback->human_date }}</p>
        </div>
    </div>
    <a href="{{ route('feedbacks.edit', $feedback->id) }}" class="btn btn-warning">{{ __('app.edit') }}</a>
    <form action="{{ route('feedbacks.destroy', $feedback->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('feedbacks.delete_confirm') }}')">{{ __('app.delete') }}</button>
    </form>
    <a href="{{ route('feedbacks.index') }}" class="btn btn-secondary">{{ __('app.back') }}</a>
</div>
@endsection
