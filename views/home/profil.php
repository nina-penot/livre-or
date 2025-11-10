<div class="your_comments">Bienvenue sur votre compte, <?= $login ?> !</div>

<form class="connect_form glow float_column gap_small" method="post">
    <label for="login_change">Changez votre login</label>
    <input type="text" name="login_change" value="<?= $login ?>">
    <label for="pass_change">Changez votre mot de passe</label>
    <input type="text" name="pass_change" required>
    <label for="pass_change_confirm">Confirmez votre mot de passe</label>
    <input type="text" name="pass_change_confirm" required>
    <?php generate_neon_button("ENVOYER") ?>
</form>


<?php if (!empty($comments)) { ?>
    <div class="your_comments">Vos commentaires : </div>
    <div class="float_column" style="gap: 20px;">
        <?php foreach ($comments as $c) { ?>
            <div class="profile_com">
                <div><?= escape($c["commentaire"]); ?></div>
                <div style="font-size: 12px;"><?= escape($c["date"]); ?></div>
            </div>
        <?php } ?>
    </div>

    <!-- Système de pagination -->
    <?php
    if ($page < 1) {
        redirect('home/profil?page=1');
    }
    if ($page > $max_page) {
        redirect('home/profil?page=' . $max_page);
    }
    if ($max_page > 1) {
    ?>
        <div style="margin-top: 10px; text-align:center;">Page : <?= $page; ?> / <?= $max_page ?></div>

        <div class="page_grid">
            <?php
            //afficher pagination
            if ($page > 1) {
                generate_neon_link("<<", 'home/profil?page=' . $page - 1);
            } else { ?> <div></div> <?php } ?>

            <form style="justify-self: center;" method="get">
                <label for="page">Goto page</label>
                <input class="input_num" type="number" max="<?= $max_page ?>" min="1" name="page" value="<?= $page ?>">
                <?php generate_neon_button("GO") ?>
            </form>

            <?php if ($page < $max_page) {
                generate_neon_link(">>", 'home/profil?page=' . $page + 1);
            } else { ?> <div></div> <?php } ?>
        </div>

    <?php } ?>


<?php } else { ?>
    <div>Vous n'avez pas encore envoyé de commentaires.</div>
    <?php generate_neon_link("Envoyer un commentaire ?", 'livre/commentaire') ?>
<?php } ?>
<!-- foreach in comments, show message -->