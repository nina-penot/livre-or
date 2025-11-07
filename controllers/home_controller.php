<?php
// Contrôleur pour la page d'accueil

/**
 * Page d'accueil
 */
function home_index()
{
    $data = [
        'title' => "Accueil"
    ];

    load_view_with_layout('home/index', $data);
}

/**
 * Page profil
 */
function home_profil()
{
    if (!is_logged_in()) {
        redirect('auth/connexion');
    }
    //add database comments
    $comments = get_comment_by_userid($_SESSION["user_id"]);

    //Ajout de changements d'info
    if (is_post()) {
        $new_login = $_POST["login_change"];
        $new_pass = $_POST["pass_change"];
        $confirm = $_POST["pass_change_confirm"];
        //Met à jour le login utilisateur si il n'est pas le même et si correcte
        if ($new_login != $_SESSION["login"]) {
            if (is_login_correct($new_login)) {
                //update database
                $_SESSION["login"] = $new_login;
                echo "Login changé avec succès.";
            } else {
                echo "ERREUR: Login incorrect. Utilisez seulement des lettres, chiffres, 
                espaces ou tirets.";
            }
        }
        //Si nouveau mot de passe n'est pas vide, applique un changement.
        if (!empty($new_pass)) {
            if ($new_pass == $confirm) {
                //update pass in database
                echo "Mot de passe changé avec succès.";
            } else {
                echo "ERREUR: Confirmation de mot de passe ne correspond pas.";
            }
        }
    }

    $data = [
        'login' => $_SESSION["login"],
        'comments' => $comments
    ];

    load_view_with_layout('home/profil', $data);
}
