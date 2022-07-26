<?php

namespace App\Models\Enums;

use MyCLabs\Enum\Enum;

class UserRoleType extends Enum
{
    const VIEWONLY = 'view-only';
    const PUBLISHER = 'publisher';
    const ADMIN = 'admin';
    const USERS = 'manage-users';
    const WEB_USERS = 'manage-web-users';
}
