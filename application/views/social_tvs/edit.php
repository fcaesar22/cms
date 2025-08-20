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
    .catid1 .btn-link {color: white !important; font-weight: 600; cursor: pointer;}
    .cattl1 .btn-link {color: white !important; font-weight: 600; cursor: pointer;}
    select{display: block !important;}
    select.image-picker{margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 200px;height: 130px;}
    .contacts__img>img{width: 100px;height: 100px;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Social TV</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('social_tvs') ?>">List Social TV</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?= form_open('social_tvs/edit/'.$socialtv['socialtv_id']) ?>
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
                                <select class="form-control" name="category_social_tv[]" id="category_social_tv" multiple="multiple" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('category_social_tv') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Source (*required)</label>
                                <select class="form-control" name="source" id="source" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('source') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Channel ID (*required)</label>
                                <input type="text" name="channel_id" id="channel_id" class="form-control" value="<?= set_value('channel_id', $socialtv['channel_id']) ?>" placeholder="Please Input Source" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('channel_id') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (*required)</label>
                                <input type="text" name="title" id="title" class="form-control" value="<?= set_value('title', $socialtv['socialtv_name']) ?>" placeholder="Please Input Title" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('title') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description (*required)</label>
                                <textarea name="description" id="description" class="form-control" rows="1" placeholder="Please Input Description" required><?= set_value('description', $socialtv['description']) ?></textarea>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('description') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Image Landscape (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_landscape" src="<?= $socialtv['posters'][0]['poster_url'] ? $socialtv['posters'][0]['poster_url'] : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-imagelandscape">Upload</a>
                                    <input name="poster_content1" id="poster_content1" type="hidden" class="form-control" value="<?= set_value('poster_content1', $socialtv['posters'][0]['poster_url']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('poster_content1') ?></span>
                                    <input name="poster_content2" id="poster_content2" type="hidden" class="form-control" value="<?= set_value('poster_content2', $socialtv['posters'][1]['poster_url']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('poster_content2') ?></span>
                                    <input name="poster_content3" id="poster_content3" type="hidden" class="form-control" value="<?= set_value('poster_content3', $socialtv['posters'][2]['poster_url']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('poster_content3') ?></span>
                                    <input type="hidden" class="form-control" id='poster_id1' name="poster_id1" value="<?= set_value('poster_id1', $socialtv['posters'][0]['poster_id']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('poster_id1') ?></span>
                                    <input type="hidden" class="form-control" id='poster_id2' name="poster_id2" value="<?= set_value('poster_id2', $socialtv['posters'][1]['poster_id']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('poster_id2') ?></span>
                                    <input type="hidden" class="form-control" id='poster_id3' name="poster_id3" value="<?= set_value('poster_id3', $socialtv['posters'][2]['poster_id']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('poster_id3') ?></span>
                                </div>
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

<script type="text/javascript">
    var selectedContentType = <?= json_encode($selected_content_type ?? '') ?>;
    var selectedCategory = <?= json_encode($selected_category ?? []) ?>;
    var selectedSource = <?= json_encode($selected_source ?? '') ?>;

    $(document).ready(function(){
        $('#content_type').select2({
            ajax: {
                url: '<?= base_url() ?>social_tvs/get_content_type',
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
                url: '<?= base_url() ?>social_tvs/get_single_content_type',
                data: { id: selectedContentType },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#content_type').append(option).trigger('change');
                    $('#contentid').val(selectedContentType);
                    initCategorySelect2(selectedContentType);
                }
            });
        }

        $('#category_social_tv').select2({})

        $('#content_type').on('select2:select', function (e) {
            $('#category_social_tv').val(null).trigger('change');
            var idcon = $('#content_type').val();
            if (idcon != "" || idcon != null) {
                $('.visibilitys').show();
                $('#contentid').val(idcon);
            }
            var category_id = e.params.data.id
            initCategorySelect2(category_id);
        })

        if (selectedCategory.length > 0) {
            $.ajax({
                url: '<?= base_url("social_tvs/get_multiple_category") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedCategory },
                success: function (response) {
                    response.forEach(function (group) {
                        var option = new Option(group.text, group.id, true, true);
                        $('#category_social_tv').append(option).trigger('change');
                    });
                }
            });
        }

        $('#source').select2({
            ajax: {
                url: '<?= base_url() ?>social_tvs/get_source',
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
            placeholder: "Select a Source",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedSource) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>social_tvs/get_single_source',
                data: { id: selectedSource },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#source').append(option).trigger('change');
                }
            });
        }

        $("select").imagepicker();

        // image landscape
        $('.callfunction').click(function () {
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>social_tvs/compare_image_landscape',
                success: function(data) {
                    data = JSON.parse(data);
                    var _gallery = "<select class='image-picker show-html'>";
                    if (data.error==0) {
                        var content = data.content
                        if (content!=null) {
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1);
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>";
                            }
                        }
                    }
                    _gallery = _gallery+"</select>";
                    setTimeout(function(){$(".loadimage1").fadeOut()},500)
                    $('#changing-contentimage1').html(_gallery);
                    $("select").imagepicker();
                }
            });
        })

        $('#uploadimagelandscape').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>social_tvs/get_token',
                success: function(data) {
                    $('#changing-contentimage1')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=socialtv_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backimagelandscape').click(function () {
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>social_tvs/compare_image_landscape',
                success: function(data) {
                    data = JSON.parse(data);
                    var _gallery = "<select class='image-picker show-html'>";
                    if (data.error==0) {
                        var content = data.content
                        if (content!=null) {
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1);
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>";
                            }
                        }
                    }
                    _gallery = _gallery+"</select>";
                    setTimeout(function(){$(".loadimage1").fadeOut()},500)
                    $('#changing-contentimage1').html(_gallery);
                    $("select").imagepicker();
                }
            });
        });
        // image landscape

        var lastImageUrlLandscape = "<?= set_value('poster_content1') ?>";
        if (lastImageUrlLandscape) {
            $('#img_landscape').attr('src', lastImageUrlLandscape);
        }
    })

    function initCategorySelect2(category_id) {
        $('#category_social_tv').select2({
            ajax: {
                url: '<?= base_url() ?>social_tvs/get_list_category',
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

    function getUrlLandscape() {
        var img = $('#modal-imagelandscape .image_picker_selector').find('.selected').find('img').attr('src');
        var image = 'http://picture.dens.tv/wp/img/socialtv_v1/1280x720/'+img.replace(/.*\//, '');
        var images = 'http://picture.dens.tv/wp/img/socialtv_v1/1280x720/thumbnail/'+img.replace(/.*\//, '');
        $('#poster_content1').val(image);
        $('#poster_content2').val(images);
        $('#poster_content3').val(images);
        $('#img_landscape').attr('src',img);
        $('#modal-imagelandscape').modal('hide');
    }

    // manage category
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

    // ajax search
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
            url: '<?=base_url()?>social_tvs/list_category_social_tv/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+'/'+contentid+'/'+pagno,
            type: 'get',
            dataType: 'json',
            success: function(response) {
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
    function createTable(result,sno) {
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
        if (name_res == ''){
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
                url : "<?php echo site_url('social_tvs/save_category')?>",
                type: "POST",
                data: $('#form_category').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.error==='0') {
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
            url : "<?php echo site_url('social_tvs/get_data_edit_category');?>",
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
        if (name_res == ''){
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
                url : "<?php echo site_url('social_tvs/edit_category')?>",
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
            url: '<?=base_url()?>social_tvs/active_category',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response) {
                if (response.error==='0') {
                    $(".menulist").trigger('click');
                }
            }
        });
    }

    function inactiveConfirm(id) {
        $.ajax({
            url: '<?=base_url()?>social_tvs/inactive_category',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response) {
                if (response.error==='0') {
                    $(".menulist").trigger('click');
                }
            }
        });
    }
    // manage category
</script>