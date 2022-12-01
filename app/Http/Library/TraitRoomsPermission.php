<?php

namespace App\Http\Library;

use App\Models\Rooms;

trait TraitRoomsPermission
{
    /**
     * List of permissions Rooms
     *
     * @var array
     */
    private $permissions = [
        Rooms::PERMISSION_GROUP_NAME . '.' . Rooms::PERMISSION_CREATE,
        Rooms::PERMISSION_GROUP_NAME . '.' . Rooms::PERMISSION_VIEW,
        Rooms::PERMISSION_GROUP_NAME . '.' . Rooms::PERMISSION_EDIT,
        Rooms::PERMISSION_GROUP_NAME . '.' . Rooms::PERMISSION_DELETE
    ];

    /**
     * Check if user has any permission from modul Rooms
     *
     * @param mixed|void $user
     * @param string $permission_name
     * @param string $group_name
     * @return boolean
     */
    public function isAuthenticated($user, $permission_name, $group_name = Rooms::PERMISSION_GROUP_NAME)
    {
        $permission = "{$group_name}.{$permission_name}";
        if (is_null($user) || !in_array($permission, $this->permissions) || !$user->can($permission)) {
            abort(403, "Sorry !! You are Unauthorized to {$permission_name} any {$group_name} !");
        }

        return true;
    }
}
