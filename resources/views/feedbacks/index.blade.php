@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ __('feedbacks.feedback_list') }}</h1>
    @if(session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif
    <a href="{{ route('feedbacks.create') }}" class="btn btn-primary mb-3">{{ __('feedbacks.add_feedback') }}</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{ __('feedbacks.name') }}</th>
                <th>{{ __('feedbacks.stars') }}</th>
                <th>{{ __('feedbacks.comment') }}</th>
                <th>{{ __('feedbacks.date') }}</th>
                <th>{{ __('app.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->en_name }}</td>
                    <td>{{ $feedback->stars }}</td>
                    <td>{{ $feedback->en_comment }}</td>
                    <td>{{ $feedback->date }}</td>
                    <td>
                        <a href="{{ route('feedbacks.show', $feedback->id) }}" class="btn btn-info btn-sm">{{ __('app.show') }}</a>
                        <a href="{{ route('feedbacks.edit', $feedback->id) }}" class="btn btn-warning btn-sm">{{ __('app.edit') }}</a>
                        <form action="{{ route('feedbacks.destroy', $feedback->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('feedbacks.delete_confirm') }}')">{{ __('app.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $feedbacks->links() }}
</div>
@endsection
