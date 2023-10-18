<?php
/**
 * Template Name: Media
 * The template for displaying main "In The Media" page.
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
$context['media'] = Timber::get_posts('category=media&posts_per_page=12');
$context['options'] = get_fields('options');
Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page-media.twig' ), $context );
