<?php
include "header.php";
$table = $prefix . 'pages-layolt';
$query = $mysqli->query("SELECT * FROM `$table` WHERE page='Spam'");
$row   = mysqli_fetch_array($query);
?>
        <br />
        <div class="row">
          <div class="col-lg-12">
              <div class="jumbotron">
                <center>
				<div class="alert alert-danger" style="background-color: #d9534f; color: white;">
                    <h4 class="alert-heading"><?php
echo html_entity_decode($row['text']);
?></h4>
                </div><br />
				
                    <p style="font-size: 30px;"><i class="fas fa-keyboard fa-4x"></i></p>
                <h5>Please contact with the webmaster of the website if you think something is wrong.</h5>
				
				<br />
	            <a href="mailto:<?php echo $rowst['email']; ?>" class="btn btn-primary btn-block" target="_blank"><i class="fas fa-envelope"></i> Contact</a>
                
				<br />
                <h5>To check in which Spam Database (DNSBL) you attend click the button below:</h5>
                <a href="https://www.dnsbl.info/dnsbl-database-check.php" class="btn btn-info btn-block" target="_blank">Check</a>
				
				</center>
              </div>
          </div>
        </div>

<?php
include "footer.php";
?>