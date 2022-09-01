<?php
require_once 'functions.php';
require_once 'config.php';
require_once 'connect.php';
// require_once 'header(1).php';


$id = (INT)$_GET['id'];
if ($id < 1) {
    header("location: $url_path");
}
$sql = "Select * FROM posts WHERE id = '$id'";
$result = mysqli_query($dbcon, $sql);

$invalid = mysqli_num_rows($result);
if ($invalid == 0) {
    header("location: $url_path");
}

$hsql = "SELECT * FROM posts WHERE id = '$id'";
$res = mysqli_query($dbcon, $hsql);
$row = mysqli_fetch_assoc($result);

$id = $row['id'];
$title = $row['title'];
$description = $row['description'];
$author = $row['posted_by'];
$time = $row['date'];

if (!empty(SITE_ROOT)){
    $url_path = "/".SITE_ROOT."/";
} else{
    $url_path = "/";
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" ,initial-scale=1">
    <title>PHP Blog</title>

    <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.19.1/ui/trumbowyg.min.css">
</head>
<body>

<header class="w3-container w3-teal">
    <h1>PHP Blog</h1>
</header>

<div class="w3-bar w3-border">
    <a href="/<?=SITE_ROOT?>" class="w3-bar-item w3-button w3-pale-green">Home</a>
    <?php
    if (isset($_SESSION['username'])) {
        echo "<a href='".$url_path ."new.php' class='w3-bar-item w3-btn'>New Post</a>";
        echo "<a href='".$url_path ."admin.php' class='w3-bar-item w3-btn'>Admin Panel</a>";
        echo "<a href='".$url_path ."logout.php' class='w3-bar-item w3-btn'>Logout</a>";
    } else {
        echo "<a href='".$url_path ."login.php' class='w3-bar-item w3-pale-red' >Login</a>";
    }
    ?>
</div>

echo '<div class="w3-container w3-sand w3-card-4">';

echo "<h3>$title</h3>";
echo '<div class="w3-panel w3-leftbar w3-rightbar w3-border w3-sand w3-card-4">';
echo "$description<br>";
echo '<div class="w3-text-grey">';
echo "Posted by: " . $author . "<br>";
echo "$time</div>";
?>


<?php
if (isset($_SESSION['username'])) {
    ?>
    <div class="w3-text-green"><a href="<?=$url_path?>edit.php?id=<?php echo $row['id']; ?>">[Edit]</a></div>
    <div class="w3-text-red">
        <a href="<?=$url_path?>del.php?id=<?php echo $row['id']; ?>"
           onclick="return confirm('Are you sure you want to delete this post?'); ">[Delete]</a></div>
    <?php
}
echo '</div></div>';


include("footer.php");
