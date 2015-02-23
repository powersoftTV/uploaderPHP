<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>image uploader</title>

<style>

div.type1{
	width:800px;
	text-align:center;
	position:relative;
}

table.type1{
	text-align:end;
	padding:5px;
	text-align:center;
}


div.type6{
	width:1000px;
	background:#999;
	padding:10px;
	height:800px;	
	text-align:center;
	position:relative;
	margin-right:auto;
	margin-top:5px;
	margin-left:auto;
	-moz-border-radius: 20px; /* Mozilla */
	border-radius: 20px; /* Chrome, Safari, Opera ... */
	}
table.type10{
	display:block;
	padding:5px;
	color:#fff;
	background:#555;
	text-decoration:none;
	text-shadow:1px 1px 1px rgba(0,0,0,0.75); /* Тень текста, чтобы приподнять его на немного */
	-moz-border-radius:20px;
	-webkit-border-radius:2px;
	border-radius:20px;
}
nav{
	float:left;
	
	list-style:none;
	font-weight:bold;
	margin-bottom:10px;
}


#nav li a{
	display:block;
	padding:5px;
	color:#fff;
	background:#666;
	text-decoration:none;
	
	text-shadow:1px 1px 1px rgba(0,0,0,0.75); /* Тень текста, чтобы приподнять его на немного */
	-moz-border-radius:2px;
	-webkit-border-radius:2px;
	border-radius:2px;
}
#nav li a:hover{
	color:#fff;
	background:#6b0c36;
	background:rgba(107,12,54,0.75); /* Выглядит полупрозрачным */
	text-decoration:underline;
}

body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td{
	margin:0;
	padding:0;
}
li {
    list-style-type: none;}

#navv li a:hover{
	color:#fff;
	background:#F00;
	background:rgba(255,00,00,0.75); /* Выглядит полупрозрачным */
	text-decoration:underline;
}

navv{
	float:left;
	
	list-style:none;
	font-weight:bold;
	margin-bottom:10px;
}
#navv li a{
	display:block;
	padding:5px;
	color:#fff;
	background:#666;
	text-decoration:none;
	
	text-shadow:1px 1px 1px rgba(0,0,0,0.75); /* Тень текста, чтобы приподнять его на немного */
	-moz-border-radius:2px;
	-webkit-border-radius:2px;
	border-radius:2px;
}

</style>


</head>

<body>   

<?

date_default_timezone_set('Asia/Tbilisi');
$num=9;
$ord="date";
if(isset($_GET['order'])) $ord=$_GET['order'];
if(isset($_GET['desc'])) $des=$_GET['desc']; 
$dd=$_SERVER['PHP_SELF']."?order=".$ord."&desc=".$des;
if($_GET[p]){
	$page=$_GET[p];
	$start=$num*$page-$num;
}
else {
	$page=1;
	$start=0;
}
?>

<div class="type6"> 



<table align="center">
<tr>
	
	<td>
	<form action=<?=$dd?> method="post" enctype="multipart/form-data">
	<input type="file" name="media" value="browse" />
	</td>
    <td>
    <input type="submit" name="submit" value="upload" />
	</form>
    </td>
</tr>
<tr>
	
    <td>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="get">
    <? if(isset($_GET['order'])){
    	if($ord=="size"){
			?>
    <input type="radio" name="order" value="size" checked/>size 
    <input type="radio" name="order" value="date" />date 
    <input type="radio" name="order" value="name" />name
    	<? }
		if($ord=="name"){
			?>
    <input type="radio" name="order" value="size" />size 
    <input type="radio" name="order" value="date" />date 
    <input type="radio" name="order" value="name" checked/>name
    	<? }
		if($ord=="date"){
			?>
    <input type="radio" name="order" value="size" />size 
    <input type="radio" name="order" value="date" checked/>date 
    <input type="radio" name="order" value="name" />name
    	<? }
    }
	else {
		$ord="date";?>
    <input type="radio" name="order" value="size" />size 
    <input type="radio" name="order" value="date" checked/>date 
    <input type="radio" name="order" value="name" />name
    <? }
	if(isset($_GET['desc'])) { 
		if($des=="descending"){
			?>
    		<input type="checkbox" name="desc" value="descending" checked/>descending <? ;} 
		else {
			$des="";?> <input type="checkbox" name="desc" value="descending" />descending <? ;} }
	else {
		$des="";?> <input type="checkbox" name="desc" value="descending" />descending <? ;} ?>
    </td>
    <td>
    <input type="submit" name="ok" value="order" />
    </form>
    </td>
