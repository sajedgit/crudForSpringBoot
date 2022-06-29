<!DOCTYPE html>
<html lang="en">
<head>
    <title>CRUD Generator</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
        .row.content {
            height: 1500px
        }

        /* Set gray background color and 100% height */
        .sidenav {
            background-color: #f1f1f1;
            height: 100%;
        }

        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }

        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }

            .row.content {
                height: auto;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav">
            <h4><a href="">CRUD Generator</a></h4>
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="index.php">Home</a></li>
                <?php if( isset($_COOKIE["download_file_src"]) ) { ?>
                   <li><a href="<?php echo $_COOKIE['download_file_src']; ?>">Download Code</a></li>
                <?php } ?>
                <li><a href="clean_system.php">Clean System</a></li>
            </ul>
            <br>
<!--            <div class="input-group">-->
<!--                <input type="text" class="form-control" placeholder="Search Blog..">-->
<!--                <span class="input-group-btn">-->
<!--                  <button class="btn btn-default" type="button">-->
<!--                    <span class="glyphicon glyphicon-search"></span>-->
<!--                  </button>-->
<!--                 </span>-->
<!--            </div>-->
        </div>
