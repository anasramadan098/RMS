@extends('layouts.app')
@section('page_name', __('competitors.competitors'))
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>{{ __('competitors.competitor_list') }}</h6>
                    <a href="{{ route('competitors.create') }}" 
                       class="btn btn-primary btn-sm {{ $isRtl ? 'float-start' : 'float-end' }}" type="button">
                        <i class="fa fa-plus {{ $isRtl ? 'ms-1' : 'me-1' }}"></i> 
                        {{ __('competitors.add_competitor') }}
                    </a>
                </div>
                
                @if(session('success'))
                <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div>
                @endif
                
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                        #</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                        {{ __('competitors.table.name') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                        {{ __('competitors.table.location') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                        {{ __('competitors.table.avg_price') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                        {{ __('competitors.table.contact') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                        {{ __('competitors.table.social_media') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                        {{ __('competitors.table.created_at') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                        {{ __('competitors.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($competitors as $competitor)
                                <tr>
                                    <td class="{{ $isRtl ? 'pe-3' : 'ps-3' }}">
                                        <span class="text-sm font-weight-bold">#{{ $competitor->id }}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">{{ $competitor->name }}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">{{ $competitor->location }}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">${{ number_format($competitor->avg_price_range, 2) }}</span>
                                    </td>
                                    <td>
                                        @if($competitor->phone || $competitor->email)
                                            @if($competitor->phone)
                                                <span class="text-sm"><i class="fa fa-phone"></i> {{ $competitor->phone }}</span><br>
                                            @endif
                                            @if($competitor->email)
                                                <span class="text-sm"><i class="fa fa-envelope"></i> {{ $competitor->email }}</span>
                                            @endif
                                        @else
                                            <span class="text-sm text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $socialCount = collect([
                                                $competitor->facebook,
                                                $competitor->twitter,
                                                $competitor->instagram,
                                                $competitor->tiktok,
                                                $competitor->youtube,
                                                $competitor->linkedin
                                            ])->filter()->count();
                                        @endphp
                                        <span class="text-sm font-weight-bold">{{ $socialCount }} {{ __('competitors.platforms') }}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">{{ $competitor->created_at->format('Y-m-d') }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('competitors.edit', $competitor) }}" 
                                               class="btn btn-link text-secondary mb-0">
                                                <i class="fa fa-edit text-xs"></i>
                                            </a>
                                            <form action="{{ route('competitors.destroy', $competitor) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger mb-0"
                                                        onclick="return confirm('{{ __('competitors.confirm_delete') }}')">
                                                    <i class="fa fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">{{ __('competitors.no_competitors_found') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($competitors->hasPages())
                <div class="card-footer">{{ $competitors->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
