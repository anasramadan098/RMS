@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">إضافات الوجبة: {{ $meal->name_ar }}</h1>
                <p class="text-gray-600">إدارة الإضافات المتاحة للوجبة</p>
            </div>
            <div class="flex space-x-2 space-x-reverse">
                <a href="{{ route('meals.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    العودة للوجبات
                </a>
                <button onclick="openAddExtraModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    إضافة إضافة جديدة
                </button>
            </div>
        </div>

        <!-- Extras Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإضافة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">السعر</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الفئة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($extras as $extra)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $extra->name_ar }}</div>
                                @if($extra->name_en)
                                <div class="text-sm text-gray-500">{{ $extra->name_en }}</div>
                                @endif
                                @if($extra->description)
                                <div class="text-xs text-gray-400 mt-1">{{ $extra->description }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($extra->price, 2) }} ج.م
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($extra->category)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $extra->category }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($extra->is_active)
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
                                <button onclick="editExtra({{ $extra->id }})" class="text-blue-600 hover:text-blue-900">
                                    تعديل
                                </button>
                                <button onclick="toggleExtraStatus({{ $extra->id }})" class="text-yellow-600 hover:text-yellow-900">
                                    {{ $extra->is_active ? 'إلغاء تفعيل' : 'تفعيل' }}
                                </button>
                                <button onclick="deleteExtra({{ $extra->id }})" class="text-red-600 hover:text-red-900">
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            لا توجد إضافات مضافة لهذه الوجبة
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Extra Modal -->
<div id="extraModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
        <h3 id="modalTitle" class="text-lg font-semibold mb-4 text-gray-800">إضافة إضافة جديدة</h3>
        <form id="extraForm">
            <input type="hidden" id="extraId" name="extra_id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">اسم الإضافة (عربي) *</label>
                <input type="text" id="name_ar" name="name_ar" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="مثال: جبن إضافي، فطر، زيتون">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">اسم الإضافة (إنجليزي)</label>
                <input type="text" id="name_en" name="name_en"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Example: Extra Cheese, Mushrooms, Olives">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">السعر *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="0.00">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">الفئة</label>
                <select id="category" name="category"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">اختر الفئة</option>
                    <option value="جبن">جبن</option>
                    <option value="خضار">خضار</option>
                    <option value="لحوم">لحوم</option>
                    <option value="صوص">صوص</option>
                    <option value="توابل">توابل</option>
                    <option value="أخرى">أخرى</option>
                </select>
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
                    placeholder="وصف الإضافة (اختياري)"></textarea>
            </div>

            <div class="flex justify-end space-x-2 space-x-reverse">
                <button type="button" onclick="closeExtraModal()" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
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
    const extraModal = document.getElementById('extraModal');
    const extraForm = document.getElementById('extraForm');
    const modalTitle = document.getElementById('modalTitle');

    // Open add extra modal
    window.openAddExtraModal = function() {
        modalTitle.textContent = 'إضافة إضافة جديدة';
        extraForm.reset();
        document.getElementById('extraId').value = '';
        extraModal.classList.remove('hidden');
    };

    // Close modal
    window.closeExtraModal = function() {
        extraModal.classList.add('hidden');
    };

    // Edit extra
    window.editExtra = function(extraId) {
        // Fetch extra data and populate form
        fetch(`/meals/{{ $meal->id }}/extras/${extraId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const extra = data.extra;
                    modalTitle.textContent = 'تعديل الإضافة';
                    document.getElementById('extraId').value = extra.id;
                    document.getElementById('name_ar').value = extra.name_ar;
                    document.getElementById('name_en').value = extra.name_en || '';
                    document.getElementById('price').value = extra.price;
                    document.getElementById('category').value = extra.category || '';
                    document.getElementById('sort_order').value = extra.sort_order;
                    document.getElementById('description').value = extra.description || '';
                    extraModal.classList.remove('hidden');
                }
            });
    };

    // Form submission
    extraForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(extraForm);
        const extraId = document.getElementById('extraId').value;
        const url = extraId ? 
            `/meals/{{ $meal->id }}/extras/${extraId}` : 
            `/meals/{{ $meal->id }}/extras`;
        const method = extraId ? 'PUT' : 'POST';

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
    window.toggleExtraStatus = function(extraId) {
        fetch(`/meals/{{ $meal->id }}/extras/${extraId}/toggle`, {
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

    // Delete extra
    window.deleteExtra = function(extraId) {
        if (confirm('هل أنت متأكد من حذف هذه الإضافة؟')) {
            fetch(`/meals/{{ $meal->id }}/extras/${extraId}`, {
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
    extraModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeExtraModal();
        }
    });
});
</script>
@endsection
