@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('tasks.create_new_task') }}</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="content" class="form-label">{{ __('tasks.content') }}</label>
            <textarea name="content" class="form-control" id="content" rows="4" required>{{ old('content') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="ended_at" class="form-label">{{ __('tasks.due_date') }}</label>
            <input type="datetime-local" name="ended_at" class="form-control" id="ended_at" value="{{ old('ended_at') }}">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">{{ __('tasks.status') }}</label>
            <select name="status" class="form-select" id="status">
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ __('tasks.pending') }}</option>
                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>{{ __('tasks.in_progress') }}</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>{{ __('tasks.completed') }}</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">{{ __('tasks.employee') }}</label>
            <select name="user_id" class="form-select" id="user_id">
                <option value="" selected disabled>{{ __('tasks.employee') }}</option>
                @foreach ($users as $user)  
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('tasks.create_task') }}</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">{{ __('tasks.cancel') }}</a>
    </form>
</div>
@endsection