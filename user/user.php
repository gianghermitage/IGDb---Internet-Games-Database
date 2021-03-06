﻿<?php
	header("Cache-Control: no cache");
	session_cache_limiter("private_no_expire");
    session_start();
    // header("Cache-Control: no cache");
	// session_cache_limiter("private_no_expire");
    if ( isset($_SESSION['user_id']) ){
        include '../shared.php';

        // connect to database
        $db_conn = pg_connect("host=$host port=$port user=$user password=$pass dbname=$dbname") or die('Could not connect: ' . pg_last_error());

        $id = $_SESSION['user_id'];
        $result = pg_exec($db_conn, "SELECT * FROM igdb.users WHERE user_id='$id';");
        $numrows = pg_numrows($result);
        if ($numrows == 0){
            header("Location: ../login/login.php");
            exit(0);
		}
    }
    else {
        header("Location: ../login/login.php");
        exit(0);
	}

	//game filter
	if ( isset($_POST['gameFilter']) || isset($_POST['reviewFilter'])){
		$gameFilter = $_POST['gameFilter'];
		$_SESSION['gameFilter'] = $gameFilter;
		$reviewFilter = $_POST['reviewFilter'];
		$_SESSION['reviewFilter'] = $reviewFilter;
		if ($gameFilter == "none")
			$_SESSION['gameFilter_query'] = "game_id";
		if ($gameFilter == "newest")
			$_SESSION['gameFilter_query'] = "release_date";
		if ($gameFilter == "popular")
			$_SESSION['gameFilter_query'] = "total_added";
		if ($gameFilter == "rating")
			$_SESSION['gameFilter_query'] = "avg_score";
		//$gameFilter = $_POST['gameFilter'];
		if ($reviewFilter == "none")
			$_SESSION['reviewFilter_query'] = "review_id";
		if ($reviewFilter == "date")
			$_SESSION['reviewFilter_query'] = "review_date";
		if ($reviewFilter == "pos")
			$_SESSION['reviewFilter_query'] = "t";
		if ($reviewFilter == "neg")
			$_SESSION['reviewFilter_query'] = "f";
		header("Location: ./user.php");
		return;
	}
?>

<!DOCTYPE html>
<html>

<head>
    <title>IGDb</title>
    <link href="style sheet/user.css" rel="stylesheet" />
	<link rel="stylesheet" href="style sheet/selectbox.min.css">
</head>

