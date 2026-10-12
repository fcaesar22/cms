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
                                        <label>Please Select Date</label><br>
                                        <div class='input-group date'>
                                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                            <input type="text" id="activateDate" name="activateDate" placeholder="Pick a date & time" class="form-control datetime-picker" value="">
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label></label><br>
                                        <button type="button" class="btn btn-outline-info" name="applyFilter" id="applyFilter">Apply</button>
                                        <button type="button" class="btn btn-outline-success ml-4 d-none" name="exportData" id="exportData">Export</button>
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
                defaultDate: "<?= set_value('activateDate') ?>"
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

                if (model === 'MNC' && z <= 50000) {
                    $("#exportData").removeClass("d-none");
                } else {
                    $("#exportData").addClass("d-none");
                }

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
                var device_product = result[index].device_product
                sno+=1
                var base_url = '<?php echo base_url()?>'
                var activatedeactivate = ''
                var statusBadge = ''
                if (status==="1") {
                    statusBadge = "<button type='button' class='btn btn-outline-primary' disabled>Not Login</button>"
                    if (model!=="MNC") {
                        activatedeactivate = `<a onclick="confirmAction('${id}', '${model}', '${user}', '${device_product}', 'activate')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate</a>`
                    }
                } else {
                    statusBadge = "<button type='button' class='btn btn-outline-success' disabled>Login</button>"
                    activatedeactivate = `<a onclick="confirmAction('${id}', '${model}', '${user}', '${device_product}', 'deactivate')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate</a>`
                }
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

    function confirmAction(id, model, emailExist, deviceProductExist, action) {
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
                        device_product: deviceProductExist
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

    $('#exportData').click(function() {
        const key_search = $('#searchinputactive').val() || null;
        const model = $('#getModel').val();
        const status = $('#getStatus').val();
        const date = $('#activateDate').val() || null;

        // Dynamically create a form
        var form = $('<form action="stb/downloadFile/'+key_search+'/'+model+'/'+status+'/'+date+'" method="POST"></form>');

        // Append the form to the body (but don't show it)
        $('body').append(form);

        // Submit the form to trigger the CSV download
        form.submit();

        // Optionally, remove the form after submission
        form.remove();
    });
</script>