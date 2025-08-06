<style type="text/css">
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    .page-link a {color: white;}
    .page-link {width: 35px; height: 35px;}
    #searchinputactive, #searchinputinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonactive, #searchbuttoninactive { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow_active, #selectrow_inactive { float: left; width: 7%; padding: 3.8px; color: white; font-size: 14px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    .whtl1 .btn-link, .whtl2 .btn-link  {color: white !important; font-weight: 600; cursor: pointer;}
    .whid1 .btn-link, .whid2 .btn-link  {color: white !important; font-weight: 600; cursor: pointer;}
    .whds1 .btn-link, .whds2 .btn-link  {color: white !important; font-weight: 600; cursor: pointer;}
    .whbn1 .btn-link, .whbn2 .btn-link  {color: white !important; font-weight: 600; cursor: pointer;}
    .whpin1 .btn-link, .whpin2 .btn-link  {color: white !important; font-weight: 600; cursor: pointer;}
    #mytable1 .more-content, #mytable2 .more-content {display: none;}
    #mytable1 .read-more, #mytable2 .read-more {cursor: pointer; color: rgba(255, 255, 255, .7); padding: 0;}
    #mytable1 .descdiv, #mytable2 .descdiv {white-space: pre-wrap; text-align: justify; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Users</h1>
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
                <?php if (has_permission('create_whatsons')): ?>
                    <a href="<?= base_url('whatsons/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add What's On</a>
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
                            <input type="hidden" name="sort_table" id="sort_table" value="whatson_id">
                            <input type="hidden" name="order_table" id="order_table" value="desc">
                            <input type="hidden" name="visible" id="visible" value="0">
                            <span class="invalid-feedback" id="wardingsearchactive" name="wardingsearchactive" style="display:none;">minimum 5 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputactive" id="searchinputactive" minlength="5" maxlength="50">
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
                                            <th class="whds1">Description</th>
                                            <th>Category</th>
                                            <th>Image</th>
                                            <th class="whbn1">Status Banner</th>
                                            <th class="whpin1">Pin Banner</th>
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
                            <span class="invalid-feedback" id="wardingsearchinactive" name="wardingsearchinactive" style="display:none;">minimum 5 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputinactive" id="searchinputinactive" minlength="5" maxlength="50">
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
                                            <th class="whds2">Description</th>
                                            <th>Category</th>
                                            <th>Image</th>
                                            <th class="whbn2">Status Banner</th>
                                            <th class="whpin2">Pin Banner</th>
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

