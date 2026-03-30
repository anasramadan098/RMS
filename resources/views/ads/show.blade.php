@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-eye"></i> عرض تفاصيل الإعلان
                        </h4>
                        {{-- Status Badge --}}
                        @if($ad->isActiveNow())
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-play"></i> نشط الآن
                            </span>
                        @else
                            <span class="badge bg-secondary fs-6">
                                <i class="fas fa-pause"></i> غير نشط
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Ad Images --}}
                        <div class="col-md-5">
                            <div class="text-center">
                                {{-- Language Tabs --}}
                                <ul class="nav nav-tabs mb-3" id="imageTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="ar-tab" data-bs-toggle="tab" data-bs-target="#ar-image" type="button" role="tab">
                                            عربي
                                        </button>
                                    </li>
                                    @if($ad->path_en)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-image" type="button" role="tab">
                                            English
                                        </button>
                                    </li>
                                    @endif
                                </ul>
                                
                                {{-- Tab Contents --}}
                                <div class="tab-content" id="imageTabsContent">
                                    <div class="tab-pane fade show active" id="ar-image" role="tabpanel">
                                        <img src="{{ asset($ad->getImagePath('ar')) }}" 
                                             alt="{{ $ad->getName('ar') }}" 
                                             class="img-fluid rounded shadow"
                                             style="max-height: 400px; width: 100%; object-fit: cover;">
                                    </div>
                                    @if($ad->path_en)
                                    <div class="tab-pane fade" id="en-image" role="tabpanel">
                                        <img src="{{ asset($ad->getImagePath('en')) }}" 
                                             alt="{{ $ad->getName('en') }}" 
                                             class="img-fluid rounded shadow"
                                             style="max-height: 400px; width: 100%; object-fit: cover;">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        {{-- Ad Details --}}
                        <div class="col-md-7">
                            <div class="ps-md-4">
                                {{-- Ad Names --}}
                                <div class="mb-4">
                                    <h3 class="text-primary mb-2">
                                        <i class="fas fa-tag"></i> {{ $ad->getName() }}
                                    </h3>
                                    @if($ad->name_ar && $ad->name_en && $ad->name_ar !== $ad->name_en)
                                        <p class="text-muted small">
                                            <strong>عربي:</strong> {{ $ad->name_ar }} | 
                                            <strong>English:</strong> {{ $ad->name_en }}
                                        </p>
                                    @endif
                                    <hr>
                                </div>

                                {{-- Descriptions --}}
                                @if($ad->getDescription())
                                    <div class="mb-4">
                                        <h5 class="text-muted">
                                            <i class="fas fa-align-left"></i> الوصف
                                        </h5>
                                        <p class="lead">{{ $ad->getDescription() }}</p>
                                        @if($ad->description_ar && $ad->description_en && $ad->description_ar !== $ad->description_en)
                                            <div class="accordion" id="descriptionAccordion">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingDescription">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDescription">
                                                            عرض الوصف باللغتين
                                                        </button>
                                                    </h2>
                                                    <div id="collapseDescription" class="accordion-collapse collapse" data-bs-parent="#descriptionAccordion">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6>عربي:</h6>
                                                                    <p>{{ $ad->description_ar }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6>English:</h6>
                                                                    <p>{{ $ad->description_en }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                {{-- Time Information --}}
                                <div class="mb-4">
                                    <h5 class="text-muted mb-3">
                                        <i class="fas fa-clock"></i> أوقات العرض
                                    </h5>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="card bg-light">
                                                <div class="card-body text-center py-3">
                                                    <h6 class="card-title text-success mb-2">
                                                        <i class="fas fa-play-circle"></i> وقت البداية
                                                    </h6>
                                                    <h4 class="text-success mb-0">
                                                        {{ $ad->start_time->format('H:i') }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="card bg-light">
                                                <div class="card-body text-center py-3">
                                                    <h6 class="card-title text-danger mb-2">
                                                        <i class="fas fa-stop-circle"></i> وقت النهاية
                                                    </h6>
                                                    <h4 class="text-danger mb-0">
                                                        {{ $ad->end_time->format('H:i') }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Duration --}}
                                <div class="mb-4">
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading">
                                            <i class="fas fa-hourglass-half"></i> مدة عرض الإعلان
                                        </h6>
                                        <p class="mb-0">
                                            @php
                                                $start = \Carbon\Carbon::parse($ad->start_time);
                                                $end = \Carbon\Carbon::parse($ad->end_time);
                                                $duration = $start->diff($end);
                                            @endphp
                                            {{ $duration->h }} ساعة و {{ $duration->i }} دقيقة
                                        </p>
                                    </div>
                                </div>

                                {{-- Status and Additional Info --}}
                                <div class="mb-4">
                                    <h5 class="text-muted mb-3">
                                        <i class="fas fa-info-circle"></i> معلومات إضافية
                                    </h5>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <small class="text-muted">حالة الإعلان:</small>
                                            <p class="mb-1">
                                                <span class="badge {{ $ad->active ? 'bg-success' : 'bg-danger' }}">
                                                    <i class="fas {{ $ad->active ? 'fa-check' : 'fa-times' }}"></i>
                                                    {{ $ad->active ? 'مفعل' : 'معطل' }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col-sm-4">
                                            <small class="text-muted">تاريخ الإنشاء:</small>
                                            <p class="mb-1">{{ $ad->created_at->format('d/m/Y') }}</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <small class="text-muted">آخر تحديث:</small>
                                            <p class="mb-1">{{ $ad->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                <a href="{{ route('ad.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> العودة للقائمة
                                </a>
                                
                                <div class="d-flex gap-2">
                                    <a href="{{ route('ad.edit', $ad->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                    
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                    
                                    {{-- Download Buttons --}}
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="{{ asset($ad->getImagePath('ar')) }}" 
                                           download="{{ $ad->getName('ar') }}_ar" 
                                           class="btn btn-success">
                                            <i class="fas fa-download"></i> تحميل الصورة العربية
                                        </a>
                                        
                                        @if($ad->path_en)
                                            <a href="{{ asset($ad->getImagePath('en')) }}" 
                                               download="{{ $ad->getName('en') }}_en" 
                                               class="btn btn-success">
                                                <i class="fas fa-download"></i> Download English Image
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تأكيد الحذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h5>هل أنت متأكد من حذف هذا الإعلان؟</h5>
                    <p class="text-muted">
                        سيتم حذف الإعلان "<strong>{{ $ad->getName() }}</strong>" نهائياً ولن يمكن استرجاعه.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> إلغاء
                </button>
                <form action="{{ route('ad.destroy', $ad->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> نعم، احذف
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Auto refresh status every minute to check if ad is currently active
setInterval(function() {
    const now = new Date();
    const currentTime = now.getHours().toString().padStart(2, '0') + ':' + 
                       now.getMinutes().toString().padStart(2, '0');
    
    const startTime = '{{ $ad->start_time->format("H:i") }}';
    const endTime = '{{ $ad->end_time->format("H:i") }}';
    
    const statusBadge = document.querySelector('.badge');
    
    if (currentTime >= startTime && currentTime <= endTime) {
        if (statusBadge.classList.contains('bg-secondary')) {
            statusBadge.className = 'badge bg-success fs-6';
            statusBadge.innerHTML = '<i class="fas fa-play"></i> نشط الآن';
        }
    } else {
        if (statusBadge.classList.contains('bg-success')) {
            statusBadge.className = 'badge bg-secondary fs-6';
            statusBadge.innerHTML = '<i class="fas fa-pause"></i> غير نشط';
        }
    }
}, 60000); // Check every minute
</script>
@endpush
@endsection