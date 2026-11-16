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
    #searchinputactive, #searchinputinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonactive, #searchbuttoninactive { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow_active, #selectrow_inactive { float: left; width: 7%; padding: 3.8px; color: white; font-size: 14px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #tbody-tooltip {position: absolute; padding: 6px 12px; background: #fff; color: #333; border-radius: 4px; font-size: 13px; font-weight: 500; box-shadow: 0 2px 6px rgba(0,0,0,0.3); pointer-events: none; white-space: nowrap; z-index: 2000; display: none;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Management Section Packages</h1>
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
                <?php if (has_permission('create_sectionpackages')): ?>
                    <a href="<?= base_url('section_packages/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Section Package</a><br><br>
                <?php endif; ?>

                <input type="hidden" name="sort_table" id="sort_table" value="id_package_ott">
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
                                    <div class="col-md-3">
                                        <label>Please Select Type</label><br>
                                        <select class="form-control" name="getType" id="getType" required>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Please Select Device</label><br>
                                        <select class="form-control" name="getDevice" id="getDevice" required>
                                            <option></option>
                                        </select>
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

                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a id="active_tab" class="nav-link active" data-toggle="tab" href="#activeTab" role="tab">Active</a>
                        </li>
                        <li class="nav-item">
                            <a id="inactive_tab" class="nav-link" data-toggle="tab" href="#inactiveTab" role="tab">Inactive</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active fade show" id="activeTab" role="tabpanel">
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
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Device</th>
                                            <th>Create Date</th>
                                            <th>Update Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="active-tbody" class="table-active" style="cursor: all-scroll;">
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_info" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination'></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="inactiveTab" role="tabpanel">
                            <span class="invalid-feedback" id="wardingsearchinactive" name="wardingsearchinactive" style="display:none;">minimum 3 charachters</span>
                            <br>
                            <input type="search" placeholder="Search for title..." name="searchinputinactive" id="searchinputinactive" minlength="3" maxlength="50">
                            <button type="button" name="searchbuttoninactive" id="searchbuttoninactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrow_inactive" id="selectrow_inactive" class="btn btn-light">
                                <select name="rowselect_inactive" id="rowselect_inactive" style="width: 100%;">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytable2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Device</th>
                                            <th>Create Date</th>
                                            <th>Update Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_info2" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination2'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Active Package Confirmation-->
<div class="modal fade" id="activeExploreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-confirmactive" class="btn btn-success" href="#">Yes</a>
            </div>
        </div>
    </div>
</div>

<!--Inactive Package Confirmation-->
<div class="modal fade" id="inactiveExploreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-confirminactive" class="btn btn-danger" href="#">Yes</a>
            </div>
        </div>
    </div>
</div>

