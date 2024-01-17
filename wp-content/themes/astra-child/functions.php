<?php
add_action('wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
/* enqueue script for parent theme stylesheeet */
// function childtheme_parent_styles() {

//     // enqueue style
//     wp_enqueue_style( 'parent', get_template_directory_uri().'/style.css' );
//     }
//     add_action( 'wp_enqueue_scripts', 'childtheme_parent_styles');
 
function custom_data_menu() {
    $page_title = 'Custom Data';
    $menu_title = 'Custom Data';
    $capability = 'manage_options';
    $menu_slug = 'custom-data';
    $function = 'custom_data_page';
    $icon_url = 'dashicons-admin-generic';
    $position = 25;

    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);

    // Submenu pages
    add_submenu_page($menu_slug, 'Add New', 'Add New', $capability, 'custom-data-add', 'custom_data_add_page');
    add_submenu_page($menu_slug, 'Edit', 'Edit', $capability, 'custom-data-edit', 'custom_data_edit_page');
}
add_action('admin_menu', 'custom_data_menu');

function custom_data_page() {

global $wpdb;

    $results = $wpdb->get_results("SELECT id 
    FROM wp_itemmaison_entity ");
// var_dump($results);

                                        
// var_dump($results2);
// requête pour dédoublonner les attributs (fusion)
    $results3 = $wpdb->get_results(
    "SELECT DISTINCT attribute_name 
    FROM wp_itemmaison_value
    INNER JOIN wp_itemmaison_attribute
    ON wp_itemmaison_attribute.id = wp_itemmaison_value.attribute_id
    ORDER BY attribute_id
    ");
    // var_dump($results3);

    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">Custom Data</h1>';
    echo '<a href="' . admin_url('admin.php?page=custom-data-add') . '" class="page-title-action">Add New</a>';
    echo '<hr class="wp-header-end">';

    echo '<table class="wp-list-table widefat fixed striped">';
    // titre tableau par attribut
    echo '<thead><tr><th></th>';
    foreach ($results3 as $row3) {
    echo '<th>' . esc_html($row3->attribute_name) . '</th>';}
    echo '</tr></thead>';
    echo '<tbody>';
// affichage des valeurs -> GROUP BY entity_id 

    foreach ($results as $row) {
        echo '<tr>';  
       
        echo '<td>' . esc_html($row->id) . '</td>';
    // }
    //requête pour grouper les valeurs par attribut (rangés dans la même case)
    $results2 = $wpdb->get_results(
        "SELECT  * ,GROUP_CONCAT( value SEPARATOR ' - ') AS value
        FROM wp_itemmaison_value
        WHERE entity_id =$row->id
        GROUP BY attribute_id
        ");
        foreach ($results2 as $row2){
        echo '<td>' . esc_html($row2->value) . '</td>';}
        // echo '<td>' . esc_html($row2->value) . '</td>';
        // echo '<td>' . esc_html($row2->value) . '</td>';
        echo '<td><a href="' . admin_url('admin.php?page=custom-data-edit&id=' . $row->id) . '">Edit</a> | <a href="#" class="delete-link" data-id="' . $row->id . '">Delete</a></td>';}
        echo '</tr>';
  
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}



function custom_data_add_page() {
    
    include_once(ABSPATH . 'wp-content/plugins/my-first-plugin/my_first_plugin.php');
    echo myfirstplugin_add_page();
//     // Add new custom data page content
//     global $wpdb;

//     $resultsCat = $wpdb->get_results("SELECT *
//     FROM wp_itemmaison_categorie 
//     WHERE attribute_id = 7 ");

//     $resultsSta = $wpdb->get_results("SELECT *
//     FROM wp_itemmaison_categorie 
//     WHERE attribute_id = 8 ");
    

//     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])
//     //  && wp_verify_nonce($_POST['custom_data_nonce'], 'custom_data_add')
//     )
//       {
//         $nom = sanitize_text_field($_POST['nom']);
//         $photo = sanitize_textarea_field($_POST['photo']);
//         $prix = sanitize_text_field($_POST['prix']);
//         $description = sanitize_textarea_field($_POST['description']);
//         $pointure = sanitize_text_field($_POST['pointure']);
//         $couleur = sanitize_text_field($_POST['couleur']);
//         $catégorie = sanitize_text_field($_POST['catégorie']);
//         $statut = sanitize_text_field($_POST['statut']);
        
//         // error_log(print_r($_POST,1));
// $wpdb->query(
//         $wpdb->prepare("INSERT INTO wp_itemmaison_entity (Statut)VALUES (0)")
//         );
//         $lastInsertEntityId = $wpdb->insert_id;
//         // error_log($lastInsertEntityId);
//         $wpdb->query(
//         $wpdb->prepare("INSERT INTO wp_itemmaison_value (entity_id , attribute_id , value) VALUES 
//         ( '$lastInsertEntityId', '1', '$nom' ),
//         ( '$lastInsertEntityId', '2', '$photo' ),
//         ( '$lastInsertEntityId', '3', '$prix' ),
//         ( '$lastInsertEntityId', '4', '$description' ),
//         ( '$lastInsertEntityId', '5', '$pointure' ),
//         ( '$lastInsertEntityId', '6', '$couleur' ),
//         ( '$lastInsertEntityId', '7', '$catégorie' ),
//         ( '$lastInsertEntityId', '8', '$statut' ) "));


//         echo '<div class="notice notice-success is-dismissible"><p>Custom data added successfully!</p></div>';
//         echo '<script>window.location.href="' . admin_url('admin.php?page=custom-data') . '";</script>';
//     }
//     // Titre
//     echo '<div class="wrap">';
//     echo '<h1 class="wp-heading-inline">Add New Custom Data</h1>';
//     echo '<hr class="wp-header-end">';

//         // Début du formulaire
//     echo '<form method="POST">';
//     echo '<table class="form-table">';
//     //activation du plugin : myfirstplugin
//     // add_action()
// //insertion nom
//     echo '<tr>';
//     echo '<th scope="row"><label for="nom">Nom</label></th>';
//     echo '<td><input name="nom" type="text" id="nom" class="regular-text" required></td>';
//     echo '</tr>';
// //insertion photo
//     echo '<tr>';
//     echo '<th scope="row"><label for="photo">Photo</label></th>';
//     echo '<td>
//     <textarea name="photo" id="photo" class="large-text" rows="10" required></textarea>
//     </td>';
//     echo '</tr>';
// //insertion prix
//     echo '<tr>';
//     echo '<th scope="row"><label for="prix">Prix</label></th>';
//     echo '<td><input name="prix" type="text" id="prix" class="regular-text" required></td>';
//     echo '</tr>';
// //insertion description
//     echo '<tr>';
//     echo '<th scope="row"><label for="description">Description</label></th>';
//     echo '<td><textarea name="description" type="text" id="description" class="large-text" rows="10" required></textarea></td>';
//     echo '</tr>';
// //insertion pointure
//     echo '<tr>';
//     echo '<th scope="row"><label for="pointure">Pointure</label></th>';
//     echo '<td><input name="pointure" type="text" id="pointure" class="regular-text" required></td>';
//     echo '</tr>';
// //insertion couleur
//     echo '<tr>';
//     echo '<th scope="row"><label for="couleur">Couleur</label></th>';
//     echo '<td><input name="couleur" type="text" id="couleur" class="regular-text" required></td>';
//     echo '</tr>';
// //insertion catégorie
//     echo '<tr>';
//     echo '<th scope="row"><label for="catégorie">Catégorie</label></th>';
//     echo '<td><select name="catégorie" id="catégorie" class="regular-text" required>
//     <option value=""> Choisissez une catégorie </option>';
//         foreach ($resultsCat as $cat) {
//     echo '<option value="' . esc_html($cat->id) . '  "> ' . esc_html($cat->name) . ' </option>'; }
//     '</td>';
//     echo '</tr>';
// // insertion statut
//     echo '<tr>';
//     echo '<th scope="row"><label for="statut">Statut</label></th>';
//     echo '<td>
//     <select name="statut" id="statut" class="regular-text" required>
//     <option value=""> Choisissez un statut </option>';
//         foreach ($resultsSta as $sta) {
//     echo '<option value="'.esc_html($sta->id).'  "> ' . esc_html($sta->name) . ' </option>'; }
//     '</td>';
//     echo '</tr>';
//     echo '</table>';
// //soumission du formulaire
//     echo '<input type="hidden" name="custom_data_nonce" value="' . wp_create_nonce('custom_data_add') . '">';
//     echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Add New"></p>';
//     echo '</form>';
//     echo '</div>';
}

function custom_data_edit_page() {
    // Edit custom data page conte
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));

    if (!$row) {
        echo '<div class="notice notice-error is-dismissible"><p>Invalid custom data ID!</p></div>';
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['custom_data_nonce']) && wp_verify_nonce($_POST['custom_data_nonce'], 'custom_data_edit')) {
        $title = sanitize_text_field($_POST['title']);
        $content = sanitize_textarea_field($_POST['content']);
        $updated_at = current_time('mysql');

        $wpdb->update($table_name, compact('title', 'content', 'updated_at'), array('id' => $id));

        echo '<div class="notice notice-success is-dismissible"><p>Custom data updated successfully!</p></div>';
        echo '<script>window.location.href="' . admin_url('admin.php?page=custom-data') . '";</script>';
    }

    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">Edit Custom Data</h1>';
    echo '<hr class="wp-header-end">';

    echo '<form method="post">';
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label for="title">Title</label></th>';
    echo '<td><input name="title" type="text" id="title" value="' . esc_attr($row->title) . '" class="regular-text" required></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th scope="row"><label for="content">Content</label></th>';
    echo '<td><textarea name="content" id="content" class="large-text" rows="10" required>' . esc_textarea($row->content) . '</textarea></td>';
    echo '</tr>';
    echo '</table>';

    echo '<input type="hidden" name="custom_data_nonce" value="' . wp_create_nonce('custom_data_edit') . '">';
    echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Update"></p>';
    echo '</form>';
    echo '</div>';
}
function delete_custom_data() {
    check_ajax_referer('delete_custom_data_nonce', 'nonce');
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    $result = $wpdb->delete($table_name, array('id' => $id));
    wp_send_json_success($result);
}
add_action('wp_ajax_delete_custom_data', 'delete_custom_data');

