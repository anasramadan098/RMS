@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('tasks.all_tasks') }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($tasks->isEmpty())
        <div class="alert alert-info">{{ __('tasks.no_tasks') }}</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('tasks.task') }}</th>
                    <th>{{ __('tasks.assigned_user') }}</th>
                    <th>{{ __('tasks.status') }}</th>
                    <th>{{ __('tasks.created_at') }}</th>
                    <th>{{ __('tasks.ended_at') }}</th>
                    <th>{{ __('tasks.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $task->content }}</td>
                    <td>{{ $task->user->name ?? __('tasks.unassigned') }}</td>
                    <td>{{ __('tasks.' . $task->status) }}</td>
                    <td>{{ $task->created_at->format('Y-m-d') }}</td>
                    <td>{{ $task->ended_at }}</td>
                    <td>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">{{ __('tasks.edit') }}</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('{{ __('tasks.are_you_sure') }}')">{{ __('tasks.delete') }}</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tasks->links() }}
    @endif
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mt-3">{{ __('tasks.create_new_task') }}</a>
</div>
@endsection