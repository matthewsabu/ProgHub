<?php require_once 'config.php'?>
<div class="mainGrid">
    <!--HEADER-->
    <div class="header">
        <div class="logo">
            <a class="aLogo" href="home.php">
            <img class="logoPgh" src="pictures/pgh.png">
            <img class ="proghub" src="pictures/proghub2.png">
            </a>
        </div>
        
        <div class="search">
            <!--search
            <form class="searchForm" action="search.php" method="get">
                <input class="searchInput" type="text" name="search" Placeholder="Search" />
            </form>-->
        </div>
        
        <div class="account">
            <?php 
				global $user;
				$signedInStatus="False";
				$usersQuery = mysqli_query($user,"select * from login WHERE SignedInStatus = 'True' ");
				
				//global arrays [login and userdetails]
				$userArr = array();
				$specificUserArr = array();
				
                $users = mysqli_fetch_array($usersQuery);
                
				if(empty($users))
                {
                    $signedInStatus="False";
                }
                else{
                    //echo $users["Username"];
                    $username = $users["Username"];
                    $password = $users["Password"];
                    $signedInStatus = $users["SignedInStatus"];
                    $position = $users["Position"];
                    //echo "yep";
                    array_push($userArr,$username,$password,$signedInStatus,$position);
					
					$userdetailQuery = mysqli_query($user,"select * from userdetails WHERE Username = '$username'");
					
					$specificUser = mysqli_fetch_array($userdetailQuery);
					
					$age = $specificUser["Age"];
                    $email = $specificUser["Email"];
                    $gender = $specificUser["Gender"];
                    $image = $specificUser["Image"];
					$bio = $specificUser["Bio"];
					$likes = $specificUser["Likes"];
					array_push($specificUserArr,$username,$password,$age,$email,$gender,$image,$bio,$likes);
                }
				
                if($signedInStatus == "False"){
                    echo "<form class='login' action='login.php' method='post'>";
                    echo "<input class='loginBtn' type='submit' value='Login'/>";
                    echo "</form>";
                    echo "<form class='signup' action='signup.php' method='post'>";
                    echo "<input class='signupBtn' type='submit' value='Sign Up'/>";
                    echo "</form>";
                } else {
					//echo "<label class='username'><a class='username' href='userProfile.php' >".$userArr[0]." </a></label>";
					echo "<form class='username' action='userProfile.php' method='post'>";
                    echo "<input class='usernameBtn' type='submit' value='".$userArr[0]."'/>";
                    echo "</form>";
					echo "<form class='settings' action='settings.php' method='post'>";
                    echo "<input class='settingsBtn' type='submit' value='Settings'/>";
                    echo "</form>";
					//dropdown menu not yet implementable
					/*echo "<select name='userDropDown'>";
					echo "<a href='settings.php'><option>Settings</option></a>";
					echo "</select>";*/
				}
            ?>
        </div>
    </div>