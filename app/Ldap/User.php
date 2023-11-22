<?php

namespace App\Ldap;

use LdapRecord\Models\OpenLDAP\User as OpenLDAPUser;
//use LdapRecord\Models\OpenLDAP\Group;
use LdapRecord\Models\Relations\HasMany;

class User extends OpenLDAPUser
{
    // sets id-Key to 'uid' for querying
    protected string $guidKey = 'uid';

    // sets relation between user and group
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'member');
    }

    // returns id-key for querying
    public function getAuthIdentifier(): ?string
    {
        return $this->getFirstAttribute($this->guidKey);
    }
}
