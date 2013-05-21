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
	#header
	{
		color:white;
		background-image: url('header.png');
	    -webkit-background-size: cover;
	    -moz-background-size: cover;
	    -o-background-size: cover;
	    background-size: cover;
	}
	#video
	{
		text-align: center;
		padding-left:25px;
		padding-right: 10px;
	}
	</style>
</head>
<body>
	<table class='table table-bordered'>
		<tr id='divider'>
			<td colspan=2>
				<h4>Reviews</h4>
			</td>
		</tr>

	<?php

		$business_id=$_GET["business_id"];
		$page=$_GET["page"];
		$offset=(10*$page)-10;
		$sort=$_GET["sort"];
		$clusters=str_split($_GET["clusters"]);
		if(count($clusters)>0)
		{
			$clusterSelector='and (';
			for($i=0; $i<count($clusters); $i++)
			{
				//Build cluster selection string
				$clusterSelector.="reviewerCluster.cluster=$clusters[$i]";
				if($i<count($clusters)-1)
				{
					$clusterSelector.=' or ';
				}
			}
			$clusterSelector.=')';
		}
		else
		{
			$clusterSelector="and reviewerCluster.cluster=999";
		}

		$dbh=mysql_connect ("localhost", "mtriffco_matt", PASSWORD)
			or die ('I cannot connect to the database.');

		mysql_select_db ("mtriffco_yelp");	

		$cmd="select * from reviewInfo join reviewerInfo join reviewerCluster join reviewerClusterInfo on (reviewInfo.user_id=reviewerInfo.user_id and reviewInfo.user_id=reviewerCluster.id and reviewerCluster.cluster=reviewerClusterInfo.cluster) where business_id='$business_id' $clusterSelector order by $sort desc limit $offset,10";
		$result=mysql_query($cmd, $dbh);

		while ($row = mysql_fetch_assoc($result)) {
			$name=$row['firstName'];
			$checkins=$row['totalCheckins'];
			$reviews=$row['totalReviews'];
			$numStars=$row['stars'];
			$starIcons="";
			$profile=$row['title'];
			$text=$row['text'];
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
			$date=$row['date'];
			$cluster=$row['cluster'];

			echo "<tr>
				<td class='span3'>
					<div>
						<strong>
							$name</br>
							Rating Given: $starIcons</br>
							Date Reviewed: $date</br>
							Profile: $profile</br>
						</strong>
					<a href='#business$cluster' class='btn btn-small btn-info' data-dismiss='modal' data-toggle='modal'>View Profile</a>
					<br><br>
					<a class='btn btn-small btn-info' href='reviewer.php?id=$id' target='_top'>View Details</a>
										</div>
				</td>
				<td class='span9'>
					<p>$text</p>
				</td>
			</tr>";
		}

		echo "</table>
		</div>";

		?>

				<?php include('profileModals.php');?>

</body>
</html>