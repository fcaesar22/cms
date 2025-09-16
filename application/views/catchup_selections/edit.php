<style type="text/css">
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
    select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    .contacts__img>img {width: 100px; height: 100px;}
    #changing-contentimage1 .image_picker_image {width: 200px; height: 130px;}
    #changing-contentimage2 .image_picker_image {width: 200px; height: 130px;}
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
                <?= form_open('catchup_selections/edit/'.$catchup['id']) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Thumbnail (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_thumbnail" src="<?= $catchup['thumbnail'] ? $catchup['thumbnail'] : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-imagethumbnail">Upload</a>
                                    <input name="thumbnail" id="thumbnail" type="hidden" class="form-control" value="<?= set_value('thumbnail', $catchup['thumbnail']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('thumbnail') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Banner (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_banner" src="<?= $catchup['banner'] ? $catchup['banner'] : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction2" data-toggle="modal" data-target="#modal-imagebanner">Upload</a>
                                    <input name="banner" id="banner" type="hidden" class="form-control" value="<?= set_value('banner', $catchup['banner']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('banner') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Channel (*required)</label>&nbsp;
                                <select class="form-control" name="id_channel" id="id_channel" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('id_channel') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category (*required)</label>&nbsp;
                                <select class="form-control" name="category_catchup" id="category_catchup" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('category_catchup') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (*required)</label>
                                <input type="text" name="title" id="title" class="form-control" value="<?= set_value('title', $catchup['title']) ?>" placeholder="Please Input Title" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('title') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description (*required)</label>
                                <textarea name="description" id="description" class="form-control" rows="1" placeholder="Please Input Description" required><?= set_value('description', $catchup['description']) ?></textarea>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('description') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Year</label>
                                <input class="form-control" type="text" name="year" id="year" value="<?= set_value('year', !empty($catchup['year']) ? $catchup['year'] : '0') ?>" placeholder="Please Input Year" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onfocus="this.select()" onblur="if(this.value === '') this.value = '0';">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('year') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rated (*required)</label>
                                <input type="text" name="rating" id="rating" class="form-control" value="<?= set_value('rating', $catchup['rating']) ?>" placeholder="ex: G, PG, PG-13, R" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('rating') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Waktu Tayang (*required)</label>
                                <input type="text" name="jam_tayang" id="jam_tayang" class="form-control" value="<?= set_value('jam_tayang', $catchup['jamtayang']) ?>" placeholder="Please Input Waktu Tayang" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('jam_tayang') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Duration (*required)</label>
                                <input type="text" name="durasi" id="durasi" class="form-control" value="<?= set_value('durasi', $catchup['durasi']) ?>" placeholder="Please Input Duration" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('durasi') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Genre (*required)</label>&nbsp;
                                <a class="btn btn-light btn-sm tested" data-toggle="modal" name="addgenre" data-target="#modal-genre" id="addgenre"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Genre</a>
                                <select class="form-control" name="genre[]" id="genre" multiple="multiple" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('genre') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cast (*required)</label>
                                <input type="text" name="cast" id="cast" class="form-control" value="<?= set_value('cast', $catchup['cast']) ?>" placeholder="Please Input Cast" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('cast') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6" id="form-startdate">
                            <div class="form-group">
                                <label for="datetimepicker">Start Date (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="start_date" name="start_date" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('start_date', $catchup['start_date']) ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('start_date') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6" id="form-enddate">
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
                        <div class="col-md-6" id="form-coomingsoon">
                            <div class="form-group">
                                <label>Coming Soon (*required)</label>
                                <select class="form-control" name="coming_soon" id="coming_soon" required>
                                    <option value="0" <?= set_select('coming_soon', '0', $catchup['coming_soon'] == '0') ?>>No</option>
                                    <option value="1" <?= set_select('coming_soon', '1', $catchup['coming_soon'] == '1') ?>>Yes</option>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('coming_soon') ?></span>
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
        $('#id_channel').select2({
            ajax: {
                url: '<?= base_url() ?>catchup_selections/get_list_channel',
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
                url: '<?= base_url() ?>catchup_selections/get_single_channel',
                data: { id: selectedChannel },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#id_channel').append(option).trigger('change');
                }
            });
        }

        $('#category_catchup').select2({
            ajax: {
                url: '<?= base_url() ?>catchup_selections/get_list_category',
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
                    $('#category_catchup').append(option).trigger('change');
                    if (selectedCategory=='1') {
                        $('#form-startdate').show();
                        $('#form-enddate').show();
                        $('#form-coomingsoon').show();
                        $(function () {
                            $("#start_date").flatpickr({
                                enableTime: true,
                                time_24hr: true,
                                enableSeconds: true,
                                minuteIncrement: 1,
                                dateFormat: "Y-m-d H:i:S",
                                allowInput: false,
                                defaultDate: "<?= set_value('start_date', $catchup['start_date']) ?>"
                            });
                        });

                        $( function() {
                            $("#end_date").flatpickr({
                                enableTime: true,
                                time_24hr: true,
                                enableSeconds: true,
                                minuteIncrement: 1,
                                dateFormat: "Y-m-d H:i:S",
                                allowInput: false,
                                defaultDate: "<?= set_value('end_date', $catchup['end_date']) ?>"
                            })
                        });
                        $('#coming_soon').val(<?= $catchup['coming_soon'] ?>).trigger("change");
                    } else {
                        $('#form-startdate').hide();
                        $('#form-enddate').hide();
                        $('#form-coomingsoon').hide();
                    }
                }
            });
        }

        $('#genre').select2({
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
                        $('#genre').append(option).trigger('change');
                    });
                }
            });
        }

        $('#coming_soon').select2({
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

        var lastImageUrlThumbnail = "<?= set_value('thumbnail') ?>";
        if (lastImageUrlThumbnail) {
            $('#img_thumbnail').attr('src', lastImageUrlThumbnail);
        }

        var lastImageUrlBanner = "<?= set_value('banner') ?>";
        if (lastImageUrlBanner) {
            $('#img_banner').attr('src', lastImageUrlBanner);
        }
    })

    $('#category_catchup').change(function() {
        var value = $(this).val();
        if (value == "1") {
            $('#start_date').val(null);
            $('#end_date').val(null);
            $('#coming_soon').val(null);
            $('#form-startdate').show();
            $('#form-enddate').show();
            $('#form-coomingsoon').show();
        } else { 
            $('#start_date').val(null);
            $('#end_date').val(null);
            $('#coming_soon').val(null);
            $('#form-startdate').hide();
            $('#form-enddate').hide();
            $('#form-coomingsoon').hide();
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
        $('#thumbnail').val(image);
        $('#img_thumbnail').attr('src',img);
        $('#modal-imagethumbnail').modal('hide');
    }

    function getUrlBanner() {
        var img = $('#modal-imagebanner .image_picker_selector').find('.selected').find('img').attr('src');
        var image = 'https://picture.dens.tv/wp/img/catchup_banner/1280x720/'+img.replace(/.*\//, '');
        $('#banner').val(image);
        $('#img_banner').attr('src',img);
        $('#modal-imagebanner').modal('hide');
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
        });
    });

    $( function() {
        $("#end_date").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
            allowInput: false,
            defaultDate: "<?= set_value('end_date', $catchup['end_date']) ?>"
        })
    });

    var selectedChannel = <?= json_encode($selected_channel ?? '') ?>;
    var selectedCategory = <?= json_encode($selected_category ?? '') ?>;
</script>