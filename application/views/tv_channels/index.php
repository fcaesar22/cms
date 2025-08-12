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
    #mytable1 .more-content, #mytable2 .more-content {display: none;}
    #mytable1 .read-more, #mytable2 .read-more {cursor: pointer; color: rgba(255, 255, 255, .7); padding: 0;}
    #mytable1 .descdiv, #mytable2 .descdiv {white-space: pre-wrap; text-align: justify; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>TV Channels</h1>
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
                <?php if (has_permission('create_tvchannels')): ?>
                    <a href="<?= base_url('tv_channels/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add TV Channels</a>
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
                            <input type="hidden" name="sort_table" id="sort_table" value="seq">
                            <input type="hidden" name="order_table" id="order_table" value="desc">
                            <input type="hidden" name="visible" id="visible" value="Y">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Category</label><br>
                                    <select class="form-control" name="category_tvchannelsactive" id="category_tvchannelsactive" required>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <br><br>
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
                                            <th>No.</th>
                                            <th>Icon</th>
                                            <th>Title</th>
                                            <th>URL</th>
                                            <th>List Price</th>
                                            <th>Sell Price</th>
                                            <th>Channel ID</th>
                                            <th>Updated Time</th>
                                            <th>Member</th>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Category</label><br>
                                    <select class="form-control" name="category_tvchannelsinactive" id="category_tvchannelsinactive" required>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <br><br>
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
                                            <th>No.</th>
                                            <th>Icon</th>
                                            <th>Title</th>
                                            <th>URL</th>
                                            <th>List Price</th>
                                            <th>Sell Price</th>
                                            <th>Channel ID</th>
                                            <th>Updated Time</th>
                                            <th>Member</th>
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

