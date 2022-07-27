<?php

namespace App\Twill\Capsules\SiteUsers\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Twill\Capsules\SiteUsers\Models\SiteUser;
use A17\Twill\Repositories\Behaviors\HandleRevisions;

class SiteUserRepository extends ModuleRepository
{
    use HandleRevisions;

    public function __construct(SiteUser $model)
    {
        $this->model = $model;
    }

    public function countLogins(): int
    {
        return $this->model
            ->newQuery()
            ->hasLogin()
            ->count();
    }

    public function filter($query, array $scopes = [])
    {
        $likeOperator = $this->getLikeOperator();

        if (filled($scopes['%email'] ?? null)) {
            foreach (['email', 'name'] as $field) {
                $query->orWhere("users.$field", $likeOperator, '%' . $scopes['%email'] . '%');
            }

            unset($scopes['%email']);
        }

        return parent::filter($query, $scopes);
    }
}
