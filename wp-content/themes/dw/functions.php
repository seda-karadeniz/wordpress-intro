<?php

// Désactiver l'éditeur Gutenberg de Wordpress
add_filter('use_block_editor_for_post', '__return_false');

// Activer les images pour les posts (articles, voyages, ...)
add_theme_support('post-thumbnails');

// Enregistrer un "type de ressource" (custom post type) pour les voyages
register_post_type('trips', [
    'label' => 'Voyages',
    'labels' => [
        'name' => 'Voyages',
        'singular_name' => 'Voyage',
    ],
    'description' => 'La ressource permettant de gérer les voyages qui ont été effectués.',
    'public' => true,
    'menu_position' => 5,
    'menu_icon' => 'dashicons-palmtree',
    'supports' => ['title','editor' ,'thumbnail']
]);

function dw_get_trips($count = 20)
{
    // 1on instancie l'objet wp_query

    $trips = new WP_Query([
        'post_type' => 'trips',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => $count,
    ]);

    // 2 on retourne l'objet
    return $trips;
}