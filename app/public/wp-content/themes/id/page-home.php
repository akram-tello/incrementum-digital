<?php
/**
 * Template Name: Home Page
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
$context['options'] = get_fields('option');
$context['cases'] = Timber::get_posts('post_type=case-studies');
// $context['cases'] = Timber::get_posts('post_type=case-studies');
Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page.twig' ), $context );
