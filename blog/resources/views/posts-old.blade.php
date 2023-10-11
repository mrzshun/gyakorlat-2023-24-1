<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HTML 5 Boilerplate</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
	<script src="index.js"></script>
  @empty($posts->toArray())
    <h1>No blogposts!</h1>
  @else
    <h1>All blogposts:</h1>
    @foreach ($posts as $post)
        <h2>{{$post->title}}</h2>
        <cite>Author: <a href="{{$post->author->email}}">{{$post->author->name}}</a></cite>
        <p>
          <strong>Tags:</strong>
          @foreach ($post->categories as $category)
              <span style="color: {{$category->txt_color}};background-color:{{$category->bg_color}}">
                {{$category->name}}
              </span>&nbsp;
          @endforeach
        </p>
        <p>
          {{$post->description}}
        </p>
    @endforeach
  @endempty
  </body>
</html>