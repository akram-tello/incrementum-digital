<?php
/**
 * Template Name: A/B Testing
 * The template for displaying A/B Testing landing page.
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
 Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page-abtesting.twig' ), $context );
 