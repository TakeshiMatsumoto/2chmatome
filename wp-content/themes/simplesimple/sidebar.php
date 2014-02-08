<?php 
/****************************************

	sidebar.php
	
	サイドバーを表示するための
	テンプレートファイルです。
	
	sidebar.php のコードに関しては、
	CHAPTER 11 で詳しく解説しています。

*****************************************/
?>
<!-- sidebar.php -->
<!-- sidebar -->
<div id="sidebar">
	<div class="widget">
		<?php
		$args = array( 
			'posts_per_page'=> 3, 
		);
		$my_query = new WP_Query($args);
		if ( $my_query -> have_posts( ) ): /* サブループ開始 */
		?>
			<ul id="sidebar-recent-posts" class="sidebar-posts">
			<?php
			while ($my_query -> have_posts()) : $my_query -> the_post(); // 繰り返し処理開始
			?>


<li class="clearfix">
<div class="sidebar-recent-posts-title">
<h3><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h3>	
<p class="sidebar-date"><?php echo get_the_date(); ?></p>
<p class="sidebar-comment-num"><?php comments_popup_link('comment : 0','comment : 1','comment : %'); ?></p>
</div>	

<p class="sidebar-thumbnail-box">
  <a href="<?php the_permalink()?>" title="<?php  the_title(); ?>の続きを読む"></a>	
<?php
if(has_post_thumbnail()):
	the_post_thumbnail(array(75,75));
	?>
<?php 
endif;
?>

</a>
</p>
</li>

<?php
 endwhile;
?>
	
</ul>


</p>
	

</ul>
<?php
endif;
?>
<?php wp_reset_postdata();?>
</div>

</li>
<?php if ( is_active_sidebar( 'sidebar-1' ) ) : // ウィジットがあったら表示　?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
		
<?php endif; ?>
</div></div>