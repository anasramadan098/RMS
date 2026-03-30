@extends('layouts.app')

@section('page_name', __('projects.edit_project'))

@section('content')
<div class="container {{ $textAlign }}">
    <h2>{{ __('projects.edit_project') }}</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('projects.project_name') }}</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $project->name) }}" required placeholder="{{ __('projects.placeholders.enter_project_name') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">{{ __('projects.description') }}</label>
            <textarea name="description" class="form-control" id="description" rows="4" placeholder="{{ __('projects.placeholders.enter_description') }}">{{ old('description', $project->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">{{ __('app.link') }}</label>
            <input type="url" name="link" class="form-control" id="link" value="{{ old('link', $project->link) }}" placeholder="https://example.com">
        </div>



        <div class="mb-3">
            <label for="strengths" class="form-label">{{ __('app.strengths') }}</label>
            <textarea name="strengths"  class="form-control" id="strengths">{{ old('strengths', $project->strengths) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="weaknesses" class="form-label">{{ __('app.weaknesses') }}</label>
            <textarea name="weaknesses"  class="form-control" id="weaknesses">{{ old('weaknesses', $project->weaknesses) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="opportunities" class="form-label">{{ __('app.opportunities') }}</label>
            <textarea name="opportunities"  class="form-control" id="opportunities">{{ old('opportunities', $project->opportunities) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="threats" class="form-label">{{ __('app.threats') }}</label>
            <textarea name="threats"  class="form-control" id="threats">{{ old('threats', $project->threats) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">{{ __('projects.status') }}</label>
            <select name="status" id="status" class="form-control" required>
                <option value="Active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>{{ __('projects.statuses.in_progress') }}</option>
                <option value="not Active" {{ old('status', $project->status) == 'not_active' ? 'selected' : '' }}>{{ __('projects.statuses.on_hold') }}</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary {{ $isRtl ? 'ms-2' : 'me-2' }}">{{ __('projects.update_project') }}</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">{{ __('app.cancel') }}</a>
    </form>
</div>
@endsection