@extends('layouts.app')@section('page_name', __('categories.edit_category'))
@section('content')<div class="container mt-4 {{ $textAlign }}">
    <div class="row justify-content-center">        <div class="col-md-8">
            <div class="card">                <div class="card-header {{ $textAlign }}">{{ __('categories.edit_category') }}</div>
                <div class="card-body">
                    <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf                        @method('PUT')
                        <!-- أسماء الفئة باللغتين -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name_ar" class="form-label">{{ __('categories.category_name_ar') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name_ar" class="form-control" id="name_ar" value="{{ old('name_ar', $category->name_ar) }}" required placeholder="أدخل اسم الفئة بالعربية">
                                    @error('name_ar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name_en" class="form-label">{{ __('categories.category_name_en') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name_en" class="form-control" id="name_en" value="{{ old('name_en', $category->name_en) }}" required placeholder="Enter category name in English">
                                    @error('name_en')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- وصف الفئة باللغتين -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description_ar" class="form-label">{{ __('categories.description_ar') }}</label>
                                    <textarea name="description_ar" class="form-control" id="description_ar" rows="3" placeholder="أدخل وصف الفئة بالعربية">{{ old('description_ar', $category->description_ar) }}</textarea>
                                    @error('description_ar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description_en" class="form-label">{{ __('categories.description_en') }}</label>
                                    <textarea name="description_en" class="form-control" id="description_en" rows="3" placeholder="Enter category description in English">{{ old('description_en', $category->description_en) }}</textarea>
                                    @error('description_en')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">{{ __('categories.type') }}</label>
                                    <select name="type" class="form-select" id="type">
                                        <option value="food" {{ old('type', $category->type) == 'food' ? 'selected' : '' }}>{{ __('categories.types.food') }}</option>
                                        <option value="drink" {{ old('type', $category->type) == 'drink' ? 'selected' : '' }}>{{ __('categories.types.drink') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">{{ __('categories.display_order') }}</label>
                                    <input type="number" name="order" class="form-control" id="order" value="{{ old('order', $category->order ?? 0) }}" min="0" placeholder="0">
                                    @error('order')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('categories.category_image') }}</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">                            <button type="submit" class="btn btn-primary">{{ __('app.update') }}</button>
                            <a href="{{ route('category.index') }}" class="btn btn-secondary">{{ __('app.cancel') }}</a>                        </div>
                    </form>                </div>
            </div>        </div>
    </div>
</div>
@endsection




















