import 'select2';                       // globally assign select2 fn to $ element

$(function() {

    // /orders-export-settings Page
    $(document).ready(function() {
        var city = $('#city');
        if (city) {
            $.ajax({
                type: 'GET',
                url: '/ajax/cities',
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        city.append('<option id=' + data[i].cityid + ' value=' + data[i].cityid + '>' + data[i].citytitle + '</option>');
                    }
                }
            });
        };
   });

    $('#city').change(function() {
        var id = $(this).find(':selected')[0].id;
        $.ajax({
            type: 'GET',
            url: '/ajax/products/' + id,
            success: function (data) {
                var products = $('#products');
                products.empty();
                products.append('<option>All products</option>');
                for (var i = 0; i < data.length; i++) {
                    products.append('<option id=' + data[i].productid + ' value=' + data[i].productid + '>' + data[i].producttitle + '</option>');
                }
            }
        });
    });

    $('.select_all_fields').click(function() {
        $('#fields').find(':checkbox').each(function() {
            jQuery(this).attr('checked', 1);
        });
    });
    $('.select_all_state').click(function() {
        $('#state').find(':checkbox').each(function() {
            jQuery(this).attr('checked', 1);
        });
    });
    $('.select_all_type').click(function() {
        $('#type').find(':checkbox').each(function() {
            jQuery(this).attr('checked', 1);
        });
    });
    // END orders-export-settings

    $('#product_id').change(function() {
        var product_id = parseInt($(this).val());

        $('#stop_sales_time').empty();
        $('#language_id').empty();

        if (product_id) {
            $.get('/ajax/products/' + product_id + '/start-hours', function(data) {

                var hours = data.hours;

                $('#stop_sales_time').append('<option value="00:00">All start hours</option>');

                for (var i in hours) {
                    $('#stop_sales_time').append('<option value="' + hours[i].starttime + '">' + hours[i].starttime + '</option>');
                }

                $('#stop_sales_time').trigger('change');
            });
        }
    });

    $('#product_id').trigger('change');

    $('#stop_sales_time').change(function() {
        var product_id = parseInt($('#product_id').val());
        var start_time = $(this).val();

        $('#language_id').empty();

        if (product_id) {
            $.get('/ajax/products/' + product_id + '/start-hours/' + start_time + '/languages', function(data) {

                var languages = data.languages;

                $('#language_id').append('<option value="">All languages</option>');

                for (var i in languages) {
                    $('#language_id').append('<option value="' + languages[i].id + '">' + languages[i].name + '</option>');
                }
            });
        }
    });

    $('.dashboard-datepicker').datepicker({
        weekStart : 1,
        format    : 'yyyy-mm-dd',
        autoclose : true
    });

    $('.datepicker-month-year').datepicker({
        format    : 'yyyy-mm',
        autoclose : true,
        startView: "months",
        minViewMode: "months"
    });

    $('.suppliers-startsales-datepicker').datepicker({
        weekStart : 1,
        format    : 'dd-mm-yyyy',
        startDate : 'today',
        autoclose : true
    });

    $('.suppliers-stopsales-datepicker').datepicker({
        weekStart : 1,
        format    : 'yyyy-mm-dd',
        startDate : 'today',
        autoclose : true
    });

    $(document).on('keydown', null, 'ctrl+enter', function(){
        alert('d');
        document.getElementById('customer-data').submit();
    });

    $('.order-payment').click(function() {

        var baja_id = $(this).attr('order-payment-attr');

        $.get('/orders/' + baja_id + '/payments', function(data) {
            var template = $('#order-payments-template').html();
            var data     = data.data;
            data.token   = window.Laravel.csrfToken;

            // optional, speeds up future uses
            Mustache.parse(template);

            var rendered = Mustache.render(template, data);

            BootstrapDialog.show({
                type            : BootstrapDialog.TYPE_PRIMARY,
                closeByBackdrop : false,
                closeByKeyboard : false,
                title           : 'Request pre-payment to customers of booking ' + baja_id,
                message         : $('<div></div>').html(rendered)
            });
        });

        return false;
    });

    /**
     * Remove spaces from payment link so it can pass validation
     */
    $(document).on('input', '.payment-link', function() {
        $(this).val(function(_, v){
            return v.replace(/\s+/g, '');
        });
    });

    $(document).on('click', '#remove-uploaded-photo', function() {
        $('#photo-upload-step2').hide();
        $('#photo-upload-step1').show();

        return false;
    });

    $(document).on('click', '#send-uploaded-photo', function() {

        // Close popup
        BootstrapDialog.closeAll();

        var id = $(this).attr('order-id');

        $.ajax({
            url         : '/orders/' + id + '/photos',
            type        : "POST",
            data        : new FormData(document.getElementById('photo-upload-form')),
            contentType : false,
            cache       : false,
            processData : false,
            success     : function(data) {

            }
        });

        return false;
    });

    $(document).on('click', '#upload-photo', function() {
        $('#file').click();

        $('#file').change(function(event) {
            $('#photo-upload-step1').hide();

            var output = document.getElementById('uploaded-photo');
            $('#uploaded-filename').text($('#file').val());
            output.src = URL.createObjectURL(event.target.files[0]);

            $('#photo-upload-step2').show();
        });

        return false;
    });

    $('.upload-photo').click(function() {
        var bajaid   = $(this).attr('data-booking-id');
        var id       = $(this).attr('order-id');
        var template = $('#upload-photo-template').html();

        Mustache.parse(template);

        var rendered = Mustache.render(template, {bajaid: bajaid, id: id});

        BootstrapDialog.show({
            type            : BootstrapDialog.TYPE_PRIMARY,
            closeByBackdrop : false,
            cssClass        :'supplier-photo-upload-dialog',
            closeByKeyboard : false,
            title           : 'Booking ' + bajaid + ': Add photo',
            message         : $('<div></div>').html(rendered)
        });

        return false;
    });

    $('.supplier-orders .order-details').click(function() {
        var order_id = $(this).attr('order-id');

        $.get('/orders/' + order_id, function(data) {
            var template = $('#order-details-template').html();
            var data     = data.data;

            // optional, speeds up future uses
            Mustache.parse(template);

            var rendered = Mustache.render(template, data);

            BootstrapDialog.show({
                type            : BootstrapDialog.TYPE_PRIMARY,
                closeByBackdrop : false,
                closeByKeyboard : false,
                title           : 'You are viewing booking ' + data.bajaid +', booked on ' + data.booking_date,
                message         : $('<div></div>').html(rendered)
            });
        }, 'json');

        return false;
    });

    $('.time').inputmask("hh:mm", {
        placeholder     : "HH:MM",
        insertMode      : false,
        showMaskOnHover : false
    });

    // CSRF token for AJAX-requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('keydown', null, 'shift+c', function() {
        window.location = backoffice_url + 'index.php?module=orders&action=new&type=3';
    });

    $(document).on('keydown', null, 'shift+t', function() {
        window.location = backoffice_url + 'index.php?module=orders&action=new&type=1';
    });

    $(document).on('keydown', null, 'shift+g', function() {
        window.location = backoffice_url + 'index.php?module=orders&action=new&type=2';
    });

    $(document).on('keydown', null, 'shift+s', function() {
        $('input[name=query]').focus();
        return false;
    });

    // Toggle dropdown filter and focus inside of it
    $('#filter-toggle').dropdown();

    $(document).on('keydown', null, 'shift+f', function() {
        $('.bookings-filter .dropdown')
            .toggleClass('open')
            .find('.dropdown-submenu a:first')
            .focus();
        return false;
    });

    $(document).on('keydown', null, 'ctrl+return', function() {
        $('#order-form2').submit();
        $('#form3').submit();
        return false;
    });

    // Dropdown menu on hover
    $('ul.nav li.dropdown').hover(function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(100);
    }, function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(100);
    });

    // State switcher
    $('.state-switcher label').click(function() {
        $(this).removeClass('btn-default').addClass('btn-success');
        $(this).siblings().removeClass('btn-success').addClass('btn-default');
    });

    // Item remove modal dialog
    $('.remove-dialog').click(function() {
        var question = $(this).attr('data-question');
        var location = $(this).attr('href');

        BootstrapDialog.show({
            message         : question,
            title           : '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Attention',
            type            : BootstrapDialog.TYPE_DANGER,
            closable        : false,
            closeByBackdrop : false,
            closeByKeyboard : false,
            buttons         : [{
                label    : '<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Yes',
                cssClass : 'btn-danger',
                action   : function(dialogRef) {
                    dialogRef.close();

                    window.location = location;
                }
            }, {
                label    : '<i class="fa fa-thumbs-o-down" aria-hidden="true"></i> No',
                cssClass : 'btn-success',
                action   : function(dialogRef) {
                    dialogRef.close();
                }
            }]
        });

        return false;
    });

    // Drag&drop reposition for products request
    $('.products-table tbody').sortable({
        axis        : 'y',
        containment : 'parent',
        cursor      : 'move',
        revert      : true,
        handle      : '.draggable',
        update      : function(event, ui) {
            $(document.body).css({'cursor' : 'wait'});
            var url         = $(this).data('route');
            var productList = $(this).sortable('serialize');

            executeUpdateRequest(url, productList, 'json');
        }
    });

    // Update product availability period
    $('.availability-update').click(function() {
        var url       = $(this).data('route'),
            availRow  = $(this).closest('.availability-row'),
            startDate = availRow.find('.start-date input').val(),
            endDate   = availRow.find('.end-date input').val(),
            startTime = availRow.find('.start-time input').val(),
            weekdays  = availRow.find('.weekday input:checked');

        var data = {
            'startdate' : startDate,
            'enddate'   : endDate,
            'starttime' : startTime,
            'weekdays'  : []
        }

        $(weekdays).each(function() {
            data['weekdays'].push($(this).val());
        });

        executeUpdateRequest(url, data);

        return false;
    });

    // Update product stop sales date
    $('.stop-sales-update').click(function() {
        var url           = $(this).data('route'),
            exceptDateRow = $(this).closest('.stop-sales-row'),
            stopSalesDate = exceptDateRow.find('.stop-sales-date input').val(),
            formattedDate = moment(stopSalesDate, 'DD-MM-YYYY').format('YYYY-MM-DD'),
            stopSalesTime = exceptDateRow.find('.stop-sales-time input').val(),
            language      = exceptDateRow.find('.language option:selected').val();

        var data = {
            'stop_sales_date' : formattedDate,
            'stop_sales_time' : stopSalesTime,
            'language_id'     : language
        }

        executeUpdateRequest(url, data);

        return false;
    });

    // Update product price
    $('.price-update').click(function() {
        var url            = $(this).data('route'),
            pricesRow      = $(this).closest('.prices-row'),
            touroperatorId = pricesRow.find('.reseller input').val(),
            adultOrChild   = pricesRow.find('.adult-child > div').text(),
            paxFrom        = pricesRow.find('.pax-from input').val() || pricesRow.find('.pax-from option:selected').val(),
            paxTo          = pricesRow.find('.pax-to input').val(),
            purchasePrice  = pricesRow.find('.purchase-price input').val(),
            sellingPrice   = pricesRow.find('.selling-price input').val();

        var data = {
            'touroperatorid' : touroperatorId,
            'adult-child'    : adultOrChild,
            'frompax'        : paxFrom,
            'tillpax'        : paxTo,
            'purchaseprice'  : purchasePrice,
            'sellingprice'   : sellingPrice
        }

        executeUpdateRequest(url, data, false, pricesRow);

        return false;
    });

    $('#producttypes-filter, #touroperators-filter, #products-filter, #cities-filter').select2();

    // Update product price
    $('.price-update-all').click(function() {
        var pricesRow      = $(this).closest('.prices-row'),
            touroperatorId = pricesRow.find('.touroperator-title input').val(),
            priceid        = pricesRow.find('#priceid').val(),
            adultOrChild   = pricesRow.find('.is-childrens > div').text(),
            paxFrom        = pricesRow.find('.pax-from input').val() || pricesRow.find('.pax-from option:selected').val(),
            paxTo          = pricesRow.find('.pax-to input').val(),
            purchasePrice  = pricesRow.find('.purchase-price input').val(),
            sellingPrice   = pricesRow.find('.selling-price input').val();

        var url            = '/prices/'+priceid+'/update';
        var data = {
            'touroperatorid' : touroperatorId,
            'adult-child'    : adultOrChild,
            'frompax'        : paxFrom,
            'tillpax'        : paxTo,
            'purchaseprice'  : purchasePrice,
            'sellingprice'   : sellingPrice
        }

        $(document.body).css({'cursor' : 'wait'});

        $.ajax({
          type: "POST",
          url: url,
          data: data,
          success: function(response){
            $(document.body).css({'cursor' : 'default'});
            pricesRow.trigger('view:update', response);
          },
          error: function(response) {
            $(document.body).css({'cursor' : 'default'});
            for (var name in response.responseJSON) {
                if (response.responseJSON.hasOwnProperty(name)) {
                    alert(response.responseJSON[name]);
                }
            }
          }
        });

    });

    // Update margin value on price update
    $('.prices-table').on('view:update', '.prices-row', function(event, response) {
        $(this).find('.margin > div').text(response.margin + ' %');
    });

    // Send AJAX request with parameters
    var executeUpdateRequest = function(url, data, json = false, element = false) {

        $(document.body).css({'cursor' : 'wait'});

        $.post(url, data, function(response) {
            $(document.body).css({'cursor' : 'default'});

            if(!response.success) {
                alert('Whoops, something went wrong :/');
            }

            element.trigger('view:update', response);

        }, json);
    }

    // Toggle expired data
    $('.expired-periods button, .expired-stop-sales button').click(function() {
        if ($(this).parent().hasClass('expired-periods')) {

            var rowSelector  = '.availability-row.expired',
                hideSelector = '.expired-periods .hide-expired',
                showSelector = '.expired-periods .show-expired';

        } else if ($(this).parent().hasClass('expired-stop-sales')) {

            var rowSelector  = '.stop-sales-row.expired',
                hideSelector = '.expired-stop-sales .hide-expired',
                showSelector = '.expired-stop-sales .show-expired';

        };

        if ($(this).hasClass('show-expired')) {

            $(rowSelector + ', ' + hideSelector).show();
            $(showSelector).hide();

        } else if ($(this).hasClass('hide-expired')) {

            $(rowSelector + ', ' + hideSelector).hide();
            $(showSelector).show();
        };
    });

    // Products availabilities calendar
    $('.product-datepiker').datepicker({
        weekStart  : 1,
        startDate  : '0',
        autoclose  : true,
        forceParse : false
    });

    // Products availabilities calendar
    $('.backoffice-datepiker').datepicker();

    $('#year-filter').datepicker({
        format      : 'yyyy',
        minViewMode : 'years',
        autoclose   : true
    }).on('change.dp', function(e) {
        $(this).closest('form').submit();
    });

    // Reseller filter for prices
    $('#reseller-filter option').each(function() {
        var filter      = $(this).text();
        var hasReseller = $(".reseller div:contains('" + filter + "')").text();

        if (filter != ' -- all resellers -- ' && !hasReseller) {
            $(this).remove();
        };
    });

    $('#reseller-filter').change(function() {
        var reseller = $(this).find("option:selected").text();
        if (reseller == ' -- all resellers -- ') {
            $('.prices-row').show();
        } else {
            $('.prices-row').hide();
            $('.reseller').find("div:contains('" + reseller + "')").closest('.prices-row').show();
        };
    });

    $('#reseller-filter').change();
    //--

    // Activate Bootstrap tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Bookings filter
    $('.bookings-filter input').bind('change keyup', function() {
        var now                  = moment();
        var closestSubmenu       = $(this).closest('.dropdown-submenu');
        var showFutureBookings   = $('#time-filters .future').is(':checked');
        var showPastBookings     = $('#time-filters .past').is(':checked');
        var showActiveBookings   = $('#state-filters .active').is(':checked');
        var showCanceledBookings = $('#state-filters .canceled').is(':checked');
        var showNoShowBookings   = $('#state-filters .no-show').is(':checked');
        var languagesList        = $('#language-filters input:checkbox:checked').map(function() {
                                        return $(this).attr('class');
                                    }).get();
        var productsList         = $('#product-filter input:checkbox:checked').map(function() {
                                        return $(this).siblings('span').text();
                                    }).get();
        var productNameQuery     = $('#product-name-filter .product-name').val().toLowerCase();
        var clientNameQuery      = $('#client-name-filter .client-name').val().toLowerCase();
        var bajaIdQuery          = $('#booking-id-filter .booking-id').val().toLowerCase();
        var touroperatorQuery    = $('#touroperator-title-filter').length
                                        ? $('#touroperator-title-filter .touroperator-title').val().toLowerCase()
                                        : '';

        if (closestSubmenu.find('input:checked').length === 0) {
            closestSubmenu.find('.clear-all').hide();
            closestSubmenu.find('.select-all').show();
        } else {
            closestSubmenu.find('.clear-all').show();
            closestSubmenu.find('.select-all').hide();
        };

        $('.order-row').each(function() {
            var date               = moment($(this).find('.tour-date').text(), 'DD-MM-YYYY');
            var dateFilter         = (showFutureBookings && date.isAfter(now)) || (showPastBookings && date.isBefore(now));
            var langFilter         = $.inArray($(this).data('lang'), languagesList) >= 0;
            var clientName         = $(this).find('.client-name').text();
            var clientFilter       = clientName.toLowerCase().indexOf(clientNameQuery) >= 0;
            var bajaId             = $(this).find('.order-id a').text();
            var bajaIdFilter       = bajaId.toLowerCase().indexOf(bajaIdQuery) >= 0;
            var touroperator       = $(this).find('.touroperator-title').text();
            var touroperatorFilter = $('#touroperator-title-filter').length ? touroperator.toLowerCase().indexOf(touroperatorQuery) >= 0 : true;
            var productName        = $(this).find('.product-name a').attr('title');
            var prodFilter         = $('#product-filter').length ? ($.inArray(productName, productsList) >= 0) : true;
            var prodNameFilter     = productName.toLowerCase().indexOf(productNameQuery) >= 0;
            var stateFilter        = (showActiveBookings && $(this).hasClass('active'))
                                  || (showCanceledBookings && $(this).hasClass('canceled'))
                                  || (showNoShowBookings && $(this).hasClass('no-show'));

            var closestDateOrdersRow    = $(this).closest('.date-orders-row');
            var closestProductOrdersRow = $(this).closest('.product-orders-row');

            if (dateFilter && stateFilter && langFilter && clientFilter && bajaIdFilter && touroperatorFilter && prodNameFilter && prodFilter) {
                closestDateOrdersRow.show();
                closestProductOrdersRow.show();
                $(this).show();
            } else {
                $(this).hide();

                if (!closestProductOrdersRow.find('.order-row:visible').length) {
                    closestProductOrdersRow.hide();
                }

                if (!closestDateOrdersRow.find('.order-row:visible').length) {
                    closestDateOrdersRow.hide();
                }
            };
        });
    });

    $('.bookings-filter .toggle').click(function() {
        var closestSubmenu = $(this).closest('.dropdown-submenu');

        if ($(this).hasClass('clear-all')) {
            closestSubmenu.find('input:checked').click();
        };

        if ($(this).hasClass('select-all')) {
            closestSubmenu.find('input').click();
        };

        $(this).hide().siblings('.toggle').show();

        closestSubmenu.find('input:first').change();

        return false;
    });

    // Prevent dropdown to be closed when we click on submenu link
    $('.bookings-filter .dropdown-submenu').click(function(e) {
        e.stopPropagation();
    });

    $('.dropdown-submenu a[data-toggle="collapse"]').click(function() {
        $(this).siblings('.panel-collapse').collapse('toggle');
        $(this).children('i').toggleClass('fa-caret-right fa-caret-down');

        return false;
    });
    // --

    // Reviews module
    $('#select-all-reviews').click(function() {
        this.checked
            ? $('input[name="review-id"]').each(function() { this.checked = true; })
            : $('input[name="review-id"]').each(function() { this.checked = false; });

        $('input[name="review-id"]').change();
    });

    $('#show-reviews').click(function() {

        var reviews_ids = $('input[name="review-id"]:checked').map(function() {
            return $(this).attr('data-id');
        }).get().join(',');

        if (reviews_ids.length) {
            window.location.href = '/reviews/' + reviews_ids + '/show';
        }

        return false;
    });

    $('#hide-reviews').click(function() {
        var reviews_ids = $('input[name="review-id"]:checked').map(function() {
            return $(this).attr('data-id');
        })
        .get()
        .join(',');

        if (reviews_ids.length) {
            document.location.href = '/reviews/' + reviews_ids + '/hide';
        }

        return false;
    });
    //--

    // Emails tracking module
    $('#select-all-emails').click(function() {
        this.checked
            ? $('input[name="email-id"]').each(function() { this.checked = true; })
            : $('input[name="email-id"]').each(function() { this.checked = false; });

            $('input[name="email-id"]').change();
    });

    $('input[name="email-id"]').change(function() {
        var emailIds = $('input[name="email-id"]:checked').map(function() {
            return $(this).data('id');
        })
        .get()
        .join(',');

        var url = emailIds.length ? 'emails/' + emailIds + '/resend' : '#';

        $('#resend-selected-emails').attr('href', url);
    });
    // --

    // Stop sales request
    $('#select-all-requests').click(function() {
        this.checked
            ? $('input[name="request-id"]').each(function() { this.checked = true; })
            : $('input[name="request-id"]').each(function() { this.checked = false; });

            $('input[name="request-id"]').change();
    });

    $('input[name="request-id"]').change(function() {
        var requestIds = $('input[name="request-id"]:checked').map(function() {
            return $(this).data('id');
        })
        .get()
        .join(',');

        var approveUrl = requestIds.length ? 'requests/' + requestIds + '/approve' : '#';
        var denyUrl    = requestIds.length ? 'requests/' + requestIds + '/deny' : '#';

        $('#approve-requests').attr('href', approveUrl);

        $('#deny-requests').attr('href', denyUrl);
    });
    // --

    $('.supplier_invoice').click(function() {
        var submit_url = $(this).val();

        BootstrapDialog.show({
            message         : 'You cannot switch back! Are you sure?',
            title           : '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Attention',
            type            : BootstrapDialog.TYPE_WARNING,
            closable        : false,
            closeByBackdrop : false,
            closeByKeyboard : false,
            buttons         : [{
                label    : 'Yes',
                cssClass : 'btn-success',
                action   : function(dialogRef) {
                    dialogRef.close();
                }
            }]
        });

        return false;
    });

    $('.invoice_type').change(function() {
        var invoice_type = $(this).val();

        if (invoice_type == 'month') {

            BootstrapDialog.show({
                message         : 'You cannot switch back! Are you sure?',
                title           : '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Attention',
                type            : BootstrapDialog.TYPE_PRIMARY,
                closable        : false,
                closeByBackdrop : false,
                closeByKeyboard : false,
                buttons         : [{
                    label    : 'Yes',
                    cssClass : 'btn-success',
                    action   : function(dialogRef) {
                        dialogRef.close();
                    }
                }]
            });
        }
    });
});
