<?php
			$dbh=mysql_connect ("localhost", "mtriffco_matt", PASSWORD)
			or die ('I cannot connect to the database.');

			mysql_select_db ("mtriffco_yelp");	

			$cmd="select * from businessClusterInfo";
			$result=mysql_query($cmd, $dbh);

			$businessProfiles=array();
			while ($row = mysql_fetch_assoc($result)) {
				$businessProfiles[]=array($row['title'], $row['details']);
			}

			$cmd="select * from reviewerClusterInfo";
			$result=mysql_query($cmd, $dbh);

			$reviewerProfiles=array();
			while ($row = mysql_fetch_assoc($result)) {
				$reviewerProfiles[]=array($row['title'], $row['details']);
			}

			for($i=0;$i<7;$i++)
			{
				$businessProfilesNoBR[]=str_replace('<br>', ' ', $businessProfiles[$i][0]);
				$reviewerProfilesNoBR[]=str_replace('<br>', ' ', $reviewerProfiles[$i][0]);			
			}

			

			error_log($businessProfilesNoBR[0][0]);

			$businessProfileStats=array(
				"1"=>array(12,16,19,31,22,12,6,1,3,1,69,10,10),
				"2"=>array(11,6,5,7,22,61,21,1,5,1,60,6,6),
				"3"=>array(101,6,9,16,37,31,3,0,20,2,65,4,6),
				"4"=>array(13,6,7,12,55,20,8,1,3,1,75,5,8),
				"5"=>array(5,6,3,2,6,83,63,0,6,1,20,7,3),
				"6"=>array(5,51,11,9,14,15,11,1,5,2,34,42,6),
				"7"=>array(335,3,6,14,39,38,4,0,7,22,60,2,5)
			);

			$commonReviewerArray=array(
				"1"=>"<a href='#reviewer5' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[4][0]."</a><br><a href='#reviewer2' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[1][0]."</a><br><a href='#reviewer6' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[5][0]."</a>",
				"2"=>"<a href='#reviewer1' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[0][0]."</a><br><a href='#reviewer2' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[1][0]."</a><br><a href='#reviewer4' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[3][0]."</a>",
				"3"=>"<a href='#reviewer3' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[2][0]."</a><br><a href='#reviewer7' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[6][0]."</a><br><a href='#reviewer5' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[4][0]."</a>",
				"4"=>"<a href='#reviewer7' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[6][0]."</a><br><a href='#reviewer3' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[2][0]."</a><br><a href='#reviewer6' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[5][0]."</a>",
				"5"=>"<a href='#reviewer4' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[3][0]."</a><br><a href='#reviewer1' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[0][0]."</a><br><a href='#reviewer3' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[2][0]."</a>",
				"6"=>"<a href='#reviewer6' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[5][0]."</a><br><a href='#reviewer1' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[0][0]."</a><br><a href='#reviewer5' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[4][0]."</a>",
				"7"=>"<a href='#reviewer4' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[3][0]."</a><br><a href='#reviewer1' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[0][0]."</a><br><a href='#reviewer2' role='button' class='btn btn-info span4' data-dismiss='modal' data-toggle='modal'>".$reviewerProfiles[1][0]."</a>"
			);

			for($id=1; $id<8;$id++){
				$name=$businessProfiles[$id-1][0];
				$summary=$businessProfiles[$id-1][1];

				echo "<div id='business$id' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='business1Label' aria-hidden='true'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
						<h4 id='business1Label'>Business Profile</h4>

					</div>
					<div class='modal-body'>
						<table class='table table-striped table-bordered'>
							<tr>
								<td ><h4>$name</h4></td>
							</tr>
							<tr>
								<td><strong class='paddedCell'>Summary</strong></td>
							</tr>
							<tr>
								<td>
									<p class='paddedCell'>$summary</p>
								</td>
							</tr>
							<tr>
								<td>
									<strong class='paddedCell'>Most Common Reviewers</strong>
								</td>
							</tr>
							<tr>
								<td>
									<p class='paddedCell'>$commonReviewerArray[$id]</p>
								</td>
							</tr>
						</table>
					</div>
					<div class='modal-footer'>
						<a class='btn btn-success pull-left' id='statsBus$id'>Statistics</a>
						<a class='btn btn-success' href='businesses.php?cluster=$id&page=1&search=' target='_parent'>View Businesses</a>
					</div>
				</div>";

				echo "<script type='text/javascript'>
					$('#statsBus$id').popover({
						placement:'top',
						title: 'Statistics',
						html:true,
						content:'<hr class=\'bighr\'>Static Representation<hr class=\'bighr\'>Average Reviews Recieved: ".$businessProfileStats[$id][0]."<hr><i class=\'icon-star\'></i> Reviews : ".$businessProfileStats[$id][1]."%<br><i class=\'icon-star\'></i><i class=\'icon-star\'></i> Reviews : ".$businessProfileStats[$id][2]."%<br><i class=\'icon-star\'></i><i class=\'icon-star\'></i><i class=\'icon-star\'></i> Reviews : ".$businessProfileStats[$id][3]."%<br><i class=\'icon-star\'></i><i class=\'icon-star\'></i><i class=\'icon-star\'></i><i class=\'icon-star\'></i> Reviews : ".$businessProfileStats[$id][4]."%<br><i class=\'icon-star\'></i><i class=\'icon-star\'></i><i class=\'icon-star\'></i><i class=\'icon-star\'></i><i class=\'icon-star\'></i> Reviews : ".$businessProfileStats[$id][5]."%<br><br><hr class=\'bighr\'>Dynamic Representation<hr class=\'bighr\'>".$reviewerProfilesNoBR[0]." : ".$businessProfileStats[$id][6]."%<hr>".$reviewerProfilesNoBR[1]." : ".$businessProfileStats[$id][7]."%<hr>".$reviewerProfilesNoBR[2]." : ".$businessProfileStats[$id][8]."%<hr>".$reviewerProfilesNoBR[3]." : ".$businessProfileStats[$id][9]."%<hr>".$reviewerProfilesNoBR[4]." : ".$businessProfileStats[$id][10]."%<hr>".$reviewerProfilesNoBR[5]." : ".$businessProfileStats[$id][11]."%<hr>".$reviewerProfilesNoBR[6]." : ".$businessProfileStats[$id][12]."%'
					});
				</script>";
			}

			$reviewerProfileStats=array(
				"1"=>array(2,2,2,2,4,91,2,9,34,6,16,29,3,3),
				"2"=>array(443,2,6,26,46,20,13074,19,17,32,16,2,4,10),
				"3"=>array(3,4,13,12,6,65,4,2,3,84,3,1,1,5),
				"4"=>array(2,6,8,10,29,47,3,2,2,7,2,1,1,84),
				"5"=>array(10,3,6,12,64,15,25,12,11,42,21,1,2,10),
				"6"=>array(2,63,18,12,3,5,2,26,12,21,12,4,23,2),
				"7"=>array(180,5,9,23,39,24,2235,17,12,36,18,1,2,13)
			);

			$commonBusinessArray=array(
				"1"=>"<a href='#business6' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[5][0]."</a><br><a href='#business2' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[1][0]."</a><br><a href='#business7' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[6][0]."</a>",
				"2"=>"<a href='#business2' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[1][0]."</a><br><a href='#business6' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[5][0]."</a><br><a href='#business7' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[6][0]."</a>",
				"3"=>"<a href='#business3' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[2][0]."</a><br><a href='#business5' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[4][0]."</a><br><a href='#business7' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[6][0]."</a>",
				"4"=>"<a href='#business4' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[6][0]."</a><br><a href='#business7' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[6][0]."</a><br><a href='#business1' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[0][0]."</a>",
				"5"=>"<a href='#business1' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[0][0]."</a><br><a href='#business6' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[5][0]."</a><br><a href='#business2' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[1][0]."</a>",
				"6"=>"<a href='#business6' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[5][0]."</a><br><a href='#business2' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[1][0]."</a><br><a href='#business1' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[0][0]."</a>",
				"7"=>"<a href='#business4' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[3][0]."</a><br><a href='#business7' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[6][0]."</a><br><a href='#business2' role='button' class='btn btn-success span4' data-dismiss='modal' data-toggle='modal'>".$businessProfiles[1][0]."</a>"
			);

			for($id=0; $id<8;$id++){
				$name=$reviewerProfiles[$id-1][0];
				$summary=$reviewerProfiles[$id-1][1];
				
				echo "<div id='reviewer$id' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='business1Label' aria-hidden='true'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
						<h4 id='business1Label'>Reviewer Profile</h4>

					</div>
					<div class='modal-body'>
						<table class='table table-striped table-bordered'>
							<tr>
								<td ><h4>$name</h4></td>
							</tr>
							<tr>
								<td><strong class='paddedCell'>Summary</strong></td>
							</tr>
							<tr>
								<td>
									<p class='paddedCell'>$summary</p>
								</td>
							</tr>
							<tr>
								<td>
									<strong class='paddedCell'>Most Common Businesses Reviewed</strong>
								</td>
							</tr>
							<tr>
								<td>
									<p class='paddedCell'>$commonBusinessArray[$id]</p>
								</td>
							</tr>
						</table>
					</div>
					<div class='modal-footer'>
						<a class='btn btn-info pull-left' id='statsRev$id'>Statistics</a>
						<a class='btn btn-info' href='reviews.php?cluster=$id&page=1&search=' target='_parent'>View Reviewers</a>
					</div>
				</div>";

					echo "<script type='text/javascript'>
					$('#statsRev$id').popover({
						placement:'top',
						title: 'Statistics',
						html:true,
						content:'<hr class=\'bighr\'>Static Representation<hr class=\'bighr\'>Average Reviews Given: ".$reviewerProfileStats[$id][0]."<hr><i class=\'icon-star\'></i>Reviews : ".$reviewerProfileStats[$id][1]."%<br><i class=\'icon-star\'></i><i class=\'icon-star\'></i>Reviews : ".$reviewerProfileStats[$id][2]."%<br><i class=\'icon-star\'></i><i class=\'icon-star\'></i><i class=\'icon-star\'></i> Reviews : ".$reviewerProfileStats[$id][3]."%<br><i class=\'icon-star\'></i><i class=\'icon-star\'></i><i class=\'icon-star\'></i><i class=\'icon-star\'></i> Reviews : ".$reviewerProfileStats[$id][4]."%<br><i class=\'icon-star\'></i><i class=\'icon-star\'></i><i class=\'icon-star\'></i><i class=\'icon-star\'></i><i class=\'icon-star\'></i> Reviews : ".$reviewerProfileStats[$id][5]."%<hr>Average Votes: ".$reviewerProfileStats[$id][6]."<br><br><hr class=\'bighr\'>Dynamic Representation<hr class=\'bighr\'>".$businessProfilesNoBR[0]." : ".$reviewerProfileStats[$id][7]."%<hr>".$businessProfilesNoBR[1]." : ".$reviewerProfileStats[$id][8]."%<hr>".$businessProfilesNoBR[2]." : ".$reviewerProfileStats[$id][9]."%<hr>".$businessProfilesNoBR[3]." : ".$reviewerProfileStats[$id][10]."%<hr>".$businessProfilesNoBR[4]." : ".$reviewerProfileStats[$id][11]."%<hr>".$businessProfilesNoBR[5]." : ".$reviewerProfileStats[$id][12]."%<hr>".$businessProfilesNoBR[6]." : ".$reviewerProfileStats[$id][13]."%'
					});
				</script>";
			}
?>