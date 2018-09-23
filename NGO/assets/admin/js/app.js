$(document).ready(function() {
    window.APP = {};

    $.ajaxSetup({
        data: {
            csrf_token: config.token
        }
    });
 
    window.makeApiCall = function(type, url, data, callbackSuccess, callbackError) {
        $.ajax({
            url: url,
            type: type,
            data: data,
            dataType: "json",
            success: function(response) {
                callbackSuccess(response);
            },
            error: function(response) {
                //callbackError(response);
            }
        });
    }

    // Date time picker.
    $('.datetime-picker').each(function() {
        $(this).datetimepicker({
            format: 'YYYY/MM/DD ',
            minDate: getFormattedDate(new Date())

        });
    });

    function getFormattedDate(date) {
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear().toString().slice(2);
        return year + '-' + month + '-' + day;
    }

    // Color picker.
    if ($('#cp2').length > 0) {
        $('#cp2').colorpicker();
    }

    // Global ajax error handling
    $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
        alert(jqxhr.statusText)
    });

    APP.initSelect2 = function() {
        if ($('.select2').length > 0) {
            $('.select2').select2();
        }
    }

    APP.initDatatable = function() {
        if ($('.datatable').length > 0) {
            $('.datatable').DataTable({
                responsive: true,
                lengthMenu: [25, 50, 75, 100],
                "bSort": false,
            });

            $('.datatable').on('page.dt', function() {
                $('.bootstrap-switch').bootstrapSwitch({
                    onSwitchChange: function(e, status) {
                        callbackUpdateDataStatus($(this).data('action'), $(this).data('id'), status);
                    }

                });
            });
        }
    }

    APP.closeModalWindow = function() {
        $('.modal').modal('hide');
    }

    APP.initTooltip = function() {
        $('[data-toggle="tooltip"]').tooltip();
    }

    APP.showFlashMessage = function(status, messsage) {
        var m = '<div class="alert alert-success" role="alert"><button class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button><strong>Well done!</strong> ' + messsage + '</div>';
        $('#flash-message-wrapper').html(m).show();
    }

    APP.bootstrapSwitch = function(className) {
        if ($(".bootstrap-switch").length > 0) {
            className = typeof className !== 'undefined' ? className : '.bootstrap-switch';
            $(className).bootstrapSwitch({
                onSwitchChange: function(e, status) {
                    callbackUpdateDataStatus($(this).data('action'), $(this).data('id'), status);
                }
            });
        }
    }

    // Initialization
    APP.initSelect2();
    APP.initDatatable();
    APP.initTooltip();
    APP.bootstrapSwitch();

    // Autoclose the flash message
    $("#flash-message-wrapper").delay(10000).slideUp(500, function() {
        $('#flash-message-wrapper').empty();
    });

    $(document).on('click', '.btn-loading', function() {
        var $btn = $(this);
        $btn.button('loading');
        setTimeout(function() {
            $btn.button('reset');
        }, 1000);
    })

    // Row deletion
    $(document).on('click', '.btn-delete', function(event) {
        event.preventDefault();
        var self = $(this);
        var url = config.admin_url + '/' + self.data('href')
        var url_segment = (self.data('href')).split('/');

        call_confirm_dialog(function(result) {
            if (!result) {
                return false;
            }
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                success: function(result) {
                    if (result.status) {
                        var row = self.closest('tr');
                        if (url_segment[2] == 'menu') {
                            window.location.reload();
                        } else {
                            $('.datatable').dataTable().fnDeleteRow(row);
                            APP.showFlashMessage(result.status, result.message);
                        }

                    }
                }
            })
        });
    })
    
    //delete modifier table
    $(document).on('click', '.btn-modi', function(event) {
        event.preventDefault();
        var self = $(this);
        var url = config.admin_url + self.data('href')

        call_confirm_dialog(function(result) {
            if (!result) {
                return false;
            }

            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                success: function(result) {
                    if (result.status) {
                        self.closest("table").remove();
                        APP.showFlashMessage(result.status, result.message);
                    }
                }
            })
        });
    })

    //delete modifier size table
    $(document).on('click', '.btn-product-mod-size', function(event) {
        event.preventDefault();
        var self = $(this);
        var url = config.admin_url + self.data('href')

        call_confirm_dialog(function(result) {
            if (!result) {
                return false;
            }

            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                success: function(result) {
                    if (result.status) {
                        self.closest("tr").remove();
                        APP.showFlashMessage(result.status, result.message);
                    }
                }
            })
        });
    })

    // Delete confirm dialog box
    function call_confirm_dialog(callback) {
        BootstrapDialog.show({
            title: 'Warning',
            message: 'Action is irreversible, do you want to proceed?',
            type: BootstrapDialog.TYPE_DANGER,
            size: BootstrapDialog.SIZE_SMALL,
            buttons: [{
                label: 'No',
                cssClass: 'btn-danger',
                action: function(dialog) {
                    dialog.close();
                    callback(0);
                }
            }, {
                label: 'Yes, Proceed',
                cssClass: 'btn-primary btn-loading',
                action: function(dialog) {
                    dialog.close();
                    callback(1);
                }
            }]
        });
    }

    // File Upload (New)
    if ($('#fileupload').length > 0) {
        $('#fileupload').fileupload({
            dataType: 'json',
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            formData: {
                csrf_token: config.token,
                folder: $('#fileupload').data('folder'),
                type: $('#type').val()
            },
            url: config.admin_url + '/upload',
            done: function(e, data) {
                $('#progress .bar').hide();
                $('.btn-submit').removeAttr('disabled');
                var result = data.result;
                $(this).closest('.upload-holder').find('#thumbnail-preview').attr('src', result.thumbnail);
                $(this).closest('.upload-holder').find('#image-id').val(result.name);
            },
            progress: function(e, data) {
                $('#progress .bar').show();
                var progress = parseInt((data.loaded / (data.total * 2)) * 100, 20);
                $('#progress .bar').css('width', progress + '%');
            },
            change: function(e, data) {
                $('.btn-submit').attr('disabled', 'disabled');
            }
        });
    }

    if ($('#fileupload_banner').length > 0) {
        $('#fileupload_banner').fileupload({
            dataType: 'json',
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            formData: {
                csrf_token: config.token,
                folder: $('#fileupload_banner').data('folder'),
                type: $('#banner-type').val()
            },
            url: config.admin_url + '/upload',
            done: function(e, data) {
                $('#progress .bar').hide();
                $('.btn-submit').removeAttr('disabled');
                var result = data.result;
                $(this).closest('.upload-holder').find('#thumbnail-banner-preview').attr('src', result.thumbnail);
                $(this).closest('.upload-holder').find('#image-banner-id').val(result.name);
            },
            progress: function(e, data) {
                $('#progress .bar').show();
                var progress = parseInt((data.loaded / (data.total * 2)) * 100, 20);
                $('#progress .bar').css('width', progress + '%');
            },
            change: function(e, data) {
                $('.btn-submit').attr('disabled', 'disabled');
            }
        });
    }

    if ($('#fileupload_icon').length > 0) {
        $('#fileupload_icon').fileupload({
            dataType: 'json',
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            formData: {
                csrf_token: config.token,
                folder: $('#fileupload_icon').data('folder'),
                type: $('#icon-type').val()
            },
            url: config.admin_url + '/upload',
            done: function(e, data) {
                $('#progress .bar').hide();
                $('.btn-submit').removeAttr('disabled');
                var result = data.result;
                $(this).closest('.upload-holder').find('#thumbnail-icon-preview').attr('src', result.thumbnail);
                $(this).closest('.upload-holder').find('#image-icon-id').val(result.name);
            },
            progress: function(e, data) {
                $('#progress .bar').show();
                var progress = parseInt((data.loaded / (data.total * 2)) * 100, 20);
                $('#progress .bar').css('width', progress + '%');
            },
            change: function(e, data) {
                $('.btn-submit').attr('disabled', 'disabled');
            }
        });
    }

    // Clock picker
    if ($('.clockpicker').length > 0) {
        $('.clockpicker').clockpicker({
            autoclose: true
        });
    }

    /*
     * http://stackoverflow.com/questions/12286332/twitter-bootstrap-remote-modal-shows-same-content-everytime
     * Solved the twitter bootstrap ajax modal problem
     */
    $('body').on('hidden.bs.modal', '.modal', function() {
        $(this).removeData('bs.modal');
    });

    // Called when modal loaded via ajax
    $('#modal-zipcode').on('shown.bs.modal', function() {
        APP.initSelect2();
    });


  // Add item modifer rows
    $(document).on('click', '#btn-add-item-modifier', function() {
        var template = $('#template-item-modifier').html();
        $('#item-modifiers-list').append(_.template(template));
    });

    // Remove item modifer row
    $(document).on('click', '.btn-remove-modifier-row', function() {
        $(this).closest('.form-group').remove();
    });

    $(document).on('click', '#btn-add-product-size', function() {
        var template = $('#template-product-size').html();
        $('#product-size-list').append(_.template(template));
    });

    // Create product modifier
    $(document).on('submit', '#form-create-product-modifier', function(event) {
        event.preventDefault();
        var self = $(this);

        makeApiCall('POST', self.attr('action'), self.serialize(), function(response) {
            fetchDishModifiers();
            $('#ajaxModal').modal('hide');
        });
    });

      // Edit modifier modal
    $(document).on('submit', '#form-update-product-modifier', function(event) {
        event.preventDefault();
        var self = $(this);

        makeApiCall('POST', self.attr('action'), self.serialize(), function(response) {
            fetchDishModifiers();
            $('#ajaxModal').modal('hide');
        });
    });

    // Fetch modifiers for a product
    var fetchDishModifiers = function() {
        var dishId = product.dishId;
        var restaurantId = typeof product.restaurantId == 'string' ? product.restaurantId : '';

        window.makeApiCall('GET', config.admin_url + '/dish_modifier/index/' + dishId + '/' + restaurantId, {}, function(response) {
            var template = $('#template-item-modifiers-list').html();
            var compiled = _.template(template);

            $('#item-all-modifiers').html(compiled({
                response: response
            }));
        });
    }

    // Fetch modifier for a product
    if ($('div').hasClass('has-product-modifier')) {
        fetchDishModifiers();
    }

     // Create size modifier
    $(document).on('submit', '#form-create-size-modifier', function(event) {
        event.preventDefault();
        var self = $(this);

        makeApiCall('POST', self.attr('action'), self.serialize(), function(response) {
            fetchSizeModifiers();
            $('#ajaxModalSize').modal('hide');
        });
    });

      // Edit modifier modal
    $(document).on('submit', '#form-update-size-modifier', function(event) {
        event.preventDefault();
        var self = $(this);

        makeApiCall('POST', self.attr('action'), self.serialize(), function(response) {
            fetchSizeModifiers();
            $('#ajaxModalSize').modal('hide');
        });
    });

    // Fetch modifiers size for a product
    var fetchSizeModifiers = function() {
        var dishId = product.dishId;
        
        window.makeApiCall('GET', config.admin_url + '/dish_sizes/index/' + dishId, {}, function(response) {
            var template = $('#template-size-modifiers-list').html();
            var compiled = _.template(template);

            $('#size-all-modifiers').html(compiled({
                response: response
            }));
        });
    }

    // Fetch size for a product
    if ($('div').hasClass('has-size-modifier')) {
        fetchSizeModifiers();
    }
});

