<?php
use Models\PopupAlert;
include ('navbaradmin.php');
?>
<main class="d-flex  justify-content-center ">
	
	<div class="content">
		<h2 class="title-secondary">Statistics</h2>
		<header class="text-center">
			<div class="p-2 text-center">
				<form method="POST">
					<div class="p-2">
						<button formaction="<?php echo FRONT_ROOT ?>Cinema"
							class="btn btn-secondary" type="submit" name="action"
							value="register">Back</button>
					</div>
				</form>
			</div>
			<br>
			

		</header>
		<div class="table-responsive">
			<form method="POST">
				<table class="table">
					<tbody class="table-hover">
						<tr>
							<td><br>
								<p>Enter Start Day</p> <input type="date" name="startDate"
								value="<?php echo date('Y-m-d', time()) ?>"
								placeholder="Enter Start Day" required class="form-control"> <br>
							</td>
							<td><br>
								<p>Enter Finish Day</p> <input type="date" name="finishDate"
								value="<?php echo date('Y-m-d', time()) ?>"
								placeholder="Enter Finish Day" required class="form-control"> <br>
							</td>
						</tr>
						<tr>
						</tr>
					</tbody>
				</table>
		
		</div>
		<div class="text-center">
			<button formaction="<?php echo FRONT_ROOT ?>Cinema/ShowStatistics"
				class="botons-chico" type="submit" name="cinemaId"
				value="<?php echo $cinemaId; ?>">Search</button>
			</form>
		</div>
		<br>
	</div>
</main>
<?php
include ('footer.php');
?>
	