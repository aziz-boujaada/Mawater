<?php

namespace App\Services;

class UpdateProfileService
{

    public static function removeFromVillgerOnChangeRole($old_role, $user, $profile)
    {
        if ($old_role == 'villager' && $profile['role'] != 'villager') {
            $user->villager()->delete();
            return true;
        }
        return false;
    }
    public static function checkUserNotVillager($old_role, $user, $profile)
    {
        if ($old_role != 'villager' && $profile['role'] == 'villager') {

            $user->villager()->create([
                'user_id' => $user->id,
                'cin' => $profile['cin'],
                'address' => $profile['address'],
                'subscription_status' => $profile['subscription_status'],
            ]);
            return true;
        }
        return false;
    }
    public function  updateProfile($profile, $user)
    {

        $old_role = $user->role;

        $user->update([
            'name' => $profile['name'],
            'email' => $profile['email'],
            'role' => $profile['role'],
            'phone' => $profile['phone'],
        ]);

        if (self::removeFromVillgerOnChangeRole($old_role, $user, $profile)) {
            return $user;
        }
        
        if (!self::checkUserNotVillager($old_role, $user, $profile)) {

            if ($profile['role'] == 'villager') {
                $user->villager()->update([

                    'cin' => $profile['cin'],
                    'address' => $profile['address'],
                    'subscription_status' => $profile['subscription_status'],
                ]);
            }
        }


        return $user;
    }
}
