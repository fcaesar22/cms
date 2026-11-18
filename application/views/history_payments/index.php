<style type="text/css">
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    #headingOne a {pointer-events: none;}
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    td {overflow-wrap: anywhere; white-space: normal;}
    .page-link a {color: white;}
    .page-link {width: 35px; height: 35px;}
    #searchinputactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonactive { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow_active { float: left; width: 7%; padding: 3.8px; color: white; font-size: 14px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
</style>

<div class="page-loader loadimage1">
    <div class="page-loader__spinner loadimage1">
        <svg viewBox="25 25 50 50">
            <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
</div>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>History Payments</h1>
            <?php echo $this->session->flashdata('msg');?>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php if (has_permission('create_historypayments')): ?>
                    <!-- <a href="<?= base_url('history_payments/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add History</a><br><br> -->
                <?php endif; ?>

                <input type="hidden" name="sort_table" id="sort_table" value="seq">
                <input type="hidden" name="order_table" id="order_table" value="desc">
                <input type="hidden" name="visible" id="visible" value="Y">

                <div class="accordion" role="tablist">
                    <div class="card">
                        <div class="card-header" role="tab" id="headingOne">
                            <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="">
                                <i class="zmdi zmdi-filter-list zmdi-hc-fw"></i>
                                Filter
                            </a>
                        </div>
                        <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Please Select Active Date</label><br>
                                        <div class='input-group date'>
                                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                            <input type="text" id="activateDate" name="activateDate" placeholder="Pick a date & time" class="form-control datetime-picker" value="">
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label></label><br>
                                        <button type="button" class="btn btn-outline-info" name="applyFilter" id="applyFilter">Apply</button>&nbsp;
                                        <button type="button" class="btn btn-outline-success btn--icon-text" name="exportData" id="exportData"><i class="zmdi zmdi-download"></i>Export</button>
                                    </div>
                                </div>
                                <span class="invalid-feedback" id="wardingsearchactive" name="wardingsearchactive" style="display:none;">minimum 3 charachters</span>
                                <br>
                                <input type="search" placeholder="Search for title..." name="searchinputactive" id="searchinputactive" minlength="3" maxlength="50">
                                <button type="button" name="searchbuttonactive" id="searchbuttonactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                                <button type="button" name="selectrow_active" id="selectrow_active" class="btn btn-light">
                                    <select name="rowselect_active" id="rowselect_active" style="width: 100%;">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </button>
                                <div class="table-responsive">
                                    <table class="table table-striped table-inverse table-bordered mb-0" id="mytable1" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Order ID</th>
                                                <th>User</th>
                                                <th>Package</th>
                                                <th>Payment Channel</th>
                                                <th>Payment Name</th>
                                                <th>Paid Date</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div class="dataTables_info" id="data-table_info" role="status" aria-live="polite"></div>
                                    <div style='margin-top: 10px;' id='pagination'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        $('#rowselect_active').select2()

        var key_search = $('#searchinputactive').val() || null
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var date = $('#activateDate').val() || null
        var rowperpage = $('#rowselect_active').val()
        var pageno = 0

        loadPagination(key_search, sort_by, order_sort, date, rowperpage, pageno)
    })

    $( function () {
        $("#activateDate").flatpickr({
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: "<?= set_value('activateDate') ?>",
            maxDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 1) {
                    const start = selectedDates[0];

                    const maxDate = new Date(start);
                    maxDate.setFullYear(maxDate.getFullYear() + 1);

                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    instance.set(
                        "maxDate",
                        maxDate > today ? today : maxDate
                    );
                } else if (selectedDates.length === 0) {
                    instance.set("maxDate", "today");
                }
            },
            onClose: function(selectedDates, dateStr, instance) {
                if (selectedDates.length !== 1) {
                    instance.set("maxDate", "today");
                }
            }
        })
        $("#activateDate").prop('readonly', false)
    })

    $(document).on('click', '#applyFilter', function () {
        var key_search = $('#searchinputactive').val() || null
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var date = $('#activateDate').val() || null
        var rowperpage = $('#rowselect_active').val()
        var pageno = 0
        loadPagination(key_search, sort_by, order_sort, date, rowperpage, pageno)
    })

    $(document).on('keydown', '#searchinputactive', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault()
            $('#searchbuttonactive').trigger('click')
        }
    })

    $(document).on('change', '#rowselect_active', function () {
        var key_search = $('#searchinputactive').val() || null
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var date = $('#activateDate').val() || null
        var rowperpage = $('#rowselect_active').val()
        var pageno = 0
        loadPagination(key_search, sort_by, order_sort, date, rowperpage, pageno)
    })

    $(document).on('click', '#searchbuttonactive', function () {
        var search = $('#searchinputactive').val()
        if (!search || search.length < 3) {
            $('#wardingsearchactive').show()
            setTimeout(function () {
                $('#wardingsearchactive').hide()
            }, 5000)
            return
        }
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var date = $('#activateDate').val() || null
        var rowperpage = $('#rowselect_active').val()
        loadPagination(search, sort_by, order_sort, date, rowperpage, 0)
    })

    function handlePaginationClick(paginationSelector, type) {
        $(paginationSelector).on('click', '.page-link', function (e) {
            e.preventDefault()
            var link = $(this).find('a')
            var pageno = link.data('ci-pagination-page')
            if (!pageno) {
                var text = $(this).text().trim()
                if (!isNaN(text)) {
                    pageno = parseInt(text, 10)
                }
            }
            if (!pageno) {
                return
            }
            var key_search = $('#searchinput' + type).val() || null
            var rowperpage = $('#rowselect_' + type).val()
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var date = $('#activateDate').val() || null
            loadPagination(key_search, sort_by, order_sort, date, rowperpage, pageno)
        })
    }

    handlePaginationClick('#pagination', 'active')

    function loadPagination(key_search, sort_by, order_sort, date, rowperpage, pageno) {
        $.ajax({
            url: '<?=base_url()?>history_payments/history_payments/'+key_search+'/'+sort_by+'/'+order_sort+'/'+date+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var order_sort = response.order
                var sumTotalPrice = response.total_price
                var x = response.x
                var y = response.y
                var z = response.z
                var show = 'Showing '+x+' to '+y+' of '+z+' entries'

                $('#data-table_info').html(show)
                var paginationId = '#pagination'

                if (response.pagination == "") {
                    var page1 = `<div class="pagging text-center">
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item active">
                                                <span class="page-link">1<span class="sr-only">(current)</span></span>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>`
                    $(paginationId).html(page1)
                } else {
                    $(paginationId).html(response.pagination)
                }
                createTable(response.result, response.row, sumTotalPrice)
            }
        })
    }

    function createTable(result, sno, sumTotalPrice) {
        $('#mytable1 tbody').empty()

        if (result.length > 0) {
            sno = Number(sno)
            for (index in result) {
                var id = result[index].seq
                var orderId = result[index].orderid
                var userId = result[index].userid
                var description = result[index].description
                var totalPrice = result[index].totalprice;
                var paymentChannel = result[index].payment_channel;
                var paidDate = result[index].paiddate;
                
                switch(paymentChannel) {
                    case '02':
                        pc = 'Virtual Account'
                    break;
                    case '04015':
                        pc = 'Credit Card'
                    break;
                    case '04018':
                        pc = 'BCA Klik Pay'
                    break;
                    case '04004':
                        pc = 'Doku Wallet'
                    break;
                    case '04026':
                        pc = 'IBI Danamon'
                    break;
                    case '04028':
                        pc = 'Permata Bank'
                    break;
                    case '04035':
                        pc = 'Alfamart'
                    break;
                    case '06':
                        pc = 'Dana'
                    break;
                    case '07':
                        pc = 'OttoPay'
                    break;
                    case '08':
                        pc = 'KasPro'
                    break;
                    case '09':
                        pc = 'Apple Pay'
                    break;
                    default:
                        pc = 'Indomaret'
                }

                sno+=1
                var base_url ='<?php echo base_url()?>'

                var tr = "<tr id='"+id+"'>"
                tr += "<td>"+ sno +"</td>"
                tr += "<td>"+ orderId +"</td>"
                tr += "<td>"+ userId +"</td>"
                tr += "<td>"+ description +"</td>"
                tr += "<td>"+ paymentChannel +"</td>"
                tr += "<td>"+ pc +"</td>"
                tr += "<td>"+ paidDate +"</td>"
                tr += "<td>"+ totalPrice +"</td>"
                tr += "</tr>"
                $('#mytable1 tbody').append(tr)
            }

            var trsum = '<tr><td colspan="7">Total</td><td>' + sumTotalPrice + '</td></tr>'
            $('#mytable1 tbody').append(trsum);
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No matching records found</td></tr>`
            $('#mytable1 tbody').append(tr)
        }
    }

    $(document).on('click', '#exportData', function () {
        html = `
                <div class="row">
                    <div class="col-md-12" style="text-align: left;">
                        <label>Please Select Active Date</label><br>
                        <div class='input-group date'>
                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                            <input type="text" id="dateRange" name="dateRange" placeholder="Pick a date & time" class="form-control datetime-picker" value="">
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                </div>
            `;
        swal({
            title: 'Export Data History Payment',
            text: 'Please select date!',
            html: html,
            showCancelButton: true,
            showLoaderOnConfirm: true,
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-success',
            confirmButtonText: 'Download',
            cancelButtonClass: 'btn btn-light',
            background: '#222323',
            allowOutsideClick: false,
            allowEscapeKey: false,
            onOpen: function () {
                $("#dateRange").flatpickr({
                    mode: "range",
                    dateFormat: "Y-m-d",
                    defaultDate: "<?= set_value('dateRange') ?>",
                    maxDate: "today",
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length === 1) {
                            const start = selectedDates[0];

                            const maxDate = new Date(start);
                            maxDate.setFullYear(maxDate.getFullYear() + 1);

                            const today = new Date();
                            today.setHours(0, 0, 0, 0);

                            instance.set(
                                "maxDate",
                                maxDate > today ? today : maxDate
                            );
                        } else if (selectedDates.length === 0) {
                            instance.set("maxDate", "today");
                        }
                    },
                    onClose: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length !== 1) {
                            instance.set("maxDate", "today");
                        }
                    }
                })
                $("#dateRange").prop('readonly', false)
            },
            preConfirm: function () {
                return new Promise(function(resolve, reject) {
                    let dateSelect = $('#dateRange').val() || '';
                    dateSelect = dateSelect.trim();

                    if (!dateSelect) {
                        swal.showValidationError('Date is required');
                        reject();
                        return;
                    }

                    resolve({
                        dateSelect: dateSelect,
                    });
                });
            }
        }).then(function(result) {
            let dateValue = result.value ? result.value.dateSelect : (result.dateSelect || (result.dismiss ? null : result));

            if (dateValue && typeof dateValue === 'object' && dateValue.dateSelect) {
                dateValue = dateValue.dateSelect;
            }

            if (dateValue && typeof dateValue === 'string') {
                $(".loadimage1").show();

                fetch('<?=base_url()?>history_payments/exportDatas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'date=' + encodeURIComponent(dateValue)
                })
                .then(async response => {
                    $(".loadimage1").fadeOut(100);

                    const contentType = response.headers.get("content-type");
                    if (contentType && contentType.includes("application/json")) {
                        const errData = await response.json();
                        swal({
                            title: 'Failed',
                            text: errData.message || 'Data not found',
                            type: 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323'
                        });
                        return;
                    }

                    if (response.ok) {
                        const blob = await response.blob();
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        
                        let filename = 'stb_data_export_' + new Date().toISOString().slice(0,19).replace(/[:T]/g,'-') + '.xlsx';
                        const disposition = response.headers.get('Content-Disposition');
                        if (disposition && disposition.indexOf('filename=') !== -1) {
                            let matches = disposition.match(/filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/);
                            if (matches != null && matches[1]) { 
                                filename = matches[1].replace(/['"]/g, '');
                            }
                        }
                        
                        a.download = filename;
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        a.remove();
                    } else {
                        swal({
                            title: 'Failed',
                            text: 'Failed to process request',
                            type: 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323'
                        });
                    }
                })
                .catch(error => {
                    $(".loadimage1").fadeOut(100);
                    swal({
                        title: 'Failed',
                        text: 'Failed to process request',
                        type: 'error',
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-light',
                        background: '#222323'
                    });
                });
            }
        });
    })
</script>