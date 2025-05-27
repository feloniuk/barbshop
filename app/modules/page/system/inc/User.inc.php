<?php
/**
* USER
*/

class UserInc
{
    static public $model;

    static public function cookieAuth()
    {
        $userToken = User::getTokenCookie();
        $candidateToken = User::getTokenCookie('candidate'); // Additional login for profile(candidates)
        $portalToken = User::getTokenCookie('portal'); // Additional login for portal
        $clubToken = User::getTokenCookie('club'); // Additional login for members_growth_club
        $ldToken = User::getTokenCookie('ld'); // Additional login for learning-development

        Model::import('page');

        // USER login-verification
        User::set(null);
        User::setRole('guest');

        if ($userToken) {
            $session = PageModel::getSession($userToken);
            if ($session->scope == 'user' && $session->status == 1) {
                $user = PageModel::getUser($session->user_id);

                if ($user->id && $user->deleted == 'no') {
                    $userUpdate = [];
                    $user->last_time = $userUpdate['last_time'] = time();
                    PageModel::updateUserByID($user->id, $userUpdate);

                    User::set($user);
                    User::setRole($user->role);
                }
            }
        }


        // CANDIDATE login-verification
        User::set(null, 'candidate');
        User::setRole('guest', 'candidate');

        if ($candidateToken) {
            $session = PageModel::getSession($candidateToken);
            if ($session->scope == 'candidate' && $session->status == 1 && $session->ip == getIP()) {
                Model::import('profile');
                $user = ProfileModel::getCandidate($session->user_id);

                if ($user->id && $user->deleted == 'no') {
                    $userUpdate = [];
                    $user->last_time = $userUpdate['last_time'] = time();
                    ProfileModel::updateCandidateByID($user->id, $userUpdate);

                    User::set($user, 'candidate');
                    User::setRole($user->role, 'candidate');
                }
            }
        }


        // PORTAL login-verification
        User::set(null, 'portal');
        User::setRole('guest', 'portal');

        if ($portalToken) {
            $session = PageModel::getSession($userToken);
            if ($session->scope == 'portal' && $session->status == 1 && $session->ip == getIP()) {
                $user = PageModel::getUser($session->user_id);

                if ($user->id && $user->role == 'customer' && $user->deleted == 'no') {
                    $userUpdate = [];
                    $user->last_time = $userUpdate['last_time'] = time();
                    PageModel::updateUserByID($user->id, $userUpdate);

                    User::set($user, 'portal');
                    User::setRole($user->role, 'portal');
                }
            }
        }


        // LD login-verification
        User::set(null, 'ld');
        User::setRole('guest', 'ld');

        if ($ldToken) {
            $session = PageModel::getSession($userToken);
            if ($session->scope == 'ld' && $session->status == 1 && $session->ip == getIP()) {
                $user = PageModel::getUser($session->user_id);

                if ($user->id && $user->role == 'moder' && $user->deleted == 'no') {
                    $userUpdate = [];
                    $user->last_time = $userUpdate['last_time'] = time();
                    PageModel::updateUserByID($user->id, $userUpdate);

                    User::set($user, 'ld');
                    User::setRole($user->role, 'ld');
                }
            }
        }


        // Club Blog login-verification
        User::set(null, 'club');
        User::setRole('guest', 'club');

        if ($clubToken) {
            $session = PageModel::getSession($userToken);
            if ($session->scope == 'club' && $session->status == 1 && $session->ip == getIP()) {
                Model::import('members_growth_club');
                $user = Members_growth_clubModel::getClubUser($session->user_id);

                if ($user->id && $user->deleted == 'no') {
                    $userUpdate = [];
                    $user->last_time = $userUpdate['last_time'] = time();
                    Members_growth_clubModel::updateClubUserByID($user->id, $userUpdate);

                    User::set($user, 'club');
                    User::setRole($user->role, 'club');
                }
            }
        }


        // If user is guest
        if (User::checkRole('guest') && User::checkRole('guest', 'candidate')) {
            $gip = ip2long(getIP());
            Request::setParam('guest', PageModel::getGuestByIP($gip));

            if (Request::getParam('guest')->id) {
                $gData['count'] = "++";
                $gData['time'] = time();
                Model::update('guests', $gData, "`id` = '" . Request::getParam('guest')->id . "' LIMIT 1");
            } else {
                $gData['ip'] = $gip;
                $gData['browser'] = mb_substr(filter($_SERVER['HTTP_USER_AGENT']), 0, 255);
                $gData['referer'] = mb_substr(filter($_SERVER['HTTP_REFERER']), 0, 255);
                $gData['count'] = 1;
                $gData['time'] = time();
                Model::insert('guests', $gData);
            }
        }


        // Language
        Lang::setLanguage();
    }

}

/* End of file */