callbackUpdateDataStatus = function(action, id, status) {
    $.ajax({
        type: "POST",
        url: config.admin_url + action,
        data: {
            id: id,
            status: status
        },
        dataType: 'json',
        success: function(result) {
            APP.showFlashMessage(result.status, result.message);
        }
    })
}

if ($('.ckeditor').length > 0) {
    CKEDITOR.replace('editor', {
        filebrowserUploadUrl: config.admin_url + '/ck_uploader?folder=extras&csrf_token=' + config.token
    });
}


/*SETTING PERMISSION*/
$(document).on('change', '#group', function(event) {
    var group_id = $(this).val();
    if (!isNaN(group_id) && group_id != 0)
        window.location = config.admin_url + '/user/permissions/index/' + group_id;
})

if ($('#tree').length > 0) {
    $("#tree").dynatree({
        checkbox: true,
        selectMode: 3,
        onSelect: function(select, node) {
            var s = node.tree.getSelectedNodes().join(", ");
            var td = node.toDict();
            var selNodes = node.tree.getSelectedNodes();
            var data = [];
            var selKeys = $.map(selNodes, function(node1) {
                if (!node1.data.isFolder) {
                    data.push(node1.data.key);
                }

                $('#module_id').val(dict);
            });
            var s = node.tree.getSelectedNodes().join(" , ");
        },
    });
}

// Post the permission
$(document).on('click', '#btn_submit_permission', function(event) {
    event.preventDefault();
    var dict = $("#tree").dynatree("getTree").toDict();
    var group_id = $('#group').val();
    $.ajax({
        url: config.admin_url + '/user/permissions/add_permission',
        type: 'POST',
        dataType: "json",
        data: {
            group: group_id,
            modules: dict
        },
        success: function(result) {
            if (result.STATUS == 1) {
                window.location.href = config.admin_url + '/user/permissions/index/' + group_id;
            }
        }
    });
});

$(document).on('click', '.ajax-load-modal', function() {
    var URL = $(this).data('href');
    if (URL == '') {
        return false;
    }

    $.get(URL, function(response) {
        $('.modal-dialog').html(response.html)
        $('#fd-modal').modal({
            show: true
        });
    });
});

// Show and hide product div.
$(document).on('change', '#different_size', function (event) {
    var different_size = $(this).val();
    if (different_size == '1') {
        $('#dish_price_div').hide();
        $('#dish_different_size_div').show();
    } else {
        $('#dish_price_div').show();
        $('#dish_different_size_div').hide();
    }
});