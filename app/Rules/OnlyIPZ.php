<?php

namespace App\Rules;

use Illuminate\Database\Eloquent\Model as Eloquent;
use LdapRecord\Laravel\Auth\Rule;
use App\Ldap\Group;
use LdapRecord\Models\Model as LdapRecord;

class OnlyIPZ implements Rule
{
    public function passes(LdapRecord $user, Eloquent $model = null): bool
    {
        // retrieves '.G.IPZ' and '.G.PW' groups from LDAP-Server
        $ipzMembers = Group::find('cn=.G.IPZ,ou=Groups,ou=WebPass,ou=id,dc=uzh,dc=ch');
        $pwMembers = Group::find('cn=.G.PW,ou=Groups,ou=WebPass,ou=id,dc=uzh,dc=ch');

        // checks whether user that is authenticating is member of the groups
        $inIPZ = $user->groups()->recursive()->exists($ipzMembers);
        $inPW = $user->groups()->recursive()->exists($pwMembers);

        // allows authentication when user is member of at least one group
        return $inIPZ || $inPW;
    }
}
