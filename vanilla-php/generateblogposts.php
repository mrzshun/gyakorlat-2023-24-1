<?php
    require_once 'vendor/autoload.php';
    $faker = Faker\Factory::create();
    $blogposts = [];
    for($i = 0; $i < 100; $i++) {
        $blogposts[$i] = [
            'id' => $faker->unique()->randomNumber(5,true),
            'title' => $faker->sentence(5),
            'description' => $faker->sentences(3,true),
            'text' => $faker->paragraphs(5,true),
            'author' => $faker->name()
        ];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<title>Generate Names</title>
</head>
<body>
    <h1>Blogpost</h1>
    <pre>
        <?php echo json_encode($blogposts,JSON_PRETTY_PRINT); ?>
    </pre>
</body>
</html>