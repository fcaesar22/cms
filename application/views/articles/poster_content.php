<style type="text/css">
    select {display: block !important;}
    select.image-picker{margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 200px;height: 130px;}
    #changing-video .image_picker_image {width: 200px;height: 130px;}
    .contacts__img>img{width: 100px;height: 100px;}
    .contacts__item {margin-bottom: 0px;}
    .disabledTab{pointer-events: none;}
</style>
<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Articles</h1>
            <?php echo $this->session->flashdata('msg');?>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('articles') ?>">Articles</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('articles/edit/'.$article_id) ?>">Edit Articles</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('articles/create_edit_article_content/'.$article_id) ?>">Edit Article Content</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('articles/create_edit_poster_banner/'.$article_id) ?>">Edit Poster Banner</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?= form_open('articles/create_edit_poster_content/'.$article_id) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Poster Content Images (*required)</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Image</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-img">
                                            <tr id="rowimg0" class="content_images1">
                                                <td>
                                                    <span class="btn btn-sm btn-default">1</span>
                                                    <input type="hidden" name="count_images[]" value="6437">
                                                </td>
                                                <td class="img_contents">
                                                    <div class="contacts__item">
                                                        <a class="contacts__img">
                                                            <img id="img_pos0" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                                        </a>
                                                        <a class="btn btn-light callfunction" onclick="show_modal('img', 'img_pos0', 'rowimg0')">Upload</a>
                                                        <input name="poster_url[rowimg0][]" type="hidden" class="form-control" value="" required>
                                                        <span class="invalid-feedback" style="display:block;"><?= form_error('poster_url[rowimg0][0]') ?></span>
                                                        <input type="hidden" name="productidimg[rowimg0][]" value="<?php echo $article_id?>">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12" align="center">
                                <button type="button" class="btn btn-sm btn-primary btn-add-img">Add More</button>
                                <button type="button" class="btn btn-sm btn-danger btn-remove-img">Delete</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Poster Content Videos (*required)</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Video</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-vid">
                                            <tr id="rowvid0" class="content_videos1">
                                                <td>
                                                    <span class="btn btn-sm btn-default">1</span>
                                                    <input type="hidden" name="count_videos[]" value="6437">
                                                </td>
                                                <td class="vid_contents">
                                                    <div class="contacts__item">
                                                        <a class="contacts__img">
                                                            <img id="vid_pos0" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                                        </a>
                                                        <a class="btn btn-light callfunctionvid" onclick="show_modal('vid', 'vid_pos0', 'rowvid0')">Upload</a>
                                                        <input name="stream_url[rowvid0][]" type="hidden" class="form-control" value="" required>
                                                        <span class="invalid-feedback" style="display:block;"><?= form_error('stream_url[rowvid0][0]') ?></span>
                                                        <input name="stream_id[rowvid0][]" type="hidden" class="form-control" value="" required>
                                                        <input name="stream_type[rowvid0][]" type="hidden" class="form-control" value="" required>
                                                        <input name="poster_url_vid[rowvid0][]" type="hidden" class="form-control" value="" required>
                                                        <input name="poster_id_vid[rowvid0][]" type="hidden" class="form-control" value="" required>
                                                        <input type="hidden" name="productidvid[rowvid0][]" value="">
                                                        <input type="hidden" name="productidstream[rowvid0][]" value="<?php echo $article_id?>">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12" align="center">
                                <button type="button" class="btn btn-sm btn-primary btn-add-vid">Add More</button>
                                <button type="button" class="btn btn-sm btn-danger btn-remove-vid">Delete</button>
                            </div>
                        </div>
                        <input type="hidden" name="status_images" id="status_images" value="add">
                        <input type="hidden" name="status_videos" id="status_videos" value="add">
                        <div class="col-md-12" align="center">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-image" tabindex="-1" style="display: none;" aria-hidden="true">
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
                <button type="button" class="btn btn-link" onclick="getUrlImage()">Save</button>
                <button id="backimagelandscape" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-video" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Select a video</h5>
            </div>
            <div class="modal-body">
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#active_art" role="tab">Videos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabledTab" data-toggle="tab" href="#inactive_art" role="tab">Embed Videos</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active fade show" id="active_art" role="tabpanel">
                            <h4 align="center">Videos</h4><br><br>
                            <div class="page-loader loadimage2">
                                <div class="page-loader__spinner">
                                    <svg viewBox="25 25 50 50">
                                        <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                                    </svg>
                                </div>
                            </div>
                            <div id="changing-video" class="tester">
                                <select class='image-picker show-html vid_sel' name="vid_sel">
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="inactive_art" role="tabpanel">
                            <!-- <div class="row">
                                <div class="col-md-12" align="center">
                                    <div name="embed_sel" class="col-xl-2 col-lg-3 col-sm-4 col-6" align="center">
                                        <div class="contacts__item" id="embed" align="center">
                                            <label>Image</label>
                                            <a href="#" class="contacts__img">
                                                <img id="embed_pos" src="" alt="" width="100" height="100">
                                            </a>
                                            <a class="btn btn-success btn-sm" name="embed_images" id="embed_images">Choose Image</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <textarea id="embed_video" name="embed_video" class="wysiwyg-editor"></textarea>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="url_image_video" name="url_image_video">
                <input type="hidden" id="url_video_final" name="url_video_final">
                <input type="hidden" id="streamtype" name="streamtype">
                <input type="hidden" id="prodid" name="prodid">
                <button id="preview_vid" type="button" class="btn btn-link">Preview Video</button>
                <button type="button" class="btn btn-link" onclick="getUrlVideo()">Save</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.player = videojs('my-video');

    $(document).ready(function(){
        // get data image
        get_data_images();

        // get data videos
        get_data_videos();

        // add or delete images
        $("body").on('click', '.btn-add-img', function (e) {
            e.preventDefault();
            var $sr = ($(".content_images1").length);
            var $no = ($(".content_images1").length+1);
            var $rdm = Math.floor((Math.random() * 10000) + 1)
            var $html = `<tr id="rowimg${$sr}" class="content_images1">
                            <td>
                                <span class="btn btn-sm btn-default">${$no}</span>
                                <input type="hidden" name="count_images[]" value="${$rdm}">
                            </td>
                            <td class="img_contents">
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_pos${$sr}" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction" onclick="show_modal('img', 'img_pos${$sr}', 'rowimg${$sr}')">Upload</a>
                                    <input name="poster_url[rowimg${$sr}][]" type="hidden" class="form-control" value="">
                                    <input type="hidden" name="productidimg[rowimg${$sr}][]" value="<?php echo $article_id?>">
                                </div>
                            </td>
                        </tr>`
            $("#table-img").append($html);
            if ($('.img_contents input').val.length ==0) {
                $('.btn-add-img').attr('disabled', true);
            } else {
                $('.btn-add-img').attr('disabled', false);
            }
        });

        $("body").on('click', '.btn-remove-img', function (e) {
            e.preventDefault();
            if ($("#table-img tr:last-child").attr('id') != 'rowimg0') {
                $("#table-img tr:last-child").remove();
            }
        });
        // add or delete images

        // add or delete videos
        $("body").on('click', '.btn-add-vid', function (e) {
            e.preventDefault();
            var $sr = ($(".content_videos1").length);
            var $no = ($(".content_videos1").length+1);
            var $rdm = Math.floor((Math.random() * 10000) + 1)
            var $html = `<tr id="rowvid${$sr}" class="content_videos1">
                            <td>
                                <span class="btn btn-sm btn-default">${$no}</span>
                                <input type="hidden" name="count_videos[]" value="${$rdm}">
                            </td>
                            <td class="vid_contents">
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="vid_pos${$sr}" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                    </a>
                                    <a class="btn btn-light callfunctionvid" onclick="show_modal('vid', 'vid_pos${$sr}', 'rowvid${$sr}')">Upload</a>
                                    <input name="stream_url[rowvid${$sr}][]" type="hidden" class="form-control" value="">
                                    <input name="stream_id[rowvid${$sr}][]" type="hidden" class="form-control" value="">
                                    <input name="stream_type[rowvid${$sr}][]" type="hidden" class="form-control" value="">
                                    <input name="poster_url_vid[rowvid${$sr}][]" type="hidden" class="form-control" value="">
                                    <input name="poster_id_vid[rowvid${$sr}][]" type="hidden" class="form-control" value="">
                                    <input type="hidden" name="productidvid[rowvid${$sr}][]" value="">
                                    <input type="hidden" name="productidstream[rowvid${$sr}][]" value="<?php echo $article_id?>">
                                </div>
                            </td>
                        </tr>`
            $("#table-vid").append($html);
            if ($('.vid_contents input').val.length ==0) {
                $('.btn-add-vid').attr('disabled', true);
            } else {
                $('.btn-add-vid').attr('disabled', false);
            }
        });

        $("body").on('click', '.btn-remove-vid', function (e) {
            e.preventDefault();
            if ($("#table-vid tr:last-child").attr('id') != 'rowvid0') {
                $("#table-vid tr:last-child").remove();
            }
        });
        // add or delete videos

        // image popup
        $("select").imagepicker();

        $('.callfunction').click(function () {
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>articles/compare_image_banner',
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
                url: '<?php echo base_url() ?>articles/get_token',
                success: function(data) {
                    $('#changing-contentimage1')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=denslife_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backimagelandscape').click(function () {
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>articles/compare_image_banner',
                success: function(data){
                    data = JSON.parse(data);
                    var _gallery = "<select class='image-picker show-html'>";
                    if (data.error==0) {
                        var content = data.content
                        if(content!=null){
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1);
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>";
                            }
                        }
                    }
                    _gallery = _gallery+"</select>";
                    $('#changing-contentimage1').html(_gallery);
                    $("select").imagepicker();
                }
            });
        });
        // image popup

        // video popup
        $('.callfunctionvid').click(function () {
            $(".loadimage2").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>articles/get_video',
                success: function(data) {
                    data = JSON.parse(data)
                    var _gallery = "<select class='image-picker show-html vid_sel' name='vid_sel'>";
                    if (data!=null) {
                        for (var i = 0; i < data.length; i++) {
                            var _counter = parseInt(i+1);
                            _gallery = _gallery + "<option data-img-src='"+data[i]['url_video_poster']+"' data-img-alt='Image "+_counter+"' value='"+data[i]['url_video']+"'> Image "+_counter+"</option>";
                        }
                    }
                    _gallery = _gallery+"</select>";
                    setTimeout(function(){$(".loadimage2").fadeOut()},500)
                    $('#changing-video').html(_gallery);
                    $("select").imagepicker();
                    var url_videos = $('.vid_sel').find("option:first-child").val()
                    var url_images = $('.vid_sel').find("option:first-child").attr('data-img-src')
                    $('#url_image_video').val(url_images)
                    $('#url_video_final').val(url_videos)
                    $('#streamtype').val('AVO')
                    var info_id = $('#modal-video').attr('data-vidid-name');
                    var matche = info_id.replace("rowvid", "");
                    var matches = +matche+1;
                    var prodid = 'AVO_'+'<?php echo $article_id?>'+'_'+matches;
                    $('#prodid').val(prodid);
                    $('[name=vid_sel]').on('change', function(e){
                        var optionVideo = $("option:selected", this);
                        var optionImage = $(optionVideo).attr('data-img-src');
                        var valueSelected = this.value;
                        var info_id = $('#modal-video').attr('data-vidid-name');
                        var matche = info_id.replace("rowvid", "");
                        var matches = +matche+1;
                        var prodid = 'AVO_'+'<?php echo $article_id?>'+'_'+matches;
                        $('#url_image_video').val(optionImage)
                        $('#url_video_final').val(valueSelected)
                        $('#streamtype').val('AVO')
                        $('#prodid').val(prodid);
                    })
                }
            });
        })

        $('#preview_vid').click(function () {
            var image = $('#modal-video .image_picker_selector').find('.selected').find('img').attr('src');
            var video_sel = $('[name=vid_sel]').val();
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
                src: video_sel,
                type: 'application/x-mpegURL',
                // withCredentials: true
            });
            $('#modal-preview').modal('show');
        });

        $('#modal-preview').on('hidden.bs.modal', function (e) {
            player.pause();
        });
        // video popup
    })

    function show_modal(type, img, id) {
        if (type == 'img') {
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>articles/compare_image_banner',
                success: function(data) {
                    data = JSON.parse(data);
                    var _gallery = "<select class='image-picker show-html'>";
                    if (data.error==0) {
                        var content = data.content
                        if(content!=null){
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
            // add data attribute into modal
            $('#modal-image').attr('data-img-name', img);
            $('#modal-image').attr('data-id-name', id);
            // show modal
            $('#modal-image').modal('show');
        } else {
            $(".loadimage2").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>articles/get_video',
                success: function(data) {
                    data = JSON.parse(data)
                    var _gallery = "<select class='image-picker show-html vid_sel' name='vid_sel'>";
                    if (data!=null) {
                        for (var i = 0; i < data.length; i++) {
                            var _counter = parseInt(i+1);
                            _gallery = _gallery + "<option data-img-src='"+data[i]['url_video_poster']+"' data-img-alt='Image "+_counter+"' value='"+data[i]['url_video']+"'> Image "+_counter+"</option>";
                        }
                    }
                    _gallery = _gallery+"</select>";
                    setTimeout(function(){$(".loadimage2").fadeOut()},500)
                    $('#changing-video').html(_gallery);
                    $("select").imagepicker();
                    var url_videos = $('.vid_sel').find("option:first-child").val()
                    var url_images = $('.vid_sel').find("option:first-child").attr('data-img-src')
                    $('#url_image_video').val(url_images)
                    $('#url_video_final').val(url_videos)
                    $('#streamtype').val('AVO')
                    var info_id = $('#modal-video').attr('data-vidid-name');
                    var matche = info_id.replace("rowvid", "");
                    var matches = +matche+1;
                    var prodid = 'AVO_'+'<?php echo $article_id?>'+'_'+matches;
                    $('#prodid').val(prodid);
                    $('[name=vid_sel]').on('change', function(e){
                        var optionVideo = $("option:selected", this);
                        var optionImage = $(optionVideo).attr('data-img-src');
                        var valueSelected = this.value;
                        var info_id = $('#modal-video').attr('data-vidid-name');
                        var matche = info_id.replace("rowvid", "");
                        var matches = +matche+1;
                        var prodid = 'AVO_'+'<?php echo $article_id?>'+'_'+matches;
                        $('#url_image_video').val(optionImage)
                        $('#url_video_final').val(valueSelected)
                        $('#streamtype').val('AVO')
                        $('#prodid').val(prodid);
                    })
                }
            });
            // add data attribute into modal
            $('#modal-video').attr('data-vid-name', img);
            $('#modal-video').attr('data-vidid-name', id);
            // show modal
            $('#modal-video').modal('show');
        }
    }

    $('#modal-video').on('shown.bs.modal', function (e) {
        $('[name=vid_sel]').change();
    })

    $(document).on('show.bs.modal', '.modal', function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });

    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal:visible').length && $(document.body).addClass('modal-open');
    });

    function getUrlImage() {
        var image = $('#modal-image .image_picker_selector').find('.selected').find('img').attr('src');
        var info_img = $('#modal-image').attr('data-img-name');
        var info_id = $('#modal-image').attr('data-id-name');
        // set value into element
        $('#' + info_img).attr('src', image);
        $('#' + info_id).val(image);
        $('#' + info_id).find('[name="poster_url['+info_id+'][]"]').val(image)
        // hide modal
        $('#modal-image').modal('hide');
    }

    function getUrlVideo() {
        var image = $('#url_image_video').val()
        var video_sel = $('#url_video_final').val()
        var streamtype = $('#streamtype').val()
        var prodid = $('#prodid').val()
        var info_img = $('#modal-video').attr('data-vid-name');
        var info_id = $('#modal-video').attr('data-vidid-name');
        // set value into element
        $('#' + info_img).attr('src', image);
        $('#' + info_id).val(image);
        $('#' + info_id).find('[name="stream_url['+info_id+'][]"]').val(video_sel);
        $('#' + info_id).find('[name="poster_url_vid['+info_id+'][]"]').val(image);
        $('#' + info_id).find('[name="stream_type['+info_id+'][]"]').val(streamtype);
        $('#' + info_id).find('[name="productidvid['+info_id+'][]"]').val(prodid);
        // hide modal
        $('#modal-video').modal('hide');
    }

    function get_data_images() {
        var article_id = $('[name="productidimg[rowimg0][]"]').val();
        $.ajax({
            url : "<?php echo site_url('articles/get_data_images');?>",
            method : "POST",
            data :{article_id :article_id},
            async : true,
            dataType : 'json',
            success : function(data) {
                if (data!=null) {
                    var status = data.error
                    if (status==0) {
                        var poster = data.poster
                        var elem = ''
                        var i = 0
                        $.each(poster, function(idx, val) {
                            var hidden_fields=''
                            for (var j = 0; j < val.length; j++) {
                                hidden_fields += '<input type="hidden" name="poster_url[rowimg' + i +'][]" value="'+val[j].poster_url+'" required>'+
                                '<input type="hidden" name="productidimg[rowimg' + i +'][]" value="<?php echo $article_id?>">'+
                                '<input type="hidden" name="poster_id[rowimg' + i +'][]" value="'+val[j].poster_id+'">'+
                                '<input type="hidden" name="poster_type[rowimg' + i +'][]" value="'+val[j].product_id+'">'
                            }
                            elem += `<tr id="rowimg${i}" class="content_images1">
                                <td>
                                    <span class="btn btn-sm btn-default">${i+1}</span>
                                    <input type="hidden" name="count_images[]" value="6437">
                                </td>
                                <td class="img_contents">
                                    <div class="contacts__item">
                                        <a class="contacts__img">
                                            <img id="img_pos${i}" src="${val[0].poster_url}" alt="">
                                        </a>
                                        <a class="btn btn-light callfunction" onclick="show_modal('img', 'img_pos${i}', 'rowimg${i}')">Upload</a>
                                        ${hidden_fields}
                                    </div>
                                </td>
                            </tr>`
                            i++;
                        })
                        $('#table-img').html(elem);
                        $('[name="status_images"]').val('edit').trigger('change');
                    } else {
                        $('[name="status_images"]').val('add').trigger('change');
                    }
                } else {
                    $('[name="status_images"]').val('add').trigger('change');
                }
            }
        });
    }

    function get_data_videos() {
        var article_id = $('[name="productidimg[rowimg0][]"]').val();
        $.ajax({
            url : "<?php echo site_url('articles/get_data_videos');?>",
            method : "POST",
            data :{article_id :article_id},
            async : true,
            dataType : 'json',
            success : function(data) {
                if (data!=null) {
                    var status = data.error
                    if (status==0) {
                        var poster = data.poster
                        var elem = ''
                        var i = 0
                        $.each(poster, function(idx, val) {
                            var hidden_fields=''
                            for (var j = 0; j < val.length; j++) {
                                hidden_fields += '<input type="hidden" name="stream_url[rowvid' + i +'][]" value="'+val[j].stream_url+'" required>'+
                                '<input type="hidden" name="stream_id[rowvid' + i +'][]" value="'+val[j].stream_id+'">'+
                                '<input type="hidden" name="stream_type[rowvid' + i +'][]" value="'+val[j].stream_type+'">'+
                                '<input type="hidden" name="poster_url_vid[rowvid' + i +'][]" value="'+val[j].poster_url+'">'+
                                '<input type="hidden" name="poster_id_vid[rowvid' + i +'][]" value="'+val[j].poster_id+'">'+
                                '<input type="hidden" name="productidvid[rowvid' + i +'][]" value="'+val[j].product_id+'">'+
                                '<input type="hidden" name="productidvidimg[rowvid' + i +'][]" value="'+val[j].productid_poster+'">'
                            }
                            elem += `<tr id="rowvid${i}" class="content_videos1">
                                <td>
                                    <span class="btn btn-sm btn-default">${i+1}</span>
                                    <input type="hidden" name="count_videos[]" value="6437">
                                </td>
                                <td class="vid_contents">
                                    <div class="contacts__item">
                                        <a class="contacts__img">
                                            <img id="vid_pos${i}" src="${val[0].poster_url}" alt="">
                                        </a>
                                        <a class="btn btn-light callfunctionvid" onclick="show_modal('vid', 'vid_pos${i}', 'rowvid${i}')">Upload</a>
                                        <input type="hidden" name="productidstream[rowvid${i}][]" value="<?php echo $article_id?>">
                                        ${hidden_fields}
                                    </div>
                                </td>
                            </tr>`
                            i++;
                        })
                        $('#table-vid').html(elem);
                        $('[name="status_videos"]').val('edit').trigger('change');
                    } else {
                        $('[name="status_videos"]').val('add').trigger('change');
                    }
                } else {
                    $('[name="status_videos"]').val('add').trigger('change');
                }
            }
        });
    }
</script>