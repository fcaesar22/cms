<style type="text/css">
    select{display: block !important;}
    select.image-picker{margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 200px;height: 130px;}
    #changing-contentimage2 .image_picker_image {width: 130px;height: 200px;}
    .contacts__img>img{width: 100px;height: 100px;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Movies</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('movies') ?>">Movies</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('movies/edit/'.$movie_id) ?>">Edit Movies</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <form action="" method="post" id="form_submit" name="form_submit" autocomplete="off">
                    <h4 class="card-title" align="center">Poster & Stream</h4>
                    <div class="jumbotron jumboPoster">
                        <p class="lead">Poster</p>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Poster Landscape (*required)</label>
                                    <div class="contacts__item">
                                        <a class="contacts__img">
                                            <img id="img_landscape" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                        </a>
                                        <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-imagelandscape">Upload</a>
                                        <input type="hidden" name="url_vod_1280x720" id="url_vod_1280x720" class="form-control" value="">
                                        <input type="hidden" name="id_vod_1280x720" id="id_vod_1280x720" class="form-control" value="">
                                        <input type="hidden" name="url_vod_410x230" id="url_vod_410x230" class="form-control" value="">
                                        <input type="hidden" name="id_vod_410x230" id="id_vod_410x230" class="form-control" value="">
                                        <input type="hidden" name="url_vod_235x132" id="url_vod_235x132" class="form-control" value="">
                                        <input type="hidden" name="id_vod_235x132" id="id_vod_235x132" class="form-control" value="">
                                        <br>
                                        <span id="imglandscape_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Poster Portrait (*required)</label>
                                    <div class="contacts__item">
                                        <a class="contacts__img">
                                            <img id="img_portrait" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                                        </a>
                                        <a class="btn btn-light callfunction2" data-toggle="modal" data-target="#modal-imageportrait">Upload</a>
                                        <input type="hidden" name="url_vod_549x825" id="url_vod_549x825" class="form-control" value="">
                                        <input type="hidden" name="id_vod_549x825" id="id_vod_549x825" class="form-control" value="">
                                        <input type="hidden" name="url_vod_183x275" id="url_vod_183x275" class="form-control" value="">
                                        <input type="hidden" name="id_vod_183x275" id="id_vod_183x275" class="form-control" value="">
                                        <input type="hidden" name="url_vod_170x252" id="url_vod_170x252" class="form-control" value="">
                                        <input type="hidden" name="id_vod_170x252" id="id_vod_170x252" class="form-control" value="">
                                        <input type="hidden" name="url_vod_122x182" id="url_vod_122x182" class="form-control" value="">
                                        <input type="hidden" name="id_vod_122x182" id="id_vod_122x182" class="form-control" value="">
                                        <br>
                                        <span id="imgportrait_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="jumbotron jumboStream" style="display: none;">
                        <p class="lead">Stream</p>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="duration" class="col-md-4 col-form-label">Duration (*required)</label>
                                    <div class="col-md-8">
                                        <input type="number" name="duration" id="duration" step="1" class="form-control" placeholder="Please Input Duration" value="" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                        <span id="duration_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="web_stream_url" class="col-md-4 col-form-label">Stream URL VOD PC HLS( 255 Char) (*required)</label>
                                    <div class="col-md-8">
                                        <input type="text" name="web_stream_url" id="web_stream_url" class="form-control" placeholder="Please Input URL" value="">
                                        <input type="hidden" name="web_stream_id" id="web_stream_id" class="form-control" value="">
                                        <span id="streamweb_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="stb_stream_url" class="col-md-4 col-form-label">Stream URL VOD STB HLS( 255 Char) (*required)</label>
                                    <div class="col-md-8">
                                        <input type="text" name="stb_stream_url" id="stb_stream_url" class="form-control" placeholder="Please Input URL" value="">
                                        <input type="hidden" name="stb_stream_id" id="stb_stream_id" class="form-control" value="">
                                        <span id="streamstb_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="ios_stream_url" class="col-md-4 col-form-label">Stream URL VOD IOS PHONE HLS( 255 Char) (*required)</label>
                                    <div class="col-md-8">
                                        <input type="text" name="ios_stream_url" id="ios_stream_url" class="form-control" placeholder="Please Input URL" value="">
                                        <input type="hidden" name="ios_stream_id" id="ios_stream_id" class="form-control" value="">
                                        <span id="streamios_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="ios_pad_stream_url" class="col-md-4 col-form-label">Stream URL VOD IOS PAD HLS( 255 Char) (*required)</label>
                                    <div class="col-md-8">
                                        <input type="text" name="ios_pad_stream_url" id="ios_pad_stream_url" class="form-control" placeholder="Please Input URL" value="">
                                        <input type="hidden" name="ios_pad_stream_id" id="ios_pad_stream_id" class="form-control" value="">
                                        <span id="streamiospad_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="android_stream_url" class="col-md-4 col-form-label">Stream URL VOD ANDROID PHONE HLS( 255 Char) (*required)</label>
                                    <div class="col-md-8">
                                        <input type="text" name="android_stream_url" id="android_stream_url" class="form-control" placeholder="Please Input URL" value="">
                                        <input type="hidden" name="android_stream_id" id="android_stream_id" class="form-control" value="">
                                        <span id="streamandroid_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="android_pad_stream_url" class="col-md-4 col-form-label">Stream URL VOD ANDROID PAD HLS( 255 Char) (*required)</label>
                                    <div class="col-md-8">
                                        <input type="text" name="android_pad_stream_url" id="android_pad_stream_url" class="form-control" placeholder="Please Input URL" value="">
                                        <input type="hidden" name="android_pad_stream_id" id="android_pad_stream_id" class="form-control" value="">
                                        <span id="streamandroidpad_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="octoshape_stream_url" class="col-md-4 col-form-label">Stream URL VOD Octoshape Adaptive smil Abr( 255 Char)</label>
                                    <div class="col-md-8">
                                        <input type="text" name="octoshape_stream_url" id="octoshape_stream_url" class="form-control" placeholder="Please Input URL" value="">
                                        <input type="hidden" name="octoshape_stream_id" id="octoshape_stream_id" class="form-control" value="">
                                        <span id="streamoctoshape_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="octoshape2400k_stream_url" class="col-md-4 col-form-label">Stream URL VOD Octoshape 2400K( 255 Char) (*required)</label>
                                    <div class="col-md-8">
                                        <input type="text" name="octoshape2400k_stream_url" id="octoshape2400k_stream_url" class="form-control" placeholder="Please Input URL" value="">
                                        <input type="hidden" name="octoshape2400k_stream_id" id="octoshape2400k_stream_id" class="form-control" value="">
                                        <span id="streamoctoshape2400k_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="trailer_stream_url" class="col-md-4 col-form-label">Stream URL VOD Trailer Youtube( 255 Char) (*required)</label>
                                    <div class="col-md-8">
                                        <input type="text" name="trailer_stream_url" id="trailer_stream_url" class="form-control" placeholder="Please Input URL" value="">
                                        <input type="hidden" name="trailer_stream_id" id="trailer_stream_id" class="form-control" value="">
                                        <span id="streamtrailer_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="download_stream_url" class="col-md-4 col-form-label">Stream URL Download low bitrate( 255 Char) (*required)</label>
                                    <div class="col-md-8">
                                        <input type="text" name="download_stream_url" id="download_stream_url" class="form-control" placeholder="Please Input URL" value="">
                                        <input type="hidden" name="download_stream_id" id="download_stream_id" class="form-control" value="">
                                        <span id="streamdownload_val" class="notify" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="movie_id" id="movie_id" value="<?php echo $movie_id?>">
                    <input type="hidden" name="movie_type" id="movie_type" value="<?php echo $movie_type?>">
                    <div class="col-md-12" align="center">
                        <button class="btn btn-success" type="button" id="upload" name="upload">Submit</button>
                    </div>
                </form>
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
            <div class="modal-footer" style="justify-content: center;">
                <button id="uploadimagelandscape" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlLandscape()">Save</button>
                <button id="backimagelandscape" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-imageportrait" tabindex="-1" style="display: none;" aria-hidden="true">
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
                <button id="uploadimageportrait" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlPortrait()">Save</button>
                <button id="backimageportrait" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-submit" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left"></h5>
            </div>
            <div class="modal-body">
                <div id="warding_submit" style="text-align: center; color: red; font-size: 14px; margin-bottom: 10px;"></div>
                <h5 style="text-align: center;">are you sure?</h5>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button id="submit_data" type="button" class="btn btn-link">Save</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var movieType = $('#movie_type').val()
        if (movieType == 'SIN') {
            $('.jumboStream').css("display", "block");
        }

        $(document).on('click','#upload', function() {
            var self = $('#form_submit');
            var url_vod_1280x720_res = $(self).find('#url_vod_1280x720').val();
            var url_vod_410x230_res = $(self).find('#url_vod_410x230').val();
            var url_vod_235x132_res = $(self).find('#url_vod_235x132').val();
            var url_vod_549x825_res = $(self).find('#url_vod_549x825').val();
            var url_vod_183x275_res = $(self).find('#url_vod_183x275').val();
            var url_vod_170x252_res = $(self).find('#url_vod_170x252').val();
            var url_vod_122x182_res = $(self).find('#url_vod_122x182').val();
            var duration_res = $(self).find('#duration').val();
            var web_stream_url_res = $(self).find('#web_stream_url').val();
            var stb_stream_url_res = $(self).find('#stb_stream_url').val();
            var ios_stream_url_res = $(self).find('#ios_stream_url').val();
            var ios_pad_stream_url_res = $(self).find('#ios_pad_stream_url').val();
            var android_stream_url_res = $(self).find('#android_stream_url').val();
            var android_pad_stream_url_res = $(self).find('#android_pad_stream_url').val();

            let count=0;
            if (url_vod_1280x720_res == '' || url_vod_1280x720_res == null) {
                $('#imglandscape_val').text('* Please upload image landscape');
                ++count;
            }
            if (url_vod_410x230_res == '' || url_vod_410x230_res == null) {
                $('#imglandscape_val').text('* Please upload image landscape');
                ++count;
            }
            if (url_vod_235x132_res == '' || url_vod_235x132_res == null) {
                $('#imglandscape_val').text('* Please upload image landscape');
                ++count;
            }
            if (url_vod_549x825_res == '' || url_vod_549x825_res == null) {
                $('#imgportrait_val').text('* Please upload image portrait');
                ++count;
            }
            if (url_vod_183x275_res == '' || url_vod_183x275_res == null) {
                $('#imgportrait_val').text('* Please upload image portrait');
                ++count;
            }
            if (url_vod_170x252_res == '' || url_vod_170x252_res == null) {
                $('#imgportrait_val').text('* Please upload image portrait');
                ++count;
            }
            if (url_vod_122x182_res == '' || url_vod_122x182_res == null) {
                $('#imgportrait_val').text('* Please upload image portrait');
                ++count;
            }
            if (movieType=='SIN')
            {
                if (duration_res == '' || duration_res == null) {
                    $('#duration_val').text('* Please input duration');
                    ++count;
                }
                if (web_stream_url_res == '' || web_stream_url_res == null) {
                    $('#streamweb_val').text('* Please input web url');
                    ++count;
                }
                if (stb_stream_url_res == '' || stb_stream_url_res == null) {
                    $('#streamstb_val').text('* Please input stb url');
                    ++count;
                }
                if (ios_stream_url_res == '' || ios_stream_url_res == null) {
                    $('#streamios_val').text('* Please input ios url');
                    ++count;
                }
                if (ios_pad_stream_url_res == '' || ios_pad_stream_url_res == null) {
                    $('#streamiospad_val').text('* Please input ios pas url');
                    ++count;
                }
                if (android_stream_url_res == '' || android_stream_url_res == null) {
                    $('#streamandroid_val').text('* Please input android url');
                    ++count;
                }
                if (android_pad_stream_url_res == '' || android_pad_stream_url_res == null) {
                    $('#streamandroidpad_val').text('* Please input android pad url');
                    ++count;
                }
            }
            if(count>0){
                $("html, body").animate({ scrollTop: 0 }, "slow");
                return;
            }
            else
            {
                $('#modal-submit').modal('show')
            }
        })

        $(document).on('click','#submit_data', function() {
            var self = $('#form_submit');
            var url_vod_1280x720_res = $(self).find('#url_vod_1280x720').val();
            var id_vod_1280x720_res = $(self).find('#id_vod_1280x720').val();
            var url_vod_410x230_res = $(self).find('#url_vod_410x230').val();
            var id_vod_410x230_res = $(self).find('#id_vod_410x230').val();
            var url_vod_235x132_res = $(self).find('#url_vod_235x132').val();
            var id_vod_235x132_res = $(self).find('#id_vod_235x132').val();
            var url_vod_549x825_res = $(self).find('#url_vod_549x825').val();
            var id_vod_549x825_res = $(self).find('#id_vod_549x825').val();
            var url_vod_183x275_res = $(self).find('#url_vod_183x275').val();
            var id_vod_183x275_res = $(self).find('#id_vod_183x275').val();
            var url_vod_170x252_res = $(self).find('#url_vod_170x252').val();
            var id_vod_170x252_res = $(self).find('#id_vod_170x252').val();
            var url_vod_122x182_res = $(self).find('#url_vod_122x182').val();
            var id_vod_122x182_res = $(self).find('#id_vod_122x182').val();
            var duration_res = $(self).find('#duration').val();
            var web_stream_url_res = $(self).find('#web_stream_url').val();
            var web_stream_id_res = $(self).find('#web_stream_id').val();
            var stb_stream_url_res = $(self).find('#stb_stream_url').val();
            var stb_stream_id_res = $(self).find('#stb_stream_id').val();
            var ios_stream_url_res = $(self).find('#ios_stream_url').val();
            var ios_stream_id_res = $(self).find('#ios_stream_id').val();
            var ios_pad_stream_url_res = $(self).find('#ios_pad_stream_url').val();
            var ios_pad_stream_id_res = $(self).find('#ios_pad_stream_id').val();
            var android_stream_url_res = $(self).find('#android_stream_url').val();
            var android_stream_id_res = $(self).find('#android_stream_id').val();
            var android_pad_stream_url_res = $(self).find('#android_pad_stream_url').val();
            var android_pad_stream_id_res = $(self).find('#android_pad_stream_id').val();
            var octoshape_stream_url_res = $(self).find('#octoshape_stream_url').val();
            var octoshape_stream_id_res = $(self).find('#octoshape_stream_id').val();
            var octoshape2400k_stream_url_res = $(self).find('#octoshape2400k_stream_url').val();
            var octoshape2400k_stream_id_res = $(self).find('#octoshape2400k_stream_id').val();
            var trailer_stream_url_res = $(self).find('#trailer_stream_url').val();
            var trailer_stream_id_res = $(self).find('#trailer_stream_id').val();
            var download_stream_url_res = $(self).find('#download_stream_url').val();
            var download_stream_id_res = $(self).find('#download_stream_id').val();
            var movieType = $('#movie_type').val()
            var movieID = $('#movie_id').val()

            $('#submit_data').text('Submit...');
            $('#submit_data').attr('disabled', true);

            var url = '<?php echo base_url() ?>movies/poster_and_stream';
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    url_vod_1280x720:url_vod_1280x720_res,
                    id_vod_1280x720:id_vod_1280x720_res,
                    url_vod_410x230:url_vod_410x230_res,
                    id_vod_410x230:id_vod_410x230_res,
                    url_vod_235x132:url_vod_235x132_res,
                    id_vod_235x132:id_vod_235x132_res,
                    url_vod_549x825:url_vod_549x825_res,
                    id_vod_549x825:id_vod_549x825_res,
                    url_vod_183x275:url_vod_183x275_res,
                    id_vod_183x275:id_vod_183x275_res,
                    url_vod_170x252:url_vod_170x252_res,
                    id_vod_170x252:id_vod_170x252_res,
                    url_vod_122x182:url_vod_122x182_res,
                    id_vod_122x182:id_vod_122x182_res,
                    duration:duration_res,
                    web_stream_url:web_stream_url_res,
                    web_stream_id:web_stream_id_res,
                    stb_stream_url:stb_stream_url_res,
                    stb_stream_id:stb_stream_id_res,
                    ios_stream_url:ios_stream_url_res,
                    ios_stream_id:ios_stream_id_res,
                    ios_pad_stream_url:ios_pad_stream_url_res,
                    ios_pad_stream_id:ios_pad_stream_id_res,
                    android_stream_url:android_stream_url_res,
                    android_stream_id:android_stream_id_res,
                    android_pad_stream_url:android_pad_stream_url_res,
                    android_pad_stream_id:android_pad_stream_id_res,
                    octoshape_stream_url:octoshape_stream_url_res,
                    octoshape_stream_id:octoshape_stream_id_res,
                    octoshape2400k_stream_url:octoshape2400k_stream_url_res,
                    octoshape2400k_stream_id:octoshape2400k_stream_id_res,
                    trailer_stream_url:trailer_stream_url_res,
                    trailer_stream_id:trailer_stream_id_res,
                    download_stream_url:download_stream_url_res,
                    download_stream_id:download_stream_id_res,
                    movie_id:movieID,
                    movie_type:movieType,
                },
                success: function(response){
                    var result = JSON.parse(response);
                    if (result.res == 0) {
                        window.location.href ='<?php echo base_url() ?>movies';
                    } else {
                        $('#submit_data').text('Submit');
                        $('#submit_data').attr('disabled', false);
                        $('#warding_submit').html(result.msg)
                        $("#warding_submit").show();
                        setTimeout(function() { $("#warding_submit").hide(); }, 5000);
                    }
                }
            });
        });

        get_data_poster_stream();
    })

    function get_data_poster_stream(){
        var movie_id = $('[name="movie_id"]').val();
        $.ajax({
            url : "<?php echo site_url('movies/get_data_poster_stream');?>",
            method : "POST",
            data :{movie_id :movie_id},
            async : true,
            dataType : 'json',
            success : function(data){
                // poster
                populateForm(data.poster.portrait, "portrait");
                populateForm(data.poster.landscape, "landscape");
                // stream
                $.each(data.stream, function(index, streamData) {
                    switch (streamData.stream_screen) {
                        case "101":
                            $('#web_stream_url').val(streamData.stream_url);
                            $('#web_stream_id').val(streamData.stream_id);
                            $('#duration').val(streamData.stream_length);
                            break;
                        case "201":
                            $('#stb_stream_url').val(streamData.stream_url);
                            $('#stb_stream_id').val(streamData.stream_id);
                            $('#duration').val(streamData.stream_length);
                            break;
                        case "301":
                            $('#ios_stream_url').val(streamData.stream_url);
                            $('#ios_stream_id').val(streamData.stream_id);
                            $('#duration').val(streamData.stream_length);
                            break;
                        case "401":
                            $('#ios_pad_stream_url').val(streamData.stream_url);
                            $('#ios_pad_stream_id').val(streamData.stream_id);
                            $('#duration').val(streamData.stream_length);
                            break;
                        case "501":
                            $('#android_stream_url').val(streamData.stream_url);
                            $('#android_stream_id').val(streamData.stream_id);
                            $('#duration').val(streamData.stream_length);
                            break;
                        case "601":
                            $('#android_pad_stream_url').val(streamData.stream_url);
                            $('#android_pad_stream_id').val(streamData.stream_id);
                            $('#duration').val(streamData.stream_length);
                            break;
                        case "202":
                            $('#octoshape_stream_url').val(streamData.stream_url);
                            $('#octoshape_stream_id').val(streamData.stream_id);
                            break;
                        case "102":
                            $('#octoshape2400k_stream_url').val(streamData.stream_url);
                            $('#octoshape2400k_stream_id').val(streamData.stream_id);
                            break;
                        case "103":
                            $('#trailer_stream_url').val(streamData.stream_url);
                            $('#trailer_stream_id').val(streamData.stream_id);
                            break;
                        case "701":
                            $('#download_stream_url').val(streamData.stream_url);
                            $('#download_stream_id').val(streamData.stream_id);
                            break;
                        default:
                            break;
                    }
                });
            }
        });
    }

    function populateForm(posters, type) {
        $.each(posters, function(index, poster) {
            // Cari elemen input hidden sesuai dengan poster_type
            if (type === "portrait") {
                $("#" + "url_" + poster.poster_type).val(poster.poster_url);
                $("#" + "id_" + poster.poster_type).val(poster.poster_id);
                $("#img_portrait").attr("src", poster.poster_url);
            } else if (type === "landscape") {
                $("#" + "url_" + poster.poster_type).val(poster.poster_url);
                $("#" + "id_" + poster.poster_type).val(poster.poster_id);
                $("#img_landscape").attr("src", poster.poster_url);
            }
        });
    }

    // image landscape
    $("select").imagepicker();

    $('.callfunction').click(function () {
        $(".loadimage1").show();
        $.ajax({
            type: "GET",
            url: '<?php echo base_url() ?>movies/compare_image_landscape',
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
                setTimeout(function(){$(".loadimage1").fadeOut()},500)
                $('#changing-contentimage1').html(_gallery);
                $("select").imagepicker();
            }
        });
    })

    $('#uploadimagelandscape').click(function () {
        $('#changing-contentimage1').html('<iframe id="myIframe" src="http://pic1.dens.tv/poster/upload-landscape.php" width="100%" height="500px" frameborder="0"></iframe>');
    });

    $('#backimagelandscape').click(function () {
        $(".loadimage1").show();
        $.ajax({
            type: "GET",
            url: '<?php echo base_url() ?>movies/compare_image_landscape',
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
                setTimeout(function(){$(".loadimage1").fadeOut()},500)
                $('#changing-contentimage1').html(_gallery);
                $("select").imagepicker();
            }
        });
    });

    function getUrlLandscape(){
        var endpoint = 'https://picture.dens.tv/poster/files/lands/'
        var img = $('#modal-imagelandscape .image_picker_selector').find('.selected').find('img').attr('src');
        var image1280x720 = endpoint + img.replace(/.*\//, '');
        var image410x230 = endpoint + 'vod_410x230/' + img.replace(/.*\//, '');
        var image235x132 = endpoint + 'vod_235x132/' + img.replace(/.*\//, '');
        $('#url_vod_1280x720').val(image1280x720);
        $('#url_vod_410x230').val(image410x230);
        $('#url_vod_235x132').val(image235x132);
        $('#img_landscape').attr('src',img);
        $('#modal-imagelandscape').modal('hide');
    }
    // image landscape

    // image portrait
    $("select").imagepicker();

    $('.callfunction2').click(function () {
        $(".loadimage2").show();
        $.ajax({
            type: "GET",
            url: '<?php echo base_url() ?>movies/compare_image_portrait',
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
                setTimeout(function(){$(".loadimage2").fadeOut()},500)
                $('#changing-contentimage2').html(_gallery);
                $("select").imagepicker();
            }
        });
    })

    $('#uploadimageportrait').click(function () {
        $('#changing-contentimage2').html('<iframe id="myIframe2" src="http://pic1.dens.tv/poster/upload-portrait2.php" width="100%" height="500px" frameborder="0"></iframe>');
    });

    $('#backimageportrait').click(function () {
        $(".loadimage2").show();
        $.ajax({
            type: "GET",
            url: '<?php echo base_url() ?>movies/compare_image_portrait',
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
                setTimeout(function(){$(".loadimage2").fadeOut()},500)
                $('#changing-contentimage2').html(_gallery);
                $("select").imagepicker();
            }
        });
    });

    function getUrlPortrait(){
        var endpoint = 'https://picture.dens.tv/poster/files/port/'
        var img = $('#modal-imageportrait .image_picker_selector').find('.selected').find('img').attr('src');
        var image549x825 = endpoint + img.replace(/.*\//, '');
        var image183x275 = endpoint + 'vod_183x275/' + img.replace(/.*\//, '');
        var image170x252 = endpoint + 'vod_170x252/' + img.replace(/.*\//, '');
        var image122x182 = endpoint + 'vod_122x182/' + img.replace(/.*\//, '');
        $('#url_vod_549x825').val(image549x825);
        $('#url_vod_183x275').val(image183x275);
        $('#url_vod_170x252').val(image170x252);
        $('#url_vod_122x182').val(image122x182);
        $('#img_portrait').attr('src',img);
        $('#modal-imageportrait').modal('hide');
    }
    // image portrait
</script>