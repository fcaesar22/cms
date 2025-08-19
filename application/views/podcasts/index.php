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
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Podcast</h1>
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
                <?php if (has_permission('create_podcasts')): ?>
                    <a href="<?= base_url('podcasts/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Podcast</a>
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
                            <input type="hidden" name="sort_table" id="sort_table" value="podcast_id">
                            <input type="hidden" name="order_table" id="order_table" value="desc">
                            <input type="hidden" name="visible" id="visible" value="Y">
                            <span class="invalid-feedback" id="wardingsearchactive" name="wardingsearchactive" style="display:none;">minimum 3 charachters</span>
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
                                            <th>No.</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Recommendation</th>
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
                            <span class="invalid-feedback" id="wardingsearchinactive" name="wardingsearchinactive" style="display:none;">minimum 3 charachters</span>
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
                                            <th>No.</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Recommendation</th>
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

<!-- Modal Activated podcast content Confirmation -->
<div class="modal fade" id="activeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-active" class="btn btn-success" href="#">Yes</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Inactivated podcast content Confirmation -->
<div class="modal fade" id="inactiveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-inactive" class="btn btn-danger" href="#">Yes</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal activated and inactivated recommendation podcast content -->
<div class="modal fade show" id="modalRecom" tabindex="-1" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- form recommendation podcast content -->
            <form id="myform" action="<?php echo base_url("podcasts/save_podcast_recom"); ?>" method="post">
                <div class="modal-header" style="justify-content: center;">
                    <h5 class="modal-title">Recommendation Podcast</h5>
                </div>
                <hr>
                <div class="modal-body">
                <br>
                    <div class="col-sm-6">
                        <label>Start Schedule Time</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                            <div class="form-group">
                                <input type="text" name="datetimepickerstart" id="datetimepickerstart" class="form-control date-picker flatpickr-input" placeholder="Pick a start date" autocomplete="off" required="">
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-6">
                        <label>End Schedule Time</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                            <div class="form-group">
                                <input type="text" name="datetimepickerend" id="datetimepickerend" class="form-control date-picker flatpickr-input" placeholder="Pick a end date" autocomplete="off" required="">
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content: center;">
                    <input type="hidden" name="podcast_id" id="podcast_id" value="">
                    <button type="submit" class="btn btn-link">Save</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </form>
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
        $('#rowselect_active').select2()
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,0);
    };

    $("#tab_1").click(function() {
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        $('#visible').val('Y')
        var visible = $('#visible').val()
        $('#searchinputactive').val(null)
        var key_search = null
        skipRowChange = true;
        $('#rowselect_active').val(10).trigger('change');
        skipRowChange = false;
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,0);
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
        skipRowChange = true;
        $('#rowselect_inactive').val(10).trigger('change');
        skipRowChange = false;
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,0);
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
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno);
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
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno);
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
            skipRowChange = true;
            $('#rowselect_active').val(10).trigger('change');
            skipRowChange = false;
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
        if (length < 3) {
            $("#wardingsearchinactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchinactive').css("display", "none");
            }, 5000)
        } else {
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var visible = $('#visible').val()
            skipRowChange = true;
            $('#rowselect_inactive').val(10).trigger('change');
            skipRowChange = false;
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

    function loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno) {
        $.ajax({
            url: '<?=base_url()?>podcasts/list_podcast/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+rowperpage+'/'+pageno,
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
                        $('#pagination').html(response.pagination);
                    } else {
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
                var id = result[index].podcast_id;
                var image = result[index].podcast_image;
                var htmlimage = '<img id="myImg" src="' + image + '" alt="" width="100" height="100">'
                var title = result[index].podcast_name;
                var category = result[index].categories;
                var recommendation = result[index].status;
                var start_periode = result[index].start_periode;
                var end_periode = result[index].end_periode;
                var visible = result[index].visible;
                sno+=1;
                var base_url ='<?php echo base_url()?>'

                if (recommendation == 'FALSE') {
                    recommendation = "<button type='button' class='btn btn-outline-danger' disabled>Not Ready</button>"
                } else {
                    recommendation = "<button type='button' class='btn btn-outline-success' disabled>Ready</button>"
                }
                var activeinactive = ""
                var set_recommendation = ""
                if (visible==="N") {
                    activeinactive = "<a onclick='activeConfirm(\""+base_url+'podcasts/activated/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-plus-circle zmdi-hc-fw'></i>Activate Podcast</a>";
                } else {
                    activeinactive = "<a onclick='inactiveConfirm(\""+base_url+'podcasts/inactivated/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-minus-circle zmdi-hc-fw'></i>Deactivate Podcast</a>";
                    if (start_periode != null && end_periode != null) {
                        var set_recommendation = '<a onclick="getIDS(\''+id+'\', \''+start_periode+'\', \''+end_periode+'\')" href="#" class="dropdown-item" data-toggle="modal" data-target="#modalRecom"><i class="zmdi zmdi-calendar zmdi-hc-fw" ></i>Recommendation</a>'
                    } else {
                        var set_recommendation = '<a onclick="getID(\''+id+'\')" href="#" class="dropdown-item" data-toggle="modal" data-target="#modalRecom"><i class="zmdi zmdi-calendar zmdi-hc-fw" ></i>Recommendation</a>'
                    }
                }

                var tr = "<tr id='"+id+"'>";
                tr += "<td>"+ sno +"</td>";
                tr += "<td>"+ htmlimage +"</td>";
                tr += "<td>"+ title +"</td>";
                tr += "<td>"+ category +"</td>";
                tr += "<td>"+ recommendation +"</td>";
                tr += `<td>
                            <div class='dropdown'>
                                <button class='btn btn-light' data-toggle='dropdown' aria-expanded='false'>ACTION</button>
                                <div class='dropdown-menu dropdown-menu--icon'>
                                <?php if (has_permission('edit_podcasts')): ?>
                                    ${set_recommendation}
                                    <a href="<?= base_url('podcasts/edit/${id}') ?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                <?php endif; ?>
                                <?php if (has_permission('delete_podcasts')): ?>
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
            var tr = `<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable=='Y') {
                $('#mytable1 tbody').append(tr);
            } else {
                $('#mytable2 tbody').append(tr);
            }
        }
    }

    $( function() {
        $("#datetimepickerstart").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d",
        })
        $("#datetimepickerstart").prop('readonly', false)
    });

    $( function() {
        $("#datetimepickerend").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d",
        })
        $("#datetimepickerend").prop('readonly', false)
    });

    function getID(podcast_id){
        $('#podcast_id').val(podcast_id);
        $("#datetimepickerstart").flatpickr().clear()
        $("#datetimepickerstart").prop('readonly', false)
        $("#datetimepickerend").flatpickr().clear()
        $("#datetimepickerend").prop('readonly', false)
    }

    function getIDS(podcast_id, start_periode, end_periode){
        $('#podcast_id').val(podcast_id);
        $('[name="datetimepickerstart"]').val(start_periode).trigger('change');
        $('[name="datetimepickerend"]').val(end_periode).trigger('change');
    }

    function activeConfirm(url) {
        $('#btn-active').attr('href', url);
        $('#activeModal').modal();
    }

    function inactiveConfirm(url) {
        $('#btn-inactive').attr('href', url);
        $('#inactiveModal').modal();
    }
</script>