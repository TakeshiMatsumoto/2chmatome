<?php 
/****************************************

	page.php
	
	固定ページを表示するための
	テンプレートファイルです。

*****************************************/

get_header(); ?>
<!-- page.php -->
<div id="main">
<?php 
	if (have_posts()) :
		while (have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
				<?php the_content(); ?>
			</div>
		<?php
		endwhile;
	else :
	?>
			<div class="post page">
				<h2>ページがありません</h2>
				<p>お探しのページは見つかりませんでした。</p>
			</div>
	<?php 
	endif; 
	?>
</div>
<!-- /main -->
<!-- /page.php -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>