<style type="text/css">
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    .page-link a {color: white;}
    .page-link {width: 35px; height: 35px;}
    #searchinputactive, #searchinputinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonactive, #searchbuttoninactive { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #refreshbuttonepisode, #refreshbuttontrailer { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Catch Up</h1>
            <?php echo $this->session->flashdata('msg');?>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('catchup_selections') ?>">List Catch Up</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <div id="content-wrapper">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table mb-0" style="width:100%">
                                <tr>
                                    <th>Sort :</th>
                                    <td><?php echo $catchup['sort'] ?></td>
                                </tr>
                                <tr>
                                    <th>TV Channel :</th>
                                    <td><?php echo $catchup['name_channel'] ?></td>
                                </tr>
                                <tr>
                                    <th>Category Catch Up :</th>
                                    <td><?php echo $catchup['category_catchup_name'] ?></td>
                                </tr>
                                <tr>
                                    <th>Title :</th>
                                    <td><?php echo $catchup['title'] ?></td>
                                </tr>
                                <tr>
                                    <th>Year :</th>
                                    <td><?php echo $catchup['year'] ?></td>
                                </tr>
                                <tr>
                                    <th>Waktu Tayang :</th>
                                    <td><?php echo $catchup['jamtayang'] ?></td>
                                </tr>
                                <tr>
                                    <th>Duration :</th>
                                    <td><?php echo $catchup['durasi'] ?></td>
                                </tr>
                                <tr>
                                    <th>Rated :</th>
                                    <td><?php echo $catchup['rating'] ?></td>
                                </tr>
                                <tr>
                                    <th>Description :</th>
                                    <td><?php echo $catchup['description'] ?></td>
                                </tr>
                                <tr>
                                    <th>Cast :</th>
                                    <td><?php echo $catchup['cast'] ?></td>
                                </tr>
                                <tr>
                                    <th>Genre :</th>
                                    <td><?php echo $catchup['genre'] ?></td>
                                </tr>
                                <tr>
                                    <th>Thumbnail :</th>
                                    <td><img width="128" height="72" src="<?php echo $catchup['thumbnail'] ?>"></td>
                                </tr>
                                <tr>
                                    <th>Banner :</th>
                                    <td><img width="128" height="72" src="<?php echo $catchup['banner'] ?>"></td>
                                </tr>
                            </table>       
                        </div>
                    </div>
                </div>
                <br><hr><br>
                <?php 
                if($catchup['category_catchup'] == "1") {
                    $tab1 = "Movie";
                } elseif($catchup['category_catchup'] == "2") {
                    $tab1 = "Episodes";
                } elseif($catchup['category_catchup'] == "4") {
                    $tab1 = "Sequels";
                }
                ?>
                <?php if (has_permission('create_catchupselections') && $catchup['category_catchup'] != '1'): ?>
                    <a href="<?= base_url('catchup_selections/create_catchup_content/'.$catchup['id']) ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Catch Up Content</a>
                <?php endif; ?>
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a id="tab_1" class="nav-link aktif active" data-toggle="tab" href="#tab_episode" role="tab"><?php echo $tab1 ?></a>
                        </li>
                        <li class="nav-item">
                            <a id="tab_2" class="nav-link nonaktif" data-toggle="tab" href="#tab_trailer" role="tab">Trailer</a>
                        </li>
                    </ul>
                    <input type="hidden" name="category_catchup" id="category_catchup" value="<?php echo $catchup['category_catchup_name'] ?>">
                    <input type="hidden" name="category_id" id="category_id" value="<?php echo $catchup['category_catchup'] ?>">
                    <input type="hidden" name="sort_table" id="sort_table" value="id">
                    <input type="hidden" name="order_table" id="order_table" value="desc">
                    <input type="hidden" name="id_catchup" id="id_catchup" value="<?php echo $catchup['id'] ?>">
                    <div class="tab-content">
                        <div class="tab-pane active fade show" id="tab_episode" role="tabpanel">
                            <?php
                            if($catchup['category_catchup'] == "2") {
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Highlight Season</label><br>
                                    <select class="form-control" name="category_season1" id="category_season1" required>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <br><br>
                            <?php } ?>
                            <span class="invalid-feedback" id="wardingsearchactive" name="wardingsearchactive" style="display:none;">minimum 5 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputactive" id="searchinputactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttonactive" id="searchbuttonactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" class="btn btn-light" id="refreshbuttonepisode"><i class="zmdi zmdi-refresh zmdi-hc-fw"></i></button>
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytable1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <?php if($catchup['category_catchup'] == "4") { ?>
                                            <th>Sequels</th>
                                            <?php } else { ?>
                                            <th>No.</th>
                                            <?php } ?>
                                            <th>Thumbnail</th>
                                            <th class="text-center">Title</th>
                                            <?php
                                            if($catchup['category_catchup'] == "2") {
                                            ?>
                                            <th>Season</th>
                                            <th>Episode</th>
                                            <th>Label</th>
                                            <?php } ?>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody  class="tableactive" style="cursor: all-scroll;">
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_info" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination'></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_trailer" role="tabpanel">
                            <span class="invalid-feedback" id="wardingsearchinactive" name="wardingsearchinactive" style="display:none;">minimum 5 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputinactive" id="searchinputinactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttoninactive" id="searchbuttoninactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" class="btn btn-light" id="refreshbuttontrailer"><i class="zmdi zmdi-refresh zmdi-hc-fw"></i></button>
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytable2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Thumbnail</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Trailer URL</th>
                                            <?php
                                            if($catchup['category_catchup_name'] == "Season") {
                                            ?>
                                            <th>Season</th>
                                            <th>Episode</th>
                                            <?php } ?>
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

