<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Article;
use App\Policies\ArticlePolicy;

use App\Models\Permission;
use App\Policies\PermissionPolicy;

use App\Models\Menu;
use App\Policies\MenusPolicy;

use App\Models\User;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Permission::class => PermissionPolicy::class,
        Menu::class => MenusPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('VIEW_ADMIN', function($user) {
            return $user->canDo('VIEW_ADMIN', false);
        });

        Gate::define('VIEW_ADMIN_ARTICLES', function($user) {
            return $user->canDo('VIEW_ADMIN_ARTICLES', false);
        });

        Gate::define('EDIT_USERS', function($user) {
            return $user->canDo('EDIT_USERS', false);
        });
        
        Gate::define('VIEM_ADMIN_MENU', function($user) {
            return $user->canDo('VIEM_ADMIN_MENU', false);
        });

        Gate::define('VIEM_ADMIN_USERS', function($user) {
            return $user->canDo('VIEM_ADMIN_USERS', false);
        });

        Gate::define('VIEM_ADMIN_PORTFOLIOS', function($user) {
            return $user->canDo('VIEM_ADMIN_PORTFOLIOS', false);
        });

        Gate::define('VIEM_ADMIN_PERMISSIONS', function($user) {
            return $user->canDo('VIEM_ADMIN_PERMISSIONS', false);
        });
    }
}
