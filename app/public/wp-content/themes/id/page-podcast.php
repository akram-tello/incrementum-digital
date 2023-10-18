<?php
/**
 * Template Name: Podcast
 * The template for displaying main "podcast" page.
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
$context['podcast'] = Timber::get_posts('post_type=podcast&posts_per_page=8');
$context['options'] = get_fields('options');
Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page-podcast.twig' ), $context );
