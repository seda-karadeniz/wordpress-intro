<?php
/*require_once(__DIR__.'/Menus/PrimaryMenuWalker.php');*/
require_once(__DIR__.'/Menus/PrimaryMenuItem.php');

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
    'supports' => ['title','editor' ,'thumbnail'],
    'rewrite' => ['slug', 'voyage'],
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
//enregistrer les menu de nav

register_nav_menu('primary', 'Emplacement de la navigation principale');
register_nav_menu('footer', 'Emplacement de la navigation de pied de page');

// definition de la fonction retournant un menu de navigation sous  forme d'un tableau de liens de niveau 0
function dw_get_menu_items($location)
{
    $items = [];
    // recuperer le menu qui correspond à l'emplacement souhaité
    $locations = get_nav_menu_locations();
    if ($locations[$location] ?? null){
        $menu= $locations[$location];

        // recuperer tout les elements du menu en question

        $posts = wp_get_nav_menu_items($menu);
        // traiter chaque element de menu pour le transformer en objet
        foreach ($posts as  $post){
            $item = new PrimaryMenuItem($post);
            // creer une instance d'un objet d'un objet personnalisé à partir de $post
            // ajouter cette instance soit a $item (s'il sagit d'un element de niveau 0) soit en tant que sous-element d'un item deja existant

            if ($item->isSubItems()){
                // ajouter l'instance comme "enfant"
                foreach ($items as $existing){
                    if ($existing->isParentFor($item)){
                        $existing->addSubItem($item);
                    }
                }
            }
            else{
                // sil sagit dun element niveau 0
                $items[]= $item;
            }
        }
    }
    // ?? = si ce quil ya sur la gauche existe et nest pas null alors ca prend ca sinon ca prend null (verifie si la clé existe dans le tableau)

    // retourner les elements de menu de niveau 0
    return $items;
}