<!-- Active/Inactive Confirmation-->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left"></h5>
            </div>
            <div class="modal-body">
                <h5 class="modal-title text-center" id="exampleModalLabel">Are you sure?</h5>
            </div>
            <div class="modal-footer">
                <a id="btn-status" class="btn btn-link" href="#">Yes</a>
                <button class="btn btn-link" type="button" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var category_catchup = $("#category_catchup").val();
    var id_catchup = $("#id_catchup").val();
    if (category_catchup == "Season") {
        $('#category_season1').select2({
            ajax: {
                url: '<?= base_url() ?>catchup_selections/category_season',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page,
                        id_catchup: id_catchup,
                        category_catchup: 'season'
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
            placeholder: "Select a category season",
            templateResult: format,
            templateSelection: formatSelection
        })
    
        $('#category_season1').on('select2:select', function (e) {
            var cat_season = $(this).val()
            var select_content = 'episode';
            var category_catchup = $('#category_catchup').val()
            var id_catchup = $('#id_catchup').val()
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var key_search = $('#searchinputactive').val()
            if (key_search=='') {
                key_search = null
            }   console.log(cat_season);
            if (cat_season=='' || cat_season == undefined) {
                cat_season = null
            }
            loadPagination(id_catchup,key_search,cat_season,category_catchup,sort_by,order_sort,select_content,0);
        })
    }

    $(document).ready(function() {
        var category = $('#category_id').val();
        if (category == "1") {
            $("#tab_1").parent().hide();
            $(".nonaktif").click();
        } else {
            var select_content = 'episode';
            var cat_season = null;
            var category_catchup  = $('#category_catchup').val()
            var id_catchup = $('#id_catchup').val()
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var key_search = $('#searchinputactive').val()
            if (key_search == '') {
                key_search = null;
            }
            loadPagination(id_catchup,key_search,cat_season,category_catchup,sort_by,order_sort,select_content,0);
            $("#tab_episode").show();
        }

        $('#rowselect_active').select2()

        $('#rowselect_inactive').select2()
    })

    $(".aktif").click(function() {
        var select_content = 'episode';
        var category_catchup = $('#category_catchup').val()
        var cat_season = $('#category_season1').val()
        var id_catchup = $('#id_catchup').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null;
        }
        if (cat_season == '' || cat_season == 'undefined' || cat_season == undefined) {
            cat_season = null;
        }
        loadPagination(id_catchup,key_search,cat_season,category_catchup,sort_by,order_sort,select_content,0);
        $("#tab_episode").show();
        $("#tab_trailer").hide();
    });

    $(".nonaktif").click(function() {
        var select_content = 'trailer';
        var category_catchup = $('#category_catchup').val()
        var cat_season = $('#category_season2').val()
        var id_catchup = $('#id_catchup').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputinactive').val()
        if (key_search == '') {
            key_search = null
        }
        if (cat_season=='' || cat_season == 'undefined' || cat_season == undefined) {
            cat_season = null
        }
        loadPagination(id_catchup,key_search,cat_season,category_catchup,sort_by,order_sort,select_content,0);
        $("#tab_episode").hide();
        $("#tab_trailer").show();
    });

    $("#searchbuttonactive").click(function() {
        var id_catchup = $('#id_catchup').val()
        var select_content = 'episode';
        var category_catchup = $('#category_catchup').val()
        var search = $("#searchinputactive").val();
        var length = search.length;
        if (length < 3) {
            $("#wardingsearchactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchactive').css("display", "none");
            }, 5000)
        } else {
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var cat_season = null;
            loadPagination(id_catchup,search,cat_season,category_catchup,sort_by,order_sort,select_content,0);
        }
    });

    $("#refreshbuttonepisode").click(function(){
        location.reload();
    });

    $('#pagination').on('click','a',function(e) {
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var select_content = 'episode';
        var category_catchup = $('#category_catchup').val()
        var id_catchup = $('#id_catchup').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        var cat_season = $('#category_season1').val()
        if (key_search=='') {
            key_search = null
        }   console.log(cat_season);
        if (cat_season=='' || cat_season == undefined) {
            cat_season = null
        }
        loadPagination(id_catchup,key_search,cat_season,category_catchup,sort_by,order_sort,select_content,pageno);
    });

    $('#pagination').on('click','.page-link',function(e) {
        e.preventDefault(); 
        var pageno = e.currentTarget.firstElementChild.attributes[1].nodeValue
        var select_content = 'episode';
        var category_catchup = $('#category_catchup').val()
        var id_catchup = $('#id_catchup').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        var cat_season = $('#category_season1').val()
        if (key_search=='') {
            key_search = null
        }   console.log(cat_season);
        if (cat_season=='' || cat_season == undefined) {
            cat_season = null
        }
        loadPagination(id_catchup,key_search,cat_season,category_catchup,sort_by,order_sort,select_content,pageno);
    });

    $("#searchbuttonacinactive").click(function() {
        var id_catchup = $('#id_catchup').val()
        var select_content = 'trailer';
        var category_catchup = $('#category_catchup').val()
        var search = $("#searchinputinactive").val();
        var length = search.length;
        if (length < 3) {
            $("#wardingsearchinactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchinactive').css("display", "none");
            }, 5000)
        } else {
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var cat_season = null;
            loadPagination(id_catchup,search,cat_season,category_catchup,sort_by,order_sort,select_content,0);
        }
    });

    $("#refreshbuttontrailer").click(function(){
        location.reload();
        $("#tab_1").removeClass("active");
        $("#tab_1").attr("aria-expanded", "false");
        $("#tab_2").addClass("active");
        $("#tab_2").attr("aria-expanded", "true");
    });

    $('#pagination2').on('click','a',function(e) {
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var select_content = 'trailer';
        var category_catchup = $('#category_catchup').val()
        var id_catchup = $('#id_catchup').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        var cat_season = $('#category_season2').val()
        if (key_search=='') {
            key_search = null
        }   console.log(cat_season);
        if (cat_season=='' || cat_season == undefined) {
            cat_season = null
        }
        loadPagination(id_catchup,key_search,cat_season,category_catchup,sort_by,order_sort,select_content,pageno);
    });

    $('#pagination2').on('click','.page-link',function(e) {
        var pageno            = e.currentTarget.firstElementChild.attributes[1].nodeValue
        var select_content    = 'trailer';
        var category_catchup  = $('#category_catchup').val()
        var id_catchup        = $('#id_catchup').val()
        var sort_by           = $('#sort_table').val()
        var order_sort        = $('#order_table').val()
        var key_search        = $('#searchinputinactive').val()
        var cat_season        = $('#category_season2').val()
        if (key_search=='') {
            key_search = null
        }   console.log(cat_season);
        if (cat_season=='' || cat_season == undefined) {
            cat_season = null
        }
        loadPagination(id_catchup,key_search,cat_season,category_catchup,sort_by,order_sort,select_content,pageno);
    });

    function loadPagination(id_catchup,key_search,cat_season,category_catchup,sort_by,order_sort,select_content,pagno) {
        $.ajax({
            url: '<?=base_url()?>catchup_selections/contentList/'+id_catchup+'/'+key_search+'/'+cat_season+'/'+sort_by+'/'+order_sort+'/'+select_content+'/'+pagno,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var order_sort = response.order;
                var x = response.x;
                var y = response.y;
                var z = response.z;
                var show = 'Showing '+x+' to '+y+' of '+z+' entries';
                $('#data-table_info').html(show);
                if (select_content=='episode') {
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
                                </div>`;

                    if (select_content =='episode') {
                        $('#pagination').html(page1);
                    } else {
                        $('#pagination2').html(page1);
                    }
                } else {
                    if (select_content =='episode') {
                        $('#pagination').html(response.pagination);
                    } else {
                        $('#pagination2').html(response.pagination);
                    }
                }
                createTable(response.result, response.row, category_catchup, select_content);
            }
        });
    }

    function createTable(result, sno, category_catchup, select_content) {
        if (select_content == 'episode') {
            $('#mytable1 tbody').empty();
        } else {
            $('#mytable2 tbody').empty();
        }
        if (result.length > 0) {
            sno = Number(sno);
            for (index in result) {
                var id = result[index].id_content;
                var id_catchup = result[index].id_catchup;
                var thumbnail = result[index].thumbnail;
                var title = result[index].content_title;
                var cat_catchup = result[index].category_catchup;
                var episode = result[index].episode;
                var label = result[index].label_group;
                if (select_content == 'trailer') {
                    var trailer_url = result[index].trailer_url;
                }
                if (category_catchup == 'Season') {
                    var season = result[index].season;
                    var episode = result[index].episode;
                }
                var content_status = result[index].content_status;
                sno+=1;
                var base_url ='<?php echo base_url()?>';
                if (content_status == "Y") {
                    var btn_status = "<button type='button' class='btn btn-outline-success' disabled>Active</button>";
                } else {
                    var btn_status = "<button type='button' class='btn btn-outline-danger' disabled>Inactive</button>";
                }
                var action = '<div class="dropdown"><button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button><div class="dropdown-menu dropdown-menu--icon">'
                if (content_status == "N") {
                    var action = action + '<a onclick="statusConfirm(\''+base_url+'catchup_selections/activated_content/'+id+'/'+id_catchup+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Actived</a>'
                } else {
                    var action = action + '<a onclick="statusConfirm(\''+base_url+'catchup_selections/inactivated_content/'+id+'/'+id_catchup+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Inactived</a>'
                }
                var action = action+'<a href="'+base_url+'catchup_selections/edit_catchup_content/'+id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
                if (category_catchup == 'Sequels') {
                    var num = episode;
                } else {
                    var num = sno;
                }
                var tr = "<tr>";
                tr += "<td class='text-center'>"+ num +"</td>";
                tr += "<td class='text-center'><img id='myImg' src='"+thumbnail+"' alt='' width='128' height='72'></td>";
                tr += "<td class='text-center'>"+ title +"</td>";
                if (select_content == 'trailer') {
                    tr += "<td class='link-url'>"+ trailer_url +"</td>";
                }
                if (category_catchup == 'Season') {
                    tr += "<td class='text-center'>"+ season +"</td>";
                    tr += "<td class='text-center'>"+ episode +"</td>";
                }
                if (cat_catchup == '2') {
                    label = label.split(" ");
                    tr += "<td class='text-center'>"+ label[0] +"</td>";
                }
                tr += "<td class='text-center'>"+ btn_status +"</td>";
                tr += "<td class='text-center'>"+ action +"</td>";
                tr += "</tr>";
                if (select_content=='episode') {
                    $('#mytable1 tbody').append(tr);
                } else {
                    $('#mytable2 tbody').append(tr);
                }
            }
        } else {
            if (category_catchup == "Single") {
                var colspan = 6;
            } else {
                var colspan = 8;
            }
            var tr = '<tr class="odd"><td valign="top" colspan="'+colspan+'" class="dataTables_empty">No matching records found</td></tr>';
            if (select_content == 'episode') {
                $('#mytable1 tbody').append(tr);
            } else {
                $('#mytable2 tbody').append(tr);
            }
        }
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

    function statusConfirm(url) {
        $('#btn-status').attr('href', url);
        $('#statusModal').modal();
    }
</script>