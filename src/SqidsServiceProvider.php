<?php

declare(strict_types=1);

namespace RedExplosion\Sqids;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use RedExplosion\Sqids\Mixins\FindBySqidMixin;
use RedExplosion\Sqids\Mixins\FindBySqidOrFailMixin;
use RedExplosion\Sqids\Mixins\WhereSqidInMixin;
use RedExplosion\Sqids\Mixins\WhereSqidMixin;
use RedExplosion\Sqids\Mixins\WhereSqidNotInMixin;

class SqidsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(path: __DIR__ . '/../config/sqids.php', key: 'sqids');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                paths: [
                    __DIR__ . '/../config/sqids.php' => config_path('sqids.php'),
                ],
                groups: 'sqids-config',
            );
        }

        $this->bootBuilderMixins();
    }

    protected function bootBuilderMixins(): void
    {
        Builder::mixin(new FindBySqidMixin());
        Builder::mixin(new FindBySqidOrFailMixin());
        Builder::mixin(new WhereSqidInMixin());
        Builder::mixin(new WhereSqidMixin());
        Builder::mixin(new WhereSqidNotInMixin());
    }
}
