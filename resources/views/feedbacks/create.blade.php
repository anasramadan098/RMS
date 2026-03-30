@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ __('feedbacks.add_feedback') }}</h1>
    <form action="{{ route('feedbacks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="en_name" class="form-label">{{ __('feedbacks.en_name') }}</label>
            <input type="text" name="en_name" id="en_name" class="form-control" value="{{ old('en_name') }}" required>
            @error('en_name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="ar_name" class="form-label">{{ __('feedbacks.ar_name') }}</label>
            <input type="text" name="ar_name" id="ar_name" class="form-control" value="{{ old('ar_name') }}" required>
            @error('ar_name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="stars" class="form-label">{{ __('feedbacks.stars') }}</label>
            <input type="number" name="stars" id="stars" class="form-control" min="1" max="5" value="{{ old('stars') }}" required>
            @error('stars')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="en_comment" class="form-label">{{ __('feedbacks.en_comment') }}</label>
            <textarea name="en_comment" id="en_comment" class="form-control">{{ old('en_comment') }}</textarea>
            @error('en_comment')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="ar_comment" class="form-label">{{ __('feedbacks.ar_comment') }}</label>
            <textarea name="ar_comment" id="ar_comment" class="form-control">{{ old('ar_comment') }}</textarea>
            @error('ar_comment')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">{{ __('feedbacks.date') }}</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required max="{{ date('Y-m-d') }}" >
            @error('date')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-success">{{ __('app.save') }}</button>
        <a href="{{ route('feedbacks.index') }}" class="btn btn-secondary">{{ __('app.back') }}</a>
    </form>
</div>
@endsection
