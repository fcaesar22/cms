<style type="text/css">
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    td {overflow-wrap: anywhere; white-space: normal;}
    .page-link a {color: white;}
    .page-link {width: 35px; height: 35px;}
    #searchinputactive, #searchinputmain, #searchinputaddon, #searchinputcoupon, #searchinputstb, #searchinputinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonactive, #searchbuttonmain, #searchbuttonaddon, #searchbuttoncoupon, #searchbuttonstb, #searchbuttoninactive { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow_active, #selectrow_main, #selectrow_addon, #selectrow_coupon, #selectrow_stb, #selectrow_inactive { float: left; width: 7%; padding: 3.8px; color: white; font-size: 14px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Management Packages</h1>
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
                <?php if (has_permission('create_packages')): ?>
                    <a href="<?= base_url('packages/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Package</a><br>
                <?php endif; ?>

                <input type="hidden" name="sort_table" id="sort_table" value="seq">
                <input type="hidden" name="order_table" id="order_table" value="desc">
                <input type="hidden" name="status" id="status" value="active">

                <div class="tab-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a id="active_tab" class="nav-link active" data-toggle="tab" href="#activeTab" role="tab">Active</a>
                        </li>
                        <li class="nav-item">
                            <a id="main_tab" class="nav-link" data-toggle="tab" href="#mainTab" role="tab">Main</a>
                        </li>
                        <li class="nav-item">
                            <a id="addon_tab" class="nav-link" data-toggle="tab" href="#addonTab" role="tab">Add-On</a>
                        </li>
                        <li class="nav-item">
                            <a id="coupon_tab" class="nav-link" data-toggle="tab" href="#couponTab" role="tab">Voucher Coupon</a>
                        </li>
                        <li class="nav-item">
                            <a id="stb_tab" class="nav-link" data-toggle="tab" href="#stbTab" role="tab">STB Rental</a>
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
                                            <th>Affiliate</th>
                                            <th>List Price</th>
                                            <th>Sell Price</th>
                                            <th>Update Date</th>
                                            <th>Status</th>
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
                        <div class="tab-pane fade" id="mainTab" role="tabpanel">
                            <span class="invalid-feedback" id="wardingsearchmain" name="wardingsearchmain" style="display:none;">minimum 3 charachters</span>
                            <br>
                            <input type="search" placeholder="Search for title..." name="searchinputmain" id="searchinputmain" minlength="3" maxlength="50">
                            <button type="button" name="searchbuttonmain" id="searchbuttonmain" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrow_main" id="selectrow_main" class="btn btn-light">
                                <select name="rowselect_main" id="rowselect_main" style="width: 100%;">
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
                                            <th>Affiliate</th>
                                            <th>List Price</th>
                                            <th>Sell Price</th>
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
                        <div class="tab-pane fade" id="addonTab" role="tabpanel">
                            <span class="invalid-feedback" id="wardingsearchaddon" name="wardingsearchaddon" style="display:none;">minimum 3 charachters</span>
                            <br>
                            <input type="search" placeholder="Search for title..." name="searchinputaddon" id="searchinputaddon" minlength="3" maxlength="50">
                            <button type="button" name="searchbuttonaddon" id="searchbuttonaddon" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrow_addon" id="selectrow_addon" class="btn btn-light">
                                <select name="rowselect_addon" id="rowselect_addon" style="width: 100%;">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytable3" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Affiliate</th>
                                            <th>List Price</th>
                                            <th>Sell Price</th>
                                            <th>Update Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_info3" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination3'></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="couponTab" role="tabpanel">
                            <span class="invalid-feedback" id="wardingsearchcoupon" name="wardingsearchcoupon" style="display:none;">minimum 3 charachters</span>
                            <br>
                            <input type="search" placeholder="Search for title..." name="searchinputcoupon" id="searchinputcoupon" minlength="3" maxlength="50">
                            <button type="button" name="searchbuttoncoupon" id="searchbuttoncoupon" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrow_coupon" id="selectrow_coupon" class="btn btn-light">
                                <select name="rowselect_coupon" id="rowselect_coupon" style="width: 100%;">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytable4" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Affiliate</th>
                                            <th>List Price</th>
                                            <th>Sell Price</th>
                                            <th>Update Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_info4" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination4'></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="stbTab" role="tabpanel">
                            <span class="invalid-feedback" id="wardingsearchstb" name="wardingsearchstb" style="display:none;">minimum 3 charachters</span>
                            <br>
                            <input type="search" placeholder="Search for title..." name="searchinputstb" id="searchinputstb" minlength="3" maxlength="50">
                            <button type="button" name="searchbuttonstb" id="searchbuttonstb" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrow_stb" id="selectrow_stb" class="btn btn-light">
                                <select name="rowselect_stb" id="rowselect_stb" style="width: 100%;">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytable5" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Affiliate</th>
                                            <th>List Price</th>
                                            <th>Sell Price</th>
                                            <th>Update Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_info5" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination5'></div>
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
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytable6" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Affiliate</th>
                                            <th>List Price</th>
                                            <th>Sell Price</th>
                                            <th>Update Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_info6" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination6'></div>
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

