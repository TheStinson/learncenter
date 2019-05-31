<?php
$servername = "localhost";
$username = "thestinson";
$password = "";
$dbname = "learncenter";

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
<html>
<head>
    <title>Learn Center | Archives</title>
</head>
<body>
<h1>Archives</h1>
<table> 
<tr>
        <th>File Name</th>
        <th>Upload Date</th>
        <th>Rating</th>
        <th>Type</th>
        <th>Uploaded By</th>
        <th>Action</th>
        </tr>
<?PHP    
$sql = "select u.file_id,u.file_name,u.file_link,u.upload_date,u.rating,uu.name,ft.type_name from upload u inner join users uu inner join filetype ft on u.type_id = ft.type_id AND u.id_user = uu.id_user where u.status='1' ORDER BY u.upload_date";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {?>
        <tr>
        <td><?php echo $row['file_name']?></td>
        <td><?php echo $row['upload_date']?></td>
        <td><?php echo $row['rating']?></td>
        <td><?php echo $row['type_name']?></td>
        <td><?php echo $row['name']?></td>
        <td><a href="<?php echo $row['file_link']?>" target="_blank">View</a> <a href="<?php echo $row['file_link']?>">Download</a></td>
        </tr>
<?PHP    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?> 
</table>
</body>
</html>