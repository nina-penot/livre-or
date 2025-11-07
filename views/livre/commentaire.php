<?php if (is_logged_in("user")) { ?>
    <div>Ecrire un commentaire :</div>
    <form class="float_column" method="post">
        <div>Votre commentaire :</div>
        <textarea class="comment_textarea" name="commentaire" id="commentaire" required></textarea>
        <?php generate_neon_button("ENVOYER") ?>
    </form>
<?php } else { ?>
    <div>Vous n'êtes pas connécté !</div>
    <?php generate_neon_link("Connectez-vous", "auth/connexion") ?>
<?php } ?>