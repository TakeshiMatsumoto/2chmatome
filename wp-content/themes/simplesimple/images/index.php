<?php 
/****************************************

	index.php
	
	アイキャッチ画像と抜粋でレイアウトしています。
	（CHAPTER14）

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
						<span class="post-date"><?php echo get_the_date(); ?></span>
						<span class="category">Category - <?php the_category(', ') ?></span>
						<span class="comment-num"><?php comments_popup_link('Comment : 0', 'Comment : 1', 'Comments : %'); ?></span>
					</p>
					<?php the_excerpt(); // 抜粋（CHAPTER 14） ?>
	
					<?php // 続きを読むリンク ?>
					<p class="more-link">
						<a href="<?php the_permalink() ?>" title="「<?php the_title(); ?>」の続きを読む">続きを読む &raquo;</a>
					</p>
				</div>
				<?php // アイキャッチ画像（CHAPTER 14）  ?>
				<p class="thumbnail-box">
					<?php 
					if(has_post_thumbnail()):
						the_post_thumbnail("thumbnail");
					else: ?>
						<img src="<?php echo get_template_directory_uri(); ?>/images/noimage.gif" alt="" />
					<?php 
					endif; 
					?>
				</p>
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
<?php get_footer(); ?>