#!/usr/local/bin/php -q
<?php

require_once("/var/www/htdocs/wordpress/simple/simple_html_dom.php");
require_once(  '/var/www/htdocs/wordpress/wp-load.php' );
require_once(  '/var/www/htdocs/wordpress/db/dbpass.php' );

$resNumberCount=0;

$html = file_get_html( 'http://2ch-ranking.net/' );//ニュー速のランキングサイト

foreach ($html->find('.res') as $ResNum) {//レス数一覧を格納

	$resnumber[$resNumberCount++]=$ResNum->plaintext;

}

$titleCount=0;

foreach ($html->find('.title') as $title) {//スレタイ一覧を格納
		$titleArray[$titleCount++]=$title->plaintext;
	}

$titleUrlCount=0;

$titleUrlArray=array();//スレをurlを格納する配列

foreach ($html->find('.title a') as $title) {//スレのurl一覧を格納
	$titleUrlArray[$titleUrlCount++]=$title->href;
	}



try{
	$db= new PDO('mysql:host='.$db['host'].';dbname='.$db['dbname'].';charset=utf8',$db['user'],$db['passwd']);
}
	catch(PDOExeption $e)
{
	die('エラーメッセージ'.$e->getMessage());	
}


   $threadTitle;//スレタイ
   $titleCount=0;
   $titleConfirm=0;//タイトルがどれともかぶっていなかったら１になる
   $roopCount=0;

for ($i=0; $i < Count($titleArray); $i++) {//抜き出したスレが今まで抜き出したスレとかぶっていないか調べる

	$dbThreadTitle=$db->query('SET NAMES utf8');
	$dbThreadTitle=$db->prepare('SELECT * FROM wp_posts ');
	$dbThreadTitle->execute();

	while ($dbThreadTitleResult = $dbThreadTitle->fetch()) {

		if($titleArray[$i]!=$dbThreadTitleResult['post_title']){//抜き出したいスレタイが既存のスレとかぶってなかったら
	       	$threadTitle=$titleArray[$i];//スレタイに格納
	    		$titleConfirm=1;
 	    }else{  //既存の記事とかぶっていたらループ強制終了
	    		$dbThreadTitle->closeCursor();
	    		$titleConfirm=0;
	   		break;
 	     }
          


	}

	 if($resnumber[$i]>1000||$resnumber[$i]<500){	//レスが500以下、もしくは1000以上ならそのスレは抜かない
                 $titleConfirm=0;
}

	$roopCount++;
	
	if($roopCount>50){//過去の記事を50記事分検索、照合したらループ終了
	    
            break;

            }

           if($titleConfirm==1){//抜くスレが決まっていたら、ループ終了
           	break;
			
          }
}


for ($m=0; $m < Count($titleArray); $m++) { //抜き出したいスレのurlを抜く。スレタイとスレのurlの添字は一致している。
	
	if($threadTitle==$titleArray[$m])
	{

		$targetUrl=$titleUrlArray[$m];
		
	}
	
}

$str = $targetUrl;//文字列
$cut = 8;//カットしたい文字数
$targetUrl = substr( $str , 0 , strlen($str)-$cut );//urlのうしろについている余分なものを削除



$html = file_get_html($targetUrl);//抜きたいスレのurlからhtmlを引っ張ってくる

$resDt=array();//resのdt要素。書き込み主の名前などがある場所
$resDd=array();//redのｄｄ要素。レスの内容自体。

$resDtCount=0;

foreach ($html->find('dt') as $dt) {//dt要素抜きだし　

    $resDt[$resDtCount++]=$dt->plaintext;
				   }
		
$ResDdCount=0;

foreach ($html->find('dd') as $dd) {//dd要素抜き出し
	
    $resDd[ResDdCount++]=$dd->plaintext."</br>";
				   
	}
		

$resAnkar=array();//レスアンカー先の番号が入っている。
$resAnkarContainer=array();//レスアンカーが含まれているレスの番号が入っている
$resAnkarCount=0;



foreach ($html->find('.bi a') as $a) {

    $resAnkarContainer[$resAnkarCount]=substr($a->parent()->parent()->id, 7)-1;//レスアンカーを含むレス
    $resAnkar[$resAnkarContainer[$resAnkarCount++]]=intval(substr($a->plaintext, 8))-1;//レスアンカーを含むレスの番号をキーにレスアンカー先を格納


	}


$omitRes=range(0, 500);//抜き出すレス
shuffle($omitRes);//ランダムに抜き出すためにシャッフル
$resConfirm=array();//確定した抜き出すレス

$functionCount=0;

function resAnkarCheck(&$omitRes,&$resConfirm,$resAnkarContainer,$resAnkar,&$resCount)//レスを抜き出すための関数
{

    $Count=0;	
    $resAnkarflag=0;//レスアンカーを含むレスを抜き出したかどうか。１なら抜き出している
    $resAnkarres=array();//レスアンカー先のレスを格納

    for($i=0;$i<$resCount;$i++)//100個分抜き出す
{
	for ($n=0; $n <Count($resAnkarContainer) ; $n++) { 
		

		if($omitRes[$i]==$resAnkarContainer[$n]){//抜き出したレスがレスアンカーを含むレスかどうかを判定
			$resAnkarres[$Count++]=$resAnkar[$resAnkarContainer[$n]];//レスアンカー先を格納
			$resAnkarflag=1;
               
	}
	}
		array_push($resConfirm, $omitRes[$i]);//抜き出したレスを格納
	
}


	for ($i=0; $i < Count($resAnkarres); $i++) { //レスアンカー先のレスを格納
		array_push($resConfirm, $resAnkarres[$i]);
	}

$functionLimit=30;
if($functionCount>30)//resankarcheck関数を抜き出す回数に制限を設ける
{

$resAnkarflag=0;


}


if($resAnkarflag==1)//レスアンカーを含むレスを抜き出していたらもう一度、resAnkarCheckを呼び出す
{       $functionCount++;
	resAnkarCheck($resAnkarres,$resConfirm, $resAnkarContainer,$resAnkar,Count($resAnkarres));
}

}

$resCount=100;//100レス抜き出す
resAnkarCheck($omitRes,$resConfirm,$resAnkarContainer,$resAnkar,$resCount);


array_push($resConfirm, 0);//スレの１は必ず抜き出す

sort($resConfirm);
$postcontent;//wordpressに投稿する内容
$resConfirm=array_unique($resConfirm);//重複して抜き出しているレスがあったら削除


for ($i=0; $i < Count($omitRes); $i++) { //実際にレスを抽出し、wordpressに投稿するために変数に格納
		 
	if(isset($resDt[$resConfirm[$i]])&isset($resDd[$resConfirm[$i]]))
		 {
		 	$postcontent.=$resDt[$resConfirm[$i]]."</br></br>".$resDd[$resConfirm[$i]]."</br></br>";
			
		 }
		 
	 }


	 
  $my_post = array();
  $my_post['post_title'] = $threadTitle;
  $my_post['post_content'] = $postcontent;
  $my_post['post_status'] = 'publish';
  $my_post['post_author'] = 1;
  $my_post['post_category'] = array(8,39);
// データベースに投稿を追加