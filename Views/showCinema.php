<?php
include('navbaradmin.php');
?>
<main class="d-flex  justify-content-center ">
	<div class="content">
		<header class="text-center">
			<h2 class="fuente4 text-center">Cinema: </h2>

			<form method="POST">
				<div class="p-2">
					<button formaction="<?php echo FRONT_ROOT ?>Cinema" class="btn btn-secondary" type="submit" name="action" value="register"> Back </button>
				</div>
				<?php

				if (empty($cinemaFound)) {

					echo "Cinema " . $cinemaSearched . " don't found";
				} else {
					?>


				</header>
				<div class="login-form bg-dark-alpha p-5 bg-light">
					<section>
						<br>                         
						<div class="form-group">
							<div class="form-group">
								<br>
								<input type="text" name="id"  value="<?php echo $cinemaFound->getId() ?>"  required class="form-control"readonly="readonly">
								<br>
								<input type="text" name="name" value="<?php echo $cinemaFound->getName() ?>" required class="form-control" >
								<br>
								<input type="text" name="adress" value="<?php echo $cinemaFound->getAdress() ?>" required class="form-control">
								<br>
								<input type="text" name="openingTime" value="<?php echo $cinemaFound->getOpeningTime() ?>"  required class="form-control">
								<br>
								<input type="text" name="closingTime" value="<?php echo $cinemaFound->getClosingTime()?>" required class="form-control">
								<br>
								<input type="text" name="ticketValue" value="<?php echo $cinemaFound->getTicketValue() ?>" required class="form-control">
								<br>
								<input type="text" name="capacity" value="<?php echo $cinemaFound->getCapacity() ?>" required class="form-control">
								<br>
							</div>
						</div>
					</section>
				</div>
			</div>
		</main>
		<?php
	}
	?>



