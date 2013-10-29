<section class="title">
    <h4>Confirmed Payments</h4>
</section>

<section class="item">
    <div class="content">    
    <?php if ( ! empty($payments)): ?>
    
        <table class="table-list">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Payment Date</th>
                    <th>Invoice</th>
                    <th>Payment Amount</th>
                    <th>Confirmation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $payments as $payment ): ?>
                <tr>
                    <td><?php echo $payment->id; ?></td>
                    <td><?php echo $payment->date; ?></td>
                    <td><?php echo $payment->invoice; ?></td>
                    <td>$<?php echo $payment->value; ?></td>
                    <td><?php echo $payment->confirm; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="blank-slate">
            <div class="no_data">
                No payments made yet.
            </div>
        </div>
    <?php endif;?>
    </div>
</section>