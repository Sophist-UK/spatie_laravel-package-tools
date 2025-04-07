<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackageHasConfigFileDefaultLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile();
    }
}

uses(PackageHasConfigFileDefaultLegacyTest::class);

it("registers only the default config file by legacy", function () {
    expect(config('package-tools.key'))->toBe('value');
})->group('config', 'legacy');

it("publishes only the default config file by legacy", function () {
    $publishedFiles = [
        config_path('package-tools.php'),
    ];
    $nonPublishedFiles = [
        config_path('alternative-config.php'),
        config_path('config-stub.php'),
    ];
    expect($publishedFiles)->each->not->toBeFileOrDirectory();
    expect($nonPublishedFiles)->each->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertSuccessful();

    expect($publishedFiles)->each->toBeFile();
    expect($nonPublishedFiles)->each->not->toBeFileOrDirectory();
})->group('config', 'legacy');
