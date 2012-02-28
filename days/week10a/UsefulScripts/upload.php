<?php
//?heck that we have a file
if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
  //Check if the file is JPEG image and it's size is less than 350Kb
  $filename = basename($_FILES['uploaded_file']['name']);
  $ext = substr($filename, strrpos($filename, '.') + 1);
/*  if (($ext == "jpg") && ($_FILES["uploaded_file"]["type"] == "image/jpeg") && 
    ($_FILES["uploaded_file"]["size"] < 350000)) {
    //Determine the path to which we want to save this file
      $newname = '/directory/'.$filename;
      //Check if the file with the same name is already exists on the server
      if (!file_exists($newname)) {
        //Attempt to move the uploaded file to it's new place
        if ((move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$newname))) {
           echo "It's done! The file has been saved as: ".$newname;
        } else {
           echo "Error: A problem occurred during file upload!";
        }
      } else {
         echo "Error: File ".$_FILES["uploaded_file"]["name"]." already exists";
      }
  } else*/ if (($ext == "xls") && ($_FILES["uploaded_file"]["type"] == "application/vnd.ms-excel" ||
                 $_FILES["uploaded_file"]["type"]== "application/xls" ) && 
                 ($_FILES["uploaded_file"]["size"] < 350000)) {
    //Determine the path to which we want to save this file add a path if needed.
      $newname = $filename;
      //Check if the file with the same name is already exists on the server
//      if (!file_exists($newname)) {
        //Attempt to move the uploaded file to it's new place
        if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$newname)) {
           $msg = "It's done! The file has been saved as: ".$newname;
           $json = array();
           $json['msg'] = $msg;
           $json['error'] = '';
           echo json_encode($json);
        } else {
           $json = array();
           $json['msg'] = "Error: A problem occurred during file upload!";
           $json['error'] = "Error: A problem occurred during file upload!";
           echo json_encode();
        }
//      } else {
//         echo "Error: File ".$_FILES["uploaded_file"]["name"]." already exists";
//      }
  } else{
            $msg = "Error: Only .xls files under 350Kb are accepted for upload: ".$_FILES["uploaded_file"]["size"]." : ".$_FILES["uploaded_file"]["type"]." : ".$ext;
           $json = array();
           $json['msg'] = $msg;
           $json['error'] = '';
           echo json_encode($json);
  }
} else {
           $msg = "Error: No file uploaded";
           $json = array();
           $json['msg'] = $msg;
           $json['error'] = '';
           echo json_encode($json);
}
?>