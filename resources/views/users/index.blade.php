@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4 pe-5">
            <h1>{{ __('users.manage_users') }}</h1>
            <a href="{{ route('users.create') }}" class="btn btn-primary mb-0">
                <i class="fas fa-plus me-2"></i>{{ __('users.add_new_user') }}
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('users.all_users') }}</h5>
            </div>
            <div class="card-body">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>{{ __('users.table.id') }}</th>
                                    <th>{{ __('users.table.name') }}</th>
                                    <th>{{ __('users.table.email') }}</th>
                                    <th>{{ __('users.table.role') }}</th>
                                    <th>{{ __('users.table.created') }}</th>
                                    <th>{{ __('users.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center me-2" 
                                                     style="width: 32px; height: 32px;">
                                                    <i class="fas fa-user text-white small"></i>
                                                </div>
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge {{ $user->role->value === 'owner' ? 'bg-warning' : 'bg-primary' }}">
                                                {{ $user->role->label() }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('users.edit', $user) }}" 
                                                   class="btn btn-md btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <form method="POST" 
                                                          action="{{ route('users.destroy', $user) }}" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('{{ __('users.delete_user_confirm') }}')"
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-md btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">{{ __('users.no_users_found') }}</h5>
                        <p class="text-muted">{{ __('users.start_by_adding') }}</p>
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>{{ __('users.add_user') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
