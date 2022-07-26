<?php

namespace App\Twill\Capsules\SiteUsers\Models;

use App\Twill\Capsules\Base\Model;

class SiteUser extends Model
{
    protected $table = 'users';

    protected $fillable = ['published', 'name'];

    public function getEmailIsVerifiedStringAttribute(): string
    {
        return filled($this->email_verified_at) ? 'Yes' : '';
    }
}
