<?php require_once 'config.php'?>
<?php require_once (ROOT_PATH .'\includes\header.php')?>
<?php require_once (ROOT_PATH .'\includes\navigation.php')?>
<html>
	<head>
		<title>Website Project</title>
		<link rel="stylesheet" type="text/css" href="css/editComment.css">
	</head>
	<body>
		<!-- TITLE -->
		<div class="title">
			<?php
				//displays chosen community as title
				if($_SESSION['status'] == "selected"){
					echo "<label class='titleLabel'>".$_SESSION['commSelected']."</label>";
				}
				
			?>		
		</div>
		
		<!-- DIVIDER BEWTEEN THREAD AND PROJECT
		<div class="headers">
			<label class="threads"><a href="#"> Threads </a></label>
			<span class="divider1"> </span>
			<label class="projects"><a href="#"> Projects </a></label>
		</div> -->
			
		<div class="back">
			<form class="backForm" action="post.php" method="post">
				<input class="backBtn" type="submit" name="backBtn" value="Back to Post" />
			</form>
		</div>	
			
		<!-- EDIT POSTS -->
		<div class="edit">
		<?php
			global $data;
			$userarray=$GLOBALS["userArr"];
			$errorMessage="";
			$statement="select * from commentpost where id = '".$_SESSION['id']."'";
			$result=mysqli_query($data,$statement);
			$commentdata=mysqli_fetch_array($result);
            $firstContent=$commentdata['TextComment'];
            $firstImage=$commentdata['ImageComment'];
			$author= $commentdata['Username'];
			$title= $commentdata['Title'];
			
			if(isset($_POST["editBtn"]))
			{
				if($signedInStatus == "True"){
					if ($_SERVER["REQUEST_METHOD"] == "POST")
					{
						$title=$content=$statement=" ";
						if(empty($_POST["editContent"])){
							$errorMessage = "Fill up Content";
						}
						else{
							$content=$_POST["editContent"];
							$community=$_SESSION['commSelected'];
							if(empty($_FILES["editImage"]["name"]))
							{	
                                $contentUpdate="update commentpost set TextComment = '$content' Where id ='".$_SESSION['id']."'";
                                mysqli_query($data,$contentUpdate);
								header("Location:post.php");
								exit();
							}
							else{
								//get file info
								$fileName = $_FILES["editImage"]["name"];
								$fileError= $_FILES["editImage"]["error"];
								$filetmp = $_FILES["editImage"]["tmp_name"];
								$fileExt = explode('.',$fileName);
								$fileActualExt = strtolower(end($fileExt));
								// Allow certain file formats 
								$allowTypes = array('jpg','png','jpeg','gif'); 
								if(in_array($fileActualExt, $allowTypes)){ 
									if($fileError === 0)
									{
										$fileNameNew = $fileExt[0].".".$fileActualExt;
										$fileDestination ='upload/'.$fileNameNew;
										move_uploaded_file($filetmp,$fileDestination);
										$contentUpdate="update commentpost set TextComment = '$content' Where id ='".$_SESSION['id']."'";
                                		mysqli_query($data,$contentUpdate);
                                        $FileUpdate="update commentpost set ImageComment = '$fileDestination' Where id ='".$_SESSION['id']."'";
                                        mysqli_query($data,$FileUpdate);
										header("Location:post.php");
										exit();
									}else{
										$errorMessage="File Upload Failed";
									}
								}
								else{
									$errorMessage="Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
									}
							}
						}
					}
				} else {
					$errorMessage = "You have to be logged in to do that!";
				}
			}
			?>
			<form method ="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>" >
				<label class="editComment"> Edit Comment </label>
				<table class="editDetails">
					<!--<tr><td><input class="contentInput" type = "text" name = "createContent" Placeholder="Thread Discussion"/></td></tr>-->
					<tr><td><textarea class="contentInput" rows='15' cols='35' name='contentInput'><?php echo $firstContent;?></textarea></td></tr>
                    <tr><td><img class='postImg' src='<?php echo $firstImage;?>'/></td></tr>
					<tr><td><input class="imageInput" type = "file" name = "imageInput"></td></tr>
					<tr><td><span style="color:red"> <?php echo $errorMessage;?> </span></td></tr>
					<tr><td><input class="editBtn" type = "submit" name = "editBtn" value="Edit Comment"/></td></tr>
				</table>
			</form>
		</div>
			
		<!--FOOTER-->
		<?php require_once (ROOT_PATH .'\includes\footer.php')?>
		
	</body>
</html>