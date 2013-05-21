
	<!--Modals-->
			<?php
				$dbh=mysql_connect ("localhost", "mtriffco_matt", PASSWORD)
				or die ('I cannot connect to the database.');

				mysql_select_db ("mtriffco_yelp");	

				$cmd="select * from businessClusterInfo";
				$result=mysql_query($cmd, $dbh);

				while ($row = mysql_fetch_assoc($result)) {
					$businessProfiles[]=array($row['title'], $row['details']);
				}

				$cmd="select * from reviewerClusterInfo";
				$result=mysql_query($cmd, $dbh);

				while ($row = mysql_fetch_assoc($result)) {
					$reviewerProfiles[]=array($row['title'], $row['details']);
				}
			?>


				<div id='businessProfiles' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='business1Label' aria-hidden='true'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
						<h4 id='business1Label'>Business Profiles</h4>
					</div>
					<div class='modal-body pagination-centered'>
						<a href='businesses.php?cluster=1&page=1&search=' role='button' class='btn btn-success span3' data-toggle='modal'><p><?php echo $businessProfiles[0][0];?></p></a><br>
						<a href='businesses.php?cluster=2&page=1&search=' role='button' class='btn btn-success span3' data-toggle='modal'><p><?php echo $businessProfiles[1][0];?></p></a><br>
						<a href='businesses.php?cluster=3&page=1&search=' role='button' class='btn btn-success span3' data-toggle='modal'><p><?php echo $businessProfiles[2][0];?></p></a><br>
						<a href='businesses.php?cluster=4&page=1&search=' role='button' class='btn btn-success span3' data-toggle='modal'><p><?php echo $businessProfiles[3][0];?></p></a><br>
						<a href='businesses.php?cluster=5&page=1&search=' role='button' class='btn btn-success span3' data-toggle='modal'><p><?php echo $businessProfiles[4][0];?></p></a><br>
						<a href='businesses.php?cluster=6&page=1&search=' role='button' class='btn btn-success span3' data-toggle='modal'><p><?php echo $businessProfiles[5][0];?></p></a><br>
						<a href='businesses.php?cluster=7&page=1&search=' role='button' class='btn btn-success span3' data-toggle='modal'><p><?php echo $businessProfiles[6][0];?></p></a><br>
					</div>
				</div>

				<div id='reviewerProfiles' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='business1Label' aria-hidden='true'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
						<h4 id='business1Label'>Reviewer Profiles</h4>
					</div>
					<div class='modal-body pagination-centered'>
								<a href='reviews.php?cluster=1&page=1&search=' role='button' class='btn btn-info span3' data-toggle='modal'><p><?php echo $reviewerProfiles[0][0];?></p></a><br>
								<a href='reviews.php?cluster=2&page=1&search=' role='button' class='btn btn-info span3' data-toggle='modal'><p><?php echo $reviewerProfiles[1][0];?></p></a><br>
								<a href='reviews.php?cluster=3&page=1&search=' role='button' class='btn btn-info span3' data-toggle='modal'><p><?php echo $reviewerProfiles[2][0];?></p></a><br>
								<a href='reviews.php?cluster=4&page=1&search=' role='button' class='btn btn-info span3' data-toggle='modal'><p><?php echo $reviewerProfiles[3][0];?></p></a><br>
								<a href='reviews.php?cluster=5&page=1&search=' role='button' class='btn btn-info span3' data-toggle='modal'><p><?php echo $reviewerProfiles[4][0];?></p></a><br>
								<a href='reviews.php?cluster=6&page=1&search=' role='button' class='btn btn-info span3' data-toggle='modal'><p><?php echo $reviewerProfiles[5][0];?></p></a><br>
								<a href='reviews.php?cluster=7&page=1&search=' role='button' class='btn btn-info span3' data-toggle='modal'><p><?php echo $reviewerProfiles[6][0];?></p></a><br>
					</div>
				</div>
