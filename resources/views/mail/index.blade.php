@extends('layouts.app')

@section('page_name', 'Mail Analytics Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Search Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-0">
                                {{-- Envolope --}}
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                {{__('app.send_marketing_emails')}}
                                @if($whatsapp_enabled)
                                    <i class="fab fa-whatsapp ms-2 text-success"></i>
                                @endif
                            </h4>
                        </div>
                        <div class="col-md-4 text-end">
                            @if($whatsapp_enabled)
                                <span class="badge bg-success">
                                    <i class="fab fa-whatsapp me-1"></i>
                                    {{__('whatsapp.status.enabled')}}
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fab fa-whatsapp me-1"></i>
                                    {{__('whatsapp.status.disabled')}}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <form action="{{route('mail.send')}}" method="POST">
                    @csrf
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h6 class="mb-0">
                                <i class="fas fa-user me-2"></i>
                                {{__('app.all_clients')}}
                            </h6>
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="prompt" class="form-control" placeholder="{{__('app.promt_clients')}}" >
                        </div>

                        <div class="col-md-4">
                            <select name="send_method" class="form-select" required>
                                <option value="email">{{__('whatsapp.form.email_only')}}</option>
                                @if($whatsapp_enabled)
                                    <option value="whatsapp">{{__('whatsapp.form.whatsapp_only')}}</option>
                                    <option value="both">{{__('whatsapp.form.both')}}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body position-relative">
                        <button type="submit" class="btn btn-primary position-sticky top-5 left-5" style="z-index: 1000;">{{__('app.send')}}</button>

                        <div class="row">
                            @foreach($clients as $item)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card h-100 search-result-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar avatar-sm bg-gradient-success  rounded-circle">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">
                                                        <a href="{{ $item->name }}" class="text-decoration-none">
                                                            {{ $item->name }}
                                                        </a>
                                                        @if($item->whatsapp_phone && $item->whatsapp_notifications)
                                                            <i class="fab fa-whatsapp text-success ms-1" title="{{__('whatsapp.whatsapp_notifications')}}"></i>
                                                        @endif
                                                    </h6>
                                                    <p class="text-sm text-muted mb-1">
                                                        <i class="fas fa-envelope me-1"></i>{{ $item->email }}
                                                    </p>
                                                    @if($item->whatsapp_phone)
                                                        <p class="text-sm text-muted mb-0">
                                                            <i class="fab fa-whatsapp me-1 text-success"></i>{{ $item->whatsapp_phone }}
                                                            @if(!$item->whatsapp_notifications)
                                                                <small class="text-warning">({{__('whatsapp.status.disabled')}})</small>
                                                            @endif
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="form-check form-switch ms-auto mailChecoBox">
                                                    <input class="form-check-input" type="checkbox" name="clients[]" value="{{ $item->id }}" id="client_{{ $item->id }}">
                                                    <label class="form-check-label" for="client_{{ $item->id }}"></label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection