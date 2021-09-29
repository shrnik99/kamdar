<?php
include_once "connection.php";
include_once "header.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrapcss/bootstrap.min.css">
    <script type="text/javascript " src="bootstrapjs/bootstrap.min.js"></script>
    <script type="text/javascript " src="bootstrapjs/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/indexstyle.css">
    <link rel="stylesheet" type="text/css" href="css/selectpro.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h1>List Of Professionals</h1>
        <div class="row">
            <?php



            if (isset($_GET['searchSubmit'])) {
                $searchText = $_GET['searchText'];
                $searchResults = explode(" ", $searchText);
                $firstName = $searchResults[0];
                $lastName = $searchResults[1];
                // echo $searchText;
            }
            else{
                $firstName = $_GET['first'];
                $lastName = $_GET['last'];
            }
            $result = mysqli_query($conn, "SELECT *  FROM professional WHERE first LIKE '%$firstName%' AND last LIKE '%$lastName'");
            $resultCount = mysqli_num_rows($result);
            // echo $resultCount;
            // if ($resultCount == 1) {
            //     header('Location: review.php');
            // }
            while ($main_result = mysqli_fetch_assoc($result)) : ?>

                <div class="col-sm-4" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-body ">
                            <?php
                            $proid = $main_result['id'];
                            $state = $main_result['stats'];
                            if ($state == 1) {
                            ?>
                                <i class="fas fa-certificate" style="float: right; color:blue;">User Verified</i><br>
                            <?php
                            } else {
                            ?>
                                <i class="fas fa-times-circle" style="float: right; color:red ; "> User Not Verified</i><br>
                            <?php
                            }

                            ?>
                            <h3 class="card-title-left"><?php echo $main_result['first'];
                                                        echo "  ";
                                                        echo $main_result['last']; ?></h3>
                            <?php 
        $res = mysqli_query($conn,"SELECT * FROM avgrateing Where proid = '$proid'");
        $main = mysqli_fetch_assoc($res);
        // $avg = $main['avgrate'];
        $coun = mysqli_num_rows($res);

     if ($coun == 0) {
        ?>
        <span id="rate" style="color : red;"> Avg : 0 <i class="fa fa-star " ></i></span><br>
        <?php 
        
     }
     else
     {   $avg = $main['avgrate'];
        ?>
        <span id="rate"> Avg : <?php echo $avg ?> <i class="fa fa-star " ></i></span><br>
        <?php 
     }

            ?> 
                            <h5> Gender :<?php echo $main_result['gender']; ?></h5><br>
                            <h5>Phone number :<?php echo $main_result['phone']; ?></h5><br>
                            <h5>Address :<?php echo $main_result['address']; ?></h5><br>
                            <?php
                            $proid = $main_result['id'];
                            $state = $main_result['stats'];
                            $service = $main_result['service'];
                            $location = $main_result['address'];
                            ?>
                            <a href="viewsearchpro.php?id=<?php echo $main_result['id'];?>&ser=<?php echo $service;?>&loc=<?php echo $location;?>"><button type="submit" id="view" >View</button></a>
                            <?php
                            if(isset($_SESSION['ro'])){
                            if ($state == 1 ) {
                            ?>
                                <a href="searchbook.php?id=<?php echo $main_result['id']; ?>&first=<?php echo $firstName;?>&last=<?php echo $lastName;?>"><button type="submit" id="change">Book</button></a>
                            <?php
                            } else {
                            ?>
                                <button type="submit" id="change" onclick="changeColor()">Book</button>
                            <?php
                            }
                        }


                            ?>

                        </div>
                    </div>
                </div>

            <?php endwhile    ?>
        </div>


    </div>

</body>
<script>
    var buttons = document.querySelectorAll('#change');

    // console.log(a);

    function changeColor() {
        alert("Can't Book Professional Not Verified!!");
    }
</script>

</html>