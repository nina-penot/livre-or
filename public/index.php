<?php

/**
 * Point d'entrée principal de l'application PHP MVC
 * 
 * Ce fichier initialise l'application et lance le système de routing
 */


// Charger le bootstrap qui initialise tout
require_once '../bootstrap.php';

// Charger les fichiers core
require_once CORE_PATH . '/database.php';
require_once CORE_PATH . '/router.php';
require_once CORE_PATH . '/view.php';

// Charger les fichiers utilitaires
require_once INCLUDE_PATH . '/helpers.php';

// Charger les modèles
// ex: require_once MODEL_PATH . '/user_model.php';

// Lancer le routeur
route();
