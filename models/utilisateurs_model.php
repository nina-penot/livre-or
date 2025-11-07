<?php
//Fonctions pour utilisateurs (connexion, inscription...)

/**
 * Vérifie qu'un login ne contient que des lettres, chiffres, tirets
 */
function is_login_correct($name)
{
    if (preg_match("/^[a-zA-Z\p{L}\s\-_ ]+$/u", $name)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Créé un utilisateur, l'ajoute à la base de données
 */
function create_user($login, $pass)
{
    $hashed_password = hash_password($pass);
    $query = "INSERT INTO utilisateurs (utilisateurs.login, utilisateurs.password) 
    VALUES (?, ?)";
    return db_execute($query, [$login, $hashed_password]);
}

/**
 * Récupère un utilisateur via son login
 */
function get_user_by_login($login)
{
    $query = "SELECT * FROM utilisateurs WHERE utilisateurs.login = ?";
    return db_select_one($query, [$login]);
}

/**
 * Récupère un utilisateur via son id
 */
function get_user_by_id($user_id)
{
    $query = "SELECT * FROM utilisateurs WHERE utilisateurs.id = ?";
    return db_select_one($query, [$user_id]);
}

/**
 * Vérifie si le mot de passe est correcte
 */
function is_pass_correct($login, $pass)
{
    $query = "SELECT * FROM utilisateurs WHERE utilisateurs.login = ?";
    $info = db_select_one($query, [$login]);
    return password_verify($pass, $info["password"]);
}

/**
 * Vérifie que le login soit dans la base de données
 */
function does_login_exist($login)
{
    $query = "SELECT * FROM utilisateurs WHERE utilisateurs.login = ?";
    $info = db_select_one($query, [$login]);
    if (!empty($info)) {
        return true;
    } else {
        return false;
    }
}

function get_all_users()
{
    $query = "SELECT * FROM utilisateurs";
    return db_select($query);
}
