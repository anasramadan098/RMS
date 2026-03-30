@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-edit"></i> تعديل الإعلان: {{ $ad->getName() }}
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

                    <form action="{{ route('ad.update', $ad->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        {{-- Current Images Preview --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-image text-primary"></i> الصورة العربية الحالية
                                </label>
                                <div class="text-center p-3 border rounded bg-light">
                                    <img src="{{ asset($ad->getImagePath('ar')) }}" 
                                         alt="{{ $ad->getName('ar') }}" 
                                         class="img-thumbnail"
                                         style="max-height: 200px;">
                                </div>
                            </div>
                            @if($ad->path_en)
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-image text-primary"></i> Current English Image
                                </label>
                                <div class="text-center p-3 border rounded bg-light">
                                    <img src="{{ asset($ad->getImagePath('en')) }}" 
                                         alt="{{ $ad->getName('en') }}" 
                                         class="img-thumbnail"
                                         style="max-height: 200px;">
                                </div>
                            </div>
                            @endif
                        </div>

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
                                       value="{{ old('name_ar', $ad->name_ar) }}" 
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
                                       value="{{ old('name_en', $ad->name_en) }}" 
                                       placeholder="Example: Special Pizza Offer"
                                       required>
                                @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Ad Description --}}
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="description" class="form-label">
                                    <i class="fas fa-align-left text-primary"></i> وصف الإعلان
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="3"
                                          placeholder="اكتب وصفاً مختصراً للإعلان...">{{ old('description', $ad->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Time Settings --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_time" class="form-label">
                                    <i class="fas fa-play text-success"></i> وقت البداية *
                                </label>
                                <input type="time" 
                                       class="form-control @error('start_time') is-invalid @enderror" 
                                       id="start_time" 
                                       name="start_time" 
                                       value="{{ old('start_time', $ad->start_time->format('H:i')) }}"
                                       required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="end_time" class="form-label">
                                    <i class="fas fa-stop text-danger"></i> وقت النهاية *
                                </label>
                                <input type="time" 
                                       class="form-control @error('end_time') is-invalid @enderror" 
                                       id="end_time" 
                                       name="end_time" 
                                       value="{{ old('end_time', $ad->end_time->format('H:i')) }}"
                                       required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Image Upload (Optional for Edit) --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="img" class="form-label">
                                    <i class="fas fa-image text-primary"></i> تغيير صورة الإعلان (اختياري)
                                </label>
                                <input type="file" 
                                       class="form-control @error('img') is-invalid @enderror" 
                                       id="img" 
                                       name="img" 
                                       accept="image/*"
                                       onchange="previewNewImage(this)">
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i> 
                                    اتركه فارغاً للاحتفاظ بالصورة الحالية | الحد الأقصى: 2 ميجابايت
                                </div>
                                @error('img')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                {{-- New Image Preview --}}
                                <div id="newImagePreview" class="mt-3" style="display: none;">
                                    <label class="form-label">الصورة الجديدة:</label>
                                    <img id="newPreview" src="" alt="معاينة الصورة الجديدة" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="img_en" class="form-label">
                                    <i class="fas fa-image text-primary"></i> تغيير صورة الإعلان (الإنجليزية)
                                </label>
                                <input type="file" 
                                       class="form-control @error('img_en') is-invalid @enderror" 
                                       id="img_en" 
                                       name="img_en" 
                                       accept="image/*"
                                       onchange="previewNewImage(this)">
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i> 
                                    اتركه فارغاً للاحتفاظ بالصورة الحالية | الحد الأقصى: 2 ميجابايت
                                </div>
                                @error('img_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                {{-- New Image Preview --}}
                                <div id="newImagePreview" class="mt-3" style="display: none;">
                                    <label class="form-label">الصورة الجديدة:</label>
                                    <img id="newPreview" src="" alt="معاينة الصورة الجديدة" class="img-thumbnail" style="max-height: 200px;">
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
                                    <div>
                                        <a href="{{ route('ad.show', $ad->id) }}" class="btn btn-info me-2">
                                            <i class="fas fa-eye"></i> عرض
                                        </a>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-save"></i> تحديث الإعلان
                                        </button>
                                    </div>
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
function previewNewImage(input) {
    const preview = document.getElementById('newPreview');
    const previewContainer = document.getElementById('newImagePreview');
    
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