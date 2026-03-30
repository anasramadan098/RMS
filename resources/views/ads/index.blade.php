@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">
            <i class="fas fa-bullhorn text-primary"></i> معرض الإعلانات
        </h1>
        <a href="{{ route('ad.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة إعلان جديد
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Ads Grid --}}
    @if($ads->count() > 0)
        <div class="row">
            @foreach($ads as $ad)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="position-relative">
                            <img src="{{ asset($ad->getImagePath()) }}" class="card-img-top" 
                                 alt="{{ $ad->getName() }}" 
                                 style="height: 200px; object-fit: cover;">
                            
                            {{-- Status Badge --}}
                            @if($ad->isActiveNow())
                                <span class="badge bg-success position-absolute top-0 end-0 m-2">
                                    <i class="fas fa-play"></i> نشط الآن
                                </span>
                            @else
                                <span class="badge bg-secondary position-absolute top-0 end-0 m-2">
                                    <i class="fas fa-pause"></i> غير نشط
                                </span>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $ad->getName() }}</h5>
                            
                            @if($ad->getDescription())
                                <p class="card-text text-muted small">{{ Str::limit($ad->getDescription(), 80) }}</p>
                            @endif
                            
                            {{-- Active Status Toggle --}}
                            <div class="mb-2">
                                <span class="badge {{ $ad->active ? 'bg-success' : 'bg-danger' }}">
                                    <i class="fas {{ $ad->active ? 'fa-check' : 'fa-times' }}"></i>
                                    {{ $ad->active ? 'مفعل' : 'معطل' }}
                                </span>
                            </div>
                            
                            <div class="mt-auto">
                                <div class="row text-center mb-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block">وقت البداية</small>
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-clock"></i> {{ $ad->start_time->format('H:i') }}
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">وقت النهاية</small>
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-clock"></i> {{ $ad->end_time->format('H:i') }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="btn-group w-100" role="group">
                                    <a href="{{ route('ad.show', $ad->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> عرض
                                    </a>
                                    <a href="{{ route('ad.edit', $ad->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="confirmDelete({{ $ad->id }})">
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">لا توجد إعلانات حالياً</h4>
            <p class="text-muted">قم بإضافة أول إعلان للبدء</p>
            <a href="{{ route('ad.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> إضافة إعلان
            </a>
        </div>
    @endif
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
                هل أنت متأكد من حذف هذا الإعلان؟ لن يمكن استرجاع هذه العملية.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> حذف
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(adId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `{{ url('ad') }}/${adId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
@endsection
