<?php
/****************************************
		
		header.php
          
*****************************************/
?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<title>
<?php
if ( !is_front_page() ){
	wp_title('::', true, 'right');
}
bloginfo('name'); 
?>
</title>
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" />
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" media="screen" />
<link href="http://fonts.googleapis.com/css?family=Josefin+Sans:400,600,700" rel="stylesheet" />
<?php 
if ( is_singular() ) {
	wp_enqueue_script( "comment-reply" );
}
?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="container">
<!-- header -->
<div id="header" class="clearfix">
	<div class="alignleft">
		<h1 id="logo"><a href="<?php echo home_url('/'); ?>"><span><?php bloginfo('name'); ?></span></a></h1>
		<p id="description"><?php bloginfo('description'); ?></p>
	</div>
	<div class="alignright">
		<?php get_search_form(); ?>
	</div>
	<?php wp_nav_menu( 'theme_location = header-navi' ); ?>
</div>
<?php // ここからパンくずリスト（CHAPTER16）
breadcrumb();
?>
<?php // ここからヘッダー画像（CHAPTER15）
if( (is_home() && !is_paged() ) || is_page() ):
?>
<div id="header-image">
	<?php 
	if( is_page() && has_post_thumbnail($post -> ID) ):
		echo get_the_post_thumbnail($post ->ID, "header-image");
	else: 
	?>
		<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
	<?php 
	endif; 
	?>
</div>
<?php 
endif; 
?>
<!-- header -->
<!-- /header.php -->