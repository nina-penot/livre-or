<div>Livre d'or</div>

<div>Vous souhaitez aussi laisser un message ?</div>
<?php generate_neon_link("Postez un message.", 'livre/commentaire') ?>

<div class="message_all">

    <?php
    $my_comments = get_limited_comments($per_page, $page);
    foreach ($my_comments as $num => $c) {
        if ($num % 2 == 0) {
            $direction1 = "go_right";
            $direction2 = "go_left";
        } else {
            $direction2 = "go_right";
            $direction1 = "go_left";
        } ?>
        <div class="message_main <?= $direction1 ?>">
            <div class="message_profile <?= $direction2 ?> float_left">
                <div class="message_profile_img">👤</div>
                <div class="message_profile_txt"><?= escape(get_comment_author($c["id"])) ?></div>
            </div>

            <div class="message_text_block">
                <div class="message_text">
                    <?= escape($c['commentaire']) ?>
                </div>
                <div class="message_text">
                    <?= escape($c['date']) ?>
                </div>
            </div>

        </div>
    <?php } ?>

    <?php
    if ($page < 1) {
        redirect('livre/livreor?page=1');
    }
    if ($page > $max_page) {
        redirect('livre/livreor?page=' . $max_page);
    }
    if ($max_page > 1) {
        //afficher pagination
        if ($page < $max_page) {
            generate_neon_link("Next page", 'livre/livreor?page=' . $page + 1);
        } else if ($page > 1) {
            generate_neon_link("Prev page", 'livre/livreor?page=' . $page - 1);
        }
    ?>
        <div>Page : <?= $page; ?>/<?= $max_page ?></div>
        <form method="get">
            <label for="page">Goto page</label>
            <input type="number" max="<?= $max_page ?>" min="1" name="page" value="<?= $page ?>">
            <?php generate_neon_button("GO") ?>
        </form>
    <?php } ?>


    <!-- temporary examples -->
    <!-- <div class="message_main go_right">
        <div class="message_profile go_left float_left">
            <div class="message_profile_img">👤</div>
            <div class="message_profile_txt">GogoGaga</div>
        </div>

        <div class="message_text_block">
            <div class="message_text">
                hosqgfgdfgkj dsulgsqgglq dsgdslg dsgulglggdudgdqg iflq
                fdgukgkfdug fgdugfdu fgdkqgfd gfgdgjdk
                gfdkgkd gfdqgdf fgdqgfd fgdqgdkgfdkq
            </div>
        </div>
    </div>

    <div class="message_main go_left">
        <div class="message_profile go_right float_left">
            <div class="message_profile_img">👤</div>
            <div class="message_profile_txt">Bidule_du_666</div>
        </div>

        <div class="message_text_block">
            <div class="message_text">
                hosqgfgdfgkj dsulgsqgglq dsgdslg dsgulglggdudgdqg iflq
                fdgukgkfdug fgdugfdu fgdkqgfd gfgdgjdk
                gfdkgkd gfdqgdf fgdqgfd fgdqgdkgfdkq
            </div>
        </div>
    </div>
</div> -->