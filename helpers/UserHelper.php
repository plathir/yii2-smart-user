<?php

namespace plathir\user\helpers;

use plathir\user\models\profile\UserProfile;
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
                    $bundle = \plathir\user\userAsset::register($view);
                    return $bundle->baseUrl . '/img/user_profile.png';
                }
            } else {
                $bundle = \plathir\user\userAsset::register($view);
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

    public function getProfileFullName($id) {
        $profile = UserProfile::find()
                ->where(['id' => $id])
                ->one();

        if ($profile) {
            return $profile->first_name. '&nbsp;'. $profile->last_name;
        }
    }

}
