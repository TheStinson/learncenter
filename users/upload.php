<?php
$servername = "localhost";
$username = "thestinson";
$password = "";
$dbname = "learncenter";
// Create connection
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$userid = $fgmembersite->Id_User();
?>
<!DOCTYPE html>
<html >
<head>
</head>
<body>
	<form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="submit"> 
    Title:<input name="txtName" type="text" value="" required="required" placeholder="Enter File Name..."/><br>
    Branch : <select type="select" name="branchlist">
    <?php $sql = "select b.branch_id,b.branch_name from branch b";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)){?>
        
    <option value="<?php echo $row['branch_id'];?>"><?php echo $row['branch_name'];?></option>><?PHP }}?></select>
    Select file to upload:
    <input type="file" name="fileToUpload" size="50" id="fileToUpload" ><br>
    <input type="submit" name="submit" value="Upload File"/> 
    
    </form>  
<?php
    if(isset($_POST["submit"])) 
{
    $uploadOk = 1;
    $oname = basename($_FILES["fileToUpload"]["name"]);
    $ext = strtolower (pathinfo($oname, PATHINFO_EXTENSION));
    $sql = "select ft.type_id from filetype ft where ft.type_name = '$ext'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {$typeid = $row['type_id'];}}
        
    $name=$_POST['txtName'];
    $branchid=$_POST['branchlist'];
    echo $branchid;
    $filename ="uploads/";
    $filename.= $name.".".$ext;
    $target_file = $filename;
    $uploadOk = 1;

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.$name";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } 
        else 
        {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
            {
                $sql = "INSERT INTO upload (file_name,file_link,type_id,id_user,branch_id) VALUES ('$name','$filename','$typeid','$userid','$branchid')";
                if(mysqli_query($conn, $sql))
                {
                    echo "File Uploaded Succefully!";
                }
                else
                {
                    echo "Something went wrong! Please try again!";
                    unlink($filename);
                }
            } 
            else 
            {
            echo "Sorry, there was an error uploading your file.";
            }
        }
}
 ?> 
 </body>
</html>
