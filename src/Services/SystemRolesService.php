<?php

namespace BabeRuka\SystemRoles\Services;
use BabeRuka\SystemRoles\Models\UserRoles;  

class SystemRolesService
{
    /**
     * Get a user profile by their ID.
     *
     * @param int $user_id
     * @return \BabeRuka\Models\UserRoles|null
     */
    public function getUserRole(int $user_id): ?UserRoles
    {
        return UserRoles::find($user_id);
    }

    public function updateUserRole(int $user_id, array $data): ?UserRoles
    {
        $UserRole = UserRoles::find($user_id);

        if ($UserRole) {
            $UserRole->fill($data);
            $UserRole->save();
            return $UserRole;
        }

        return null;
    }

    /**
     * Create a new user profile.
     *
     * @param array $data
     * @return \BabeRuka\Models\UserRoles
     */
    public function createUserRole(array $data): UserRoles
    {
        return UserRoles::create($data);
    }
 
 
}