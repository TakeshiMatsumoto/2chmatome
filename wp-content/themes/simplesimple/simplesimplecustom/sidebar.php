<?php 
/****************************************

	sidebar.php
	
	カスタマイズしたサイドバーです。
	（CHAPTER20）

*****************************************/
?>
<!-- sidebar.php -->
<!-- sidebar -->
<div id="sidebarleft">
	<!-- Recent Posts -->
	<div class="widget">
		<h2>Recent Posts</h2>
		<?php
		$args = array( 
			'posts_per_page'=> 3, 
		);
		$my_query = new WP_Query($args);
		if ( $my_query -> have_posts() ): /* サブループ開始 */
		?>
			<ul id="sidebar-recent-posts" class="sidebar-posts">
			<?php
			while ($my_query -> have_posts()) : $my_query -> the_post(); // 繰り返し処理開始
			?>
				<li class="clearfix">
					<div class="sidebar-recent-posts-title">
						<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
						<p class="sidebar-date"><?php echo get_the_date(); ?></p>
						<p class="sidebar-comment-num"><?php comments_popup_link('Comment : 0', 'Comment : 1', 'Comments : %'); ?></p>
					</div>
					<p class="sidebar-thumbnail-box">
						<a href="<?php the_permalink() ?>" title="「<?php the_title(); ?>」の続きを読む">
						<?php
						if (has_post_thumbnail()):
							the_post_thumbnail(array(75,75)); /* アイキャッチ画像 */
						else:
						?>
						<img src="<?php echo get_template_directory_uri(); ?>/images/noimage.gif"
width="75" height="75" alt="" />
						<?php
						endif;
						?>
						</a>
					</p>
				</li>
			<?php
			endwhile; // 繰り返し処理終了
			?>
			</ul>
	<?php
	endif; /* サブループ終了 */
	wp_reset_postdata(); 
	?>
	</div>
	
	<!-- Popular Posts -->
	<div class="widget">
		<h2>Popular Posts</h2>
		<?php
		$args = array( 
			'posts_per_page'=> 3,
			'orderby' => 'comment_count',
		);
		$my_query = new WP_Query($args);
		if ( $my_query -> have_posts() ): /* サブループ */
		?>
			<ul id="sidebar-recent-posts" class="sidebar-posts">
			<?php
			while ($my_query -> have_posts()) : $my_query -> the_post(); // 繰り返し処理開始
			?>
				<li class="clearfix">
					<div class="sidebar-recent-posts-title">
						<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
						<p class="sidebar-date"><?php echo get_the_date(); ?></p>
						<p class="sidebar-comment-num"><?php comments_popup_link('Comment : 0', 'Comment : 1', 'Comments : %'); ?></p>
					</div>
					<p class="sidebar-thumbnail-box">
						<a href="<?php the_permalink() ?>" title="「<?php the_title(); ?>」の続きを読む">
						<?php
						if (has_post_thumbnail()):
							the_post_thumbnail(array(75,75)); /* アイキャッチ画像 */
						else:
						?>
						<img src="<?php echo get_template_directory_uri(); ?>/images/noimage.gif"
width="75" height="75" alt="" />
						<?php
						endif;
						?>
						</a>
					</p>
				</li>
			<?php
			endwhile; // 繰り返し処理終了
			?>
			</ul>
	<?php
	endif; /* サブループ終了 */
	wp_reset_postdata(); 
	?>
	</div>
	
	<!-- Tag Cloud -->
	<div class="widget">
		<h2>Tag Cloud</h2>
		<?php
		$args = array(
			'smallest' => 14,
			'largest' => 18,
			'unit' => 'px',
			'number' => 0,
			'format' => 'flat',
			'taxonomy' => 'post_tag',
			'echo' => true,
		);
		?>
		<p class="tagcloud">
		<?php wp_tag_cloud($args); ?>
		</p>
	</div>


<?php if ( is_active_sidebar( 'sidebar-left' ) ) : // ウィジットがあったら表示　?>
		<?php dynamic_sidebar( 'sidebar-left' ); ?>
		
<?php endif; ?>
<!-- /sidebar -->
<!-- /sidebar.php -->