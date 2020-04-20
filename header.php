<nav class="navbar navbar-default">
    <div class="container ">
        <!-- Brand and toggle get grouped for better mobile display -->
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <div class="navbar-header">
                <a class="navbar-brand" href="main.php"><strong style="color: black">GoodJob</strong> </a>
            </div>

            <ul class="nav navbar-nav">
                <li><a href="main.php">Home</a></li>
                <li><a href="mypost.php">My Post</a></li>
                <li><a href="#">My Info</a></li>

            </ul>

            <ul class="nav navbar-nav">
                <li><a>Welcome to GoodJob,&nbsp;<?= $_SESSION['email'] ?>!</a></li>
                <li>
                    <a href="./backend/login.php?method=logout">Logout</a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

