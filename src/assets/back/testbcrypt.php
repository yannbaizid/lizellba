<?php
if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
    echo "CRYPT_BLOWFISH is enabled!";
}else {
echo "CRYPT_BLOWFISH is not available";
}

echo "<br> ";

$pwd="MaCouillesurTesGrandsMorts";
$hash= password_hash($pwd, PASSWORD_DEFAULT);
echo password_hash($pwd, PASSWORD_DEFAULT);
echo '<br>'.$hash;
echo '<br> password 1: rasmuslerdorf ';

if (password_verify('rasmuslerdorf', $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}


echo '<br> password 2: '.$pwd.' ';


if (password_verify($pwd, $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}

echo '<br>mkdir: test';
if (mkdir('../img/test/')) {

    echo 'sucess!';
}