<?php
include_once 'connection.php';
session_start();
$id = $_GET['id'];
$service = $_GET['ser'];
$location = $_GET['loc'];

$useremail = $_SESSION['name'];

// echo $id;
$result6 = mysqli_query($conn,"SELECT * from professional where id = '$id'");
$ma = mysqli_fetch_assoc($result6);
$proemail = $ma['email'];
 $proimage = $ma['images'];

$result = mysqli_query($conn, "SELECT * from users where email = '$proemail'");
$main = mysqli_fetch_assoc($result);
$proname = $main['fname'];
$lastname = $main['lname'];
$address = $main['address'];
$gender = $main['gender'];
$phone = $main['phone'];

// echo $proname;
// echo $lastname;

// fetch rating and comment
$average = mysqli_query($conn, "SELECT AVG(rating) AS avg FROM rating WHERE proid='$id'");
$row = mysqli_fetch_assoc($average);
$final_avg = number_format($row['avg'], 1);



$re = mysqli_query($conn,"SELECT * from avgrateing Where proid ='$id'");
$coun = mysqli_num_rows($re);
if($coun == 0){
	$insert = mysqli_query($conn," INSERT INTO avgrateing (proid,avgrate)VALUES('$id','$final_avg')");
}
else{
	
	$update = mysqli_query($conn,"UPDATE avgrateing SET avgrate = '$final_avg' where proid = '$id'");

}

// $book = mysqli_query($conn,"UPDATE bookings SET state = 4 where proid = '$id' and useremail ='$useremail' ") ;




?>




<html>

<head>
	<meta charset="utf-8">
	<title>Details</title>
	<link rel="stylesheet" type="text/css" href="bootstrapcss/bootstrap.min.css">
	<script type="text/javascript " src="bootstrapjs/bootstrap.min.js"></script>
	<script type="text/javascript " src="bootstrapjs/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- link for css file -->
	<link rel="stylesheet" type="text/css" href="css/viewprostyle.css">

	<!-- link for fontawesome -->
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body>
	<a href="selectpro.php?ser=<?php echo $service;?>&loc=<?php echo $location;?>"><i class="glyphicon glyphicon-remove" id="cross"></i></a>
	<div class="container">
		<div class="main">
<!-- 
			<h1>Details For :</h1> -->
			<?php echo '<img height="200" width="200" src="data:image/jpeg;base64,'.base64_encode($proimage).'"/>'; ?>
				<h1><?php echo $proname;
					echo " ";
					echo $lastname; ?></h1>
					<h3>Address : <?php echo $address ?></h3>
					<h3> Phone Number :<?php echo $phone ?></h3>
					<h3> Gender :<?php echo $gender ?></h3>

					<span id="rate">Avg : <?php echo $final_avg; ?><i class="glyphicon glyphicon-star" id="cross"></i></span>
					<br>
					<br>
					
					
					
		</div>
		<div class="right">
			<h1>Previous Comments: </h1>
			<?php
			$result = mysqli_query($conn, "SELECT * from rating Where proid = '$id'");
			while ($row = mysqli_fetch_assoc($result)) : ?>
				<?php
				$userid = $row['userid'];
				$comment = $row['comment'];
				$rate = $row['rating'];

				$result2 = mysqli_query($conn, "SELECT * from users WHERE id = '$userid'");
				$main = mysqli_fetch_assoc($result2);
				$username = $main['fname'];

				?>
				<div class="card">
					<div class="card-header">User:
						<?php echo $username; ?>
						<span style="float: right;">Review : <?php echo $rate ?> <i class="fa fa-star fa-1x text-success"></i></span>
					</div>
					<div class="card-body">

						<p class="card-text">Comment: <?php echo $comment; ?></p>

					</div>
				</div>
			<?php endwhile ?>
<?php 

?>


		</div>
	</div>
	<script src="js/provide_review.js"></script>
</body>

</html>