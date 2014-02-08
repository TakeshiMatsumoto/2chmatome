<?php
/****************************************

	searchform.php
	検索フォーム部分のテンプレートファイルです。

*****************************************/
?>
<!-- searchform.php -->
<form method="get" id="searchform" action="<?php echo home_url('/'); ?>" >
	<input type="text" placeholder="検索" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="" />
</form>
<!-- /searchform.php -->