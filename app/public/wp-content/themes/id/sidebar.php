<?php
/**
 * The Template for the sidebar containing the main widget area
 *
 * @package  WordPress
 * @subpackage  Timber
 */

// $context['dynamic_sidebar'] = Timber::get_widgets('dynamic_sidebar');
$context['dynamic_sidebar'] = Timber::get_widgets('blog_sidebar');
Timber::render( array( 'sidebar.twig' ), $context );