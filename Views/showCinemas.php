<?php
use Models\PopupAlert;
include ('navbaradmin.php');

?>
<br>
<br>
<br>
<h2 class="fuente4 text-center">Cinemas Admin</h2>
<br>
<br>
<br>

<form method="POST">
	<div class="p-2 text-center">
		<button formaction="<?php echo FRONT_ROOT ?>Cinema"
			class="btn btn-info" type="submit" name="action" value="register">
			Back</button>
	</div>
	<br> <br> <br>
	<div class="table-responsive">
		<table class="table">
			<thead class="thead-dark">


				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Address</th>
					<th>Opening Time</th>
					<th>Closing Time</th>
					<th>Ticket Value</th>
					<th>Capacity</th>
					<th></th>

				</tr>
			</thead>
			<tbody class="table-hover">

    <?php
    if (is_array($cinemaList) || is_object($cinemaList)) {
        foreach ($cinemaList as $cinema) {
            ?>
        <tr>
					<td><?php echo $cinema->getidCinema()?></td>
					<td><?php echo $cinema->getnameCinema()?></td>
					<td><?php echo $cinema->getaddress()?></td>
					<td><?php echo $cinema->getopeningTime(). 'hs<br>';?></td>
					<td><?php echo $cinema->getclosingTime(). 'hs<br>';?></td>
					<td><?php echo "$" . $cinema->getticketValue();?></td>
					<td><?php echo $cinema->getcapacity();?></td>
					<th>
						<div class="row">
							<form method="POST">
								<div class="p-2">
									<button formaction="<?php echo FRONT_ROOT ?>Room/List"
										class="btn btn-dark" type="submit" name="room"
										value="<?php echo $cinema->getidCinema(); ?>">Rooms</button>
								</div>
								<div class="p-2">
									<button
										formaction="<?php echo FRONT_ROOT ?>Cinema/ModifyCinema"
										class="btn btn-warning" type="submit" name="modifyId"
										value="<?php echo $cinema->getidCinema(); ?>">Modify</button>
								</div>
								<div class="p-2">
									<button
										formaction="<?php echo FRONT_ROOT ?>Cinema/DeleteCinema"
										class="btn btn-danger" type="submit" name="deleteId"
										value="<?php echo $cinema->getidCinema(); ?>">Delete</button>
								</div>
								<div class="p-2">
									<button formaction="<?php echo FRONT_ROOT ?>Cinema/Statistics"
										class="btn btn-primary" type="submit" name="cinemaId"
										value="<?php echo $cinema->getidCinema(); ?>">Statistics</button>
								</div>
							</form>
					
					</th>
				</tr>
    <?php
        }
    }
    ?>              
</tbody>
		</table>
	</div>