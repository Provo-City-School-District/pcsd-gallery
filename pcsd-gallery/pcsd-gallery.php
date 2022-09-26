<?php
/*
  Plugin Name: PCSD Gallery
  Description: Gallery system for Wordpress Editor
  Version: 1.0
  Author: Josh Espinoza
  Author URI: tech.provo.edu
*/
include('pcsd-gallery-fields.php');
function pcsd_gallery_enqueue(){
    wp_enqueue_style('plugin-styles', plugins_url('pcsd-gallery/pcsd-gallery-styles.css'));
}
add_action( 'wp_enqueue_scripts', 'pcsd_gallery_enqueue' );
function pcsd_gallery($content) {
    if(!is_admin()){
        //    echo '<article>';
        echo $content;
       // echo '</article>';
    }
    if(get_field('gallery_images')){
        $pcsd_gallery_raw = get_field('gallery_images');
        $pcsd_image_ids = array();
        foreach($pcsd_gallery_raw as $image) {
             //print_r($image);
            array_push($pcsd_image_ids, $image['image']);
        }
        $columns = count($pcsd_image_ids);
        $pcsd_id_prep = implode(',', $pcsd_image_ids);
        echo do_shortcode('[gallery columns="'.$columns.'" link="file" size="medium" ids="'.$pcsd_id_prep.'"]');

    }
}
add_filter('the_content', 'pcsd_gallery', 100);
?>
