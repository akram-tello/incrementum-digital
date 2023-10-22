<?php
/**
 * Template Name: Home Page
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

// Get the global context
$context = \Timber\Timber::context();

// Get the current post
$timber_post = \Timber\Timber::get_post(); 
$context['post'] = $timber_post;
$context['options'] = get_fields('option');


// Get other posts
$args1 = array(
    'post_type' => 'post',
);
$context['posts'] = \Timber\Timber::get_posts($args1);

// Get case studies
$args2 = array(
    'post_type' => 'case-studies',
);
$context['cases'] = \Timber\Timber::get_posts($args2);

// Render the view
\Timber\Timber::render(array('page-' . $timber_post->post_name . '.twig', 'page.twig'), $context);