<div id="tbody-tooltip">Drag & drop to reorder sort</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#getType').select2({
            ajax: {
                url: '<?= base_url() ?>section_packages/getListTypeSection',
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
            placeholder: 'Select a type',
            width: '100%',
            templateResult: format,
            templateSelection: formatSelection
        })

        var optionModel = new Option('Main Package', '0', true, true);
        $('#getType').append(optionModel).trigger('change');

        $('#getDevice').select2({
            ajax: {
                url: '<?= base_url() ?>section_packages/getListDeviceSection',
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
            placeholder: 'Select a device',
            width: '100%',
            templateResult: format,
            templateSelection: formatSelection
        })

        var optionStatus = new Option('WEB', '10', true, true);
        $('#getDevice').append(optionStatus).trigger('change');

        activaTab('activeTab')

        $('#rowselect_active').select2()
        $('#rowselect_inactive').select2()
    })

    function activaTab(tab) {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show')
        var typeSection = $('#getType').val()
        var deviceSection = $('#getDevice').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search == '') {
            key_search = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search, sort_by, order_sort, visible, typeSection, deviceSection, rowperpage, 0)
    }

    function handleTab(type) {
        var optionModel = new Option('Main Package', '0', true, true);
        $('#getType').append(optionModel).trigger('change');
        var optionStatus = new Option('WEB', '10', true, true);
        $('#getDevice').append(optionStatus).trigger('change');
        var typeSection = $('#getType').val()
        var deviceSection = $('#getDevice').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        switch(type) {
            case 'active':
                var visible = 'Y'
                $("#inactiveTab").hide()
                $("#activeTab").show()
                break;
            case 'inactive':
                var visible = 'N'
                $("#activeTab").hide()
                $("#inactiveTab").show()
                break;
            default:
                var visible = 'Y'
                $("#inactiveTab").hide()
                $("#activeTab").show()
        }
        $('#visible').val(visible)
        $('#searchinput' + type).val(null)
        var key_search = null
        $('#rowselect_' + type).val(10).trigger('change.select2')
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(key_search, sort_by, order_sort, visible, typeSection, deviceSection, rowperpage, 0)
    }

    $(document).on('click', '#active_tab', function () {
        handleTab('active')
    })

    $(document).on('click', '#inactive_tab', function () {
        handleTab('inactive')
    })

    $(document).on('click', '#applyFilter', function () {
        var activeTab = $('.nav-tabs .nav-link.active').attr('href');
        var type, visible;
        if (activeTab === '#activeTab') {
            type = 'active';
            visible = 'Y';
        } else {
            type = 'inactive';
            visible = 'N';
        }
        $('#visible').val(visible)
        var pageno = 0
        var typeSection = $('#getType').val()
        var deviceSection = $('#getDevice').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinput' + type).val() || null
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(key_search, sort_by, order_sort, visible, typeSection, deviceSection, rowperpage, pageno)
    })

    $(document).on('keydown', '#searchinputactive', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault()
            $('#searchbuttonactive').trigger('click')
        }
    })

    $(document).on('keydown', '#searchinputinactive', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault()
            $('#searchbuttoninactive').trigger('click')
        }
    })

    function handleRowSelect(type) {
        var pageno = 0
        var typeSection = $('#getType').val()
        var deviceSection = $('#getDevice').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinput' + type).val() || null
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(key_search, sort_by, order_sort, visible, typeSection, deviceSection, rowperpage, pageno)
    }

    $(document).on('change', '#rowselect_active', function () {
        handleRowSelect('active')
    })

    $(document).on('change', '#rowselect_inactive', function () {
        handleRowSelect('inactive')
    })

    function handleSearch(type) {
        var search = $('#searchinput' + type).val()
        if (!search || search.length < 3) {
            $('#wardingsearch' + type).show()
            setTimeout(function () {
                $('#wardingsearch' + type).hide()
            }, 5000)
            return
        }
        var typeSection = $('#getType').val()
        var deviceSection = $('#getDevice').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(search, sort_by, order_sort, visible, typeSection, deviceSection, rowperpage, 0)
    }

    $(document).on('click', '#searchbuttonactive', function () {
        handleSearch('active')
    })

    $(document).on('click', '#searchbuttoninactive', function () {
        handleSearch('inactive')
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
            var typeSection = $('#getType').val()
            var deviceSection = $('#getDevice').val()
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var visible = $('#visible').val()
            loadPagination(key_search, sort_by, order_sort, visible, typeSection, deviceSection, rowperpage, pageno)
        })
    }

    handlePaginationClick('#pagination', 'active')
    handlePaginationClick('#pagination2', 'inactive')

    function loadPagination(key_search, sort_by, order_sort, visible, typeSection, deviceSection, rowperpage, pageno) {
        $.ajax({
            url: '<?=base_url()?>section_packages/list_sections/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+typeSection+'/'+deviceSection+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var order_sort = response.order
                var x = response.x
                var y = response.y
                var z = response.z
                var show = 'Showing '+x+' to '+y+' of '+z+' entries'

                switch(visible) {
                    case 'Y':
                        $('#data-table_info').html(show)
                        var paginationId = '#pagination'
                        break;
                    case 'N':
                        $('#data-table_info2').html(show)
                        var paginationId = '#pagination2'
                        break;
                    default:
                        $('#data-table_info').html(show)
                        var paginationId = '#pagination'
                }

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
                createTable(response.result, response.row)
            }
        })
    }

    function createTable(result, sno) {
        var statustable = $('#visible').val()

        switch(statustable) {
            case 'Y':
                var tableId = '#mytable1 tbody'
                break;
            case 'N':
                var tableId = '#mytable2 tbody'
                break;
            default:
                var tableId = '#mytable1 tbody'
        }

        $(tableId).empty()

        if (result.length > 0) {
            sno = Number(sno)
            for (index in result) {
                var id = result[index].id_package_ott
                var title = result[index].title
                var type = result[index].type_package ?? ''
                var device = result[index].app_type
                var create_date = result[index].create_date
                var update_date = result[index].update_date
                var visible = result[index].visible

                var typePackage = ''
                if (type === '0') {
                    typePackage = 'Main Package'
                } else if (type === '1') {
                    typePackage = 'Add-On Package'
                }

                var typeDevice = ''
                if (device === '10') {
                    typeDevice = 'WEB'
                } else if (device === '20') {
                    typeDevice = 'STB'
                } else if (device === '30') {
                    typeDevice = 'ANDROID'
                } else if (device === '40') {
                    typeDevice = 'IOS'
                }
                
                sno+=1
                var base_url ='<?php echo base_url()?>'
                var activeinactive = ""
                var statusRow = ""

                if (visible === "Y") {
                    activeinactive = `<a onclick="inactiveConfirm('${base_url}section_packages/inactivatedSection/${id}/${type}/${device}')" href="#!" class="dropdown-item"><i class="zmdi zmdi-minus-circle zmdi-hc-fw"></i>Deactivate</a>`
                    statusRow = "<button type='button' class='btn btn-outline-success' disabled>Active</button>"
                } else {
                    activeinactive = `<a onclick="activeConfirm('${base_url}section_packages/activatedSection/${id}/${type}/${device}')" href="#!" class="dropdown-item"><i class="zmdi zmdi-plus-circle zmdi-hc-fw"></i>Activate</a>`
                    statusRow = "<button type='button' class='btn btn-outline-danger' disabled>Inactive</button>"
                }

                var tr = "<tr id='"+id+"'>"
                tr += "<td>"+ sno +"</td>"
                tr += "<td>"+ title +"</td>"
                tr += "<td>"+ typePackage +"</td>"
                tr += "<td>"+ typeDevice +"</td>"
                tr += "<td>"+ create_date +"</td>"
                tr += "<td>"+ update_date +"</td>"
                tr += "<td>"+ statusRow +"</td>"
                tr += `<td>
                            <div class='dropdown'>
                                <button class='btn btn-light' data-toggle='dropdown' aria-expanded='false'>ACTION</button>
                                <div class='dropdown-menu dropdown-menu--icon'>
                                <?php if (has_permission('edit_sectionpackages')): ?>
                                    <a href="<?= base_url('section_packages/edit/${id}') ?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                <?php endif; ?>
                                <?php if (has_permission('delete_sectionpackages')): ?>
                                    ${activeinactive}
                                <?php endif; ?>
                                </div>
                            </div>
                        </td>`
                tr += "</tr>"
                $(tableId).append(tr)
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No matching records found</td></tr>`
            $(tableId).append(tr)
        }
    }

    const tooltip = document.getElementById('tbody-tooltip')
    const tbodyparent = document.getElementById('active-tbody')

    tbodyparent.addEventListener('mousemove', function (e) {
        tooltip.style.left = (e.pageX + 10) + 'px' 
        tooltip.style.top = (e.pageY + 15) + 'px'
    })

    tbodyparent.addEventListener('mouseenter', function () {
        tooltip.style.display = 'block'
    })

    tbodyparent.addEventListener('mouseleave', function () {
        tooltip.style.display = 'none'
    })

    $('#active-tbody').sortable({
        placeholder : 'ui-state-highlight',
        update: function (event, ui) {
            const tbody = $(this);
            swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Yes',
                cancelButtonClass: 'btn btn-light',
                background: '#222323',
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    var page_id_array = new Array()
                    tbody.find('tr').each(function () {
                        page_id_array.push($(this).attr('id'));
                    })

                    $.ajax({
                        url: '<?=base_url()?>section_packages/update_sort',
                        method: 'POST',
                        data: {
                            page_id_array: page_id_array,
                            type: $('#getType').val(),
                            device: $('#getDevice').val(),
                            action:'update'
                        },
                        dataType: 'json',
                        success: function (response) {
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
                                    if ($('#visible').val() === 'Y') {
                                        $('#active_tab').trigger('click');
                                    } else {
                                        $('#inactive_tab').trigger('click');
                                    }
                                } else {
                                    tbody.sortable('cancel')
                                }
                            })
                        },
                        error: function () {
                            swal({
                                title: 'Failed',
                                text: 'Failed to process request',
                                type: 'error',
                                buttonsStyling: false,
                                confirmButtonClass: 'btn btn-light',
                                background: '#222323',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            }).then(function (ok) {
                                if (ok) {
                                    tbody.sortable('cancel')
                                }
                            })
                        },
                    })
                }
            }).catch(function () {
                tbody.sortable('cancel')
            })
        }
    })

    function activeConfirm(url) {
        $('#btn-confirmactive').attr('href', url)
        $('#activeExploreModal').modal()
    }

    function inactiveConfirm(url) {
        $('#btn-confirminactive').attr('href', url)
        $('#inactiveExploreModal').modal()
    }

    function format(repo) {
        if (repo.loading) {
            return repo.text
        }
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'></div>" +
            "</div>"
        )
        $container.find(".select2-result-repository__title").text(repo.text)
        return $container
    }

    function formatSelection(repo) {
        return repo.text
    }
</script>