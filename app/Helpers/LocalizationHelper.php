<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;

class LocalizationHelper
{
    /**
     * Get the current locale
     */
    public static function getCurrentLocale(): string
    {
        return App::getLocale();
    }
    
    /**
     * Check if current locale is RTL
     */
    public static function isRtl(): bool
    {
        $rtlLanguages = ['ar', 'he', 'fa', 'ur'];
        return in_array(self::getCurrentLocale(), $rtlLanguages);
    }
    
    /**
     * Get text direction for current locale
     */
    public static function getDirection(): string
    {
        return self::isRtl() ? 'rtl' : 'ltr';
    }
    
    /**
     * Get opposite direction for current locale
     */
    public static function getOppositeDirection(): string
    {
        return self::isRtl() ? 'ltr' : 'rtl';
    }
    
    /**
     * Get CSS class for text alignment based on locale
     */
    public static function getTextAlign(): string
    {
        return self::isRtl() ? 'text-end' : 'text-start';
    }
    
    /**
     * Get CSS class for float based on locale
     */
    public static function getFloat(): string
    {
        return self::isRtl() ? 'float-end' : 'float-start';
    }
    
    /**
     * Get margin/padding classes for RTL support
     */
    public static function getMarginStart(): string
    {
        return self::isRtl() ? 'me-' : 'ms-';
    }
    
    public static function getMarginEnd(): string
    {
        return self::isRtl() ? 'ms-' : 'me-';
    }
    
    public static function getPaddingStart(): string
    {
        return self::isRtl() ? 'pe-' : 'ps-';
    }
    
    public static function getPaddingEnd(): string
    {
        return self::isRtl() ? 'ps-' : 'pe-';
    }
    
    /**
     * Get available languages
     */
    public static function getAvailableLanguages(): array
    {
        return config('app.locale_config', [
            'en' => [
                'name' => 'English',
                'native_name' => 'English',
                'flag' => '🇺🇸',
                'direction' => 'ltr',
            ],
            'ar' => [
                'name' => 'Arabic',
                'native_name' => 'العربية',
                'flag' => '🇪🇬',
                'direction' => 'rtl',
            ],
        ]);
    }
    
    /**
     * Get current language information
     */
    public static function getCurrentLanguage(): array
    {
        $languages = self::getAvailableLanguages();
        $currentLocale = self::getCurrentLocale();
        
        return $languages[$currentLocale] ?? $languages['en'];
    }
    
    /**
     * Format date according to current locale
     */
    public static function formatDate($date, $format = null): string
    {
        if (!$date) {
            return '';
        }
        
        $currentLang = self::getCurrentLanguage();
        $format = $format ?? $currentLang['date_format'] ?? 'Y-m-d';
        
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }
        
        return $date->format($format);
    }
    
    /**
     * Format datetime according to current locale
     */
    public static function formatDateTime($datetime, $format = null): string
    {
        if (!$datetime) {
            return '';
        }
        
        $currentLang = self::getCurrentLanguage();
        $format = $format ?? $currentLang['datetime_format'] ?? 'Y-m-d H:i:s';
        
        if (is_string($datetime)) {
            $datetime = \Carbon\Carbon::parse($datetime);
        }
        
        return $datetime->format($format);
    }
    
    /**
     * Format number according to current locale
     */
    public static function formatNumber($number, $decimals = 2): string
    {
        // Handle null, empty, or non-numeric values
        if ($number === null || $number === '' || $number === false) {
            return '0';
        }

        // Convert to string first to handle edge cases
        $numberStr = (string) $number;

        if (!is_numeric($numberStr)) {
            return $numberStr !== '' ? $numberStr : '0';
        }

        // Convert to float for formatting
        $floatNumber = (float) $number;

        $locale = self::getCurrentLocale();

        try {
            // Arabic number formatting
            if ($locale === 'ar') {
                $formatted = number_format($floatNumber, $decimals, '.', ',');
                // Convert to Arabic-Indic numerals if needed
                // $formatted = self::convertToArabicNumerals($formatted);
                return $formatted;
            }

            // Default English formatting
            return number_format($floatNumber, $decimals, '.', ',');
        } catch (\Exception $e) {
            // Fallback in case of any formatting error
            return '0';
        }
    }
    
    /**
     * Format currency according to current locale
     */
    public static function formatCurrency($amount, $currency = 'EGP'): string
    {
        // Handle null, empty, or non-numeric amounts
        if ($amount === null || $amount === '' || $amount === false) {
            $amount = 0;
        }

        try {
            $formattedAmount = self::formatNumber($amount, 2);
            $locale = self::getCurrentLocale();

            if ($locale === 'ar') {
                return $formattedAmount . ' ' . self::getCurrencySymbol($currency);
            }

            return self::getCurrencySymbol($currency) . ' ' . $formattedAmount;
        } catch (\Exception $e) {
            // Fallback in case of any formatting error
            return self::getCurrencySymbol($currency) . ' 0.00';
        }
    }
    
    /**
     * Get currency symbol
     */
    public static function getCurrencySymbol($currency = 'EGP'): string
    {
        $symbols = [
            'EGP' => 'ج.م',
            'USD' => '$',
            'EUR' => '€',
            'SAR' => 'ر.س',
            'AED' => 'د.إ',
        ];
        
        return $symbols[$currency] ?? $currency;
    }
    
    /**
     * Convert numbers to Arabic-Indic numerals
     */
    public static function convertToArabicNumerals($text): string
    {
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        
        return str_replace($western, $arabic, $text);
    }
    
    /**
     * Get localized route
     */
    public static function localizedRoute($name, $parameters = []): string
    {
        return route($name, array_merge($parameters, ['locale' => self::getCurrentLocale()]));
    }
    
    /**
     * Get HTML attributes for current locale
     */
    public static function getHtmlAttributes(): array
    {
        return [
            'lang' => self::getCurrentLocale(),
            'dir' => self::getDirection(),
        ];
    }
    
    /**
     * Get body classes for current locale
     */
    public static function getBodyClasses(): string
    {
        $classes = [];
        $classes[] = 'locale-' . self::getCurrentLocale();
        $classes[] = 'dir-' . self::getDirection();
        
        if (self::isRtl()) {
            $classes[] = 'rtl';
        } else {
            $classes[] = 'ltr';
        }
        
        return implode(' ', $classes);
    }
}
