<?php
/****************************************
		
	header.php
	
	Webサイトのヘッダー部分を表示するための
	テンプレートファイルです。
		
	header.php のコードについては、
	CHAPTER 8 で詳しく説明しています。
          
*****************************************/
?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<title>
<?php
if ( is_single() /* !is_front_page() に書き換えよう！（CHAPTER 8） */ ){
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
// コメント欄をポップアップで表示したいなら、下記を有効にする
//comments_popup_script();
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
<!-- header -->
<!-- /header.php -->