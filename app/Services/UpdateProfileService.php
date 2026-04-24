<?php

namespace App\Services;

class UpdateProfileService
{

    public static function removeFromVillgerOnChangeRole($old_role, $user, $profile_data)
    {
        if ($old_role == 'villager' && $profile_data['role'] != 'villager') {
            $user->villager()->delete();
            return true;
        }
        return false;
    }
    public static function checkUserNotVillager($old_role, $user, $profile_data)
    {
        if ($old_role != 'villager' && $profile_data['role'] == 'villager') {

            $user->villager()->create([
                'user_id' => $user->id,
                'cin' => $profile_data['cin'],
                'address' => $profile_data['address'],
                'subscription_status' => $profile_data['subscription_status'],
            ]);
            return true;
        }
        return false;
    }
    public function  updateProfile($profile_data, $user)
    {

        $old_role = $user->role;

        $user->update([
            'name' => $profile_data['name'],
            'email' => $profile_data['email'],
            'role' => $profile_data['role'],
            'phone' => $profile_data['phone'],
        ]);

        if (self::removeFromVillgerOnChangeRole($old_role, $user, $profile_data)) {
            return $user;
        }
        
        if (!self::checkUserNotVillager($old_role, $user, $profile_data)) {

            if ($profile_data['role'] == 'villager') {
                $user->villager()->update([

                    'cin' => $profile_data['cin'],
                    'address' => $profile_data['address'],
                    'subscription_status' => $profile_data['subscription_status'],
                ]);
            }
        }


        return $user;
    }
}
