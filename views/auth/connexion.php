<form class="connect_form glow float_column gap_small" method="post">
    <label for="login">Login</label>
    <input type="text" name="login" required>
    <label for="pass">Mot de passe</label>
    <input type="password" name="pass" required>
    <?php generate_neon_button("ENVOYER") ?>
</form>