<div class="modal fade show" id="modalEPG" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">EPG</h5>
            </div>
            <div class="modal-body">
                Anda akan diarahkan ke EPG, silahkan memilih tanggal dan waktu
                <form action="" method="post">
                <div class="col-sm-6">
                <div class="form-group">

                    <label for="datetimepicker">EPG Schedule Time</label>
                    <div class='input-group date'>
                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                        <input type="text" id="datetimepicker" name="datetimepicker" placeholder="Pick a date & time" class="form-control">
                        <i class="form-group__bar"></i>
                    </div>
                    <input type="hidden" name="channel_id" id="channel_id" value="">
                </div>
               
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" onclick="toEPG()">Go To EPG</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!--Active Whatson Confirmation-->
<div class="modal fade" id="activeWhatsonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<!--Inactive Whatson Confirmation-->
<div class="modal fade" id="inactiveWhatsonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    })

    function activaTab(tab) {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        $('#rowselect_active').select2()
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,0);
    };

    $("#tab_1").click(function() {
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        $('#visible').val('0')
        var visible = $('#visible').val()
        $('#searchinputactive').val(null)
        var key_search = null
        $('#rowselect_active').select2()
        $('#rowselect_active').val(10)
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,0);
        $("#tab2").hide();
        $("#tab1").show();
    });

    $("#tab_2").click(function() {
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        $('#visible').val('1')
        var visible = $('#visible').val()
        $('#searchinputinactive').val(null)
        var key_search = null
        $('#rowselect_inactive').select2()
        $('#rowselect_inactive').val(10)
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,0);
        $("#tab1").hide();
        $("#tab2").show();
    });

    $(document).on("change","#rowselect_active",function (e) {
        var pageno = 0
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno);
    });

    $(document).on("change","#rowselect_inactive",function (e) {
        var pageno = 0
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputinactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno);
    });

    $("#searchbuttonactive").click(function() {
        var search =  $("#searchinputactive").val();
        var length = search.length
        if (length < 4) {
            $("#wardingsearchactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchactive').css("display", "none");
            }, 5000)
        } else {
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var visible = $('#visible').val()
            var rowperpage = $('#rowselect_active').val()
            loadPagination(search,sort_by,order_sort,visible,rowperpage,0);
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
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno);
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
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno);
    });

    $("#searchbuttonacinactive").click(function() {
        var search =  $("#searchinputinactive").val();
        var length = search.length
        if (length < 4) {
            $("#wardingsearchinactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchinactive').css("display", "none");
            }, 5000)
        } else {
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var visible = $('#visible').val()
            var rowperpage = $('#rowselect_inactive').val()
            loadPagination(search,sort_by,order_sort,visible,rowperpage,0);
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
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno);
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
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno);
    });

    function sort_field_active(key_search,sort_by,order_sort,pageno) {
        if (order_sort == 'asc') {
            var order_sort = 'desc'
        } else {
            var order_sort = 'asc'
        }
        $('#sort_table').val(sort_by)
        $('#order_table').val(order_sort)
        sort_by = $('#sort_table').val()
        order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno);
    }

    function sort_field_inactive(key_search,sort_by,order_sort,pageno) {
        if (order_sort == 'asc') {
            var order_sort = 'desc'
        } else {
            var order_sort = 'asc'
        }
        $('#sort_table').val(sort_by)
        $('#order_table').val(order_sort)
        sort_by = $('#sort_table').val()
        order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputinactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno);
    }

    function loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno) {
        $.ajax({
            url: '<?=base_url()?>whatsons/list_whatsons/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function(response){
                var order_sort = response.order;
                var x = response.x;
                var y = response.y;
                var z = response.z;
                var show = 'Showing '+x+' to '+y+' of '+z+' entries';
                $('#data-table_info').html(show);
                if (visible=='0') {
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
                    if (visible=='0') {
                        $('#pagination').html(page1);
                    } else {
                        $('#pagination2').html(page1);
                    }
                } else {
                    if (visible=='0') {
                        $('.whid1').html('<input type="button" class="btn btn-link" value="No." onClick="sort_field_active(\''+key_search+'\',\'whatson_id\',\''+order_sort+'\','+pageno+')" />')
                        $('.whtl1').html('<input type="button" class="btn btn-link" value="Title" onClick="sort_field_active(\''+key_search+'\',\'whatson_title\',\''+order_sort+'\','+pageno+')" />')
                        $('.whds1').html('<input type="button" class="btn btn-link" value="Description" onClick="sort_field_active(\''+key_search+'\',\'whatson_description\',\''+order_sort+'\','+pageno+')" />')
                        $('.whbn1').html('<input type="button" class="btn btn-link" value="Banner" onClick="sort_field_active(\''+key_search+'\',\'whatson_banner_active\',\''+order_sort+'\','+pageno+')" />')
                        $('.whpin1').html('<input type="button" class="btn btn-link" value="Pin Banner" onClick="sort_field_active(\''+key_search+'\',\'is_pinned\',\''+order_sort+'\','+pageno+')" />')
                        $('#pagination').html(response.pagination);
                    } else {
                        $('.whid2').html('<input type="button" class="btn btn-link" value="No." onClick="sort_field_inactive(\''+key_search+'\',\'whatson_id\',\''+order_sort+'\','+pageno+')" />')
                        $('.whtl2').html('<input type="button" class="btn btn-link" value="Title" onClick="sort_field_inactive(\''+key_search+'\',\'whatson_title\',\''+order_sort+'\','+pageno+')" />')
                        $('.whds2').html('<input type="button" class="btn btn-link" value="Description" onClick="sort_field_inactive(\''+key_search+'\',\'whatson_description\',\''+order_sort+'\','+pageno+')" />')
                        $('.whbn2').html('<input type="button" class="btn btn-link" value="Banner" onClick="sort_field_inactive(\''+key_search+'\',\'whatson_banner_active\',\''+order_sort+'\','+pageno+')" />')
                        $('.whpin2').html('<input type="button" class="btn btn-link" value="Pin Banner" onClick="sort_field_inactive(\''+key_search+'\',\'is_pinned\',\''+order_sort+'\','+pageno+')" />')
                        $('#pagination2').html(response.pagination);
                    }
                }
                createTable(response.result,response.row);
            }
        });
    }

    function createTable(result,sno) {
        var statustable = $('#visible').val()
        if (statustable=='0') {
            $('#mytable1 tbody').empty();
        } else {
            $('#mytable2 tbody').empty();
        }

        if (result.length > 0) {
            sno = Number(sno);
            for(index in result){
                var id = result[index].whatson_id;
                var title = result[index].whatson_title;
                var description = result[index].whatson_description;
                var category = result[index].category_whatson_name;
                var category_id = result[index].category_whatson_id;
                var content_id = result[index].content_id;
                var image = 'https://picture.dens.tv/wp/img/whatson_v2/1280x720/'+result[index].whatson_image;
                var htmlimage = '<img id="myImg" src="' + image + '" alt="" width="128" height="72">'
                var banner = result[index].whatson_banner_active;
                var pin = result[index].is_pinned;
                sno+=1;
                var base_url ='<?php echo base_url()?>'

                if (banner == '1') {
                    var banner_status = "<button type='button' class='btn btn-outline-success' disabled>Active</button>"
                } else {
                    var banner_status = "<button type='button' class='btn btn-outline-danger' disabled>Inactive</button>"
                }

                if (pin == '1') {
                    var banner_pin = "<button type='button' class='btn btn-outline-success' disabled>Ready</button>"
                } else {
                    var banner_pin = "<button type='button' class='btn btn-outline-danger' disabled>Not Ready</button>"
                }

                var to_epg = ""
                if (category_id==="2") {
                    to_epg = "<a onclick='getChannel(\""+content_id+"\")' href='#' class='dropdown-item' data-toggle='modal' data-target='#modalEPG'><i class='zmdi zmdi-calendar zmdi-hc-fw' ></i>EPG</a>";
                }

                var activeinactive = ""
                var set_banner = ""
                var set_pin = ""
                if (result[index].deleted==="1") {
                    activeinactive = "<a onclick='activeConfirm(\""+base_url+'whatsons/activated_whatson/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-plus-circle zmdi-hc-fw'></i>Activate What's On</a>";
                } else {
                    activeinactive = "<a onclick='inactiveConfirm(\""+base_url+'whatsons/inactivated_whatson/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-minus-circle zmdi-hc-fw'></i>Deactivate What's On</a>";
                    var set_banner = ""
                    if (banner==='0') {
                        set_banner = "<a onclick='activeConfirm(\""+base_url+'whatsons/activated_banner/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-layers zmdi-hc-fw'></i>Activate Banner</a>"
                    } else {
                        set_banner = "<a onclick='inactiveConfirm(\""+base_url+'whatsons/inactivated_banner/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-layers-off zmdi-hc-fw'></i>Deactivate Banner</a>"
                    }

                    var set_pin = ""
                    if (pin==='0') {
                        set_pin = "<a onclick='activeConfirm(\""+base_url+'whatsons/pinbanner/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-pin zmdi-hc-fw'></i>Pin Banner</a>"
                    } else {
                        set_pin = "<a onclick='inactiveConfirm(\""+base_url+'whatsons/unpinbanner/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-pin-off zmdi-hc-fw'></i>Unpin Banner</a>"
                    }
                }

                var displayText = description.substring(0, 80);
                var moreContent = description.substring(80);
                var readMoreBtn = "";
                if (description.length > 10) {
                    readMoreBtn = "<button class='read-more btn btn-sm btn-link'>Read More</button>";
                }

                var tr = "<tr id='"+id+"'>";
                tr += "<td>"+ sno +"</td>";
                tr += "<td>"+ title +"</td>";
                tr += "<td class='descdiv'>" + displayText + "<span class='more-content'>" + moreContent + "</span>" + readMoreBtn + "</td>";
                tr += "<td>"+ category +"</td>";
                tr += "<td>"+ htmlimage +"</td>";
                tr += "<td>"+ banner_status +"</td>";
                tr += "<td>"+ banner_pin +"</td>";
                tr += `<td>
                            <div class='dropdown'>
                                <button class='btn btn-light' data-toggle='dropdown' aria-expanded='false'>ACTION</button>
                                <div class='dropdown-menu dropdown-menu--icon'>
                                <?php if (has_permission('edit_whatsons')): ?>
                                    ${to_epg}
                                    ${set_banner}
                                    ${set_pin}
                                    <a href="<?= base_url('whatsons/edit/${id}') ?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                <?php endif; ?>
                                <?php if (has_permission('delete_whatsons')): ?>
                                    ${activeinactive}
                                <?php endif; ?>
                                </div>
                            </div>
                        </td>`
                tr += "</tr>";
                if (statustable=='0') {
                    $('#mytable1 tbody').append(tr);
                    initializeReadMore('#mytable1');
                } else {
                    $('#mytable2 tbody').append(tr);
                    initializeReadMore('#mytable2');
                }
            }
        }
        else
        {
            var tr = `<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable=='0') {
                $('#mytable1 tbody').append(tr);
            } else {
                $('#mytable2 tbody').append(tr);
            }
        }
    }

    function initializeReadMore(table) {
        $(table + " .read-more").off('click').on('click', function() {
            var $this = $(this);
            var $moreContent = $this.siblings(".more-content"); // ambil sibling .more-content
            $moreContent.toggle();

            $this.text($this.text() === "Read More" ? "Read Less" : "Read More");
        });
    }

    $( function() {
        $("#datetimepicker").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d",
        })
        $("#datetimepicker").prop('readonly', false)
    });

    function toEPG() {
        var data = $('form').serializeArray();
        var url = "http://epg.dens.tv/schedule/admin/manual.php";
        if (data!=null) {
            url = url+"?id="+data[1].value+"&dt="+data[0].value;
        }
        window.open(url, "_blank");
        $('#modalEPG').modal('hide');
    }

    function getChannel(ch_id) {
        $('#channel_id').val(ch_id)
    }

    function activeConfirm(url) {
        $('#btn-confirmactive').attr('href', url);
        $('#activeWhatsonModal').modal();
    }

    function inactiveConfirm(url) {
        $('#btn-confirminactive').attr('href', url);
        $('#inactiveWhatsonModal').modal();
    }
</script>