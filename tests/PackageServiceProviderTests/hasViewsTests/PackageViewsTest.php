<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageViewsTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews();
    }
}

uses(PackageViewsTest::class);

it("can load default views", function () {
    $content = view('package-tools::test')->render();

    expect($content)->toStartWith('This is a blade view');
})->group('views');

it("can publish default views", function () {
    $file = resource_path('views/vendor/package-tools/test.blade.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-views')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('views');
