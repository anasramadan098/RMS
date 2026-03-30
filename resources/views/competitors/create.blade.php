@extends('layouts.app')
@section('page_name', __('competitors.create_competitor'))
@section('content')
<div class="container mt-4 {{ $textAlign }}">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header {{ $textAlign }}">{{ __('competitors.create_new_competitor') }}</div>
                <div class="card-body">
                    <form action="{{ route('competitors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Basic Information -->
                        <h6 class="mb-3">{{ __('competitors.basic_info') }}</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('competitors.name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" 
                                           value="{{ old('name') }}" required 
                                           placeholder="{{ __('competitors.name_placeholder') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">{{ __('competitors.location') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="location" class="form-control" id="location" 
                                           value="{{ old('location') }}" required 
                                           placeholder="{{ __('competitors.location_placeholder') }}">
                                    @error('location')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="website" class="form-label">{{ __('competitors.website') }}</label>
                                    <input type="url" name="website" class="form-control" id="website" 
                                           value="{{ old('website') }}" 
                                           placeholder="{{ __('competitors.website_placeholder') }}">
                                    @error('website')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="avg_price_range" class="form-label">{{ __('competitors.avg_price_range') }} <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="avg_price_range" class="form-control" 
                                           id="avg_price_range" value="{{ old('avg_price_range') }}" required 
                                           placeholder="{{ __('competitors.price_placeholder') }}">
                                    @error('avg_price_range')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <h6 class="mb-3 mt-4">{{ __('competitors.contact_info') }}</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('competitors.email') }}</label>
                                    <input type="email" name="email" class="form-control" id="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="{{ __('competitors.email_placeholder') }}">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">{{ __('competitors.phone') }}</label>
                                    <input type="text" name="phone" class="form-control" id="phone" 
                                           value="{{ old('phone') }}" 
                                           placeholder="{{ __('competitors.phone_placeholder') }}">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        <h6 class="mb-3 mt-4">{{ __('competitors.social_media') }}</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="facebook" class="form-label"><i class="fab fa-facebook"></i> {{ __('competitors.facebook') }}</label>
                                    <input type="url" name="facebook" class="form-control" id="facebook" 
                                           value="{{ old('facebook') }}" 
                                           placeholder="{{ __('competitors.facebook_placeholder') }}">
                                    @error('facebook')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="twitter" class="form-label"><i class="fab fa-twitter"></i> {{ __('competitors.twitter') }}</label>
                                    <input type="url" name="twitter" class="form-control" id="twitter" 
                                           value="{{ old('twitter') }}" 
                                           placeholder="{{ __('competitors.twitter_placeholder') }}">
                                    @error('twitter')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="instagram" class="form-label"><i class="fab fa-instagram"></i> {{ __('competitors.instagram') }}</label>
                                    <input type="url" name="instagram" class="form-control" id="instagram" 
                                           value="{{ old('instagram') }}" 
                                           placeholder="{{ __('competitors.instagram_placeholder') }}">
                                    @error('instagram')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tiktok" class="form-label"><i class="fab fa-tiktok"></i> {{ __('competitors.tiktok') }}</label>
                                    <input type="url" name="tiktok" class="form-control" id="tiktok" 
                                           value="{{ old('tiktok') }}" 
                                           placeholder="{{ __('competitors.tiktok_placeholder') }}">
                                    @error('tiktok')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="youtube" class="form-label"><i class="fab fa-youtube"></i> {{ __('competitors.youtube') }}</label>
                                    <input type="url" name="youtube" class="form-control" id="youtube" 
                                           value="{{ old('youtube') }}" 
                                           placeholder="{{ __('competitors.youtube_placeholder') }}">
                                    @error('youtube')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="linkedin" class="form-label"><i class="fab fa-linkedin"></i> {{ __('competitors.linkedin') }}</label>
                                    <input type="url" name="linkedin" class="form-control" id="linkedin" 
                                           value="{{ old('linkedin') }}" 
                                           placeholder="{{ __('competitors.linkedin_placeholder') }}">
                                    @error('linkedin')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Analysis -->
                        <h6 class="mb-3 mt-4">{{ __('competitors.analysis') }}</h6>
                        <div class="mb-3">
                            <label for="strengths" class="form-label">{{ __('competitors.strengths') }}</label>
                            <textarea name="strengths" class="form-control" id="strengths" rows="3" 
                                      placeholder="{{ __('competitors.strengths_placeholder') }}">{{ old('strengths') }}</textarea>
                            @error('strengths')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="weaknesses" class="form-label">{{ __('competitors.weaknesses') }}</label>
                            <textarea name="weaknesses" class="form-control" id="weaknesses" rows="3" 
                                      placeholder="{{ __('competitors.weaknesses_placeholder') }}">{{ old('weaknesses') }}</textarea>
                            @error('weaknesses')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">{{ __('competitors.notes') }}</label>
                            <textarea name="notes" class="form-control" id="notes" rows="3" 
                                      placeholder="{{ __('competitors.notes_placeholder') }}">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('competitors.index') }}" class="btn btn-secondary me-2">
                                {{ __('app.cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                {{ __('competitors.create_competitor') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
