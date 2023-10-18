<?php
/**
 * Template Name: Services in Beta
 * The template for displaying main "Services in BEeta" page.
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
$context['options'] = get_fields('options');
Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page-services-beta.twig' ), $context );