</tr> 
</table><br />

<?
function mythumbnails($x=100,$y=100,$path,$picture,$destin, $prefix){
	$im = @imagecreatefromjpeg($path.$picture);
	$ext="jpg";
	if ($im === false) {
		$im = @imagecreatefromgif($path.$picture);
		$ext="gif";
		if ($im === false) {
			$im = @imagecreatefrompng($path.$picture);
			$ext="png";
			}
		else {
			$ext=false;
			return false;
			}
		}
	if ($im){
	$size=array();
	$size=@getimagesize($path.$picture);
	$srcx= $size[0];
	$srcy= $size[1];
	if($srcx>$srcy){ 
		$dstx= $x;
		$dsty= $srcy/$srcx*$x;
		}
	else {
		$dsty= $y;
		$dstx= $srcx/$srcy*$y;
		}
	$dest = imagecreatetruecolor($dstx,$dsty);
	
	imagecopyresampled($dest, $im, 0, 0, 0 ,0, $dstx, $dsty, $srcx, $srcy);
	$verch=imagejpeg($dest,$destin.$prefix.$picture);
	if($verch) return $destin.$prefix.$picture;
	else return false;}
}
function mypagesnew($num,$page,$pages, $dest){?>
<table align="center">
<tr> <?
	echo "Страница ".$page." из "." ".$pages." ";
		 if($page==1){?>
         	 <td>
<ul id="nav">	
<li ><a><<<</a></li>
</ul>
</td>
         <? }
		 else {
			 ?>
             <td>
<ul id="nav">	
<li ><a href="<?=$dest?>p=<?=$page-1?>"><<<</a></li>
</ul>
</td>
         	
         <? }
		
		 for($i=1;$i<$pages+1;$i++){
			 
			 if($pages<12){
				 if($i==$page){ ?>
                 	<td>
					<ul id="nav">	
					 <a style="background-color:#FFF"><h2><?=$i ?></h2></a>
                     </ul>
					</td>
                 <? ; }
				 else {?>
                 <td>
<ul id="nav">	
<li ><a href="<?=$dest?>p=<?=$i?>"><?=$i ?></a></li>
</ul>
</td>
				 	
				 <? }
			  }
			  else {				  
				  if($page<7){
					if($i==$page){ ?>
                 	<td>
					<ul id="nav">	
					 <a style="background-color:#FFF"><h2><?=$i ?></h2></a>
                     </ul>
					</td>
                 <? ; }
					if(($i==1 && $i!=$page) || ($i==$pages && $page!=$pages) || ($i<10 && $i!=$page)){?>
                    <td>
<ul id="nav">	
<li ><a href="<?=$dest?>p=<?=$i?>"><?=$i ?></a></li>
</ul>
</td>
				 	 	<?	}
					if(($i==$page+4 && ($page+4 < $pages) && $page>5) || ($pages>10 && $i==10)){ ?>
                 	<td>
					<ul id="nav">	
					 <a>...</a>
                     </ul>
					</td>
                 <? ; }				 					 	
				 	}
				  elseif($page>$pages-6){
					 if($i==$page){ ?>
                 	<td>
					<ul id="nav">	
					 <a style="background-color:#FFF"><h2><?=$i ?></h2></a>
                     </ul>
					</td>
                 <? ; }
					if(($i==1 && $i!=$page) || ($i==$pages && $page!=$pages) || ($i>$pages-9 && $i!=$page)){?>
                       <td>
<ul id="nav">	
<li ><a href="<?=$dest?>p=<?=$i?>"><?=$i ?></a></li>
</ul>
</td>
				 	 	<?	}
					if(($i==$page-4 && ($page-4 < $pages) && $page<$pages-9) || ($pages>10 && $i==1)){ ?>
                 	<td>
					<ul id="nav">	
					 <a>...</a>
                     </ul>
					</td>
                 <? ; }				 	
				 	}	
				  else {
					if($i==$page){ ?>
                 	<td>
					<ul id="nav">	
					 <a style="background-color:#FFF"><h2><?=$i ?></h2></a>
                     </ul>
					</td>
                 <? ; }		
					if(($i==1 && $i!=$page) || ($i==$pages && $page!=$pages) || ($i>$page-4 && $i<$page+4 && $i!=$page)){?>
                     <td>
<ul id="nav">	
<li ><a href="<?=$dest?>p=<?=$i?>"><?=$i ?></a></li>
</ul>
</td>
				 		 	<? }				 
					if(($i==$page+3 && ($page+4 < $pages)) || ($i==$page-4) && ($page-4 > 1)){ ?>
                 	<td>
					<ul id="nav">	
					 <a>...</a>
                     </ul>
					</td>
                 <? ; }				 	
				 	  }
			  	}
		 }
		 if($page==$pages ||$page>$pages-1){?>
           <td>
<ul id="nav">	
<li ><a > >>></a></li>
</ul>
</td>
         <? ;}
		 else { 
		  ?>
          <td>
<ul id="nav">	
<li ><a href="<?=$dest?>p=<?=$page+1 ?>"> >>></a></li>
</ul>
</td>
        
         <? } ?>
         </tr>
</table> <?
}

