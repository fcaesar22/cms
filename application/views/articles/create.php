<style type="text/css">
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    .page-link a {color: white;}
    .modal-body {max-height: 70vh; overflow-y: auto;}
    .modal-body::-webkit-scrollbar {width: 6px;}
    .modal-body::-webkit-scrollbar-thumb {background-color: rgba(255, 255, 255, 0.2); border-radius: 3px;}
    .modal-body::-webkit-scrollbar-thumb:hover {background-color: rgba(255, 255, 255, 0.35);}
    .modal-body::-webkit-scrollbar-track {background: transparent;}
    .modal-body {scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.2) transparent;}
    #searchinputactive{padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 60%; color: white; background: transparent;}
    #searchinputinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 80%; color: white; background: transparent;}
    #searchbuttonactive, #searchbuttoninactive { float: left; width: 20%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow {float: left; width: 20%; padding: 5px; color: white; font-size: 12px; border: 1px solid white; border-left: none; cursor: pointer; margin-bottom: 10px;}
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
    .visibilitys {display: none;}
    .visibilitys2 {display: none;}
    .catid1 .btn-link {color: white !important; font-weight: 600; cursor: pointer;}
    .cattl1 .btn-link {color: white !important; font-weight: 600; cursor: pointer;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Articles</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('articles') ?>">Articles</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?= form_open('articles/create') ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Content Type (*required)</label>&nbsp;
                                <select class="form-control" name="content_type" id="content_type" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('content_type') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category (*required)</label>&nbsp;
                                <a class="btn btn-light btn-sm visibilitys" data-toggle="modal" name="category" data-target="#modal-category" id="category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Category</a>
                                <select class="form-control" name="category_article[]" id="category_article" multiple="multiple" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('category_article') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tags (*required)</label>&nbsp;
                                <a class="btn btn-light btn-sm visibilitys2" data-toggle="modal" name="tagging" data-target="#modal-tags" id="tagging"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Tags</a>
                                <select class="form-control" name="tags_article[]" id="tags_article" multiple="multiple" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('tags_article') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>By (*required)</label>
                                <input type="text" name="article_by" id="article_by" class="form-control" value="<?= set_value('article_by') ?>" placeholder="Please Input By" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('article_by') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (*required)</label>
                                <input type="text" name="title" id="title" class="form-control" value="<?= set_value('title') ?>" placeholder="Please Input Title" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('title') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Summary (*required)</label>
                                <textarea name="summary" id="summary" class="form-control" rows="1" placeholder="Please Input Summary" required><?= set_value('summary') ?></textarea>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('summary') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>URL Maps (*required)</label>
                                <input type="text" name="url_maps" id="url_maps" class="form-control" value="<?= set_value('url_maps') ?>" placeholder="Please Input URL Maps">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('url_maps') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12" align="center">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-category" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title pull-left">Add Category</h5> -->
            </div>
            <div class="modal-body">
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link adds active" data-toggle="tab" href="#tab_add_category" role="tab">Add</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menulist" data-toggle="tab" href="#tab_list_category" role="tab">List</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active fade show" id="tab_add_category" role="tabpanel">
                            
                        </div>
                        <div class="tab-pane fade" id="tab_list_category" role="tabpanel">
                            <input type="hidden" name="visible" id="visible" value="Y">
                            <input type="hidden" name="sort_table" id="sort_table" value="keyword_id">
                            <input type="hidden" name="order_table" id="order_table" value="desc">
                            <h5>List Category</h5><hr>
                            <div class="tab-container">
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link tab_cat_active active" data-toggle="tab" href="#tab_cat_active" role="tab">Active</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tab_cat_inactive" data-toggle="tab" href="#tab_cat_inactive" role="tab">Inactive</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active fade show" id="tab_cat_active" role="tabpanel">
                                        <div id="data-table_filter" class="dataTables_filter">
                                            <label>Search:
                                                <input type="search" id="search_word" name="search_word" maxlength="50" placeholder="Search for category name..." aria-controls="data-table">
                                            </label>
                                        </div>
                                        <br>
                                        <div id="table_category" class="table-responsive">
                                            <table class="table table-striped table-inverse table-bordered mb-0" id="mytable1" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="catid1">No.</th>
                                                        <th class="cattl1">Category Name</th>
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
                                    <div class="tab-pane fade" id="tab_cat_inactive" role="tabpanel">
                                        <div id="data-table_filter" class="dataTables_filter">
                                            <label>Search:
                                                <input type="search" id="search_word2" name="search_word2" maxlength="50" placeholder="Search for category name..." aria-controls="data-table">
                                            </label>
                                        </div>
                                        <br>
                                        <div id="table_category" class="table-responsive">
                                            <table class="table table-striped table-inverse table-bordered mb-0" id="mytable2" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="catid1">No.</th>
                                                        <th class="cattl1">Category Name</th>
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
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <input class="form-control" type="hidden" name="contentid" id="contentid" required="">
                <button type="button" id="insert_category" class="btn btn-light">Submit</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Edit</h5>
            </div>
            <div class="modal-body">
                <div id="changing-edit">
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button id="update_category" type="button" class="btn btn-light">Update</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-tags" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Add Tags</h5>
            </div>
            <form action="#" method="post" id="form_tags" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">                         
                            <!-- Text input-->
                            <table style="width: 100%" class="table">
                                <thead><tr><th>No.</th><th>Tag</th></tr></thead>
                                <tbody id="table-details">
                                    <tr id="row1" class="jdr1">
                                    <td><span class="btn btn-sm btn-default">1</span><input type="hidden" value="6437" name="count[]"></td>
                                    <td><input type="text" required="" class="form-control input-sm" placeholder="Tag" name="jtag[]"></td>
                                    <td><input type="hidden" value="1" class="form-control input-sm" placeholder="Tag" name="jsort[]"></td>
                                    <td><input type="hidden" value="SIN" class="form-control input-sm" placeholder="Tag" name="jchild[]"></td>
                                    <td><input type="hidden" value="N" class="form-control input-sm" placeholder="Tag" name="jsub[]"></td>
                                    <td><input type="hidden" value="TDL" class="form-control input-sm" placeholder="Tag" name="jref[]"></td>
                                    <td><input type="hidden" value="Y" class="form-control input-sm" placeholder="Tag" name="jvis[]"></td>
                                    <td><input type="hidden" value="NULL" class="form-control input-sm" placeholder="Tag" name="jpar[]"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-primary btn-sm btn-add-more">Add More</button>
                            <button class="btn btn-sm btn-warning btn-remove-detail-row">X<i class="glyphicon glyphicon-remove"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save_tags()" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var selectedCategory = <?= json_encode((array) $selected_category) ?>;
    var selectedTag = <?= json_encode((array) $selected_tag) ?>;

    $(document).ready(function(){
        $('#content_type').select2({
            ajax: {
                url: '<?= base_url() ?>articles/get_content_type',
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
            placeholder: "Select a Content Type",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedContentType) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>articles/get_single_content_type',
                data: { id: selectedContentType },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#content_type').append(option).trigger('change');
                }
            });
        }

        $('#category_article').select2({})

        $('#tags_article').select2({})

        $('#content_type').on('select2:select', function (e) {
            $('#category_article').val(null).trigger('change');
            $('#tags_article').val(null).trigger('change');
            var idcon = $('#content_type').val();
            if (idcon != "" || idcon != null) {
                $('.visibilitys').show();
                $('.visibilitys2').show();
                $('#contentid').val(idcon);
            }
            var category_id = e.params.data.id
            initCategorySelect2(category_id);
            initTagSelect2();
        })

        if (selectedCategory.length > 0) {
            $.ajax({
                url: '<?= base_url("articles/get_multiple_category") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedCategory },
                success: function (response) {
                    response.forEach(function (group) {
                        var option = new Option(group.text, group.id, true, true);
                        $('#category_article').append(option).trigger('change');
                    });
                }
            });
        }

        if (selectedTag.length > 0) {
            $.ajax({
                url: '<?= base_url("articles/get_multiple_tags") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedTag },
                success: function (response) {
                    response.forEach(function (group) {
                        var option = new Option(group.text, group.id, true, true);
                        $('#tags_article').append(option).trigger('change');
                    });
                }
            });
        }
    })

    function initCategorySelect2(category_id) {
        $('#category_article').select2({
            ajax: {
                url: '<?= base_url() ?>articles/get_list_category',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page,
                        category_id: category_id
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
            placeholder: "Select categories",
            templateResult: format,
            templateSelection: formatSelection
        })
    }

    function initTagSelect2() {
        $('#tags_article').select2({
            ajax: {
                url: '<?= base_url() ?>articles/get_tags',
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
            placeholder: "Select tags",
            templateResult: format,
            templateSelection: formatSelection
        })
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

    // manage category dan tags
    $(".adds").click(function(){
        $('#insert_category').css('display', 'block')
    });

    $(".menulist").click(function(){
        $(".tab_cat_active").trigger('click');
    });

    $(".tab_cat_active").click(function(){
        $('#insert_category').css('display', 'none')
        $('#mytable1 tbody').empty();
        var contentid = $('#contentid').val()
        $('#visible').val('Y')
        var visible = $('#visible').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        sortPagination(null,sort_by,order_sort,visible,contentid,0);
        $("#tab_cat_inactive").hide();
        $("#tab_cat_active").show();
    });

    $(".tab_cat_inactive").click(function(){
        $('#insert_category').css('display', 'none')
        $('#mytable2 tbody').empty();
        var contentid = $('#contentid').val()
        $('#visible').val('N')
        var visible = $('#visible').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        sortPagination(null,sort_by,order_sort,visible,contentid,0);
        $("#tab_cat_active").hide();
        $("#tab_cat_inactive").show();
    });

    // Detect pagination click
    $('#pagination').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var visible = $('#visible').val()
        var contentid = $('#contentid').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#search_word').val()
        if (key_search=='') {
            key_search = null
        }
        sortPagination(key_search,sort_by,order_sort,visible,contentid,pageno);
    });

    $('#pagination2').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var visible = $('#visible').val()
        var contentid = $('#contentid').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#search_word').val()
        if (key_search=='') {
            key_search = null
        }
        sortPagination(key_search,sort_by,order_sort,visible,contentid,pageno);
    });

    $("#search_word").keyup(function(){
        var strval =  $("#search_word").val();
        var visible = $('#visible').val()
        var contentid = $('#contentid').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var norow = 0;
        if (strval == "") {
            sortPagination(null,sort_by,order_sort,visible,contentid,0);
        } else {
            sortPagination(strval,sort_by,order_sort,visible,contentid,0)
        }
    });

    $("#search_word2").keyup(function(){
        var strval =  $("#search_word2").val();
        var visible = $('#visible').val()
        var contentid = $('#contentid').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var norow = 0;
        if (strval == "") {
            sortPagination(null,sort_by,order_sort,visible,contentid,0);
        } else {
            sortPagination(strval,sort_by,order_sort,visible,contentid,0)
        }
    });

    function field_sort(key_search,sort_by,order_sort,visible,contentid,pagno) {
        if (order_sort == 'asc') {
            var order_sort = 'desc'
        } else {
            var order_sort = 'asc'
        }
        $('#sort_table').val(sort_by)
        $('#order_table').val(order_sort)
        sort_by = $('#sort_table').val()
        order_sort = $('#order_table').val()
        var key_search = $('#search_word').val()
        var visible = $('#visible').val()
        var contentid = $('#contentid').val()
        if (key_search=='') {
            key_search = null
        }
        sortPagination(key_search,sort_by,order_sort,visible,contentid,pagno)
    }

    function sortPagination(key_search,sort_by,order_sort,visible,contentid,pagno) {
        var sort_by_name = 'keyword_name'
        var statustable = $('#visible').val()
        $.ajax({
            url: '<?=base_url()?>articles/list_category_article/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+contentid+'/'+pagno,
            type: 'get',
            dataType: 'json',
            success: function(response){
                var order_sort = response.order;
                var x = response.x;
                var y = response.y;
                var z = response.z;
                var show = 'Showing '+x+' to '+y+' of '+z+' entries';
                $('#data-table_info').html(show);
                if (statustable=='Y') {
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
                    if (statustable=='Y') {
                        $('#pagination').html(page1);
                    } else {
                        $('#pagination2').html(page1);
                    }
                } else {
                    var pageee = response.pagination
                    if (statustable=='Y') {
                        $('#pagination').html(response.pagination);
                    } else {
                        $('#pagination2').html(response.pagination);
                    }
                }
                $('.catid1').html('<input type="button" class="btn btn-link" value="No." onClick="field_sort(\''+key_search+'\',\''+sort_by+'\',\''+order_sort+'\',\''+visible+'\',\''+contentid+'\','+pagno+')" />')
                $('.cattl1').html('<input type="button" class="btn btn-link" value="Category Name" onClick="field_sort(\''+key_search+'\',\''+sort_by_name+'\',\''+order_sort+'\',\''+visible+'\',\''+contentid+'\','+pagno+')" />')
                createTable(response.result,response.row);
            }
        });
    }

    // Create table list
    function createTable(result,sno){
        var statustable = $('#visible').val()
        if (statustable=='Y') {
            $('#mytable1 tbody').empty();
        } else {
            $('#mytable2 tbody').empty();
        }

        if (result.length > 0) {
            sno = Number(sno);
            for (index in result) {
                var id = result[index].keyword_id;
                var title = result[index].keyword_name;
                sno+=1;
                var base_url ='<?php echo base_url()?>'
                if (result[index].keyword_visible=="N") {
                    var html = '<a onclick="activeConfirm(\''+id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate</a>'
                } else {
                    var html = '<a onclick="inactiveConfirm(\''+id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate</a>'
                }

                var tr = "<tr>";
                tr += "<td>"+ sno +"</td>";
                tr += "<td>"+ title +"</td>";
                tr += "<td><div class='dropdown'><button class='btn btn-light dropdown-toggle' data-toggle='dropdown'>ACTION</button><div class='dropdown-menu dropdown-menu--icon'>"+ html +"<a href='#!' onclick='edit_category(\""+id+"\")' class='dropdown-item'><i class='zmdi zmdi-edit zmdi-hc-fw'></i>Edit</a></div></div></td>";
                tr += "</tr>";
                if (statustable=='Y') {
                    $('#mytable1 tbody').append(tr);
                } else {
                    $('#mytable2 tbody').append(tr);
                }
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="4" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable=='Y') {
                $('#mytable1 tbody').append(tr);
            } else {
                $('#mytable2 tbody').append(tr);
            }
        }
    }

    $(document).on("click","#category",(function(e){
        e.preventDefault();
        $('#insert_category').css('display', 'block')
        $('.nav-tabs a[href="#tab_add_category"]').tab('show');
        var contentid = $('#contentid').val()
        
        var html = `<form action="#" method="post" id="form_category" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Catgeory Name (*required)</label>
                                    <input name="keyword_name" id="keyword_name" type="text" class="form-control" placeholder="Please Input Catgeory Name" value="" required>
                                    <span id="name_val" name="name_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input class="form-control" type="hidden" name="idcontent" id="idcontent" value="${contentid}" required="">
                        </div>`
        $('#tab_add_category').html(html);
    }))

    $("#insert_category").click(function(){
        var self = $('#form_category');
        var name_res = $(self).find('#keyword_name').val();
        if (name_res == '') {
            $('#name_val').text('* Please input your category name');
            $('#name_val').show()
        } else {
            $("#name_val").hide();
        }

        if (name_res!='') {
            $('#insert_category').text('Submit...'); //change button text
            $('#insert_category').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('articles/save_category')?>",
                type: "POST",
                data: $('#form_category').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if(data.error==='0') {
                        alert(data.message);
                        $('#modal-category').modal('hide');
                        $('#insert_category').text('Submit'); //change button text
                        $('#insert_category').attr('disabled',false); //set button enable
                    } else {
                        $('#insert_category').text('Submit'); //change button text
                        $('#insert_category').attr('disabled',false); //set button enable
                        alert(data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Data gagal disimpan, silahkan isi category!');
                    $('#insert_category').text('Submit'); //change button text
                    $('#insert_category').attr('disabled',false); //set button enable 
                }
            });
        }
    });

    function edit_category(id) {
        var html = `<form action="#" method="post" id="form_category_edit" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Catgeory Name (*required)</label>
                                    <input name="keyword_name" id="keyword_name" type="text" class="form-control" placeholder="Please Input Catgeory Name" value="" required>
                                    <span id="name_val" name="name_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input type="hidden" name="keyword_id" id="keyword_id" value="${id}">
                        </div>`
        $('#changing-edit').html(html);

        $.ajax({
            url : "<?php echo site_url('articles/get_data_edit_category');?>",
            method : "POST",
            data :{id:id},
            async : true,
            dataType : 'json',
            success : function(data) {
                var val_name = data[0]['keyword_name']
                $('#form_category_edit [name="keyword_name"]').val(val_name).trigger('change');
            }
        });
        $('#modal-edit').modal('show');
    }

    $("#update_category").click(function(){
        var self = $('#form_category_edit');
        var name_res = $(self).find('#keyword_name').val();
        if (name_res == '') {
            $('#name_val').text('* Please input your category name');
            $('#name_val').show()
        } else {
            $("#name_val").hide();
        }

        if (name_res!='') {
            $('#update_category').text('Submit...'); //change button text
            $('#update_category').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('articles/edit_category')?>",
                type: "POST",
                data: $('#form_category_edit').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.error==='0') {
                        alert(data.message);
                        $('#update_category').text('Submit'); //change button text
                        $('#update_category').attr('disabled',false); //set button enable
                        $('#modal-edit').modal('hide');
                        $(".menulist").trigger('click');
                    } else {
                        $('#update_category').text('Submit'); //change button text
                        $('#update_category').attr('disabled',false); //set button enable
                        alert(data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Data gagal disimpan, silahkan isi category!');
                    $('#update_category').text('Submit'); //change button text
                    $('#update_category').attr('disabled',false); //set button enable 
                }
            });
        }
    });

    function activeConfirm(id) {
        $.ajax({
            url: '<?=base_url()?>articles/active_category',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response) {
                console.log(response.error)
                if (response.error==='0') {
                    $(".menulist").trigger('click');
                }
            }
        });
    }

    function inactiveConfirm(id) {
        $.ajax({
            url: '<?=base_url()?>articles/inactive_category',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response) {
                console.log(response.error)
                if (response.error==='0') {
                    $(".menulist").trigger('click');
                }
            }
        });
    }

    $("body").on('click', '.btn-add-more', function (e) {
        e.preventDefault();
        var $sr = ($(".jdr1").length + 1);
        var rowid = Math.random();
        var $html = '<tr class="jdr1" id="' + rowid + '">' +
                '<td><span class="btn btn-sm btn-default">' + $sr + '</span><input type="hidden" name="count[]" value="'+Math.floor((Math.random() * 10000) + 1)+'"></td>' +
                '<td><input type="text" required="" name="jtag[]" placeholder="tag" class="form-control input-sm"></td>' +
                '<td><input type="hidden" value="1" class="form-control input-sm" placeholder="Tag" name="jsort[]"></td>' +
                '<td><input type="hidden" value="SIN" class="form-control input-sm" placeholder="Tag" name="jchild[]"></td>' +
                '<td><input type="hidden" value="N" class="form-control input-sm" placeholder="Tag" name="jsub[]"></td>' +
                '<td><input type="hidden" value="TDL" class="form-control input-sm" placeholder="Tag" name="jref[]"></td>' +
                '<td><input type="hidden" value="Y" class="form-control input-sm" placeholder="Tag" name="jvis[]"></td>' +
                '<td><input type="hidden" value="NULL" class="form-control input-sm" placeholder="Tag" name="jpar[]"></td>' +
                '</tr>';
        $("#table-details").append($html);
    });
    
    $("body").on('click', '.btn-remove-detail-row', function (e) {
        e.preventDefault();
        if ($("#table-details tr:last-child").attr('id') != 'row1') {
            $("#table-details tr:last-child").remove();
        }
    });

    function save_tags() {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        // ajax adding data to database
        $.ajax({
            url : "<?php echo site_url('articles/save_tags')?>",
            type: "POST",
            data: $('#form_tags').serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#modal-tags').modal('hide');
                    alert("Data Berhasil disimpan");
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                    }
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Data gagal disimpan, silahkan isi category!');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });
    }
    // manage category dan tags

    var selectedContentType = <?= json_encode($selected_content_type ?? '') ?>;
</script>