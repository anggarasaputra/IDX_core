<?php

namespace App\Http\Library;

use App\Models\Master\Floor;

trait TraitFloorPermission
{
    /**
     * List of permissions floor (lantai)
     *
     * @var array
     */
    private $permissions = [
        Floor::PERMISSION_GROUP_NAME . '.' . Floor::PERMISSION_CREATE,
        Floor::PERMISSION_GROUP_NAME . '.' . Floor::PERMISSION_VIEW,
        Floor::PERMISSION_GROUP_NAME . '.' . Floor::PERMISSION_EDIT,
        Floor::PERMISSION_GROUP_NAME . '.' . Floor::PERMISSION_DELETE
    ];

    /**
     * Check if user has any permission from modul floor
     *
     * @param mixed|void $user
     * @param string $permission_name
     * @param string $group_name
     * @return boolean
     */
    public function isAuthenticated($user, $permission_name, $group_name = Floor::PERMISSION_GROUP_NAME)
    {
        $permission = "{$group_name}.{$permission_name}";
        if (is_null($user) || !in_array($permission, $this->permissions) || !$user->can($permission)) {
            abort(403, "Sorry !! You are Unauthorized to {$permission_name} any {$group_name} !");
        }

        return true;
    }
}
