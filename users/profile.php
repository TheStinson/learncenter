<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
echo "name : ".$fgmembersite->UserFullName();
echo "user id : ".$fgmembersite->Id_User();
echo "contact : ".$fgmembersite->Usercontact();
echo "email : ".$fgmembersite->UserEmail();
echo "username : ".$fgmembersite->Username();

echo "<a href='logout.php'>Logout</a>";
?>
