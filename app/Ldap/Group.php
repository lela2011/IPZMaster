<?php

namespace App\Ldap;

use LdapRecord\Models\OpenLDAP\Group as OpenLDAPGroup;

class Group extends OpenLDAPGroup
{
    public static array $objectClasses = ['groupOfNames'];
}
