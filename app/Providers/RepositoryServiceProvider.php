<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\UserRepositoryInterface;
use App\Repository\Eloquent\AlbumRepository;
use App\Repository\AlbumRepositoryInterface;
use App\Repository\EloquentRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AlbumRepositoryInterface::class, AlbumRepository::class);
    }

    public function boot()
    {
        //
    }
}
