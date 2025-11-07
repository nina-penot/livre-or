<?php

/**
 * ===============================================
 * FONCTIONS UTILITAIRES ESSENTIELLES - MVC STARTER
 * ===============================================
 * 
 * Ce fichier contient toutes les fonctions utilitaires nécessaires
 * pour développer une application MVC sécurisée et maintenable.
 * 
 */

// ===============================================
// SÉCURITÉ - PROTECTION XSS
// ===============================================

/**
 * Sécurise l'affichage d'une chaîne de caractères (protection XSS)
 * 
 * Cette fonction est ESSENTIELLE pour éviter les attaques XSS.
 * Elle convertit les caractères spéciaux HTML en entités HTML.
 * 
 * @param string $string La chaîne à sécuriser
 * @return string La chaîne sécurisée
 * 
 */
function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Affiche directement une chaîne sécurisée (échappée)
 * 
 * Version raccourcie de echo escape($string)
 * Pratique pour les templates avec beaucoup d'affichages
 * 
 * @param string $string La chaîne à afficher de manière sécurisée
 * 
 */
function e($string)
{
    echo escape($string);
}

// ===============================================
// CONNEXIONS - SECURITE
// ===============================================

/**
 * Hash un mot de passe
 */
function hash_password($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Vérifie si un utilisateur est connecté
 */
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function log_out()
{
    unset($_SESSION["user_id"]);
    unset($_SESSION["login"]);
    redirect('auth/connexion');
}

// ===============================================
// NAVIGATION - URLS ET REDIRECTIONS
// ===============================================

/**
 * Génère une URL absolue basée sur la configuration BASE_URL
 * 
 * Cette fonction garantit des URLs cohérentes dans toute l'application
 * et facilite le déploiement sur différents environnements.
 * 
 * @param string $path Le chemin relatif (optionnel)
 * @return string L'URL absolue complète
 * 
 */
function url($path = '')
{
    $base_url = rtrim(BASE_URL, '/');
    $path = ltrim($path, '/');
    return $base_url . '/' . $path;
}

/**
 * Effectue une redirection HTTP vers une URL
 * 
 * Utilisée pour rediriger l'utilisateur après une action
 * (connexion, création, modification, etc.)
 * 
 * @param string $path Le chemin de destination (optionnel, par défaut : accueil)
 * 
 */
function redirect($path = '')
{
    $url = url($path);
    header("Location: $url");
    exit;
}

// ===============================================
// REQUÊTES HTTP - MÉTHODES ET PARAMÈTRES
// ===============================================

/**
 * Vérifie si la requête HTTP actuelle est en méthode POST
 * 
 * Utilisée pour différencier l'affichage d'un formulaire (GET)
 * du traitement de ce formulaire (POST).
 * 
 * @return bool true si POST, false sinon
 * 
 */
function is_post()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
 * Vérifie si la requête HTTP actuelle est en méthode GET
 * 
 * Utilisée pour les affichages, recherches, et navigation.
 * 
 * @return bool true si GET, false sinon
 * 
 */
function is_get()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

/**
 * Récupère la valeur d'un paramètre POST de manière sécurisée
 * 
 * Évite les erreurs "Undefined index" et permet des valeurs par défaut.
 * 
 * @param string $key Le nom du paramètre POST
 * @param mixed $default La valeur par défaut si le paramètre n'existe pas
 * @return mixed La valeur du paramètre ou la valeur par défaut
 * 
 */
function post($key, $default = null)
{
    return $_POST[$key] ?? $default;
}

/**
 * Récupère la valeur d'un paramètre GET de manière sécurisée
 * 
 * Utilisée pour les paramètres d'URL, recherches, pagination, filtres.
 * 
 * @param string $key Le nom du paramètre GET
 * @param mixed $default La valeur par défaut si le paramètre n'existe pas
 * @return mixed La valeur du paramètre ou la valeur par défaut
 * 
 */
function get($key, $default = null)
{
    return $_GET[$key] ?? $default;
}

// ===============================================
// NAVIGATION - ROUTES ET LIENS ACTIFS
// ===============================================

/**
 * Retourne la route courante basée sur l'URL
 * 
 * Utilisée pour déterminer quelle page est actuellement affichée
 * et appliquer les styles appropriés aux liens de navigation.
 * 
 * @return string La route courante (ex: 'documentation/mvc')
 * 
 */
function current_route()
{
    $url = $_GET['url'] ?? '';
    $url = rtrim($url, '/');
    return $url;
}

/**
 * Vérifie si un lien de navigation est actif
 * 
 * Compare la route courante avec le chemin du lien pour déterminer
 * si le lien doit être marqué comme actif dans la navigation.
 * 
 * @param string $path Le chemin du lien à vérifier
 * @return bool true si le lien est actif, false sinon
 * 
 */
function is_active_link($path)
{
    $current = current_route();
    $path = ltrim($path, '/');

    // Page d'accueil
    if (empty($path) && empty($current)) {
        return true;
    }

    // Correspondance exacte
    if ($current === $path) {
        return true;
    }

    // Correspondance partielle pour les sections principales uniquement
    // Éviter que "documentation" soit actif sur "documentation/mvc"
    if (!empty($path) && !empty($current)) {
        $currentParts = explode('/', $current);
        $pathParts = explode('/', $path);

        // Si le path est une section principale (ex: "documentation")
        // et que la route courante commence par cette section
        // mais a plus de segments, alors ce n'est pas actif
        if (count($pathParts) === 1 && count($currentParts) > 1) {
            return false;
        }

        // Correspondance partielle normale
        if (strpos($current, $path) === 0) {
            return true;
        }
    }

    return false;
}

// ===============================================
// SÉCURITÉ - PROTECTION CSRF
// ===============================================

/**
 * Génère un token CSRF unique pour sécuriser les formulaires
 * 
 * Cette fonction crée un token aléatoirement sécurisé qui doit être inclus
 * dans tous les formulaires pour prévenir les attaques CSRF.
 * Le token est stocké en session pour vérification ultérieure.
 * 
 * @return string Le token CSRF généré
 * 
 */
function csrf_token()
{
    // Démarrer la session si elle n'est pas déjà active
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Générer un nouveau token s'il n'existe pas
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/**
 * Vérifie la validité d'un token CSRF
 * 
 * Cette fonction compare le token fourni avec celui stocké en session
 * pour s'assurer que la requête provient bien du formulaire légitime.
 * 
 * @param string $token Le token CSRF à vérifier
 * @return bool true si le token est valide, false sinon
 * 
 */
function verify_csrf_token($token)
{
    // Démarrer la session si elle n'est pas déjà active
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Vérifier que le token existe en session
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }

    // Comparaison sécurisée des tokens (évite les attaques timing)
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Régénère un nouveau token CSRF
 * 
 * Utilisée après une action sensible pour invalider l'ancien token
 * et forcer la génération d'un nouveau pour les prochains formulaires.
 * 
 * @return string Le nouveau token CSRF généré
 * 
 */
function regenerate_csrf_token()
{
    // Démarrer la session si elle n'est pas déjà active
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Supprimer l'ancien token et en générer un nouveau
    unset($_SESSION['csrf_token']);
    return csrf_token();
}

// ===============================================
// BONUS!!!!!
// ===============================================

/**
 * Fabrique un lien style boutton neon
 */
function generate_neon_link($content, $url = '')
{ ?>
    <a class="nav_elem glow_out" href="<?= url($url); ?>">
        <div class="nav_elem_inside glow_in"><?= $content; ?></div>
    </a>
<?php }

/**
 * Fabrique un boutton neon
 */
function generate_neon_button($content)
{ ?>
    <button class="nav_elem glow_out border_killer" type="submit">
        <div class="nav_elem_inside glow_in"><?= $content; ?></div>
    </button>
<?php }
