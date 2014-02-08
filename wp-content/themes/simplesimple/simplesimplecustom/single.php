<?php 
/****************************************

	single.php
	
	カスタマイズした single.php

*****************************************/

get_header(); ?>
<!-- single.php -->
<div id="main">

	<?php 
	if (have_posts()) : // WordPress ループ
		while (have_posts()) : the_post(); // 繰り返し処理開始 ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
				<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
				<p class="post-meta">
					<span class="post-date"><?php echo get_the_date(); ?></span>
					<span class="category">Category - <?php the_category(', ') ?></span>
					<span class="comment-num"><?php comments_popup_link('Comment : 0', 'Comment : 1', 'Comments : %'); ?></span>
				</p>
					
				<?php the_content();
				
				$args = array(
					'before' => '<div class="page-link">',
					'after' => '</div>',
					'link_before' => '<span>',
					'link_after' => '</span>',
				);
				wp_link_pages($args); ?>
					
				<p class="footer-post-meta">
					<?php the_tags('Tag : ',', '); ?>
					<span class="post-author">作成者 : <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span>
				</p>
			</div>
				
			<div class="navigation"><!-- ページャー -->
				<?php 
				if(get_previous_post()): ?>
					<div class="alignleft"><?php previous_post_link('%link', '&laquo; %title'); ?></div>
				<?php 
				endif;
				
				if(get_next_post()): ?>
					<div class="alignright"><?php next_post_link('%link', '%title &raquo;'); ?></div>
				<?php 
				endif; 
				?>
			</div><!-- /ページャー -->
			
			<?php // ここから関連記事の表示（CHAPTER17）
			// カテゴリーIDの取得
			$categories = get_the_category($post->ID);
			$category_ID = array();
			foreach($categories as $category):
				array_push( $category_ID, $category -> cat_ID);
			endforeach ;
			
			// WordPressオブジェクトの作成
			$args = array(
				'post__not_in' => array($post -> ID),
				'category__in' => $category_ID,
				'posts_per_page'=> 3,
				'orderby' => 'rand',
			);
			$my_query = new WP_Query($args); ?>
			
			<div class="related-posts">
				<h3 id="related">Related Posts</h3>
				<?php
				if( $my_query -> have_posts() ): // サブループ ?>
					<ul id="related-posts">
					<?php
					while ($my_query -> have_posts()) : $my_query -> the_post(); // 繰り返し処理 ?>
						<li class="clearfix">
							<div class="content-box">
								<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
								<p class="date"><?php echo get_the_date(); ?></p>
								<p><?php echo get_post_meta($post -> ID, 'short_description',true); ?></p>
							</div>
							<p class="thumbnail-box">
								<a href = "<?php the_permalink() ?>" title = "「<?php the_title(); ?>」の続きを読む">
									<?php
									if ( has_post_thumbnail() ):
										the_post_thumbnail( array(100,100) );
									else:
									?>
									<img src = "<?php echo get_template_directory_uri(); ?>/images/noimage.gif" width = "100" height="100" alt="" />
									<?php
									endif;
									?>
								</a>
							</p>
						</li>
					<?php
					endwhile; // サブループの繰り返し処理終了
					?>
					</ul>
				<?php 
				else:
				?>
					<p>関連する記事はありませんでした ...</p>
				<?php
				endif; // サブループ終了
				wp_reset_postdata();
				?>
			</div><!-- /related-posts -->
			
			<?php
			comments_template(); // コメント欄の表示（CHAPTER19）
				
		endwhile; // WordPressループの繰り返し終了
	else : 
	?>
		<div class="post">
			<h2>記事はありません</h2>
			<p>お探しの記事は見つかりませんでした。</p>
		</div>
	<?php 
	endif; // WordPressループの終了
	?>

</div><!-- /main -->
<!-- /single.php -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>