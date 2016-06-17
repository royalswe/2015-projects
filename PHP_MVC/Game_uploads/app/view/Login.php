<?php

namespace view;

class Login
{
    private static $login = 'view\Login::Login';
    private static $name = 'view\Login::UserName';
    private static $password = 'view\Login::Password';
    private static $messageId = 'view\Login::Message';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $cookieName = 'view\Login::CookieName';
    private static $cookiePassword = 'view\Login::CookiePassword';
    private static $logoutURLID = 'logout';

    private $message;
    public $loginSuccess = null;
    private $loginModel;
    private $cookieStorage;

    public function __construct(\model\Login $login)
    {
        $this->loginModel = $login;
        $this->cookieStorage = new CookieStorage();
    }

    public function userWantsToLogout()
    {
        $this->removeCookie();
        return isset($_GET[self::$logoutURLID]);
    }

    public function userWantsToLogin()
    {
        return isset($_POST[self::$login]);
    }

    public function getCredentials()
    {
        try {
            return new \model\User(
                $this->getUsername(),
                $this->getPassword());
        } catch (\Exception $e) {
            $this->message = "Obs!<br>";
        }

    }

    public function getUsername(){
        if(isset($_POST[self::$name])){
            return trim($_POST[self::$name]);
        }
    }

    public function getPassword(){
        if(isset($_POST[self::$password])){
            return trim($_POST[self::$password]);
        }
    }

    public function redirectToHomePage()
    {
        header("Location: " . parse_ini_file('.env')['site']);
    }

    private function rememberMe() {
        return isset($_POST[self::$keep]);
    }

    public function setCookies(){
        $this->cookieStorage->save(self::$cookiePassword, sha1('password'));
        $this->cookieStorage->save(self::$cookieName, $this->getUsername());
    }

    public function doCookieExist(){
        return $this->cookieStorage->load(self::$cookiePassword) && $this->cookieStorage->load(self::$cookieName);
    }

    public function removeCookie(){
        $this->cookieStorage->remove(self::$cookieName);
        $this->cookieStorage->remove(self::$cookiePassword);
    }

    public function response()
    {
        if($this->userWantsToLogin()){
            if (empty($this->getUsername())) {
                $this->message .= "Username is missing<br>";
            }
            if (empty($this->getPassword())) {
                $this->message .= "Password is missing<br>";
            }
            if ($this->loginSuccess == false) {
                $this->message .= "Wrong name or password";
            }
        }

        if ($this->loginModel->isLoggedIn()) {
            $response = $this->generateLogoutButtonHTML();
            if ($this->rememberMe()) {
                $this->setCookies();
            }
        } else {
            $response = $this->generateLoginFormHTML($this->message);
        }

        return $response;
    }

    private function generateLoginFormHTML($message)
    {
        return '
			<form method="post" >
			<h2>Login</h2>
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getUsername() . '" />
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<label for="' . self::$keep . '">Remember me  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
    }

    private function generateLogoutButtonHTML() {
        return '
            You are logged in <br>
            <a href="login?logout">Logout</a>
		';
    }
}