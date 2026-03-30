@php
    $currentLocale = app()->getLocale();
    $languages = \App\Helpers\LocalizationHelper::getAvailableLanguages();
    $currentLang = \App\Helpers\LocalizationHelper::getCurrentLanguage();
@endphp

<div class="dropdown language-switcher">
    <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center"
            type="button"
            id="languageDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            title="{{ __('app.language') }}">
        <span class="flag me-2">{{ $currentLang['flag'] }}</span>
        <span class="language-name d-none d-md-inline">{{ $currentLang['native_name'] }}</span>
    </button>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
        @foreach($languages as $locale => $language)
            <li>
                <a class="dropdown-item d-flex align-items-center {{ $currentLocale === $locale ? 'active' : '' }}"
                   href="/language/{{ $locale }}"
                   onclick="switchLanguage('{{ $locale }}'); return false;">
                    <span class="flag me-2">{{ $language['flag'] }}</span>
                    <span class="language-info">
                        <span class="language-native">{{ $language['native_name'] }}</span>
                        <small class="text-muted d-block">{{ $language['name'] }}</small>
                    </span>
                    @if($currentLocale === $locale)
                        <i class="fas fa-check ms-auto text-success"></i>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>

<style>
.language-switcher .dropdown-toggle {
    border: 1px solid #dee2e6;
    background: white;
    color: #495057;
    transition: all 0.3s ease;
}

.language-switcher .dropdown-toggle:hover {
    background: #f8f9fa;
    border-color: #007bff;
}

.language-switcher .dropdown-toggle:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.language-switcher .dropdown-menu {
    border: 1px solid #dee2e6;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 0.375rem;
    min-width: 200px;
}

.language-switcher .dropdown-item {
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.language-switcher .dropdown-item:hover {
    background-color: #f8f9fa;
}

.language-switcher .dropdown-item.active {
    background-color: #e3f2fd;
    color: #1976d2;
}

.language-switcher .flag {
    font-size: 1.2em;
    width: 24px;
    text-align: center;
}

.language-switcher .language-info {
    flex: 1;
}

.language-switcher .language-native {
    font-weight: 500;
}

/* RTL Support */
[dir="rtl"] .language-switcher .dropdown-menu {
    left: 0;
    right: auto;
}

[dir="rtl"] .language-switcher .flag {
    margin-left: 0.5rem;
    margin-right: 0;
}

[dir="rtl"] .language-switcher .ms-auto {
    margin-left: 0 !important;
    margin-right: auto !important;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .language-switcher .dropdown-menu {
        min-width: 150px;
    }

    .language-switcher .dropdown-item {
        padding: 0.5rem 0.75rem;
    }
}
</style>

<script>
function switchLanguage(locale) {
    // Show loading state
    const button = document.getElementById('languageDropdown');
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __("app.loading") }}';
    button.disabled = true;

    // Add smooth transition effect
    document.body.style.transition = 'opacity 0.3s ease';
    document.body.style.opacity = '0.7';

    // Navigate to language switch route
    window.location.href = "/language/" + locale;
}

// Handle page load
document.addEventListener('DOMContentLoaded', function() {
    // Simple fade in effect
    const languageSwitcher = document.querySelector('.language-switcher');
    if (languageSwitcher) {
        languageSwitcher.style.opacity = '1';
    }
});
</script>
