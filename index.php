<!DOCTYPE html>
<html>
<head>
        <title>Photo album</title>
	<link rel="stylesheet" type="text/css" href="./styles/album.css">
        <!-- "Photography can only represent the present." -->
<?php
        // Once photographed, the subject becomes part of the past.
        // ~ Berenice Abbott
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
class ImageMetadata{
	function __construct($title,$filename,$description,$orginal_name,$author,$type){
		$this->title = $title;
		$this->filename = $filename;
		$this->orginal_name = $orginal_name;
		$this->description = $description;
                $this->author = $author;
		$this->type = $type;
	}
}
$images = "./images/";
define('META','./metadata/');
define("PIC","pic");
$images_dir = dir($images);

$dir_count = function($dir){
	return (count(scandir($dir)) - 2);
};
$extension = function($files){
	return explode('/',$files['type'])[1];
};
if(isset($_FILES[PIC]) && isset($_POST['author']) && isset($_POST['title']) && isset($_POST['description'])){
	// if media type
	$count = $dir_count($images);
	$name = $images.$count.'.'.$extension($_FILES[PIC]);
	move_uploaded_file($_FILES[PIC]['tmp_name'],$name);
	$metadata = new ImageMetadata($_POST['title'],
								  $name,
								  $_POST['description'],
								  $_FILES[PIC]['name'],
                                                                  $_POST['author'],
								  $_FILES[PIC]['type']);
	$metadata = serialize($metadata);
	file_put_contents(META.$count,$metadata);
	
}
for($image=$images_dir->read();$image;$image=$images_dir->read()){
	if($image != '.' && $image != '..'){
		$id = explode('.',$image)[0];
		$meta = unserialize(file_get_contents(META.$id));
		echo<<<END
		<article class="photo_sector" id="sector_$id">
			<h1>$meta->title</h1>
			<img class="album" id="$id" src="$images$image" alt="$meta->title" />
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
