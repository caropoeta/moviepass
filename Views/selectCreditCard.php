<?php

use Models\CreditCard;

if ($currRole == ADMIN_ROLE_NAME) include('navbaradmin.php');

if ($currRole == CLIENT_ROLE_NAME) include('navbarclient.php');
?>

<div>

    <label style="color:#fff" >Number of tickets to buy: <?php echo ' ' . $numberOfTickets ?></label>
    <br>
    <label style="color:#fff">Total price: <?php echo ' $' . $totalPrice ?></label>
    <br>
    <table class="table bg-light">
        <thead class="bg-dark text-white">
            <th>Issuer</th>
            <th>Number</th>
            <th>Delete</th>
            <th>Select</th>
        </thead>
        <tbody>
            <?php foreach ($creditCards as $cc) {
                if ($cc instanceof CreditCard) { ?>
                    <tr>
                        <td><?php echo $cc->getIssuer() ?></td>
                        <td><?php echo substr_replace($cc->getNumber(), 'XXXXXXXXXXXX', 0, 12) ?></td>

                        <td>
                            <form method="POST">
                                <input type="hidden" name="numberOfTickets" value="<?php echo $numberOfTickets ?>">
                                <input type="hidden" name="functionId" value="<?php echo $functionId ?>">

                                <button formaction="<?php echo FRONT_ROOT ?>Ticket/DeleteCreditCard" class="botons" name="ccn" value="<?php echo $cc->getNumber() ?>" type="submit">
                                    Delete
                                </button>
                            </form>
                        </td>
                        <td><button type="button" class="botons" data-toggle="modal" data-target="<?php echo '#ccSelect' . $cc->getNumber(); ?>">
                                Select
                            </button></td>
                    </tr>

                    <div class="modal fade bd-example-modal-lg" id="<?php echo 'ccSelect' . $cc->getNumber(); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Select credit card</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="numberOfTickets" value="<?php echo $numberOfTickets ?>">
                                        <input type="hidden" name="functionId" value="<?php echo $functionId ?>">

                                        <label for="ccsc">Credit card security code:</label>
                                        <input id="ccsc" type="number" name="ccsc" min="100" max="999" required>

                                        <input type="hidden" name="ccn" value="<?php echo $cc->getNumber() ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="botons-chico" data-dismiss="modal">Close</button>
                                        <button formaction="<?php echo FRONT_ROOT ?>Ticket/GetAuthorization" class="botons-chico" type="submit">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
    <hr>
    <button type="button" class="botons-chico" data-toggle="modal" data-target="#ccAdd">
        Add
    </button>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="ccAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">Add credit card</h2>
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <h5>Visa or Mastercard</h5>
                    <div class="modal-body">
                        <input type="hidden" name="numberOfTickets" value="<?php echo $numberOfTickets ?>">
                        <input type="hidden" name="functionId" value="<?php echo $functionId ?>">

                        <label for="creditCardNumber">Credit Card Number:</label>
                        <input id="creditCardNumber" type="number" name="creditCardNumber" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx" required>
                        <br>
                        <label for="expireDate">Expire Date:</label>
                        <input type="month" id="expireDate" name="expireDate" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="botons-chico" data-dismiss="modal">Close</button>
                        <button formaction="<?php echo FRONT_ROOT ?>Ticket/AddCreditCard" class="botons-chico" type="submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>