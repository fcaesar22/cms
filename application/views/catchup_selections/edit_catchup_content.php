<style type="text/css">
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
    select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    .contacts__img>img {width: 100px; height: 100px;}
    #changing-contentimage1 .image_picker_image {width: 200px; height: 130px;}
    #changing-contentimage2 .image_picker_image {width: 200px; height: 130px;}
    .select2-container--default.select2-container--disabled .select2-selection--multiple {
        background-color: transparent !important; /* sesuaikan dengan background kamu */
    }
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Catch Up</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('catchup_selections') ?>">List Catch Up</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?= form_open('catchup_selections/edit_catchup_content/'.$catchup['id']) ?>
                    <div class="row">
                        <div class="col-md-12" align="center">
                            <h4 class="card-title">Edit Catch Up Content</h4>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Thumbnail (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_thumbnail_content" src="<?= $catchup['thumbnail'] ? $catchup['thumbnail'] : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-imagethumbnail">Upload</a>
                                    <input name="thumbnail_content" id="thumbnail_content" type="hidden" class="form-control" value="<?= set_value('thumbnail_content', $catchup['thumbnail']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('thumbnail_content') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Banner (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_banner_content" src="<?= $catchup['banner'] ? $catchup['banner'] : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction2" data-toggle="modal" data-target="#modal-imagebanner">Upload</a>
                                    <input name="banner_content" id="banner_content" type="hidden" class="form-control" value="<?= set_value('banner_content', $catchup['banner']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('banner_content') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category (*required)</label>&nbsp;
                                <select class="form-control" name="category_catchup_content" id="category_catchup_content" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('category_catchup_content') ?></span>
                            </div>
                        </div>
                        <?php $labelsgroup = explode(' ', $catchup['label_group']); ?>
                        <div class="col-md-6" id="form-label">
                            <div class="form-group">
                                <label>Label</label>
                                <select class="form-control" name="label_content" id="label_content">
                                    <option value="">Select a label catch up content</option>
                                    <option value="Season" <?= set_select('label_content', 'Season', $labelsgroup[0] == 'Season') ?>>Season</option>
                                    <option value="Sequels" <?= set_select('label_content', 'Sequels', $labelsgroup[0] == 'Sequels') ?>>Sequels</option>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('label_content') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6" id="form-episode">
                            <div class="form-group">
                                <label>Episode (*required)</label>
                                <input type="text" name="episode_content" id="episode_content" class="form-control" value="<?= set_value('episode_content', $catchup['episode']) ?>" placeholder="Please Input Title" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('episode_content') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6" id="form-season">
                            <div class="form-group">
                                <label>Season (*required)</label>
                                <input type="text" name="season_content" id="season_content" class="form-control" value="<?= set_value('season_content', $catchup['season']) ?>" placeholder="Please Input Title" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('season_content') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6" id="form-trailer">
                            <div class="form-group">
                                <label>Trailer URL (*required)</label>
                                <input type="text" name="trailer_url" id="trailer_url" class="form-control" value="<?= set_value('trailer_url', $catchup['trailer_url']) ?>" placeholder="Please Input Title" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('trailer_url') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (*required)</label>
                                <input type="text" name="title_content" id="title_content" class="form-control" value="<?= set_value('title_content', $catchup['title']) ?>" placeholder="Please Input Title" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('title_content') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description (*required)</label>
                                <textarea name="description_content" id="description_content" class="form-control" rows="1" placeholder="Please Input Description" required><?= set_value('description_content', $catchup['description']) ?></textarea>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('description_content') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Year</label>
                                <input class="form-control" type="text" name="year_content" id="year_content" value="<?= set_value('year_content', !empty($catchup['year']) ? $catchup['year'] : '0') ?>" placeholder="Please Input Year" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onfocus="this.select()" onblur="if(this.value === '') this.value = '0';">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('year_content') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rated (*required)</label>
                                <input type="text" name="rating_content" id="rating_content" class="form-control" value="<?= set_value('rating_content', $catchup['rating']) ?>" placeholder="ex: G, PG, PG-13, R" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('rating_content') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Waktu Tayang (*required)</label>
                                <input type="text" name="jam_tayang_content" id="jam_tayang_content" class="form-control" value="<?= set_value('jam_tayang_content', $catchup['jamtayang']) ?>" placeholder="Please Input Waktu Tayang" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('jam_tayang_content') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Duration (*required)</label>
                                <input type="text" name="durasi_content" id="durasi_content" class="form-control" value="<?= set_value('durasi_content', $catchup['durasi']) ?>" placeholder="Please Input Duration" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('durasi_content') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Genre (*required)</label>&nbsp;
                                <a class="btn btn-light btn-sm tested" data-toggle="modal" name="addgenre" data-target="#modal-genre" id="addgenre"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Genre</a>
                                <select class="form-control" name="genre_content[]" id="genre_content" multiple="multiple" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('genre_content') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cast (*required)</label>
                                <input type="text" name="cast_content" id="cast_content" class="form-control" value="<?= set_value('cast_content', $catchup['cast']) ?>" placeholder="Please Input Cast" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('cast_content') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="datetimepicker">Start Date (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="start_date_content" name="start_date_content" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('start_date_content', $catchup['start_date']) ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('start_date_content') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="datetimepicker">End Date (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="end_date_content" name="end_date_content" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('end_date_content', $catchup['end_date']) ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('end_date_content') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Coming Soon (*required)</label>
                                <select class="form-control" name="coming_soon_content" id="coming_soon_content" required>
                                    <option value="0" <?= set_select('coming_soon_content', '0', $catchup['coming_soon'] == '0') ?>>No</option>
                                    <option value="1" <?= set_select('coming_soon_content', '1', $catchup['coming_soon'] == '1') ?>>Yes</option>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('coming_soon_content') ?></span>
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

<div class="modal fade" id="modal-imagethumbnail" tabindex="-1" style="display: none;" aria-hidden="true">
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
                <button id="uploadimagethumbnail" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlThumbnail()">Save</button>
                <button id="backimagethumbnail" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-imagebanner" tabindex="-1" style="display: none;" aria-hidden="true">
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
                <button id="uploadimagebanner" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlBanner()">Save</button>
                <button id="backimagebanner" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var selectedGenreIds = <?= json_encode((array) $selected_genres) ?>;

    $(document).ready(function(){
        $('#form-label').hide();
        $('#form-episode').hide();
        $('#form-season').hide();
        $('#form-trailer').hide();

        $('#label_content').select2({
            placeholder: "Select a channel",
            width: '100%'
        })

        $('#category_catchup_content').select2({
            ajax: {
                url: '<?= base_url() ?>catchup_selections/get_list_category_content',
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
                url: '<?= base_url() ?>catchup_selections/get_single_category',
                data: { id: selectedCategory },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#category_catchup_content').append(option).trigger('change');
                }
            });
        }

        $('#genre_content').select2({
            ajax: {
                url: '<?= base_url() ?>catchup_selections/get_list_genre',
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
                url: '<?= base_url("catchup_selections/get_multiple_genres") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedGenreIds },
                success: function (response) {
                    response.forEach(function (genre) {
                        var option = new Option(genre.text, genre.id, true, true);
                        $('#genre_content').append(option).trigger('change');
                    });
                }
            });
        }

        $('#coming_soon_content').select2({
            width: '100%',
        })

        $("select").imagepicker();

        // image thumbnail
        $('.callfunction').click(function () {
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>catchup_selections/compare_image_thumbnail',
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
                    _gallery = _gallery+"</select>";
                    setTimeout(function(){$(".loadimage1").fadeOut()},500)
                    $('#changing-contentimage1').html(_gallery);
                    $("select").imagepicker();
                }
            });
        })

        $('#uploadimagethumbnail').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>catchup_selections/get_token',
                success: function(data) {
                    $('#changing-contentimage1')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=410&h=230&pw=410&ph=230&token='+data+'&thumb=50&CH=catchup_thumbnail&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backimagethumbnail').click(function () {
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>catchup_selections/compare_image_thumbnail',
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
                    _gallery = _gallery+"</select>";
                    setTimeout(function(){$(".loadimage1").fadeOut()},500)
                    $('#changing-contentimage1').html(_gallery);
                    $("select").imagepicker();
                }
            });
        });
        // image thumbnail

        // image banner
        $('.callfunction2').click(function () {
            $(".loadimage2").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>catchup_selections/compare_image_banner',
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
                    _gallery = _gallery+"</select>";
                    setTimeout(function(){$(".loadimage2").fadeOut()},500)
                    $('#changing-contentimage2').html(_gallery);
                    $("select").imagepicker();
                }
            });
        })

        $('#uploadimagebanner').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>catchup_selections/get_token',
                success: function(data) {
                    $('#changing-contentimage2')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=340&ph=160&token='+data+'&thumb=50&CH=catchup_banner&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backimagebanner').click(function () {
            $(".loadimage2").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>catchup_selections/compare_image_banner',
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
                    _gallery = _gallery+"</select>";
                    setTimeout(function(){$(".loadimage2").fadeOut()},500)
                    $('#changing-contentimage2').html(_gallery);
                    $("select").imagepicker();
                }
            });
        });
        // image banner

        var lastImageUrlThumbnail = "<?= set_value('thumbnail_content') ?>";
        if (lastImageUrlThumbnail) {
            $('#img_thumbnail_content').attr('src', lastImageUrlThumbnail);
        }

        var lastImageUrlBanner = "<?= set_value('banner_content') ?>";
        if (lastImageUrlBanner) {
            $('#img_banner_content').attr('src', lastImageUrlBanner);
        }
    })

    $('#category_catchup_content').change(function() {
        var value = $(this).val();
        switch (value) {
            case "1":
                $('#form-label').hide();
                $('#label_content').removeAttr('required');
                $('#form-episode').hide();
                $('#episode_content').removeAttr('required');
                $('#form-season').hide();
                $('#season_content').removeAttr('required');
                $('#form-trailer').hide();
                $('#trailer_url').removeAttr('required');
                break;
            case "2":
                $('#form-label').show();
                $('#label_content').attr('required', true);
                $('#form-episode').show();
                $('#episode_content').attr('required', true);
                $('#form-season').show();
                $('#season_content').attr('required', true);
                $('#form-trailer').hide();
                $('#trailer_url').removeAttr('required');
                $('#form-episode label').text('Episode (*required)');
                break;
            case "3":
                $('#form-label').hide();
                $('#label_content').removeAttr('required');
                $('#form-episode').hide();
                $('#episode_content').removeAttr('required');
                $('#form-season').hide();
                $('#season_content').removeAttr('required');
                $('#form-trailer').show();
                $('#trailer_url').attr('required', true);
                break;
            case "4":
                $('#form-label').show();
                $('#label_content').attr('required', true);
                $('#form-episode').show();
                $('#episode_content').attr('required', true);
                $('#form-season').hide();
                $('#season_content').removeAttr('required');
                $('#form-trailer').hide();
                $('#trailer_url').removeAttr('required');
                $('#form-episode label').text('Episode / Sequels (*required)');
                break;
        }
    });

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

    function getUrlThumbnail() {
        var img = $('#modal-imagethumbnail .image_picker_selector').find('.selected').find('img').attr('src');
        var image = 'https://picture.dens.tv/wp/img/catchup_thumbnail/410x230/'+img.replace(/.*\//, '');
        $('#thumbnail_content').val(image);
        $('#img_thumbnail_content').attr('src',img);
        $('#modal-imagethumbnail').modal('hide');
    }

    function getUrlBanner() {
        var img = $('#modal-imagebanner .image_picker_selector').find('.selected').find('img').attr('src');
        var image = 'https://picture.dens.tv/wp/img/catchup_banner/1280x720/'+img.replace(/.*\//, '');
        $('#banner_content').val(image);
        $('#img_banner_content').attr('src',img);
        $('#modal-imagebanner').modal('hide');
    }

    $(function () {
        $("#start_date_content").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
            allowInput: false,
            defaultDate: "<?= set_value('start_date_content', $catchup['start_date']) ?>"
        });
    });

    $( function() {
        $("#end_date_content").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
            allowInput: false,
            defaultDate: "<?= set_value('end_date_content', $catchup['end_date']) ?>"
        })
    });

    var selectedCategory = <?= json_encode($selected_category ?? '') ?>;
</script>