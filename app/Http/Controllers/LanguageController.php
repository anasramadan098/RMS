<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language
     */
    public function switch($locale)
    {
        // Validate the locale
        $supportedLocales = config('app.supported_locales', ['en', 'ar']);

        if (!in_array($locale, $supportedLocales)) {
            return redirect()->back()->with('error', __('app.messages.error_validation'));
        }

        // Set the locale in session
        Session::put('locale', $locale);

        // Note: User preference storage can be added later if needed
        // by adding a 'locale' column to the users table

        // Set the application locale for immediate effect
        App::setLocale($locale);

        // Redirect back with success message
        return redirect()->back()->with('success', __('app.messages.success_updated', ['item' => __('app.language')]));
    }

    /**
     * Get available languages
     */
    public function getAvailableLanguages()
    {
        return [
            'en' => [
                'code' => 'en',
                'name' => 'English',
                'native_name' => 'English',
                'flag' => '🇺🇸',
                'direction' => 'ltr'
            ],
            'ar' => [
                'code' => 'ar',
                'name' => 'Arabic',
                'native_name' => 'العربية',
                'flag' => '🇪🇬',
                'direction' => 'rtl'
            ]
        ];
    }

    /**
     * Get current language information
     */
    public function getCurrentLanguage()
    {
        $currentLocale = App::getLocale();
        $languages = $this->getAvailableLanguages();

        return $languages[$currentLocale] ?? $languages['en'];
    }

    /**
     * API endpoint to get language information
     */
    public function apiLanguageInfo()
    {
        return response()->json([
            'current' => $this->getCurrentLanguage(),
            'available' => $this->getAvailableLanguages(),
            'supported_locales' => config('app.supported_locales', ['en', 'ar'])
        ]);
    }

    /**
     * Check if current language is RTL
     */
    public function isRtl()
    {
        $currentLang = $this->getCurrentLanguage();
        return $currentLang['direction'] === 'rtl';
    }
}
