<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the locale from various sources in order of priority
        $locale = $this->getLocale($request);
        
        // Validate the locale
        if (!in_array($locale, config('app.supported_locales', ['en', 'ar']))) {
            $locale = config('app.locale', 'en');
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        // Store the locale in session for persistence
        Session::put('locale', $locale);
        
        // Set the locale in the request for use in views
        $request->attributes->set('locale', $locale);
        
        return $next($request);
    }
    
    /**
     * Get the locale from various sources
     */
    private function getLocale(Request $request): string
    {
        // 1. Check if locale is passed as a parameter
        if ($request->has('locale')) {
            return $request->get('locale');
        }
        
        // 2. Check if locale is in the session
        if (Session::has('locale')) {
            return Session::get('locale');
        }
        
        // 3. Check if user is authenticated and has a preferred locale
        if (auth()->check() && auth()->user()->locale) {
            return auth()->user()->locale;
        }
        
        // 4. Check browser language preference
        $browserLocale = $this->getBrowserLocale($request);
        if ($browserLocale) {
            return $browserLocale;
        }
        
        // 5. Fall back to default locale
        return config('app.locale', 'en');
    }
    
    /**
     * Get locale from browser Accept-Language header
     */
    private function getBrowserLocale(Request $request): ?string
    {
        $acceptLanguage = $request->header('Accept-Language');
        
        if (!$acceptLanguage) {
            return null;
        }
        
        // Parse the Accept-Language header
        $languages = [];
        foreach (explode(',', $acceptLanguage) as $lang) {
            $parts = explode(';', trim($lang));
            $code = trim($parts[0]);
            $quality = 1.0;
            
            if (isset($parts[1]) && strpos($parts[1], 'q=') === 0) {
                $quality = (float) substr($parts[1], 2);
            }
            
            // Extract the primary language code
            $primaryLang = substr($code, 0, 2);
            $languages[$primaryLang] = $quality;
        }
        
        // Sort by quality
        arsort($languages);
        
        // Check if any of the preferred languages are supported
        $supportedLocales = config('app.supported_locales', ['en', 'ar']);
        foreach (array_keys($languages) as $lang) {
            if (in_array($lang, $supportedLocales)) {
                return $lang;
            }
        }
        
        return null;
    }
}
