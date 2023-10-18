<?php
/**
 * Template Name: Team
 * The template for displaying main "team" page.
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
$context['team'] = Timber::get_posts('post_type=team&posts_per_page=-1');
$context['options'] = get_fields('options');
Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page-team.twig' ), $context );
