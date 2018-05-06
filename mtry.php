<?php
  include "modules/connect.php";
  include "modules/verify.php";
  
 
if (isset($_SESSION['email'])){
    $e=$_SESSION['email'];
  
  }
   	$sql= "SELECT * FROM messages where to_whom='$e' ORDER BY m_id DESC";
   	$result=mysqli_query($conn,$sql);
 
   	$sql2= "SELECT MAX(m_id) as maxid FROM messages WHERE to_whom='$e'";
   	$result2=mysqli_query($conn,$sql2);
   $Row2 = (mysqli_fetch_assoc($result2));
    
  $max_msg = $Row2["maxid"];
  ?>
	
<head>
  <title>Message</title><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
	var timeout = setInterval(reloadChat, 1000);    
  function reloadChat () {
  	 $('#newchats').load("mtry.php?i=<?php echo $max_msg; ?> #container");
		
}
 function success() {
	 if(document.getElementById("textsend").value==="") { 
            document.getElementById('start_button').disabled = true; 
		    document.getElementById('throw').innerHTML= "Message cannot be empty!"
        } else { 
            document.getElementById('start_button').disabled = false;
			
        }
    }
</script>

  
<p4>MessageBucket: The Real-time chat system </p4><br>
<form  class="form-group block" id="write-area" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	
	<div  class="form-group" id="write-id"><textarea class="form-control input-lg-18" id="textsend" rows="4" cols="30" onkeyup="success()" name="sendthis" placeholder="Enter your Message ..."></textarea><button type="submit"  id="start_button" onclick="verify()" disabled>Send <i class="fa fa-paper-plane"></i></button><p id="throw"></p>
		</div>
	 </form>
<div class="bar">
  Navigate to:<a href="sentmessages.php"> Sent Messages</a> | <a href="dashboard.php"> Dashboard</a> | 
	<a href="modules/logout.php"> Logout</a></div> <h2>Inbox Messages here:</h2>


<?php	

   if(isset($_POST) & !empty($_POST))  {
	   		$insertmsg = $_POST['sendthis'];  
	   $Row=mysqli_fetch_array($result);
	      		$fname=$Row["fname"];
				 $sql4 = "INSERT INTO `messages`( `email`, `to_whom`, `text`, `time`, `fname`) VALUES ('$e','test@gmail.com','$insertmsg',CURRENT_TIMESTAMP,'$fname');";
				$result4=mysqli_query($conn,$sql4); }
 ?>


	
<form  id="newchats">

	
</form>
<div id="container">
	
    <?php 
      if (isset($_GET['i'])) {
          $min = $_GET['i'];
      	$minus = $_GET['i'];
      	$minus=$minus+1;
         
      	$sql2= "SELECT MAX(m_id) as maxid FROM messages";
      	   $result2=mysqli_query($conn,$sql2);
      	$row2=(mysqli_fetch_assoc($result2));
      	 $max =  $row2["maxid"];
		  
      	if($max > $min) { 
		
			
			$sql3 = "SELECT * FROM messages where to_whom='$e' and email='test@gmail.com' and m_id BETWEEN $minus AND $max 
      		 ORDER BY m_id DESC";
      		$result3=mysqli_query($conn,$sql3);
      			while($row3=mysqli_fetch_array($result3)) 	 { ?>
	<div id="newchats" class="cardfornewchats">
    <div class="newchatsclass" id="new">
      <?php echo "<b><br><b><p2>".$row3['text']; ?><br>
	<br>	<?php echo "</p2><p3>From: Admin &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "."Email:".$row3['email']; ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<?php echo "time : ".$row3['time'];"</p3>" ?>
    </div>
  </div>
	<?php } 
    
	  } } 
      ?>
  </div>
<form>
  <?php if(mysqli_num_rows($result)>0){
    while ($Row=mysqli_fetch_array($result)) {
    ?>
  <div id="card" class="card">
    <div class="container" id="oldchats">
      <?php echo "<b><br><b><p2>".$Row['text']; ?><br>
	<br>	<?php echo "</p2><p3>From: Admin &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "."Email:".$Row['email']; ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<?php echo "time : ".$Row['time'];"</p3>" ?>
    </div>
  </div>
  <?php	} } else{
	echo nl2br("If you're New here, Start Conversation!");
}
?>
</form>
<style>
	
	body{
		background-color: #ffffff;margin:3px;
	}

  button {
  width:110px;
  height:35px;
  position: fixed;
  position: sticky;
  top: 0;
  background-color:#2cd6ff;
  border: 2px solid #adadad;
  font-weight: bolder;
  font-family: monospace;
	  color:white;
	  font-size: 15px;
  }
	button:hover{
		background-color:#f2f2f2;
  border: 2px solid #2cd6ff;
		color:#2cd6ff;
		font-weight: bolder;
	}
	
  #textsend{
  font-family:monospace;
  word-spacing: 6px;
  letter-spacing: 2px;
  font-size: 15px;text-align:left;
  font-weight: bolder;
  background-color: #ffffff;
  font-family:monospace;
  color:black;font-weight: bolder;
  border: 3px solid #a2a2a2;
  
  }

  .card,.cardfornewchats,.newchatscard {
  padding-bottom: 1%;
  padding-top: 1%;
  padding-left: 2%;
  padding-right: 2%;
  letter-spacing: 1px;
  word-spacing: 4px;
   text-align: left;
  transition: 0.1s; 
	  word-wrap: break-word;
  width:100%;
  color: #2f2f2f;
  background-color: #f4f1f1;
  border-color: #2fe0e0;	
  margin: 17px;
  font-family: cursive;
	  border-left:5px solid #00ceff;background: linear-gradient(-90deg, #ffffff, #fcfeff);
  }
  .card:hover,.newchatscard:hover {
  box-shadow: 1px 2px 1px 0 rgb(49, 49, 49);
background-color: #f7f5f5;
  font-family: cursive;
  }

  .container,.newchatsclass,.newchatscontainer {
 resize: both;
  overflow: auto;
  font-size: 16px;
  letter-spacing: 1px;
	  width:100%;
  }
  form {
  width: 70%;
  padding-right: 3%;
  padding-left: 3%;
  }
	p2{
		font-size: 17px;
		font-family: monospace;
	}p3{
		font-size: 10px;
		font-family:serif;
		color: cadetblue;
	}
	#throw{
		font-family: monospace;
		font-size:15px;
		color: red;
	}
	p4{
		font-family: monospace;
		font-size: 20px;
		color: #a2a2a2;
		letter-spacing: 5px;
		font-weight: bolder;
	}
	
	h2{
		font-size: 13px;
		text-align:  center;
	}
	@media only screen and (max-width: 800px) {
    
        form {
  width: 100%;
  padding-right: 5%;
  padding-left: 1%;
  }
		 .card,.cardfornewchats,.newchatscard {
		border: 1px solid #070707;
		 border-left:2px solid #2cd6ff;
	}
		p4{
		font-family: fantasy;
		font-size: 14px;
		color: #a2a2a2;
		letter-spacing: 0px;
		font-weight:100;
	}
	}
	
</style>