<!--Active Article Confirmation-->
<div class="modal fade" id="activeTVModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<!--Inactive Article Confirmation-->
<div class="modal fade" id="inactiveTVModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<div class="modal fade" id="modal-preview" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Preview Video</h5>
            </div>
            <div class="modal-body">
                <div id="changing-embed">
                    <div id="bungkus" style="margin: 0 auto;display: none;"><video id="my-video" class="video-js vjs-theme-forest" controls preload="auto" width="410" height="230" data-setup="{}"><p class="vjs-no-js"> To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank"> supports HTML5 video</a></p></video></div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        activaTab('tab1');

        $('#category_tvchannelsactive').select2({
            ajax: {
                url: '<?= base_url() ?>tv_channels/category_tvchannels',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }

                    };
                },
                cache: true
            },
            placeholder: "Select a tv channels category",
            width: '100%',
            templateResult: format,
            templateSelection: formatSelection
        })

        $('#category_tvchannelsinactive').select2({
            ajax: {
                url: '<?= base_url() ?>tv_channels/category_tvchannels',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }

                    };
                },
                cache: true
            },
            placeholder: "Select a tv channels category",
            width: '100%',
            templateResult: format,
            templateSelection: formatSelection
        })

        $('#rowselect_active').select2()

        $('#rowselect_inactive').select2()
    })

    function activaTab(tab) {
        $("#category_tvchannelsactive").html('<option value="-1" selected>All</option>');
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_tvchannelsactive').val()
        if (category=='') {
            category = null
        }
        $('#rowselect_active').select2()
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
    };

    $("#tab_1").click(function() {
        $("#category_tvchannelsactive").html('<option value="-1" selected>All</option>');
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        $('#visible').val('Y')
        var visible = $('#visible').val()
        $('#searchinputactive').val(null)
        var key_search = null
        var category = $('#category_tvchannelsactive').val()
        if (category=='') {
            category = null
        }
        $('#rowselect_active').val(10).trigger('change');
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
        $("#tab2").hide();
        $("#tab1").show();
    });

    $("#tab_2").click(function() {
        $("#category_tvchannelsinactive").html('<option value="-1" selected>All</option>');
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        $('#visible').val('N')
        var visible = $('#visible').val()
        $('#searchinputinactive').val(null)
        var key_search = null
        var category = $('#category_tvchannelsinactive').val()
        if (category=='') {
            category = null
        }
        $('#rowselect_inactive').val(10).trigger('change');
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
        $("#tab1").hide();
        $("#tab2").show();
    });

    $('#category_tvchannelsactive').on('select2:select', function (e) {
        var visible = $('#visible').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_tvchannelsactive').val()
        if (category=='') {
            category = null
        }
        $('#rowselect_active').val(10).trigger('change');
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
    })

    $('#category_tvchannelsinactive').on('select2:select', function (e) {
        var visible = $('#visible').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_tvchannelsinactive').val()
        if (category=='') {
            category = null
        }
        $('#rowselect_inactive').val(10).trigger('change');
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
    })

    $(document).on("change","#rowselect_active",function (e) {
        var pageno = 0
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_tvchannelsactive').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
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
        var category = $('#category_tvchannelsinactive').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
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
            var category = $('#category_tvchannelsactive').val()
            if (category=='') {
                category = null
            }
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
        var category = $('#category_tvchannelsactive').val()
        if (category=='') {
            category = null
        }
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
        var category = $('#category_tvchannelsactive').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
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
            var category = $('#category_tvchannelsinactive').val()
            if (category=='') {
                category = null
            }
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
        var category = $('#category_tvchannelsinactive').val()
        if (category=='') {
            category = null
        }
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
        var category = $('#category_tvchannelsinactive').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
    });

    function loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno) {
        $.ajax({
            url: '<?=base_url()?>tv_channels/list_tv_channels/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+category+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function(response){
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
                var id = result[index].seq;
                var title = result[index].title;
                var play_url = result[index].play_url;
                var list_price = result[index].price;
                var sell_price = result[index].price2;
                var channelid = result[index].channelid;
                var update_date = result[index].update_date;
                var member_area = result[index].member_area;
                var member_id = result[index].member_id;
                var image = 'https://picture.dens.tv/tv_183x174/'+result[index].file1;
                var htmlimage = '<img id="myImg" src="' + image + '" alt="" width="80" height="80">'
                sno+=1;
                var base_url ='<?php echo base_url()?>'

                var activeinactive = ""
                var previewurl = ""
                if (result[index].visible==="N") {
                    activeinactive = "<a onclick='activeConfirm(\""+base_url+'tv_channels/activated_tv_channel/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-plus-circle zmdi-hc-fw'></i>Activate TV Channels</a>";
                } else {
                    activeinactive = "<a onclick='inactiveConfirm(\""+base_url+'tv_channels/inactivated_tv_channel/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-minus-circle zmdi-hc-fw'></i>Deactivate TV Channels</a>";
                    previewurl = "<a href='#!' onclick='preview(\""+play_url+"\")' class='dropdown-item'><i class='zmdi zmdi-eye zmdi-hc-fw'></i>Preview</a>"
                }

                var tr = "<tr id='"+id+"'>";
                tr += "<td>"+ sno +"</td>";
                tr += "<td>"+ htmlimage +"</td>";
                tr += "<td>"+ title +"</td>";
                tr += "<td>"+ play_url +"</td>";
                tr += "<td>"+ list_price +"</td>";
                tr += "<td>"+ sell_price +"</td>";
                tr += "<td>"+ channelid +"</td>";
                tr += "<td>"+ update_date +"</td>";
                tr += "<td>"+ member_area + "/" + member_id +"</td>";
                tr += `<td>
                            <div class='dropdown'>
                                <button class='btn btn-light' data-toggle='dropdown' aria-expanded='false'>ACTION</button>
                                <div class='dropdown-menu dropdown-menu--icon'>
                                <?php if (has_permission('edit_tvchannels')): ?>
                                    ${previewurl}
                                    <a href="<?= base_url('tv_channels/edit/${id}') ?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                <?php endif; ?>
                                <?php if (has_permission('delete_tvchannels')): ?>
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
            var tr = `<tr class="odd"><td valign="top" colspan="10" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable=='Y') {
                $('#mytable1 tbody').append(tr);
            } else {
                $('#mytable2 tbody').append(tr);
            }
        }
    }

    function activeConfirm(url) {
        $('#btn-confirmactive').attr('href', url);
        $('#activeTVModal').modal();
    }

    function inactiveConfirm(url) {
        $('#btn-confirminactive').attr('href', url);
        $('#inactiveTVModal').modal();
    }

    function format (repo) {
        if (repo.loading) {
            return repo.text;
        }
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'></div>" +
            "</div>"
        );
        $container.find(".select2-result-repository__title").text(repo.text);
        return $container;
    }

    function formatSelection (repo) {
        return repo.text;
    }

    window.player = videojs('my-video');

    function preview(url) {
        console.log(url)
        var vid_preview = '<video id="my-video" style="margin: 0 auto;" class="video-js vjs-theme-forest" controls preload="auto" width="410" height="230" data-setup="{}"><p class="vjs-no-js"> To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank"> supports HTML5 video</a></p></video>'
        var bungkus
        if ($('#bungkus').html() != undefined) {
            bungkus = $('#bungkus').html('').css({
                display:'block',
                margin:'0 auto'
            })
            $('#changing-embed').html($(bungkus).append(vid_preview));
        } else {
            $('#changing-embed').html($('<div id="bungkus" style="display:block; margin: 0 auto;"></div>').append(vid_preview));
        }

        if (window.player.isReady_) window.player.dispose();

        window.player = videojs('my-video');
        window.player.src({
            src: url,
            type: 'application/x-mpegURL',
            // withCredentials: true
        });
        $('#modal-preview').modal('show');
        player.play();
    }

    $('#modal-preview').on('hidden.bs.modal', function (e) {
        player.pause();
    })
</script>