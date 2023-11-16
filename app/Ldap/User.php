<?php

namespace App\Ldap;

use LdapRecord\Models\OpenLDAP\User as OpenLDAPUser;
//use LdapRecord\Models\OpenLDAP\Group;
use LdapRecord\Models\Relations\HasMany;

class User extends OpenLDAPUser
{
    protected string $guidKey = 'uid';
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'member');
    }
}
