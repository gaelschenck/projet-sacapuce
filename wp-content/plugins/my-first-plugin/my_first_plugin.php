<?php
/*
Plugin Name: Mon premier plugin
*/
add_action("custom-data", "myfirstplugin_add_page");

// function myfirstplugin_menu() {
//     $page_title = 'My first plugin';
//     $menu_title = 'My first plugin';
//     $capability = 'manage_options';
//     $menu_slug = 'myfirstplugin';
//     $function = 'myfirstplugin_page';
//     $icon_url = 'dashicons-admin-generic';
//     $position = 25;

//     add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);

//     // Submenu pages
//     add_submenu_page($menu_slug, 'Ajouter', 'Add New', $capability, 'myfirstplugin-add', 'myfirstplugin_add_page');
//     add_submenu_page($menu_slug, 'Edit', 'Edit', $capability, 'myfirstplugin-edit', 'myfirstplugin_edit_page');
    
// }
// add_action('admin_menu', 'myfirstplugin_menu');

function myfirstplugin_page() {

global $wpdb;
//recupérer le nom des formulaires
    $results = $wpdb->get_results(
    "SELECT * 
    FROM my_first_plugin_category ");

    
// en-tête de l'affichage
    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">My first Plugin</h1>';
    echo '<a href="' . admin_url('admin.php?page=myfirstplugin-add') . '" class="page-title-action">Ajouter</a>';
    echo '<hr class="wp-header-end">';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>Nom du formulaire</th>';
    echo '<th>Champ disponibles</th>';
    echo '<th>Actions possible</th>';
    echo '</tr></thead>';
    echo '<tbody>';

//affichage des catégories
    foreach ($results as $row) {
        echo '<tr>';  
        echo '<td>' . esc_html($row->category_name) . '</td>';
//récupérer les noms des champs disponibles en fonction des catégories
        $results2 = $wpdb->get_results(
            "SELECT * 
            ,GROUP_CONCAT( form_name SEPARATOR ' - ') AS form_name
            FROM my_first_plugin_liaison
            JOIN  my_first_plugin_form
            ON my_first_plugin_liaison.elem_form_id = my_first_plugin_form.id
            JOIN my_first_plugin_category
            ON my_first_plugin_liaison.category_id = my_first_plugin_category.id
            WHERE category_id = $row->id
            ");
            
        foreach ($results2 as $row2){
        echo '<td>' . esc_html($row2->form_name) . '</td>';}
//actions possibles par catégories
        echo '<td><a href="' . admin_url('admin.php?page=myfirstplugin-edit&id=' . $row->id) . '">Edit</a> | <a href="#" class="delete-link" data-id="' . $row->id . '">Delete</a></td>';}
        echo '</tr>';
  
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
 function myfirstplugin_add_page(){

    global $wpdb;

    $resultsCat = $wpdb->get_results("SELECT *
    FROM wp_itemmaison_categorie 
    WHERE attribute_id = 7 ");
    $resultsSta = $wpdb->get_results("SELECT *
    FROM wp_itemmaison_categorie 
    WHERE attribute_id = 8 ");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])
//  && wp_verify_nonce($_POST['custom_data_nonce'], 'custom_data_add')
)
  {
    $wpdb->query(
        $wpdb->prepare("INSERT INTO wp_itemmaison_entity (Statut)VALUES (0)")
        );
        $lastInsertEntityId = $wpdb->insert_id;

        if(!empty($_POST['nom'])){
    $nom = sanitize_text_field($_POST['nom']);
    $wpdb->query(
        $wpdb->prepare("INSERT INTO wp_itemmaison_value (entity_id , attribute_id , value) VALUES ( '$lastInsertEntityId', '1', '$nom')
        "));
}
        if(!empty($_POST['photo'])){
    $photo = sanitize_textarea_field($_POST['photo']);
    $wpdb->query(
        $wpdb->prepare("INSERT INTO wp_itemmaison_value (entity_id , attribute_id , value) VALUES ( '$lastInsertEntityId', '2', '$photo' )
    "));
}
    if(!empty($_POST['prix'])){
    $prix = sanitize_text_field($_POST['prix']);
    $wpdb->query(
        $wpdb->prepare("INSERT INTO wp_itemmaison_value (entity_id , attribute_id , value) VALUES( '$lastInsertEntityId', '3', '$prix' )
    "));
}
    if(!empty($_POST['description'])){
    $description = sanitize_textarea_field($_POST['description']);
    $wpdb->query(
        $wpdb->prepare("INSERT INTO wp_itemmaison_value (entity_id , attribute_id , value) VALUES( '$lastInsertEntityId', '4', '$description' )
    "));
}
    if(!empty($_POST['pointure'])){
    $pointure = sanitize_text_field($_POST['pointure']);
    $wpdb->query(
        $wpdb->prepare("INSERT INTO wp_itemmaison_value (entity_id , attribute_id , value) VALUES( '$lastInsertEntityId', '5', '$pointure' )
    "));
}
    if(!empty($_POST['couleur'])){
    $couleur = sanitize_text_field($_POST['couleur']);
    $wpdb->query(
        $wpdb->prepare("INSERT INTO wp_itemmaison_value (entity_id , attribute_id , value) VALUES( '$lastInsertEntityId', '6', '$couleur' )
    "));
}
    if(!empty($_POST['catégorie'])){
    $catégorie = sanitize_text_field($_POST['catégorie']);
    $wpdb->query(
        $wpdb->prepare("INSERT INTO wp_itemmaison_value (entity_id , attribute_id , value) VALUES( '$lastInsertEntityId', '7', '$catégorie' )
    "));
}
    if(!empty($_POST['statut'])){
    $statut = sanitize_text_field($_POST['statut']);
    $wpdb->query(
        $wpdb->prepare("INSERT INTO wp_itemmaison_value (entity_id , attribute_id , value) VALUES( '$lastInsertEntityId', '8', '$statut' )
    "));
}

}

    
// Titre
    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">Ajouter de nouvelles données</h1>';
    echo '<hr class="wp-header-end">';
// Début du formulaire
    echo '<form method="POST">';
    echo '<table class="form-table">';
//Insertion catégorie
    echo '<tr>';
    echo '<th scope="row"><label for="selectcatégorie"> Choisissez votre Catégorie</label></th>';
    echo '<td><select name="selectcatégorie" id="selectcatégorie" class="regular-text" >
    <option value=""> Choisissez une catégorie </option>';
        foreach ($resultsCat as $cat) {
    echo '<option value="' . esc_html($cat->id) . '"> ' . esc_html($cat->name) . ' </option>'; }'</td>';
    
    echo '<p class="submit"><input type="submit" name="go" id="go" class="button button-primary" value="Charger formulaire"></p>';
    echo '</tr>';
    // var_dump($_POST['go']);
    if(isset($_POST['go'])){
        $switch = ($_POST['selectcatégorie']);
switch($switch){
    case 1 :
        //insertion nom
            echo '<tr>';
            echo '<th scope="row"><label for="nom">Nom</label></th>';
            echo '<td><input name="nom" type="text" id="nom" class="regular-text" ></td>';
            echo '</tr>';
        //insertion prix
            echo '<tr>';
            echo '<th scope="row"><label for="prix">Prix</label></th>';
            echo '<td><input name="prix" type="text" id="prix" class="regular-text" ></td>';
            echo '</tr>';
        //insertion description
            echo '<tr>';
            echo '<th scope="row"><label for="description">Description</label></th>';
            echo '<td><textarea name="description" type="text" id="description" class="large-text" rows="10" ></textarea></td>';
            echo '</tr>';
        break;
    case 2:
        //insertion nom
            echo '<tr>';
            echo '<th scope="row"><label for="nom">Nom</label></th>';
            echo '<td><input name="nom" type="text" id="nom" class="regular-text"></td>';
            echo '</tr>';
        //insertion prix
            echo '<tr>';
            echo '<th scope="row"><label for="prix">Prix</label></th>';
            echo '<td><input name="prix" type="text" id="prix" class="regular-text"></td>';
            echo '</tr>';
        //insertion description
            echo '<tr>';
            echo '<th scope="row"><label for="description">Description</label></th>';
            echo '<td><textarea name="description" type="text" id="description" class="large-text" rows="10"></textarea></td>';
            echo '</tr>';
        //insertion pointure
            echo '<tr>';
            echo '<th scope="row"><label for="pointure">Pointure</label></th>';
            echo '<td><input name="pointure" type="text" id="pointure" class="regular-text"></td>';
            echo '</tr>';
        //insertion couleur
            echo '<tr>';
            echo '<th scope="row"><label for="couleur">Couleur</label></th>';
            echo '<td><input name="couleur" type="text" id="couleur" class="regular-text"></td>';
            echo '</tr>';
        break;
    case 3 :
        //insertion couleur
            echo '<tr>';
            echo '<th scope="row"><label for="couleur">Couleur</label></th>';
            echo '<td><input name="couleur" type="text" id="couleur" class="regular-text"></td>';
            echo '</tr>';
        //insertion pointure
            echo '<tr>';
            echo '<th scope="row"><label for="pointure">Pointure</label></th>';
            echo '<td><input name="pointure" type="text" id="pointure" class="regular-text" required></td>';
            echo '</tr>';
        //insertion nom
            echo '<tr>';
            echo '<th scope="row"><label for="nom">Nom</label></th>';
            echo '<td><input name="nom" type="text" id="nom" class="regular-text"></td>';
            echo '</tr>';
        //insertion description
            echo '<tr>';
            echo '<th scope="row"><label for="description">Description</label></th>';
            echo '<td><textarea name="description" type="text" id="description" class="large-text" rows="10"></textarea></td>';
            echo '</tr>';
        break;
    case 4:
        //insertion nom
            echo '<tr>';
            echo '<th scope="row"><label for="nom">Nom</label></th>';
            echo '<td><input name="nom" type="text" id="nom" class="regular-text"></td>';
            echo '</tr>';
        //insertion description
            echo '<tr>';
            echo '<th scope="row"><label for="description">Description</label></th>';
            echo '<td><textarea name="description" type="text" id="description" class="large-text" rows="10"></textarea></td>';
            echo '</tr>';
        //insertion prix
            echo '<tr>';
            echo '<th scope="row"><label for="prix">Prix</label></th>';
            echo '<td><input name="prix" type="text" id="prix" class="regular-text"></td>';
            echo '</tr>';
        break;
    default :
        //insertion nom
            echo '<tr>';
            echo '<th scope="row"><label for="nom">Nom</label></th>';
            echo '<td><input name="nom" type="text" id="nom" class="regular-text"></td>';
            echo '</tr>';
        //insertion photo
            echo '<tr>';
            echo '<th scope="row"><label for="photo">Photo</label></th>';
            echo '<td>
            <textarea name="photo" id="photo" class="large-text" rows="10" ></textarea>
            </td>';
            echo '</tr>';
        //insertion prix
            echo '<tr>';
            echo '<th scope="row"><label for="prix">Prix</label></th>';
            echo '<td><input name="prix" type="text" id="prix" class="regular-text"></td>';
            echo '</tr>';
        //insertion description
            echo '<tr>';
            echo '<th scope="row"><label for="description">Description</label></th>';
            echo '<td><textarea name="description" type="text" id="description" class="large-text" rows="10"></textarea></td>';
            echo '</tr>';
        //insertion pointure
            echo '<tr>';
            echo '<th scope="row"><label for="pointure">Pointure</label></th>';
            echo '<td><input name="pointure" type="text" id="pointure" class="regular-text"></td>';
            echo '</tr>';
        //insertion couleur
            echo '<tr>';
            echo '<th scope="row"><label for="couleur">Couleur</label></th>';
            echo '<td><input name="couleur" type="text" id="couleur" class="regular-text"></td>';
            echo '</tr>';
        //insertion catégorie
            echo '<tr>';
            echo '<th scope="row"><label for="catégorie">Catégorie</label></th>';
            echo '<td><select name="catégorie" id="catégorie" class="regular-text">
            <option value=""> Choisissez une catégorie </option>';
                foreach ($resultsCat as $cat) {
            echo '<option value="' . esc_html($cat->id) . '"> ' . esc_html($cat->name) . '</option>'; }
            echo '</td>';
            echo '</tr>';
        // insertion statut
            echo '<tr>';
            echo '<th scope="row"><label for="statut">Statut</label></th>';
            echo '<td><select name="statut" id="statut" class="regular-text">
            <option value=""> Choisissez un statut </option>';
                foreach ($resultsSta as $sta) {
            echo '<option value="'.esc_html($sta->id).'"> ' . esc_html($sta->name) . '</option>'; }
            echo '</td>';
            echo '</tr>';
            
    break;
    }
    }
    echo '</table>';

    //soumission du formulaire
    echo '<input type="hidden" name="myfirstplugin_nonce" value="' . wp_create_nonce('myfirstplugin_add') . '">';
    echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Add New"></p>';
    echo '</form>';
    echo '</div>';

    
 }

// function myfirstplugin_add_page() {
    
// // // Ajouter du contenu
// //     global $wpdb;

// //     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])
// //     //  && wp_verify_nonce($_POST['myfirstplugin_nonce'], 'myfirstplugin_add')
// //     )
// //       {
// //         $nom = sanitize_text_field($_POST['nom']);
// //         $photo = sanitize_textarea_field($_POST['photo']);
// //         $prix = sanitize_text_field($_POST['prix']);
// //         $description = sanitize_textarea_field($_POST['description']);
// //         $pointure = sanitize_text_field($_POST['pointure']);
// //         $couleur = sanitize_text_field($_POST['couleur']);
// //         $catégorie = sanitize_text_field($_POST['catégorie']);
// //         $statut = sanitize_text_field($_POST['statut']);
        
// // $wpdb->query(
// //         $wpdb->prepare("INSERT INTO wp_itemmaison_entity (Statut)VALUES (0)")
// //         );
        
        
// //         $lastInsertEntityId = $wpdb->insert_id;
        
// //         $wpdb->query(
// //         $wpdb->prepare("INSERT INTO wp_itemmaison_value (entity_id , attribute_id , value) VALUES ( '$lastInsertEntityId', '1', '$nom' )"));

// //     }
// // Titre
//     echo '<div class="wrap">';
//     echo '<h1 class="wp-heading-inline">Ajouter un nouveau formulaire</h1>';
//     echo '<hr class="wp-header-end">';

// // Début du formulaire
//     echo '<form method="POST">';
//     echo '<table class="form-table">';

// //Choix du nombre d'input
//     echo '<tr>';
//     echo '<th scope="row"><label for="nbr">Nombre de champs</label></th>';
//     echo '<td><input type="number" name="nbr" id="nbr" class="number" required placeholder="Insérer un chiffre"></td>';
//     echo '</tr>';
//     echo '</div>';
//     echo '</table>';
//     echo '<p class="submit"><input type="submit" name="valid" id="valid" class="button button-primary" value="Ajouter le nombre de champs"></p>';

// if(isset($_POST['valid'])){
//     $maxI = ($_POST['nbr']);
//     // var_dump($number); 

//     echo '<form method="POST">';
//     echo '<table class="form-table">';
//     //Insertion nom de catégorie
//     echo '<tr>';
//     echo '<th scope="row"><label for="category">Catégorie</label></th>';
//     echo '<td><input name="category" type="text" id="category" class="regular-text" required></td>';
//     echo '</tr>';
//     // $_POST['valid'] = $i;
//     for($i=1 ; $i<= $maxI; addnewinput($i++)){        
//     }
// }
// //soumission du formulaire
//     echo '<input type="hidden" name="myfirstplugin_nonce" value="' . wp_create_nonce('myfirstplugin_add') . '">';
//     echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Ajouter le nouveau formulaire"></p>';
//     echo '</form>';
//     echo '</div>';
// }
// function addnewinput($i){

//     echo '<tr>';
//     echo '<th scope="row"><label for="new'.esc_html($i).'">Champ'.esc_html($i).'</label></th>';
//     echo '<td><input name="new'.esc_html($i).'" id="new'.esc_html($i).'" class="text" required></td>';
//     echo '</tr>';
// }

// function custom_data_edit_page() {
//     // Edit custom data page conte
//     global $wpdb;
//     $table_name = $wpdb->prefix . 'custom_data';
//     $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
//     $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));

//     if (!$row) {
//         echo '<div class="notice notice-error is-dismissible"><p>Invalid custom data ID!</p></div>';
//         return;
//     }

//     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['custom_data_nonce']) && wp_verify_nonce($_POST['custom_data_nonce'], 'custom_data_edit')) {
//         $title = sanitize_text_field($_POST['title']);
//         $content = sanitize_textarea_field($_POST['content']);
//         $updated_at = current_time('mysql');

//         $wpdb->update($table_name, compact('title', 'content', 'updated_at'), array('id' => $id));

//         echo '<div class="notice notice-success is-dismissible"><p>Custom data updated successfully!</p></div>';
//         echo '<script>window.location.href="' . admin_url('admin.php?page=custom-data') . '";</script>';
//     }

//     echo '<div class="wrap">';
//     echo '<h1 class="wp-heading-inline">Edit Custom Data</h1>';
//     echo '<hr class="wp-header-end">';

//     echo '<form method="post">';
//     echo '<table class="form-table">';
//     echo '<tr>';
//     echo '<th scope="row"><label for="title">Title</label></th>';
//     echo '<td><input name="title" type="text" id="title" value="' . esc_attr($row->title) . '" class="regular-text" required></td>';
//     echo '</tr>';
//     echo '<tr>';
//     echo '<th scope="row"><label for="content">Content</label></th>';
//     echo '<td><textarea name="content" id="content" class="large-text" rows="10" required>' . esc_textarea($row->content) . '</textarea></td>';
//     echo '</tr>';
//     echo '</table>';

//     echo '<input type="hidden" name="custom_data_nonce" value="' . wp_create_nonce('custom_data_edit') . '">';
//     echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Update"></p>';
//     echo '</form>';
//     echo '</div>';
// }
// function delete_myfirstplugin() {
//     check_ajax_referer('delete_myfirstplugin_nonce', 'nonce');
//     global $wpdb;
//     $table_name = $wpdb->prefix . 'custom_data';
//     $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

//     $result = $wpdb->delete($table_name, array('id' => $id));
//     wp_send_json_success($result);
// }
// add_action('wp_ajax_delete_myfirstplugin', 'delete_myfirstplugin');

// function custom_data_admin_scripts() {
//     wp_enqueue_script('myfirstplugin', get_template_directory_uri() . '/js/myfirstplugin.js', array('jquery'), false, true);
//     wp_localize_script('myfirstplugin', 'customData', array(
//         'ajaxurl' => admin_url('admin-ajax.php'),
//         'delete_nonce' => wp_create_nonce('delete_myfirstplugin_nonce')
//     ));
// }
// add_action('admin_enqueue_scripts', 'myfirstplugin_admin_scripts');
//
 ?>