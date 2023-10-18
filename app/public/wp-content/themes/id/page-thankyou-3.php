<?php
/**
 * Template Name: Thank You Page - 2
 * The template for displaying Audit Thank You 2 landing page.
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
 Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page-thankyou-3.twig' ), $context );
 