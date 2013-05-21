<!DOCTYPE html>
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
<script>
	function search()
	{
		searchQuery=document.getElementById('searchbar').value;
		window.location.href = 'businesses.php?cluster=1&page=1&search='+searchQuery;
	}

    function toggleChecked( id ){

	    $('#checkboxes').find(':checkbox').each(function(){
	        jQuery(this).prop('checked', $('#' + id).is(':checked'));

	    	});
    	clustersUpdate();
	}

	function getUrlVars() {
		var map = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			map[key] = value;
		});
		return map;
	}

	function getUrlVarsFrom(url) {
		var map = {};
		var parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			map[key] = value;
		});
		return map;
	}	

	function startIframe()
	{
		updateIframe(getUrlVars()['id'], 1, 'businessInfo.stars', '1234567');
		document.getElementById('currPage').innerHTML=1;
	}

	function updateIframe(user_id, page, sort, clusters)
	{
		document.getElementById('theIframe').src='businessList.php?user_id='+user_id+'&page='+page+'&sort='+sort+'&clusters='+clusters;
	}

	function setIframeHeight()
	{
		var theIframe=document.getElementById('theIframe');
		var newHeight=theIframe.contentWindow.document.body.scrollHeight;
		if(newHeight<600)
		{
			newHeight=600;
		}
		theIframe.height=newHeight+'px';
	}

	function changeSort(newSort)
	{
		varsMap=getUrlVarsFrom(document.getElementById('theIframe').src);
		updateIframe(varsMap['user_id'], varsMap['page'], newSort, varsMap['clusters']);		
	}

	function prevPage()
	{
		varsMap=getUrlVarsFrom(document.getElementById('theIframe').src);
		updateIframe(varsMap['user_id'], document.getElementById('currPage').innerHTML*1-1, varsMap['sort'], varsMap['clusters']);	
		document.getElementById('currPage').innerHTML=document.getElementById('currPage').innerHTML*1-1;
		document.location.href = "#theIframe"; 
	}

	function nextPage()
	{
		varsMap=getUrlVarsFrom(document.getElementById('theIframe').src);
		updateIframe(varsMap['user_id'], document.getElementById('currPage').innerHTML*1+1, varsMap['sort'], varsMap['clusters']);
		document.getElementById('currPage').innerHTML=document.getElementById('currPage').innerHTML*1+1;
		document.location.href = "#theIframe"; 
	}


	function clustersUpdate()
	{
		var clustersList='';

		for(var i=1; i<8; i++)
		{
			if(document.getElementById('checkbox'+i).checked)
			{
				clustersList+=i;
			}
		}

		if(clustersList=='1234567')
		{
			document.getElementById('checkAll').checked=true;
		}
		else
		{
			document.getElementById('checkAll').checked=false;
		}

		varsMap=getUrlVarsFrom(document.getElementById('theIframe').src);
		updateIframe(varsMap['user_id'], varsMap['page'], varsMap['sort'], clustersList);
	}

