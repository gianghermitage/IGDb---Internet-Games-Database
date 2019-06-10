﻿<!DOCTYPE html>
<html>

<head>
    <title>IGDb</title>
    <link href="style sheet/user.css" rel="stylesheet" />
</head>

<body>
    <div class="bg">
        <div class="bodyContainer">
            <div class="header">
                <div class="leftHeader">
                    <div class="logo">
                        <div class="logoText">IGDb</div>
                    </div>
                    <div class="Store">
                        <div class="storeText">Store</div>
                    </div>
                    <div class="Library">
                        <div class="libText">Library</div>
                    </div>
                    <div class="Search">
                        <div class="searchText">Search</div>
                    </div>

                    <div class="User">
                        <div class="userText">User</div>
                        <span class="user-menu">
                            <p class="profile">Profile</p>
                            <p class="logout">Logout</p>
                        </span>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="userInfoContainer">
                    <span class="userAva">
                        <img src=pictures/game4.jpg width="200px" height="200px">
                    </span>
                    <div class="userInfo">
                        <div class=userName>
                            <div class="userName">John Doe</div>
                        </div>
                        <div class="userEmail">johndoe@gmail.com</div>
                    </div>
                </div>
                <div class="userStatistic">
                    <div class="numGamesContainer">
                        <div class="numGamesText">Number of games:</div>
                        <div class="numGames">5</div>
                    </div>
                    <div class="numReviewsContainer">
                        <div class="numReviewsText">Number of reviews:</div>
                        <div class="numReviews">4</div>
                    </div>
                </div>

                <div class="gamesDisplay">
                    <div class="gameText">
                        <div id="allGames">Library</div>
                        <div class="storeSortButton">
                            <div class="sortButton">Filter
                                <span class="sort-menu">
                                    <p class="sortbyPlaying">Currently playing</p>
                                    <p class="sortbyPlayed">Played</p>
                                    <p class="sortbyWait">Waiting to play</p>
                                    <p class="sortbyDropped">Dropped</p>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class=gamesContainer>
                        <div class="grid-container">
                            <div class="grid-item">
                                <span class="gameCover">
                                    <img src=pictures/game4.jpg width="200px" height="100px">
                                </span>
                                <span class="gameInfo">
                                    <div class="gameName">Game name #1</div>
                                    <div class="gameOption">
                                        <label class="container">Playing
                                            <input type="radio" name="Game name #1">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="container">Played
                                            <input type="radio" name="Game name #1">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="container">Waiting to play
                                            <input type="radio" name="Game name #1">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="container">Dropped
                                            <input type="radio" name="Game name #1">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <div class="grid-item">
                                <span class="gameCover">
                                    <img src=pictures/game4.jpg width="200px" height="100px">
                                </span>
                                <span class="gameInfo">
                                    <div class="gameName">Game name #2</div>
                                    <div class="gameOption">
                                        <label class="container">Playing
                                            <input type="radio"name="Game name #2">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="container">Played
                                            <input type="radio" name="Game name #2">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="container">Waiting to play
                                            <input type="radio" name="Game name #2">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="container">Dropped
                                            <input type="radio" name="Game name #2">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </span>
                            </div>

                        </div>
                    </div>
                </div>










            </div>
        </div>
    </div>
    <script src="javascript/jquery-3.3.1.js"></script>
    <script src="javascript/user.js"></script>
</body>

</html>