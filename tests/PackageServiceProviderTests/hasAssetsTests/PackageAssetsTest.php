<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasAssetsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageAssetsTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasAssets();
    }
}

uses(PackageAssetsTest::class);

it('can publish the assets', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-assets')
        ->assertExitCode(0);

    $this->assertFileExists(public_path('vendor/package-tools/dummy.js'));
});
