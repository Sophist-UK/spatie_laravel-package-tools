<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasProviderTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishableProviderTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesServiceProvider();
    }
}

uses(PackagePublishableProviderTest::class);

it("can publish a service provider", function () {
    $providerPath = app_path('Providers/PackageToolsServiceProvider.php');

    expect($providerPath)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-provider')
        ->assertSuccessful();

    expect($providerPath)->toBeFile();
})->group('provider');
