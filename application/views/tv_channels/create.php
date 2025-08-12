<style type="text/css">
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
    select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 130px;height: 130px;}
    #changing-contentimage2 .image_picker_image {width: 200px;height: 130px;}
    .contacts__img>img {width: 100px;height: 100px;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>TV Channels</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('tv_channels') ?>">TV Channels</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?= form_open('tv_channels/create') ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Logo Square for STB & Apps (*required)</label>
                                <div class="contacts__item">
                                    <label>(183x174)</label>
                                    <a class="contacts__img">
                                        <img id="img_landscape1" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction1" data-toggle="modal" data-target="#modal-imagelandscape1">Upload</a>
                                    <input name="poster_content1" id="poster_content1" type="hidden" class="form-control" value="<?= set_value('poster_content1') ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('poster_content1') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Logo Landscape for Web (*required)</label>
                                <div class="contacts__item">
                                    <label>(340x160)</label>
                                    <a class="contacts__img">
                                        <img id="img_landscape2" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction2" data-toggle="modal" data-target="#modal-imagelandscape2">Upload</a>
                                    <input name="poster_content2" id="poster_content2" type="hidden" class="form-control" value="<?= set_value('poster_content2') ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('poster_content2') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Genre (*required)</label>
                                <select class="form-control" name="genre[]" id="genre" multiple="multiple" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('genre') ?></span>
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
                                <label>Description (*required)</label>
                                <textarea name="description" id="description" class="form-control" rows="1" placeholder="Please Input Description" required><?= set_value('description') ?></textarea>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('description') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sort ID (*required)</label>
                                <input class="form-control" type="text" name="sort_id" id="sort_id" value="<?= set_value('sort_id', '0') ?>" placeholder="Please Input Sort ID" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onfocus="this.select()" onblur="if(this.value === '') this.value = '0';">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('sort_id') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Trial Period (*required)</label>
                                <input class="form-control" type="text" name="trial_period" id="trial_period" value="<?= set_value('trial_period', '0') ?>" placeholder="Please Input Trial Period" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onfocus="this.select()" onblur="if(this.value === '') this.value = '0';">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('trial_period') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>List Price (*required)</label>
                                <input class="form-control" type="text" name="list_price" id="list_price" value="<?= set_value('list_price', '0') ?>" placeholder="Please Input List Price" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onfocus="this.select()" onblur="if(this.value === '') this.value = '0';">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('list_price') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sell Price (*required)</label>
                                <input class="form-control" type="text" name="sell_price" id="sell_price" value="<?= set_value('sell_price', '0') ?>" placeholder="Please Input Sell Price" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onfocus="this.select()" onblur="if(this.value === '') this.value = '0';">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('sell_price') ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="datetimepicker">Active in UI (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="start_time" name="start_time" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('start_time') ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('start_time') ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="datetimepicker">Inctive in UI (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="end_time" name="end_time" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('end_time') ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('end_time') ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <hr><br>
                        </div>
                        <div class="col-sm-12">
                            <label>Allowed on devices</label>
                            <div class="form-group">
                                <label>PC</label>
                                <div class="btn-group btn-group--colors pcs" data-toggle="buttons">
                                    <label class="btn <?= set_checkbox('allowed_pc', '1') ? 'active' : '' ?>">
                                        <input name="allowed_pc" id="allowed_pc" type="checkbox" value="1" autocomplete="off" <?= set_checkbox('allowed_pc', '1') ?>>
                                    </label>
                                </div>
                                <label>STB</label>
                                <div class="btn-group btn-group--colors stbs" data-toggle="buttons">
                                    <label class="btn <?= set_checkbox('allowed_stb', '1') ? 'active' : '' ?>">
                                        <input name="allowed_stb" id="allowed_stb" type="checkbox" value="1" autocomplete="off" <?= set_checkbox('allowed_stb', '1') ?>>
                                    </label>
                                </div>
                                <label>Android</label>
                                <div class="btn-group btn-group--colors adrs" data-toggle="buttons">
                                    <label class="btn <?= set_checkbox('allowed_android', '1') ? 'active' : '' ?>">
                                        <input name="allowed_android" id="allowed_android" type="checkbox" value="1" autocomplete="off" <?= set_checkbox('allowed_android', '1') ?>>
                                    </label>
                                </div>
                                <label>iOS</label>
                                <div class="btn-group btn-group--colors ioss" data-toggle="buttons">
                                    <label class="btn <?= set_checkbox('allowed_ios', '1') ? 'active' : '' ?>">
                                        <input name="allowed_ios" id="allowed_ios" type="checkbox" value="1" autocomplete="off" <?= set_checkbox('allowed_ios', '1') ?>>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Play URL for WEB</label>
                                <input class="form-control" type="text" name="url_web" id="url_web" value="<?= set_value('url_web') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('url_web') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Play URL for STB</label>
                                <input class="form-control" type="text" name="url_stb" id="url_stb" value="<?= set_value('url_stb') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('url_stb') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Play URL for iPhone</label>
                                <input class="form-control" type="text" name="url_iphone" id="url_iphone" value="<?= set_value('url_iphone') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('url_iphone') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Play URL for iPad</label>
                                <input class="form-control" type="text" name="url_ipad" id="url_ipad" value="<?= set_value('url_ipad') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('url_ipad') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Play URL for Android Phone</label>
                                <input class="form-control" type="text" name="url_adrphone" id="url_adrphone" value="<?= set_value('url_adrphone') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('url_adrphone') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Play URL for Android Pad</label>
                                <input class="form-control" type="text" name="url_adrpad" id="url_adrpad" value="<?= set_value('url_adrpad') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('url_adrpad') ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <hr><br>
                        </div>
                        <div class="col-sm-4">
                            <label>Allowed Catchup</label>
                            <div class="form-group">
                                <label>Allowed Catchup</label>
                                <div class="btn-group btn-group--colors pcs" data-toggle="buttons">
                                    <label class="btn <?= set_checkbox('allowed_catchup', '1') ? 'active' : '' ?>">
                                        <input name="allowed_catchup" id="allowed_catchup" type="checkbox" value="1" autocomplete="off" <?= set_checkbox('allowed_catchup', '1') ?>>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label>Limit Catchup (*required)</label>
                            <div class="form-group">
                                <label>PC (Max 7 days)<input class="form-control" type="number" name="web_catchup" id="web_catchup" min="1" max="7" value="<?= set_value('web_catchup', 7) ?>" onKeyPress="if(this.value.length==1) return false;"></label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>STB (Max 7 days)<input class="form-control" type="number" name="stb_catchup" id="stb_catchup" min="1" max="7" value="<?= set_value('stb_catchup', 7) ?>" onKeyPress="if(this.value.length==1) return false;"></label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>Android (Max 7 days)<input class="form-control" type="number" name="android_catchup" id="android_catchup" min="1" max="7" value="<?= set_value('android_catchup', 7) ?>" onKeyPress="if(this.value.length==1) return false;"></label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>IOS (Max 7 days)<input class="form-control" type="number" name="ios_catchup" id="ios_catchup" min="1" max="7" value="<?= set_value('ios_catchup', 7) ?>" onKeyPress="if(this.value.length==1) return false;"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>TVOD for WEB</label>
                                <input class="form-control" type="text" name="tvod_web" id="tvod_web" value="<?= set_value('tvod_web') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('tvod_web') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>TVOD for STB</label>
                                <input class="form-control" type="text" name="tvod_stb" id="tvod_stb" value="<?= set_value('tvod_stb') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('tvod_stb') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>TVOD for iPhone</label>
                                <input class="form-control" type="text" name="tvod_iphone" id="tvod_iphone" value="<?= set_value('tvod_iphone') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('tvod_iphone') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>TVOD for iPad</label>
                                <input class="form-control" type="text" name="tvod_ipad" id="tvod_ipad" value="<?= set_value('tvod_ipad') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('tvod_ipad') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>TVOD for Android Phone</label>
                                <input class="form-control" type="text" name="tvod_adrphone" id="tvod_adrphone" value="<?= set_value('tvod_adrphone') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('tvod_adrphone') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>TVOD for Android Pad</label>
                                <input class="form-control" type="text" name="tvod_adrpad" id="tvod_adrpad" value="<?= set_value('tvod_adrpad') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('tvod_adrpad') ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <hr><br>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Event</label>
                                <select class="form-control" name="event" id="event" required>
                                    <option value="0" <?= set_select('event', '0') ?>>inactive</option>
                                    <option value="1" <?= set_select('event', '1') ?>>active</option>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('event') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Limit Access</label>
                                <input class="form-control" type="text" name="limit_access" id="limit_access" value="<?= set_value('limit_access') ?>" placeholder="Please Input Limit Access" onKeyPress="if(this.value.length==4) return false;" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('limit_access') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Banner URL</label>
                                <input class="form-control" type="text" name="banner_url" id="banner_url" value="<?= set_value('banner_url') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('banner_url') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Link URL</label>
                                <input class="form-control" type="text" name="link_url" id="link_url" value="<?= set_value('link_url') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('link_url') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Trailer URL</label>
                                <input class="form-control" type="text" name="trailer_url" id="trailer_url" value="<?= set_value('trailer_url') ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('trailer_url') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Owner (optional)</label>
                                <select class="form-control" name="owner" id="owner">
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('owner') ?></span>
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

<div class="modal fade" id="modal-imagelandscape1" tabindex="-1" style="display: none;" aria-hidden="true">
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
            <div class="modal-footer" style="justify-content: center;">
                <button id="uploadimagelandscape1" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlSquare()">Save</button>
                <button id="backimagelandscape1" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-imagelandscape2" tabindex="-1" style="display: none;" aria-hidden="true">
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
            <div class="modal-footer" style="justify-content: center;">
                <button id="uploadimagelandscape2" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlLandscape()">Save</button>
                <button id="backimagelandscape2" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var selectedGenreIds = <?= json_encode((array) $selected_genres) ?>;
    
    $(document).ready(function(){
        $('#genre').select2({
            ajax: {
                url: '<?= base_url() ?>tv_channels/get_list_genre',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page,
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
            placeholder: "Select a genre",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedGenreIds.length > 0) {
            $.ajax({
                url: '<?= base_url("tv_channels/get_multiple_genres") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedGenreIds },
                success: function (response) {
                    response.forEach(function (genre) {
                        var option = new Option(genre.text, genre.id, true, true);
                        $('#genre').append(option).trigger('change');
                    });
                }
            });
        }

        $('#owner').select2({
            ajax: {
                url: '<?= base_url() ?>tv_channels/get_list_owner',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page,
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
            placeholder: "Select owner",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedOwner) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>tv_channels/get_single_owner',
                data: { id: selectedOwner },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#owner').append(option).trigger('change');
                }
            });
        }

        $('#event').select2()

        $("select").imagepicker();

        // image square
        $('.callfunction1').click(function(){
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>tv_channels/compare_image_square',
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

        $('#uploadimagelandscape1').click(function(){
            $('#changing-contentimage1').html('<iframe src="http://pic1.dens.tv:9797/poster/upload-channelogo_debug.php" width="100%" height="400px" frameborder="0"></iframe>');
        });

        $('#backimagelandscape1').click(function(){
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>tv_channels/compare_image_square',
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
        // image square

        // image landscape
        $('.callfunction2').click(function(){
            $(".loadimage2").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>tv_channels/compare_image_landscape',
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

        $('#uploadimagelandscape2').click(function(){
            $.ajax({
                url: '<?php echo base_url() ?>tv_channels/get_token',
                success: function(data) {
                    $('#changing-contentimage2')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=340&h=160&pw=340&ph=160&token='+data+'&thumb=50&CH=tvchannels_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backimagelandscape2').click(function(){
            $(".loadimage2").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>tv_channels/compare_image_landscape',
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
        // image landscape

        var lastImageUrlSquare = "<?= set_value('poster_content1') ?>";
        if (lastImageUrlSquare) {
            $('#img_landscape1').attr('src', lastImageUrlSquare);
        }

        var lastImageUrlLandscape = "<?= set_value('poster_content2') ?>";
        if (lastImageUrlLandscape) {
            $('#img_landscape2').attr('src', lastImageUrlLandscape);
        }
    })

    function getUrlSquare(){
        var img = $('#modal-imagelandscape1 .image_picker_selector').find('.selected').find('img').attr('src');
        var image = 'https://picture.dens.tv/tv_183x174/'+img.replace(/.*\//, '');
        $('#poster_content1').val(image);
        $('#img_landscape1').attr('src',img);
        $('#modal-imagelandscape1').modal('hide');
    }

    function getUrlLandscape(){
        var img = $('#modal-imagelandscape2 .image_picker_selector').find('.selected').find('img').attr('src');
        var image = 'https://picture.dens.tv/wp/img/tvchannels_v1/340x160/'+img.replace(/.*\//, '');
        $('#poster_content2').val(image);
        $('#img_landscape2').attr('src',img);
        $('#modal-imagelandscape2').modal('hide');
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

    $(function () {
        $("#start_time").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
            defaultDate: "<?= set_value('start_time') ?>"
        });
        $("#start_time").prop('readonly', false);
    });

    $( function() {
        $("#end_time").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
            defaultDate: "<?= set_value('end_time') ?>"
        })
        $("#end_time").prop('readonly', false)
    });

    $("#web_catchup").keypress(function(evt) {
        console.log(evt)
        if (evt.key == "0" || evt.key == "8" || evt.key == "9") {
            return false;
        }
    })

    $("#stb_catchup").keypress(function(evt) {
        console.log(evt)
        if (evt.key == "0" || evt.key == "8" || evt.key == "9") {
            return false;
        }
    })

    $("#android_catchup").keypress(function(evt) {
        console.log(evt)
        if (evt.key == "0" || evt.key == "8" || evt.key == "9") {
            return false;
        }
    })

    $("#ios_catchup").keypress(function(evt) {
        console.log(evt)
        if (evt.key == "0" || evt.key == "8" || evt.key == "9") {
            return false;
        }
    })

    var selectedOwner = <?= json_encode($selected_owner ?? '') ?>;
</script>