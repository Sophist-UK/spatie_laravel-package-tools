<?php


namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src;

use Closure;
use Exception;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ServiceProvider extends PackageServiceProvider
{
    public static ?Exception $thrownException = null;
    public static ?Closure $configurePackageUsing = null;

    public function configurePackage(Package $package): void
    {
        $configClosure = static::$configurePackageUsing ?? function (Package $package) {
        };

        ($configClosure)($package);
    }

    /**
     * Handle exceptions in PackageServiceProvider generated during register or boot
     *
     * The first exception is stored so that the Pest testcase can replay it during test initiation
     **/
    public function register(): self
    {
        static::$thrownException = null;

        try {
            parent::register();
        } catch (Exception $e) {
            static::$thrownException = $e;
        }

        return $this;
    }

    public function boot(): self
    {
        // Do not run boot if there was an exception in register
        if (static::$thrownException) {
            return $this;
        }

        try {
            parent::boot();
        } catch (Exception $e) {
            static::$thrownException = $e;
        }

        return $this;
    }

    public static function reset(): void
    {
        static::$thrownException = null;
        static::$publishes = [];
        static::$publishGroups = [];

        /* Following don't exist in Laravel 9.x or 10.x */
        if (version_compare(app()->version(), '11') >= 0) {
            static::$optimizeCommands = [];
            static::$optimizeClearCommands = [];
            static::$publishableMigrationPaths = [];
        }
    }
}
