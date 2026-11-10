<style type="text/css">
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    .page-link a {color: white;}
    #searchinputparent, #searchinputchild {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonparent, #searchbuttonchild { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow_parent, #selectrow_child { float: left; width: 7%; padding: 3.8px; color: white; font-size: 14px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #tbody-tooltip {position: absolute; padding: 6px 12px; background: #fff; color: #333; border-radius: 4px; font-size: 13px; font-weight: 500; box-shadow: 0 2px 6px rgba(0,0,0,0.3); pointer-events: none; white-space: nowrap; z-index: 2000; display: none;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Menu Sidebar</h1>
        </header>
        <div class="card">
            <div class="card-body">                
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php if (has_permission('create_menus')): ?>
                    <a href="<?= base_url('menus/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Menu</a>
                <?php endif; ?>
                
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a id="tab_1" class="nav-link" data-toggle="tab" href="#tab1" role="tab">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a id="tab_2" class="nav-link" data-toggle="tab" href="#tab2" role="tab">Sub Menu</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active fade show" id="tab1" role="tabpanel">
                            <input type="hidden" name="sort_table" id="sort_table" value="id">
                            <input type="hidden" name="order_table" id="order_table" value="asc">
                            <input type="hidden" name="type_table" id="type_table" value="parent">
                            <span class="invalid-feedback" id="wardingsearchparent" name="wardingsearchparent" style="display:none;">minimum 3 charachters</span>
                            <br>
                            <input type="search" placeholder="Search for title..." name="searchinputparent" id="searchinputparent" minlength="3" maxlength="50">
                            <button type="button" name="searchbuttonparent" id="searchbuttonparent" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrow_parent" id="selectrow_parent" class="btn btn-light">
                                <select name="rowselect_parent" id="rowselect_parent" style="width: 100%;">
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
                                            <th>Name</th>
                                            <th>URL</th>
                                            <th>Icon</th>
                                            <th>Parent</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="parent-tbody" class="table-parent" style="cursor: all-scroll;">
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_info" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination'></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <span class="invalid-feedback" id="wardingsearchchild" name="wardingsearchchild" style="display:none;">minimum 3 charachters</span>
                            <br>
                            <input type="search" placeholder="Search for title..." name="searchinputchild" id="searchinputchild" minlength="3" maxlength="50">
                            <button type="button" name="searchbuttonchild" id="searchbuttonchild" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrow_child" id="selectrow_child" class="btn btn-light">
                                <select name="rowselect_child" id="rowselect_child" style="width: 100%;">
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
                                            <th>Name</th>
                                            <th>URL</th>
                                            <th>Icon</th>
                                            <th>Parent</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="child-tbody" class="table-child" style="cursor: all-scroll;">
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

<!--Delete Confirmation-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-confirmactive" class="btn btn-danger" href="#">Yes</a>
            </div>
        </div>
    </div>
</div>

<div id="tbody-tooltip">Drag & drop to reorder sort</div>

