<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait ProcessViews
{
    protected function bootViews()
    {
        if (! $this->package->hasViews) {
            return;
        }

        $namespace = $this->package->viewNamespace;
        $vendorViews = $this->package->basePath('/../resources/views');
        $appViews = base_path("resources/views/vendor/{$this->packageView($namespace)}");

        $this->loadViewsFrom($vendorViews, $this->package->viewNamespace());

        if ($this->app->runningInConsole()) {
            $this->publishes([$vendorViews => $appViews], "{$this->packageView($namespace)}-views");
        }
    }
}
