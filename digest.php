<?php
$realm = 'Geschützter Bereich';

// Benutzer => Passwort
$benutzer = array('Max' => '1234', 'gast' => 'gast');


if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="' . $realm .
           '",qop="auth",nonce="' . uniqid() . '",opaque="' . md5($realm) .
           '"');

    die('Text, der gesendet wird, falls der Benutzer auf Abbrechen drückt');
}

// Analysieren der Variable PHP_AUTH_DIGEST
if (!($daten = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($benutzer[$daten['username']]))
    die('Falsche Zugangsdaten!');

// Erzeugen einer gültigen Antwort
$A1 = md5($daten['username'] . ':' . $realm . ':' .
          $benutzer[$daten['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'] . ':' . $daten['uri']);
$gueltige_antwort = md5($A1 . ':' . $daten['nonce'] . ':' . $daten['nc'] .
                        ':' . $daten['cnonce'] . ':' . $daten['qop'] . ':' .
                        $A2);

if ($daten['response'] != $gueltige_antwort)
    die('Falsche Zugangsdaten!');

// OK, gültige Benutzername & Passwort
echo 'Sie sind angemeldet als: ' . $daten['username'];
echo "Click to <a href='./logout.php' class='logout-button'>Logout</a>";

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