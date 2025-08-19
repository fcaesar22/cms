<style type="text/css">
    #sel_icon {margin-right: 10px;}
    .iconpicker-search {display: none !important;}
    .iconpicker .iconpicker-items {position: relative !important; clear: both !important; float: none !important; padding: 12px 0 0 12px !important; background: #fff !important; margin: 0 !important; overflow: hidden !important; overflow-y: auto !important; min-height: 49px !important; max-height: 246px !important; color: black !important;}
    .iconpicker .iconpicker-item.iconpicker-selected {box-shadow: none !important; color: #fff !important; background: #000 !important;}
    .tested {display: none;}
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    .page-link a {color: white;}
    .catid1 .btn-link {color: white !important; font-weight: 600; cursor: pointer;}
    .cattl1 .btn-link {color: white !important; font-weight: 600; cursor: pointer;}
    #mytable1 td, #mytable1 th {padding: 1rem 0.6rem;}
    #mytable2 td, #mytable2 th {padding: 1rem 0.6rem;}
    #grad1 {height: 28px; width: 80px;}
    #grad1edit {height: 28px; width: 80px;}
    .minicolors-theme-bootstrap .minicolors-swatch {border-style: solid;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Podcast</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('podcasts') ?>">List Podcast</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?= form_open('podcasts/create') ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category (*required)</label>&nbsp;
                                <a class="btn btn-light btn-sm" data-toggle="modal" name="category" data-target="#modal-category" id="category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Category</a>
                                <select class="form-control" name="category_podcast" id="category_podcast" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('category_podcast') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sub Category (*required)</label>&nbsp;
                                <a class="btn btn-light btn-sm tested" data-toggle="modal" name="sub_category" data-target="#modal-subcategory" id="sub_category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Sub Category</a>
                                <select class="form-control" name="sub_category_podcast[]" id="sub_category_podcast" multiple="multiple" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('sub_category_podcast') ?></span>
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
                                <label>Link RSS (*required)</label>
                                <input type="text" name="link_rss" id="link_rss" class="form-control" value="<?= set_value('link_rss') ?>" placeholder="Please Input Link RSS">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('link_rss') ?></span>
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
                                            <table class="table table-responsive table-striped table-inverse table-bordered mb-0" id="mytable1" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="catid1">No.</th>
                                                        <th class="cattl1">Category Name</th>
                                                        <th class="cattl1">Category Icon</th>
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
                                            <table class="table table-responsive table-striped table-inverse table-bordered mb-0" id="mytable2" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="catid1">No.</th>
                                                        <th class="cattl1">Category Name</th>
                                                        <th class="cattl1">Category Icon</th>
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

<div class="modal fade" id="modal-subcategory" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title pull-left">Add Sub Category</h5> -->
            </div>
            <div class="modal-body">
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link addssub active" data-toggle="tab" href="#tab_add_subcategory" role="tab">Add</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menulistsub" data-toggle="tab" href="#tab_list_subcategory" role="tab">List</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active fade show" id="tab_add_subcategory" role="tabpanel">
                            
                        </div>
                        <div class="tab-pane fade" id="tab_list_subcategory" role="tabpanel">
                            <input type="hidden" name="visible_sub" id="visible_sub" value="Y">
                            <input type="hidden" name="sort_tablesub" id="sort_tablesub" value="keyword_id">
                            <input type="hidden" name="order_tablesub" id="order_tablesub" value="desc">
                            <h5>List Category</h5><hr>
                            <div class="tab-container">
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link tab_subcat_active active" data-toggle="tab" href="#tab_subcat_active" role="tab">Active</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tab_subcat_inactive" data-toggle="tab" href="#tab_subcat_inactive" role="tab">Inactive</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active fade show" id="tab_subcat_active" role="tabpanel">
                                        <div id="data-table_filter" class="dataTables_filter">
                                            <label>Search:
                                                <input type="search" id="search_word3" name="search_word3" maxlength="50" placeholder="Search for sub category name..." aria-controls="data-table">
                                            </label>
                                        </div>
                                        <br>
                                        <div id="table_category" class="table-responsive">
                                            <table class="table table-responsive table-striped table-inverse table-bordered mb-0" id="mytable3" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="catid1">No.</th>
                                                        <th class="cattl1">Sub Category Name</th>
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
                                    <div class="tab-pane fade" id="tab_subcat_inactive" role="tabpanel">
                                        <div id="data-table_filter" class="dataTables_filter">
                                            <label>Search:
                                                <input type="search" id="search_word4" name="search_word4" maxlength="50" placeholder="Search for sub category name..." aria-controls="data-table">
                                            </label>
                                        </div>
                                        <br>
                                        <div id="table_category" class="table-responsive">
                                            <table class="table table-responsive table-striped table-inverse table-bordered mb-0" id="mytable4" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="catid1">No.</th>
                                                        <th class="cattl1">Sub Category Name</th>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <input class="form-control" type="hidden" name="contentid" id="contentid" required="">
                <button type="button" id="insert_subcategory" class="btn btn-light">Submit</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-editsub" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Edit</h5>
            </div>
            <div class="modal-body">
                <div id="changing-editsub">
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button id="update_subcategory" type="button" class="btn btn-light">Update</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var selectedSubCategory = <?= json_encode((array) $selected_sub_category) ?>;

    $(document).ready(function(){
        $('#category_podcast').select2({
            ajax: {
                url: '<?= base_url() ?>podcasts/get_list_category',
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
            placeholder: "Select a Category",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedCategory) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>podcasts/get_single_category',
                data: { id: selectedCategory },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#category_podcast').append(option).trigger('change');
                    $('#contentid').val(data.id);
                    $('.tested').show();
                }
            });
        }

        $('#sub_category_podcast').select2({})

        $('#category_podcast').on('select2:select', function (e) {
            $('#sub_category_podcast').val(null).trigger('change');
            var idcon = $('#category_podcast').val();
            if (idcon != "" || idcon != null) {
                $('.tested').show();
                $('#contentid').val(idcon);
            }
            var category_id = e.params.data.id
            initSubCategorySelect2(category_id);
        })

        if (selectedSubCategory.length > 0) {
            $.ajax({
                url: '<?= base_url("podcasts/get_multiple_sub_category") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedSubCategory },
                success: function (response) {
                    response.forEach(function (group) {
                        var option = new Option(group.text, group.id, true, true);
                        $('#sub_category_podcast').append(option).trigger('change');
                    });
                }
            });
        }
    })

    function initSubCategorySelect2(category_id) {
        $('#sub_category_podcast').select2({
            ajax: {
                url: '<?= base_url() ?>podcasts/get_list_sub_category',
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
            placeholder: "Select a Sub Category",
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

    $(".adds").click(function(){
        $('#insert_category').css('display', 'block')
    });

    $(document).on("click","#category",(function(e){
        e.preventDefault();
        $('#insert_category').css('display', 'block')
        $('.nav-tabs a[href="#tab_add_category"]').tab('show');
        var html = `<form action="#" method="post" id="form_category" enctype="multipart/form-data" autocomplete="off">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" name="keyword_namecategory" id="keyword_namecategory" placeholder="Category name" required="">
                                    <span id="name_val" name="name_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="margin-right: 80px;" class="control-label" for="parameterValue">Select Icon <button id="delicon1" name="delicon1" type="button" class="btn btn-default btn-sm"><i class="far fa-trash-alt" id="delicon2" name="delicon2"></i></button></label>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default iconpicker-component"><i class="" id="val_icon" name="val_icon"></i></button>
                                        <button type="button" class="icp icp-auto btn btn-default dropdown-toggle" data-selected="fa-car" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button>
                                        <div class="dropdown-menu"></div>
                                    </div>
                                    <br>
                                    <span id="icon_val" name="icon_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Background Image</label><br>
                                    <label for="name">Color 1</label>
                                    <input type="text" id="color1" name="color1" class="form-control demo" data-swatches="#ef9a9a|#90caf9|#a5d6a7|#fff59d|#ffcc80|#bcaaa4|#eeeeee|#f44336|#2196f3|#4caf50|#ffeb3b|#ff9800|#795548|#9e9e9e" value="">
                                    <label for="name">Color 2</label>
                                    <input type="text" id="color2" name="color2" class="form-control demo" data-swatches="#ef9a9a|#90caf9|#a5d6a7|#fff59d|#ffcc80|#bcaaa4|#eeeeee|#f44336|#2196f3|#4caf50|#ffeb3b|#ff9800|#795548|#9e9e9e" value="">
                                    <div id="grad1"></div>
                                    <span id="color_val" name="color_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input class="form-control" name="icon_category" id="icon_category" value="" type="hidden">
                        </div>`
        $('#tab_add_category').html(html);

        $('#delicon1').on('click', function () {
            $('[name="icon_category"]').val(null);
            $('#val_icon').get(0).className = "";
        });

        $(function () {
            $('.icp-auto').iconpicker();

            $('.icp').on('iconpickerSelected', function (e) {
                $('#icon_category').val(e.iconpickerValue);
            });
        });

        $('#color1').minicolors({
            swatches: $('#color1').attr('data-swatches') ? $('#color1').attr('data-swatches').split('|') : [],
            change: function(value, opacity) {
                if ( !value ) return;
                if ( opacity ) value += ', ' + opacity;
                if ( typeof console === 'object' ) {
                    var col1 = $('#color1').val()
                    var col2 = $('#color2').val()
                    if (col1 != null && col1 != "" && col2 != null && col2 != "") {
                        $('#grad1').css('background-image', 'linear-gradient(to right, '+col1+' , '+col2+')');
                        $('#grad1').css('border-style', 'solid');
                    } else {
                        $('#grad1').css('background-image', 'none');
                        $('#grad1').css('border-style', 'none');
                    }
                }
            },
            theme: 'bootstrap'
        });

        $('#color2').minicolors({
            swatches: $('#color2').attr('data-swatches') ? $('#color2').attr('data-swatches').split('|') : [],
            change: function(value, opacity) {
                if ( !value ) return;
                if ( opacity ) value += ', ' + opacity;
                if ( typeof console === 'object' ) {
                    var col1 = $('#color1').val()
                    var col2 = $('#color2').val()
                    if (col1 != null && col1 != "" && col2 != null && col2 != "") {
                        $('#grad1').css('background-image', 'linear-gradient(to right, '+col1+' , '+col2+')');
                        $('#grad1').css('border-style', 'solid');
                    } else {
                        $('#grad1').css('background-image', 'none');
                        $('#grad1').css('border-style', 'none');
                    }
                }
            },
            theme: 'bootstrap' // or any other theme you want to use
        });

        var imageUrl = '<?=base_url()?>assets/css/jquery.minicolors.png';
        $('.minicolors-sprite').css('background-image', 'url(' + imageUrl + ')');
    }))

    $("#insert_category").click(function(){
        var self = $('#form_category');
        var name_res = $(self).find('#keyword_namecategory').val();
        var icon_res = $(self).find('#icon_category').val();
        var color1_res = $(self).find('#color1').val();
        var color2_res = $(self).find('#color2').val();
        if (name_res == "" || name_res == null){
            $('#name_val').text('* Please input your category name');
            $('#name_val').show()
        } else {
            $("#name_val").hide();
        }

        if (icon_res == "" || icon_res == null){
            $('#icon_val').text('* Please Please select icon');
            $('#icon_val').show()
        } else {
            $("#icon_val").hide();
        }

        if (color1_res == "" || color1_res == null && color2_res == "" || color2_res == null){
            $('#color_val').text('* Please select color');
            $('#color_val').show()
            var flag_color = false
        } else {
            $("#color_val").hide();
            var flag_color = true
        }

        if (name_res!="" && icon_res!="" && flag_color==true) {
            $('#insert_category').text('Submit...'); //change button text
            $('#insert_category').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('podcasts/save_category')?>",
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
        } else {
            alert('silahkan lengkapi data')
        }
    });

    $(".menulist").click(function(){
        $(".tab_cat_active").trigger('click');
    });

    $(".tab_cat_active").click(function(){
        $('#insert_category').css('display', 'none')
        $('#mytable1 tbody').empty();
        $('#visible').val('Y')
        var visible = $('#visible').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        sortPagination(null,sort_by,order_sort,visible,0);
        $("#tab_cat_inactive").hide();
        $("#tab_cat_active").show();
    });

    $(".tab_cat_inactive").click(function(){
        $('#insert_category').css('display', 'none')
        $('#mytable2 tbody').empty();
        $('#visible').val('N')
        var visible = $('#visible').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        sortPagination(null,sort_by,order_sort,visible,0);
        $("#tab_cat_active").hide();
        $("#tab_cat_inactive").show();
    });

    // Detect pagination click
    $('#pagination').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var visible = $('#visible').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#search_word').val()
        if (key_search=='') {
            key_search = null
        }
        sortPagination(key_search,sort_by,order_sort,visible,pageno);
    });

    $('#pagination2').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var visible = $('#visible').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#search_word').val()
        if (key_search=='') {
            key_search = null
        }
        sortPagination(key_search,sort_by,order_sort,visible,pageno);
    });

    // ajax search
    $("#search_word").keyup(function(){
        var strval =  $("#search_word").val();
        var visible = $('#visible').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var norow = 0;
        if (strval == "") {
            sortPagination(null,sort_by,order_sort,visible,0);
        } else {
            sortPagination(strval,sort_by,order_sort,visible,0)
        }
    });

    $("#search_word2").keyup(function(){
        var strval =  $("#search_word2").val();
        var visible = $('#visible').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var norow = 0;
        if (strval == "") {
            sortPagination(null,sort_by,order_sort,visible,0);
        } else {
            sortPagination(strval,sort_by,order_sort,visible,0)
        }
    });

    function field_sort(key_search,sort_by,order_sort,visible,pagno) {
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
        if (key_search=='') {
            key_search = null
        }
        sortPagination(key_search,sort_by,order_sort,visible,pagno)
    }

    function sortPagination(key_search,sort_by,order_sort,visible,pagno) {
        var sort_by_name = 'keyword_name'
        var statustable = $('#visible').val()
        $.ajax({
            url: '<?=base_url()?>podcasts/list_category_podcast/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+pagno,
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
                $('.catid1').html('<input type="button" class="btn btn-link" value="No." onClick="field_sort(\''+key_search+'\',\''+sort_by+'\',\''+order_sort+'\',\''+visible+'\','+pagno+')" />')
                $('.cattl1').html('<input type="button" class="btn btn-link" value="Category Name" onClick="field_sort(\''+key_search+'\',\''+sort_by_name+'\',\''+order_sort+'\',\''+visible+'\','+pagno+')" />')
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
                var icon = result[index].icon;
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
                tr += "<td><button type='button' class='btn btn-default btn-sm'><i class='"+ icon +"'></i></button></td>";
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

    function edit_category(id) {
        var html = `<form action="#" method="post" id="form_category_edit" autocomplete="off">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" name="keyword_namecategory" id="keyword_namecategory" placeholder="Category name" required="">
                                    <span id="name_edit_val" name="name_edit_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="parameterValue">Select Icon <button id="delicon1" name="delicon1" type="button" class="btn btn-default btn-sm"><i class="far fa-trash-alt" id="delicon2" name="delicon2"></i></button></label><br>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default iconpicker-component"><i class="" id="val_icon" name="val_icon"></i></button>
                                        <button type="button" class="icp icp-auto btn btn-default dropdown-toggle" data-selected="fa-car" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button>
                                        <div class="dropdown-menu"></div>
                                    </div>
                                    <input class="form-control" name="icon_category" id="icon_category" value="" type="hidden">
                                    <br>
                                    <span id="icon_edit_val" name="icon_edit_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Background Image</label><br>
                                    <label for="name">Color 1</label>
                                    <input type="text" id="color1edit" name="color1edit" class="form-control demo" data-swatches="#ef9a9a|#90caf9|#a5d6a7|#fff59d|#ffcc80|#bcaaa4|#eeeeee|#f44336|#2196f3|#4caf50|#ffeb3b|#ff9800|#795548|#9e9e9e" value="">
                                    <label for="name">Color 2</label>
                                    <input type="text" id="color2edit" name="color2edit" class="form-control demo" data-swatches="#ef9a9a|#90caf9|#a5d6a7|#fff59d|#ffcc80|#bcaaa4|#eeeeee|#f44336|#2196f3|#4caf50|#ffeb3b|#ff9800|#795548|#9e9e9e" value="">
                                    <div id="grad1edit"></div>
                                    <span id="color_edit_val" name="color_edit_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input type="hidden" name="keyword_id" id="keyword_id" value="${id}">
                        </div>`
        $('#changing-edit').html(html);

        $('#form_category_edit #delicon1').on('click', function () {
            $('#form_category_edit [name="icon_category"]').val(null);
            $('#form_category_edit #val_icon').get(0).className = "";
        });

        $(function () {
            $('#form_category_edit .icp-auto').iconpicker();

            $('#form_category_edit .icp').on('iconpickerSelected', function (e) {
                $('#form_category_edit #icon_category').val(e.iconpickerValue);
            });
        });

        $.ajax({
            url : "<?php echo site_url('podcasts/get_data_edit_category');?>",
            method : "POST",
            data :{id:id},
            async : true,
            dataType : 'json',
            success : function(data) {
                var val_name = data[0]['keyword_name']
                var val_icon = data[0]['icon']
                var val_col = data[0]['color_background']
                if (val_col!=null||val_col!="") {
                    var checkcolor = val_col.split(',')
                    var countcolor = checkcolor.length
                    var colorfirst = null
                    var colorsecond = null
                    if (countcolor==4) {
                        var colorfirst = checkcolor[1]
                        var colorsecond = checkcolor[2]
                    }
                    if (countcolor==2) {
                        var colorfirst = checkcolor[0]
                        var colorsecond = checkcolor[1]
                    }
                    $('#form_category_edit [name="color1edit"]').val(colorfirst).trigger('change');
                    $('#form_category_edit [name="color2edit"]').val(colorsecond).trigger('change');
                    $('#color1edit').minicolors('value', colorfirst);
                    $('#color2edit').minicolors('value', colorsecond);
                    $('#grad1edit').css('background-image', 'linear-gradient(to right, '+colorfirst+' , '+colorsecond+')');
                }
                $('#form_category_edit [name="keyword_namecategory"]').val(val_name).trigger('change');
                $('#form_category_edit [name="icon_category"]').val(val_icon).trigger('change');
                $('#form_category_edit #val_icon').get(0).className = ""+val_icon+"";
            }
        });

        $('#color1edit').minicolors({
            swatches: $('#color1edit').attr('data-swatches') ? $('#color1edit').attr('data-swatches').split('|') : [],
            change: function(value, opacity) {
                if ( !value ) return;
                if ( opacity ) value += ', ' + opacity;
                if ( typeof console === 'object' ) {
                    var col1 = $('#color1edit').val()
                    var col2 = $('#color2edit').val()
                    if (col1 != null && col1 != "" && col2 != null && col2 != "") {
                        $('#grad1edit').css('background-image', 'linear-gradient(to right, '+col1+' , '+col2+')');
                        $('#grad1edit').css('border-style', 'solid');
                    } else {
                        $('#grad1edit').css('background-image', 'none');
                        $('#grad1edit').css('border-style', 'none');
                    }
                }
            },
            theme: 'bootstrap' // or any other theme you want to use
        });

        $('#color2edit').minicolors({
            swatches: $('#color2edit').attr('data-swatches') ? $('#color2edit').attr('data-swatches').split('|') : [],
            change: function(value, opacity) {
                if ( !value ) return;
                if ( opacity ) value += ', ' + opacity;
                if ( typeof console === 'object' ) {
                    var col1 = $('#color1edit').val()
                    var col2 = $('#color2edit').val()
                    if (col1 != null && col1 != "" && col2 != null && col2 != "") {
                        $('#grad1edit').css('background-image', 'linear-gradient(to right, '+col1+' , '+col2+')');
                        $('#grad1edit').css('border-style', 'solid');
                    } else {
                        $('#grad1edit').css('background-image', 'none');
                        $('#grad1edit').css('border-style', 'none');
                    }
                }
            },
            theme: 'bootstrap' // or any other theme you want to use
        });
        var imageUrl = '<?=base_url()?>assets/css/jquery.minicolors.png';
        $('.minicolors-sprite').css('background-image', 'url(' + imageUrl + ')');
        $('#modal-edit').modal('show');
    }

    $("#update_category").click(function(){
        var self = $('#form_category_edit');
        var name_res = $(self).find('#keyword_namecategory').val();
        var icon_res = $(self).find('#icon_category').val();
        var color1_res = $(self).find('#color1edit').val();
        var color2_res = $(self).find('#color2edit').val();
        if (name_res == "" || name_res == null){
            $('#name_edit_val').text('* Please input your category name');
            $('#name_edit_val').show()
        } else {
            $("#name_edit_val").hide();
        }
        if (icon_res == "" || icon_res == null) {
            $('#icon_edit_val').text('* Please select icon');
            $('#icon_edit_val').show()
        } else {
            $("#icon_edit_val").hide();
        }
        if (color1_res == "" || color1_res == null && color2_res == "" || color2_res == null) {
            $('#color_edit_val').text('* Please select color');
            $('#color_edit_val').show()
            var flag_color = false
        } else {
            $("#color_edit_val").hide();
            var flag_color = true
        }
        if (name_res!="" && icon_res!="" && flag_color==true) {
            $('#update_category').text('Submit...'); //change button text
            $('#update_category').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('podcasts/edit_category')?>",
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
        } else {
            alert('silahkan lengkapi data')
        }
    });

    function activeConfirm(id) {
        $.ajax({
            url: '<?=base_url()?>podcasts/active_category',
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
            url: '<?=base_url()?>podcasts/inactive_category',
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

    $(".addssub").click(function(){
        $('#insert_subcategory').css('display', 'block')
    });

    $(document).on("click","#sub_category",(function(e){
        e.preventDefault();
        var conid = $('#contentid').val()
        $('#insert_subcategory').css('display', 'block')
        $('.nav-tabs a[href="#tab_add_subcategory"]').tab('show');
        var html = `<form action="#" method="post" id="form_sub" enctype="multipart/form-data" autocomplete="off">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" name="keyword_namesubcategory" id="keyword_namesubcategory" placeholder="Sub Category name" required="">
                                    <span id="namesub_val" name="namesub_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input class="form-control" type="hidden" name="contentidparent" id="contentidparent" value="${conid}" required="">
                        </div>`
        $('#tab_add_subcategory').html(html);
    }))

    $("#insert_subcategory").click(function(){
        var self = $('#form_sub');
        var name_res = $(self).find('#keyword_namesubcategory').val();
        if (name_res == '') {
            $('#namesub_val').text('* Please input your sub category name');
            $('#namesub_val').show()
        } else {
            $("#namesub_val").hide();
        }
        if (name_res!='') {
            $('#insert_subcategory').text('Submit...'); //change button text
            $('#insert_subcategory').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('podcasts/save_sub_category')?>",
                type: "POST",
                data: $('#form_sub').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.error==='0') {
                        alert(data.message);
                        $('#modal-subcategory').modal('hide');
                        $('#insert_subcategory').text('Submit'); //change button text
                        $('#insert_subcategory').attr('disabled',false); //set button enable
                    } else {
                        $('#insert_subcategory').text('Submit'); //change button text
                        $('#insert_subcategory').attr('disabled',false); //set button enable
                        alert(data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Data gagal disimpan, silahkan isi category!');
                    $('#insert_subcategory').text('Submit'); //change button text
                    $('#insert_subcategory').attr('disabled',false); //set button enable 
                }
            });
        }
    });

    $(".menulistsub").click(function(){
        $(".tab_subcat_active").trigger('click');
    });

    $(".tab_subcat_active").click(function(){
        $('#insert_subcategory').css('display', 'none')
        $('#mytable3 tbody').empty();
        $('#visible_sub').val('Y')
        var conid = $('#contentid').val()
        var visible = $('#visible_sub').val()
        var sort_by = $('#sort_tablesub').val()
        var order_sort = $('#order_tablesub').val()
        sortPaginationsub(null,sort_by,order_sort,visible,conid,0);
        $("#tab_subcat_inactive").hide();
        $("#tab_subcat_active").show();
    });

    $(".tab_subcat_inactive").click(function(){
        $('#insert_subcategory').css('display', 'none')
        $('#mytable4 tbody').empty();
        $('#visible_sub').val('N')
        var conid = $('#contentid').val()
        var visible = $('#visible_sub').val()
        var sort_by = $('#sort_tablesub').val()
        var order_sort = $('#order_tablesub').val()
        sortPaginationsub(null,sort_by,order_sort,visible,conid,0);
        $("#tab_subcat_active").hide();
        $("#tab_subcat_inactive").show();
    });

    // Detect pagination click
    $('#pagination3').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var conid = $('#contentid').val()
        var visible = $('#visible_sub').val()
        var sort_by = $('#sort_tablesub').val()
        var order_sort = $('#order_tablesub').val()
        var key_search = $('#search_word3').val()
        if (key_search=='') {
            key_search = null
        }
        sortPaginationsub(key_search,sort_by,order_sort,visible,conid,pageno);
    });

    $('#pagination4').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var conid = $('#contentid').val()
        var visible = $('#visible_sub').val()
        var sort_by = $('#sort_tablesub').val()
        var order_sort = $('#order_tablesub').val()
        var key_search = $('#search_word4').val()
        if (key_search=='') {
            key_search = null
        }
        sortPaginationsub(key_search,sort_by,order_sort,visible,conid,pageno);
    });

    // ajax search
    $("#search_word3").keyup(function(){
        var strval =  $("#search_word3").val();
        var conid = $('#contentid').val()
        var visible = $('#visible_sub').val()
        var sort_by = $('#sort_tablesub').val()
        var order_sort = $('#order_tablesub').val()
        var norow = 0;
        if (strval == "") {
            sortPaginationsub(null,sort_by,order_sort,visible,conid,0);
        } else {
            sortPaginationsub(strval,sort_by,order_sort,visible,conid,0)
        }
    });

    $("#search_word4").keyup(function(){
        var strval =  $("#search_word4").val();
        var conid = $('#contentid').val()
        var visible = $('#visible_sub').val()
        var sort_by = $('#sort_tablesub').val()
        var order_sort = $('#order_tablesub').val()
        var norow = 0;
        if (strval == "") {
            sortPaginationsub(null,sort_by,order_sort,visible,conid,0);
        } else {
            sortPaginationsub(strval,sort_by,order_sort,visible,conid,0)
        }
    });

    function field_sortsub(key_search,sort_by,order_sort,visible,pagno) {
        if (order_sort == 'asc') {
            var order_sort = 'desc'
        } else {
            var order_sort = 'asc'
        }
        var conid = $('#contentid').val()
        $('#sort_tablesub').val(sort_by)
        $('#order_tablesub').val(order_sort)
        sort_by = $('#sort_tablesub').val()
        order_sort = $('#order_tablesub').val()
        var key_search = $('#search_word3').val()
        var visible = $('#visible_sub').val()
        if (key_search=='') {
            key_search = null
        }
        sortPaginationsub(key_search,sort_by,order_sort,visible,conid,pagno)
    }

    function sortPaginationsub(key_search,sort_by,order_sort,visible,conid,pagno) {
        var sort_by_name = 'keyword_name'
        var statustable = $('#visible_sub').val()
        $.ajax({
            url: '<?=base_url()?>podcasts/list_sub_category_podcast/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+'/'+conid+'/'+pagno,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var order_sort = response.order;
                var x = response.x;
                var y = response.y;
                var z = response.z;
                var show = 'Showing '+x+' to '+y+' of '+z+' entries';
                $('#data-table_info3').html(show);
                if (statustable=='Y') {
                    $('#data-table_info3').html(show);
                } else {
                    $('#data-table_info4').html(show);
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
                        $('#pagination3').html(page1);
                    } else {
                        $('#pagination4').html(page1);
                    }
                } else {
                    var pageee = response.pagination
                    if (statustable=='Y') {
                        $('#pagination3').html(response.pagination);
                    } else {
                        $('#pagination4').html(response.pagination);
                    }
                }
                $('.catid1').html('<input type="button" class="btn btn-link" value="No." onClick="field_sortsub(\''+key_search+'\',\''+sort_by+'\',\''+order_sort+'\',\''+visible+'\',\''+conid+'\','+pagno+')" />')
                $('.cattl1').html('<input type="button" class="btn btn-link" value="Category Name" onClick="field_sortsub(\''+key_search+'\',\''+sort_by_name+'\',\''+order_sort+'\',\''+visible+'\',\''+conid+'\','+pagno+')" />')
                createTableSub(response.result,response.row);
            }
        });
    }

    // Create table list
    function createTableSub(result,sno) {
        var statustable = $('#visible_sub').val()
        if (statustable=='Y') {
            $('#mytable3 tbody').empty();
        } else {
            $('#mytable4 tbody').empty();
        }
        if (result.length > 0) {
            sno = Number(sno);
            for (index in result) {
                var id = result[index].keyword_id;
                var title = result[index].keyword_name;
                sno+=1;
                var base_url ='<?php echo base_url()?>'
                if (result[index].keyword_visible=="N") {
                    var html = '<a onclick="activeConfirmSub(\''+id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate</a>'
                } else {
                    var html = '<a onclick="inactiveConfirmSub(\''+id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate</a>'
                }
                var tr = "<tr>";
                tr += "<td>"+ sno +"</td>";
                tr += "<td>"+ title +"</td>";
                tr += "<td><div class='dropdown'><button class='btn btn-light dropdown-toggle' data-toggle='dropdown'>ACTION</button><div class='dropdown-menu dropdown-menu--icon'>"+ html +"<a href='#!' onclick='edit_categorysub(\""+id+"\")' class='dropdown-item'><i class='zmdi zmdi-edit zmdi-hc-fw'></i>Edit</a></div></div></td>";
                tr += "</tr>";
                if (statustable=='Y') {
                    $('#mytable3 tbody').append(tr);
                } else {
                    $('#mytable4 tbody').append(tr);
                }
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="3" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable=='Y') {
                $('#mytable3 tbody').append(tr);
            } else {
                $('#mytable4 tbody').append(tr);
            }
        }
    }

    function edit_categorysub(id) {
        var conid = $('#contentid').val()
        var html = `<form action="#" method="post" id="form_subcategory_edit" autocomplete="off">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" name="keyword_namesubcategory" id="keyword_namesubcategory" placeholder="Sub Category name" required="">
                                    <span id="namesub_val" name="namesub_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input class="form-control" type="hidden" name="contentidparent" id="contentidparent" value="${conid}" required="">
                            <input type="hidden" name="keyword_id" id="keyword_id" value="${id}">
                        </div>`
        $('#changing-editsub').html(html);
        $.ajax({
            url : "<?php echo site_url('podcasts/get_data_edit_subcategory');?>",
            method : "POST",
            data :{id:id},
            async : true,
            dataType : 'json',
            success : function(data) {
                var val_name = data[0]['keyword_name']
                $('#form_subcategory_edit [name="keyword_namesubcategory"]').val(val_name).trigger('change');
            }
        });
        $('#modal-editsub').modal('show');
    }

    $("#update_subcategory").click(function(){
        var self = $('#form_subcategory_edit');
        var name_res = $(self).find('#keyword_namesubcategory').val();
        if (name_res == '') {
            $('#namesub_val').text('* Please input your sub category name');
            $('#namesub_val').show()
        } else {
            $("#namesub_val").hide();
        }

        if (name_res!='') {
            $('#update_subcategory').text('Submit...'); //change button text
            $('#update_subcategory').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('podcasts/edit_subcategory')?>",
                type: "POST",
                data: $('#form_subcategory_edit').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.error==='0') {
                        alert(data.message);
                        $('#update_subcategory').text('Submit'); //change button text
                        $('#update_subcategory').attr('disabled',false); //set button enable
                        $('#modal-editsub').modal('hide');
                        $(".menulistsub").trigger('click');
                    } else {
                        $('#update_subcategory').text('Submit'); //change button text
                        $('#update_subcategory').attr('disabled',false); //set button enable
                        alert(data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Data gagal disimpan, silahkan isi category!');
                    $('#update_subcategory').text('Submit'); //change button text
                    $('#update_subcategory').attr('disabled',false); //set button enable 
                }
            });
        }
    });

    function activeConfirmSub(id) {
        $.ajax({
            url: '<?=base_url()?>podcasts/active_category',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response) {
                if (response.error==='0') {
                    $(".menulistsub").trigger('click');
                }
            }
        });
    }

    function inactiveConfirmSub(id) {
        $.ajax({
            url: '<?=base_url()?>podcasts/inactive_category',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response) {
                if (response.error==='0') {
                    $(".menulistsub").trigger('click');
                }
            }
        });
    }

    var selectedCategory = <?= json_encode($selected_category ?? '') ?>;
</script>