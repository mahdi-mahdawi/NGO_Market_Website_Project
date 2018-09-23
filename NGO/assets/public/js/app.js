$(document).ready(function() {
    $.ajaxSetup({
        data: {
            csrf_token: APP.csrf_token
        }
    });

    $('body').on('hidden.bs.modal', '.modal', function() {
        $(this).removeData('bs.modal');
    });

    window.makeApiCall = function(type, url, data, callbackSuccess, callbackError) {
        $.ajax({
            url: url,
            type: type,
            data: data,
            dataType: "json",
            success: function(response) {
                callbackSuccess(response);
            }
        });
    }

    $(document).ajaxStart(function() {
        $.blockUI({
            message: '<img src="/assets/public/images/ajax-loader.gif" />'
        });
    });

    $(document).ajaxStop($.unblockUI);

    $('body').click($.unblockUI);


    // Date picker.
    $('.datepicker').each(function() {
        $(this).datepicker({
            format: 'dd/mm/yyyy',
            startDate: APP.today
        });
    });

    // Time picker.
    $('.timepicker').each(function() {
        $(this).timepicker({

        });
    });

    $(document).on('click', '.form-cart-add-product', function(event) {
        event.preventDefault();
        var form = $(this);
        var product_id = form.data('productes-id');
        var url= APP.base_url + 'cart/add/' + product_id;

        makeApiCall('GET', url, {}, function(response) {
            if (response.hasOwnProperty('html')) {
                $('.modal-dialog').html(response.html);
                $('#fd-modal').modal({
                    show: true
                });
            }
        });
    });

    $('.btn-preorder').on('click', function() {
        var self = $(this);

        $('#preorder-btn-now').removeClass('active');
        $('#preorder-btn-later').removeClass('active');

        if (self.attr('id') == 'preorder-btn-later') {
            $('#preorder-section-element').show();
            $('#preorder-btn-later').addClass('active');
            $('#is_preorder').val(1);
        } else {
            $('#preorder-section-element').hide();
            $('#preorder-btn-now').addClass('active');
            $('#is_preorder').val(0);
        }
    });
});

$(document).on('click', '.btn-loading', function() {
    var btn = $(this);
    btn.button('loading');
})


var getCartTable = function() {
    $.get(APP.base_url + 'cart/table', {}, function(response) {
        $('#cart-table-summary').html(response.html);
    }, 'json');
}

// Get the cart content
$.get(APP.base_url + 'cart/all', {}, function(response) {
    $('#cart-item-counter').html(response.count);

    $.each(response.contents, function(index, row) {
        $('[data-product-id="' + row.id + '"]').find('.product-quantity').val(row.qty);
    });
}, 'json');

// Get the cart content as table
if ($('#page-checkout').length) {
    getCartTable();
}

// Rating
if ($('.rating').length > 0) {
    $('#rating').rating();
}

// Update the checkout types.
$(document).on('change', '#checkout_types', function() {
    var val = $(this).val();

    $.post(APP.base_url + 'checkout/type', {
        checkout_types: val
    }, function(response) {
        getCartTable();
    }, 'json');
});

// Apply coupon
$(document).on('submit', '#form-apply-coupon', function(event) {
    event.preventDefault();
    var self = $(this);

    $.post(self.attr('action'), self.serialize(), function(response) {
        if (response.status == 0) {
            $('#error-invalid-coupon').html(response.error).show();
        } else {
            $('#cart-table-summary').html(response.html);
        }
    }, 'json');
});

// Remove coupon
$(document).on('submit', '#form-remove-coupon', function(event) {
    event.preventDefault();
    var self = $(this);

    $.post(self.attr('action'), self.serialize(), function(response) {
        $('#cart-table-summary').html(response.html);
    }, 'json');
});

// Form stripe payment
var formStripeCheckout = $('#form-stripe-checkout');
formStripeCheckout.submit(function(event) {
    event.preventDefault();

    var $form = $(this);
    $form.find('#btn-stripe').prop('disabled', true);
    Stripe.card.createToken($form, stripeResponseHandler);
});

function stripeResponseHandler(status, response) {
    if (response.error) {
        formStripeCheckout.find('.payment-errors').text(response.error.message);
        btnLoading.button('reset');
    } else {
        formStripeCheckout.find('.payment-errors').hide();
        var token = response.id;
        formStripeCheckout.append($('<input type="hidden" name="stripe_token" />').val(token));
        formStripeCheckout.get(0).submit();
    }
}

// Submit items to cart.
$(document).on('submit', '#form-cart-submit-product', function(event) {
    event.preventDefault();
    var form = $(this);
    var btn = form.find('.btn');

    btn.button('loading');

    makeApiCall('POST', form.attr('action'), form.serialize(), function(response) {
        if (response.status) {
            $('#fd-modal').modal('hide');
        }

        if (response.hasOwnProperty('html')) {
            $('.modal-dialog').html(response.html);
            $('#fd-modal').modal({
                show: true
            });
        }
        $('#cart-item-counter').html(response.count);
        $('#cart-icon-header').effect('shake');
        
        btn.button('reset');
    });
});