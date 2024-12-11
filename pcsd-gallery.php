<?php
/*
  Plugin Name: PCSD Gallery
  Description: Gallery system for Wordpress Editor
  Version: 1.0.1
  Author: Josh Espinoza
  Author URI: tech.provo.edu
*/
include('pcsd-gallery-fields.php');
function pcsd_gallery_enqueue()
{
    wp_enqueue_style('plugin-styles', plugins_url('pcsd-gallery/pcsd-gallery-styles.css'));
}
add_action('wp_enqueue_scripts', 'pcsd_gallery_enqueue');
function pcsd_gallery($content)
{
    if (!is_admin()) {
        echo $content;
    }
    wp_reset_query();

    if (get_field('choose_gallery') != "off") {
        if (get_field('choose_gallery') == "image") {
            $pcsd_gallery_raw = get_field('gallery_images');
            $pcsd_image_ids = array();
            foreach ($pcsd_gallery_raw as $image) {
                //print_r($image);
                array_push($pcsd_image_ids, $image['image']);
            }
            $columns = count($pcsd_image_ids);
            if ($columns > 0) {
                $pcsd_id_prep = implode(',', $pcsd_image_ids);
                echo do_shortcode('[gallery columns="' . $columns . '" link="file" size="medium" ids="' . $pcsd_id_prep . '" group="gallery"]');
            }
        }
        if (get_field('choose_gallery') == "video") {
            $pcsd_gallery_raw = get_field('video_playlist');
            $pcsd_image_ids = array();
            foreach ($pcsd_gallery_raw as $image) {
                //print_r($image);
                array_push($pcsd_image_ids, $image['video_file']);
            }
            // $columns = count($pcsd_image_ids);
            $pcsd_id_prep = implode(',', $pcsd_image_ids);
            echo do_shortcode('[playlist type="video" ids="' . $pcsd_id_prep . '"]');
        }
    }
}
add_filter('the_content', 'pcsd_gallery', 100);
