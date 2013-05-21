<html>
<head>
	<title>Yelp Dataset Challenge</title>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40827164-1', 'mtriff.com');
  ga('send', 'pageview');

</script>
<?php include('include.php');?>
	<style type="text/css">
	body {
	background-color: #FFF;
	}
	.btncustom {
	    width: 300px !important;
	    height: 50px !important;
	    margin: 10px;
	}
	.paddedCell {
		padding-left: 40px;
	}
	label {
		float: left;
		margin: 10px;
	}
	#divider {
		text-align: center;
		background-color: #000;
	}
	#divider h4 {
		color: white;
	}
	.sortButton {
		
	}
	</style>
</head>
<body>
	<?php 

	$cluster=$_GET["cluster"];
	$page=$_GET["page"];
	$offset=(10*$page)-10;
	$sort=$_GET["sort"];
	//stars, totalReviews, totalCheckins

	$dbh=mysql_connect ("localhost", "mtriffco_matt", PASSWORD)
		or die ('I cannot connect to the database.');

	mysql_select_db ("mtriffco_yelp");	

	echo "<table class='table table-bordered'>
		<tr id='divider'>
			<td colspan=2>
				<h4>Reviewers</h4>
			</td>
		</tr>";

		$cmd="select * from reviewerInfo join reviewerCluster join reviewerClusterInfo on (reviewerInfo.user_id=reviewerCluster.id and reviewerCluster.cluster=reviewerClusterInfo.cluster) where reviewerClusterInfo.cluster=$cluster order by $sort desc limit $offset,10";		
	$result=mysql_query($cmd, $dbh);
	while ($row = mysql_fetch_assoc($result)) {
		$id=$row['id'];
		$name=$row['firstName'];
		$reviews=$row['reviewsGiven'];
		$numStars=$row['aveStars'];
		$starIcons="";
		$profile=$row['title'];
		$useful=$row['useful'];
		$funny=$row['funny'];
		$cool=$row['cool'];
		for ($i=1; $i<=5; $i++)
		{
			if($i<$numStars)
			{
				$starIcons.="<i class='icon-star'></i>";
			}
			else
			{
				$starIcons.="<i class='icon-star-empty'></i>";
			}
		}
		$address=$row['address'];
		$categories=$row['categories'];

   		echo 	"<tr>
			<td class='span4'>
				<div>
					<strong>
						$name</br>
						Average Rating: $starIcons</br>
						Reviews: $reviews</br>
						Profile: $profile</br>
					</strong>
					<a href='#reviewer$cluster' class='btn btn-small btn-info' data-dismiss='modal' data-toggle='modal'>View Profile</a>
				</div>
			</td>
			<td class='span9'>
				<p>
					<strong>Useful Votes:</strong>$useful</br>
					<strong>Cool Votes:</strong>$cool</br>
					<strong>Funny Votes:</strong>$funny
				</p>
				<a class='btn btn-small btn-info' href='reviewer.php?id=$id' target='_top'>View Details</a>
			</td>
		</tr>";
	}
	echo "</table>";
	?>

		<!--Modals-->
	<?php include('profileModals.php');?>
</body>
</html>