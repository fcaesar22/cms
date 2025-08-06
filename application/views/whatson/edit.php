<style type="text/css">
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
    select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 200px;height: 130px;}
    #changing-contentimage2 .image_picker_image {width: 130px;height: 130px;}
    #changing-contentimage3 .image_picker_image {width: 200px;height: 130px;}
    .contacts__img>img {width: 100px;height: 100px;}
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    .page-link a {color: white;}
    .catid1 .btn-link {color: white !important; font-weight: 600; cursor: pointer;}
    .cattl1 .btn-link {color: white !important; font-weight: 600; cursor: pointer;}
    .catdes1 .btn-link {color: white !important; font-weight: 600; cursor: pointer;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>What's On</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('whatsons') ?>">What's On</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>','</div>'); ?>
                <?= form_open('whatsons/edit/'.$whatson->whatson_id) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (*required)</label>
                                <input type="text" name="whatson_title" id="whatson_title" class="form-control" value="<?= set_value('whatson_title', $whatson->whatson_title) ?>" placeholder="Please Input Title" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('whatson_title') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description (*required)</label>
                                <textarea name="whatson_description" id="whatson_description" class="form-control" rows="1" placeholder="Please Input Description" required><?= set_value('whatson_description', $whatson->whatson_description) ?></textarea>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('whatson_description') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image Landscape (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_landscape" src="<?= $whatson->whatson_image ? 'https://picture.dens.tv/wp/img/whatson_v2/1280x720/' . $whatson->whatson_image : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-imagelandscape">Upload</a>
                                    <input name="whatson_image" id="whatson_image" type="hidden" class="form-control" value="<?= set_value('whatson_image', 'https://picture.dens.tv/wp/img/whatson_v2/1280x720/' . $whatson->whatson_image) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('whatson_image') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image Potrait (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_potrait" src="<?= $whatson->whatson_image_potrait ? $whatson->whatson_image_potrait : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction2" data-toggle="modal" data-target="#modal-imagepotrait">Upload</a>
                                    <input name="whatson_image_potrait" id="whatson_image_potrait" type="hidden" class="form-control" value="<?= set_value('whatson_image_potrait', $whatson->whatson_image_potrait) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('whatson_image_potrait') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type(*required)</label>
                                <select class="form-control" name="whatson_type" id="whatson_type" required>
                                    <option value="">Select a type</option>
                                    <option value="1" <?= set_select('whatson_type', '1', $whatson->whatson_type == 1) ?>>Text</option>
                                    <option value="2" <?= set_select('whatson_type', '2', $whatson->whatson_type == 2) ?>>Image</option>
                                    <option value="3" <?= set_select('whatson_type', '3', $whatson->whatson_type == 3) ?>>Video</option>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('whatson_type') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>What's On Video</label>
                                <input type="text" name="whatson_video" id="whatson_video" class="form-control" value="<?= set_value('whatson_video', $whatson->whatson_video) ?>" placeholder="Please Input Video">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('whatson_video') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category (*required)</label>&nbsp;
                                <button id="add_items" type="button" class="btn btn-light btn-sm" data-cat="category" data-toggle="modal" data-target="#modal-category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Category</button>
                                <select class="form-control" name="category_whatson" id="category_whatson" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('category_whatson') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sub Category (*required)</label>&nbsp;
                                <button id="add_items" type="button" class="btn btn-light btn-sm" data-cat="sub_category" data-toggle="modal" data-target="#modal-category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Sub Category</button>
                                <select class="form-control" name="sub_category_whatson" id="sub_category_whatson" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('sub_category_whatson') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Channel (*required)</label>&nbsp;
                                <button id="add_items" type="button" class="btn btn-light btn-sm" data-cat="channel" data-toggle="modal" data-target="#modal-category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Channel</button>
                                <select class="form-control" name="channel_whatson" id="channel_whatson" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('channel_whatson') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Thumbnail (*required)</label>
                                <select class="form-control" name="thumbnail_whatson" id="thumbnail_whatson" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('thumbnail_whatson') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Content ID (*required)</label>
                                <input type="text" name="content_id" id="content_id" class="form-control" value="<?= set_value('content_id', $whatson->content_id) ?>" placeholder="Please Input Content ID" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('content_id') ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="datetimepicker">Schedule Time (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon test"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="whatson_schedule" name="whatson_schedule" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('whatson_schedule', $whatson->whatson_schedule_time) ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('whatson_schedule') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Link Go To URL</label>
                                <input type="text" name="link_goto" id="link_goto" class="form-control" value="<?= set_value('link_goto', $whatson->link_url) ?>" placeholder="Please Input Link URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('link_goto') ?></span>
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

<div class="modal fade" id="modal-imagepotrait" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Select an image</h5>
            </div>
            <div class="modal-body">
                <div class="page-loader loadimage2">
                    <div class="page-loader__spinner">
                        <svg viewBox="25 25 50 50">
                            <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                        </svg>
                    </div>
                </div>
                <div id="changing-contentimage2">
                    <select class='image-picker show-html'>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button id="uploadimagepotrait" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlPotrait()">Save</button>
                <button id="backimagepotrait" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-category" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title pull-left">Category</h5> -->
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
                            <input type="hidden" name="sort_table" id="sort_table" value="category_whatson_id">
                            <input type="hidden" name="order_table" id="order_table" value="desc">
                            <div id="data-table_filter" class="dataTables_filter">
                                <label>Search:
                                    <input type="search" id="search_word" name="search_word" maxlength="50" placeholder="Search for what's on title..." aria-controls="data-table">
                                </label>
                            </div>
                            <br>
                            <div id="table_category" class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytable1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="catid1">No.</th>
                                            <th class="cattl1">Title</th>
                                            <th class="catdes1">Description</th>
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
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button id="insert_category" type="button" class="btn btn-light">Submit</button>
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

<div class="modal fade" id="modal-imagechannel" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Select an image</h5>
            </div>
            <div class="modal-body">
                <div class="page-loader loadimage3">
                    <div class="page-loader__spinner">
                        <svg viewBox="25 25 50 50">
                            <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                        </svg>
                    </div>
                </div>
                <input type="hidden" name="pos_info" id="pos_info" value="">
                <div id="changing-contentimage3">
                    <select class='image-picker show-html'>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button id="uploadimagelogo" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlLogo()">Save</button>
                <button id="backimagelogo" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#whatson_type').select2();

        const selectedCategory = <?= json_encode($whatson->category_whatson_id) ?>;

        $('#category_whatson').select2({
            ajax: {
                url: '<?= base_url() ?>whatsons/get_list_category',
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
                url: '<?= base_url() ?>whatsons/get_single_category',
                data: { id: selectedCategory },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    let option = new Option(data.text, data.id, true, true);
                    $('#category_whatson').append(option).trigger('change');
                }
            });
        }

        const selectedSubCategory = <?= json_encode($whatson->sub_category_whatson_id) ?>;

        $('#sub_category_whatson').select2({
            ajax: {
                url: '<?= base_url() ?>whatsons/get_list_subcategory',
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
            placeholder: "Select a sub category",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedSubCategory) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>whatsons/get_single_sub_category',
                data: { id: selectedSubCategory },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#sub_category_whatson').append(option).trigger('change');
                }
            });
        }

        const selectedChannel = <?= json_encode($whatson->channel_whatson_id) ?>;

        $('#channel_whatson').select2({
            ajax: {
                url: '<?= base_url() ?>whatsons/get_list_channel',
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
            placeholder: "Select a channel",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedChannel) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>whatsons/get_single_channel',
                data: { id: selectedChannel },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#channel_whatson').append(option).trigger('change');
                }
            });
        }

        const selectedThumbnail = <?= json_encode($whatson->thumbnail_whatson_id) ?>;

        $('#thumbnail_whatson').select2({
            ajax: {
                url: '<?= base_url() ?>whatsons/get_list_thumbnail',
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
            placeholder: "Select a thumbnail",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedThumbnail) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>whatsons/get_single_thumbnail',
                data: { id: selectedThumbnail },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#thumbnail_whatson').append(option).trigger('change');
                }
            });
        }

        $("select").imagepicker();

        // image landscape
        $('.callfunction').click(function(){
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>whatsons/compare_image_landscape',
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

        $('#uploadimagelandscape').click(function(){
            $.ajax({
                url: '<?php echo base_url() ?>whatsons/get_token',
                success: function(data) {
                    $('#changing-contentimage1')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backimagelandscape').click(function(){
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>whatsons/compare_image_landscape',
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

        // image potrait
        $('.callfunction2').click(function(){
            $(".loadimage2").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>whatsons/compare_image_portrait',
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
                    setTimeout(function(){$(".loadimage2").fadeOut()},500)
                    $('#changing-contentimage2').html(_gallery);
                    $("select").imagepicker();
                }
            });
        })

        $('#uploadimagepotrait').click(function(){
            $.ajax({
                url: '<?php echo base_url() ?>whatsons/get_token',
                success: function(data) {
                    $('#changing-contentimage2')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=375&h=375&pw=252&ph=252&token='+data+'&thumb=50&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backimagepotrait').click(function(){
            $(".loadimage2").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>whatsons/compare_image_portrait',
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
                    setTimeout(function(){$(".loadimage2").fadeOut()},500)
                    $('#changing-contentimage2').html(_gallery);
                    $("select").imagepicker();
                }
            });
        });
        // image potrait

        // image logo channel
        $('.image_channel').click(function(){
            $(".loadimage3").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>whatsons/compare_image_landscape',
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
                    setTimeout(function(){$(".loadimage3").fadeOut()},500)
                    $('#changing-contentimage3').html(_gallery);
                    $("select").imagepicker();
                }
            });
        })

        $('#uploadimagelogo').click(function(){
            $.ajax({
                url: '<?php echo base_url() ?>whatsons/get_token',
                success: function(data) {
                    $('#changing-contentimage3')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backimagelogo').click(function(){
            $(".loadimage3").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>whatsons/compare_image_landscape',
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
                    setTimeout(function(){$(".loadimage3").fadeOut()},500)
                    $('#changing-contentimage3').html(_gallery);
                    $("select").imagepicker();
                }
            });
        });
        // image logo channel

        var lastImageUrlLandscape = "<?= set_value('whatson_image') ?>";
        if (lastImageUrlLandscape) {
            $('#img_landscape').attr('src', lastImageUrlLandscape);
        }

        var lastImageUrlPortrait = "<?= set_value('whatson_image_potrait') ?>";
        if (lastImageUrlPortrait) {
            $('#img_potrait').attr('src', lastImageUrlPortrait);
        }

        $( function() {
            let flatpickrInstance = flatpickr("#whatson_schedule", {
                enableTime: true,
                time_24hr: true,
                enableSeconds: true,
                minuteIncrement: 1,
                dateFormat: "Y-m-d H:i:S",
            });

            $("#whatson_schedule").prop('readonly', false);

            var initialDate = "<?= isset($whatson->whatson_schedule_time) ? $whatson->whatson_schedule_time : '' ?>";

            if (initialDate) {
                flatpickrInstance.setDate(initialDate, true);
            }
        });
    })

    function getUrlLandscape() {
        var image = $('#modal-imagelandscape .image_picker_selector').find('.selected').find('img').attr('src');
        $('#whatson_image').val(image);
        $('#img_landscape').attr('src',image);
        $('#modal-imagelandscape').modal('hide');
    }

    function getUrlPotrait() {
        var image = $('#modal-imagepotrait .image_picker_selector').find('.selected').find('img').attr('src');
        $('#whatson_image_potrait').val(image);
        $('#img_potrait').attr('src',image);
        $('#modal-imagepotrait').modal('hide');
    }

    function getUrlLogo() {
        var image = $('#modal-imagechannel .image_picker_selector').find('.selected').find('img').attr('src');
        var images = image.replace(/.*\//, '');
        var pos = $('#pos_info').val()
        if (pos==='addform') {
            $('#form_category #channel_whatson_logo').val(images);
            $('#form_category #img_logo').attr('src',image);
        } else {
            $('#form_edit #channel_whatson_logo').val(images);
            $('#form_edit #img_logo_edit').attr('src',image);
        }
        $('#modal-imagechannel').modal('hide');
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

    $(document).on("click","#add_items",(function(e) {
        e.preventDefault();
        $('#pos_info').val('addform')
        $('#insert_category').css('display', 'block')
        $('.nav-tabs a[href="#tab_add_category"]').tab('show');
        var page = $(this).data();
        var ele = page.cat
        $('#sort_table').val(ele)
        if (ele==='category') {
            var url_path = 'add_category'
            var title = 'Category Title'
            var desc = 'Category Description'
            var titlenameid = 'category_whatson_name'
            var descnameid = 'category_whatson_description'
            var table = 'category_whatson'
        } else if (ele==='sub_category') {
            var url_path = 'add_sub_category'
            var title = 'Sub Category Title'
            var desc = 'Sub Category Description'
            var titlenameid = 'sub_category_whatson_name'
            var descnameid = 'sub_category_whatson_description'
            var table = 'sub_category_whatson'
        } else if (ele==='channel') {
            var url_path = 'add_channel'
            var title = 'Channel Title'
            var desc = 'Channel Description'
            var titlenameid = 'channel_whatson_name'
            var descnameid = 'channel_whatson_description'
            var table = 'channel_whatson'
        }
        var html = `<form action="#" method="post" id="form_category" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>${title} (*required)</label>
                                    <input name="${titlenameid}" id="${titlenameid}" type="text" class="form-control" placeholder="Please Input Title" value="" required>
                                    <span id="name_val" name="name_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input type="hidden" name="table_info" id="table_info" value="${table}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>${desc} (*required)</label>
                                    <input name="${descnameid}" id="${descnameid}" type="text" class="form-control" placeholder="Please Input Description" value="" required>
                                    <span id="desc_val" desc="desc_val" style="color: red;"></span>
                                </div>
                            </div>`
        if (ele==='channel') {
            var html = html + `<div class="col-md-6">
                                <div class="form-group">
                                    <label>Channel Logo (*required)</label>
                                    <div class="contacts__item">
                                        <a class="contacts__img">
                                            <img id="img_logo" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                        </a>
                                        <a class="btn btn-light image_channel" data-toggle="modal" data-target="#modal-imagechannel">Upload</a>
                                        <input name="channel_whatson_logo" id="channel_whatson_logo" type="hidden" class="form-control" placeholder="Please Input Name" value="">
                                        <br><span id="img_val" img="img_val" style="color: red;"></span>
                                    </div>
                                </div>
                            </div>`
        }
        var html = html + `</div>`
        $('#tab_add_category').html(html);
    }))

    $(document).on("click",".image_channel",(function(e){
       $("#backimagelogo").trigger('click'); 
    }))

    $("#insert_category").click(function(){
        var self = $('#form_category');
        var table_info = $(self).find('#table_info').val();
        if (table_info==='category_whatson') {
            var name_res = $(self).find('#category_whatson_name').val();
            var desc_res = $(self).find('#category_whatson_description').val();
        } else if (table_info==='sub_category_whatson') {
            var name_res = $(self).find('#sub_category_whatson_name').val();
            var desc_res = $(self).find('#sub_category_whatson_description').val();
        } else if (table_info==='channel_whatson') {
            var name_res = $(self).find('#channel_whatson_name').val();
            var desc_res = $(self).find('#channel_whatson_description').val();
            var img_res = $(self).find('#channel_whatson_logo').val();
            if (img_res == '') {
                $('#img_val').text('* Please upload image');
                $('#img_val').show()
            } else {
                $('#img_val').hide()
            }
        }
        if (name_res == '') {
            $('#name_val').text('* Please input your name');
            $('#name_val').show()
        } else {
            $("#name_val").hide();
        }

        if (desc_res == '') {
            $('#desc_val').text('* Please input your description');
            $('#desc_val').show()
        } else {
            $("#desc_val").hide();
        }

        if (name_res!='' && desc_res!='') {
            $('#insert_category').text('Submit...'); //change button text
            $('#insert_category').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('whatsons/add_category')?>",
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

    $(".adds").click(function(){
        $('#pos_info').val('addform')
        $('#insert_category').css('display', 'block')
    });

    $(".menulist").click(function(){
        $('#insert_category').css('display', 'none')
        $('#mytable1 tbody').empty();
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        sortPagination(null,sort_by,order_sort,0);
    });

    // Detect pagination click
    $('#pagination').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#search_word').val()
        if (key_search=='') {
            key_search = null
        }
        sortPagination(key_search,sort_by,order_sort,pageno);
    });

    // ajax search
    $("#search_word").keyup(function(){
        var strval =  $("#search_word").val();
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var norow = 0;
        if(strval == "") {
            sortPagination(null,sort_by,order_sort,0);
        } else {
            sortPagination(strval,sort_by,order_sort,0)
        }
    });

    function test_sort(key_search,sort_by,order_sort,pagno) {
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
        if (key_search=='') {
            key_search = null
        }
        sortPagination(key_search,sort_by,order_sort,pagno)
    }

    // Load pagination
    function sortPagination(key_search,sort_by,order_sort,pagno) {
        if (sort_by==='category') {
            sort_by = 'category_whatson_id'
            sort_by_name = 'category_whatson_name'
            sort_by_desc = 'category_whatson_description'
            table = 'category_whatson'
        } else if (sort_by==='sub_category') {
            sort_by = 'sub_category_whatson_id'
            sort_by_name = 'sub_category_whatson_name'
            sort_by_desc = 'sub_category_whatson_description'
            table = 'sub_category_whatson'
        } else if (sort_by==='channel') {
            sort_by = 'channel_whatson_id'
            sort_by_name = 'channel_whatson_name'
            sort_by_desc = 'channel_whatson_description'
            table = 'channel_whatson'
        }
        $.ajax({
            url: '<?=base_url()?>whatsons/list_category_whatson/'+key_search+'/'+sort_by+'/'+order_sort+'/'+table+'/'+pagno,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var order_sort = response.order;
                var x = response.x;
                var y = response.y;
                var z = response.z;
                var show = 'Showing '+x+' to '+y+' of '+z+' entries';
                $('#data-table_info').html(show);
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
                    $('#pagination').html(page1);
                } else {
                    var pageee = response.pagination
                    $('#pagination').html(response.pagination);
                }
                $('.catid1').html('<input type="button" class="btn btn-link" value="No." onClick="test_sort(\''+key_search+'\',\''+sort_by+'\',\''+order_sort+'\','+pagno+')" />')
                $('.cattl1').html('<input type="button" class="btn btn-link" value="Title" onClick="test_sort(\''+key_search+'\',\''+sort_by_name+'\',\''+order_sort+'\','+pagno+')" />')
                $('.catdes1').html('<input type="button" class="btn btn-link" value="Description" onClick="test_sort(\''+key_search+'\',\''+sort_by_desc+'\',\''+order_sort+'\','+pagno+')" />')
                createTable(response.result,response.row);
            }
        });
    }

    // Create table list
    function createTable(result,sno) {
        $('#mytable1 tbody').empty();
        if (result.length > 0) {
            sno = Number(sno);
            for(index in result){
                var id = result[index].id;
                var title = result[index].name;
                var content = result[index].description;
                content = content.substr(0, 60) + " ...";
                sno+=1;
                var base_url ='<?php echo base_url()?>'
                if (result[index].deleted=="1") {
                    var html = '<a onclick="activeConfirm(\''+id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate</a>'
                } else {
                    var html = '<a onclick="inactiveConfirm(\''+id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate</a>'
                }

                var tr = "<tr>";
                tr += "<td>"+ sno +"</td>";
                tr += "<td>"+ title +"</td>";
                tr += "<td>"+ content +"</td>";
                tr += "<td><div class='dropdown'><button class='btn btn-light dropdown-toggle' data-toggle='dropdown'>ACTION</button><div class='dropdown-menu dropdown-menu--icon'>"+ html +"<a href='#!' onclick='edit_category(\""+id+"\")' class='dropdown-item'><i class='zmdi zmdi-edit zmdi-hc-fw'></i>Edit</a></div></div></td>";
                tr += "</tr>";
                $('#mytable1 tbody').append(tr);
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="4" class="dataTables_empty">No matching records found</td></tr>`
            $('#mytable1 tbody').append(tr);
        }
    }

    function inactiveConfirm(id) {
        var cat = $('#sort_table').val()
        if (cat==='category') {
            var seq = 'category_whatson_id'
            var table = 'category_whatson'
        } else if (cat==='sub_category') {
            var seq = 'sub_category_whatson_id'
            var table = 'sub_category_whatson'
        } else if (cat==='channel') {
            var seq = 'channel_whatson_id'
            var table = 'channel_whatson'
        }

        $.ajax({
            url: '<?=base_url()?>whatsons/inactive_category',
            type: 'post',
            data: {id:id,field:seq,table:table},
            dataType: 'json',
            success: function(response) {
                console.log(response.error)
                if (response.error==='0') {
                    $(".menulist").trigger('click');
                }
            }
        });
    }

    function edit_category(id) {
        $('#pos_info').val('editform')
        var ele = $('#sort_table').val()
        if (ele==='category') {
            var url_path = 'add_category'
            var title = 'Category Title'
            var desc = 'Category Description'
            var titlenameid = 'category_whatson_name'
            var descnameid = 'category_whatson_description'
            var table = 'category_whatson'
            var seq = 'category_whatson_id'
        } else if (ele==='sub_category') {
            var url_path = 'add_sub_category'
            var title = 'Sub Category Title'
            var desc = 'Sub Category Description'
            var titlenameid = 'sub_category_whatson_name'
            var descnameid = 'sub_category_whatson_description'
            var table = 'sub_category_whatson'
            var seq = 'sub_category_whatson_id'
        } else if (ele==='channel') {
            var url_path = 'add_channel'
            var title = 'Channel Title'
            var desc = 'Channel Description'
            var titlenameid = 'channel_whatson_name'
            var descnameid = 'channel_whatson_description'
            var table = 'channel_whatson'
            var seq = 'channel_whatson_id'
        }

        var html = `<form action="#" method="post" id="form_edit" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>${title} (*required)</label>
                                    <input name="${titlenameid}" id="${titlenameid}" type="text" class="form-control" placeholder="Please Input Title" value="" required>
                                    <span id="name_val" name="name_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input type="hidden" name="${seq}" id="${seq}" value="${id}">
                            <input type="hidden" name="table_info" id="table_info" value="${table}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>${desc} (*required)</label>
                                    <input name="${descnameid}" id="${descnameid}" type="text" class="form-control" placeholder="Please Input Description" value="" required>
                                    <span id="desc_val" desc="desc_val" style="color: red;"></span>
                                </div>
                            </div>`
        if (ele==='channel') {
            var html = html + `<div class="col-md-6">
                                <div class="form-group">
                                    <label>Channel Logo (*required)</label>
                                    <div class="contacts__item">
                                        <a class="contacts__img">
                                            <img id="img_logo_edit" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                        </a>
                                        <a class="btn btn-light image_channel" data-toggle="modal" data-target="#modal-imagechannel">Upload</a>
                                        <input name="channel_whatson_logo" id="channel_whatson_logo" type="hidden" class="form-control" placeholder="Please Input Name" value="">
                                        <br><span id="img_val" img="img_val" style="color: red;"></span>
                                    </div>
                                </div>
                            </div>`
        }
        var html = html + `</div>`
        $('#changing-edit').html(html);

        $.ajax({
            url : "<?php echo site_url('whatsons/get_data_edit_category');?>",
            method : "POST",
            data :{id:id,name:titlenameid,desc:descnameid,seq:table+'_id',table:table},
            async : true,
            dataType : 'json',
            success : function(data){
                var val_name = data[titlenameid]
                var val_desc = data[descnameid]
                if (table==='channel_whatson') {
                    var val_img = data['channel_whatson_logo']
                    var src_img = 'https://picture.dens.tv/wp/img/whatson_v2/1280x720/'+val_img
                    $('#img_logo_edit').attr('src',src_img);
                    $('#form_edit [name="channel_whatson_logo"]').val(val_img).trigger('change');
                }
                $('#form_edit [name="'+titlenameid+'"]').val(val_name).trigger('change');
                $('#form_edit [name="'+descnameid+'"]').val(val_desc).trigger('change');
            }
        });
        $('#modal-edit').modal('show');
    }

    $("#update_category").click(function(){
        var self = $('#form_edit');
        var table_info = $(self).find('#table_info').val();
        if (table_info==='category_whatson') {
            var name_res = $(self).find('#category_whatson_name').val();
            var desc_res = $(self).find('#category_whatson_description').val();
        } else if (table_info==='sub_category_whatson') {
            var name_res = $(self).find('#sub_category_whatson_name').val();
            var desc_res = $(self).find('#sub_category_whatson_description').val();
        } else if (table_info==='channel_whatson') {
            var name_res = $(self).find('#channel_whatson_name').val();
            var desc_res = $(self).find('#channel_whatson_description').val();
            var img_res = $(self).find('#channel_whatson_logo').val();
            if (img_res == '') {
                $('#img_val').text('* Please upload image');
                $('#img_val').show()
            } else {
                $('#img_val').hide()
            }
        }
        if (name_res == '') {
            $('#name_val').text('* Please input your name');
            $('#name_val').show()
        } else {
            $("#name_val").hide();
        }

        if (desc_res == '') {
            $('#desc_val').text('* Please input your description');
            $('#desc_val').show()
        } else {
            $("#desc_val").hide();
        }

        if (name_res!='' && desc_res!='') {
            $('#update_category').text('Submit...'); //change button text
            $('#update_category').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('whatsons/edit_category')?>",
                type: "POST",
                data: $('#form_edit').serialize(),
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

    var selectedCategory = <?= json_encode($selected_category ?? '') ?>;
    var selectedSubCategory = <?= json_encode($selected_sub_category ?? '') ?>;
    var selectedChannel = <?= json_encode($selected_channel ?? '') ?>;
    var selectedThumbnail = <?= json_encode($selected_thumbnail ?? '') ?>;
</script>