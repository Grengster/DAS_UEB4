<?php
class Users
{

    private $dbConn;

    private $ds;

    function __construct()
    {
        require_once "DataSource.php";
        $this->ds = new DataSource();
    }

    function getMemberById($memberId)
    {
        $query = "select * FROM registered_users WHERE id = ?";
        $paramType = "i";
        $paramArray = array($memberId);
        $memberResult = $this->ds->select($query, $paramType, $paramArray);
        
        return $memberResult;
    }
    
    public function processLogin($username, $password) {
        $passwordHash = md5($password);
        $query = "select * FROM registered_users WHERE user_name = ? AND password = ?";
        $paramType = "ss";
        $paramArray = array($username, $passwordHash);
        $memberResult = $this->ds->select($query, $paramType, $paramArray);
        if(!empty($memberResult)) {
            $_SESSION["userId"] = $memberResult[0]["id"];
            $_SESSION["userName"] = $memberResult[0]["user_name"];
            return true;
        }
    }
    
    public function processDigestAuth($daten, $realm) {
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
            
            $query = "select id FROM registered_users WHERE user_name = ?";
            $paramType = "s";
            $paramArray = array($daten['username']);
            $memberResult = $this->ds->select($query, $paramType, $paramArray);

            // OK, gültige Benutzername & Passwort
            $_SESSION["userId"] = $memberResult[0]["id"];
            $_SESSION["userName"] = $daten['username'];
            return true;
        }
    }
}