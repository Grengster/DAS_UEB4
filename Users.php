<?php
class Users
{
    function __construct()
    {
    }
    
    public function processLogin($username, $password, $remember) {
        $passwordHash = md5($password);
        
        $benutzer = array('Max' => '81dc9bdb52d04dc20036dbd8313ed055', 'gast' => 'd4061b1486fe2da19dd578e8d970f7eb');
        if($username === 'Max')
        {
            if(!($passwordHash === $benutzer['Max']))
            {
                return false;
            }
        }
        if($username === 'gast')
        {
            if(!($passwordHash === $benutzer['gast']))
            {
                return false;
            }
        }
        
        $_SESSION["userName"] = $username;

        if ($remember === true)
        {
            setcookie("username", $_SESSION["userName"], time() + 600);
        }

        return true;
    }
    
    public function processDigestAuth($daten, $realm, $remember) {
        $benutzer = array('Max' => '1234', 'gast' => 'gast');
        
        if(!empty($benutzer)) {
            $A1 = md5($daten['username'] . ':' . $realm . ':' .
                  $benutzer[$daten['username']]);
            $A2 = md5($_SERVER['REQUEST_METHOD'] . ':' . $daten['uri']);
            $gueltige_antwort = md5($A1 . ':' . $daten['nonce'] . ':' . $daten['nc'] .
                                    ':' . $daten['cnonce'] . ':' . $daten['qop'] . ':' .
                                    $A2);

            if ($daten['response'] != $gueltige_antwort)
            {
                return false;
            }

            // OK, gültige Benutzername & Passwort
            $_SESSION["userName"] = $daten['username'];
            
            if ($remember === true)
            {
                setcookie("username", $_SESSION["userName"], time() + 600);
            }
            
            return true;
        }
    }
}