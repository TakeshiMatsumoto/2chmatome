<?php 
/****************************************

	index.php
	
	WordPressサイトには、なくてはならない
	テンプレートファイルです。
	
	index.php のコードに関しては、
	CHAPTER 9 で詳しく解説しています。

*****************************************/

get_header(); ?>
<!-- index.php -->

<div id="main">
	<?php 
	if (have_posts()) : // WordPress ループ
		while (have_posts()) : the_post(); // 繰り返し処理開始 ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="content-box">
				<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
				<p class="post-meta">
					<span class="post-date"><?php the_date(); /* echo get_the_date() に書き換える（CHAPTER 9） */ ?></span>
					<span class="category">Category - <?php the_category(', ') ?></span>
					<span class="comment-num"><?php comments_popup_link('Comment : 0', 'Comment : 1', 'Comments : %'); ?></span>
				</p>
				<?php the_excerpt();?>
				
				<?php the_content('続きを読む &raquo;', true); ?>
				</div>
				<p class="thumbnail-box"><?php the_post_thumbnail("thumbnail");
					?></p>
			</div>
		<?php 
		endwhile; // 繰り返し処理終了		
	else : // ここから記事が見つからなかった場合の処理 ?>
			<div class="post">
				<h2>記事はありません</h2>
				<p>お探しの記事は見つかりませんでした。</p>
			</div>
	<?php
	endif;
		
	if ( $wp_query->max_num_pages > 1 ) : // ここからページャー ?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; PREV'); ?></div>
			<div class="alignright"><?php previous_posts_link('NEXT &raquo;'); ?></div>
		</div>
	<?php 
	endif; // ページャーここまで
	?>
	
</div><!-- /main -->
<!-- / index.php -->
<?php get_sidebar(); ?>
<?php get_sidebar('left'); ?>
<?php get_footer(); ?>