function custom_data_admin_scripts() {
    wp_enqueue_script('custom-data', get_template_directory_uri() . '/js/custom-data.js', array('jquery'), false, true);
    wp_localize_script('custom-data', 'customData', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'delete_nonce' => wp_create_nonce('delete_custom_data_nonce')
    ));
}
add_action('admin_enqueue_scripts', 'custom_data_admin_scripts');

function display_product($id_product) {

    if (isset($_POST["bigview{$id_product}"])) {
        big_view($id_product); 
        echo "<style>.container{display:none}</style>";
    }else{
    // error_log("coucou1");
    global $wpdb;

    // Récupérer les données de l'entité
    $entity = $wpdb->get_row("SELECT * FROM wp_itemmaison_entity WHERE id = {$id_product}", ARRAY_A);
    if (!$entity) {
        echo "Produit non trouvé";
        return;
    }

    // Récupérer les valeurs des attributs
    $attributes = $wpdb->get_results("SELECT * FROM wp_itemmaison_value WHERE entity_id = {$id_product}", ARRAY_A);

    // Organiser les attributs par leur identifiant
    $attributesById = [];
    foreach ($attributes as $attribute) {
        $attributesById[$attribute['attribute_id']] = $attribute['value'];
    }

    // Récupérer le nom de la catégorie
    $category = $wpdb->get_row("SELECT name
                                FROM wp_itemmaison_value 
                                Join wp_itemmaison_categorie 
                                ON wp_itemmaison_categorie.id = wp_itemmaison_value.value
                                WHERE wp_itemmaison_value.attribute_id = 7 AND entity_id = {$id_product}
                                ");
    
    // Récupérer le nom du statut
    $statut = $wpdb->get_row("SELECT name
                                FROM wp_itemmaison_value 
                                Join wp_itemmaison_categorie 
                                ON wp_itemmaison_categorie.id = wp_itemmaison_value.value
                                WHERE wp_itemmaison_value.attribute_id = 8 AND entity_id = {$id_product}
                                ");

    // Récupérer les pointures
    $pointe = $wpdb->get_results("SELECT value
    FROM wp_itemmaison_value 
    WHERE wp_itemmaison_value.attribute_id = 5 AND entity_id = {$id_product}
    ");  
    
    // Récupérer les couleurs
    $color = $wpdb->get_results("SELECT value
    FROM wp_itemmaison_value 
    WHERE wp_itemmaison_value.attribute_id = 6 AND entity_id = {$id_product}
    ");
                
// error_log(print_r($pointe,1));

echo "<div class='container'>";
    echo "<div class='tetemin'>
            <p>{$statut->name}</p>
            <form method='post'>
            <button class='coeur' name='coeur{$id_product}'><img src='http://localhost/Sacapuce/wp-content/uploads/2023/06/like.svg'></button></form>";
            if (isset($_POST["coeur{$id_product}"])) {
                add_coeur($id_product);
            }
        echo "</div>";
    echo "<div class='tetemoy'>
            <form method='post'>
            <button class='coeur' name='bigview{$id_product}'>
            <img src='{$attributesById[2]}'width='150px' height='150px alt='{$attributesById[1]}'/></button></form>
        </div>";
    echo "<div class='tetebas'>
            <p>{$attributesById[1]}</p>
            <p>{$attributesById[3]}€</p>
        </div>";
    echo "<div class='teteinf'>
            <p>Pointure :";    
            foreach ($pointe as $pointure){
            echo " {$pointure->value}&nbsp ";}"</p>
        </div>";
    echo "<div><form method='post'><button type='submit' id='{$id_product}' class='addcart' name='addcart{$id_product}'> Ajouter au panier </button></form></div>";
echo "</div>";
        if (isset($_POST["addcart{$id_product}"])) {
        add_cart($id_product);
        }
    }
}
function add_coeur($id_product){
    global $wpdb;
        
         $wpdb->query(
            $wpdb->prepare( "UPDATE wp_itemmaison_entity SET coeur = 1 WHERE wp_itemmaison_entity.id = $id_product" )
        );  

}
function remove_coeur($id_product){
    global $wpdb;
        
         $wpdb->query(
            $wpdb->prepare( "UPDATE wp_itemmaison_entity SET coeur = 0 WHERE wp_itemmaison_entity.id = $id_product" )
        );  
        
}

function show_all_coeur(){

    global $wpdb;
    $entity = $wpdb->get_results("SELECT id FROM wp_itemmaison_entity WHERE coeur = 1");
    echo "<div class='boutiflex'>";
    foreach ($entity as $idto){
        display_product($idto->id); 
    echo "</div>";}
}

function add_cart($id_product){
    global $wpdb;
        
         $wpdb->query(
            $wpdb->prepare( "UPDATE wp_itemmaison_entity SET statut = 1 WHERE wp_itemmaison_entity.id = $id_product" )
        );    
}

function show_all_cart(){

    global $wpdb;
    $entity = $wpdb->get_results("SELECT id FROM wp_itemmaison_entity WHERE statut = 1");
    echo "<div>";
    echo "<div class='boutiflex'>";
    foreach ($entity as $idto){
        display_cart($idto->id); 
    echo "</div>";}
    echo "</div>";
}

function display_cart($id_product){

    if (isset($_POST["bigview{$id_product}"])) {
        big_view($id_product); 
        echo "<style>.container{display:none}</style>";
    }else{

    global $wpdb;

    // Récupérer les données de l'entité
    $entity = $wpdb->get_row("SELECT * FROM wp_itemmaison_entity WHERE id = {$id_product}", ARRAY_A);
    if (!$entity) {
        echo "Produit non trouvé";
        return;
    }

    // Récupérer les valeurs des attributs
    $attributes = $wpdb->get_results("SELECT * FROM wp_itemmaison_value WHERE entity_id = {$id_product}", ARRAY_A);

    // Organiser les attributs par leur identifiant
    $attributesById = [];
    foreach ($attributes as $attribute) {
        $attributesById[$attribute['attribute_id']] = $attribute['value'];
    }

    // Récupérer le nom de la catégorie
    $category = $wpdb->get_row("SELECT name
                                FROM wp_itemmaison_value 
                                Join wp_itemmaison_categorie 
                                ON wp_itemmaison_categorie.id = wp_itemmaison_value.value
                                WHERE wp_itemmaison_value.attribute_id = 7 AND entity_id = {$id_product}
                                ");
    
    // Récupérer le nom du statut
    $statut = $wpdb->get_row("SELECT name
                                FROM wp_itemmaison_value 
                                Join wp_itemmaison_categorie 
                                ON wp_itemmaison_categorie.id = wp_itemmaison_value.value
                                WHERE wp_itemmaison_value.attribute_id = 8 AND entity_id = {$id_product}
                                ");

    // Récupérer les pointures
    $pointe = $wpdb->get_results("SELECT value
    FROM wp_itemmaison_value 
    WHERE wp_itemmaison_value.attribute_id = 5 AND entity_id = {$id_product}
    ");  
    
    // Récupérer les couleurs
    $color = $wpdb->get_results("SELECT value
    FROM wp_itemmaison_value 
    WHERE wp_itemmaison_value.attribute_id = 6 AND entity_id = {$id_product}
    ");
       $prix=$attributesById[3];      
// error_log(print_r($pointe,1));

echo "<div class='container'>";
    echo "<div class='tetemin'>
            <p>{$statut->name}</p>
            <button class='coeur' name='coeur{$id_product}'><img src='http://localhost/Sacapuce/wp-content/uploads/2023/06/like.svg'></button>";
            if (isset($_POST["coeur{$id_product}"])) {
                add_coeur($id_product);
            }
        echo "</div>";
    echo "<div class='tetemoy'>
    <form method='post'>
    <button class='coeur' name='bigview{$id_product}'>
    <img src='{$attributesById[2]}'width='150px' height='150px alt='{$attributesById[1]}'/></button></form>
        </div>";
    echo "<div class='tetebas'>
            <p>{$attributesById[1]}</p>
            <p>{$prix}€</p>
        </div>";
    echo "<div class='teteinf'>
            <p>Pointure :";    
            foreach ($pointe as $pointure){
            echo " {$pointure->value}&nbsp ";}"</p>
        </div>";
    echo "<div><form method='post'><button type='submit' id='{$id_product}' class='addcart' name='removecart{$id_product}'> Enlever du panier </button></form></div>";
echo "</div>";
        if (isset($_POST["removecart{$id_product}"])) {
            remove_cart($id_product);
        }
    }
    
}
function remove_cart($id_product){
    global $wpdb;
        
         $wpdb->query(
            $wpdb->prepare( "UPDATE wp_itemmaison_entity SET statut = 0 WHERE wp_itemmaison_entity.id = $id_product" )
        );  
        
}

function show_all(){
        // error_log("coucou");
    global $wpdb;
    $entity = $wpdb->get_results("SELECT id FROM wp_itemmaison_entity");
        // error_log(print_r ($entity,1));
    echo "<div class='boutiflex'>";
    foreach ($entity as $idto){
        display_product($idto->id); 
    
    echo "</div>";}
    
}
function big_view($id_product) {
    global $wpdb;

    // Récupérer les données de l'entité
    $entity = $wpdb->get_row("SELECT * FROM wp_itemmaison_entity WHERE id = {$id_product}", ARRAY_A);
    if (!$entity) {
        echo "Produit non trouvé";
        return;
    }

    // Récupérer les valeurs des attributs
    $attributes = $wpdb->get_results("SELECT * FROM wp_itemmaison_value WHERE entity_id = {$id_product}", ARRAY_A);

    // Organiser les attributs par leur identifiant
    $attributesById = [];
    foreach ($attributes as $attribute) {
        $attributesById[$attribute['attribute_id']] = $attribute['value'];
    }

    // Récupérer le nom de la catégorie
    $category = $wpdb->get_row("SELECT name
                                FROM wp_itemmaison_value 
                                Join wp_itemmaison_categorie 
                                ON wp_itemmaison_categorie.id = wp_itemmaison_value.value
                                WHERE wp_itemmaison_value.attribute_id = 7 AND entity_id = {$id_product}
                                ");
    
    // Récupérer le nom du statut
    $statut = $wpdb->get_row("SELECT name
                                FROM wp_itemmaison_value 
                                Join wp_itemmaison_categorie 
                                ON wp_itemmaison_categorie.id = wp_itemmaison_value.value
                                WHERE wp_itemmaison_value.attribute_id = 8 AND entity_id = {$id_product}
                                ");

    // Récupérer les pointures
    $pointe = $wpdb->get_results("SELECT value
    FROM wp_itemmaison_value 
    WHERE wp_itemmaison_value.attribute_id = 5 AND entity_id = {$id_product}
    ");  
    
    // Récupérer les couleurs
    $color = $wpdb->get_results("SELECT value
    FROM wp_itemmaison_value 
    WHERE wp_itemmaison_value.attribute_id = 6 AND entity_id = {$id_product}
    ");
                
// error_log(print_r($pointe,1));
echo "<div class='container2'>";
echo "<div class='champ1'><img src='{$attributesById[2]}' alt='{$attributesById[1]}'/></div>";
echo "<div class='champ2'>";
echo "<form method='post'><button class='coeur' name='coeur{$id_product}'><img src='http://localhost/Sacapuce/wp-content/uploads/2023/06/like.svg'></button>";
if (isset($_POST["coeur{$id_product}"])) {
    add_coeur($id_product);
}
    
    echo "<p>{$attributesById[1]}</p> ";
    echo "<p>{$attributesById[3]} €</p>";
    echo "<p>";
        foreach ($color as $colors){
        echo "{$colors->value} ";}
        echo "</p>";
        echo "<p>";
        foreach ($pointe as $pointure){
        echo "{$pointure->value} ";}
        echo "</p>";
echo "<p>{$attributesById[4]}</p>";

echo "<p>{$category->name}</p>";
echo "<p>{$statut->name}</p>";
echo "<button type='submit' id='{$id_product}' class='addcart' name='addcart{$id_product}'> Ajouter au panier </button>";
echo "<button type='submit' class='addcart' name='retour'> Retourner à la boutique </button></form></div>";
echo "</div>";
if (isset($_POST["retour"])) {
    display_product($id_product);
}

if (isset($_POST["addcart{$id_product}"])) {
    add_cart($id_product);
}
}
function purchase(){
    global $wpdb;
    $prix = $wpdb->get_results(
"SELECT value 
FROM wp_itemmaison_entity 
JOIN wp_itemmaison_value 
ON wp_itemmaison_entity.id = wp_itemmaison_value.entity_id
WHERE wp_itemmaison_entity.statut = 1 AND wp_itemmaison_value.attribute_id = 3
");
// var_dump($prix);
$somme = 0;
foreach ($prix as $index => $data){
    $somme += (int)$data->value;  
}
echo "<div class='fin'><div> Le montant total est de : ". $somme ." € </div><br>";
echo "<div><form><button type='submit' class='addcart' name='payer'> Finaliser vos achats </button></form></div></div>";
}
?>