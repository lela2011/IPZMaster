<?php

namespace App\Ldap;

use LdapRecord\Models\OpenLDAP\Group as OpenLDAPGroup;

class Group extends OpenLDAPGroup
{
    // overrides default OpenLDAPGroup to use 'groupOfNames' instead of 'groupOfUniqueNames' for querying
    public static array $objectClasses = ['groupOfNames'];
}
