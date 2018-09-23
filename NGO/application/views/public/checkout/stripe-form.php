<?php echo $template['partials']['page_header']; ?>

<!-- If you're using Stripe for payments -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<style media="screen">
.panel-title {display: inline;font-weight: bold;}

.checkbox.pull-right { margin: 0; }

.pl-ziro { padding-left: 0px; }

.form-control.error {
    border-color: red;
    outline: 0;
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(255,0,0,0.6);
}

label.error {
    font-weight: bold;
    color: red;
    padding: 2px 8px;
    margin-top: 2px;
}

.payment-errors {
    color: #a94442;
    padding: 2px 8px;
    margin-top: 2px;
}
</style>

<script type="text/javascript">
    Stripe.setPublishableKey('<?php echo $publishable_key; ?>');
</script>

<section class="section-sm bg-gray col-adjusted" >
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-4 col-md-offset-4 col-xs-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo lang('text.credit_card_payment'); ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php echo form_open(current_url_full(), ['id' => 'form-stripe-checkout', 'role' => 'form']); ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="payment-errors"></p>
                                <div class="form-group">
                                    <label for="cardNumber"><?php echo lang('label.card_number'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Valid Card Number" autofocus data-stripe="number" />
                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7 col-md-7">
                                <div class="form-group">
                                    <label for="expMonth"><?php echo lang('label.card_expiry_date'); ?></label>
                                    <div class="col-xs-6 col-lg-6 pl-ziro">
                                        <input type="text" class="form-control" placeholder="MM" data-stripe="exp_month" />
                                    </div>
                                    <div class="col-xs-6 col-lg-6 pl-ziro">
                                        <input type="text" class="form-control" placeholder="YY" data-stripe="exp_year" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group">
                                    <label for="cvCode"><?php echo lang('label.card_cv'); ?></label>
                                    <input type="password" class="form-control" placeholder="CV" data-stripe="cvc" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-success btn-lg btn-block btn-loading" type="submit" id="btn-stripe"><?php echo lang('button.make_payment'); ?></button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4"></div>
        </div>
    </div>
</section>