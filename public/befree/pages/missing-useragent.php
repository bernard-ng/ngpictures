<?php
include "header.php";
?>
        <br />
        <div class="row">
          <div class="col-lg-12">
              <div class="jumbotron">
                <center>
				<div class="alert alert-danger" style="background-color: #d9534f; color: white;">
                    <h4 class="alert-heading">The User-Agent header is missing from your HTTP Request</h4>
                </div><br />
				
                <h5>Please contact with the webmaster of the website if you think something is wrong.</h5>
				
				<br />
	            <a href="mailto:<?php echo $rowst['email']; ?>" class="btn btn-primary btn-block" target="_blank"><i class="fas fa-envelope"></i> Contact</a>
                
				</center>
              </div>
          </div>
        </div>

<?php
include "footer.php";
?>