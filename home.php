<html>
	<?php require_once 'config.php'?>
	<?php require_once (ROOT_PATH .'\includes\header.php')?>
	<?php require_once (ROOT_PATH .'\includes\navigation.php')?>
	<?php require_once (ROOT_PATH .'\includes\getauthorImage.php')?>
	<head>
		<title>Website Project</title>
		<link rel="stylesheet" type="text/css" href="css/home.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	</head>
	<?php
		global $data,$user;
		$userarray=$GLOBALS["userArr"];
		$userDetailsarray=$GLOBALS["specificUserArr"];
		$imagesArray=$GLOBALS["allUserImages"];
		
		function fillPostArray($postsQuery){
			$postArr = array();
			$y=0;
			while($posts = mysqli_fetch_array($postsQuery)){
				$postsArr = array();
				$postsArr["Author"] = $posts["Author"];
				$postsArr["Title"] = $posts["Title"];
				$postsArr["TextContent"] = $posts["TextContent"];
				$postsArr["ImageContent"] = $posts["ImageContent"];
				$postsArr["Likes"] = $posts["Likes"];
				$postsArr["Comments"] = $posts["Comments"];
				$postsArr["Community"] = $posts["Community"];
				$postsArr["PostType"] = $posts["PostType"];
				$postsArr["Upload"] = $posts["Upload"];
				array_push($postsArr,$postsArr["Author"],$postsArr["Title"],$postsArr["TextContent"],$postsArr["ImageContent"],$postsArr["Likes"],$postsArr["Comments"]
				,$postsArr["Community"],$postsArr["PostType"],$postsArr["Upload"]);
				array_push($postArr,$postsArr);
				$y++;
				if($y==5) break;
			}
			return $postArr;
		}
		
		function fillUserArray($usersListQuery){
			$userArr = array();
			while($users = mysqli_fetch_array($usersListQuery)){
				$usersArr = array();
				$usersArr["Username"] = $users["Username"];
				$usersArr["Password"] = $users["Password"];
				$usersArr["Age"] = $users["Age"];
				$usersArr["Email"] = $users["Email"];
				$usersArr["Gender"] = $users["Gender"];
				$usersArr["Image"] = $users["Image"];
				$usersArr["Bio"] = $users["Bio"];
				$usersArr["Likes"] = $users["Likes"];
				array_push($usersArr,$usersArr["Username"],$usersArr["Password"],$usersArr["Age"],$usersArr["Email"],$usersArr["Gender"],$usersArr["Image"]
				,$usersArr["Bio"],$usersArr["Likes"]);
				array_push($userArr,$usersArr);
			}
			return $userArr;
		}
		
		function toPost($post){
			$_SESSION['statusPost'] = "selected";
			$_SESSION['AuthorPost'] = $post["Author"];
			$_SESSION['TitlePost'] = $post["Title"];
			$_SESSION['ImageContentPost'] = $post["ImageContent"];
			$_SESSION['TextContentPost'] = $post["TextContent"];
			$_SESSION['StarsPost'] = $post["Likes"];
			$_SESSION['CommentsPost'] = $post["Comments"];
			$_SESSION['commSelected'] = $post["Community"];
			$_SESSION['PostTypePost'] = $post["PostType"];
			header("Location:post.php");
		}
		
		function toUserProfile($user){
			$_SESSION['statusUser'] = "selected";
			$_SESSION['UsernameUser'] = $user["Username"];
			$_SESSION['AgeUser'] = $user["Age"];
			$_SESSION['EmailUser'] = $user["Email"];
			$_SESSION['GenderUser'] = $user["Gender"];
			$_SESSION['ImageUser'] = $user["Image"];
			$_SESSION['BioUser'] = $user["Bio"];
			$_SESSION['LikesUser'] = $user["Likes"];
			header("Location:userProfile.php");
		}
		
		function displayPostsIfUser($postArr,$imagesArray,$userarray){
			foreach(array_values($postArr) as $key => $post){
				$profilePic=searchAuthor($post["Author"],$imagesArray);
					echo "<div class='singlePost'>";
					echo "<img class='userImg' src='data:image/jpeg;base64,".base64_encode($profilePic)."'>";
					echo "<form class='userBtnForm' method='post'>";
					echo "<input class='userBtn' type='submit' name='".$post["Author"]."Btn' value=''/>";
					echo "</form>";
					echo "<form class='postBtnForm' method='post'>";
					echo "<input class='postUserBtn' type='submit' name='userBtn' value='".$post["Author"]."'/>";
					echo "</form>";
					echo "<form method='post'>";
					echo "<input class='postTitleBtn' type='submit' name='goToPost' value='".$post["Title"]."'/><br><br>";
					echo "</form>";
					echo "<label class='stars'> ".$post["Likes"]." Stars </label>";
					echo "<label class='comments'> ".$post["Comments"]." Comments </label>";
					echo "<br>";
					echo "</div>";
			}
			return;
		}
		
		function displayPostsIfAdmin($postArr,$imagesArray,$userarray){
			foreach(array_values($postArr) as $key => $post){
				$profilePic=searchAuthor($post["Author"],$imagesArray);
					echo "<div class='singlePost'>";
					echo "<img class='userImg' src='data:image/jpeg;base64,".base64_encode($profilePic)."'>";
					echo "<form class='userBtnForm' method='post'>";
					echo "<input class='userBtn' type='submit' name='".$post["Author"]."Btn' value=''/>";
					echo "</form>";
					echo "<form class='postBtnForm' method='post'>";
					echo "<input class='postUserBtn' type='submit' name='userBtn' value='".$post["Author"]."'/>";
					echo "</form>";
					// echo "<img class='delImg' src='pictures/delete.png'/>";
					// echo "<form class='deleteBtnForm' method='post'>";
					// echo "<input class='deleteBtn' type='submit' name='deleteBtn' value='".$post["Title"]."'/><br><br>";
					// echo "</form>";
					echo "<form method='post'>";
					echo "<input class='postTitleBtn' type='submit' name='goToPost' value='".$post["Title"]."'/><br><br>";
					echo "</form>";
					//echo "<label class='postTitle'><a class='postTitle' href='' name='".$$post[$key]["Title"]."'> ".$postsArr["Title"]." </a></label><br>";
					echo "<label class='stars'> ".$post["Likes"]." Stars </label>";
					echo "<label class='comments'> ".$post["Comments"]." Comments </label>";
					echo "<br>";
					echo "</div>";
			}
			return;
		}
		
		function displayPostsIfAnonymous($postArr,$imagesArray,$userarray){
			foreach(array_values($postArr) as $key => $post){
				$profilePic=searchAuthor($post["Author"],$imagesArray);
					echo "<div class='singlePost'>";
					echo "<img class='userImg' src='data:image/jpeg;base64,".base64_encode($profilePic)."'>";
					echo "<form class='userBtnForm' method='post'>";
					echo "<input class='userBtn' type='submit' name='".$post["Author"]."Btn' value=''/>";
					echo "</form>";
					echo "<form class='postBtnForm' method='post'>";
					echo "<input class='postUserBtn' type='submit' name= 'userBtn'value='".$post["Author"]."'/>";
					echo "</form>";
					echo "<form method='post'>";
					echo "<input class='postTitleBtn' type='submit' name='goToPost' value='".$post["Title"]."'/><br><br>";
					echo "</form>";
					//echo "<label class='postTitle'><a class='postTitle' href='' name='".$$post[$key]["Title"]."'> ".$postsArr["Title"]." </a></label><br>";
					echo "<label class='stars'> ".$post["Likes"]." Stars </label>";
					echo "<label class='comments'> ".$post["Comments"]." Comments </label>";
					echo "<br>";
					echo "</div>";
			}
		}
	?>
	<body>
	
			<div class="title">
				<label class="titleLabel"> HOME </label>
			</div>
		
			<!--LEFT SIDE-->
			<div class="info">
				
			</div>
			
			
			<!--MAIN SECTION-->
			<div class="sections">
				<nav>
					<ul>
					  <li data-rel="1" class="active">Recent</li>
					  <li><span class="divider1"> </span></li>
					  <li data-rel="2">Popular</li>
					</ul>
				</nav>
				<br>
				 
				<!--RECENT SECTION-->
				<section> <article>
					<div class ="post">
						<?php
							$postsQuery = mysqli_query($data,"select * from posts order by Upload DESC");					
							
							$postArr=fillPostArray($postsQuery);
						
							$usersListQuery = mysqli_query($user,"select * from userdetails");
							
							$userArr=fillUserArray($usersListQuery);
							
							// Go to post.php	
							if(isset($_POST['goToPost']))
							{
								foreach($postArr as $post){
									if($post['Title']==$_POST['goToPost'])
									{
										toPost($post);
									}
								}
							}

							// go to user.php
							if(isset($_POST['userBtn'])){
								foreach($userArr as $user){
									if($_POST['userBtn'] == $user["Username"]){
										toUserProfile($user);
									}
								}
							 }
							

							$profilePic="";
							if($signedInStatus == "True"){
								if($userarray[3] == "User"){
									displayPostsIfUser($postArr,$imagesArray,$userarray);
								} else {
									displayPostsIfAdmin($postArr,$imagesArray,$userarray);
								}
							} else {
								displayPostsIfAnonymous($postArr,$imagesArray,$userarray);
							}
						?>
					</div>			
				</article></section> 
			
				<!--POPULAR SECTION-->
				<section> <article>
					<div class ="post">
						<?php
							$postsQuery = mysqli_query($data,"select * from posts order by Likes DESC");					
							
							$postArr=fillPostArray($postsQuery);
						
							$usersListQuery = mysqli_query($user,"select * from userdetails");
							
							$userArr=fillUserArray($usersListQuery);
							
							// Go to post.php	
							if(isset($_POST['goToPost']))
							{
								foreach($postArr as $post){
									if($post['Title']==$_POST['goToPost'])
									{
										toPost($post);
									}
								}
							}

							// go to user.php
							if(isset($_POST['userBtn'])){
								foreach($userArr as $user){
									if($_POST['userBtn'] == $user["Username"]){
										toUserProfile($user);
									}
								}
							 }

							if($signedInStatus == "True"){
								if($userarray[3] == "User"){
									displayPostsIfUser($postArr,$imagesArray,$userarray);
								} else {
									displayPostsIfAdmin($postArr,$imagesArray,$userarray);
								}
							} else {
								displayPostsIfAnonymous($postArr,$imagesArray,$userarray);
							}
						?>
					</div>			
				</article></section>
		
			</div>
			
			
			
			<?php
				$threadQuery = mysqli_query($data,"select * from posts where PostType='Thread'");
				$threadsCount = mysqli_num_rows($threadQuery);
				$projectQuery = mysqli_query($data,"select * from posts where PostType='Project'");
				$projectsCount = mysqli_num_rows($projectQuery);
			?>
			
			<!--RIGHT SIDE-->
			<div class="data">
				<ul class="data">
					<li class="threadsNum">Total Threads: <?php echo $threadsCount; ?></li>
					<li class="projectsNum">Total Projects: <?php echo $projectsCount; ?></li>
				</ul>
			</div>
			
			<!--FOOTER-->
			<?php require_once (ROOT_PATH .'\includes\footer.php')?>
				
		</div>
		<script>
		(function($) {
			$('nav li').click(function() {
			  $(this).addClass('active').siblings('li').removeClass('active');
			  $('section:nth-of-type('+$(this).data('rel')+')').stop().fadeIn(400, 'linear').siblings('section').stop().fadeOut(400, 'linear'); 
			});
		  })(jQuery);
		</script>
	</body>
</html>