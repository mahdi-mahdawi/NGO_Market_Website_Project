$(document).ready(function () {
    // update menu order
    $("#UpdateMenuOrder").click(function () {
        $.ajax({
            url: config.admin_url + '/cms/menu/updateMenuOrder',
            type: 'POST',
            dataType: 'json',
            data: {
                menuData: updateOutput($('#nestable3').data('output', $('#nestable3-output')))
            },
            success: function (result) {

                if (result.status == 1) {
                    window.location.reload();
                }
            },
            error: function (error) {
                alert(error);
            }
        });
    });

    var updateOutput = function (e) {

        var list = e.length ? e : $(e.target),
                output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            return(window.JSON.stringify(list.nestable('serialize')));
        } else {
            output.val('JSON browser support required for this demo.');
            returnFalse();
        }
    };


    $('#nestable-menu').on('click', function (e) {
        var target = $(e.target),
                action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    $('#nestable3').nestable();
    $('#btn-menu-edit').on('click', function (e) {
        e.preventDefault();
        $('label.error').remove();
        $('#form-edit-menu').find('div').removeClass('has-error');
        $.ajax({
            type: "POST",
            data: $('#form-edit-menu').serialize(),
            url: $('#form-edit-menu').attr('action'),
            dataType: "json",
            success: function (data) {
                if (data.status == 0) {
                    var errors = data.errors;
                    $.each(errors, function (idx, obj) {
                        $('[name="' + idx + '"]').after("<label class='error'>" + obj + "</label>");
                        $('[name="' + idx + '"]').closest(".form-group").addClass("has-error");
                    });
                }
                else {
                    $('#menu-add-edit-holder').empty().html(data.html);
                }
            },
            error: function (data) {
                alert("There was an error processing your request. Please refresh and try again.");
            }
        });
    });

});
