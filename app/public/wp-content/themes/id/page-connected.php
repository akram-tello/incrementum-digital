<?php
/**
 * Template Name: Get Connected
 * The template for displaying Get Connected landing page.
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

 $cat_args = array(
    'orderby'    => 'name',
    'order'      => 'asc',
    'hide_empty' => true
);

 $context['work_cat'] = Timber::get_terms( 'work-catergory', $cat_args );

 Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page-connected.twig' ), $context );
 