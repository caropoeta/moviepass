<?php
include('navbaradmin.php');
?>
<main class="d-flex  justify-content-center ">
	<div class="content">
		<header class="text-center">
			<h2 class="fuente4 text-center">Cinema: </h2>
		</header>
		<?php
		if (empty($cinemaFound)) {

			echo "Cinema " . $cinemaSearched . " don't found";
		} else {
			?>
			<div class="login-form bg-dark-alpha p-5 bg-light">
				<section>
					<br>
					<div class="form-group">

						<div class="form-group">
							<br>
							<input type="text" name="id"  value="<?php echo $cinemaFound->getId() ?>"  required class="form-control">
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
						</div>
						
					</div>
				</section>
			</div>
		</div>
	</main>
	<?php
}
?>
