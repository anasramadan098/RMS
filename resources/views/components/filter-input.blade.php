@props([
    'field' => '',
    'type' => 'text',
    'label' => '',
    'placeholder' => '',
    'value' => '',
    'options' => [],
    'required' => false
])

<div class="mb-3">
    <label for="filter_{{ $field }}" class="form-label text-sm font-weight-bold text-dark">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    @switch($type)
        @case('select')
            <select 
                name="{{ $field }}" 
                id="filter_{{ $field }}" 
                class="form-control form-control-sm filter-input"
                {{ $required ? 'required' : '' }}
            >
                <option value="">{{ $placeholder }}</option>
                @foreach($options as $optionValue => $optionLabel)
                    <option 
                        value="{{ $optionValue }}" 
                        {{ $value == $optionValue ? 'selected' : '' }}
                    >
                        {{ $optionLabel }}
                    </option>
                @endforeach
            </select>
            @break

        @case('number')
            <input 
                type="number" 
                name="{{ $field }}" 
                id="filter_{{ $field }}" 
                class="form-control form-control-sm filter-input"
                placeholder="{{ $placeholder }}"
                value="{{ $value }}"
                step="any"
                {{ $required ? 'required' : '' }}
            >
            @break

        @case('date')
            <input 
                type="date" 
                name="{{ $field }}" 
                id="filter_{{ $field }}" 
                class="form-control form-control-sm filter-input"
                value="{{ $value }}"
                {{ $required ? 'required' : '' }}
            >
            @break

        @case('email')
            <input 
                type="email" 
                name="{{ $field }}" 
                id="filter_{{ $field }}" 
                class="form-control form-control-sm filter-input"
                placeholder="{{ $placeholder }}"
                value="{{ $value }}"
                {{ $required ? 'required' : '' }}
            >
            @break

        @case('tel')
            <input 
                type="tel" 
                name="{{ $field }}" 
                id="filter_{{ $field }}" 
                class="form-control form-control-sm filter-input"
                placeholder="{{ $placeholder }}"
                value="{{ $value }}"
                {{ $required ? 'required' : '' }}
            >
            @break

        @default
            <input 
                type="text" 
                name="{{ $field }}" 
                id="filter_{{ $field }}" 
                class="form-control form-control-sm filter-input"
                placeholder="{{ $placeholder }}"
                value="{{ $value }}"
                {{ $required ? 'required' : '' }}
            >
    @endswitch
</div>
