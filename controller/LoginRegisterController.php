<?php
session_start();

class LoginRegisterController
{
    private $notification;
    private $userInformation;

    public function __construct()
    {
        // $this->getUserInformation();
    }

    private function getUserInformation()
    {
        //  $this->userInformation = UserModel::getUserById($_POST['id']);
    }

    public function showLoginRegister()
    {
        require_once('views/login_register/login_register.php');
    }

    /**
     * User and admin login
     */
    public function login()
    {
        if (!empty(filter_input(INPUT_POST, 'login_form'))) {
            $email = CommonUtility::filterInputPost("email");
            $pass = CommonUtility::filterInputPost("pass");

            $userInfo = UserModel::getUserByEmail($email);

            if ($userInfo == null) {
                $this->notification = CommonUtility::showNotification('This account does not exist.', 'danger');
                $this->showLoginRegister();
            } else {
                if (password_verify($pass, $userInfo['password'])) {
                    //  $user = CommonFunctions::userData($email);
                    UserModel::_setUserSession($email);
                    if ($userInfo['is_admin'] == 1) {
                        $path = '?controller=admin&action=showDashboard';
                        CommonUtility::redirect($path);
                    } else {
                        $path = '?controller=user&action=showHomePage';
                        CommonUtility::redirect($path);
                    }
                } else {
                    $this->notification = CommonUtility::showNotification('Your email and password do not match.', 'danger');
                    $this->showLoginRegister();
                }
            }
        }
    }

    /**
     * User and admin registration
     */
    public function register()
    {
        $email = CommonUtility::filterInputPost("email");

        $userInfo = UserModel::getUserByEmail($email);
        if ($userInfo != null) {
            $this->notification = CommonUtility::showNotification('This email address exists.', 'warning');

        } else if ($_POST["pass"] != $_POST["re_pass"]) {
            $this->notification = CommonUtility::showNotification('Password and repeat are not the same.', 'danger');
        } else {
            $pass = CommonUtility::test_input($_POST["pass"]);
            $data["pass"] = CommonUtility::hashPassword($pass);
            $data["email"] = CommonUtility::test_input($_POST["email"]);
            UserModel::addUser($data);
            $this->notification = CommonUtility::showNotification('You have been registered successfully.', 'success');
        }
        $this->showLoginRegister();
    }

    public function logOut()
    {
        UserModel::deleteCartInfo();
        session_destroy();
        $path = '?controller=login&action=showLoginRegister';
        CommonUtility::redirect($path);
    }

}
