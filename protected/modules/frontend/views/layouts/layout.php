<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $this->pageTitle ?  'Admin Panel | ' . Yii::app()->name . ' | ' . CHtml::encode($this->pageTitle) : 'Admin Panel | ' . Yii::app()->name?></title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Custom Google Web Font -->
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>

    <!-- Add custom CSS here -->
    <link href="/css/styles.css" rel="stylesheet">

    <!-- JavaScript -->
    <script src="/js/jquery-1.10.2.js"></script>
    <script src="/js/bootstrap.js"></script>

</head>

<body>

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">RMS</a>
            </div>
            <?php if (!Yii::app()->user->isGuest){?>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-left navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="/distributors/list" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-home"></i>Distributors <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/distributors/add">Add distributor</a></li>
                            <li><a href="/distributors/list">List distributors</a></li>
                            <li><a href="/distributors/map">Distributors map</a></li>
                            <li class="divider"></li>
                            <li><a href="/distributors/professional/list">Professional Groups</a></li>
                            <li><a href="/distributors/suppliers/list">Suppliers</a></li>
                            <li><a href="/distributors/groups/list">Groups</a></li>
                            <li><a href="/distributors/regions">Regions</a></li>
                            <li class="divider"></li>
                            <li><a href="/contact/list">Contact Logs</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="/routes/list" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-road"></i>Rep Routes <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/routes/add">Create Route</a></li>
                            <li><a href="/routes/list">View Routes</a></li>
                            <li><a href="/routes/global">Routes Map</a></li>
                            <li class="divider"></li>
                            <li><a href="/reports/add">Add Report</a></li>
                            <li><a href="/reports/list">View Reports</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="/reps/list" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>Reps <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php if (Yii::app()->user->role == 'admin'){?>
                                <li><a href="/users/add">Add User</a></li>
                            <?php }?>
                            <li><a href="/users/list">List Users</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="/orders/list" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-shopping-cart"></i>Orders <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        <li><a href="/orders/active">Active Orders</a></li>
                        <li><a href="/orders/list">All Orders</a></li>
                        <?php if (Yii::app()->user->role == 'admin'){?>
                            <li class="divider"></li>
                            <li><a href="/products/list">Products</a></li>
                            <li><a href="/templates/list">Templates</a></li>
                        <?php }?>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="collapse navbar-collapse navbar-right navbar-ex1-collapse">
                <ul class="nav navbar-nav">

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="/reps/profile"><img src="/images/avatar.png" width="18px" height="18px" style="border-radius: 50%; margin-right: 5px" /><?php echo Yii::app()->user->fname. ' ' .Yii::app()->user->lname;?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/reps/profile/">My Profile</a></li>
                            <li><a href="/settings">RMS Settings</a></li>
                            <li class="divider"></li>
                            <li><a href="/users/signout">Sign Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <?php }?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div id="wrap" class="container">
        <div class="row">
            <?php echo $content ?>
        </div>
        <div id="push"></div>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="copyright text-muted small">Copyright &copy; Representative Management System 2014. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>