<?php
    require_once 'vendor/autoload.php';
    $blogposts = json_decode(file_get_contents('./data/blogdata.json',true),true);
    $postById = null;
    if(isset($_GET['id'])){
        foreach($blogposts as $blogpost) {
            if($blogpost['id'] == $_GET['id']) {
                $postById = $blogpost;
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<title>
    <?php
        echo $postById == null ? 'List of Posts' : $postById['title'];
    ?>
</title>
</head>
<body>

    <?php if($postById == null): ?>
    <h1>All Posts:</h1>
        <?php foreach($blogposts as $blogpost): ?>
            <h2><?php echo $blogpost['title']; ?></h2>
            <p><?php echo $blogpost['description']; ?></p>
            <p><a href="blog.php?id=<?php echo $blogpost['id']; ?>">elolvas</a></p>
        <?php endforeach ?>
    <?php else: ?>
        <h1>The Requested Blogpost</h1>
        <h2><?php echo $postById['title']; ?></h2>
        <p>Author: <?php echo $postById['author']; ?></p>
        <p><?php echo $postById['description']; ?></p>
        <p><?php echo $postById['text']; ?></p>
        <p><a href="blog.php">Vissza a teljes listára</a></p>
    <?php endif; ?>
</body>
</html>