<?php

namespace App\Providers;

use App\Interfaces\AssignmenRepositoryInterface;
use App\Interfaces\CourseRepositoryInterface;
use App\Interfaces\DiscussionRepositoryInterface;
use App\Interfaces\MaterialRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\AssignmentRepository;
use App\Repositories\CourseRepository;
use App\Repositories\DiscussionRepository;
use App\Repositories\MaterialRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(MaterialRepositoryInterface::class, MaterialRepository::class);
        $this->app->bind(AssignmenRepositoryInterface::class, AssignmentRepository::class);
        $this->app->bind(DiscussionRepositoryInterface::class, DiscussionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
