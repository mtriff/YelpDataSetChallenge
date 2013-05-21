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
	$search=$_GET["search"];
	$user_id=$_GET["user_id"];

	$dbh=mysql_connect ("localhost", "mtriffco_matt", PASSWORD)
		or die ('I cannot connect to the database.');

	mysql_select_db ("mtriffco_yelp");	

	if($search=="")
	{
		if($user_id=="")
		{
			$cmd="select * from businessInfo join businessCluster join businessClusterInfo on (businessInfo.id=businessCluster.id and businessCluster.cluster=businessClusterInfo.cluster) where businessClusterInfo.cluster=$cluster order by $sort desc limit $offset,10";
		}
		else
		{
				$clusters=str_split($_GET["clusters"]);
				if(count($clusters)>0)
				{
					$clusterSelector='and (';
					for($i=0; $i<count($clusters); $i++)
					{
						//Build cluster selection string
						$clusterSelector.="businessCluster.cluster=$clusters[$i]";
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


			$cmd="select * from reviewInfo join businessInfo join businessCluster join businessClusterInfo on (reviewInfo.business_id=businessInfo.id and reviewInfo.business_id=businessCluster.id and businessCluster.cluster=businessClusterInfo.cluster) where user_id='$user_id' $clusterSelector order by $sort desc limit $offset,10";
		}
	}
	else
	{
		$cmd="select * from businessInfo join businessCluster join businessClusterInfo on (businessInfo.id=businessCluster.id and businessCluster.cluster=businessClusterInfo.cluster) where businessInfo.name like '%$search%' order by $sort desc limit $offset,10";
	}
	$result=mysql_query($cmd, $dbh);

	echo "<table class='table table-bordered'>
		<tr id='divider'>
			<td colspan=2>
				<h4>Businesses</h4>
			</td>
		</tr>";


	while ($row = mysql_fetch_assoc($result)) {
		$id=$row['id'];
		$name=$row['name'];
		$checkins=$row['totalCheckins'];
		$reviews=$row['totalReviews'];
		$numStars=$row['stars'];
		$starIcons="";
		$profile=$row['title'];
		$cluster=$row['cluster'];
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
						Rating Given: $starIcons</br>
						Checkins: $checkins</br>
						Reviews: $reviews</br>
						Profile: $profile</br>
					</strong>
					<a href='#business$cluster' class='btn btn-small btn-info' data-dismiss='modal' data-toggle='modal'>View Profile</a>
				</div>
			</td>
			<td class='span9'>
				<p>
					<strong>Categories:</strong>$categories</br>
					<strong>Address:</strong>$address
				</p>
				<a class='btn btn-small btn-info' href='business.php?id=$id' target='_top'>View Details</a>
			</td>
		</tr>";
	}
	echo "</table>";
	?>


	<?php include('profileModals.php');?>

</body>
</html>