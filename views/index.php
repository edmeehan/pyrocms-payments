{{ asset:js file="module::payment.js" }}
{{ asset:css file="module::style.css" }}

<?php echo form_open(null,array('id'=>'form_value_method')); ?>
<fieldset>
    <legend>Pay Invoice</legend>
    <?php if(validation_errors()): ?>
    <div class="row">
        <div class="span12">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Oops!</strong>
                <?php echo validation_errors('<span>','</span>'); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="row-fluid">
        <div class="span4">
            <!-- Payment Value -->
            <?php echo form_label('Payment Amount', 'payment'); ?>
            <div class="input-prepend">
                <span class="add-on">$</span>
                <?php echo form_input('payment', set_value('payment',@$payment), 'placeholder="0.00" class="span10"'); ?>
            </div>
            <!-- Invoice Number -->
            <?php echo form_label('Invoice Number', 'invoice'); ?>
            <?php echo form_input('invoice', set_value('invoice',@$invoice), 'class=""'); ?>
            <!-- Payment Choice -->
            <?php echo form_hidden('method', ''); ?>
        </div>
        <div class="span6">
            <p>All fields are required. We accept payments from Dwolla, to learn more about this great service <a href="http://refer.dwolla.com/a/clk/1SVw3m">check out their site and start an account</a>.</p>
        </div>
    </div>
    <div id="payment_choice" class="form-actions">
        <?php
            if(@$data['dwolla']):
                echo form_button('dwollapayment','<i class="icon dwolla"></i>Pay with Dwolla','class="btn btn-large btn-primary span4 offset1"');
            endif;
            
            if(@$data['braintree']):
                echo form_button('cardpayment','<i class="icon creditcard"></i>Pay with Credit Card','class="btn btn-large btn-primary span4 offset1"');
            endif;
        ?>
    </div>
</fieldset>
<?php echo form_close(); ?>