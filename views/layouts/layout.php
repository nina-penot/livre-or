<?php
$base_nav = ['Accueil' => '', "Livre d'or" => 'livre/livreor'];
$public_nav = [
    'Inscription' => 'auth/inscription',
    'Connexion' => 'auth/connexion'
];
$logged_nav = ['Profil' => 'home/profil', 'Déconnexion' => 'auth/logout'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? escape($title) . ' - ' . APP_NAME : APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo url('assets/css/style.css'); ?>">
</head>

<body>
    <header class="header glow">
        <div class="header_title">TAG WALL TIME</div>
        <nav class="float_left gap_small">
            <?php
            foreach ($base_nav as $key => $val) {
                generate_neon_link($key, $val);
            }
            if (is_logged_in()) {
                foreach ($logged_nav as $key => $val) {
                    generate_neon_link($key, $val);
                }
            } else {
                foreach ($public_nav as $key => $val) {
                    generate_neon_link($key, $val);
                }
            }
            ?>
        </nav>
    </header>

    <main class="header">
        <?php echo $content ?? ''; ?>
    </main>

    <footer class="header">
        <div>Footer here</div>
    </footer>
</body>

</html>