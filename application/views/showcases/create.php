<style type="text/css">
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
    select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    .contacts__img>img {width: 100px;height: 100px;}
    #changing-contentshowcase .image_picker_image {width: 200px;height: 130px;}
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
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Showcase</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('showcases') ?>">List Showcase</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?= form_open('showcases/create') ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Image (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_landscape" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction1" data-toggle="modal" data-target="#modal-imageshowcase">Upload</a>
                                    <input name="poster_url" id="poster_url" type="hidden" class="form-control" value="<?= set_value('poster_url') ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('poster_url') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category (*required)</label>&nbsp;
                                <a class="btn btn-light btn-sm" data-toggle="modal" name="category" data-target="#modal-category" id="category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Category</a>
                                <select class="form-control" name="category_id" id="category_id" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('category_id') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (*required)</label>
                                <input type="text" name="title" id="title" class="form-control" value="<?= set_value('title') ?>" placeholder="Please input title" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('title') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Barcode URL (*required)</label>
                                <input type="text" name="barcode_url" id="barcode_url" class="form-control" value="<?= set_value('barcode_url') ?>" placeholder="Please input url" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('barcode_url') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="datetimepicker">Start Date (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="start_date" name="start_date" placeholder="Pick a date" class="form-control date-picker" value="<?= set_value('start_date') ?>" readonly>
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('start_date') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="datetimepicker">End Date (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="end_date" name="end_date" placeholder="Pick a date" class="form-control date-picker" value="<?= set_value('end_date') ?>" readonly>
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('end_date') ?></span>
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

<div class="modal fade" id="modal-imageshowcase" tabindex="-1" style="display: none;" aria-hidden="true">
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
                <div id="changing-contentshowcase">
                    <select class='image-picker show-html'>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button id="uploadimageshowcase" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlImage()">Save</button>
                <button id="backimageshowcase" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="row" id='iframe-upload'>
    <form class="form-horizontal" id="form_foto" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="FormControlFile">File Image:</label>
            <input type="file" name="filefoto" class="form-control-file" id="FormControlFile" required>
        </div>
        <button type="button" onclick="uploadFoto()" id="uploadfoto" class="btn btn-primary">Upload Gambar</button>
    </form>
</div>

<div class="modal fade" id="modal-category" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">List Category</h5>
                <hr>
            </div>
            <div class="modal-body">
                <input type="hidden" name="visible_category" id="visible_category" value="Y">
                <input type="hidden" name="sort_table_category" id="sort_table_category" value="id">
                <input type="hidden" name="order_table_category" id="order_table_category" value="desc">
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link tab_category_active active" data-toggle="tab" href="#tab_category_active" role="tab">Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tab_category_inactive" data-toggle="tab" href="#tab_category_inactive" role="tab">Inactive</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active fade show" id="tab_category_active" role="tabpanel">
                            <button class="btn btn-light" name="add_category" id="add_category">Add Category</button>
                            <br>
                            <br>
                            <span class="invalid-feedback" id="wardingsearchactive" name="wardingsearchactive" style="display:none;">minimum 3 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputactive" id="searchinputactive" minlength="3" maxlength="50">
                            <button type="button" name="searchbuttonactive" id="searchbuttonactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrow" id="selectrow" class="btn btn-light">
                                <select name="rowselect" id="rowselect">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <br>
                            <div id="table_category" class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytablecategory1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableactive">
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_category" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination_category'></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_category_inactive" role="tabpanel">
                            <span class="invalid-feedback" id="wardingsearchinactive" name="wardingsearchinactive" style="display:none;">minimum 3 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputinactive" id="searchinputinactive" minlength="3" maxlength="50">
                            <button type="button" name="searchbuttoninactive" id="searchbuttoninactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <br>
                            <div id="table_category" class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytablecategory2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_category2" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination_category2'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-category-cu" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Category</h5>
            </div>
            <div class="modal-body">
                <div id="changing-category">
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button id="crud_category" type="button" class="btn btn-light">Submit</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#iframe-upload').hide();

        $('#category_id').select2({
            ajax: {
                url: '<?= base_url() ?>showcases/get_list_category',
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
            placeholder: "Select a category",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedCategory) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>showcases/get_single_category',
                data: { id: selectedCategory },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#category_id').append(option).trigger('change');
                }
            });
        }

        $("select").imagepicker();

        // image showcase
        $('.callfunction1').click(function() {
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>showcases/compare_image_showcase',
                success: function(data) {
                    var _gallery = "<select class='image-picker show-html'>";
                    data = JSON.parse(data);
                    if (data.error==0) {
                        var content = data.content
                        if (content!=null) {
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1);
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>";
                            }
                        }
                    }
                    _gallery = _gallery + "</select>";
                    setTimeout(function() {
                        $(".loadimage1").fadeOut()
                    }, 500)
                    $('#changing-contentshowcase').html(_gallery);
                    $("select").imagepicker();
                }
            });
        })

        $('#uploadimageshowcase').click(function() {
            $.ajax({
                url: '<?php echo base_url() ?>showcases/get_token',
                success: function(data) {
                    var iframe = $('#iframe-upload').html();
                    $('#changing-contentshowcase')
                        .html(iframe);
                        $('#iframe-upload').removeClass('hide');
                        $('#iframe-upload').css('background-color', '#000000');
                }
            });
        });

        $('#backimageshowcase').click(function() {
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>showcases/compare_image_showcase',
                success: function(data) {
                    var _gallery = "<select class='image-picker show-html'>";
                    data = JSON.parse(data);
                    if (data.error==0) {
                        var content = data.content
                        if (content!=null) {
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1);
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>";
                            }
                        }
                    }
                    _gallery = _gallery + "</select>";
                    setTimeout(function() {
                        $(".loadimage1").fadeOut()
                    }, 500)
                    $('#changing-contentshowcase').html(_gallery);
                    $("select").imagepicker();
                }
            });
        });
        // image showcase

        var lastImageUrlLandscape = "<?= set_value('poster_url') ?>";
        if (lastImageUrlLandscape) {
            $('#img_landscape').attr('src', lastImageUrlLandscape);
        }
    })

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

    function uploadFoto() {
        event.preventDefault();
        var data = new FormData();
        jQuery.each(jQuery('#FormControlFile')[0].files, function(i, file) {
            data.append('filefoto', file);
        });
        var el = $(this);
        var self = $('#form_foto');
        var filefoto_res = $(self).find('#FormControlFile').val();
        var url = 'http://showcase.dens.tv/upload/do_upload_ajax';
        $.ajax({
            type: "POST",
            url: url,
            processData: false,
            contentType: false,
            crossDomain: true,
            // dataType: 'xml',
            data: data,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.response == 200) {
                    alert('Upload image has been successfully!');
                    $('#backimageshowcase').click();
                } else {
                    alert(result.msg);
                }
            }
        });
    }

    function getUrlImage() {
        var img = $('#modal-imageshowcase .image_picker_selector').find('.selected').find('img').attr('src');
        var image = 'http://showcase.dens.tv/assets/images/' + img.replace(/.*\//, '');
        $('#poster_url').val(image);
        $('#img_landscape').attr('src', img);
        $('#modal-imageshowcase').modal('hide');
    }

    $(function () {
        $("#start_date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: false,
            defaultDate: "<?= set_value('start_date') ?>"
        });
    });

    $( function() {
        $("#end_date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: false,
            defaultDate: "<?= set_value('end_date') ?>"
        })
    });

    // management category
    $("#category").click(function(){
        $(".tab_category_active").trigger('click');
    });

    $(".tab_category_active").click(function(){
        $('#mytablecategory1 tbody').empty();
        $('#visible_category').val('Y')
        var visible = $('#visible_category').val()
        var sort_by = $('#sort_table_category').val()
        var order_sort = $('#order_table_category').val()
        var rowperpage = $('#rowselect').val()
        loadPagination(null,sort_by,order_sort,visible,rowperpage,0);
        $("#tab_category_inactive").hide();
        $("#tab_category_active").show();
    });

    $(".tab_category_inactive").click(function(){
        $('#mytablecategory2 tbody').empty();
        $('#visible_category').val('N')
        var visible = $('#visible_category').val()
        var sort_by = $('#sort_table_category').val()
        var order_sort = $('#order_table_category').val()
        var rowperpage = 10
        loadPagination(null,sort_by,order_sort,visible,rowperpage,0);
        $("#tab_category_active").hide();
        $("#tab_category_inactive").show();
    });

    $(document).on("change","#rowselect",function (e) {
        var checkpage = $('.pagination .active span').text()
        var pageno = parseInt(checkpage.replace('(current)(current)',''))
        $('#visible_category').val('Y')
        var visible = $('#visible_category').val()
        var sort_by = $('#sort_table_category').val()
        var order_sort = $('#order_table_category').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = $('#rowselect').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno);
    });

    $('#pagination_category').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var visible = $('#visible_category').val()
        var sort_by = $('#sort_table_category').val()
        var order_sort = $('#order_table_category').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = $('#rowselect').val()
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno);
    });

    $('#pagination_category2').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var visible = $('#visible_category').val()
        var sort_by = $('#sort_table_category').val()
        var order_sort = $('#order_table_category').val()
        var key_search = $('#searchinputinactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = 10
        loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pageno);
    });

    $("#searchbuttonactive").click(function(){
        var search =  $("#searchinputactive").val();
        var length = search.length
        if (length < 3) {
            $("#wardingsearchactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchactive').css("display", "none");
            }, 5000)
        } else {
            var visible = $('#visible_category').val()
            var sort_by = $('#sort_table_category').val()
            var order_sort = $('#order_table_category').val()
            var rowperpage = $('#rowselect').val()
            loadPagination(search,sort_by,order_sort,visible,rowperpage,0)
        }
    });

    $("#searchbuttoninactive").click(function(){
        var search =  $("#searchinputinactive").val();
        var length = search.length
        if (length < 3) {
            $("#wardingsearchinactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchinactive').css("display", "none");
            }, 5000)
        } else {
            var visible = $('#visible_category').val()
            var sort_by = $('#sort_table_category').val()
            var order_sort = $('#order_table_category').val()
            var rowperpage = $('#rowselect').val()
            loadPagination(search,sort_by,order_sort,visible,rowperpage,0)
        }
    });

    $('.tableactive').sortable({
        placeholder : "ui-state-highlight",
        update: function(event, ui) {
            var page_id_array = new Array();
            $('tbody tr').each(function(){
                page_id_array.push($(this).attr('id'));
            });
            $.ajax({
                url:"<?=base_url()?>showcases/update_sort_category",
                method:"POST",
                data:{page_id_array:page_id_array, action:'update'},
                success: function() {
                    $(".tab_category_active").trigger('click');
                }
            })
        }
    });

    $('#rowselect').select2({
        minimumResultsForSearch: Infinity,
        width: '100%',
        dropdownParent: $('#modal-category')
    })

    $('#select_category_active').select2({
        minimumResultsForSearch: Infinity,
        width: '50%',
        dropdownParent: $('#modal-category')
    })

    $('#select_category_inactive').select2({
        minimumResultsForSearch: Infinity,
        width: '50%',
        dropdownParent: $('#modal-category')
    })

    function loadPagination(key_search,sort_by,order_sort,visible,rowperpage,pagno) {
        var statustable = $('#visible_category').val()
        $.ajax({
            url: '<?=base_url()?>showcases/list_category_showcase/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+rowperpage+'/'+pagno,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var order_sort = response.order;
                var x = response.x;
                var y = response.y;
                var z = response.z;
                var show = 'Showing '+x+' to '+y+' of '+z+' entries';
                $('#data-table_category').html(show);
                if (statustable=='Y') {
                    $('#data-table_category').html(show);
                } else {
                    $('#data-table_category2').html(show);
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
                        $('#pagination_category').html(page1);
                    } else {
                        $('#pagination_category2').html(page1);
                    }
                } else {
                    var pageee = response.pagination
                    if (statustable=='Y') {
                        $('#pagination_category').html(response.pagination);
                    } else {
                        $('#pagination_category2').html(response.pagination);
                    }
                }
                createTableCategory(response.result,response.row);
            }
        });
    }

    function createTableCategory(result,sno) {
        var statustable = $('#visible_category').val()
        if (statustable=='Y') {
            $('#mytablecategory1 tbody').empty();
            $("#mytablecategory1 tbody").css("cursor", "all-scroll");
        } else {
            $('#mytablecategory2 tbody').empty();
        }
        if (result.length > 0) {
            sno = Number(sno);
            for (index in result) {
                var id = result[index].id;
                var title = result[index].category_name;
                sno+=1;
                var base_url ='<?php echo base_url()?>'
                if (result[index].visible=="N") {
                    var html = '<a onclick="activeCategoryConfirm(\''+id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate</a>'
                } else {
                    var html = '<a onclick="inactiveCategoryConfirm(\''+id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate</a>'
                }
                var tr = "<tr id='"+id+"'>";
                tr += "<td>"+ sno +"</td>";
                tr += "<td>"+ title +"</td>";
                tr += "<td><div class='dropdown'><button class='btn btn-light dropdown-toggle' data-toggle='dropdown'>ACTION</button><div class='dropdown-menu dropdown-menu--icon'>"+ html +"<a href='#!' onclick='edit_category(\""+id+"\")' class='dropdown-item'><i class='zmdi zmdi-edit zmdi-hc-fw'></i>Edit</a></div></div></td>";
                tr += "</tr>";
                if (statustable=='Y') {
                    $('#mytablecategory1 tbody').append(tr);
                } else {
                    $('#mytablecategory2 tbody').append(tr);
                }
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="3" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable=='Y') {
                $('#mytablecategory1 tbody').append(tr);
            } else {
                $('#mytablecategory2 tbody').append(tr);
            }
        }
    }

    $(document).on("click","#add_category",(function(e){
        e.preventDefault();
        var html = `<form action="#" method="post" id="form_crud_category" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name (*required)</label>
                                    <input name="category_name" id="category_name" type="text" class="form-control" placeholder="Please Input Category Name" value="" required>
                                    <span id="catname_val" name="catname_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input type="hidden" name="cat_id" id="cat_id" value="">
                        </div>`
        $('#changing-category').html(html);
        $('#modal-category-cu').modal('show');
    }))

    $("#crud_category").click(function(){
        var self = $('#form_crud_category');
        var catnameres = $(self).find('#category_name').val();
        if (catnameres == '' || catnameres == null) {
            $('#catname_val').text('* Please input name');
            $('#catname_val').show()
        } else {
            $("#catname_val").hide();
        }
        if (catnameres!='') {
            $('#crud_category').text('Submit...'); //change button text
            $('#crud_category').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('showcases/cu_category')?>",
                type: "POST",
                data: $('#form_crud_category').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.error==='0') {
                        alert(data.message);
                        $('#crud_category').text('Submit');
                        $('#crud_category').attr('disabled',false);
                        $('#modal-category-cu').modal('hide');
                        $(".tab_category_active").trigger('click');
                    } else {
                        $('#crud_category').text('Submit');
                        $('#crud_category').attr('disabled',false);
                        alert(data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Data gagal disimpan, silahkan isi category!');
                    $('#crud_category').text('Submit');
                    $('#crud_category').attr('disabled',false);
                }
            });
        }
    });

    function edit_category(id) {
        var html = `<form action="#" method="post" id="form_crud_category" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name (*required)</label>
                                    <input name="category_name" id="category_name" type="text" class="form-control" placeholder="Please Input Category Name" value="" required>
                                    <span id="catname_val" name="catname_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input type="hidden" name="cat_id" id="cat_id" value="${id}">
                        </div>`
        $('#changing-category').html(html);
        $.ajax({
            url : "<?php echo site_url('showcases/get_data_edit_category');?>",
            method : "POST",
            data :{id:id},
            async : true,
            dataType : 'json',
            success : function(data){
                var val_name = data[0]['category_name']
                $('#form_crud_category [name="category_name"]').val(val_name).trigger('change');
            }
        });
        $('#modal-category-cu').modal('show');
    }

    function activeCategoryConfirm(id) {
        $.ajax({
            url: "<?php echo site_url('showcases/activeCategoryConfirm');?>",
            method: "POST",
            data: {id:id},
            async: true,
            dataType: 'json',
            success: function(data) {
                if (data.error==='0') {
                    $(".tab_category_active").trigger('click');
                } else {
                    alert(data.message);
                }
            }
        });
    }

    function inactiveCategoryConfirm(id) {
        $.ajax({
            url: "<?php echo site_url('showcases/inactiveCategoryConfirm');?>",
            method: "POST",
            data: {id:id},
            async: true,
            dataType: 'json',
            success: function(data) {
                if (data.error==='0') {
                    $(".tab_category_inactive").trigger('click');
                } else {
                    alert(data.message);
                }
            }
        });
    }
    // management category

    var selectedCategory = <?= json_encode($selected_category ?? '') ?>;
</script>