<script type="text/javascript">
    $(document).ready(function () {
        activaTab('activeTab')

        $('#rowselect_active').select2()
        $('#rowselect_main').select2()
        $('#rowselect_addon').select2()
        $('#rowselect_coupon').select2()
        $('#rowselect_stb').select2()
        $('#rowselect_inactive').select2()
    })

    function activaTab(tab) {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show')
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var status = $('#status').val()
        var key_search = $('#searchinputactive').val()
        if (key_search == '') {
            key_search = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search, sort_by, order_sort, status, rowperpage, 0)
    }

    function handleTab(type) {
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        switch(type) {
            case 'active':
                var status = 'active'
                $("#mainTab").hide()
                $("#addonTab").hide()
                $("#couponTab").hide()
                $("#stbTab").hide()
                $("#inactiveTab").hide()
                $("#activeTab").show()
                break;
            case 'main':
                var status = 'main'
                $("#activeTab").hide()
                $("#addonTab").hide()
                $("#couponTab").hide()
                $("#stbTab").hide()
                $("#inactiveTab").hide()
                $("#mainTab").show()
                break;
            case 'addon':
                var status = 'addon'
                $("#activeTab").hide()
                $("#mainTab").hide()
                $("#couponTab").hide()
                $("#stbTab").hide()
                $("#inactiveTab").hide()
                $("#addonTab").show()
                break;
            case 'coupon':
                var status = 'coupon'
                $("#activeTab").hide()
                $("#mainTab").hide()
                $("#addonTab").hide()
                $("#stbTab").hide()
                $("#inactiveTab").hide()
                $("#couponTab").show()
                break;
            case 'stb':
                var status = 'stb'
                $("#activeTab").hide()
                $("#mainTab").hide()
                $("#addonTab").hide()
                $("#couponTab").hide()
                $("#inactiveTab").hide()
                $("#stbTab").show()
                break;
            case 'inactive':
                var status = 'inactive'
                $("#activeTab").hide()
                $("#mainTab").hide()
                $("#addonTab").hide()
                $("#couponTab").hide()
                $("#stbTab").hide()
                $("#inactiveTab").show()
                break;
            default:
                var status = 'active'
                $("#mainTab").hide()
                $("#addonTab").hide()
                $("#couponTab").hide()
                $("#stbTab").hide()
                $("#inactiveTab").hide()
                $("#activeTab").show()
        }
        $('#status').val(status)
        $('#searchinput' + type).val(null)
        var key_search = null
        $('#rowselect_' + type).val(10).trigger('change.select2')
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(key_search, sort_by, order_sort, status, rowperpage, 0)
    }

    $(document).on('click', '#active_tab', function () {
        handleTab('active')
    })

    $(document).on('click', '#main_tab', function () {
        handleTab('main')
    })

    $(document).on('click', '#addon_tab', function () {
        handleTab('addon')
    })

    $(document).on('click', '#coupon_tab', function () {
        handleTab('coupon')
    })

    $(document).on('click', '#stb_tab', function () {
        handleTab('stb')
    })

    $(document).on('click', '#inactive_tab', function () {
        handleTab('inactive')
    })

    function handleRowSelect(type) {
        var pageno = 0
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var status = $('#status').val()
        var key_search = $('#searchinput' + type).val() || null
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(key_search, sort_by, order_sort, status, rowperpage, pageno)
    }

    $(document).on('change', '#rowselect_active', function () {
        handleRowSelect('active')
    })

    $(document).on('change', '#rowselect_main', function () {
        handleRowSelect('main')
    })

    $(document).on('change', '#rowselect_addon', function () {
        handleRowSelect('addon')
    })

    $(document).on('change', '#rowselect_coupon', function () {
        handleRowSelect('coupon')
    })

    $(document).on('change', '#rowselect_stb', function () {
        handleRowSelect('stb')
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
        var status = $('#status').val()
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(search, sort_by, order_sort, status, rowperpage, 0)
    }

    $(document).on('click', '#searchbuttonactive', function () {
        handleSearch('active')
    })

    $(document).on('click', '#searchbuttonmain', function () {
        handleSearch('main')
    })

    $(document).on('click', '#searchbuttonaddon', function () {
        handleSearch('addon')
    })

    $(document).on('click', '#searchbuttoncoupon', function () {
        handleSearch('coupon')
    })

    $(document).on('click', '#searchbuttonstb', function () {
        handleSearch('stb')
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
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var status = $('#status').val()
            loadPagination(key_search, sort_by, order_sort, status, rowperpage, pageno)
        })
    }

    handlePaginationClick('#pagination', 'active')
    handlePaginationClick('#pagination2', 'main')
    handlePaginationClick('#pagination3', 'addon')
    handlePaginationClick('#pagination4', 'coupon')
    handlePaginationClick('#pagination5', 'stb')
    handlePaginationClick('#pagination6', 'inactive')

    function loadPagination(key_search, sort_by, order_sort, status, rowperpage, pageno) {
        $.ajax({
            url: '<?=base_url()?>packages/list_packages/'+key_search+'/'+sort_by+'/'+order_sort+'/'+status+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var order_sort = response.order
                var x = response.x
                var y = response.y
                var z = response.z
                var show = 'Showing '+x+' to '+y+' of '+z+' entries'

                switch(status) {
                    case 'active':
                        $('#data-table_info').html(show)
                        var paginationId = '#pagination'
                        break;
                    case 'main':
                        $('#data-table_info2').html(show)
                        var paginationId = '#pagination2'
                        break;
                    case 'addon':
                        $('#data-table_info3').html(show)
                        var paginationId = '#pagination3'
                        break;
                    case 'coupon':
                        $('#data-table_info4').html(show)
                        var paginationId = '#pagination4'
                        break;
                    case 'stb':
                        $('#data-table_info5').html(show)
                        var paginationId = '#pagination5'
                        break;
                    case 'inactive':
                        $('#data-table_info6').html(show)
                        var paginationId = '#pagination6'
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
        var statustable = $('#status').val()

        switch(statustable) {
            case 'active':
                var tableId = '#mytable1 tbody'
                break;
            case 'main':
                var tableId = '#mytable2 tbody'
                break;
            case 'addon':
                var tableId = '#mytable3 tbody'
                break;
            case 'coupon':
                var tableId = '#mytable4 tbody'
                break;
            case 'stb':
                var tableId = '#mytable5 tbody'
                break;
            case 'inactive':
                var tableId = '#mytable6 tbody'
                break;
            default:
                var tableId = '#mytable1 tbody'
        }

        $(tableId).empty()

        if (result.length > 0) {
            sno = Number(sno)
            for (index in result) {
                var id = result[index].seq
                var title = result[index].title
                var type = result[index].pkgtype ?? ''
                var affiliate = result[index].affiliate
                var list_price = result[index].price
                var sell_price = result[index].price2
                var update_date = result[index].update_date
                var visible = result[index].visible

                var typePackage = ''
                if (type === '0') {
                    typePackage = 'Main Package'
                } else if (type === '1') {
                    typePackage = 'Add-On Package'
                } else if (type === '2') {
                    typePackage = 'STB Rental'
                } else if (type === '3') {
                    typePackage = 'Ticket Voucher'
                }
                
                sno+=1
                var base_url ='<?php echo base_url()?>'
                var activeinactive = ""
                var statusRow = ""

                if (visible === "Y") {
                    activeinactive = "<a onclick='inactiveConfirm(\""+base_url+'packages/inactivatedPackage/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-minus-circle zmdi-hc-fw'></i>Deactivate</a>"
                    statusRow = "<button type='button' class='btn btn-outline-success' disabled>Active</button>"
                } else {
                    activeinactive = "<a onclick='activeConfirm(\""+base_url+'packages/activatedPackage/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-plus-circle zmdi-hc-fw'></i>Activate</a>"
                    statusRow = "<button type='button' class='btn btn-outline-danger' disabled>Inactive</button>"
                }

                var tr = "<tr id='"+id+"'>"
                tr += "<td>"+ sno +"</td>"
                tr += "<td>"+ title +"</td>"
                tr += "<td>"+ typePackage +"</td>"
                tr += "<td>"+ affiliate +"</td>"
                tr += "<td>"+ list_price +"</td>"
                tr += "<td>"+ sell_price +"</td>"
                tr += "<td>"+ update_date +"</td>"
                tr += "<td>"+ statusRow +"</td>"
                tr += `<td>
                            <div class='dropdown'>
                                <button class='btn btn-light' data-toggle='dropdown' aria-expanded='false'>ACTION</button>
                                <div class='dropdown-menu dropdown-menu--icon'>
                                <?php if (has_permission('edit_packages')): ?>
                                    <a href="<?= base_url('packages/edit/${id}') ?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                <?php endif; ?>
                                <?php if (has_permission('delete_packages')): ?>
                                    ${activeinactive}
                                <?php endif; ?>
                                </div>
                            </div>
                        </td>`
                tr += "</tr>"
                $(tableId).append(tr)
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="9" class="dataTables_empty">No matching records found</td></tr>`
            $(tableId).append(tr)
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
</script>