$max_image_width = 1024;
$max_image_height = 1024;
$max_photo_size = 1024 * 1024;
$max_video_size = 4024 * 1024;
$valid_types = array("gif","jpg", "jpeg","JPG","JPEG", "GIF");

$valid_p_types = array("gif","jpg","JPG","JPEG", "GIF","jpeg");
$valid=array("gif","jpg","JPG","JPEG", "GIF","jpeg");
$path="uploads";
if(!is_dir($path)) mkdir($path) ; 
$pathdir="uploads/tumb";
if(!is_dir($pathdir)) mkdir($pathdir) ; 

if(isset($_GET['del'])){
	$delfile=$_GET['del'];
	$wextd= substr($delfile,0, strrpos($file, "."));
	if(file_exists($path."/".$delfile)) unlink($path."/".$delfile);
	if(file_exists($path."/tumb/".$delfile)) unlink($path."/tumb/".$delfile);
	if(file_exists($path."/".$wextd.".webm")) unlink($path."/".$wextd.".webm");
	}
if (isset($_FILES["media"])) {
					if (is_uploaded_file($_FILES['media']['tmp_name'])) {
						if(!is_dir($path)){
						if (!mkdir($path, 0755)) die('Не удалось создать директории...');}
						$filename = $_FILES['media']['tmp_name'];
						$ext = substr($_FILES['media']['name'],1 + strrpos($_FILES['media']['name'], "."));
						$media_link=$path."/".$_FILES['media']['name'];
						if (!in_array($ext, $valid_types)) $message= 'Error: Invalid media file type.';
						else {
								$size = GetImageSize($filename);
								if (($size) && ($size[0] < $max_image_width)&& ($size[1] < $max_image_height)) {
									if (filesize($filename) > $max_photo_size) $message= 'Error:photo file size > 4M.';
									else {
										if (move_uploaded_file($filename, $media_link));
										else $message= 'Error: moving photo file failed.';
										}
									}
								else $message= 'Error: wrong photo file properties.';
							
							}
						}
			}
echo $message;


$dir = "uploads/";
$filessize=array();
$filetime=array();
if (is_dir($dir)) {
  if ($dh = opendir($dir)) {
      while (($file = readdir($dh)) !== false) {
		  if(filetype($dir . $file)==file){
			 $exten = substr($file,1 + strrpos($file, "."));
			 if(in_array($exten, $valid)){
				 $ft=filectime($dir.$file);
				 $fs=filesize($dir.$file); 
				 $filessize[$file]=$fs;
				 $filetime[$file]=$ft;
				  }
			if(in_array($exten, $valid_p_types) && !file_exists("uploads/tumb/".$file))
			 mythumbnails(200,200,$path."/",$file,"uploads/tumb/","");		  
	}
	  }
	  closedir($dh);
  }
}
$filenameorder=array();
$filenameorder=$filessize;
asort($filessize,SORT_NUMERIC);
arsort($filetime,SORT_NUMERIC);
uksort( $filenameorder, 'strnatcmp');

