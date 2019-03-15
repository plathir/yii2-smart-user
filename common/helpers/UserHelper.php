<?php
namespace plathir\user\common\helpers;

use plathir\user\common\models\profile\UserProfile;
use plathir\user\common\models\account\User;
use plathir\user\backend\userAsset;
use yii\base\View;

class UserHelper {

    public function getProfileImage($id, $view = null) {
        $profile = UserProfile::find()
                ->where(['id' => $id])
                ->one();
        if ($view != null) {

            if ($profile) {
                if ($profile->profile_image != null) {
                    $profile->module->ProfileImagePathPreview;
                    return $profile->module->ProfileImagePathPreview . '/' . $profile->profile_image;
                } else {
                    $bundle = userAsset::register($view);
                    return $bundle->baseUrl . '/img/user_profile.png';
                }
            } else {
                $bundle = userAsset::register($view);
                return $bundle->baseUrl . '/img/user_profile.png';
            }
        } else {
            if ($profile) {
                if ($profile->profile_image != null) {
                    $profile->module->ProfileImagePathPreview;
                    return $profile->module->ProfileImagePathPreview . '/' . $profile->profile_image;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        }
    }

    /*
     * Get Profile Full Name 
     * if profile data is not exist returns username
     */

    public function getProfileFullName($id) {
        $profile = UserProfile::find()
                ->where(['id' => $id])
                ->one();

        if ($profile) {
            return $profile->first_name . '&nbsp;' . $profile->last_name;
        } else {
            $user = User::find()->where(['id' => $id])->one();
            if ($user) {
                return $user->username;
            }
        }
    }

    public function getLatestUsers($numOfUsers) {
        $users = User::find()
                ->where(['status' => User::STATUS_ACTIVE])
                ->orderBy(['created_at' => SORT_DESC])
                ->limit($numOfUsers)
                ->all();
        if ($users) {
            return $users;
        } else {
            return null;
        }
    }

    public function getAddUserImage($id, $view = null) {
        $bundle = userAsset::register($view);
        return $bundle->baseUrl . '/img/add_user.png';
    }

}
