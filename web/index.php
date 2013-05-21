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
    height: 25px !important;
}
.paddedCell {
	padding-left: 40px;
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
.bighr
{
color: #000;
background-color: #000;
height: 5px;
}
.popover{
 max-width: 800px !important;
 width: auto;
}
hr{
padding: 0px;
margin: 0px;    
}
</style>
</head>
<body>

	<?php include('profileModals.php');?>

			<!--Page-->
			<?php include('header.php');?>
			<div class='row-fluid'>
					<div class='well span5 offset1 pagination-centered'>
					<h3>Business Profiles</h3>
					<a href='#business1' role='button' class='btn btn-large btn-success span12' data-toggle='modal'><p><?php echo $businessProfiles[0][0];?></p></a><br>
					<a href='#business2' role='button' class='btn btn-large btn-success span12' data-toggle='modal'><p><?php echo $businessProfiles[1][0];?></p></a><br>
					<a href='#business3' role='button' class='btn btn-large btn-success span12' data-toggle='modal'><p><?php echo $businessProfiles[2][0];?></p></a><br>
					<a href='#business4' role='button' class='btn btn-large btn-success span12' data-toggle='modal'><p><?php echo $businessProfiles[3][0];?></p></a><br>
					<a href='#business5' role='button' class='btn btn-large btn-success span12' data-toggle='modal'><p><?php echo $businessProfiles[4][0];?></p></a><br>
					<a href='#business6' role='button' class='btn btn-large btn-success span12' data-toggle='modal'><p><?php echo $businessProfiles[5][0];?></p></a><br>
					<a href='#business7' role='button' class='btn btn-large btn-success span12' data-toggle='modal'><p><?php echo $businessProfiles[6][0];?></p></a><br>
					</div>
					<div class='well span5 pagination-centered'>
					<h3>Reviewer Profiles</h3>
					<a href='#reviewer1' role='button' class='btn btn-large btn-info span12' data-toggle='modal'><p><?php echo $reviewerProfiles[0][0];?></p></a><br>
					<a href='#reviewer2' role='button' class='btn btn-large btn-info span12' data-toggle='modal'><p><?php echo $reviewerProfiles[1][0];?></p></a><br>
					<a href='#reviewer3' role='button' class='btn btn-large btn-info span12' data-toggle='modal'><p><?php echo $reviewerProfiles[2][0];?></p></a><br>
					<a href='#reviewer4' role='button' class='btn btn-large btn-info span12' data-toggle='modal'><p><?php echo $reviewerProfiles[3][0];?></p></a><br>
					<a href='#reviewer5' role='button' class='btn btn-large btn-info span12' data-toggle='modal'><p><?php echo $reviewerProfiles[4][0];?></p></a><br>
					<a href='#reviewer6' role='button' class='btn btn-large btn-info span12' data-toggle='modal'><p><?php echo $reviewerProfiles[5][0];?></p></a><br>
					<a href='#reviewer7' role='button' class='btn btn-large btn-info span12' data-toggle='modal'><p><?php echo $reviewerProfiles[6][0];?></p></a><br>
				</div>
			</div>
		</div>
	</div>

</div>
</body>
</html>