<?php

namespace view;

use model\IListener;

class Register implements IListener
{
    private static $register = 'Register::Register';
    private static $name = 'Register::UserName';
    private static $password = 'Register::Password';
    private static $repeatPassword = 'Register::PasswordRepeat';
    private static $messageId = 'Register::Message';

    private $message;


    public function response()
    {
        return $this->generateRegisterFormHTML($this->message);
    }

    public function generateRegisterFormHTML($message)
    {
        return '
        <h2>Register new user</h2>
			<form method="post" >
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getUsername() . '" />
                    <br>
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
                    <br>
                    <label for="' . self::$repeatPassword . '">Repeat password :</label>
					<input type="password" id="' . self::$repeatPassword . '" name="' . self::$repeatPassword . '" />
                    <br>
					<input type="submit" name="' . self::$register . '" value="Register" />
				</fieldset>
			</form>
		';
    }

    private function getUsername()
    {
        if (isset($_POST[self::$name]))
            return trim($_POST[self::$name]);
    }

    private function getPassword()
    {
        if (isset($_POST[self::$password]))
            return trim($_POST[self::$password]);
    }

    private function getRepeatPassword()
    {
        if (isset($_POST[self::$repeatPassword]))
            return trim($_POST[self::$repeatPassword]);
    }

    /**
     * return new user if it gets pass validation
     * @return \model\User
     */
    public function getCredentials()
    {
        try {
            if ($this->getPassword() != $this->getRepeatPassword())
                throw new \PasswordDoesntMatchException();

            return new \model\User(
                $this->getUsername(),
                $this->getPassword());
        } catch (\NameAndPasswordLengthException $e) {
            $this->message = "Username has too few characters, at least 3 characters.<br>
                                Password has too few characters, at least 2 characters.";
        } catch (\UsernameLengthException $e) {
            $this->message = "Username has too few characters, at least 3 characters.";
        } catch (\PasswordLengthException $e) {
            $this->message = "Password has too few characters, at least 2 characters.";
        } catch (\PasswordDoesntMatchException $e) {
            $this->message = "Passwords do not match.";
        } catch (\UsernameInvalidCharactersException $e) {
            $this->message = "Username contains invalid characters.";
        }

        $_POST[self::$name] = strip_tags($_POST[self::$name]);

    }

    public function userWantsToRegister()
    {
        return isset($_POST[self::$register]);
    }

    public function redirectToHomePage()
    {
        header("Location: " . parse_ini_file('.env')['site']);
    }

    /**
     * Listen from IListener in Register
     * @param $listener
     */
    public function errorListener($listener)
    {
        $this->message = "User exists, pick another username.";
    }
}