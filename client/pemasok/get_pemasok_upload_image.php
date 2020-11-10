<?php
session_start();

$upload_location = "../../asset/images/temp/";
$location_real = "asset/images/temp/";
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
    if ($handle = opendir($upload_location)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $kata = explode('-', $entry);                   
                if($kata[0] == $_SESSION['id']){
                    unlink($upload_location . $entry);
                }
            }
        }
        closedir($handle);
    }
    
	$name = $_FILES['fgambar']['name'];
	$size = $_FILES['fgambar']['size'];
	
	$allowedExtensions = array("jpg","jpeg","gif","png");  //Allowed file types
	foreach ($_FILES as $file) 
	{
	  if ($file['tmp_name'] > '' && strlen($name)) 
	  {
		  $tmp = explode(".", strtolower($file['name']));
		  if (!in_array(end($tmp), $allowedExtensions)) 
		  {
			  echo '<div class="info" style="width:500px;">Sorry, you attempted to upload an invalid file format. <br>Only jpg, jpeg, gif and png image files are allowed. Thanks.</div><br clear="all" />';
		  }
		  else 
		  {   		      
			  if($size<(1024*1024))
			  {
                    $actual_image_name = $name;
                    $actual_image_name .= rand (0, 9);
                    $actual_image_name = $_SESSION['id'] . '-' . md5($actual_image_name.$size) . '.jpg'; 
                  
				  if(move_uploaded_file($_FILES['fgambar']['tmp_name'], $upload_location.$actual_image_name)) 
				  {  
				      echo $actual_image_name;
				  }
				  else 
				  {
				        echo "1";
				  }
			  }
			  else 
			  {
				  echo "1";
			  }
		  }
	  }
	  else 
	  {
	       echo "1";
	  }
   }
}


?>