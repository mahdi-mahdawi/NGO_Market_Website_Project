// Edit menu
/*$(document).on('click', '.btn-edit-menu', function (e) {
    e.preventDefault();
    var self = $(this);
    var url = self.data('href');

    $.ajax({
        type: "POST",
        url: url,
        dataType: 'html',
        success: function (result) {
            $('#menu-add-edit-holder').empty().html(result);
            $('.select2').select2();

        }
    })
});*/

$(document).on('click', '.btn-edit-menu', function (e) {
    e.preventDefault();
    var self = $(this);
    var url = self.data('href');

    $.ajax({
        type: "POST",
        url: url,
        dataType: 'json',
        success: function (result) {
            $('#menu-add-edit-holder').empty().html(result.html);
            $('.select2').select2();

        }
    })
});
$(document).on('submit', '#form-edit-menu', function (e) {
    e.preventDefault();
    var self = $(this);

    $.ajax({
        type: "POST",
        data: self.serialize(),
        url: self.attr('action'),
        dataType: 'json',
        success: function (data) {
            if (data.status) {
                $('#menu-add-edit-holder').empty().html(data.html);
                $('#form-edit-menu').find('#menu').val('');
                $('#form-edit-menu').find('#page').val('');
                window.location.reload();
                $('#alert_menu').show();
            }
            else {
                $('#menu-add-edit-holder').empty().html(data.html);
            }
        },
        error: function (data) {
            alert("There was an error processing your request. Please refresh and try again.");
        }
    });
})
