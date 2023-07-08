<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config.php';

use Medoo\Medoo;

global $conf;

$database = new Medoo([
    'type' => 'mysql',
    'host' => 'localhost',
    'database' => 'lists',
    'username' => 'lists',
    'password' => $conf->dbpass
]);

$lists = $database->select('lists', '*');

// If a list has been selected, set this as the active list
// Otherwise, set the first list as active (default)
if (isset($_GET['list'])) {
	$active_list = $_GET['list'];
}
else {
	$active_list = $lists[0]['id'];
}
?>
<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Dylan Keys lists">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="author" content="Dylan Keys">
      <link rel="icon" href="images/favicon.ico">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

      <!-- Font Awesome -->
      <script src="https://kit.fontawesome.com/f1d81b1e61.js" crossorigin="anonymous"></script>

      <!-- DK CSS -->
      <link rel="stylesheet" href="styles.css">

      <title>Dylan Keys</title>
   </head>
   <body>
      <div class="nav">
         <ul class="nav">
				<?php
				foreach ($lists as $list) {
					if ($list['id'] == $active_list) {
						echo '<li class="active"><a href="index.php?list='.$list["id"].'">'.$list["name"].'</a></li>';
					}
					else {
						echo '<li><a href="index.php?list='.$list["id"].'">'.$list["name"].'</a></li>';
					}
				}
				?>
         </ul>
      </div>

      <div class="container">
         <div class="row">
            <div class="col-md-auto">
               <div class="lists">
						<table class="table">
						  	<thead>
						    	<tr>
						    		<th scope="col">Name</th>
						      	<th scope="col">Order</th>
						    	</tr>
						  	</thead>
						  	<tbody>
								<form method="post" action="index.php">
								<?php
								$list_data = $database->select('list_data', ['name', 'listorder'], ['listid' => $active_list, 'ORDER' => 'listorder']);
						
								foreach ($list_data as $list_item) {
									echo '<tr>';
									echo '<td><input class="form-control" type="text" name="'.$active_list.'[name]" value="'.$list_item['name'].'"></td>';
									echo '<td><input class="form-control" type="text" name="'.$active_list.'[order]" value="'.$list_item['listorder'].'"></td>';
									echo '</tr>';
								}
								?>
								</form>
							</tbody>
						</table>
					</div>  
				</div>
			</div>
      </div>
	 
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
   </body>
</html>