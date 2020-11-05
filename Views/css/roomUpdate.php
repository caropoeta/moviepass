<form method="POST" action=<?php echo FRONT_ROOT."Room/Update";?>>
        <div align="center">
            <h2 class="title-secondary">Update room:</h2>
            <div class="login-form"> 
				 <div class="form-group">
                <input style="width:50%" type="hidden" name="name" value="<?php echo $room->getName() ?>" placeholder="Nombre" class="form-group" readonly="readonly">
                <input style="width:50%" type="number" name="capacity" value="<?php echo $room->getCapacity() ?>" placeholder="Capacidad" required class="form-group" min="10" max="300">
                <input style="width:50%" type="number" name="price" value="<?php echo $room->getPrice() ?>" placeholder="Price" required class="form-group" min="10" max="300">
                
                <input style="width:50%" type="hidden" name="idCinema" value="<?php echo $room->getCinema()->getidCinema() ?>" placeholder="IdCinema" class="form-group" readonly="readonly">
                <br>
                <input type="hidden" readonly name="roomId" value=<?php echo $room->getId() ?>>
                
                <br>
                <br>
                <button class="botons"style="width:50%" type="submit">Update</button>
        </div>
    </form>
</div>
</div>
