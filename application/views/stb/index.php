<style type="text/css">
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    .page-link a {color: white;}
    .page-link {width: 35px; height: 35px;}
    .modal-body {max-height: 70vh; overflow-y: auto;}
    .modal-body::-webkit-scrollbar {width: 6px;}
    .modal-body::-webkit-scrollbar-thumb {background-color: rgba(255, 255, 255, 0.2); border-radius: 3px;}
    .modal-body::-webkit-scrollbar-thumb:hover {background-color: rgba(255, 255, 255, 0.35);}
    .modal-body::-webkit-scrollbar-track {background: transparent;}
    .modal-body {scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.2) transparent;}
    #searchinputactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonactive { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow_active { float: left; width: 7%; padding: 3.8px; color: white; font-size: 14px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    #mytable1 .more-content {display: none;}
    #mytable1 .read-more {cursor: pointer; color: rgba(255, 255, 255, .7); padding: 0;}
    #mytable1 .descdiv {white-space: pre-wrap; text-align: justify; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;}
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
    .swal2-content .select2-container--default .select2-selection--single .select2-selection__rendered {text-align: left !important; padding-left: 10px;}
    #headingOne a {pointer-events: none;}
    #headingLog a {pointer-events: none;}
    #headingDetailLog a {pointer-events: none;}
    #modal-log-history .modal-content {background-color: #252525;}
    #modal-log-detail .modal-content {background-color: #252525;}
    .json-wrapper {position: relative; background: #18191b; padding: 15px 15px 15px; border-radius: 10px;}
    .json-label {position: absolute; top: 15px; left: 30px; color: #777; font-size: 13px;}
    .json-textarea {width: 100%; background: #f4f4f4; color: #333; font-family: Consolas, monospace; font-size: 13px; line-height: 1.6; resize: vertical; border: none; border-radius: 10px; padding: 15px 15px 15px;}
    .btn-copy {position: absolute; top: 18px; right: 30px; z-index: 2; width: 42px; height: 42px; border: 1px solid #ddd; border-radius: 50%; background: #fff; color: #555; cursor: pointer;}
    .btn-copy:hover {background: #e9e9e9;}
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
            <h1>STB</h1>
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
                <?php if (has_permission('create_movies')): ?>
                    <div class="mb-4">
                        <a href="<?= base_url('stb/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add STB</a>
                        <button type="button" class="btn btn-outline-success btn--icon-text" name="exportData" id="exportData"><i class="zmdi zmdi-download"></i>Export Data Activation STB MNC</button>
                    </div>
                <?php endif; ?>
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
                                    <div class="col-md-3">
                                        <label>Please Select Model</label><br>
                                        <select class="form-control" name="getModel" id="getModel" required>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Please Select Status</label><br>
                                        <select class="form-control" name="getStatus" id="getStatus" required>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Please Select Active Date</label><br>
                                        <div class='input-group date'>
                                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                            <input type="text" id="activateDate" name="activateDate" placeholder="Pick a date & time" class="form-control datetime-picker" value="">
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label></label><br>
                                        <button type="button" class="btn btn-outline-info" name="applyFilter" id="applyFilter">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="invalid-feedback" id="wardingsearchactive" name="wardingsearchactive" style="display:none;">minimum 3 charachters</span><br>
                <input type="search" placeholder="Search for serial number or email..." name="searchinputactive" id="searchinputactive" minlength="3" maxlength="50">
                <button type="button" name="searchbuttonactive" id="searchbuttonactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                <button type="button" name="selectrow_active" id="selectrow_active" class="btn btn-light">
                    <select name="rowselect_active" id="rowselect_active" style="width: 100%;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </button>
                <input type="hidden" name="sortTable" id="sortTable" value="seq">
                <input type="hidden" name="orderTable" id="orderTable" value="DESC">
                <div class="table-responsive">
                    <table class="table table-striped table-inverse table-bordered mb-0" id="mytable1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Serial Number</th>
                                <th>User</th>
                                <th>Model</th>
                                <th>Status</th>
                                <th>Device Product</th>
                                <th>Active Date</th>
                                <th>Action</th>
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
</section>

<div class="modal fade" id="modal-log-history" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Log History</h5>
            </div>
            <div class="modal-body">
                <div class="accordion" role="tablist">
                    <div class="card">
                        <div class="card-header" role="tab" id="headingLog">
                            <a data-toggle="collapse" href="#collapseLog" aria-expanded="true" aria-controls="collapseLog" class="">
                                <i class="zmdi zmdi-filter-list zmdi-hc-fw"></i>
                                Filter
                            </a>
                        </div>
                        <div id="collapseLog" class="collapse show" role="tabpanel" aria-labelledby="headingLog" data-parent="#accordion" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Please Select Type</label><br>
                                        <select class="form-control" name="getTypeLog" id="getTypeLog" required>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Please Select Status</label><br>
                                        <select class="form-control" name="getStatusLog" id="getStatusLog" required>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label></label><br>
                                        <button type="button" class="btn btn-outline-info" name="applyFilterLog" id="applyFilterLog">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="idLog" name="idLog" value="">
                <input type="hidden" id="modelLog" name="modelLog" value="">
                <input type="hidden" id="serialNumberLog" name="serialNumberLog" value="">
                <input type="hidden" id="deviceProductLog" name="deviceProductLog" value="">
                <div class="table-responsive">
                    <table class="table table-striped table-inverse table-bordered mb-0" id="tableLog" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Serial Number</th>
                                <th>User</th>
                                <th>Device Product</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Create Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <div class="dataTables_info" id="data-table_infoLog" role="status" aria-live="polite"></div>
                    <div style='margin-top: 10px;' id='paginationLog'></div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-log-detail" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Log History</h5>
            </div>
            <div class="modal-body">
                <div class="accordion" role="tablist">
                    <div class="card">
                        <div class="card-header" role="tab" id="headingDetailLog">
                            <a data-toggle="collapse" href="#collapseDetailLog" aria-expanded="true" aria-controls="collapseDetailLog" class="">
                                <i class="zmdi zmdi-filter-list zmdi-hc-fw"></i>
                                Detail
                            </a>
                        </div>
                        <div id="collapseDetailLog" class="collapse show" role="tabpanel" aria-labelledby="headingDetailLog" data-parent="#accordion" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4" style="margin-bottom: 10px;">
                                        <label>Serial Number</label><br>
                                        <input type="text" class="form-control" name="serialNumberDetail" id="serialNumberDetail" readonly>
                                    </div>
                                    <div class="col-md-4" style="margin-bottom: 10px;">
                                        <label>User</label><br>
                                        <input type="text" class="form-control" name="userDetail" id="userDetail" readonly>
                                    </div>
                                    <div class="col-md-4" style="margin-bottom: 10px;">
                                        <label>Device Product</label><br>
                                        <input type="text" class="form-control" name="deviceProductDetail" id="deviceProductDetail" readonly>
                                    </div>
                                    <div class="col-md-4" style="margin-bottom: 15px;">
                                        <label>Type</label><br>
                                        <button type="button" name="actionDetail" id="actionDetail" disabled></button>
                                    </div>
                                    <div class="col-md-4" style="margin-bottom: 15px;">
                                        <label>Status</label><br>
                                        <button type="button" name="statusDetail" id="statusDetail" disabled></button>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Request Payload</label><br>
                                        <div class="json-wrapper">
                                            <button type="button" class="btn-copy" onclick="copyPayload('requestDetail')" title="Copy JSON"><i class="fa fa-copy"></i></button>
                                            <textarea name="requestDetail" id="requestDetail" class="json-textarea" rows="10" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Response Payload</label><br>
                                        <div class="json-wrapper">
                                            <button type="button" class="btn-copy" onclick="copyPayload('responseDetail')" title="Copy JSON"><i class="fa fa-copy"></i></button>
                                            <textarea name="responseDetail" id="responseDetail" class="json-textarea" rows="10" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#getModel').select2({
            ajax: {
                url: '<?= base_url() ?>stb/getListModel',
                type: 'post',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page
                    }
                },
                processResults: function (data, params) {
                    params.page = params.page || 1
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    }
                },
                cache: true
            },
            placeholder: 'Select a model',
            width: '100%',
            templateResult: format,
            templateSelection: formatSelection
        })

        var optionModel = new Option('ALL', 'ALL', true, true);
        $('#getModel').append(optionModel).trigger('change');

        $('#getStatus').select2({
            ajax: {
                url: '<?= base_url() ?>stb/getListStatus',
                type: 'post',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page
                    }
                },
                processResults: function (data, params) {
                    params.page = params.page || 1
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    }
                },
                cache: true
            },
            placeholder: 'Select a status',
            width: '100%',
            templateResult: format,
            templateSelection: formatSelection
        })

        var optionStatus = new Option('All', 'All', true, true);
        $('#getStatus').append(optionStatus).trigger('change');

        $( function () {
            $("#activateDate").flatpickr({
                mode: "range",
                dateFormat: "Y-m-d",
                defaultDate: "<?= set_value('activateDate') ?>",
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 1) {
                        const start = selectedDates[0];

                        const maxDate = new Date(start);
                        maxDate.setFullYear(maxDate.getFullYear() + 1);

                        instance.set("maxDate", maxDate);
                    } else if (selectedDates.length === 0) {
                        instance.set("maxDate", null);
                    }
                },
                onClose: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length !== 1) {
                        instance.set("maxDate", null);
                    }
                }
            })
            $("#activateDate").prop('readonly', false)
        })

        $('#rowselect_active').select2()

        var key_search = null
        var model = $('#getModel').val()
        var status = $('#getStatus').val()
        var date = null
        var sort_by = $('#sortTable').val()
        var order_by = $('#orderTable').val()
        var row_per_page = $('#rowselect_active').val()
        var page_number = 0

        loadPagination(key_search, model, status, date, sort_by, order_by, row_per_page, page_number)
    })

    $(document).on('click', '#applyFilter', function () {
        const key_search = $('#searchinputactive').val() || null
        const model = $('#getModel').val()
        const status = $('#getStatus').val() || null
        const date = $('#activateDate').val() || null
        const sort_by = $('#sortTable').val()
        const order_by = $('#orderTable').val()
        const row_per_page = $('#rowselect_active')
        row_per_page.val(10).trigger('change.select2')
        const page_number = 0

        loadPagination(key_search, model, status, date, sort_by, order_by, row_per_page.val(), page_number)
    })

    $(document).on('keydown', '#searchinputactive', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $('#searchbuttonactive').trigger('click');
        }
    });

    $(document).on('click', '#searchbuttonactive', function () {
        handleSearch('active')
    })

    function handleSearch(type) {
        var key_search = $('#searchinput' + type).val()
        
        if (!key_search || key_search.length < 3) {
            $('#wardingsearch' + type).show()
            setTimeout(function () {
                $('#wardingsearch' + type).hide()
            }, 5000)
            return
        }

        var model = $('#getModel').val()
        var status = $('#getStatus').val()
        var date = $('#activateDate').val() || null
        var sort_by = $('#sortTable').val()
        var order_by = $('#orderTable').val()
        var row_per_page = $('#rowselect_active').val()
        var page_number = 0

        loadPagination(key_search, model, status, date, sort_by, order_by, row_per_page, page_number)
    }

    handlePaginationClick('#pagination', 'active')

    function handlePaginationClick(paginationSelector, type) {
        $(paginationSelector).on('click', '.page-link', function (e) {
            e.preventDefault()
            
            var isActive = type === 'active'
            var key_search = $('#searchinput' + type).val() || null
            var model = $('#getModel').val()
            var status = $('#getStatus').val()
            var date = $('#activateDate').val() || null
            var sort_by = $('#sortTable').val()
            var order_by = $('#orderTable').val()
            var row_per_page = $('#rowselect_' + type).val()
            var link = $(this).find('a')
            var page_number = link.data('ci-pagination-page')
            
            if (!page_number) {
                var text = $(this).text().trim()
                if (!isNaN(text)) {
                    page_number = parseInt(text, 10)
                }
            }

            if (!page_number) {
                return
            }

            loadPagination(key_search, model, status, date, sort_by, order_by, row_per_page, page_number)
        })
    }

    function loadPagination(key_search, model, status, date, sort_by, order_by, row_per_page, page_number) {
        $(".loadimage1").show();
        $.ajax({
            url: '<?=base_url()?>stb/listStb/'+key_search+'/'+model+'/'+status+'/'+date+'/'+sort_by+'/'+order_by+'/'+row_per_page+'/'+page_number,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var order_by = response.order
                var x = response.x
                var y = response.y
                var z = response.z

                var show = 'Showing '+x+' to '+y+' of '+z+' entries'
                $('#data-table_info').html(show)
                
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
                    $('#pagination').html(page1)
                } else {
                    $('#pagination').html(response.pagination)
                }
                createTable(response.result, response.row)
            },
            error: function () {
                $(".loadimage1").fadeOut();
                swal({
                    title: 'Error',
                    text: 'I will close in 2 seconds.',
                    timer: 2000,
                    showConfirmButton: false,
                    buttonsStyling: false,
                    background: 'rgba(0, 0, 0, 0.96)'
                });
            },
            complete: function () {
                $(".loadimage1").fadeOut(100);
            }
        })
    }

    function createTable(result, sno) {
        $('#mytable1 tbody').empty()
        if (result.length > 0) {
            sno = Number(sno)
            for (index in result) {
                var id = result[index].seq
                var serial_number = result[index].serial_number
                var user = result[index].user
                var model = result[index].model
                var status = result[index].status
                var active_date = result[index].active_date
                var device_product = result[index].device_product ?? ''
                sno+=1
                var base_url = '<?php echo base_url()?>'
                var activatedeactivate = ''
                var statusBadge = ''
                if (status==="1") {
                    statusBadge = "<button type='button' class='btn btn-outline-primary' disabled>Not Login</button>"
                    if (model !== "MNC" && model !== "ZTEATV") {
                        activatedeactivate = `<a onclick="confirmAction('${id}', '${model}', '${user}', '${device_product}', '${serial_number}', 'activate')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate</a>`
                    }
                } else {
                    statusBadge = "<button type='button' class='btn btn-outline-success' disabled>Login</button>"
                    activatedeactivate = `<a onclick="confirmAction('${id}', '${model}', '${user}', '${device_product}', '${serial_number}', 'deactivate')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate</a>`
                }
                var logDetail = `<a onclick="logDetail('${id}', '${model}', '${serial_number}', '${device_product}')" href="#!" class="dropdown-item"><i class="zmdi zmdi-info zmdi-hc-fw"></i>Log History</a>`
                var tr = "<tr id='"+id+"'>"
                tr += "<td>"+ sno +"</td>"
                tr += "<td>"+ serial_number +"</td>"
                tr += "<td>"+ user +"</td>"
                tr += "<td>"+ model +"</td>"
                tr += "<td>"+ statusBadge +"</td>"
                tr += "<td>"+ device_product +"</td>"
                tr += "<td>"+ active_date +"</td>"
                tr += `<td>
                            <div class='dropdown'>
                                <button class='btn btn-light' data-toggle='dropdown' aria-expanded='false'>ACTION</button>
                                <div class='dropdown-menu dropdown-menu--icon'>
                                <?php if (has_permission('edit_stb')): ?>
                                    <a href="<?= base_url('stb/edit/${id}') ?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                    ${logDetail}
                                    ${activatedeactivate}
                                <?php endif; ?>
                                </div>
                            </div>
                        </td>`
                tr += "</tr>"
                $('#mytable1 tbody').append(tr)
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="10" class="dataTables_empty">No matching records found</td></tr>`
            $('#mytable1 tbody').append(tr)
        }
    }

    function confirmAction(id, model, emailExist, deviceProductExist, serialNumberExist, action) {
        const settings = {
            activate: {
                url: '<?=base_url()?>stb/activateStb',
                confirmText: 'Activate',
                confirmClass: 'btn btn-success',
            },
            deactivate: {
                url: '<?=base_url()?>stb/deactivateStb',
                confirmText: 'Deactivate',
                confirmClass: 'btn btn-danger',
            }
        }

        const config = settings[action];

        if (!config) {
            return;
        }

        let html = '';

        if (action === 'activate') {
            html = `
                <div class="row">
                    <div class="col-md-12" style="text-align: left;"> <!-- Tambah rata kiri untuk label -->
                        <label>Title (*required)</label>
                        <select id="swal-email" class="swal2-select" style="width:100%">
                            <option></option>
                        </select>
                    </div>
                </div>
            `;
        }

        swal({
            title: 'Are you sure?',
            text: action === 'activate' ? 'Please fill out the form below' : '',
            html: html,
            type: 'warning',
            showCancelButton: true,
            showLoaderOnConfirm: true,
            buttonsStyling: false,
            confirmButtonClass: config.confirmClass,
            confirmButtonText: config.confirmText,
            cancelButtonClass: 'btn btn-light',
            background: '#222323',
            allowOutsideClick: false,
            allowEscapeKey: false,
            onOpen: function () {
                $('#swal-email').select2({
                    ajax: {
                        url: '<?= base_url() ?>stb/getEmail',
                        type: 'POST',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                searchTerm: params.term,
                                page: params.page
                            };
                        },
                        processResults: function(data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.items,
                                pagination: {
                                    more: (params.page * 10) < data.total_count
                                }
                            }
                        },
                        cache: true
                    },
                    placeholder: 'Please select email',
                    width: '100%',
                    dropdownParent: $('.swal2-modal'),
                    templateResult: format,
                    templateSelection: formatSelection
                });

            },
            preConfirm: function () {
                return new Promise(function(resolve, reject) {
                    if (action !== 'activate') {
                        resolve({
                            email: emailExist,
                        });
                        return;
                    }

                    let email = $('#swal-email').val() || '';
                    email = email.trim();

                    if (!email) {
                        swal.showValidationError('Email address is required');
                        reject();
                        return;
                    }

                    resolve({
                        email: email,
                    });
                });
            }
        }).then(function(result) {
            if (result) {
                $(".loadimage1").show();

                $.ajax({
                    url: config.url,
                    type: 'post',
                    data: {
                        id: id,
                        model: model,
                        email: result.email,
                        device_product: deviceProductExist,
                        serial_number: serialNumberExist
                    },
                    dataType: 'json',
                    success: function(response) {
                        $(".loadimage1").fadeOut(100);

                        swal({
                            title: response.error === '0' ? 'Success' : 'Failed',
                            text: response.message,
                            type: response.error === '0' ? 'success' : 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(function (ok) {
                            if (ok && response.error === '0') {
                                const key_search = $('#searchinputactive').val() || null;
                                const model = $('#getModel').val();
                                const status = $('#getStatus').val();
                                const date = $('#activateDate').val() || null;
                                const sort_by = $('#sortTable').val();
                                const order_by = $('#orderTable').val();
                                const row_per_page = $('#rowselect_active').val();

                                let page_number = $('#pagination .page-item.active .page-link a').data('ci-pagination-page');

                                if (!page_number) {
                                    page_number = parseInt($('#pagination .page-item.active').text().trim()) || 0;
                                }

                                loadPagination(key_search, model, status, date, sort_by, order_by, row_per_page, page_number);
                            }
                        })
                    },
                    error: function() {
                        $(".loadimage1").fadeOut(100);

                        swal({
                            title: 'Failed',
                            text: 'Failed to process request',
                            type: 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        })
                    }
                });
            }
        });
    }

    function logDetail(id, model, serialNumber, deviceProduct) {
        $('#modal-log-history').modal('show');

        $('#idLog').val(id);
        $('#modelLog').val(model);
        $('#serialNumberLog').val(serialNumber);
        $('#deviceProductLog').val(deviceProduct);

        loadPaginationLog(id, model, serialNumber, deviceProduct, 10, 0)
    }

    logHandlePaginationClick('#paginationLog')

    function logHandlePaginationClick(paginationSelector) {
        $(paginationSelector).on('click', '.page-link', function (e) {
            e.preventDefault()

            var id = $('#idLog').val()
            var model = $('#modelLog').val()
            var serialNumber = $('#serialNumberLog').val()
            var deviceProduct = $('#deviceProductLog').val()
            var rowPerPage = 10
            var link = $(this).find('a')
            var pageNumber = link.data('ci-pagination-page')
            
            if (!pageNumber) {
                var text = $(this).text().trim()
                if (!isNaN(text)) {
                    pageNumber = parseInt(text, 10)
                }
            }

            if (!pageNumber) {
                return
            }

            loadPaginationLog(id, model, serialNumber, deviceProduct, rowPerPage, pageNumber)
        })
    }

    function loadPaginationLog(id, model, serialNumber, deviceProduct, rowPerPage, pageNumber) {
        $(".loadimage1").show();
        $.ajax({
            url: '<?=base_url()?>stb/getListStbLog/'+id+'/'+model+'/'+serialNumber+'/'+deviceProduct+'/'+rowPerPage+'/'+pageNumber,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var order_by = response.order
                var x = response.x
                var y = response.y
                var z = response.z

                var show = 'Showing '+x+' to '+y+' of '+z+' entries'
                $('#data-table_infoLog').html(show)
                
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
                    $('#paginationLog').html(page1)
                } else {
                    $('#paginationLog').html(response.pagination)
                }
                createTableLog(response.result, response.row, model)
            },
            error: function () {
                $(".loadimage1").fadeOut();
                swal({
                    title: 'Error',
                    text: 'I will close in 2 seconds.',
                    timer: 2000,
                    showConfirmButton: false,
                    buttonsStyling: false,
                    background: 'rgba(0, 0, 0, 0.96)'
                });
            },
            complete: function () {
                $(".loadimage1").fadeOut(100);
            }
        })
    }

    function createTableLog(result, sno, model) {
        $('#tableLog tbody').empty()
        if (result.length > 0) {
            sno = Number(sno)
            for (index in result) {
                var id = result[index].id
                var serial_number = result[index].serial_number
                var user = result[index].user
                var device_product = result[index].device_product ?? ''
                var action = result[index].action
                var status = result[index].status
                var created_at = result[index].created_at
                sno+=1
                switch (action) {
                    case 'ACTIVATION':
                        var typeBadge = "<button type='button' class='btn btn-outline-success' disabled>Activation</button>";
                        break;
                    case 'RESET_STB':
                        var typeBadge = "<button type='button' class='btn btn-outline-danger' disabled>Reset</button>";
                        break;
                    default:
                        var typeBadge = "";
                }
                var statusBadge = ''
                if (status==="SUCCESS") {
                    statusBadge = "<button type='button' class='btn btn-outline-success' disabled>Success</button>"
                } else {
                    statusBadge = "<button type='button' class='btn btn-outline-danger' disabled>Failed</button>"
                }
                var tr = "<tr>"
                tr += "<td>"+ sno +"</td>"
                tr += "<td>"+ serial_number +"</td>"
                tr += "<td>"+ user +"</td>"
                tr += "<td>"+ device_product +"</td>"
                tr += "<td>"+ typeBadge +"</td>"
                tr += "<td>"+ statusBadge +"</td>"
                tr += "<td>"+ created_at +"</td>"
                tr += "<td><button onclick=\"detailLogs('" + id + "', '" + model + "', '" + serial_number + "', '" + device_product + "')\" type='button' class='btn btn-light' id='detailLog' name='detailLog' data-toggle='modal' data-target='#modal-log-detail'>Detail</button></td>"
                tr += "</tr>"
                $('#tableLog tbody').append(tr)
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No matching records found</td></tr>`
            $('#tableLog tbody').append(tr)
        }
    }

    function detailLogs(id, model, serial_number, device_product) {
        $(".loadimage1").show();
        $.ajax({
            url: '<?=base_url()?>stb/getDetailStbLog/'+id+'/'+model+'/'+serial_number+'/'+device_product,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                console.log(response)
                var sn = response[0].serial_number
                var user = response[0].user
                var dp = response[0].device_product
                var type = response[0].action
                var status = response[0].status
                $('#serialNumberDetail').val(sn)
                $('#userDetail').val(user)
                $('#deviceProductDetail').val(dp)
                var actionButton = $('#actionDetail');
                actionButton.removeClass('btn-outline-success btn-outline-danger');
                switch (type) {
                    case 'ACTIVATION':
                        actionButton.addClass('btn btn-outline-success').text('Activation');
                        break;
                    case 'RESET_STB':
                        actionButton.addClass('btn btn-outline-danger').text('Reset');
                        break;
                    default:
                        actionButton.addClass('btn btn-outline-secondary').text(type || '-');
                }
                var statusButton = $('#statusDetail');
                statusButton.removeClass('btn-outline-success btn-outline-danger');
                if (status === "SUCCESS") {
                    statusButton.addClass('btn btn-outline-success').text('Success');
                } else {
                    statusButton.addClass('btn btn-outline-danger').text('Failed');
                }
                var requestPayload = response[0].request_payload;
                var responsePayload = response[0].response_payload;
                $('#requestDetail').val(requestPayload ? JSON.stringify(JSON.parse(requestPayload), null, 4) : '');
                $('#responseDetail').val(responsePayload ? JSON.stringify(JSON.parse(responsePayload), null, 4) : '');
            },
            error: function () {
                $(".loadimage1").fadeOut();
                swal({
                    title: 'Error',
                    text: 'I will close in 2 seconds.',
                    timer: 2000,
                    showConfirmButton: false,
                    buttonsStyling: false,
                    background: 'rgba(0, 0, 0, 0.96)'
                });
            },
            complete: function () {
                $(".loadimage1").fadeOut(100);
            }
        })
    }

    function copyPayload(id) {
        var textarea = document.getElementById(id);

        navigator.clipboard.writeText(textarea.value)
            .then(function () {
                swal({
                    title: 'Copied!',
                    text: 'JSON successfully copied.',
                    timer: 2000,
                    showConfirmButton: false,
                    type: 'success',
                    buttonsStyling: false,
                    background: 'rgba(0, 0, 0, 0.96)'
                });
            });
    }

    function format (repo) {
        if (repo.loading) {
            return repo.text
        }
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'></div>" +
            "</div>"
        )
        $container.find('.select2-result-repository__title').text(repo.text)
        return $container
    }

    function formatSelection (repo) {
        return repo.text
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
            title: 'Export Data Activation STB MNC',
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
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length === 1) {
                            const start = selectedDates[0];

                            const maxDate = new Date(start);
                            maxDate.setFullYear(maxDate.getFullYear() + 1);

                            instance.set("maxDate", maxDate);
                        } else if (selectedDates.length === 0) {
                            instance.set("maxDate", null);
                        }
                    },
                    onClose: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length !== 1) {
                            instance.set("maxDate", null);
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

                fetch('<?=base_url()?>stb/exportDatas', {
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