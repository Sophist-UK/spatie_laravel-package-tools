<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageViewsAltNamespacePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews('custom-namespace', '../resources/views_alt');
    }
}

uses(PackageViewsAltNamespacePathTest::class);

it("can load the views with a custom namespace", function () {
    $content = view('custom-namespace::test-alt')->render();

    expect($content)->toStartWith('This is a blade view');
})->group('views');

it("can publish the views with a custom namespace and path and tag", function () {
    $file = resource_path('views/vendor/custom-namespace/test-alt.blade.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=custom-namespace-views')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('views');

it("can publish the views with a custom namespace and path", function () {
    $file = resource_path('views/vendor/custom-namespace/test-alt.blade.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-views')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('views');
