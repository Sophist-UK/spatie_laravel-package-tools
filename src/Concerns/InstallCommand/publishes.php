<?php

namespace Spatie\LaravelPackageTools\Concerns\InstallCommand;

trait publishes
{
    protected array $publishes = [];

    public function publish(string ...$tag): self
    {
        $this->publishes = array_merge(
            $this->publishes,
            $tag
        );

        return $this;
    }

    public function publishConfigFile(): self
    {
        return $this->publish('config');
    }

    public function publishAssets(): self
    {
        return $this->publish('assets');
    }

    public function publishInertiaComponents(): self
    {
        return $this->publish('inertia-components');
    }

    public function publishMigrations(): self
    {
        return $this->publish('migrations');
    }

    protected function processPublishes(): void
    {
        foreach ($this->publishes as $tag) {
            $name = str_replace('-', ' ', $tag);
            $this->comment("Publishing {$name}...");

            $this->callSilently("vendor:publish", [
                '--tag' => "{$this->package->shortName()}-{$tag}",
            ]);
        }
    }
}
