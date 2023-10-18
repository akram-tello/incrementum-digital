<?php
/**
 * Template Name: Resources
 * The template for displaying Resources landing page.
 * 
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();
$timber_post     = new Timber\Post();
$context['post'] = $timber_post;

// get latest three posts
$args = array(
    'posts_per_page' => 3
);
$context['posts'] = Timber::get_posts($args);
$context['podcast'] = Timber::get_posts('post_type=podcast&numberposts=1');
$context['options'] = get_fields('options');
Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page-resources.twig' ), $context );
