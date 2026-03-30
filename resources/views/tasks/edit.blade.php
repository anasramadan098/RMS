@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('tasks.edit_task') }}</h2>
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')


        <div class="mb-3">
            <label for="content" class="form-label">{{ __('tasks.content') }}</label>
            <textarea 
                class="form-control" 
                id="content" 
                name="content" 
                rows="4"
                required>{{ old('content', $task->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">{{ __('tasks.status') }}</label>
            <select class="form-select" id="status" name="status" required>
                <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>{{ __('tasks.pending') }}</option>
                <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>{{ __('tasks.in_progress') }}</option>
                <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>{{ __('tasks.completed') }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="ended_at" class="form-label">{{ __('tasks.due_date') }}</label>
            <input 
                type="datetime-local" 
                class="form-control" 
                id="ended_at" 
                name="ended_at" 
                value="{{ old('ended_at', $task->ended_at ? $task->ended_at : '') }}">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('tasks.update_task') }}</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">{{ __('tasks.cancel') }}</a>
    </form>
</div>
@endsection