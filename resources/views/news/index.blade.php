<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Traffex</title>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="http://getbootstrap.com/examples/blog/blog.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="blog-masthead">
            <div class="container">
                <nav class="blog-nav">
                    <a class="blog-nav-item active" href="/">Home</a>
                    <a class="blog-nav-item" href="#">New features</a>
                    <a class="blog-nav-item" href="#">Press</a>
                    <a class="blog-nav-item" href="#">New hires</a>
                    <a class="blog-nav-item" href="#">About</a>
                </nav>
            </div>
        </div>

        <div class="container">

            <div class="blog-header">
                <h1 class="blog-title">The Bootstrap Blog</h1>
                <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p>
            </div>

            <div class="row">

                <div class="col-sm-8 blog-main">
                    
                    <?php foreach($news as $item): ?>
                    <div class="blog-post">
                        <h2 class="blog-post-title"><a href="/news/<?= $item->id ?>"><?= $item->title ?></a></h2>
                        <p class="blog-post-meta"><?= date_format($item->updated_at, 'd, M Y H:i') ?> by <a href="#">Alexandr</a></p>
                    </div><!-- /.blog-post -->
                    <?php endforeach; ?>

                </div><!-- /.blog-main -->

                <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
                    <div class="sidebar-module sidebar-module-inset">
                        <h4>About</h4>
                        <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                    </div>
                    <div class="sidebar-module">
                        <h4>Archives</h4>
                        <ol class="list-unstyled">
                            <li><a href="#">March 2014</a></li>
                            <li><a href="#">February 2014</a></li>
                            <li><a href="#">January 2014</a></li>
                            <li><a href="#">December 2013</a></li>
                            <li><a href="#">November 2013</a></li>
                            <li><a href="#">October 2013</a></li>
                            <li><a href="#">September 2013</a></li>
                            <li><a href="#">August 2013</a></li>
                            <li><a href="#">July 2013</a></li>
                            <li><a href="#">June 2013</a></li>
                            <li><a href="#">May 2013</a></li>
                            <li><a href="#">April 2013</a></li>
                        </ol>
                    </div>
                    <div class="sidebar-module">
                        <h4>Elsewhere</h4>
                        <ol class="list-unstyled">
                            <li><a href="#">GitHub</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Facebook</a></li>
                        </ol>
                    </div>
                </div><!-- /.blog-sidebar -->

            </div><!-- /.row -->

        </div><!-- /.container -->

        <footer class="blog-footer">
            <p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
            <p>
                <a href="#">Back to top</a>
            </p>
        </footer>
    </body>
</html>