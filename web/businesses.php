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
		updateIframe(getUrlVars()['cluster'], getUrlVars()['page'], 'stars', getUrlVars()['search']);
		document.getElementById('currPage').innerHTML=getUrlVars()['page'];
	}

	function updateIframe(cluster, page, sort, search)
	{
		document.getElementById('theIframe').src='businessList.php?cluster='+cluster+'&page='+page+'&sort='+sort+'&search='+search;
	}

	function setIframeHeight()
	{
		var theIframe=document.getElementById('theIframe');
		theIframe.height=theIframe.contentWindow.document.body.scrollHeight+'px';
		console.log('Scroll Height:'+theIframe.contentWindow.document.body.windowHeight);
	}

	function changeSort(newSort)
	{
		varsMap=getUrlVarsFrom(document.getElementById('theIframe').src);
		updateIframe(varsMap['cluster'], varsMap['page'], newSort, varsMap['search']);		
	}

	function prevPage()
	{
		varsMap=getUrlVarsFrom(document.getElementById('theIframe').src);
		updateIframe(varsMap['cluster'], document.getElementById('currPage').innerHTML*1-1, varsMap['sort'], varsMap['search']);	
		document.getElementById('currPage').innerHTML=document.getElementById('currPage').innerHTML*1-1;
		document.location.href = "#"; 
	}

	function nextPage()
	{
		varsMap=getUrlVarsFrom(document.getElementById('theIframe').src);
		updateIframe(varsMap['cluster'], document.getElementById('currPage').innerHTML*1+1, varsMap['sort'], varsMap['search']);
		document.getElementById('currPage').innerHTML=document.getElementById('currPage').innerHTML*1+1;
		document.location.href = "#"; 
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
				<table class='table table-bordered span10 offset1'>
				<tr>
					<td class='span3'>
						<strong>Sort Results By:</strong>
					</td>
					<td class='span9'>
						<a class='btn btn-small' onclick='changeSort("stars");'>Highest Rating</a>
						<a class='btn btn-small' onclick='changeSort("totalReviews");'>Most Reviews</a>
						<a class='btn btn-small' onclick='changeSort("totalCheckins");'>Most Checkins</a>
					</td>
			</table>
		</div>
		<div class='row-fluid'>
		   <iframe id='theIframe' 
		   		   class="span10 offset1"
		           src='' 
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





</body>
</html>