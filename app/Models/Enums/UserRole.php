<?php

namespace A17\Twill\Models\Enums;

use MyCLabs\Enum\Enum;

class UserRole extends Enum
{
    const VIEWONLY = 'View only';
    const PUBLISHER = 'Publishers';
    const ADMIN = 'Admins';
    const WEB_USERS = 'Web User Admins';
}
