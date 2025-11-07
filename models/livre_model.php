<?php
//Fonctions pour le livre (commentaires...)

/**
 * Récupère tous les commentaires
 */
function get_all_comments()
{
    $query = "SELECT * FROM commentaires";
    return db_select($query);
}

/**
 * Récupère un nombre limité de commentaires
 */
function get_limited_comments($amount, $page)
{
    $offset = ($page - 1) * $amount;
    $query = "SELECT * FROM commentaires LIMIT ? OFFSET ?";
    return db_select($query, [$amount, $offset]);
}

/**
 * Récupère les commentaires d'un utilisateur
 */
function get_comment_by_userid($user_id)
{
    $query = "SELECT * FROM commentaires WHERE commentaires.id_utilisateur = ?";
    return db_select($query, [$user_id]);
}

/**
 * Récupère l'autheur d'un commentaire
 */
function get_comment_author($comment_id)
{
    $query = "SELECT commentaires.id_utilisateur FROM commentaires 
    WHERE commentaires.id = ?";
    $user_id = db_select_one($query, [$comment_id]);

    $getuser = "SELECT utilisateurs.login FROM utilisateurs WHERE utilisateurs.id = ?";
    $user = db_select_one($getuser, [$user_id["id_utilisateur"]]);
    return $user['login'];
}

/**
 * Enregistre un commentaire dans la base de données commentaires
 */
function create_comment($comment, $user_id)
{
    $query = "INSERT INTO commentaires (commentaire, id_utilisateur, date) 
    VALUES (?, ?, NOW())";
    return db_execute($query, [$comment, $user_id]);
}

/**
 * Compte le total de commentaires
 */
function count_comments()
{
    $query = "SELECT COUNT(*) AS 'count' FROM commentaires";
    $count = db_select_one($query);
    return $count['count'];
}
