<?php

namespace App\Http\Library;

use App\Models\Order\OrderRooms;

trait TraitOrderRoomsPermission
{
    /**
     * List of permissions Order Rooms
     *
     * @var array
     */
    private $permissions = [
        OrderRooms::PERMISSION_GROUP_NAME . '.' . OrderRooms::PERMISSION_APPROVE,
        OrderRooms::PERMISSION_GROUP_NAME . '.' . OrderRooms::PERMISSION_REJECT
    ];

    /**
     * Check if user has any permission from modul Order Rooms
     *
     * @param mixed|void $user
     * @param string $permission_name
     * @param string $group_name
     * @return boolean
     */
    public function isAuthenticated($user, $permission_name, $group_name = OrderRooms::PERMISSION_GROUP_NAME)
    {
        $permission = "{$group_name}.{$permission_name}";
        if (is_null($user) || !in_array($permission, $this->permissions) || !$user->can($permission)) {
            abort(403, "Sorry !! You are Unauthorized to {$permission_name} any {$group_name} !");
        }

        return true;
    }
}
