<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

if (isset($_GET['blog_id'])) {
    $blogID = $_GET['blog_id'];
} else {
    header("Location: dashboard.php");
    exit();
}

// id người dùng hiện tại đang xem blog
if (isset($_GET['user_id'])) {
    $userID = $_GET['user_id'];
} else {
    // Nếu không có ID người dùng trong URL, sử dụng ID người dùng hiện tại
    $userID = $_SESSION['user_id'];
}


$blog = getBlog($blogID);
$authorBlog = $_GET['author_blog']; // tác giả blog hiện tại
$viewer = $_GET['viewer']; // người xem hiện tại
// Lấy danh sách bình luận của blog
$comments = getComments($blogID);

// Hàm lấy thông tin blog từ db
// Done
function getBlog($blogID) {
    include 'db_connection.php';

    // Query blog dựa trên ID
    $query = "SELECT * FROM blogs WHERE id = '$blogID'";
    $result = mysqli_query($connection, $query);

    $blog = mysqli_fetch_assoc($result);

    mysqli_close($connection);

    return $blog;
}

// Hàm lấy danh sách bình luận của blog từ db
function getComments($blogID) {
    include 'db_connection.php';

    // Query
    $query = "SELECT * FROM comments WHERE blog_id = '$blogID'";
    $result = mysqli_query($connection, $query);

    $comments = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row;
    }

    mysqli_close($connection);

    return $comments;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Blog</title>
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="css/comment-box.css">
    <link href="css/clean-blog.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="css/comment.css"> -->

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
    <header class="intro-header" style="background-image: url('images/blog-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1><?php echo $blog['title']; ?></h1>
                        <!-- <h2 class="subheading">Problems look mighty small from 150 miles up</h2> -->
                        <span class="meta">Posted by <a href="#"><?php echo $blog['author']; ?></a></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
        <!-- Post Content -->

        <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <p><?php echo $blog['content']; ?></p>

<!-- Audio -->
<?php if (!empty($blog['audio_path'])) { ?>
                <audio controls>
                    <source src="<?php echo $blog['audio_path']; ?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                </audio>
                <?php } ?>
                <br><br><br>
                <hr>

<!-- ////////////////// -->

<style>
    /* CSS cho phần hiển thị comment */
    .comment {
        margin-bottom: 10px;
    }

    .comment small {
        font-size: 12px;
    }

    .comment a {
        color: red;
        text-decoration: none;
    }

    /* CSS cho phần viết comment */
    .comment-form textarea {
        width: 100%;
        height: 100px;
        margin-bottom: 10px;
    }

    .comment-form button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }
</style>

<!-- Comments -->
<h1>All comments</h1><br>
<?php foreach ($comments as $comment) { ?>
    <div class="comment">
    <img src="https://i.imgur.com/CFpa3nK.jpg" width="30" height="30" alt=""> <?php echo $comment['user']; ?>
        <br>
        <p><?php echo $comment['content']; ?></p>
        
        <?php if ($viewer == $authorBlog && (count($comments) > 0)) { ?>
            <br>
            <small><a href="delete_comment.php?comment_id=<?php echo $comment['id']; ?>">Remove</a></small>
        <?php } ?>
        <hr>
    </div>
<?php } ?>

<!-- Comment box -->
<br>
<form class="comment-form" method="POST" action="add_comment.php">
    <input type="hidden" name="blog_id" value="<?php echo $blogID; ?>">
    <input type="hidden" name="viewer" value="<?php echo $viewer; ?>">
    <input type="hidden" name="author_blog" value="<?php echo $authorBlog; ?>">
    <textarea name="comment_content" required></textarea>
    <button type="submit">Comment</button>
</form>



<!-- ////////////////// -->     

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