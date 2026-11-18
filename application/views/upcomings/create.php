<style type="text/css">
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    select.image-picker {margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 130px;height: 200px;}
    #changing-contentimage2 .image_picker_image {width: 200px;height: 130px;}
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
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Upcoming Trailer</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('upcomings') ?>">Upcoming Trailer</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>','</div>'); ?>
                <?= form_open('upcomings/create') ?>
                    <div class="row">
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
                                <label>Genre (*required)</label>
                                <select class="form-control" name="genre" id="genre" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('genre') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Year (*required)</label>
                                <input type="text" name="year" id="year" class="form-control" value="<?= set_value('year') ?>" placeholder="Please Input Year" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('year') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rated (*required)</label>
                                <select class="form-control" name="rated" id="rated" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('rated') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Director (*required)</label>
                                <input type="text" name="director" id="director" class="form-control" value="<?= set_value('director') ?>" placeholder="Please Input Director" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('director') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cast (*required)</label>
                                <input type="text" name="cast" id="cast" class="form-control" value="<?= set_value('cast') ?>" placeholder="Please Input Cast" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('cast') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Duration (*required)</label>
                                <input type="text" name="duration" id="duration" class="form-control" value="<?= set_value('duration') ?>" placeholder="Please Input Duration" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('duration') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Trailer URL (*required)</label>
                                <input type="text" name="trailer_url" id="trailer_url" class="form-control" value="<?= set_value('trailer_url') ?>" placeholder="Please Input Link URL" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('trailer_url') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Trailer URL for Hover</label>
                                <input type="text" name="trailer_url_hover" id="trailer_url_hover" class="form-control" value="<?= set_value('trailer_url_hover') ?>" placeholder="Please Input Link URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('trailer_url_hover') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Banner Image (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_banner" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-bannerimage">Upload</a>
                                    <input name="banner_image" id="banner_image" type="hidden" class="form-control" value="<?= set_value('banner_image') ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('banner_image') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pop Up Image (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_popup" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction2" data-toggle="modal" data-target="#modal-popupimage">Upload</a>
                                    <input name="popup_image" id="popup_image" type="hidden" class="form-control" value="<?= set_value('popup_image') ?>" required>
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

<div class="modal fade" id="modal-bannerimage" tabindex="-1" style="display: none;" aria-hidden="true">
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
                <button id="uploadimagebanner" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlBanner()">Save</button>
                <button id="backimagebanner" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-popupimage" tabindex="-1" style="display: none;" aria-hidden="true">
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
                <button id="uploadimagepopup" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlPopUp()">Save</button>
                <button id="backimagepopup" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="tbody-tooltip">Drag & drop keywords to reorder</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#genre').select2({
            ajax: {
                url: '<?= base_url() ?>upcomings/getListGenre',
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
            placeholder: "Select a genre",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedGenre) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>upcomings/getSingleGenre',
                data: {id: selectedGenre},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#genre').append(option).trigger('change')
                }
            })
        }

        $('#rated').select2({
            ajax: {
                url: '<?= base_url() ?>upcomings/getListRated',
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

        if (selectedRated) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>upcomings/getSingleRated',
                data: {id: selectedRated},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#rated').append(option).trigger('change')
                }
            })
        }

        $("select").imagepicker()

        // image landscape
        $('.callfunction').click(function () {
            $(".loadimage1").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>upcomings/compareBannerImage',
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

        $('#uploadimagebanner').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>upcomings/get_token',
                success: function (data) {
                    $('#changing-contentimage1')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=575&h=1028&pw=252&ph=448&token='+data+'&thumb=50&CH=upcoming_potrait_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>')
                }
            })
        })

        $('#backimagebanner').click(function () {
            $(".loadimage1").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>upcomings/compareBannerImage',
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
                url: '<?php echo base_url() ?>upcomings/comparePopUpImage',
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

        $('#uploadimagepopup').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>upcomings/get_token',
                success: function (data) {
                    $('#changing-contentimage2')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=upcoming_landscape_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>')
                }
            })
        })

        $('#backimagepopup').click(function () {
            $(".loadimage2").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>upcomings/comparePopUpImage',
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

        var lastImageUrlBanner = "<?= set_value('banner_image') ?>"
        if (lastImageUrlBanner) {
            $('#img_banner').attr('src', lastImageUrlBanner)
        }

        var lastImageUrlPopUp = "<?= set_value('popup_image') ?>"
        if (lastImageUrlPopUp) {
            $('#img_popup').attr('src', lastImageUrlPopUp)
        }
    })

    function getUrlBanner() {
        var image = $('#modal-bannerimage .image_picker_selector').find('.selected').find('img').attr('src')
        $('#banner_image').val(image)
        $('#img_banner').attr('src',image)
        $('#modal-bannerimage').modal('hide')
    }

    function getUrlPopUp() {
        var image = $('#modal-popupimage .image_picker_selector').find('.selected').find('img').attr('src')
        $('#popup_image').val(image)
        $('#img_popup').attr('src',image)
        $('#modal-popupimage').modal('hide')
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

    var selectedGenre = <?= json_encode($selected_genre ?? '') ?>;
    var selectedRated = <?= json_encode($selected_rated ?? '') ?>;
</script>