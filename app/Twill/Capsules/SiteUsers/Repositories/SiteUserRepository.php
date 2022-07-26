<?php

namespace App\Twill\Capsules\SiteUsers\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Twill\Capsules\SiteUsers\Models\SiteUser;

class SiteUserRepository extends ModuleRepository
{
    public function __construct(SiteUser $model)
    {
        $this->model = $model;
    }
}
