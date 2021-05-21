<?php
session_start();
$realm = 'Geschützter Bereich';

// Benutzer => Passwort
$benutzer = array('Max' => '1234', 'gast' => 'gast');


if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="' . $realm .
           '",qop="auth",nonce="' . uniqid() . '",opaque="' . md5($realm) .
           '"');

    echo "Authentification cancelled. Click to <a href='./index.php' class='logout-button'>return to Login</a>";
}
else
{

    // Analysieren der Variable PHP_AUTH_DIGEST
    if (!($daten = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])))
    {
        $_SESSION["errorMessage"] = "Error with digest parse";
        header("Location: ./index.php");
    }
    else
    {   
        $remember = false;
        if (isset($_POST["rememberDig"])) 
        {
            $remember = true;
        }
        
        require_once (__DIR__ . "/Users.php");
        $member = new Users();
        $isLoggedIn = $member->processDigestAuth($daten, $realm, $remember);
        if (! $isLoggedIn) {
            $_SESSION["errorMessage"] = "Invalid Credentials";
        }
        header("Location: ./index.php");
        exit();
    }
}

// Funktion zum analysieren der HTTP-Auth-Header
function http_digest_parse($txt) {
    // gegen fehlende Daten schützen
    $noetige_teile = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1,
                           'username'=>1, 'uri'=>1, 'response'=>1);
    $daten = array();
    $schluessel = implode('|', array_keys($noetige_teile));

    preg_match_all('@(' . $schluessel . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@',
                   $txt, $treffer, PREG_SET_ORDER);

    foreach ($treffer as $t) {
        $daten[$t[1]] = $t[3] ? $t[3] : $t[4];
        unset($noetige_teile[$t[1]]);
    }
    return $noetige_teile ? false : $daten;
}
?>