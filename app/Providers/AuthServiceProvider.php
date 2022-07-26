<?php

namespace App\Providers;

use A17\Twill\Models\User;
use App\Models\Enums\UserRoleType;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    const ALL_ROLES = [
        UserRoleType::VIEWONLY,
        UserRoleType::ADMIN,
        UserRoleType::PUBLISHER,
        UserRoleType::USERS,
        UserRoleType::WEB_USERS,
    ];

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerGates();
    }

    private function registerGates(): void
    {
        Gate::define(UserRoleType::WEB_USERS, function ($user) {
            return $this->authorize($user, fn(User $user) => $this->userHasRole($user, self::ALL_ROLES));
        });
    }

    protected function authorize(User $user, callable $callback): bool
    {
        if (!$user->isPublished()) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        return $callback($user);
    }

    protected function userHasRole(User $user, array $roles): bool
    {
        return in_array($user->role_value, $roles);
    }
}
