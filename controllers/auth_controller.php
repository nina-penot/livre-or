<?php
//Controller pour les pages auth

function auth_connexion()
{
    //Vérifie si le formulaire de connexion a été rempli
    if (is_post()) {
        $login = post("login");
        $pass = post("pass");
        if (does_login_exist($login)) {
            $user_info = get_user_by_login($login);
            if (is_pass_correct($login, $pass)) {
                //Connexion ok
                $_SESSION["user_id"] = $user_info["id"];
                $_SESSION["login"] = $user_info["login"];
                redirect('home/profil');
            } else {
                echo "ERREUR: Mot de passe incorrecte.";
            }
        } else {
            echo "ERREUR: Login inconnu. Veuillez vous inscrire.";
        }
    }
    load_view_with_layout('auth/connexion');
}

function auth_inscription()
{
    //Vérifie si le formulaire d'inscription a été rempli
    if (is_post()) {
        $login = post("login");
        $pass = post("pass");
        $confirm = post("confirm");

        if ($pass != $confirm) {
            echo "ERREUR: Les mots de passes ne correspondent pas.";
        }
        if (!is_login_correct($login)) {
            echo "ERREUR: Le login contient des caractère non authorisés. Veuillez n'utiliser que
            des lettres, chiffres, espaces ou tirets.";
        }
        if ($pass == $confirm and is_login_correct($login)) {
            if (does_login_exist($login)) {
                echo "ERREUR: Ce login existe déjà.";
            } else {
                //Inscription ok
                create_user($login, $pass);
                redirect('auth/connexion');
            }
        }
    }

    //Charge la page avec le layout par défaut
    load_view_with_layout('auth/inscription');
}

function auth_logout()
{
    log_out();
}
