<style type="text/css">
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
    select.image-picker {margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 200px;height: 130px;}
    #changing-contentimage2 .image_picker_image {width: 130px;height: 200px;}
    #changing-contentimage3 .image_picker_image {width: 200px;height: 130px;}
    .contacts__img>img {width: 100px;height: 100px;}
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
    #tbody-tooltip {position: absolute; padding: 6px 12px; background: #fff; color: #333; border-radius: 4px; font-size: 13px; font-weight: 500; box-shadow: 0 2px 6px rgba(0,0,0,0.3); pointer-events: none; white-space: nowrap; z-index: 2000; display: none;}
    #modal-category .dropdown-menu {background-color: #222323;}
    #searchinputkeywordactive, #searchinputkeywordinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 60%; color: white; background: transparent;}
    #searchbuttonkeywordactive, #searchbuttonkeywordinactive {float: left; width: 20%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrowkeywordactive, #selectrowkeywordinactive {float: left; width: 20%; padding: 5px; color: white; font-size: 12px; border: 1px solid gray; border-left: none; cursor: pointer; margin-bottom: 10px;}
    .schedule-option {padding: 4px 0;}
    #tooltipBtn {position: absolute; padding: 6px 12px; background: #fff; color: #333; border-radius: 4px; font-size: 13px; font-weight: 500; box-shadow: 0 2px 6px rgba(0,0,0,0.3); pointer-events: none; white-space: nowrap; z-index: 2000; display: none;}
    .label-with-icon {display: flex; align-items: center; margin-bottom: 5px;}
    .label-with-icon label {margin-bottom: 0 !important;}
    .info-select-wrapper .select2-container {width: 25px !important; height: 25px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; vertical-align: middle !important; margin-left: 6px; background-color: rgba(255, 255, 255, .125) !important; border-radius: 50% !important; color: white; cursor: pointer !important;}
    .info-select-wrapper .select2-selection--single {border: none !important; background: transparent !important; width: 28px !important; height: 28px !important; padding: 0 !important;}
    .info-select-wrapper .select2-selection__rendered::before {content: "\f1f7"; font-family: 'Material-Design-Iconic-Font'; font-size: 1.1rem; color: #fff; display: inline-block; text-align: center; width: 100%; line-height: 0px;}
    .info-select-wrapper .select2-container--default .select2-selection--single:before {display: none;}
    .info-select-wrapper .select2-container--default .select2-selection--single .select2-selection__clear {display: none !important;}
    .select2-container.select2-container--default.select2-container--open .select2-dropdown.dropdown-program-custom,
    .select2-dropdown.dropdown-program-custom {width: 400px !important; min-width: 320px !important;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Catch Up Schedule</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('catchup_schedules') ?>">Catch Up Schedule</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>','</div>'); ?>
                <?= form_open('catchup_schedules/edit/'.$catchup['id_top_tvshow']) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Category TV Show (*required)</label>&nbsp;
                                <button id="addCategory" name="addCategory" type="button" class="btn btn-light btn-sm" data-cat="category" data-toggle="modal" data-target="#modal-category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Category</button>
                                <select class="form-control" name="toptvshow_category" id="toptvshow_category" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('toptvshow_category') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category Channel (*required)</label>
                                <select class="form-control" name="channel_category" id="channel_category" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('channel_category') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Channel (*required)</label>
                                <select class="form-control" name="channel_id" id="channel_id" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('channel_id') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (*required)</label>
                                <input type="text" name="toptvshow_title" id="toptvshow_title" class="form-control" value="<?= set_value('toptvshow_title', $catchup['title']) ?>" placeholder="Please Input Title" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('toptvshow_title') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description (*required)</label>
                                <textarea name="toptvshow_description" id="toptvshow_description" class="form-control" rows="1" placeholder="Please Input Description" required><?= set_value('toptvshow_description', $catchup['description']) ?></textarea>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('toptvshow_description') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Trailer URL</label>
                                <input type="text" name="trailer_url" id="trailer_url" class="form-control" value="<?= set_value('trailer_url', $catchup['trailer_url']) ?>" placeholder="Please Input Link URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('trailer_url') ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="label-with-icon">
                                    <label for="datetimepicker">Start Time (*required)</label>
                                    <span class="info-select-wrapper" id="info-select-wrapper">
                                        <select class="form-control" name="list_schedule" id="list_schedule"></select>
                                    </span>
                                    <span id="starttime_val" class="notify" style="color: red"></span>
                                </div>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="start_date" name="start_date" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('start_date', $catchup['start_date']) ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('start_date') ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="datetimepicker">End Date (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="end_date" name="end_date" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('end_date', $catchup['end_date']) ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('end_date') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Banner Image Landscape (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_landscape" src="<?= $catchup['banner_image'] ? $catchup['banner_image'] : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-imagelandscape">Upload</a>
                                    <input name="banner_image_landscape" id="banner_image_landscape" type="hidden" class="form-control" value="<?= set_value('banner_image_landscape', $catchup['banner_image']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('banner_image_landscape') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Banner Image Portrait (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_potrait" src="<?= $catchup['banner_image_potrait'] ? $catchup['banner_image_potrait'] : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction2" data-toggle="modal" data-target="#modal-imagepotrait">Upload</a>
                                    <input name="banner_image_portrait" id="banner_image_portrait" type="hidden" class="form-control" value="<?= set_value('banner_image_portrait', $catchup['banner_image_potrait']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('banner_image_portrait') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pop Up Image (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_popup" src="<?= $catchup['popup_image'] ? $catchup['popup_image'] : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction3" data-toggle="modal" data-target="#modal-imagepopup">Upload</a>
                                    <input name="popup_image" id="popup_image" type="hidden" class="form-control" value="<?= set_value('popup_image', $catchup['popup_image']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('popup_image') ?></span>
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

<div class="modal fade" id="modal-imagepopup" tabindex="-1" style="display: none;" aria-hidden="true">
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
                <div id="changing-contentimage3">
                    <select class='image-picker show-html'>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button id="uploadpopupimage" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlPopUpImage()">Save</button>
                <button id="backpopupimage" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-category" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">List Category</h5>
                <hr>
            </div>
            <div class="modal-body">
                <input type="hidden" name="visible" id="visible" value="Y">
                <input type="hidden" name="sort_table" id="sort_table" value="category_tvshow_id">
                <input type="hidden" name="order_table" id="order_table" value="desc">
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link tab_keyword_active active" data-toggle="tab" href="#tab_keyword_active" role="tab">Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tab_keyword_inactive" data-toggle="tab" href="#tab_keyword_inactive" role="tab">Inactive</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active fade show" id="tab_keyword_active" role="tabpanel">
                            <button class="btn btn-light" name="add_keyword" id="add_keyword">Add Category</button>
                            <br><br>
                            <span class="invalid-feedback" id="wardingsearchkeywordactive" name="wardingsearchkeywordactive" style="display:none;">minimum 5 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputkeywordactive" id="searchinputkeywordactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttonkeywordactive" id="searchbuttonkeywordactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrowkeywordactive" id="selectrowkeywordactive" class="btn btn-light">
                                <select name="rowselectkeywordactive" id="rowselectkeywordactive">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <br>
                            <div id="table_keyword" class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytablekeyword1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>Show Number</th>
                                            <th>Create Date</th>
                                            <th>Update Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="my-tbody" class="tableactive">
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_keyword" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination_keyword'></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_keyword_inactive" role="tabpanel">
                            <button class="btn btn-light" name="add_keyword" id="add_keyword">Add Category</button>
                            <br><br>
                            <span class="invalid-feedback" id="wardingsearchkeywordinactive" name="wardingsearchkeywordinactive" style="display:none;">minimum 5 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputkeywordinactive" id="searchinputkeywordinactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttonkeywordinactive" id="searchbuttonkeywordinactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrowkeywordinactive" id="selectrowkeywordinactive" class="btn btn-light">
                                <select name="rowselectkeywordinactive" id="rowselectkeywordinactive">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <br>
                            <div id="table_keyword" class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytablekeyword2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>Show Number</th>
                                            <th>Create Date</th>
                                            <th>Update Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_keyword2" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination_keyword2'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-keyword-cu" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Keywords</h5>
            </div>
            <div class="modal-body">
                <div id="changing-keyword">
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button id="crud_keyword" type="button" class="btn btn-outline-success">Submit</button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div id="tbody-tooltip">Drag & drop keywords to reorder</div>

<div id="tooltipBtn">Klik untuk cari acara TV hingga 7 hari ke belakang.</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#toptvshow_category').select2({
            ajax: {
                url: '<?= base_url() ?>catchup_schedules/get_list_toptvshow_category',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page
                    }
                },
                processResults: function (data, params) {
                    params.page = params.page || 1
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    }
                },
                cache: true
            },
            placeholder: "Select a category top tv show",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedCategoryTopTvShow) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>catchup_schedules/get_single_toptvshow_category',
                data: {id: selectedCategoryTopTvShow},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#toptvshow_category').append(option).trigger('change')
                }
            })
        }

        $('#channel_category').select2({
            ajax: {
                url: '<?= base_url() ?>catchup_schedules/get_list_category_channel',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page
                    }
                },
                processResults: function (data, params) {
                    params.page = params.page || 1
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    }
                },
                cache: true
            },
            placeholder: "Select a category channel",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedCategoryChannel) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>catchup_schedules/get_single_category_channel',
                data: {id: selectedCategoryChannel},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#channel_category').append(option).trigger('change')
                }
            })
        }

        $('#channel_id').select2({
            ajax: {
                url: '<?= base_url() ?>catchup_schedules/get_list_channel',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page,
                        categoryChannel: $('#channel_category').val()
                    }
                },
                processResults: function (data, params) {
                    params.page = params.page || 1
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    }
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
                url: '<?= base_url() ?>catchup_schedules/get_single_channel',
                data: {id: selectedChannel},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#channel_id').append(option).trigger('change')
                }
            })
        }

        $("select").imagepicker()

        // image landscape
        $('.callfunction').click(function () {
            $(".loadimage1").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>catchup_schedules/compare_image_landscape',
                success: function (data) {
                    data = JSON.parse(data)
                    var _gallery = "<select class='image-picker show-html'>"
                    if (data.error == 0) {
                        var content = data.content
                        if (content != null) {
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1)
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>"
                            }
                        }
                    }
                    _gallery = _gallery+"</select>"
                    setTimeout(function () {
                        $(".loadimage1").fadeOut()
                    }, 500)
                    $('#changing-contentimage1').html(_gallery)
                    $("select").imagepicker()
                }
            })
        })

        $('#uploadimagelandscape').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>catchup_schedules/get_token',
                success: function (data) {
                    $('#changing-contentimage1')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=top_tvshowbanner_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>')
                }
            })
        })

        $('#backimagelandscape').click(function () {
            $(".loadimage1").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>catchup_schedules/compare_image_landscape',
                success: function (data) {
                    data = JSON.parse(data)
                    var _gallery = "<select class='image-picker show-html'>"
                    if (data.error == 0) {
                        var content = data.content
                        if (content != null) {
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1)
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>"
                            }
                        }
                    }
                    _gallery = _gallery+"</select>"
                    setTimeout(function () {
                        $(".loadimage1").fadeOut()
                    }, 500)
                    $('#changing-contentimage1').html(_gallery)
                    $("select").imagepicker()
                }
            })
        })
        // image landscape

        // image potrait
        $('.callfunction2').click(function () {
            $(".loadimage2").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>catchup_schedules/compare_image_portrait',
                success: function (data) {
                    data = JSON.parse(data)
                    var _gallery = "<select class='image-picker show-html'>"
                    if (data.error == 0) {
                        var content = data.content
                        if (content != null) {
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1)
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>"
                            }
                        }
                    }
                    _gallery = _gallery+"</select>"
                    setTimeout(function () {
                        $(".loadimage2").fadeOut()
                    }, 500)
                    $('#changing-contentimage2').html(_gallery)
                    $("select").imagepicker()
                }
            })
        })

        $('#uploadimagepotrait').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>catchup_schedules/get_token',
                success: function (data) {
                    $('#changing-contentimage2')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=575&h=1028&pw=252&ph=448&token='+data+'&thumb=50&CH=top_tvshowpotrait_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>')
                }
            })
        })

        $('#backimagepotrait').click(function () {
            $(".loadimage2").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>catchup_schedules/compare_image_portrait',
                success: function (data) {
                    data = JSON.parse(data)
                    var _gallery = "<select class='image-picker show-html'>"
                    if (data.error == 0) {
                        var content = data.content
                        if (content != null) {
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1)
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>"
                            }
                        }
                    }
                    _gallery = _gallery+"</select>"
                    setTimeout(function () {
                        $(".loadimage2").fadeOut()
                    }, 500)
                    $('#changing-contentimage2').html(_gallery)
                    $("select").imagepicker()
                }
            })
        })
        // image potrait

        // image popup
        $('.callfunction3').click(function () {
            $(".loadimage3").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>catchup_schedules/compare_image_popup',
                success: function (data) {
                    data = JSON.parse(data)
                    var _gallery = "<select class='image-picker show-html'>"
                    if (data.error == 0) {
                        var content = data.content
                        if (content != null) {
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1)
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>"
                            }
                        }
                    }
                    _gallery = _gallery+"</select>"
                    setTimeout(function () {
                        $(".loadimage3").fadeOut()
                    }, 500)
                    $('#changing-contentimage3').html(_gallery)
                    $("select").imagepicker()
                }
            })
        })

        $('#uploadpopupimage').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>catchup_schedules/get_token',
                success: function(data) {
                    $('#changing-contentimage3')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=top_tvshowpopup_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>')
                }
            })
        })

        $('#backpopupimage').click(function () {
            $(".loadimage3").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>catchup_schedules/compare_image_popup',
                success: function (data) {
                    data = JSON.parse(data)
                    var _gallery = "<select class='image-picker show-html'>"
                    if (data.error == 0) {
                        var content = data.content
                        if (content != null) {
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1)
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>"
                            }
                        }
                    }
                    _gallery = _gallery+"</select>"
                    setTimeout(function () {
                        $(".loadimage3").fadeOut()
                    }, 500)
                    $('#changing-contentimage3').html(_gallery)
                    $("select").imagepicker()
                }
            })
        })
        // image popup

        var lastImageUrlLandscape = "<?= set_value('banner_image_landscape') ?>"
        if (lastImageUrlLandscape) {
            $('#img_landscape').attr('src', lastImageUrlLandscape)
        }

        var lastImageUrlPortrait = "<?= set_value('banner_image_portrait') ?>"
        if (lastImageUrlPortrait) {
            $('#img_potrait').attr('src', lastImageUrlPortrait)
        }

        var lastImageUrlPopUp = "<?= set_value('popup_image') ?>"
        if (lastImageUrlPopUp) {
            $('#img_popup').attr('src', lastImageUrlPopUp)
        }
    })

    function getUrlLandscape() {
        var image = $('#modal-imagelandscape .image_picker_selector').find('.selected').find('img').attr('src')
        $('#banner_image_landscape').val(image)
        $('#img_landscape').attr('src',image)
        $('#modal-imagelandscape').modal('hide')
    }

    function getUrlPotrait() {
        var image = $('#modal-imagepotrait .image_picker_selector').find('.selected').find('img').attr('src')
        $('#banner_image_portrait').val(image)
        $('#img_potrait').attr('src',image)
        $('#modal-imagepotrait').modal('hide')
    }

    function getUrlPopUpImage() {
        var image = $('#modal-imagepopup .image_picker_selector').find('.selected').find('img').attr('src')
        $('#popup_image').val(image)
        $('#img_popup').attr('src',image)
        $('#modal-imagepopup').modal('hide')
    }

    function format(repo) {
        if (repo.loading) {
            return repo.text
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'></div>" +
            "</div>"
        )

        $container.find(".select2-result-repository__title").text(repo.text)
        
        return $container
    }

    function formatSelection(repo) {
        return repo.text
    }

    $(function () {
        $("#start_date").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
            allowInput: false,
            defaultDate: "<?= set_value('start_date', $catchup['start_date']) ?>"
        })
    })

    $(function () {
        $("#end_date").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
            allowInput: false,
            defaultDate: "<?= set_value('end_date', $catchup['end_date']) ?>"
        })
    })

    $(function () {
        const startTimePicker = $('#start_date').flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: 'Y-m-d H:i:S',
            allowInput: false,
            defaultDate: "<?= set_value('start_date', $catchup['start_date']) ?>"
        })

        const endTimePicker = $('#end_date').flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: 'Y-m-d H:i:S',
            allowInput: false,
            defaultDate: "<?= set_value('end_date', $catchup['end_date']) ?>"
        })

        $('#list_schedule').select2({
            allowClear: true,
            dropdownCssClass: "dropdown-program-custom",
            ajax: {
                url: '<?= base_url() ?>catchup_schedules/list_schedule',
                type: 'post',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        idChannel: $('#channel_id').val()
                    }
                },
                processResults: function (response) {
                    return {
                        results: response
                    }
                },
                cache: true
            },
            templateResult: function (item) {
                if (item.loading) {
                    return item.text
                }

                if (!item.data) {
                    return item.text
                }

                const data = item.data

                return $(`
                    <div class="schedule-option">
                        <div class="schedule-title">
                            ${data.title}
                        </div>
                        <div class="schedule-time">
                            ${formatDateSchedule(data.start_time)}
                            &nbsp; • &nbsp;
                            ${formatTimeSchedule(data.start_time)}
                            – 
                            ${formatTimeSchedule(data.end_time)}
                        </div>
                    </div>
                `)
            },
            templateSelection: function (item) {
                if (!item.data) {
                    return item.text
                }

                return item.data.title
            }
        })

        $('#list_schedule').on('select2:select', function (e) {
            const data = e.params.data.data

            if (!data) {
                return
            }

            startTimePicker.setDate(data.start_time, true)

            endTimePicker.setDate(data.end_time, true)
        })

        function formatDateSchedule(datetime) {
            const date = new Date(
                datetime.replace(' ', 'T')
            )

            return date.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            })
        }

        function formatTimeSchedule(datetime) {
            const date = new Date(
                datetime.replace(' ', 'T')
            )

            return date.toLocaleTimeString('en-GB', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            })
        }
    })

    const tbodyschedule = document.getElementById('info-select-wrapper')
    const tooltipschedule = document.getElementById('tooltipBtn')

    tbodyschedule.addEventListener('mousemove', function (e) {
        tooltipschedule.style.left = (e.pageX + 10) + 'px' 
        tooltipschedule.style.top = (e.pageY + 15) + 'px'
    })

    tbodyschedule.addEventListener('mouseenter', function () {
        tooltipschedule.style.display = 'block'
    })

    tbodyschedule.addEventListener('mouseleave', function () {
        tooltipschedule.style.display = 'none'
    })

    var selectedCategoryTopTvShow = <?= json_encode($selected_category_tvshow ?? '') ?>;
    var selectedCategoryChannel = <?= json_encode($selected_category_channel ?? '') ?>;
    var selectedChannel = <?= json_encode($selected_channel ?? '') ?>;

    // management keyword
    $("#addCategory").click(function () {
        $(".tab_keyword_active").trigger('click')
    })

    function handleKeywordTab(type) {
        var tableId = type === 'active' ? '#mytablekeyword1' : '#mytablekeyword2'
        var tabShow = type === 'active' ? '#tab_keyword_active' : '#tab_keyword_inactive'
        var tabHide = type === 'active' ? '#tab_keyword_inactive' : '#tab_keyword_active'
        $(tableId + ' tbody').empty()
        var visible = type === 'active' ? 'Y' : 'N'
        $('#visible').val(visible)
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        $('#rowselectkeyword' + type).val(10).trigger('change.select2')
        var rowperpage = $('#rowselectkeyword' + type).val()
        sortPaginationKeyword(null, sort_by, order_sort, visible, rowperpage, 0)
        $(tabHide).hide()
        $(tabShow).show()
    }

    $(document).on('click', '.tab_keyword_active', function () {
        handleKeywordTab('active')
    })

    $(document).on('click', '.tab_keyword_inactive', function () {
        handleKeywordTab('inactive')
    })

    $('#rowselectkeywordactive').select2({
        minimumResultsForSearch: Infinity,
        width: '100%',
        dropdownParent: $('#modal-category'),
        dropdownCssClass: 'keyword-select2-dark'
    })

    $('#rowselectkeywordinactive').select2({
        minimumResultsForSearch: Infinity,
        width: '100%',
        dropdownParent: $('#modal-category'),
        dropdownCssClass: 'keyword-select2-dark'
    })

    function handleRowSelectKeyword(type) {
        var pageno = 0
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputkeyword' + type).val() || null
        var rowperpage = $('#rowselectkeyword' + type).val()
        sortPaginationKeyword(key_search, sort_by, order_sort, visible, rowperpage, pageno)
    }

    $(document).on('change', '#rowselectkeywordactive', function () {
        handleRowSelectKeyword('active')
    })

    $(document).on('change', '#rowselectkeywordinactive', function () {
        handleRowSelectKeyword('inactive')
    })

    function handlePaginationKeywordClick(paginationSelector, type) {
        $(paginationSelector).on('click', '.page-link', function (e) {
            e.preventDefault()
            var link = $(this).find('a')
            var pageno = link.data('ci-pagination-page')
            if (!pageno) {
                var text = $(this).text().trim()
                if (!isNaN(text)) {
                    pageno = parseInt(text, 10)
                }
            }
            if (!pageno) {
                return
            }
            var isActive = type === 'active'
            var visible = $('#visible').val()
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var key_search = $('#searchinputkeyword' + type).val() || null
            var rowperpage = $('#rowselectkeyword' + type).val()
            sortPaginationKeyword(key_search, sort_by, order_sort, visible, rowperpage, pageno)
        })
    }

    handlePaginationKeywordClick('#pagination_keyword', 'active')

    handlePaginationKeywordClick('#pagination_keyword2', 'inactive')

    function handleSearchKeyword(type) {
        var search = $('#searchinputkeyword' + type).val()
        if (!search || search.length < 3) {
            $('#wardingsearchkeyword' + type).show()
            setTimeout(function () {
                $('#wardingsearchkeyword' + type).hide()
            }, 5000)
            return
        }
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var rowperpage = $('#rowselectkeyword' + type).val()
        sortPaginationKeyword(search, sort_by, order_sort, visible, rowperpage, 0)
    }

    $(document).on('click', '#searchbuttonkeywordactive', function () {
        handleSearchKeyword('active')
    })

    $(document).on('click', '#searchbuttonkeywordinactive', function () {
        handleSearchKeyword('inactive')
    })

    function sortPaginationKeyword(key_search, sort_by, order_sort, visible, rowperpage, pageno){
        var statustable = $('#visible').val()
        $.ajax({
            url: '<?=base_url()?>catchup_schedules/listCategoryTopTvShow/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var order_sort = response.order
                var x = response.x
                var y = response.y
                var z = response.z
                var show = 'Showing '+x+' to '+y+' of '+z+' entries'
                $('#data-table_keyword').html(show)
                if (statustable == 'Y') {
                    $('#data-table_keyword').html(show)
                } else {
                    $('#data-table_keyword2').html(show)
                }
                if (response.pagination == "") {
                    var page1 = `<div class="pagging text-center">
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item active">
                                                <span class="page-link">1<span class="sr-only">(current)</span></span>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>`
                    if (statustable == 'Y') {
                        $('#pagination_keyword').html(page1)
                    } else {
                        $('#pagination_keyword2').html(page1)
                    }
                } else {
                    if (statustable == 'Y') {
                        $('#pagination_keyword').html(response.pagination)
                    } else {
                        $('#pagination_keyword2').html(response.pagination)
                    }
                }
                createTableKeyword(response.result, response.row)
            }
        })
    }

    function createTableKeyword(result, sno) {
        var statustable = $('#visible').val()

        if (statustable == 'Y') {
            $tbody = $('#mytablekeyword1 tbody')
            $('#mytablekeyword1 tbody').empty()
            $('#mytablekeyword1 tbody').css('cursor', 'all-scroll')
        } else {
            $tbody = $('#mytablekeyword2 tbody')
            $('#mytablekeyword2 tbody').empty()
            $('#mytablekeyword2 tbody').css('cursor', 'default')
        }

        if (result.length > 0) {
            sno = Number(sno)
            for (index in result) {
                var id = result[index].category_tvshow_id
                var title = result[index].title_tvshow
                var showNumber = result[index].show_number
                var visible = result[index].visible
                var createDate = result[index].create_date
                var updateDate = result[index].update_date
                sno+=1
                var base_url = '<?php echo base_url() ?>'

                if (showNumber === "Y") {
                    var show_number = `<button type='button' class='btn btn-outline-success' disabled>Active</button>`
                    var htmlBtnShowNumber = `<a onclick="confirmShowNumberAction('${id}', 'deactivate')" href="#!" class="dropdown-item">
                         <i class="zmdi zmdi-minus-circle-outline zmdi-hc-fw"></i>Deactivate Show Number
                       </a>`
                } else {
                    var show_number = `<button type='button' class='btn btn-outline-danger' disabled>Inactive</button>`
                    var htmlBtnShowNumber = `<a onclick="confirmShowNumberAction('${id}', 'activate')" href="#!" class="dropdown-item">
                         <i class="zmdi zmdi-plus-circle-o zmdi-hc-fw"></i>Activate Show Number
                       </a>`
                }

                var html = result[index].visible == "N" 
                    ? `<a onclick="confirmKeywordAction('${id}', 'activate')" href="#!" class="dropdown-item">
                         <i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate
                       </a>`
                    : `<a onclick="confirmKeywordAction('${id}', 'deactivate')" href="#!" class="dropdown-item">
                         <i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate
                       </a>`

                var tr = "<tr id='"+id+"'>"
                tr += "<td>"+ sno +"</td>"
                tr += "<td>"+ title +"</td>"
                tr += "<td>"+ show_number +"</td>"
                tr += "<td>"+ createDate +"</td>"
                tr += "<td>"+ updateDate +"</td>"
                tr += "<td><div class='dropdown'><button class='btn btn-light dropdown-toggle' data-toggle='dropdown'>ACTION</button><div class='dropdown-menu dropdown-menu--icon'>"+ html + htmlBtnShowNumber +"<a href='#!' onclick='edit_keyword(\""+id+"\")' class='dropdown-item'><i class='zmdi zmdi-edit zmdi-hc-fw'></i>Edit</a></div></div></td>"
                tr += "</tr>"
                
                if (statustable == 'Y') {
                    $('#mytablekeyword1 tbody').append(tr)
                } else {
                    $('#mytablekeyword2 tbody').append(tr)
                }
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="3" class="dataTables_empty">No matching records found</td></tr>`
            
            if (statustable == 'Y') {
                $('#mytablekeyword1 tbody').append(tr)
            } else {
                $('#mytablekeyword2 tbody').append(tr)
            }
        }

        if (statustable == 'Y') {
            if (!$tbody.hasClass('ui-sortable')) {
                $tbody.sortable({
                    placeholder : 'ui-state-highlight',
                    update: function (event, ui) {
                        swal({
                            title: 'Are you sure?',
                            type: 'warning',
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-success',
                            confirmButtonText: 'Yes',
                            cancelButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(function (isConfirm) {
                            if (isConfirm) {
                                var page_id_array = new Array()
                                $('tbody tr').each(function () {
                                    page_id_array.push($(this).attr('id'))
                                })

                                $.ajax({
                                    url: '<?=base_url()?>catchup_schedules/update_sort_category',
                                    method: 'POST',
                                    data: {
                                        page_id_array: page_id_array,
                                        action: 'update'
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        swal({
                                            title: response.error === '0' ? 'Success' : 'Failed',
                                            text: response.message,
                                            type: response.error === '0' ? 'success' : 'error',
                                            buttonsStyling: false,
                                            confirmButtonClass: 'btn btn-light',
                                            background: '#222323',
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                        }).then(function (ok) {
                                            if (ok && response.error === '0') {
                                                $('.tab_keyword_active').trigger('click')
                                            } else {
                                                $tbody.sortable('cancel')
                                            }
                                        })
                                    },
                                    error: function () {
                                        swal({
                                            title: 'Failed',
                                            text: 'Failed to process request',
                                            type: 'error',
                                            buttonsStyling: false,
                                            confirmButtonClass: 'btn btn-light',
                                            background: '#222323',
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                        }).then(function (ok) {
                                            if (ok) {
                                                $tbody.sortable('cancel')
                                            }
                                        })
                                    },
                                })
                            }
                        }).catch(function () {
                            $tbody.sortable('cancel')
                        })
                    }
                })
            }
        } else {
            if ($tbody.hasClass('ui-sortable')) {
                $tbody.sortable('destroy')
            }
        }
    }

    const tbody = document.getElementById('my-tbody')
    const tooltip = document.getElementById('tbody-tooltip')

    tbody.addEventListener('mousemove', function (e) {
        tooltip.style.left = (e.pageX + 10) + 'px' 
        tooltip.style.top = (e.pageY + 15) + 'px'
    })

    tbody.addEventListener('mouseenter', function () {
        tooltip.style.display = 'block'
    })

    tbody.addEventListener('mouseleave', function () {
        tooltip.style.display = 'none'
    })

    function confirmShowNumberAction(id, action) {
        const settings = {
            activate: {
                url: '<?=base_url()?>catchup_schedules/activate_shownumber',
                confirmText: 'Activate',
                confirmClass: 'btn btn-success',
                tabSelector: '.tab_keyword_active',
            },
            deactivate: {
                url: '<?=base_url()?>catchup_schedules/inactivate_shownumber',
                confirmText: 'Deactivate',
                confirmClass: 'btn btn-danger',
                tabSelector: '.tab_keyword_inactive',
            }
        }
        const config = settings[action]
        if (!config) {
            return
        }
        swal({
            title: 'Are you sure?',
            type: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonClass: config.confirmClass,
            confirmButtonText: config.confirmText,
            cancelButtonClass: 'btn btn-light',
            background: '#222323',
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then(function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: config.url,
                    type: 'post',
                    data: {id: id},
                    dataType: 'json',
                    success: function (response) {
                        swal({
                            title: response.error === '0' ? 'Success' : 'Failed',
                            text: response.message,
                            type: response.error === '0' ? 'success' : 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(function (ok) {
                            if (ok && response.error === '0') {
                                $('.tab_keyword_active').trigger('click')
                            }
                        })
                    },
                    error: function() {
                        swal({
                            title: 'Failed',
                            text: 'Failed to process request',
                            type: 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        })
                    },
                })
            }
        })
    }

    function confirmKeywordAction(id, action) {
        const settings = {
            activate: {
                url: '<?=base_url()?>catchup_schedules/activate_keyword',
                confirmText: 'Activate',
                confirmClass: 'btn btn-success',
                tabSelector: '.tab_keyword_active',
            },
            deactivate: {
                url: '<?=base_url()?>catchup_schedules/inactivate_keyword',
                confirmText: 'Deactivate',
                confirmClass: 'btn btn-danger',
                tabSelector: '.tab_keyword_inactive',
            }
        }
        const config = settings[action]
        if (!config) {
            return
        }
        swal({
            title: 'Are you sure?',
            type: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonClass: config.confirmClass,
            confirmButtonText: config.confirmText,
            cancelButtonClass: 'btn btn-light',
            background: '#222323',
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then(function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: config.url,
                    type: 'post',
                    data: {id: id},
                    dataType: 'json',
                    success: function (response) {
                        swal({
                            title: response.error === '0' ? 'Success' : 'Failed',
                            text: response.message,
                            type: response.error === '0' ? 'success' : 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(function (ok) {
                            if (ok && response.error === '0') {
                                $(config.tabSelector).trigger('click')
                            }
                        })
                    },
                    error: function() {
                        swal({
                            title: 'Failed',
                            text: 'Failed to process request',
                            type: 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        })
                    },
                })
            }
        })
    }

    $(document).on("click", "#add_keyword", (function (e) {
        e.preventDefault()
        var html = `<form action="#" method="post" id="form_crud_keyword" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title (*required)</label>
                                    <input name="titleCategory" id="titleCategory" type="text" class="form-control" placeholder="Please Input Keyword Name" value="" required>
                                    <span id="keyname_val" name="keyname_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input type="hidden" name="category_tvshow_id" id="category_tvshow_id" value="">
                        </div>`
        $('#changing-keyword').html(html)

        $('#modal-keyword-cu').modal('show')
    }))

    function edit_keyword(id) {
        var html = `<form action="#" method="post" id="form_crud_keyword" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name (*required)</label>
                                    <input name="titleCategory" id="titleCategory" type="text" class="form-control" placeholder="Please Input Keyword Name" value="" required>
                                    <span id="keyname_val" name="keyname_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input type="hidden" name="category_tvshow_id" id="category_tvshow_id" value="${id}">
                        </div>`
        $('#changing-keyword').html(html)

        $.ajax({
            url: "<?php echo site_url('catchup_schedules/get_data_edit_keyword') ?>",
            method: "POST",
            data: {id:id},
            async : true,
            dataType: 'json',
            success: function (data) {
                var val_name = data[0]['title_tvshow']
                $('#form_crud_keyword [name="titleCategory"]').val(val_name).trigger('change')
            }
        })

        $('#modal-keyword-cu').modal('show')
    }

    $("#crud_keyword").click(function () {
        var self = $('#form_crud_keyword')
        var keyname_res = $(self).find('#titleCategory').val()
        if (keyname_res == '' || keyname_res == null) {
            $('#keyname_val').text('* Please input name')
            $('#keyname_val').show()
        } else {
            $("#keyname_val").hide()
        }
        if (keyname_res != '') {
            $('#crud_keyword').text('Submit...')
            $('#crud_keyword').attr('disabled', true)
            swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Yes',
                cancelButtonClass: 'btn btn-light',
                background: '#222323',
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '<?php echo site_url("catchup_schedules/cu_keyword") ?>',
                        type: 'post',
                        data: $('#form_crud_keyword').serialize(),
                        dataType: 'json',
                        success: function (response) {
                            swal({
                                title: response.error === '0' ? 'Success' : 'Failed',
                                text: response.message,
                                type: response.error === '0' ? 'success' : 'error',
                                buttonsStyling: false,
                                confirmButtonClass: 'btn btn-light',
                                background: '#222323',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            }).then(function (ok) {
                                if (ok && response.error === '0') {
                                    $('#crud_keyword').text('Submit')
                                    $('#crud_keyword').attr('disabled', false)
                                    $('#modal-keyword-cu').modal('hide')
                                    $(".tab_keyword_active").trigger('click')
                                } else {
                                    $('#crud_keyword').text('Submit')
                                    $('#crud_keyword').attr('disabled', false)
                                }
                            })
                        },
                        error: function () {
                            swal({
                                title: 'Failed',
                                text: 'Failed to process request',
                                type: 'error',
                                buttonsStyling: false,
                                confirmButtonClass: 'btn btn-light',
                                background: '#222323',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            }).then(function (ok) {
                                if (ok && response.error === '0') {
                                    $('#crud_keyword').text('Submit')
                                    $('#crud_keyword').attr('disabled', false)
                                }
                            })
                        },
                    })
                }
            })
        }
    })
    // management keyword
</script>