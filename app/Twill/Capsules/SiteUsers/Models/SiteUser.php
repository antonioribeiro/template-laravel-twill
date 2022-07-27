<?php

namespace App\Twill\Capsules\SiteUsers\Models;

use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use A17\Twill\Models\Behaviors\HasRevisions;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $email_is_verified_string
 * @property string $created_at_string
 * @property string $updated_at_string
 */
class SiteUser extends Model
{
    use HasRevisions;

    protected $table = 'users';

    protected $fillable = ['published', 'name'];

    public function getEmailIsVerifiedStringAttribute(): string
    {
        return filled($this->email_verified_at) ? 'Yes' : '';
    }

    public function getHasPasswordAttribute(): string
    {
        return filled($this->password) ? 'Yes' : '';
    }

    public function getCreatedAtStringAttribute(): string
    {
        return (string) $this->created_at;
    }

    public function getUpdatedAtStringAttribute(): string
    {
        return (string) $this->updated_at;
    }

    public function scopeHasLogin(Builder $query): Builder
    {
        return $query->whereNotNull('password');
    }

    /**
     * Defines the one-to-many relationship for revisions.
     */
    public function revisions(): HasMany
    {
        return $this->hasMany($this->getRevisionModel(), 'site_user_id')->orderBy('created_at', 'desc');
    }
}
