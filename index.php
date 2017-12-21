<?php
	require_once("./metadata.php");
	define('META','./metadata/');
	define("PIC","pic");
    if(isset($_GET['photo_id'])){
        $meta = unserialize(file_get_contents(META.$_GET['photo_id']));
        header("Content-type: ".$meta->type);
        echo($meta->image);
        die();
    }
?>
<!DOCTYPE html>
<html>
<head>
		<!-- "Photography can only represent the present." -->
<?php
        // Once photographed, the subject becomes part of the past.
        // ~ Berenice Abbott
	if(@$page_info = file_get_contents(META.'page_info')){
		$page_info = unserialize($page_info);
	} else if(isset($_POST['title']) && isset($_POST['copyright'])){
        $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING && FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $copy = filter_input(INPUT_POST,'copyright',FILTER_SANITIZE_STRING && FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$page_info = new PageMetadata($title,$copy);
		$saveinfo = serialize($page_info);
		file_put_contents(META.'page_info',$saveinfo);
	} else{
		echo<<<END
		<title>Setup album</title>
		<link rel="stylesheet" type="text/css" href="./styles/album.css">
		</head>
		<body>
		<main>
			<h1 id="setup_header">Setup your album</h1>
			<form method="post" id="setup">
				<input type="text" name="title" id="title" placeholder="Title" required />
				<input type="text" name="copyright" id="copyright" placeholder="copyright" required /> 
				<input type="submit">
			</form>
		</main>
		</body>
		</html>
END;
	die();
	}
    echo('<title>'.$page_info->title.'</title>');
?>
	<link rel="stylesheet" type="text/css" href="./styles/album.css">
        
<?php
	$plugins_dir = "./plugins/";
	$plugins = dir($plugins_dir);
	for($plugin=$plugins->read();$plugin;$plugin=$plugins->read()){
		if($plugin != '.' && $plugin != '..'){
			echo('<script src="'.$plugins_dir.$plugin.'"></script>');
		}
	}
?>
</head>
<body>
<main id="main">
<form method="post" id="send_photo" enctype="multipart/form-data">
  <input type="text" name="title" id="title" placeholder="Title" required />
  <input type="text" name="description" id="title" placeholder="Description" required />
  <input type="text" name="author" id="author" placeholder="Author" required /> 
  <input type="file" name="pic" accept="image/*" required />
  <input type="submit">
</form>
<?php
$images_dir = dir(META);

$dir_count = function($dir){
	return (count(scandir($dir)) - 2);
};
$extension = function($files){
	return explode('/',$files['type'])[1];
};
if(isset($_FILES[PIC]) && isset($_POST['author']) && isset($_POST['title']) && isset($_POST['description'])){
	$count = $dir_count(META);
    $file = file_get_contents($_FILES[PIC]['tmp_name']);
	$metadata = new ImageMetadata($_POST['title'],
								  $count.$extension($_FILES[PIC]),
								  $_POST['description'],
								  $_FILES[PIC]['name'],
                                  $_POST['author'],
								  $_FILES[PIC]['type'],
                                  $file);
	$metadata = serialize($metadata);
	file_put_contents(META.$count,$metadata);
	
}
$images_dir = dir(META);
for($image=$images_dir->read();$image;$image=$images_dir->read()){
	if($image != '.' && $image != '..' && $image != 'page_info'){
		$id = explode('.',$image)[0];
		$meta = unserialize(file_get_contents(META.$id));
		echo<<<END
		<article class="photo_sector" id="sector_$id">
			<h1>$meta->title</h1>
			<img class="album" id="$id" src="./index.php?photo_id=$id" alt="$meta->title" />
			<p class="desc">$meta->description</p>
                        <p class="author">Author: $meta->author</p>
		</article>
END;
	}
}
$images_dir->close();
?>
</main>
</body>
<html>