<script type="text/javascript">
    $(document).ready(function () {
        activaTab('tab1')

        $('#rowselect_parent').select2()
        
        $('#rowselect_child').select2()
    })

    function activaTab(tab) {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show')
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var type_menu = $('#type_table').val()
        var key_search = $('#searchinputparent').val()
        if (key_search == '') {
            key_search = null
        }
        var rowperpage = $('#rowselect_parent').val()
        loadPagination(key_search, sort_by, order_sort, type_menu, rowperpage, 0)
    }

    function handleTab(type) {
        var isActive = type === 'parent'
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var type_menu = isActive ? 'parent' : 'child'
        $('#type_table').val(type_menu)
        $('#searchinput' + type).val(null)
        var key_search = null
        $('#rowselect_' + type).val(10).trigger('change.select2')
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(key_search, sort_by, order_sort, type_menu, rowperpage, 0)
        if (isActive) {
            $("#tab2").hide()
            $("#tab1").show()
        } else {
            $("#tab1").hide()
            $("#tab2").show()
        }
    }

    $(document).on('click', '#tab_1', function () {
        handleTab('parent')
    })

    $(document).on('click', '#tab_2', function () {
        handleTab('child')
    })

    function handleRowSelect(type) {
        var pageno = 0
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var type_menu = $('#type_table').val()
        var key_search = $('#searchinput' + type).val() || null
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(key_search, sort_by, order_sort, type_menu, rowperpage, pageno)
    }

    $(document).on('change', '#rowselect_parent', function () {
        handleRowSelect('parent')
    })

    $(document).on('change', '#rowselect_child', function () {
        handleRowSelect('child')
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
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var type_menu = $('#type_table').val()
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(search, sort_by, order_sort, type_menu, rowperpage, 0)
    }

    $(document).on('click', '#searchbuttonparent', function () {
        handleSearch('parent')
    })

    $(document).on('click', '#searchbuttonchild', function () {
        handleSearch('child')
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
            var type_menu = $('#type_table').val()
            loadPagination(key_search, sort_by, order_sort, type_menu, rowperpage, pageno)
        })
    }

    handlePaginationClick('#pagination', 'parent')

    handlePaginationClick('#pagination2', 'child')

    function loadPagination(key_search, sort_by, order_sort, type_menu, rowperpage, pageno) {
        $.ajax({
            url: '<?=base_url()?>menus/list_menus/'+key_search+'/'+sort_by+'/'+order_sort+'/'+type_menu+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var order_sort = response.order
                var x = response.x
                var y = response.y
                var z = response.z
                var show = 'Showing '+x+' to '+y+' of '+z+' entries'
                $('#data-table_info').html(show)
                if (type_menu == 'Y') {
                    $('#data-table_info').html(show)
                } else {
                    $('#data-table_info2').html(show)
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
                    if (type_menu == 'Y') {
                        $('#pagination').html(page1)
                    } else {
                        $('#pagination2').html(page1)
                    }
                } else {
                    if (type_menu == 'Y') {
                        $('#pagination').html(response.pagination)
                    } else {
                        $('#pagination2').html(response.pagination)
                    }
                }
                createTable(response.result, response.row)
            }
        })
    }

    function createTable(result, sno) {
        var statustable = $('#type_table').val()
        if (statustable == 'parent') {
            $('#mytable1 tbody').empty()
        } else {
            $('#mytable2 tbody').empty()
        }

        if (result.length > 0) {
            sno = Number(sno)
            for (index in result) {
                var id = result[index].id
                var name = result[index].name
                var url = result[index].url
                var icon = result[index].icon
                var parent_id = result[index].parent_id
                var parent_name = result[index].parent_name ?? ''
                var sort_order = result[index].sort_order
                sno+=1
                var base_url ='<?php echo base_url()?>'
                var tr = "<tr id='"+id+"' data-parent-id='"+parent_id+"'>";
                tr += "<td>"+ sno +"</td>"
                tr += "<td>"+ name +"</td>"
                tr += "<td>"+ url +"</td>"
                tr += "<td><i class='"+ icon +"'></i></td>"
                tr += "<td>"+ parent_name +"</td>"
                tr += `<td>
                            <?php if (has_permission('edit_menus')): ?>
                                <a href="<?= base_url('menus/set_permission_menu/${id}') ?>" class="btn btn-outline-info btn--icon-text"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Set Permission Menu</a>
                            <?php endif; ?>
                            <?php if (has_permission('edit_menus')): ?>
                                <a href="<?= base_url('menus/edit/${id}') ?>" class="btn btn-outline-warning btn--icon-text"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                            <?php endif; ?>
                            <?php if (has_permission('delete_menus')): ?>
                                <a href="#!" class="btn btn-outline-danger btn--icon-text" onclick="deleteConfirm('${base_url}menus/delete/${id}')"><i class="zmdi zmdi-delete zmdi-hc-fw"></i>Delete</a>
                            <?php endif; ?>
                        </td>`
                tr += "</tr>"
                if (statustable == 'parent') {
                    $('#mytable1 tbody').append(tr)
                } else {
                    $('#mytable2 tbody').append(tr)
                }
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable == 'parent') {
                $('#mytable1 tbody').append(tr)
            } else {
                $('#mytable2 tbody').append(tr)
            }
        }
    }

    function deleteConfirm(url) {
        $('#btn-confirmactive').attr('href', url)
        $('#deleteModal').modal()
    }

    const tooltip = document.getElementById('tbody-tooltip')
    const tbodyparent = document.getElementById('parent-tbody')
    const tbodychild = document.getElementById('child-tbody')

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

    tbodychild.addEventListener('mousemove', function (e) {
        tooltip.style.left = (e.pageX + 10) + 'px' 
        tooltip.style.top = (e.pageY + 15) + 'px'
    })

    tbodychild.addEventListener('mouseenter', function () {
        tooltip.style.display = 'block'
    })

    tbodychild.addEventListener('mouseleave', function () {
        tooltip.style.display = 'none'
    })

    $('#parent-tbody, #child-tbody').sortable({
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
                    var parent_id = ui.item.data('parent-id');
                    tbody.find('tr').each(function () {
                        if ($(this).data('parent-id') == parent_id) {
                            page_id_array.push($(this).attr('id'));
                        }
                    })

                    $.ajax({
                        url: '<?=base_url()?>menus/update_sort',
                        method: 'POST',
                        data: {
                            page_id_array: page_id_array,
                            type: $('#type_table').val(),
                            parent_id: parent_id,
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
                                    if ($('#type_table').val()==='parent') {
                                        $('#tab_1').trigger('click');
                                    } else {
                                        $('#tab_2').trigger('click');
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
</script>