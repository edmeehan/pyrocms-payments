{{ asset:js file="module::payment.js" }}
{{ asset:css file="module::style.css" }}

<script src="https://js.braintreegateway.com/v1/braintree.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
 var braintreeClientKey = '<?php echo $data['clientKey']; ?>';
</script>

<?php echo form_open(null,array('id'=>'form_cc')); ?>
<fieldset>
    <legend>Credit Card Information</legend>
    
    <?php if(@$data['error']): ?>
    <div class="row">
        <div class="span12">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Oops!</strong>
                <?php echo $data['error']; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="row-fluid">
        <div class="span6">
            
            <!-- Credit Card Number -->
            <label>Card Holder Name</label>
            <input type="text" class="span9" autocomplete="off" data-encrypted-name="cc_name" />
            <span class="help-block">Enter name as it appears on card</span>
            
            <!-- Credit Card Number -->
            <label>Credit Card Number</label>
            <input type="text" class="span9" autocomplete="off" data-encrypted-name="cc_num" />
            
            <!-- Credit Card CVV Number -->
            <label>CVV</label>
            <input type="text" class="span3" autocomplete="off" data-encrypted-name="cc_cvv" />
            <i class="cvv"></i>
            <!-- Credit Card Exp Date -->
            <label>Expiration Date</label>
            <p class="form-inline">
                <input type="text" class="span3" data-encrypted-name="cc_month" placeholder="MM" /> / <input type="text" class="span5" data-encrypted-name="cc_year" placeholder="YYYY" />
            </p>
            
            <!-- Credit Card Zip Code -->
            <?php echo form_label('Billing Zip Code', 'zip'); ?>
            <?php echo form_input('zip', NULL, 'class="span4"'); ?>
            
        </div>
        <div class="span5 offset1">
            <table class="table">
                <tr>
                    <td>Payment:</td>
                    <td>${{ session:data name="payment" }}</td>
                </tr>
                <tr>
                    <td>Invoice:</td>
                    <td>{{ session:data name="invoice" }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div id="payment_credit" class="form-actions">
        <?php echo form_submit('submit','Submit Payment','class="btn btn-large btn-primary"'); ?>
        <a href="/payment/cancel" class="btn btn-large">Cancel</a>
    </div>
</fieldset>
<?php echo form_close(); ?>    