<?php
//Controller pour le livre d'or

/**
 * Page livre d'or
 */
function livre_livreor()
{
    $comments = get_all_comments();
    $users = get_all_users();

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $per_page = 2;
    $count = count_comments();
    $max_page = ceil($count / $per_page);

    $data = [
        'comments' => $comments,
        'users' => $users,
        'page' => $page,
        'max_page' => $max_page,
        'per_page' => $per_page
    ];
    load_view_with_layout('livre/livreor', $data);
}

/**
 * Page ajout de commentaires
 */
function livre_commentaire()
{
    if (is_post()) {
        $message = $_POST["commentaire"];
        create_comment($message, $_SESSION["user_id"]);
        echo "Votre message a été envoyé!";
        generate_neon_link("Voulez-vous le consulter?", 'livre/livreor');
    }
    load_view_with_layout('livre/commentaire');
}
