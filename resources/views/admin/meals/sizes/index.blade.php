@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">أحجام الوجبة: {{ $meal->name_ar }}</h1>
                <p class="text-gray-600">إدارة أحجام وأسعار الوجبة</p>
            </div>
            <div class="flex space-x-2 space-x-reverse">
                <a href="{{ route('meals.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    العودة للوجبات
                </a>
                <button onclick="openAddSizeModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    إضافة حجم جديد
                </button>
            </div>
        </div>

        <!-- Sizes Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحجم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">السعر</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">السعر الإضافي</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">افتراضي</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($sizes as $size)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $size->name_ar }}</div>
                                @if($size->name_en)
                                <div class="text-sm text-gray-500">{{ $size->name_en }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($size->price, 2) }} ج.م
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($size->additional_price > 0)
                                <span class="text-green-600">+{{ number_format($size->additional_price, 2) }} ج.م</span>
                            @elseif($size->additional_price < 0)
                                <span class="text-red-600">{{ number_format($size->additional_price, 2) }} ج.م</span>
                            @else
                                <span class="text-gray-500">0.00 ج.م</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($size->is_default)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    افتراضي
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($size->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    نشط
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    غير نشط
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2 space-x-reverse">
                                <button onclick="editSize({{ $size->id }})" class="text-blue-600 hover:text-blue-900">
                                    تعديل
                                </button>
                                <button onclick="toggleSizeStatus({{ $size->id }})" class="text-yellow-600 hover:text-yellow-900">
                                    {{ $size->is_active ? 'إلغاء تفعيل' : 'تفعيل' }}
                                </button>
                                <button onclick="deleteSize({{ $size->id }})" class="text-red-600 hover:text-red-900">
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            لا توجد أحجام مضافة لهذه الوجبة
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Size Modal -->
<div id="sizeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
        <h3 id="modalTitle" class="text-lg font-semibold mb-4 text-gray-800">إضافة حجم جديد</h3>
        <form id="sizeForm">
            <input type="hidden" id="sizeId" name="size_id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">اسم الحجم (عربي) *</label>
                <input type="text" id="name_ar" name="name_ar" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="مثال: صغير، متوسط، كبير">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">اسم الحجم (إنجليزي)</label>
                <input type="text" id="name_en" name="name_en"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Example: Small, Medium, Large">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">السعر *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="0.00">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">السعر الإضافي *</label>
                <input type="number" id="additional_price" name="additional_price" step="0.01" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="0.00">
                <p class="text-xs text-gray-500 mt-1">السعر الإضافي عن السعر الأساسي (يمكن أن يكون سالب)</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">ترتيب العرض</label>
                <input type="number" id="sort_order" name="sort_order" min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="0">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">الوصف</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="وصف الحجم (اختياري)"></textarea>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" id="is_default" name="is_default" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="mr-2 text-sm text-gray-700">جعل هذا الحجم افتراضي</span>
                </label>
            </div>

            <div class="flex justify-end space-x-2 space-x-reverse">
                <button type="button" onclick="closeSizeModal()" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    إلغاء
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    حفظ
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sizeModal = document.getElementById('sizeModal');
    const sizeForm = document.getElementById('sizeForm');
    const modalTitle = document.getElementById('modalTitle');

    // Open add size modal
    window.openAddSizeModal = function() {
        modalTitle.textContent = 'إضافة حجم جديد';
        sizeForm.reset();
        document.getElementById('sizeId').value = '';
        sizeModal.classList.remove('hidden');
    };

    // Close modal
    window.closeSizeModal = function() {
        sizeModal.classList.add('hidden');
    };

    // Edit size
    window.editSize = function(sizeId) {
        // Fetch size data and populate form
        fetch(`/meals/{{ $meal->id }}/sizes/${sizeId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const size = data.size;
                    modalTitle.textContent = 'تعديل الحجم';
                    document.getElementById('sizeId').value = size.id;
                    document.getElementById('name_ar').value = size.name_ar;
                    document.getElementById('name_en').value = size.name_en || '';
                    document.getElementById('price').value = size.price;
                    document.getElementById('additional_price').value = size.additional_price;
                    document.getElementById('sort_order').value = size.sort_order;
                    document.getElementById('description').value = size.description || '';
                    document.getElementById('is_default').checked = size.is_default;
                    sizeModal.classList.remove('hidden');
                }
            });
    };

    // Form submission
    sizeForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(sizeForm);
        const sizeId = document.getElementById('sizeId').value;
        const url = sizeId ? 
            `/meals/{{ $meal->id }}/sizes/${sizeId}` : 
            `/meals/{{ $meal->id }}/sizes`;
        const method = sizeId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء الحفظ');
        });
    });

    // Toggle status
    window.toggleSizeStatus = function(sizeId) {
        fetch(`/meals/{{ $meal->id }}/sizes/${sizeId}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    };

    // Delete size
    window.deleteSize = function(sizeId) {
        if (confirm('هل أنت متأكد من حذف هذا الحجم؟')) {
            fetch(`/meals/{{ $meal->id }}/sizes/${sizeId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    };

    // Close modal when clicking outside
    sizeModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeSizeModal();
        }
    });
});
</script>
@endsection
