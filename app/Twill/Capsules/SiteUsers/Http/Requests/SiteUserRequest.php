<?php

namespace App\Twill\Capsules\SiteUsers\Http\Requests;

use A17\Twill\Http\Requests\Admin\Request;

class SiteUserRequest extends Request
{
    public function rulesForCreate(): array
    {
        return [];
    }

    public function rulesForUpdate(): array
    {
        return [];
    }
}
