<div>Livre d'or</div>

<div>Vous souhaitez aussi laisser un message ?</div>
<?php generate_neon_link("Postez un message.", 'livre/commentaire') ?>

<!-- <div style="height: 120px; object-fit: contain;" class="pos_relative">
    <img style="height: inherit;" class="svg_color_blue" src="../../public/assets/images/blob_3.svg" alt="splosh">
    <img style="height: inherit;" class="svg_color_pink pos_absolute paint_coords" src="../../public/assets/images/blob_3.svg" alt="splosh">
    <div style="gap: 10px;" class="pos_absolute paint_txt_coords float_left">
        <div>👤</div>
        <div>TEXTZZZZZZZZZZZZZZZZ</div>
    </div>
</div> -->

<div class="message_all">

    <?php
    $colors = ['pink', 'blue', 'yellow'];
    $my_comments = get_limited_comments($per_page, $page);
    foreach ($my_comments as $num => $c) {
        $num1 = mt_rand(0, count($colors) - 1);
        $num2 = mt_rand(0, count($colors) - 1);
        $blob_num = mt_rand(1, 3);
        while ($num2 == $num1) {
            $num2 = mt_rand(0, count($colors) - 1);
        }
        $rand_color1 = $colors[$num1];
        $rand_color2 = $colors[$num2];
        if ($num % 2 == 0) {
            $direction1 = "go_right";
            $direction2 = "go_left";
        } else {
            $direction2 = "go_right";
            $direction1 = "go_left";
        } ?>
        <div class="message_main <?= $direction1 ?>">
            <div style="height: 120px; top: -20px" class="pos_absolute <?= $direction2 ?>">
                <img style="height: inherit;" class="svg_color_<?= $rand_color1 ?>" src="../../public/assets/images/blob_<?= $blob_num ?>.svg" alt="splosh">
                <img style="height: inherit;" class="svg_color_<?= $rand_color2 ?> pos_absolute paint_coords" src="../../public/assets/images/blob_<?= $blob_num ?>.svg" alt="splosh">
                <div style="gap: 10px;" class="pos_absolute paint_txt_coords float_left">
                    <div>👤</div>
                    <div class="paint_text_style"> <strong> <?= escape(get_comment_author($c["id"])) ?> </strong></div>
                </div>
            </div>

            <div class="message_text_block">
                <div class="message_text">
                    <div>
                        <?= escape($c['commentaire']) ?>
                    </div>
                    <p>
                        <?= escape($c['date']) ?>
                    </p>
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