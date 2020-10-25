<form method="POST"  action=<?php echo FRONT_ROOT."Room/Add";?>>
		<div align="center">
			 <h2>Add Room </h2>
			 <div class="form-register"> 
				 <div class="form-register-ul">
     			<input style="width:50%" type="text" name="name" placeholder="Room Name" required class="form-control">
			<br>
     			<input style="width:50%" type="number" name="capacity" placeholder="Capacity" required class="form-control" min = "10" max = "500">
			<br>
				<input type="hidden" name="idCinema" value = <?php echo $cinemaId ?>>
     			<button type="submit">Add</button>
    </form>
</div>
</div>
</div>
