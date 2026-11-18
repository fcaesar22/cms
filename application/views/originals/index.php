<style type="text/css">
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    td {overflow-wrap: anywhere; white-space: normal;}
    .page-link a {color: white;}
    .page-link {width: 35px; height: 35px;}
    #searchinputactive, #searchinputinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonactive, #searchbuttoninactive { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow_active, #selectrow_inactive { float: left; width: 7%; padding: 3.8px; color: white; font-size: 14px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    #tbody-tooltip {position: absolute; padding: 6px 12px; background: #fff; color: #333; border-radius: 4px; font-size: 13px; font-weight: 500; box-shadow: 0 2px 6px rgba(0,0,0,0.3); pointer-events: none; white-space: nowrap; z-index: 2000; display: none;}
    #tooltipBtn {position: absolute; padding: 6px 12px; background: #fff; color: #333; border-radius: 4px; font-size: 13px; font-weight: 500; box-shadow: 0 2px 6px rgba(0,0,0,0.3); pointer-events: none; white-space: nowrap; z-index: 2000; display: none;}
    #searchinputkeywordactive, #searchinputkeywordinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 60%; color: white; background: transparent;}
    #searchbuttonkeywordactive, #searchbuttonkeywordinactive {float: left; width: 20%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrowkeywordactive, #selectrowkeywordinactive {float: left; width: 20%; padding: 5px; color: white; font-size: 12px; border: 1px solid gray; border-left: none; cursor: pointer; margin-bottom: 10px;}
    .keyword-select2-dark {background-color: #222323 !important;}
    #modal-ads .dropdown-menu {background-color: #222323;}
    select.image-picker {margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 448px;height: 55px;}
    .contacts__img>img{width: 100px;height: 100px;}
    #select option {color: black;}
    .flatpickr-calendar.animate.open{width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path{fill: white;}
    #modal-keyword-cu {z-index: 1060 !important;}
    #modal-keyword-cu .select2-container {z-index: 1065 !important;}
    #modal-keyword-cu .select2-dropdown {z-index: 1070 !important;}
    .modal-backdrop {z-index: 1040 !important;}
    #modal-imagelandscape {z-index: 1080 !important;}
    .modal-backdrop.modal-backdrop-nested {z-index: 1070 !important;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Original</h1>
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
                <?php if (has_permission('create_originals')): ?>
                    <a href="<?= base_url('originals/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Original</a>&nbsp;
                    <button name="mngAds" id="mngAds" type="button" class="btn btn-outline-success btn--icon-text" data-cat="ads" data-toggle="modal" data-target="#modal-ads"><i class="zmdi zmdi-collection-image-o zmdi-hc-fw"></i> Management Ads</button>
                <?php endif; ?>
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a id="tab_1" class="nav-link" data-toggle="tab" href="#tab1" role="tab">Active</a>
                        </li>
                        <li class="nav-item">
                            <a id="tab_2" class="nav-link" data-toggle="tab" href="#tab2" role="tab">Inactive</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active fade show" id="tab1" role="tabpanel">
                            <button name="syncall" id="syncall" type="button" class="btn btn-outline-success btn--icon-text"><i class="zmdi zmdi-refresh-sync zmdi-hc-fw"></i> Sync</button><br>
                            <input type="hidden" name="sort_table" id="sort_table" value="id">
                            <input type="hidden" name="order_table" id="order_table" value="desc">
                            <input type="hidden" name="visible" id="visible" value="Y">
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
                                            <th>Create Date</th>
                                            <th>Update Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="my-tbody" class="tableactive" style="cursor: all-scroll;">
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_info" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination'></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
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
                                            <th>Create Date</th>
                                            <th>Update Date</th>
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

<!--Active Explore Confirmation-->
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

<!--Inactive Explore Confirmation-->
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

<div class="modal fade" id="syncModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure sync?</div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-confirmsync" class="btn btn-success" href="#">Yes</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-ads" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">List Advertising</h5>
                <hr>
            </div>
            <div class="modal-body">
                <input type="hidden" name="visible_keyword" id="visible_keyword" value="Y">
                <input type="hidden" name="sort_table_keyword" id="sort_table_keyword" value="id_ads">
                <input type="hidden" name="order_table_keyword" id="order_table_keyword" value="desc">
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link tab_keyword_active active" data-toggle="tab" href="#tab_keyword_active" role="tab">Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tab_keyword_inactive" data-toggle="tab" href="#tab_keyword_inactive" role="tab">Inactive</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active fade show" id="tab_keyword_active" role="tabpanel">
                            <button class="btn btn-light" name="add_keyword" id="add_keyword">Add Advertising</button>
                            <br><br>
                            <span class="invalid-feedback" id="wardingsearchkeywordactive" name="wardingsearchkeywordactive" style="display:none;">minimum 5 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputkeywordactive" id="searchinputkeywordactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttonkeywordactive" id="searchbuttonkeywordactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrowkeywordactive" id="selectrowkeywordactive" class="btn btn-light">
                                <select name="rowselectkeywordactive" id="rowselectkeywordactive">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <br>
                            <div id="table_keyword" class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytablekeyword1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Target</th>
                                            <th>Location</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="my-tbodyads" class="tableactive">
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_keyword" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination_keyword'></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_keyword_inactive" role="tabpanel">
                            <button class="btn btn-light" name="add_keyword" id="add_keyword">Add Category</button>
                            <br><br>
                            <span class="invalid-feedback" id="wardingsearchkeywordinactive" name="wardingsearchkeywordinactive" style="display:none;">minimum 5 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputkeywordinactive" id="searchinputkeywordinactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttonkeywordinactive" id="searchbuttonkeywordinactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrowkeywordinactive" id="selectrowkeywordinactive" class="btn btn-light">
                                <select name="rowselectkeywordinactive" id="rowselectkeywordinactive">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <br>
                            <div id="table_keyword" class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytablekeyword2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Target</th>
                                            <th>Location</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_keyword2" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination_keyword2'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-keyword-cu" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Advertising</h5>
            </div>
            <div class="modal-body">
                <div id="changing-keyword">
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button id="crud_keyword" type="button" class="btn btn-outline-success">Submit</button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-imagelandscape" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Select an image</h5>
            </div>
            <div class="modal-body">
                <div class="page-loader loadimage1">
                    <div class="page-loader__spinner">
                        <svg viewBox="25 25 50 50">
                            <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                        </svg>
                    </div>
                </div>
                <div id="changing-contentimage1">
                    <select class='image-picker show-html'>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button id="uploadimagelandscape" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlLandscape()">Save</button>
                <button id="backimagelandscape" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="tbody-tooltip">Drag & drop to reorder sort section</div>

<div id="tooltipBtn">Drag & drop to reorder sort ads</div>

<script type="text/javascript">
    $(document).ready(function () {
        activaTab('tab1')

        $('#rowselect_active').select2()
        
        $('#rowselect_inactive').select2()
    })

    function activaTab(tab) {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show')
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search == '') {
            key_search = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search, sort_by, order_sort, visible, rowperpage, 0)
    }

    function handleTab(type) {
        var isActive = type === 'active'
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = isActive ? 'Y' : 'N'
        $('#visible').val(visible)
        $('#searchinput' + type).val(null)
        var key_search = null
        $('#rowselect_' + type).val(10).trigger('change.select2')
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(key_search, sort_by, order_sort, visible, rowperpage, 0)
        if (isActive) {
            $("#tab2").hide()
            $("#tab1").show()
        } else {
            $("#tab1").hide()
            $("#tab2").show()
        }
    }

    $(document).on('click', '#tab_1', function () {
        handleTab('active')
    })

    $(document).on('click', '#tab_2', function () {
        handleTab('inactive')
    })

    function handleRowSelect(type) {
        var pageno = 0
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinput' + type).val() || null
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(key_search, sort_by, order_sort, visible, rowperpage, pageno)
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
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(search, sort_by, order_sort, visible, rowperpage, 0)
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
            var isActive = type === 'active'
            var key_search = $('#searchinput' + type).val() || null
            var rowperpage = $('#rowselect_' + type).val()
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var visible = $('#visible').val()
            loadPagination(key_search, sort_by, order_sort, visible, rowperpage, pageno)
        })
    }

    handlePaginationClick('#pagination', 'active')

    handlePaginationClick('#pagination2', 'inactive')

    function loadPagination(key_search, sort_by, order_sort, visible, rowperpage, pageno) {
        $.ajax({
            url: '<?=base_url()?>originals/list_originals/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var order_sort = response.order
                var x = response.x
                var y = response.y
                var z = response.z
                var show = 'Showing '+x+' to '+y+' of '+z+' entries'
                $('#data-table_info').html(show)
                if (visible == 'Y') {
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
                    if (visible == 'Y') {
                        $('#pagination').html(page1)
                    } else {
                        $('#pagination2').html(page1)
                    }
                } else {
                    if (visible == 'Y') {
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
        var statustable = $('#visible').val()
        if (statustable == 'Y') {
            $('#mytable1 tbody').empty()
        } else {
            $('#mytable2 tbody').empty()
        }

        if (result.length > 0) {
            sno = Number(sno)
            for (index in result) {
                var id = result[index].id
                var title = result[index].title
                var visible = result[index].visible
                var create_date = result[index].create_date
                var update_date = result[index].update_date
                
                sno+=1
                var base_url ='<?php echo base_url()?>'
                var activeinactive = ""

                if (visible === "Y") {
                    activeinactive = "<a onclick='inactiveConfirm(\""+base_url+'originals/inactivated_original/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-minus-circle zmdi-hc-fw'></i>Deactivate</a>"
                } else {
                    activeinactive = "<a onclick='activeConfirm(\""+base_url+'originals/activated_original/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-plus-circle zmdi-hc-fw'></i>Activate</a>"
                }

                var tr = "<tr id='"+id+"'>"
                tr += "<td>"+ sno +"</td>"
                tr += "<td>"+ title +"</td>"
                tr += "<td>"+ create_date +"</td>"
                tr += "<td>"+ update_date +"</td>"
                tr += `<td>
                            <div class='dropdown'>
                                <button class='btn btn-light' data-toggle='dropdown' aria-expanded='false'>ACTION</button>
                                <div class='dropdown-menu dropdown-menu--icon'>
                                <?php if (has_permission('edit_originals')): ?>
                                    <a href="<?= base_url('originals/edit/${id}') ?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                <?php endif; ?>
                                <?php if (has_permission('delete_originals')): ?>
                                    ${activeinactive}
                                <?php endif; ?>
                                </div>
                            </div>
                        </td>`
                tr += "</tr>"
                if (statustable == 'Y') {
                    $('#mytable1 tbody').append(tr)
                } else {
                    $('#mytable2 tbody').append(tr)
                }
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable == 'Y') {
                $('#mytable1 tbody').append(tr)
            } else {
                $('#mytable2 tbody').append(tr)
            }
        }
    }

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

    const tbody = document.getElementById('my-tbody')
    const tooltip = document.getElementById('tbody-tooltip')

    tbody.addEventListener('mousemove', function (e) {
        tooltip.style.left = (e.pageX + 10) + 'px' 
        tooltip.style.top = (e.pageY + 15) + 'px'
    })

    tbody.addEventListener('mouseenter', function () {
        tooltip.style.display = 'block'
    })

    tbody.addEventListener('mouseleave', function () {
        tooltip.style.display = 'none'
    })

    $('#mytable1 tbody').sortable({
        placeholder : 'ui-state-highlight',
        update: function (event, ui) {
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
                    $('#mytable1 tbody tr').each(function () {
                        page_id_array.push($(this).attr('id'))
                    })

                    $.ajax({
                        url: '<?=base_url()?>originals/update_sort',
                        method: 'POST',
                        data: {
                            page_id_array: page_id_array,
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
                                    $('#tab_1').trigger('click');
                                } else {
                                    $('#mytable1 tbody').sortable('cancel')
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
                                    $('#mytable1 tbody').sortable('cancel')
                                }
                            })
                        },
                    })
                }
            }).catch(function () {
                $('#mytable1 tbody').sortable('cancel')
            })
        }
    })

    $("#syncall").click(function () {
        $('#syncModal').modal()
    })

    $("#btn-confirmsync").click(function () {
        $.ajax({
            url: "<?=base_url()?>originals/sync_all",
            method: "POST",
            data: {},
            success: function () {
                location.reload()
            }
        })
    })

    // management ads
    $("#mngAds").click(function () {
        $(".tab_keyword_active").trigger('click')
    })

    function handleKeywordTab(type) {
        var tableId = type === 'active' ? '#mytablekeyword1' : '#mytablekeyword2'
        var tabShow = type === 'active' ? '#tab_keyword_active' : '#tab_keyword_inactive'
        var tabHide = type === 'active' ? '#tab_keyword_inactive' : '#tab_keyword_active'
        $(tableId + ' tbody').empty()
        var visible = type === 'active' ? 'Y' : 'N'
        $('#visible_keyword').val(visible)
        var sort_by = $('#sort_table_keyword').val()
        var order_sort = $('#order_table_keyword').val()
        $('#rowselectkeyword' + type).val(10).trigger('change.select2')
        var rowperpage = $('#rowselectkeyword' + type).val()
        sortPaginationKeyword(null, sort_by, order_sort, visible, rowperpage, 0)
        $(tabHide).hide()
        $(tabShow).show()
    }

    $(document).on('click', '.tab_keyword_active', function () {
        handleKeywordTab('active')
    })

    $(document).on('click', '.tab_keyword_inactive', function () {
        handleKeywordTab('inactive')
    })

    $('#rowselectkeywordactive').select2({
        minimumResultsForSearch: Infinity,
        width: '100%',
        dropdownParent: $('#modal-ads'),
        dropdownCssClass: 'keyword-select2-dark'
    })

    $('#rowselectkeywordinactive').select2({
        minimumResultsForSearch: Infinity,
        width: '100%',
        dropdownParent: $('#modal-ads'),
        dropdownCssClass: 'keyword-select2-dark'
    })

    function handleRowSelectKeyword(type) {
        var pageno = 0
        var sort_by = $('#sort_table_keyword').val()
        var order_sort = $('#order_table_keyword').val()
        var visible = $('#visible_keyword').val()
        var key_search = $('#searchinputkeyword' + type).val() || null
        var rowperpage = $('#rowselectkeyword' + type).val()
        sortPaginationKeyword(key_search, sort_by, order_sort, visible, rowperpage, pageno)
    }

    $(document).on('change', '#rowselectkeywordactive', function () {
        handleRowSelectKeyword('active')
    })

    $(document).on('change', '#rowselectkeywordinactive', function () {
        handleRowSelectKeyword('inactive')
    })

    function handlePaginationKeywordClick(paginationSelector, type) {
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
            var isActive = type === 'active'
            var visible = $('#visible_keyword').val()
            var sort_by = $('#sort_table_keyword').val()
            var order_sort = $('#order_table_keyword').val()
            var key_search = $('#searchinputkeyword' + type).val() || null
            var rowperpage = $('#rowselectkeyword' + type).val()
            sortPaginationKeyword(key_search, sort_by, order_sort, visible, rowperpage, pageno)
        })
    }

    handlePaginationKeywordClick('#pagination_keyword', 'active')

    handlePaginationKeywordClick('#pagination_keyword2', 'inactive')

    function handleSearchKeyword(type) {
        var search = $('#searchinputkeyword' + type).val()
        if (!search || search.length < 3) {
            $('#wardingsearchkeyword' + type).show()
            setTimeout(function () {
                $('#wardingsearchkeyword' + type).hide()
            }, 5000)
            return
        }
        var sort_by = $('#sort_table_keyword').val()
        var order_sort = $('#order_table_keyword').val()
        var visible = $('#visible_keyword').val()
        var rowperpage = $('#rowselectkeyword' + type).val()
        sortPaginationKeyword(search, sort_by, order_sort, visible, rowperpage, 0)
    }

    $(document).on('click', '#searchbuttonkeywordactive', function () {
        handleSearchKeyword('active')
    })

    $(document).on('click', '#searchbuttonkeywordinactive', function () {
        handleSearchKeyword('inactive')
    })

    function sortPaginationKeyword(key_search, sort_by, order_sort, visible, rowperpage, pageno){
        var statustable = $('#visible_keyword').val()
        $.ajax({
            url: '<?=base_url()?>originals/listAds/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var order_sort = response.order
                var x = response.x
                var y = response.y
                var z = response.z
                var show = 'Showing '+x+' to '+y+' of '+z+' entries'
                $('#data-table_keyword').html(show)
                if (statustable == 'Y') {
                    $('#data-table_keyword').html(show)
                } else {
                    $('#data-table_keyword2').html(show)
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
                    if (statustable == 'Y') {
                        $('#pagination_keyword').html(page1)
                    } else {
                        $('#pagination_keyword2').html(page1)
                    }
                } else {
                    if (statustable == 'Y') {
                        $('#pagination_keyword').html(response.pagination)
                    } else {
                        $('#pagination_keyword2').html(response.pagination)
                    }
                }
                createTableKeyword(response.result, response.row)
            }
        })
    }

    function createTableKeyword(result, sno) {
        var statustable = $('#visible_keyword').val()

        if (statustable == 'Y') {
            $tbody = $('#mytablekeyword1 tbody')
            $('#mytablekeyword1 tbody').empty()
            $('#mytablekeyword1 tbody').css('cursor', 'all-scroll')
        } else {
            $tbody = $('#mytablekeyword2 tbody')
            $('#mytablekeyword2 tbody').empty()
            $('#mytablekeyword2 tbody').css('cursor', 'default')
        }

        if (result.length > 0) {
            sno = Number(sno)
            for (index in result) {
                var id = result[index].id_ads
                var title = result[index].title
                var image_url = result[index].image_url
                var target = result[index].target
                var location = result[index].location
                var visible = result[index].visible
                var startDate = result[index].start_date
                var endDate = result[index].end_date
                var htmlimage = '<img id="myImg" src="assets/img/defaultuploadimage.png" alt="" width="60" height="60">'
                if (image_url !== null) {
                    var htmlimage = '<img id="myImg" src="' + image_url + '" alt="" width="170" height="25">'
                }
                sno+=1
                var base_url = '<?php echo base_url() ?>'

                var html = result[index].visible == "N" 
                    ? `<a onclick="confirmKeywordAction('${id}', 'activate')" href="#!" class="dropdown-item">
                         <i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate
                       </a>`
                    : `<a onclick="confirmKeywordAction('${id}', 'deactivate')" href="#!" class="dropdown-item">
                         <i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate
                       </a>`
                
                var tr = "<tr id='"+id+"'>"
                tr += "<td>"+ sno +"</td>"
                tr += "<td>"+ htmlimage +"</td>"
                tr += "<td>"+ title +"</td>"
                tr += "<td>"+ target +"</td>"
                tr += "<td>"+ location +"</td>"
                tr += "<td>"+ startDate +"</td>"
                tr += "<td>"+ endDate +"</td>"
                tr += "<td><div class='dropdown'><button class='btn btn-light dropdown-toggle' data-toggle='dropdown'>ACTION</button><div class='dropdown-menu dropdown-menu--icon'>"+ html + "<a href='#!' onclick='edit_keyword(\""+id+"\")' class='dropdown-item'><i class='zmdi zmdi-edit zmdi-hc-fw'></i>Edit</a></div></div></td>"
                tr += "</tr>"
                
                if (statustable == 'Y') {
                    $('#mytablekeyword1 tbody').append(tr)
                } else {
                    $('#mytablekeyword2 tbody').append(tr)
                }
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No matching records found</td></tr>`
            
            if (statustable == 'Y') {
                $('#mytablekeyword1 tbody').append(tr)
            } else {
                $('#mytablekeyword2 tbody').append(tr)
            }
        }

        if (statustable == 'Y') {
            if (!$tbody.hasClass('ui-sortable')) {
                $tbody.sortable({
                    placeholder : 'ui-state-highlight',
                    update: function (event, ui) {
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
                                var page_id_array_ads = new Array()
                                $('#mytablekeyword1 tbody tr').each(function () {
                                    page_id_array_ads.push($(this).attr('id'))
                                })

                                $.ajax({
                                    url: '<?=base_url()?>originals/updateSortAds',
                                    method: 'POST',
                                    data: {
                                        page_id_array: page_id_array_ads,
                                        action: 'update'
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
                                                $('.tab_keyword_active').trigger('click')
                                            } else {
                                                $tbody.sortable('cancel')
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
                                                $tbody.sortable('cancel')
                                            }
                                        })
                                    },
                                })
                            }
                        }).catch(function () {
                            $tbody.sortable('cancel')
                        })
                    }
                })
            }
        } else {
            if ($tbody.hasClass('ui-sortable')) {
                $tbody.sortable('destroy')
            }
        }
    }

    const tbodyads = document.getElementById('my-tbodyads')
    const tooltipads = document.getElementById('tooltipBtn')

    tbodyads.addEventListener('mousemove', function (e) {
        tooltipads.style.left = (e.pageX + 10) + 'px' 
        tooltipads.style.top = (e.pageY + 15) + 'px'
    })

    tbodyads.addEventListener('mouseenter', function () {
        tooltipads.style.display = 'block'
    })

    tbodyads.addEventListener('mouseleave', function () {
        tooltipads.style.display = 'none'
    })

    function confirmKeywordAction(id, action) {
        const settings = {
            activate: {
                url: '<?=base_url()?>originals/activate_ads',
                confirmText: 'Activate',
                confirmClass: 'btn btn-success',
                tabSelector: '.tab_keyword_active',
            },
            deactivate: {
                url: '<?=base_url()?>originals/inactivate_ads',
                confirmText: 'Deactivate',
                confirmClass: 'btn btn-danger',
                tabSelector: '.tab_keyword_inactive',
            }
        }
        const config = settings[action]
        if (!config) {
            return
        }
        swal({
            title: 'Are you sure?',
            type: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonClass: config.confirmClass,
            confirmButtonText: config.confirmText,
            cancelButtonClass: 'btn btn-light',
            background: '#222323',
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then(function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: config.url,
                    type: 'post',
                    data: {id: id},
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
                                $(config.tabSelector).trigger('click')
                            }
                        })
                    },
                    error: function() {
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
                    },
                })
            }
        })
    }

    $(document).on("click", "#add_keyword", (function (e) {
        e.preventDefault()
        var html = `<form action="#" method="post" id="form_crud_keyword" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Image (*required)</label>
                                    <div class="contacts__item">
                                        <a class="contacts__img">
                                            <img id="img_landscape1" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                        </a>
                                        <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-imagelandscape">Upload</a>
                                        <input name="imgAdsUrl" id="imgAdsUrl" type="hidden" class="form-control" value="">
                                        <br><span id="file1_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title (*required)</label>
                                    <input name="titleAds" id="titleAds" type="text" class="form-control" placeholder="Please Input Keyword Name" value="" required>
                                    <span id="title_val" name="title_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Target</label>
                                    <select class="form-control" name="target" id="target" required>
                                        <option value="_self">Self</option>
                                        <option value="_blank">Blank</option>
                                    </select>
                                    <span id="target_val" class="notify" style="color: red"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input class="form-control" type="text" name="location" id="location" placeholder="Location">
                                    <span id="location_val" class="notify" style="color: red"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type Content</label>
                                    <select class="form-control" name="type_content" id="type_content" required>
                                        <option value="">No Selected</option>
                                        <option value="external">External</option>
                                        <option value="tv">TV</option>
                                        <option value="vod">VOD</option>
                                    </select>
                                    <span id="type_val" class="notify" style="color: red"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Content ID</label>
                                    <input class="form-control" type="text" name="content_id" id="content_id" placeholder="Content ID">
                                    <span id="contentid_val" class="notify" style="color: red"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="datetimepicker">Start Date (*required)</label><span id="startdate_val" class="notify" style="color: red"></span>
                                    <div class='input-group date'>
                                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                        <input type="text" id="start_date" name="start_date" placeholder="Pick a date & time" class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="datetimepicker">End Date (*required)</label><span id="enddate_val" class="notify" style="color: red"></span>
                                    <div class='input-group date'>
                                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                        <input type="text" id="end_date" name="end_date" placeholder="Pick a date & time" class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id_ads_form" id="id_ads_form" value="">
                        </div>`
        $('#changing-keyword').html(html)

        setupKeywordSelect2()

        $('#modal-keyword-cu').modal('show')
    }))

    function edit_keyword(id) {
        var html = `<form action="#" method="post" id="form_crud_keyword" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Image (*required)</label>
                                    <div class="contacts__item">
                                        <a class="contacts__img">
                                            <img id="img_landscape1" name="img_landscape1" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                        </a>
                                        <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-imagelandscape">Upload</a>
                                        <input name="imgAdsUrl" id="imgAdsUrl" type="hidden" class="form-control" value="">
                                        <br><span id="file1_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title (*required)</label>
                                    <input name="titleAds" id="titleAds" type="text" class="form-control" placeholder="Please Input Keyword Name" value="" required>
                                    <span id="title_val" name="title_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Target</label>
                                    <select class="form-control" name="target" id="target" required>
                                        <option value="_self">Self</option>
                                        <option value="_blank">Blank</option>
                                    </select>
                                    <span id="target_val" class="notify" style="color: red"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input class="form-control" type="text" name="location" id="location" placeholder="Location">
                                    <span id="location_val" class="notify" style="color: red"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type Content</label>
                                    <select class="form-control" name="type_content" id="type_content" required>
                                        <option value="">No Selected</option>
                                        <option value="external">External</option>
                                        <option value="tv">TV</option>
                                        <option value="vod">VOD</option>
                                    </select>
                                    <span id="type_val" class="notify" style="color: red"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Content ID</label>
                                    <input class="form-control" type="text" name="content_id" id="content_id" placeholder="Content ID">
                                    <span id="contentid_val" class="notify" style="color: red"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="datetimepicker">Start Date (*required)</label><span id="startdate_val" class="notify" style="color: red"></span>
                                    <div class='input-group date'>
                                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                        <input type="text" id="start_date" name="start_date" placeholder="Pick a date & time" class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="datetimepicker">End Date (*required)</label><span id="enddate_val" class="notify" style="color: red"></span>
                                    <div class='input-group date'>
                                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                        <input type="text" id="end_date" name="end_date" placeholder="Pick a date & time" class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id_ads_form" id="id_ads_form" value="${id}">
                        </div>`
        $('#changing-keyword').html(html)

        $.ajax({
            url: "<?php echo site_url('originals/get_data_edit_ads') ?>",
            method: "POST",
            data: {id:id},
            async : true,
            dataType: 'json',
            success: function (data) {
                $('#form_crud_keyword [name="img_landscape1"]').attr('src', data[0]['image_url'])
                $('#form_crud_keyword [name="imgAdsUrl"]').val(data[0]['image_url']).trigger('change')
                $('#form_crud_keyword [name="titleAds"]').val(data[0]['title']).trigger('change')
                $('#form_crud_keyword [name="target"]').val(data[0]['target']).trigger('change')
                $('#form_crud_keyword [name="location"]').val(data[0]['location']).trigger('change')
                $('#form_crud_keyword [name="type_content"]').val(data[0]['type_content']).trigger('change')
                $('#form_crud_keyword [name="content_id"]').val(data[0]['content_id']).trigger('change')
                $('#form_crud_keyword [name="start_date"]').val(data[0]['start_date']).trigger('change')
                $('#form_crud_keyword [name="end_date"]').val(data[0]['end_date']).trigger('change')
            }
        })

        setupKeywordSelect2()

        $('#modal-keyword-cu').modal('show')
    }

    function setupKeywordSelect2() {
        const $modal = $('#modal-keyword-cu');

        ['#target', '#type_content'].forEach(function (selector) {
            const $el = $modal.find(selector);

            // Hancurkan instance lama sebelum form digunakan kembali
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }

            $el.select2({
                width: '100%',
                minimumResultsForSearch: Infinity,
                dropdownParent: $modal,
                dropdownCssClass: 'keyword-select2-dark',
                closeOnSelect: true
            });
        });

        $(function () {
            $("#start_date").flatpickr({
                enableTime: true,
                time_24hr: true,
                enableSeconds: true,
                minuteIncrement: 1,
                dateFormat: "Y-m-d H:i:S",
                allowInput: false,
            })

            $("#end_date").flatpickr({
                enableTime: true,
                time_24hr: true,
                enableSeconds: true,
                minuteIncrement: 1,
                dateFormat: "Y-m-d H:i:S",
                allowInput: false,
            })
        })

        // image landscape
        $("select").imagepicker()

        $('.callfunction').click(function () {
            $(".loadimage1").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>originals/compare_image_landscape',
                success: function (data) {
                    data = JSON.parse(data)
                    var _gallery = "<select class='image-picker show-html'>"
                    if (data.error == 0) {
                        var content = data.content
                        if (content != null) {
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1)
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>"
                            }
                        }
                    }
                    _gallery = _gallery+"</select>"
                    setTimeout(function () {
                        $(".loadimage1").fadeOut()
                    }, 500)
                    $('#changing-contentimage1').html(_gallery)
                    $("select").imagepicker()
                }
            })
        })

        $('#uploadimagelandscape').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>originals/get_token',
                success: function (data) {
                    $('#changing-contentimage1')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=1008&h=300&pw=336&ph=100&token='+data+'&thumb=50&CH=banner_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>')
                }
            })
        })

        $('#backimagelandscape').click(function () {
            $(".loadimage1").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>originals/compare_image_landscape',
                success: function (data) {
                    data = JSON.parse(data)
                    var _gallery = "<select class='image-picker show-html'>"
                    if (data.error == 0) {
                        var content = data.content
                        if (content != null) {
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1)
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>"
                            }
                        }
                    }
                    _gallery = _gallery+"</select>"
                    setTimeout(function () {
                        $(".loadimage1").fadeOut()
                    }, 500)
                    $('#changing-contentimage1').html(_gallery)
                    $("select").imagepicker()
                }
            })
        })
        // image landscape
    }

    function getUrlLandscape() {
        var image = $('#modal-imagelandscape .image_picker_selector').find('.selected').find('img').attr('src')
        $('#imgAdsUrl').val(image)
        $('#img_landscape1').attr('src',image)
        $('#modal-imagelandscape').modal('hide')
    }

    $('#modal-imagelandscape').on('hidden.bs.modal', function () {
        if ($('#modal-keyword-cu').hasClass('show')) {
            $('body').addClass('modal-open');

            $('#modal-keyword-cu').css({
                'overflow-y': 'auto'
            });

            if ($('.modal-backdrop').length === 0) {
                $('<div class="modal-backdrop fade show"></div>')
                    .appendTo(document.body);
            }
        }
    });

    $('#modal-keyword-cu').on('hidden.bs.modal', function () {
        if ($('#modal-ads').hasClass('show')) {
            $('body').addClass('modal-open');

            $('#modal-ads').css({
                'overflow-y': 'auto'
            });

            if ($('.modal-backdrop').length === 0) {
                $('<div class="modal-backdrop fade show"></div>')
                    .appendTo(document.body);
            }
        }
    });

    $("#crud_keyword").click(function () {
        var self = $('#form_crud_keyword')
        var title_res = $(self).find('#titleAds').val()
        var title_res = $(self).find('#titleAds').val()
        if (title_res == '' || title_res == null) {
            $('#title_val').text('* Please input title')
            $('#title_val').show()
        } else {
            $("#title_val").hide()
        }
        if (title_res != '') {
            $('#crud_keyword').text('Submit...')
            $('#crud_keyword').attr('disabled', true)
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
                    $.ajax({
                        url: '<?php echo site_url("originals/cu_ads") ?>',
                        type: 'post',
                        data: $('#form_crud_keyword').serialize(),
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
                                    $('#crud_keyword').text('Submit')
                                    $('#crud_keyword').attr('disabled', false)
                                    $('#modal-keyword-cu').modal('hide')
                                    $(".tab_keyword_active").trigger('click')
                                } else {
                                    $('#crud_keyword').text('Submit')
                                    $('#crud_keyword').attr('disabled', false)
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
                                if (ok && response.error === '0') {
                                    $('#crud_keyword').text('Submit')
                                    $('#crud_keyword').attr('disabled', false)
                                }
                            })
                        },
                    })
                }
            })
        }
    })
    // management ads
</script>