<?php
 if(isset($_POST["btn_zip"]))  
 {  
      $output = '';  
      if($_FILES['zip_file']['name'] != '')  
      {  
           $file_name = $_FILES['zip_file']['name'];  
           $array = explode(".", $file_name);  
           $name = $array[0];  
           $ext = $array[1];  
           if($ext == 'zip')  
           {  
                $path = 'upload/';  
                $location = $path . $file_name;  
                if(move_uploaded_file($_FILES['zip_file']['tmp_name'], $location))  
                {  
                     $zip = new ZipArchive;  
                     if($zip->open($location))  
                     {  
                          $zip->extractTo($path);  
                          $zip->close();  
                     }  
                     $files = scandir($path . $name);  
                     //$name is extract folder from zip file  
                     foreach($files as $file)  
                     {  
                          $tmp=explode(".", $file);
                          $file_ext = end($tmp);  
                          $allowed_ext = array('PNG','png','jpg','mp4','mp3','pdf');  
                          if(in_array($file_ext, $allowed_ext))  
                          {  
                              $new_name = md5(rand()).'.' . $file_ext;  
                              $output .= '    <div class="container">
                              <h2>Display The Extracted Content From Zip File</h2>
                              <!-- Trigger the modal with a button -->
                              <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">See Content</button>

                              <!-- Modal -->
                              <div class="modal fade" id="myModal" role="dialog">
                              <div class="modal-dialog">
                              
                                   <!-- Modal content-->
                                   <div class="modal-content">
                                   <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                             <h4 class="modal-title">Content Of zip file</h4>
                                   </div>
                                   <div class="modal-body">
                                   <div class="col-md-12">
                                   <div style="padding:16px; border:1px solid #aaa;"><a download="">
                                   <a download="" href="#">
                                   <img src="upload/'.$new_name.'" width="170" height="240" /></a>
                                   </div>
                                   </div>
                                    <div class="col-md-12">
                                   <div style="padding:16px; border:1px solid #aaa;"><a download="">
                                   <a download="" href="#">
                                   <img src="upload/'.$new_name.'" width="170" height="240" /></a>
                                   </div>
                                   </div>
                                             <div class="col-md-12">
                                                  <div style="padding:16px; border:1px solid #aaa;"> 
                                                  <audio controls autoplay loop>
                                                  <source src="upload/'.$new_name.'" type="audio/mpeg">   
                                                  </audio><br>
                                                  </div>
                                             </div>
                                             <div class="col-md-12">
                                                  <div style="padding:16px; border:1px solid #aaa;">
                                                  <video controls autoplay loop muted width="400px" height="400px" poster="img3.jfif">
                                                  <source src="upload/'.$new_name.'" type="video/mp4">
                                                  </video> 
                                                  </div>
                                             </div>
                                              <div class="col-md-12">
                                                  <div style="padding:16px; border:1px solid #aaa;">
                                                    <a download="" href="upload/'.$new_name.'">Download Pdf</a> 
                                                  </div>
                                             </div>
                                                                 
                                   </div>
                                   <div class="modal-footer">
                                             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                   </div>
                                   </div>
                                   
                              </div>
                              </div>                         
                              </div>';  
                              copy($path.$name.'/'.$file, $path . $new_name);  
                              unlink($path.$name.'/'.$file);  
                          }       
                     }  
                    unlink($location);  
                    rmdir($path . $name);  
 
                }  
           }  
      }  
 }  
 ?>
<!DOCTYPE html>
<html>

<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
     <title> Extract a Zip File content</title>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <br />
    <!-- Modal content-->
     <div class="body-card">
        <div class="container" style="width:500px;">
        <h3 align="">Extract Zip File content</h3><br />
        <form method="post" enctype="multipart/form-data">
            <label>Select a Zip File To Extract Its Content</label>
            <input type="file" name="zip_file" />
            <br />
            <input type="submit" name="btn_zip" class="btn btn-info" value="Upload" />
        </form>
        <br />
        <?php  
                if(isset($output))  
                {  
                     echo $output;  
                }  
                ?>
          </div>
     </div>
    
    <br />
</body>

</html>