</script>
<style type="text/css">
body {
background-color: #CCC;
}
#content {
	background-color: #FFF;
	border-radius: 5px;
	white-space:normal;
	padding: 20px;
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
.control {
	margin: 5px;
}
.modal-body {
    max-height: 800px;
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
<body onload='startIframe();'>
		<?php include('navModals.php');?>

		<?php include('header2.php');?>
			<div class='row-fluid' id='profile'>
				<?php

				$dbh=mysql_connect ("localhost", "mtriffco_matt", PASSWORD)
					or die ('I cannot connect to the database.');

				mysql_select_db ("mtriffco_yelp");	

				$id=$_GET["id"];

				$cmd="select * from reviewerInfo join reviewerCluster join reviewerClusterInfo on (reviewerInfo.user_id=reviewerCluster.id and reviewerCluster.cluster=reviewerClusterInfo.cluster) where reviewerInfo.user_id='$id'";
				$result=mysql_query($cmd, $dbh);

				$row = mysql_fetch_assoc($result);
				$name=$row['firstName'];
				$numStars=$row['aveStars'];
				$starIcons="";
				$profile=$row['title'];
				$details=$row['details'];
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

				$cmd="select count(*) from reviewInfo join businessInfo join businessCluster on (reviewInfo.business_id=businessInfo.id and businessCluster.id=businessInfo.id) where reviewInfo.user_id='$id'";
				$result=mysql_query($cmd, $dbh);
				$row = mysql_fetch_assoc($result);
				$reviews=$row['count(*)'];		

				$cmd="select count(*) from reviewInfo join businessInfo join businessCluster on (reviewInfo.business_id=businessInfo.id and businessCluster.id=businessInfo.id) where reviewInfo.user_id='$id' and cluster=1";
				$result=mysql_query($cmd, $dbh);
				$row = mysql_fetch_assoc($result);
				$cluster1=$row['count(*)'];				

				$cmd="select count(*) from reviewInfo join businessInfo join businessCluster on (reviewInfo.business_id=businessInfo.id and businessCluster.id=businessInfo.id) where reviewInfo.user_id='$id' and cluster=2";
				$result=mysql_query($cmd, $dbh);
				$row = mysql_fetch_assoc($result);
				$cluster2=$row['count(*)'];		

				$cmd="select count(*) from reviewInfo join businessInfo join businessCluster on (reviewInfo.business_id=businessInfo.id and businessCluster.id=businessInfo.id) where reviewInfo.user_id='$id' and cluster=3";
				$result=mysql_query($cmd, $dbh);
				$row = mysql_fetch_assoc($result);
				$cluster3=$row['count(*)'];		

				$cmd="select count(*) from reviewInfo join businessInfo join businessCluster on (reviewInfo.business_id=businessInfo.id and businessCluster.id=businessInfo.id) where reviewInfo.user_id='$id' and cluster=4";
				$result=mysql_query($cmd, $dbh);
				$row = mysql_fetch_assoc($result);
				$cluster4=$row['count(*)'];		

				$cmd="select count(*) from reviewInfo join businessInfo join businessCluster on (reviewInfo.business_id=businessInfo.id and businessCluster.id=businessInfo.id) where reviewInfo.user_id='$id' and cluster=5";
				$result=mysql_query($cmd, $dbh);
				$row = mysql_fetch_assoc($result);
				$cluster5=$row['count(*)'];		

				$cmd="select count(*) from reviewInfo join businessInfo join businessCluster on (reviewInfo.business_id=businessInfo.id and businessCluster.id=businessInfo.id) where reviewInfo.user_id='$id' and cluster=6";
				$result=mysql_query($cmd, $dbh);
				$row = mysql_fetch_assoc($result);
				$cluster6=$row['count(*)'];		

				$cmd="select count(*) from reviewInfo join businessInfo join businessCluster on (reviewInfo.business_id=businessInfo.id and businessCluster.id=businessInfo.id) where reviewInfo.user_id='$id' and cluster=7";
				$result=mysql_query($cmd, $dbh);
				$row = mysql_fetch_assoc($result);
				$cluster7=$row['count(*)'];		

				echo "<table class='table table-bordered span10 offset1'>
				<tr>
					<td><h4>$name</h4></td>
				</tr>
				<tr>
					<td class='span3'>
						<div>
							<strong>
								Stars: $starIcons</br>
								Total Reviews: $reviews</br>
							</strong>
							<p>	Useful Votes: $useful</br>
								Cool Votes: $cool</br>
								Funny Votes: $funny
							</p>
						</div>
					</td>
					<td class='span9'>
						<div class='span12'>
							<strong>Profile: $profile</strong>
							<p>$details</p>
						</div>
					</td>
				</tr>
				<tr>
					<td rowspan=2>
						<strong>View Reviews from Selected Profiles:</strong>
					</td>
					<td>
							<label class='checkbox'>
	      						<input type='checkbox' id='checkAll' onclick='toggleChecked(this.id)' checked> All Profiles ($reviews)
	    					</label>		
					</td>
				</tr>
				<tr>
					<td>
						<div id='checkboxes'>
							<label class='checkbox'>
	      						<input type='checkbox' id=checkbox1 checked onclick='clustersUpdate();'> ".$businessProfiles[0][0]." ($cluster1)
	    					</label>
							<label class='checkbox'>
	      						<input type='checkbox' id=checkbox2 checked onclick='clustersUpdate();'> ".$businessProfiles[1][0]."($cluster2)
	    					</label>
							<label class='checkbox'>
	      						<input type='checkbox' id=checkbox3 checked onclick='clustersUpdate();'> ".$businessProfiles[2][0]." ($cluster3)
	    					</label>
	    					<label class='checkbox'>
	      						<input type='checkbox' id=checkbox4 checked onclick='clustersUpdate();'> ".$businessProfiles[3][0]." ($cluster4)
	    					</label>
	    					<label class='checkbox'>
	      						<input type='checkbox' id=checkbox5 checked onclick='clustersUpdate();'> ".$businessProfiles[4][0]." ($cluster5)
	    					</label>
							<label class='checkbox'>
	      						<input type='checkbox' id=checkbox6 checked onclick='clustersUpdate();'> ".$businessProfiles[5][0]." ($cluster6)
	    					</label>
							<label class='checkbox'>
	      						<input type='checkbox' id=checkbox7 checked onclick='clustersUpdate();'> ".$businessProfiles[6][0]." ($cluster7)
	    					</label>
	    				</div>
					</td>
				</tr>";
			?>
				<tr>
					<td>
						<strong>Sort Results By:</strong>
					</td>
					<td>
						<a class='btn btn-small' onclick='changeSort("businessInfo.stars");'>Highest Rating</a>
						<a class='btn btn-small' onclick='changeSort("reviewInfo.date");'>Most Recent</a>
						<a class='btn btn-small' onclick='changeSort("reviewInfo.useful");'>Most Useful</a>
					</td>
			</table>
		</div>
		<div class='row-fluid'>
		   <iframe class='span10 offset1'
		   		   id='theIframe'
		           src='businessList.php?user_id=$id&page=1&sort=stars&clusters=1234567&search='
		           onload='setIframeHeight()'
		           frameBorder=0>
		   </iframe>
		</div>

		<div class='row-fluid'>
			<table class='table span10 offset1'>
				<tr>
					<td>
						<a class='btn btn-small btn-info control' onclick='prevPage()'>Previous</a>
						<a class='btn btn-small btn-info control' onclick='nextPage()'>Next</a>
						<div id='currPage'></div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
</body>
</html>