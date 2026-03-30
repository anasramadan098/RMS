<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isOwner();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $employeeId = $this->route('employee')->id;

        return [
            'name' => 'required|string|max:255|min:2',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($employeeId)
            ],
            'phone' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'default_salary' => 'required|numeric|min:0|max:999999.99',
            'hourly_rate' => 'required|numeric|min:0|max:9999.99',
            'working_hours_per_day' => 'required|integer|min:1|max:24',
            'is_active' => 'boolean',
            'notes' => 'nullable|string|max:1000',
            'attachments' => 'nullable|array|max:10',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,webp|max:5120', // 5MB max per file
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'اسم الموظف مطلوب',
            'name.min' => 'اسم الموظف يجب أن يكون على الأقل حرفين',
            'name.max' => 'اسم الموظف لا يمكن أن يتجاوز 255 حرف',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'phone.regex' => 'رقم الهاتف غير صحيح',
            'default_salary.required' => 'الراتب الافتراضي مطلوب',
            'default_salary.numeric' => 'الراتب الافتراضي يجب أن يكون رقم',
            'default_salary.min' => 'الراتب الافتراضي لا يمكن أن يكون سالب',
            'default_salary.max' => 'الراتب الافتراضي كبير جداً',
            'hourly_rate.required' => 'قيمة الساعة مطلوبة',
            'hourly_rate.numeric' => 'قيمة الساعة يجب أن تكون رقم',
            'hourly_rate.min' => 'قيمة الساعة لا يمكن أن تكون سالبة',
            'hourly_rate.max' => 'قيمة الساعة كبيرة جداً',
            'working_hours_per_day.required' => 'ساعات العمل اليومية مطلوبة',
            'working_hours_per_day.integer' => 'ساعات العمل اليومية يجب أن تكون رقم صحيح',
            'working_hours_per_day.min' => 'ساعات العمل اليومية يجب أن تكون على الأقل ساعة واحدة',
            'working_hours_per_day.max' => 'ساعات العمل اليومية لا يمكن أن تتجاوز 24 ساعة',
            'notes.max' => 'الملاحظات لا يمكن أن تتجاوز 1000 حرف',
            'attachments.array' => 'الملحقات يجب أن تكون مجموعة من الملفات',
            'attachments.max' => 'لا يمكن رفع أكثر من 10 ملفات',
            'attachments.*.file' => 'كل ملحق يجب أن يكون ملف صحيح',
            'attachments.*.mimes' => 'نوع الملف غير مدعوم. الأنواع المدعومة: JPG, JPEG, PNG, PDF, WEBP',
            'attachments.*.max' => 'حجم الملف لا يمكن أن يتجاوز 5 ميجابايت',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'اسم الموظف',
            'email' => 'البريد الإلكتروني',
            'phone' => 'رقم الهاتف',
            'default_salary' => 'الراتب الافتراضي',
            'hourly_rate' => 'قيمة الساعة',
            'working_hours_per_day' => 'ساعات العمل اليومية',
            'is_active' => 'حالة الموظف',
            'notes' => 'الملاحظات',
            'attachments' => 'الملحقات',
        ];
    }
}
