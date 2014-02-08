<?php
/****************************************
		
		ダミーのheader.php
		パンくずリストを直書きしています。
		(CHAPTER16)
          
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
<?php // ここからパンくずリスト
if ( !is_home() ):
?>
	<div id="breadcrumb" class="clearfix">
		<ul>
			<li><a href="<?php echo home_url('/'); ?>">HOME</a></li>
			<li>&gt;</li>
			<?php
				if ( is_search() ): /* 検索結果表示 */ ?>
					<li>「<?php the_search_query(); ?>」で検索した結果</li>
				<?php
				elseif ( is_tag() ): /* タグアーカイブ */ ?>
					<li>タグ : <?php single_tag_title(); ?></li>
				<?php
				elseif ( is_404() ): /* 404 Not Found */ ?>
					<li>404 Not found</li>
				<?php
				elseif ( is_date() ): /* 日付アーカイブ */
					if( is_day() ): /* 日別アーカイブ */ ?>
						<li><a href="<?php echo get_year_link( get_query_var('year') ); ?>">
							<?php echo get_query_var('year'); ?>年</a></li>
						<li>&gt;</li>
						<li><a href="<?php echo get_month_link( get_query_var('year'), get_query_var('monthnum') ); ?>">
							<?php echo get_query_var('monthnum'); ?>月</a></li>
						<li>&gt;</li>
						<li><?php echo get_query_var('day'); ?>日</li>
					<?php 
					elseif( is_month() ): /* 月別アーカイブ */ ?>
						<li><a href="<?php echo get_year_link( get_query_var('year') ); ?>">
							<?php echo get_query_var('year'); ?>年</a></li>
						<li>&gt;</li>
						<li><?php echo get_query_var('monthnum'); ?>月</li>
					<?php
					elseif( is_year() ): /* 年別アーカイブ */ ?>
						<li><?php echo get_query_var('year'); ?>年</li>
					<?php 
					endif;
				elseif ( is_category() ): /* カテゴリーアーカイブ */ 
					$cat = get_queried_object();
					if ($cat -> parent != 0):
						$ancestors = array_reverse( get_ancestors( $cat -> cat_ID, 'category' ) );
						foreach($ancestors as $ancestor): ?>
							<li><a href="<?php echo get_category_link($ancestor); ?>">
								<?php echo get_cat_name($ancestor); ?></a></li>
							<li>&gt;</li>
						<?php
						endforeach; 
					endif;
					?>
					<li><?php echo $cat -> cat_name; ?></li>
				<?php
				elseif ( is_author() ): /* 投稿者アーカイブ */ ?>
					<li>投稿者 : <?php the_author_meta( 'display_name', get_query_var('author') ); ?></li>
				<?php 
				elseif ( is_page() ): /* 固定ページ */
					if ( $post -> post_parent != 0 ):
						$ancestors = array_reverse( $post-> ancestors );
						foreach($ancestors as $ancestor): ?>
							<li><a href="<?php echo get_permalink($ancestor); ?>">
								<?php echo get_the_title($ancestor); ?></a></li>
							<li>&gt;</li>
						<?php
						endforeach;
					endif;
					?>
					<li><?php echo $post -> post_title; ?></li>
				<?php 
				elseif ( is_attachment() ): /* 添付ファイルページ */
					if ($post -> post_parent != 0 ): ?>
						<li><a href="<?php echo get_permalink($post->post_parent); ?>">
							<?php echo get_the_title($post->post_parent); ?></a></li>
						<li>&gt;</li>
					<?php 
					endif;
					?>
						<li><?php echo $post->post_title; ?></li>
				<?php 
				elseif ( is_single() ): /* ブログ記事 */
					$categories = get_the_category($post->ID);
					$cat = $categories[0];
					if ( $cat -> parent != 0 ):
						$ancestors = array_reverse( get_ancestors($cat -> cat_ID, 'category' ) );
						foreach ($ancestors as $ancestor): ?>
							<li><a href="<?php echo get_category_link($ancestor); ?>">
								<?php echo get_cat_name($ancestor); ?></a></li>
							<li>&gt;</li>
						<?php
						endforeach;
					endif;
					?>
					<li><a href="<?php echo get_category_link($cat -> cat_ID); ?>">
					<?php echo $cat-> cat_name; ?></a></li>
					<li>&gt;</li>
					<li><?php echo $post -> post_title; ?></li>
				<?php
				else: /* 上記以外 */ ?>
					<li><?php wp_title('', true); ?></li>
				<?php
				endif;
			?>
		</ul>
	</div>
<?php
endif;
?>
<?php // ここからヘッダー画像
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