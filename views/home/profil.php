<div>Bonjour, <?= $login ?> !</div>

<form method="post">
    <label for="login_change">Changez votre login</label>
    <input type="text" name="login_change" value="<?= $login ?>">
    <label for="pass_change">Changez votre mot de passe</label>
    <input type="text" name="pass_change" required>
    <label for="pass_change_confirm">Confirmez votre mot de passe</label>
    <input type="text" name="pass_change_confirm" required>
    <?php generate_neon_button("ENVOYER") ?>
</form>

<?php if (!empty($comments)) { ?>
    <div>Vos commentaires : </div>
    <?php foreach ($comments as $c) { ?>
        <div><?= $c["commentaire"]; ?></div>
    <?php } ?>
<?php } else { ?>
    <div>Vous n'avez pas encore envoyé de commentaires.</div>
    <?php generate_neon_link("Envoyer un commentaire ?", 'livre/commentaire') ?>
<?php } ?>
<!-- foreach in comments, show message -->