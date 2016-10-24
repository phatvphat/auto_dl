<meta charset="utf-8" />
<?php
if($_POST)
{
	$img = $_POST['img'];
function get_cont($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_FAILONERROR, 0);
    $data = curl_exec($ch);
    curl_close($ch);
	return $data;
}
function save_img($img)
{
	if(preg_match('/.jpg/i',$img))
	{
		$extension = '.jpg';
	}
	if(preg_match('/.jpeg/i',$img))
	{
		$extension = '.jpeg';
	}
	if(preg_match('/.png/i',$img))
	{
		$extension = '.png';
	}
	else
	{
		$extension = '.jpg';
	}
	if(get_cont($img))
	{
		$data = get_cont($img);
		if(!is_dir('data/'))
		{
			mkdir('data/');
		}
		$file = 'data/'.md5(time()).$extension;
		$image = fopen($file,'w+');
		fwrite($image,$data);
		fclose($image);
		if(file_exists($file))
		{
			$r = 2;
		}
		else
		{
			$r = 1;
		}
	}
	else
	{
		$r = 0;
	}
return $r;
}
	if($img != null)
	{
		$fp = fopen("links.txt","w+");
		fwrite($fp,preg_replace("/[0-9].bp.blogspot.com/i","lh4.googleusercontent.com",$img));
		fclose($fp);
	}
	$myfile = fopen("links.txt", "r") or die("Unable to open file!");
	$num = 0;
	while(!feof($myfile))
	{
		$link = fgets($myfile);
		$link = trim($link);
		$num++;
		$save_img = save_img($link);
		if($save_img == 0)
		{
			echo $num.'. Link ko có: '.$link;
			echo '<br>';
		}
		else if($save_img == 1)
		{
			echo $num.'. Thất bại: '.$link;
			echo '<br>';
		}
		else if($save_img == 2)
		{
			echo $num.'. Lưu thành công: '.$link;
			echo '<br>';
		}
	}
	fclose($myfile);
}
?>
<form method="post">
	<textarea name="img"></textarea><br>
	<input name="submit" type="submit" />
</form>
