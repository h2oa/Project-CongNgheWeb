<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];
$viewer = $_SESSION['username'];

$blogs = getBlogs();

// Hàm lấy danh sách blog từ db
function getBlogs() {
    include 'db_connection.php';

    // Query
    $query = "SELECT blogs.id, blogs.title, blogs.author, users.username, users.id as user_id
          FROM blogs
          INNER JOIN users ON blogs.user_id = users.id";
    $result = mysqli_query($connection, $query);

    $blogs = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $blogs[] = $row;
    }

    mysqli_close($connection);

    return $blogs;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="css/clean-blog.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
<!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="dashboard.php">Home</a>
                    </li>
                    <li>
                        <a href="create_blog.php">New Blog</a>
                    </li>
                    <li>
                        <a href="logout.php">Logout</a>
                    </li>
                    <!-- <li>
                        <a href="contact.html">Contact</a>
                    </li> -->
                </ul>
            </div>
        <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <header class="intro-header" style="background-image: url('images/dashboard-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>All blog</h1>
                        <hr class="small">
                        <span class="subheading">Share interesting things in your life through blogging</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
        <!-- Main Content -->
        <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="post-preview">
                <?php foreach ($blogs as $blog) { ?>
                    <a href="view_blog.php?blog_id=<?php echo $blog['id']; ?>&viewer=<?php echo $viewer; ?>&author_blog=<?php echo $blog['author']; ?>">
                        <h2 class="post-title">
                        <p><?php echo $blog['title']; ?></p>
                        </h2>
                        <!-- <h3 class="post-subtitle">
                        123
                        </h3> -->
                    </a>
                    <p class="post-meta">Posted by <a href="#"><?php echo $blog['author']; ?></a></p>
                    <?php } ?>
                </div>
                <hr>
                <!-- Pager -->
                <!-- <ul class="pager">
                    <li class="next">
                        <a href="#">Older Posts &rarr;</a>
                    </li>
                </ul> -->
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer>
        <!-- <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <ul class="list-inline text-center">
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="https://github.com/lengochoahust/Project-CongNgheWeb">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <p class="copyright text-muted">Copyright &copy; HUST 2023</p>
                </div>
            </div>
        </div> -->
    </footer>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/clean-blog.min.js"></script>

</body>

</html>