<style type="text/css">
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    .page-link a {color: white;}
    #searchinputactive, #searchinputinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonactive, #searchbuttoninactive { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow_active, #selectrow_inactive { float: left; width: 7%; padding: 3.8px; color: white; font-size: 14px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    span.icon-lifestyle {background-image: url("<?=base_url()?>assets/img/iconlifestyle.png");}
    span.icon-lifestyle {float: left; width: 24px; height: 24px; margin-right: 10px; background-repeat: no-repeat; background-position: center center; background-size: 100%;}
    .bg_btnlifestyle {background: #EB5757; background: -webkit-linear-gradient(to right, #000000, #EB5757); background: linear-gradient(to right, #000000, #EB5757); color: white; width: 150px; border: 0px solid transparent; margin-right: 5px; cursor: pointer;}
    .bg_btnlifestyle:hover {background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.40) 120%) #989898; border: 0px solid transparent;}
    span.icon-knowledge {background-image: url("<?=base_url()?>assets/img/iconknowledge.png");}
    span.icon-knowledge {float: left; width: 24px; height: 24px; margin-right: 10px; background-repeat: no-repeat; background-position: center center; background-size: 100%;}
    .bg_btnknowledge {background: #2C3E50; background: -webkit-linear-gradient(to right, #2C3E50, #4CA1AF); background: linear-gradient(to right, #2C3E50, #4CA1AF); color: white; width: 150px; border: 0px solid transparent; margin-right: 5px; cursor: pointer;}
    .bg_btnknowledge:hover {background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.40) 120%) #989898; border: 0px solid transparent;}
    span.icon-esportarena {background-image: url("<?=base_url()?>assets/img/icondensplay.png");}
    span.icon-esportarena {float: left; width: 24px; height: 24px; margin-right: 10px; background-repeat: no-repeat; background-position: center center; background-size: 100%;}
    .bg_esportarena {background: #00bf8f; background: -webkit-linear-gradient(to right, #001510, #00bf8f); background: linear-gradient(to right, #001510, #00bf8f); color: white; width: 150px; border: 0px solid transparent; margin-right: 5px; cursor: pointer;}
    .bg_esportarena:hover {background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.40) 120%) #989898; border: 0px solid transparent;}
    span.icon-sportmania {background-image: url("<?=base_url()?>assets/img/icon_sportmania.png");}
    span.icon-sportmania {float: left; width: 24px; height: 24px; margin-right: 10px; background-repeat: no-repeat; background-position: center center; background-size: 100%;}
    .bg_sportmania {background: #603813; background: -webkit-linear-gradient(to right, #603813, #b29f94); background: linear-gradient(to right, #603813, #b29f94); color: white; width: 150px; border: 0px solid transparent; margin-right: 5px; cursor: pointer;}
    .bg_sportmania:hover {background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.40) 120%) #989898; border: 0px solid transparent;}
    span.icon-shortmovie {background-image: url("<?=base_url()?>assets/img/icon_shortmovie.png");}
    span.icon-shortmovie {float: left; width: 24px; height: 24px; margin-right: 10px; background-repeat: no-repeat; background-position: center center; background-size: 100%;}
    .bg_shortmovie {background: #000000; background: -webkit-linear-gradient(to right, #000000, #434343); background: linear-gradient(to right, #000000, #434343); color: white; width: 150px; border: 0px solid transparent; margin-right: 5px; cursor: pointer;}
    .bg_shortmovie:hover {background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.40) 120%) #989898; border: 0px solid transparent;}
    .whtl1 .btn-link{color: white !important; font-weight: 600; cursor: pointer;}
    .whtl2 .btn-link{color: white !important; font-weight: 600; cursor: pointer;}
    .whid1 .btn-link{color: white !important; font-weight: 600; cursor: pointer;}
    .whid2 .btn-link{color: white !important; font-weight: 600; cursor: pointer;}
    .modal-footer {justify-content: center;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Social TV</h1>
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
                <?php if (has_permission('create_socialtvs')): ?>
                    <a href="<?= base_url('social_tvs/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Social TV</a>
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
                            <input type="hidden" name="sort_table" id="sort_table" value="socialtv_id">
                            <input type="hidden" name="order_table" id="order_table" value="desc">
                            <input type="hidden" name="visible" id="visible" value="Y">
                            <input type="hidden" name="contentid" id="contentid" value="246">
                            <button class="btn bg_btnlifestyle" onclick="myFunction('246')"><span class="icon icon-lifestyle"></span>DensLife & Style</button>
                            <button class="btn bg_btnknowledge" onclick="myFunction('325')"><span class="icon icon-knowledge"></span>DensKnowledge</button>
                            <button class="btn bg_esportarena" onclick="myFunction('247')"><span class="icon icon-esportarena"></span>DensPlay</button>
                            <button class="btn bg_sportmania" onclick="myFunction('1076')"><span class="icon icon-sportmania"></span>DensSportMania</button>
                            <button class="btn bg_shortmovie" onclick="myFunction('1077')"><span class="icon icon-shortmovie"></span>DensShortMovie</button>
                            <br><br>
                            <h6 id="title_active" class="card-title" align="center">DensLife & Style</h6>
                            <span class="invalid-feedback" id="wardingsearchactive" name="wardingsearchactive" style="display:none;">minimum 3 charachters</span>
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
                                            <th class="whid1">No.</th>
                                            <th class="whtl1">Title</th>
                                            <th>Category</th>
                                            <th>Image</th>
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
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <button class="btn bg_btnlifestyle" onclick="myFunction('246')"><span class="icon icon-lifestyle"></span>DensLife & Style</button>
                            <button class="btn bg_btnknowledge" onclick="myFunction('325')"><span class="icon icon-knowledge"></span>DensKnowledge</button>
                            <button class="btn bg_esportarena" onclick="myFunction('247')"><span class="icon icon-esportarena"></span>DensPlay</button>
                            <button class="btn bg_sportmania" onclick="myFunction('1076')"><span class="icon icon-sportmania"></span>DensSportMania</button>
                            <button class="btn bg_shortmovie" onclick="myFunction('1077')"><span class="icon icon-shortmovie"></span>DensShortMovie</button>
                            <br><br>
                            <h6 id="title_inactive" class="card-title" align="center">DensLife & Style</h6>
                            <span class="invalid-feedback" id="wardingsearchinactive" name="wardingsearchinactive" style="display:none;">minimum 3 charachters</span>
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
                                            <th class="whid2">No.</th>
                                            <th class="whtl2">Title</th>
                                            <th>Category</th>
                                            <th>Image</th>
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

<!--Active Social TV Confirmation-->
<div class="modal fade" id="activeSocialTVModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-confirmactive" class="btn btn-success" href="#">Yes</a>
            </div>
        </div>
    </div>
</div>

<!--Inactive Social TV Confirmation-->
<div class="modal fade" id="inactiveSocialTVModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-confirminactive" class="btn btn-danger" href="#">Yes</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        activaTab('tab1');

        $('#rowselect_active').select2()

        $('#rowselect_inactive').select2()
    })

    let skipRowChange = false;

    function activaTab(tab) {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#contentid').val()
        $('#rowselect_active').select2()
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
    };

    $("#tab_1").click(function() {
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        $('#visible').val('Y')
        var visible = $('#visible').val()
        $('#searchinputactive').val(null)
        var key_search = null
        var category = $('#contentid').val('246')
        var category = $('#contentid').val()
        $("#title_active").text("DensLife & Style")
        skipRowChange = true;
        $('#rowselect_active').val(10).trigger('change');
        skipRowChange = false;
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
        $("#tab2").hide();
        $("#tab1").show();
    });

    $("#tab_2").click(function() {
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        $('#visible').val('N')
        var visible = $('#visible').val()
        $('#searchinputinactive').val(null)
        var key_search = null
        var category = $('#contentid').val('246')
        var category = $('#contentid').val()
        $("#title_inactive").text("DensLife & Style")
        skipRowChange = true;
        $('#rowselect_inactive').val(10).trigger('change');
        skipRowChange = false;
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
        $("#tab1").hide();
        $("#tab2").show();
    });

    $(document).on("change","#rowselect_active",function (e) {
        if (skipRowChange) return;
        var pageno = 0
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#contentid').val()
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
    });

    $(document).on("change","#rowselect_inactive",function (e) {
        if (skipRowChange) return;
        var pageno = 0
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputinactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#contentid').val()
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
    });

    $("#searchbuttonactive").click(function() {
        var search =  $("#searchinputactive").val();
        var length = search.length
        if (length < 3) {
            $("#wardingsearchactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchactive').css("display", "none");
            }, 5000)
        } else {
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var visible = $('#visible').val()
            var category = $('#contentid').val()
            skipRowChange = true;
            $('#rowselect_active').val(10).trigger('change');
            skipRowChange = false;
            var rowperpage = $('#rowselect_active').val()
            loadPagination(search,sort_by,order_sort,visible,category,rowperpage,0);
        }
    });

    $('#pagination').on('click','a',function(e) {
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#contentid').val()
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
    });

    $('#pagination').on('click','.page-link',function(e) {
        e.preventDefault(); 
        var pageno = e.currentTarget.firstElementChild.attributes[1].nodeValue
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#contentid').val()
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
    });

    $("#searchbuttonacinactive").click(function() {
        var search =  $("#searchinputinactive").val();
        var length = search.length
        if (length < 3) {
            $("#wardingsearchinactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchinactive').css("display", "none");
            }, 5000)
        } else {
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var visible = $('#visible').val()
            var category = $('#contentid').val()
            skipRowChange = true;
            $('#rowselect_inactive').val(10).trigger('change');
            skipRowChange = false;
            var rowperpage = $('#rowselect_inactive').val()
            loadPagination(search,sort_by,order_sort,visible,category,rowperpage,0);
        }
    });

    $('#pagination2').on('click','a',function(e) {
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#contentid').val()
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
    });

    $('#pagination2').on('click','.page-link',function(e) {
        e.preventDefault(); 
        var pageno = e.currentTarget.firstElementChild.attributes[1].nodeValue
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#contentid').val()
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
    });

    function myFunction(id_btn) {
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        if (visible == 'Y') {
            skipRowChange = true;
            $('#rowselect_active').val(10).trigger('change');
            skipRowChange = false;
            var key_search = $('#searchinputactive').val()
            var rowperpage = $('#rowselect_active').val()
            var title = '#title_active'
        } else {
            skipRowChange = true;
            $('#rowselect_active').val(10).trigger('change');
            skipRowChange = false;
            var key_search = $('#searchinputinactive').val()
            var rowperpage = $('#rowselect_inactive').val()
            var title = '#title_inactive'
        }
        if (key_search=='') {
            key_search = null
        }
        switch (id_btn) {
            case "246":
                var category = $('#contentid').val('246')
                $(title).text("DensLife & Style")
                break;
            case "325":
                var category = $('#contentid').val('325')
                $(title).text("DensKnowledge")
                break;
            case "247":
                var category = $('#contentid').val('247')
                $(title).text("DensPlay")
                break;
            case "1076":
                var category = $('#contentid').val('1076')
                $(title).text("DensSportMania")
                break;
            case "1077":
                var category = $('#contentid').val('1077')
                $(title).text("DensShortMovie")
                break;
        }
        var category = $('#contentid').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
    }

    function sort_active(key_search,category,visible,sort_by,order_sort,pagno) {
        if (order_sort == 'asc') {
            var order_sort = 'desc'
        } else {
            var order_sort = 'asc'
        }
        $('#sort_table').val(sort_by)
        $('#order_table').val(order_sort)
        sort_by = $('#sort_table').val()
        order_sort = $('#order_table').val()
        
        var tab_status = $('.nav-item .active').attr('id')
        if (tab_status=='tab_1') {
            visible = 'Y'
            skipRowChange = true;
            $('#rowselect_active').val(10).trigger('change');
            skipRowChange = false;
            var rowperpage = $('#rowselect_active').val()
        } else {
            visible = 'N'
            skipRowChange = true;
            $('#rowselect_active').val(10).trigger('change');
            skipRowChange = false;
            var rowperpage = $('#rowselect_inactive').val()
        }
        var key_search = $('#searchinputactive').val()
        if (key_search==''||key_search==null||key_search==undefined) {
            key_search = null
        }
        var category = $('#contentid').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0)
    }

    function loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno) {
        $.ajax({
            url: '<?=base_url()?>social_tvs/list_social_tv/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+category+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var order_sort = response.order;
                var x = response.x;
                var y = response.y;
                var z = response.z;
                var show = 'Showing '+x+' to '+y+' of '+z+' entries';
                $('#data-table_info').html(show);
                if (visible=='Y') {
                    $('#data-table_info').html(show);
                } else {
                    $('#data-table_info2').html(show);
                }
                if (response.pagination=="") {
                    var page1 = `<div class="pagging text-center">
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item active">
                                                <span class="page-link">1<span class="sr-only">(current)</span></span>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>`
                    if (visible=='Y') {
                        $('#pagination').html(page1);
                    } else {
                        $('#pagination2').html(page1);
                    }
                } else {
                    if (visible=='Y') {
                        $('.whid1').html('<input type="button" class="btn btn-link" value="No." onClick="sort_active(\''+key_search+'\',\''+category+'\',\''+visible+'\',\'socialtv_id\',\''+order_sort+'\','+pageno+')" />')
                        $('.whtl1').html('<input type="button" class="btn btn-link" value="Social TV Title" onClick="sort_active(\''+key_search+'\',\''+category+'\',\''+visible+'\',\'socialtv_name\',\''+order_sort+'\','+pageno+')" />')
                        $('#pagination').html(response.pagination);
                    } else {
                        $('.whid2').html('<input type="button" class="btn btn-link" value="No." onClick="sort_active(\''+key_search+'\',\''+category+'\',\''+visible+'\',\'socialtv_id\',\''+order_sort+'\','+pageno+')" />')
                        $('.whtl2').html('<input type="button" class="btn btn-link" value="Social TV Title" onClick="sort_active(\''+key_search+'\',\''+category+'\',\''+visible+'\',\'socialtv_name\',\''+order_sort+'\','+pageno+')" />')
                        $('#pagination2').html(response.pagination);
                    }
                }
                createTable(response.result,response.row);
            }
        });
    }

    function createTable(result,sno) {
        var statustable = $('#visible').val()
        if (statustable=='Y') {
            $('#mytable1 tbody').empty();
        } else {
            $('#mytable2 tbody').empty();
        }
        if (result.length > 0) {
            sno = Number(sno);
            for(index in result){
                var id = result[index].socialtv_id;
                var title = result[index].socialtv_name;
                var categories = result[index].categories;
                var image = result[index].poster_url;
                var status = result[index].visible;
                var htmlimage = '<img id="myImg" src="' + image + '" alt="" width="128" height="72">'
                sno+=1;
                var base_url ='<?php echo base_url()?>'
                var activeinactive = ""
                if (status == 'Y') {
                    var activeinactive = "<a onclick='inactiveConfirm(\""+base_url+'social_tvs/inactivated_social_tv/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-minus-circle zmdi-hc-fw'></i>Deactivate Social TV</a>";
                } else {
                    var activeinactive = "<a onclick='activeConfirm(\""+base_url+'social_tvs/activated_social_tv/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-plus-circle zmdi-hc-fw'></i>Activate Social TV</a>";
                }
                var tr = "<tr id='"+id+"'>";
                tr += "<td>"+ sno +"</td>";
                tr += "<td>"+ title +"</td>";
                tr += "<td>"+ categories +"</td>";
                tr += "<td>"+ htmlimage +"</td>";
                tr += `<td>
                            <div class='dropdown'>
                                <button class='btn btn-light' data-toggle='dropdown' aria-expanded='false'>ACTION</button>
                                <div class='dropdown-menu dropdown-menu--icon'>
                                <?php if (has_permission('edit_socialtvs')): ?>
                                    <a href="<?= base_url('social_tvs/edit/${id}') ?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                <?php endif; ?>
                                <?php if (has_permission('delete_socialtvs')): ?>
                                    ${activeinactive}
                                <?php endif; ?>
                                </div>
                            </div>
                        </td>`
                tr += "</tr>";
                if (statustable=='Y') {
                    $('#mytable1 tbody').append(tr);
                } else {
                    $('#mytable2 tbody').append(tr);
                }
            }
        }
        else
        {
            var tr = `<tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable=='Y') {
                $('#mytable1 tbody').append(tr);
            } else {
                $('#mytable2 tbody').append(tr);
            }
        }
    }

    function activeConfirm(url) {
        $('#btn-confirmactive').attr('href', url);
        $('#activeSocialTVModal').modal();
    }

    function inactiveConfirm(url) {
        $('#btn-confirminactive').attr('href', url);
        $('#inactiveSocialTVModal').modal();
    }
</script>