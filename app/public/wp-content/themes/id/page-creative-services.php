<?php
/**
 * Template Name: Creative Services (New)
 * The template for displaying Audit landing page.
 * 
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

 $context = Timber::context();

 $timber_post     = new Timber\Post();
 global  $woocommerce;
 $context['post'] = $timber_post;
 $context['options'] = get_fields('options');
 $context['currency'] = get_woocommerce_currency_symbol(); //get_option('woocommerce_currency');

 Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page-creative.twig' ), $context );
 