<body>
    <div class="bg" style="background-image: url(../resources/test/bg.png);">
        <div class="bodyContainer">
            <?php include '../nav/navigation.php' ?>
            <div class="content">
            	<?php
            		$result = pg_query("SELECT sum(upvote)-sum(downvote) as votes from igdb.reviews where user_id=".$_SESSION['user_id'].";"); 
            		$votes = pg_fetch_array($result, 0)['votes'];
            		if ($votes < 5)
            			$background = '../resources/tiers/bronze.jpg';
            		if ($votes >= 5 && $votes < 10)
            			$background = '../resources/tiers/silver.jpg';
            		if ($votes >= 10)
            			$background = '../resources/tiers/gold.jpg';
            	?>
                <div class="userInfoContainer" style="background-image: url(<?php echo $background ?>);background-size: 800px 200px;background-position: right;background-repeat: no-repeat;">
                    <span class="userAva">
                        <img src='../resources/avatars/default.png' width="200px" height="200px">
                    </span>
                    <div class="userInfo">
					<?php 
								$result = pg_query($db_conn, "SELECT * FROM igdb.users WHERE user_id = '".$_SESSION['user_id']."';");
                                $numrows = pg_num_rows($result);

                                if ($numrows == 0) {
                                    echo 'There is nothing here';
                                }
                                else {
                                    $arr = pg_fetch_all($result);
                                    foreach($arr as $array) {
                                        $userName = $array['name'];
                                        $userEmail = $array['email'];
										echo ' <div class=userNameContainer>
										<div class="userName">'.$userName.'</div>
									</div>
									<div class="userEmail">'.$userEmail.'</div>';
                                    }
                                }

                            ?>
                    </div>
                </div>
                <div class="userStatistic">
					<?php 
						$result = pg_query($db_conn, "SELECT count(game_id) as number_of_games FROM igdb.library WHERE user_id = '".$_SESSION['user_id']."' GROUP BY user_id;");
						$numrows = pg_num_rows($result);

						if ($numrows == 0) {
							echo'<div class="numLeftContainer">
								<div class="numReviewsText">Number of games:</div>
								<div class="numReviews">0</div>
							</div>';
						}

						else {
							$arr = pg_fetch_all($result);
                            foreach($arr as $array) {
								$num = $array['number_of_games'];
								echo'<div class="numLeftContainer">
								<div class="numReviewsText">Number of games:</div>
								<div class="numReviews">'.$num.'</div>
							</div>';
							}
						}
					?>
                    
					<?php 
						$result = pg_query($db_conn, "SELECT count(review_id) as number_of_reviews FROM igdb.reviews WHERE user_id = '".$_SESSION['user_id']."' GROUP BY user_id;");
						$numrows = pg_num_rows($result);

						if ($numrows == 0) {
							echo' <div class="numLeftContainer">
								<div class="numReviewsText">Number of reviews:</div>
								<div class="numReviews">0</div>
							</div>';
						}

						else {
							$arr = pg_fetch_all($result);
                            foreach($arr as $array) {
								$num = $array['number_of_reviews'];
								echo' <div class="numLeftContainer">
								<div class="numReviewsText">Number of reviews:</div>
								<div class="numReviews">'.$num.'</div>
							</div>';
							}
						}
					?>

					<?php 
						$result = pg_query($db_conn, "SELECT count(game_id) as number_of_playing FROM igdb.library WHERE user_id = '".$_SESSION['user_id']."' AND category = 1 GROUP BY user_id;");
						$numrows = pg_num_rows($result);

						if ($numrows == 0) {
							echo'<div class="numRightContainer">
								<div class="numReviewsText">Currently playing:</div>
								<div class="numReviews">0</div>
							</div>';
						}

						else {
							$arr = pg_fetch_all($result);
                            foreach($arr as $array) {
								$num = $array['number_of_playing'];
								echo'<div class="numRightContainer">
								<div class="numReviewsText">Currently playing:</div>
								<div class="numReviews">'.$num.'</div>
							</div>';
							}
						}
					?>

					<?php 
						$result = pg_query($db_conn, "SELECT count(game_id) as number_of_completed FROM igdb.library WHERE user_id = '".$_SESSION['user_id']."' AND category = 2 GROUP BY user_id;");
						$numrows = pg_num_rows($result);

						if ($numrows == 0) {
							echo'<div class="numRightContainer">
							<div class="numReviewsText">Completed:</div>
							<div class="numReviews">0</div>
						</div>';
						}

						else {
							$arr = pg_fetch_all($result);
                            foreach($arr as $array) {
								$num = $array['number_of_completed'];
								echo'<div class="numRightContainer">
								<div class="numReviewsText">Completed:</div>
								<div class="numReviews">'.$num.'</div>
							</div>';
							}
						}
					?>
                    
					<?php 
						$result = pg_query($db_conn, "SELECT count(game_id) as number_of_hold FROM igdb.library WHERE user_id = '".$_SESSION['user_id']."' AND category = 3 GROUP BY user_id;");
						$numrows = pg_num_rows($result);

						if ($numrows == 0) {
							echo'<div class="numRightContainer">
							<div class="numReviewsText">Plan to play:</div>
							<div class="numReviews">0</div>
						</div>';
						}

						else {
							$arr = pg_fetch_all($result);
                            foreach($arr as $array) {
								$num = $array['number_of_hold'];
								echo'<div class="numRightContainer">
								<div class="numReviewsText">Plan to play:</div>
								<div class="numReviews">'.$num.'</div>
							</div>';
							}
						}
					?>
                    
					<?php 
						$result = pg_query($db_conn, "SELECT count(game_id) as number_of_dropped FROM igdb.library WHERE user_id = '".$_SESSION['user_id']."' AND category = 4 GROUP BY user_id;");
						$numrows = pg_num_rows($result);

						if ($numrows == 0) {
							echo'<div class="numRightContainer">
							<div class="numReviewsText">Dropped:</div>
							<div class="numReviews">0</div>
						</div>';
						}

						else {
							$arr = pg_fetch_all($result);
                            foreach($arr as $array) {
								$num = $array['number_of_dropped'];
								echo'<div class="numRightContainer">
								<div class="numReviewsText">Dropped:</div>
								<div class="numReviews">'.$num.'</div>
							</div>';
							}
						}
					?>
                </div>

				<div class="gamesDisplay">
                    <div class="gameText">
                        <div id="allGames">Library</div>
                        <!-- <div class="storeSortButton">
                            <div class="sortButton">Filter
                                <span class="sort-menu">
                                    <p id="sortbyPlaying" class="sort-item">Currently playing</p>
                                    <p id="sortbyPlayed" class="sort-item">Completed</p>
                                    <p id="sortbyWait" class="sort-item">Plan to play</p>
                                    <p id="sortbyDropped" class="sort-item">Dropped</p>
                                </span>
                            </div>
                        </div> -->
						<form method="post" id="filter-form" class="sortButton">
                            <select name=gameFilter onchange="this.form.submit()" class="filterButton">
                                    <option value="" disabled selected>Filter</option>
                                    <option class="sortby" value="none">None</option>
                                    <option class="sortby" value="newest">Newest first</option>
                                    <option class="sortby" value="popular">Most popular first</option>
                                    <option class="sortby" value="rating">Highest rated first</option>
                            </select>
                        </form>
                    </div>
                    <div class=gamesContainer>
                        <div class="grid-container">
						<?php 
								$gameFilter = isset($_SESSION['gameFilter']) ? $_SESSION['gameFilter'] : '';
								$gameFilter_query = isset($_SESSION['gameFilter_query']) ? $_SESSION['gameFilter_query'] : 'game_id';
								$result = pg_query($db_conn, "SELECT g.game_id, g.title,  g.description, g.img_url, g.release_date, g.avg_score,
															count(l.game_id) AS total_added FROM igdb.games g 
															INNER JOIN igdb.library l ON l.game_id = g.game_id 
															WHERE l.user_id = '".$_SESSION['user_id']."'
															GROUP BY g.game_id, g.title,  g.description, g.img_url, g.release_date, g.avg_score
															ORDER BY $gameFilter_query DESC;");
                                $numrows = pg_num_rows($result);

                                if ($numrows == 0) {
                                    echo 'There is nothing here';
                                }
                                else {
                                    $arr = pg_fetch_all($result);
                                    foreach($arr as $array) {
                                        $img_url = $array['img_url'];
                                        $cover = strtok($img_url, ";");
										$title = $array['title'];
										$description = $array['description'];
										$game_id = $array['game_id'];

										echo ' <div class="grid-item">
                                        <span class="gameCover">
                                            <img src='.$cover.' width="200px" height="100px">
                                        </span>
                                        <span class="gameInfo">
                                            <div class="gameName" onclick="game_onclick(\''.$game_id.'\')">'.$title.'</div>
                                            <div class="gameDescription">'.$description.'</div>
                                        </span>
                                    </div>';
                                    }
                                }

                            ?>
                        </div>
                    </div>

                    <div class="reviewMenu">
                            <div class="allReview">All reviews</div>
                                <!-- <div class="sortButton">Filter
                                    <span class="sort-menu">
                                        <p class="sort-item" id="sort-review-by-date">Date</p>
                                        <p class="sort-item" id="sort-review-by-pos">Negative first</p>
                                        <p class="sort-item" id="sort-review-by-neg">Positive first</p>
                                    </span>
                                </div> -->
								<form method="post" id="filter-form" class="sortButton">
                            		<select name=reviewFilter onchange="this.form.submit()" class="filterButton">
										<option value="" disabled selected>Filter</option>
										<option class="sortby" value="none">None</option>
										<option class="sortby" value="date">Date</option>
										<option class="sortby" value="pos">Positive only</option>
										<option class="sortby" value="neg">Negative only</option>
                            		</select>
                        		</form>
                            </div>

                    <div class=reviewContainer>
						<div class="grid-container">
							<?php 
								$reviewFilter = isset($_SESSION['reviewFilter']) ? $_SESSION['reviewFilter'] : '';
								$reviewFilter_query = isset($_SESSION['reviewFilter_query']) ? $_SESSION['reviewFilter_query'] : 'review_id';

								if ($reviewFilter_query == "review_date" || $reviewFilter_query == "review_id") {
									$result = pg_query($db_conn, "SELECT DISTINCT * FROM igdb.reviews r 
													INNER JOIN igdb.games g ON g.game_id = r.game_id 
													INNER JOIN igdb.library l on l.game_id = g.game_id AND l.user_id = r.user_id
													WHERE l.user_id = '".$_SESSION['user_id']."' ORDER BY $reviewFilter_query DESC;");
								}
								if ($reviewFilter_query == "t" || $reviewFilter_query == "f") {
									$result = pg_query($db_conn, "SELECT DISTINCT * FROM igdb.reviews r 
													INNER JOIN igdb.games g ON g.game_id = r.game_id 
													INNER JOIN igdb.library l on l.game_id = g.game_id AND l.user_id = r.user_id
													WHERE l.user_id = '".$_SESSION['user_id']."' AND r.recommend = '".$reviewFilter_query."';");
								}
								
                                $numrows = pg_num_rows($result);

                                if ($numrows == 0) {
                                    echo 'There is nothing here';
								}
								
								else {
									$arr = pg_fetch_all($result);
									foreach($arr as $array) 
									{
										$title = $array['title'];
										$status = $array['category'];
										$img_url = $array['img_url'];
										$cover = strtok($img_url, ";");
										if ($status == 1) $statusText = "Playing";
										else if ($status == 2) $statusText = "Completed";
										else if ($status == 3) $statusText = "Plan to play";
										else if ($status == 4) $statusText = "Dropped";
										$recommend = $array['recommend'];
										if ($recommend == 't') $recommend = "Recommended";
										if ($recommend == 'f') $recommend = "Not Recommended";
										$date = $array['review_date'];
										$content = $array['game_review'];
										$up = $array['upvote'];
										$down = $array['downvote'];
										$game_id = $array['game_id'];
										echo '<div class="grid-item">
												<span class="userAvaReview">
													<img src='.$cover.' width="100%" height="100%">
												</span>
												<div class="reviewInfo">
													<div class=reviewTop>
														<div class="gameNameReview" onclick="game_onclick(\''.$game_id.'\')">'.$title.'</div>
														<div class="gameStatus">'.$statusText.'</div>
														<div class="reviewRec">'.$recommend.'</div>
														<div class="reviewDate">'.$date.'</div>
														<div class="reviewRating">
														<div class="upvote">up: '.$up.' </div>
														<div class="downvote">down: '.$down.'</div>
													</div>
													</div>
													<div class="reviewText">'.$content.'</div>
												</div>
											</div>';
									}
								}
							?>  
							</div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <script src="javascript/jquery-3.3.1.js"></script>
	<script src="javascript/user.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script type="text/javascript" src="javascript/selectbox.min.js"></script>
</body>

</html>
