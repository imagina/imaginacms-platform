<?php

namespace Modules\Iprofile\Services;

use Illuminate\Support\Facades\Hash;
use Modules\Iprofile\Entities\UserPasswordHistory;

class UserPasswordHistoryService
{
    /**
     * Review history depending on setting
     *
     * @param $data - $data['newPassword']
     */
    public function checkOldPasswords($user, $data)
    {
        $notAllowOldPassword = setting('iprofile::notAllowOldPassword', null, 1);

        if ($notAllowOldPassword) {
            $userHistoryPass = UserPasswordHistory::select('password')->where('user_id', $user->id)->get();

            if (count($userHistoryPass) > 0) {
                foreach ($userHistoryPass as $key => $history) {
                    if (Hash::check($data['newPassword'], $history->password)) {
                        throw new \Exception(trans('iprofile::frontend.messages.You already used this password'), 400);
                    }
                }
            }
        }

        return true;
    }
}
