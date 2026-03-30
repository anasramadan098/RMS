<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\LocalizationHelper;

class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the LocalizationHelper as a singleton
        $this->app->singleton('localization', function () {
            return new LocalizationHelper();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register Blade directives for localization
        $this->registerBladeDirectives();
        
        // Share localization data with all views
        $this->shareViewData();
    }
    
    /**
     * Register custom Blade directives
     */
    private function registerBladeDirectives(): void
    {
        // @rtl directive
        Blade::directive('rtl', function () {
            return "<?php if(app()->getLocale() === 'ar'): ?>";
        });
        
        Blade::directive('endrtl', function () {
            return "<?php endif; ?>";
        });
        
        // @ltr directive
        Blade::directive('ltr', function () {
            return "<?php if(app()->getLocale() !== 'ar'): ?>";
        });
        
        Blade::directive('endltr', function () {
            return "<?php endif; ?>";
        });
        
        // @lang directive for specific language
        Blade::directive('lang', function ($expression) {
            return "<?php if(app()->getLocale() === {$expression}): ?>";
        });
        
        Blade::directive('endlang', function () {
            return "<?php endif; ?>";
        });
        
        // @direction directive
        Blade::directive('direction', function () {
            return "<?php echo \\App\\Helpers\\LocalizationHelper::getDirection(); ?>";
        });
        
        // @textAlign directive
        Blade::directive('textAlign', function () {
            return "<?php echo \\App\\Helpers\\LocalizationHelper::getTextAlign(); ?>";
        });
        
        // @marginStart directive
        Blade::directive('marginStart', function ($expression) {
            return "<?php echo \\App\\Helpers\\LocalizationHelper::getMarginStart() . {$expression}; ?>";
        });
        
        // @marginEnd directive
        Blade::directive('marginEnd', function ($expression) {
            return "<?php echo \\App\\Helpers\\LocalizationHelper::getMarginEnd() . {$expression}; ?>";
        });
        
        // @formatCurrency directive
        Blade::directive('formatCurrency', function ($expression) {
            return "<?php echo \\App\\Helpers\\LocalizationHelper::formatCurrency({$expression}); ?>";
        });
        
        // @formatNumber directive
        Blade::directive('formatNumber', function ($expression) {
            return "<?php echo \\App\\Helpers\\LocalizationHelper::formatNumber({$expression}); ?>";
        });
        
        // @formatDate directive
        Blade::directive('formatDate', function ($expression) {
            return "<?php echo \\App\\Helpers\\LocalizationHelper::formatDate({$expression}); ?>";
        });
    }
    
    /**
     * Share localization data with all views
     */
    private function shareViewData(): void
    {
        view()->composer('*', function ($view) {
            $view->with([
                'currentLocale' => app()->getLocale(),
                'isRtl' => LocalizationHelper::isRtl(),
                'direction' => LocalizationHelper::getDirection(),
                'textAlign' => LocalizationHelper::getTextAlign(),
                'availableLanguages' => LocalizationHelper::getAvailableLanguages(),
                'currentLanguage' => LocalizationHelper::getCurrentLanguage(),
            ]);
        });
    }
}
