@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle"></i> إنشاء إعلان جديد
                    </h4>
                </div>
                <div class="card-body">
                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-exclamation-triangle"></i> يرجى تصحيح الأخطاء التالية:</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('ad.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Ad Names --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name_ar" class="form-label">
                                    <i class="fas fa-tag text-primary"></i> اسم الإعلان (عربي) *
                                </label>
                                <input type="text" 
                                       class="form-control @error('name_ar') is-invalid @enderror" 
                                       id="name_ar" 
                                       name="name_ar" 
                                       value="{{ old('name_ar') }}" 
                                       placeholder="مثال: عرض خاص على البيتزا"
                                       required>
                                @error('name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="name_en" class="form-label">
                                    <i class="fas fa-tag text-primary"></i> Ad Name (English) *
                                </label>
                                <input type="text" 
                                       class="form-control @error('name_en') is-invalid @enderror" 
                                       id="name_en" 
                                       name="name_en" 
                                       value="{{ old('name_en') }}" 
                                       placeholder="Example: Special Pizza Offer"
                                       required>
                                @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Ad Descriptions --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="description_ar" class="form-label">
                                    <i class="fas fa-align-left text-primary"></i> وصف الإعلان (عربي)
                                </label>
                                <textarea class="form-control @error('description_ar') is-invalid @enderror" 
                                          id="description_ar" 
                                          name="description_ar" 
                                          rows="3"
                                          placeholder="اكتب وصفاً مختصراً للإعلان...">{{ old('description_ar') }}</textarea>
                                @error('description_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="description_en" class="form-label">
                                    <i class="fas fa-align-left text-primary"></i> Ad Description (English)
                                </label>
                                <textarea class="form-control @error('description_en') is-invalid @enderror" 
                                          id="description_en" 
                                          name="description_en" 
                                          rows="3"
                                          placeholder="Write a brief description for the ad...">{{ old('description_en') }}</textarea>
                                @error('description_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Time Settings and Active Status --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="start_time" class="form-label">
                                    <i class="fas fa-play text-success"></i> وقت البداية *
                                </label>
                                <input type="time" 
                                       class="form-control @error('start_time') is-invalid @enderror" 
                                       id="start_time" 
                                       name="start_time" 
                                       value="{{ old('start_time', '00:00') }}"
                                       required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="end_time" class="form-label">
                                    <i class="fas fa-stop text-danger"></i> وقت النهاية *
                                </label>
                                <input type="time" 
                                       class="form-control @error('end_time') is-invalid @enderror" 
                                       id="end_time" 
                                       name="end_time" 
                                       value="{{ old('end_time', '23:59') }}"
                                       required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="active" class="form-label">
                                    <i class="fas fa-toggle-on text-primary"></i> حالة الإعلان
                                </label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="active" 
                                           name="active" 
                                           value="1"
                                           {{ old('active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">
                                        مفعل
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Image Upload --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="img" class="form-label">
                                    <i class="fas fa-image text-primary"></i> صورة الإعلان (عربي) *
                                </label>
                                <input type="file" 
                                       class="form-control @error('img') is-invalid @enderror" 
                                       id="img" 
                                       name="img" 
                                       accept="image/*"
                                       onchange="previewImage(this, 'preview')"
                                       required>
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i> 
                                    الحد الأقصى: 2 ميجابايت | الأنواع المدعومة: JPEG, PNG, JPG, GIF, WEBP
                                </div>
                                @error('img')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                {{-- Arabic Image Preview --}}
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="preview" src="" alt="معاينة الصورة" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="img_en" class="form-label">
                                    <i class="fas fa-image text-primary"></i> Ad Image (English) <small class="text-muted">(اختياري)</small>
                                </label>
                                <input type="file" 
                                       class="form-control @error('img_en') is-invalid @enderror" 
                                       id="img_en" 
                                       name="img_en" 
                                       accept="image/*"
                                       onchange="previewImage(this, 'preview_en')">
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i> 
                                    Max: 2MB | Supported: JPEG, PNG, JPG, GIF, WEBP
                                </div>
                                @error('img_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                {{-- English Image Preview --}}
                                <div id="imagePreviewEn" class="mt-3" style="display: none;">
                                    <img id="preview_en" src="" alt="English Image Preview" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('ad.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> العودة للقائمة
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> إنشاء الإعلان
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const previewContainer = previewId === 'preview' ? document.getElementById('imagePreview') : document.getElementById('imagePreviewEn');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.style.display = 'none';
    }
}

// Validate time inputs
document.getElementById('start_time').addEventListener('change', function() {
    const startTime = this.value;
    const endTimeInput = document.getElementById('end_time');
    
    if (startTime && endTimeInput.value && startTime >= endTimeInput.value) {
        alert('وقت البداية يجب أن يكون قبل وقت النهاية');
        this.focus();
    }
});

document.getElementById('end_time').addEventListener('change', function() {
    const endTime = this.value;
    const startTimeInput = document.getElementById('start_time');
    
    if (startTimeInput.value && endTime && startTimeInput.value >= endTime) {
        alert('وقت النهاية يجب أن يكون بعد وقت البداية');
        this.focus();
    }
});
</script>
@endpush
@endsection