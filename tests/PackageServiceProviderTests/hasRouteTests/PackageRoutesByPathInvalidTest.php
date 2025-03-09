<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageRouteByPathInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutesByPath("InvalidPath");
    }
}

uses(PackageRouteByPathInvalidTest::class);

it("will throw an exception when the Config path is invalid")
    ->group('routes')
    ->throws(InvalidPackage::class, "hasRoutesByPath: Directory 'InvalidPath' does not exist in package laravel-package-tools");