if(isset($_GET['order'])){
	if(isset($_GET['desc'])){
		if($_GET['desc']=="descending"){
		$filessize=array_reverse($filessize);
		$filetime=array_reverse($filetime);
		$filenameorder=array_reverse($filenameorder);
	}
	}
	$order=$_GET['order'];
	$filezz=array();
	if($order=="size") $filezz=$filessize;
	if($order=="date") $filezz=$filetime;
	if($order=="name") $filezz=$filenameorder;
}
else $filezz=$filetime;
$pages=ceil(count($filezz)/$num);
$filezz=array_slice($filezz,$start, $num,true);
$i=1; ?>
<table align="center"> 
<?
foreach($filezz as $file => $value){
	$ft=filectime($dir.$file);
	$fs=filesize($dir.$file); 
	$ext = substr($file,1 + strrpos($file, "."));
	$wext= substr($file,0, strrpos($file, "."));
	if(mb_strlen($wext,'utf-8')>9)$ffffff=mb_substr($wext, 0,8,'utf-8')."...".$ext;
	else $ffffff=$file;
	if(mb_strlen($wext,'utf-8')>9)$wextff=mb_substr($wext, 0,8,'utf-8')."...";
	else $wextff=$wext;
	if($i>3 || $i==1){?>  <tr> <? }?>
   <td>
   <ul id="nav">	
<li >
   	<table class="type10" >
    	<tr> 
		<td width="200" height="210" align="center"> 
        
       <? if(file_exists("uploads/tumb/".$file)){
		   			$size=array();
					$size=@getimagesize("uploads/".$file);
					$srcx= $size[0];
					$srcy= $size[1];
					?>
            		<img title="<?=$size[0]?> x <?=$size[1]?>" src="uploads/tumb/<?=$file?>" /></td> <? ;}
			   if($ext=="mp4"){?>
                <video controls="controls" width="200" height="200">
				<source src="uploads/<?=$file?>" type="video/mp4" />
				<source src="uploads/<?=$wext?>.webm" type="video/webm" />
				</video>
		  	<? ;} ?>
 
        </td>
        
        <td  height="200" align="left">
		<? if($ext=="mp4"){?>
        	<a title="<?=$file?>" href="uploads/<?=$file?>">
			<?=$ffffff?><br /><?=date("m/d/Y H:i", $ft)?><br /><?=ceil($fs/1024)?> kb"</a><br /> <? ;
			if(file_exists("uploads/".$wext.".webm")){
				$filedate=filectime($dir.$wext.".webm");
				$filesize=ceil(filesize($dir.$wext.".webm")/1024);?>
            <a title="<?=$wext?>.webm" href="uploads/<?=$wext?>.webm">
			 <?=$wextff?>webm<br /><?=date("m/d/Y H:i",$filedate )?><br /><?=$filesize?> kb</a><br /> <? ;}
			 }
		if(in_array($ext, $valid_p_types)){
		?>
    	<a title="<?=$file?>" href="uploads/<?=$file?>"><?=$ffffff?><br /><?=date("m/d/Y H:i", $ft)?><br /><?=ceil($fs/1024) ?> kb</a><br />
        <? ;} ?>
    	
        <? if(in_array($ext, $valid_p_types) || $ext=="mp4") { 
				$upfile="uploads/".$file;
				
				?><a href="<?=$_SERVER['PHP_SELF']?>?del=<?=$file?>&p=<?=$page?>&order=<?=$ord?>&desc=<?=$des?>"><font color=#cc0000>remove</font></a> <?
    	
			}?>
        </td>
       </tr>
       <tr>
       	<td colspan="2">
        <? 
		$webmm=null;
		if(is_file("uploads/".$wext.".webm")) $webmm= "uploads/".$wext.".webm"; 
		if(isset($_GET['id']) && $_GET['id'] != "" ){
			$id=$_GET['id'];?>
        	<a href="new_story.php?id=<?=$_SESSION[id]?>&media=uploads/<?=$file?>&webm=<?=$webmm?>">SELECT</a> <? ; } ?>
        </td>
        
       </tr>
      </table>
      </li>
</ul>
     </td>
        
        
  
        <? if($i>2){
			$i=0;
			?>	</tr> <? ;}
		$i++
		 ?>
<? } ?>
</table>
</div>
<div class="type6" style="height:55px" >
<?	
mypagesnew($num,$page,$pages, $_SERVER['PHP_SELF']."?id=".$id."&order=".$ord."&desc=".$des."&");
?>
</div>

</body>
</html>