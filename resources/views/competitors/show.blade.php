@extends('layouts.app')
@section('page_name', __('competitors.competitor_details'))
@section('content')
<div class="container mt-4 {{ $textAlign }}">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header {{ $textAlign }} d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('competitors.competitor_details') }}</h5>
                    <a href="{{ route('competitors.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left"></i> {{ __('app.back') }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-12">
                            <h6 class="mb-3 text-primary">{{ __('competitors.basic_info') }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">{{ __('competitors.name') }}</label>
                            <p class="fw-bold">{{ $competitor->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">{{ __('competitors.location') }}</label>
                            <p class="fw-bold">{{ $competitor->location }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">{{ __('competitors.website') }}</label>
                            <p>
                                @if($competitor->website)
                                    <a href="{{ $competitor->website }}" target="_blank" class="text-decoration-none">
                                        <i class="fa fa-external-link-alt"></i> {{ __('competitors.visit_website') }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">{{ __('competitors.avg_price_range') }}</label>
                            <p class="fw-bold">${{ number_format($competitor->avg_price_range, 2) }}</p>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-md-12 mt-4">
                            <h6 class="mb-3 text-primary">{{ __('competitors.contact_info') }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">{{ __('competitors.email') }}</label>
                            <p>
                                @if($competitor->email)
                                    <a href="mailto:{{ $competitor->email }}" class="text-decoration-none">
                                        <i class="fa fa-envelope"></i> {{ $competitor->email }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">{{ __('competitors.phone') }}</label>
                            <p>
                                @if($competitor->phone)
                                    <a href="tel:{{ $competitor->phone }}" class="text-decoration-none">
                                        <i class="fa fa-phone"></i> {{ $competitor->phone }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </p>
                        </div>

                        <!-- Social Media Links -->
                        <div class="col-md-12 mt-4">
                            <h6 class="mb-3 text-primary">{{ __('competitors.social_media') }}</h6>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <strong><i class="fab fa-facebook text-primary"></i> {{ __('competitors.facebook') }}:</strong>
                                    @if($competitor->facebook)
                                        <a href="{{ $competitor->facebook }}" target="_blank" class="d-block text-decoration-none">
                                            {{ __('competitors.view_profile') }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                                <div class="col-md-4 mb-2">
                                    <strong><i class="fab fa-twitter text-info"></i> {{ __('competitors.twitter') }}:</strong>
                                    @if($competitor->twitter)
                                        <a href="{{ $competitor->twitter }}" target="_blank" class="d-block text-decoration-none">
                                            {{ __('competitors.view_profile') }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                                <div class="col-md-4 mb-2">
                                    <strong><i class="fab fa-instagram text-danger"></i> {{ __('competitors.instagram') }}:</strong>
                                    @if($competitor->instagram)
                                        <a href="{{ $competitor->instagram }}" target="_blank" class="d-block text-decoration-none">
                                            {{ __('competitors.view_profile') }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                                <div class="col-md-4 mb-2">
                                    <strong><i class="fab fa-tiktok text-dark"></i> {{ __('competitors.tiktok') }}:</strong>
                                    @if($competitor->tiktok)
                                        <a href="{{ $competitor->tiktok }}" target="_blank" class="d-block text-decoration-none">
                                            {{ __('competitors.view_profile') }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                                <div class="col-md-4 mb-2">
                                    <strong><i class="fab fa-youtube text-danger"></i> {{ __('competitors.youtube') }}:</strong>
                                    @if($competitor->youtube)
                                        <a href="{{ $competitor->youtube }}" target="_blank" class="d-block text-decoration-none">
                                            {{ __('competitors.view_profile') }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                                <div class="col-md-4 mb-2">
                                    <strong><i class="fab fa-linkedin text-primary"></i> {{ __('competitors.linkedin') }}:</strong>
                                    @if($competitor->linkedin)
                                        <a href="{{ $competitor->linkedin }}" target="_blank" class="d-block text-decoration-none">
                                            {{ __('competitors.view_profile') }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Analysis -->
                        <div class="col-md-12 mt-4">
                            <h6 class="mb-3 text-primary">{{ __('competitors.analysis') }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">{{ __('competitors.strengths') }}</label>
                            <div class="bg-light p-3 rounded">
                                {{ $competitor->strengths ?: __('competitors.no_data') }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">{{ __('competitors.weaknesses') }}</label>
                            <div class="bg-light p-3 rounded">
                                {{ $competitor->weaknesses ?: __('competitors.no_data') }}
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">{{ __('competitors.notes') }}</label>
                            <div class="bg-light p-3 rounded">
                                {{ $competitor->notes ?: __('competitors.no_data') }}
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div class="col-md-12 mt-4 pt-3 border-top">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">{{ __('competitors.created_at') }}:</small>
                                    <p>{{ $competitor->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">{{ __('competitors.updated_at') }}:</small>
                                    <p>{{ $competitor->updated_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="col-md-12 mt-4">
                            <div class="d-flex gap-2">
                                <a href="{{ route('competitors.edit', $competitor) }}" class="btn btn-primary">
                                    <i class="fa fa-edit"></i> {{ __('competitors.edit_competitor') }}
                                </a>
                                <form action="{{ route('competitors.destroy', $competitor) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                            onclick="return confirm('{{ __('competitors.confirm_delete') }}')">
                                        <i class="fa fa-trash"></i> {{ __('competitors.delete_competitor') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
