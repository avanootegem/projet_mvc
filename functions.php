<?php 

function init_session() {
    $_SESSION['auth'] = NULL;
    $_SESSION['flash']['success'] = NULL;
    $_SESSION['flash']['danger'] = NULL;
}

function flash() {
    if($_SESSION['flash']['success']) {
        $flash = ["type" => "success", "message" => $_SESSION['flash']['success']];
        $_SESSION['flash']['success'] = NULL;
    } elseif($_SESSION['flash']['danger']) {
        $flash = ["type" => "danger", "message" => $_SESSION['flash']['danger']];
        $_SESSION['flash']['danger'] = NULL;
    } else {
        $flash = [];
    }

    return $flash;
}

function trueOrFalse ($var) {
    if($var) {
        return 1;
    } else {
        return 0;
    }
}

function str_random($lenght) {
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $lenght)), 0, $lenght);
}

function sendMail($mail, $id, $token) {
    $header="MIME-Version: 1.0\r\n";
    $header.="From: https://aurelienv.promo-45.codeur.online/projet_mvc/\r\n";
    $header.="Content-Type: text/html; charset=utf-8\r\n";
    $header.="Content-Transfer-Encoding: 8bit\r\n";

    $message='
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
        body {
            max-width: 600px;
        }
        </style>
        </head>
        <body>
            <span> Veuillez cliquez sur ce 
            <a href="https://aurelienv.promo-45.codeur.online/projet_mvc/resetPage?id='.$id.'&token='.$token.'">lien</a>
                    
        </body>
        </html>
        ';

        mail($mail, "Lien de récupération de votre mot de passe", $message, $header);
}