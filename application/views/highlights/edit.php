<style type="text/css">
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
    select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    .contacts__img>img {width: 100px;height: 100px;}
    #changing-contentimage1 .image_picker_image {width: 200px;height: 130px;}
    #changing-contentimage2 .image_picker_image {width: 130px;height: 200px;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Highlight</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('highlights') ?>">List Highlight</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?= form_open('highlights/edit/'.$highlight['covers_id']) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Category (*required)</label>&nbsp;
                                <select class="form-control" name="category_highlight" id="category_highlight" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('category_highlight') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Type (*required)</label>&nbsp;
                                <select class="form-control" name="type_highlight" id="type_highlight" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('type_highlight') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Content (*required)</label>&nbsp;
                                <select class="form-control" name="content_highlight" id="content_highlight" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('content_highlight') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="datetimepicker">Start Date (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="startdate_highlight" name="startdate_highlight" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('startdate_highlight', $highlight['start_date']) ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('startdate_highlight') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="datetimepicker">End Date (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="enddate_highlight" name="enddate_highlight" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('enddate_highlight', $highlight['end_date']) ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('enddate_highlight') ?></span>
                            </div>
                        </div>
                        <div id="subdiv" class="col-md-12" style="display: none;">
                            <div class="form-group">
                                <label>Subtitle</label>
                                <input type="text" name="subtitle" id="subtitle" class="form-control" value="<?= set_value('subtitle', $highlight['subtitle']) ?>" placeholder="subtitle ex:channel name | year | episode | rating film">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('subtitle') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Banner Landscape (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_landscape" src="<?= $highlight['posters'][0]['poster_content_1'] ? $highlight['posters'][0]['poster_content_1'] : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-imagelandscape">Upload</a>
                                    <input name="banner_highlight" id="banner_highlight" type="hidden" class="form-control" value="<?= set_value('banner_highlight', $highlight['posters'][0]['poster_content_1']) ?>" required>
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('banner_highlight') ?></span>
                                </div>
                            </div>
                        </div>
                        <div id="potdiv" class="col-md-6" style="display: none;">
                            <div class="form-group">
                                <label>Banner Portrait</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_portrait" src="<?= $highlight['url_image_portrait'] ? $highlight['url_image_portrait'] : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction2" data-toggle="modal" data-target="#modal-imageportrait">Upload</a>
                                    <input name="url_image_portrait" id="url_image_portrait" type="hidden" class="form-control" value="<?= set_value('url_image_portrait', $highlight['url_image_portrait']) ?>">
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('url_image_portrait') ?></span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id='id_content' name="id_content" value="<?= set_value('id_content', $highlight['id_content']) ?>" required>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('id_content') ?></span>
                        <input type="hidden" class="form-control" id='title_content' name="title_content" value="<?= set_value('title_content', $highlight['title_content']) ?>" required>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('title_content') ?></span>
                        <input type="hidden" class="form-control" id='poster_content1' name="poster_content1" value="<?= set_value('poster_content1', $highlight['posters'][0]['poster_content_1']) ?>" required>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('poster_content1') ?></span>
                        <input type="hidden" class="form-control" id='poster_content2' name="poster_content2" value="<?= set_value('poster_content2', $highlight['posters'][1]['poster_content_2']) ?>" required>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('poster_content2') ?></span>
                        <input type="hidden" class="form-control" id='poster_content3' name="poster_content3" value="<?= set_value('poster_content3', $highlight['posters'][2]['poster_content_3']) ?>" required>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('poster_content3') ?></span>
                        <input type="hidden" class="form-control" id='poster_id1' name="poster_id1" value="<?= set_value('poster_id1', $highlight['posters'][0]['poster_id_1']) ?>" required>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('poster_id1') ?></span>
                        <input type="hidden" class="form-control" id='poster_id2' name="poster_id2" value="<?= set_value('poster_id2', $highlight['posters'][1]['poster_id_2']) ?>" required>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('poster_id2') ?></span>
                        <input type="hidden" class="form-control" id='poster_id3' name="poster_id3" value="<?= set_value('poster_id3', $highlight['posters'][2]['poster_id_3']) ?>" required>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('poster_id3') ?></span>
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
            <div class="modal-footer">
                <button id="uploadimageportrait" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlPortrait()">Save</button>
                <button id="backimageportrait" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var selectedCategory = <?= json_encode($selected_category ?? '') ?>;
    var selectedType = <?= json_encode($selected_type ?? '') ?>;
    var selectedContent = <?= json_encode($selected_content ?? '') ?>;

    $(document).ready(function(){
        $('#category_highlight').select2({
            ajax: {
                url: '<?= base_url() ?>highlights/get_list_category',
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
                url: '<?= base_url() ?>highlights/get_single_category',
                data: { id: selectedCategory },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#category_highlight').append(option).trigger('change');
                }
            });
        }

        $('#type_highlight').select2({})

        $('#content_highlight').select2({})

        $('#category_highlight').on('select2:select', function (e) {
            var category_id = e.params.data.id
            if (category_id=='2290' || category_id=='7636') {
                $('#subdiv').css('display', 'block')
                $('#potdiv').css('display', 'block')
            } else {
                $('#subdiv').css('display', 'none')
                $('#potdiv').css('display', 'none')
            }
            $('#type_highlight').val(null).trigger('change');
            $('#content_highlight').val(null).trigger('change');
            $('#id_content').val(null);
            $('#title_content').val(null);
            $('#poster_content1').val(null);
            $('#poster_content2').val(null);
            $('#poster_content3').val(null);
            $('#banner_highlight').val(null)
            $('#img_landscape').attr('src', '<?=base_url()?>assets/img/defaultuploadimage.png')
            $('#subtitle').val(null)
            $('#url_image_portrait').val(null)
            $('#img_portrait').attr('src', '<?=base_url()?>assets/img/defaultuploadimage.png')
            initTypeSelect2(category_id);
        })

        if (selectedType) {
            var category_id = selectedCategory
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>highlights/get_single_type',
                data: { id: selectedType },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#type_highlight').append(option).trigger('change');
                    initTypeSelect2(category_id);
                }
            });
        }

        $('#type_highlight').on('select2:select', function (e) {
            $('#content_highlight').val(null).trigger('change');
            $('#id_content').val(null);
            $('#title_content').val(null);
            $('#poster_content1').val(null);
            $('#poster_content2').val(null);
            $('#poster_content3').val(null);
            $('#banner_highlight').val(null)
            $('#img_landscape').attr('src', '<?=base_url()?>assets/img/defaultuploadimage.png')
            $('#subtitle').val(null)
            $('#url_image_portrait').val(null)
            $('#img_portrait').attr('src', '<?=base_url()?>assets/img/defaultuploadimage.png')
            var type_id = e.params.data.id
            var category_id = $('#category_highlight').val()
            var type_name = ''
            switch (type_id)
            {
                case '245':
                    type_name = 'article'
                    break;
                case '243':
                    type_name = 'tvchannel'
                    break;
                case '244':
                    type_name = 'movie'
                    break;
                case '1517':
                    type_name = 'webinar'
                    break;
            }
            initContentSelect2(type_id,category_id,type_name);
        })

        if (selectedContent) {
            var category_id = selectedCategory
            if (category_id=='2290' || category_id=='7636') {
                $('#subdiv').css('display', 'block')
                $('#potdiv').css('display', 'block')
            } else {
                $('#subdiv').css('display', 'none')
                $('#potdiv').css('display', 'none')
            }
            var type_id = selectedType
            var type_name = ''
            switch (type_id)
            {
                case '245':
                    type_name = 'article'
                    break;
                case '243':
                    type_name = 'tvchannel'
                    break;
                case '244':
                    type_name = 'movie'
                    break;
                case '1517':
                    type_name = 'webinar'
                    break;
            }
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>highlights/get_single_content',
                data: {
                    id: selectedContent,
                    category: category_id,
                    type: type_id
                },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#content_highlight').append(option).trigger('change');
                    initContentSelect2(type_id,category_id,type_name);
                }
            });
        }

        $('#content_highlight').on('select2:select', function(e){
            var data = e.params.data;
            var type_highlight = $('#type_highlight').val()
            switch (type_highlight)
            {
                case '243': //tvchannel
                    id = data[0].seq;
                    title = data[0].title;
                    // poster1 = 'https://pic.dens.tv/tv_183x174/'+data[0].file1;
                    // poster2 = 'https://pic.dens.tv/tv_183x174/'+data[0].file1;
                    // poster3 = 'https://pic.dens.tv/tv_183x174/'+data[0].file1;
                    poster1 = data[0].file3;
                    poster2 = data[0].file3;
                    poster3 = data[0].file3;
                    break;
                case '244': //movies
                    id = data[0].movie_id;
                    title = data[0].movie_title;
                    poster1 = data[0].poster_url;
                    poster2 = data[0].poster_url;
                    poster3 = data[0].poster_url;
                    break;
                case '245': //article
                    id = data[0].article_id;
                    title = data[0].article_title;
                    poster1 = data[0].poster_url;
                    poster2 = 'https://picture.dens.tv/wp/img/denslife_v1/1280x720/thumbnail/'+poster1.replace(/.*\//, '');
                    poster3 = 'https://picture.dens.tv/wp/img/denslife_v1/1280x720/thumbnail/'+poster1.replace(/.*\//, '');
                    break;
                case '1517': //webinar
                    id = data[0].webinar_id;
                    title = data[0].topic;
                    poster1 = data[0].poster_url;
                    poster2 = 'https://picture.dens.tv/wp/img/webinar_v1/1280x720/thumbnail/'+poster1.replace(/.*\//, '');
                    poster3 = 'https://picture.dens.tv/wp/img/webinar_v1/1280x720/thumbnail/'+poster1.replace(/.*\//, '');
                    break;
            }
            $('#id_content').val(id);
            $('#title_content').val(title);
            $('#poster_content1').val(poster1);
            $('#poster_content2').val(poster2);
            $('#poster_content3').val(poster3);
            $('#banner_highlight').val(poster1)
            $('#img_landscape').attr('src', poster1)
        })

        $("select").imagepicker();

        // image landscape
        $('.callfunction').click(function () {
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>highlights/compare_image_landscape',
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

        $('#uploadimagelandscape').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>highlights/get_token',
                success: function(data){
                    $('#changing-contentimage1')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=30&CH=highlight_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backimagelandscape').click(function () {
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>highlights/compare_image_landscape',
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
        // image landscape

        // image portrait
        $('.callfunction2').click(function () {
            $(".loadimage2").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>highlights/compare_image_portrait',
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

        $('#uploadimageportrait').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>highlights/get_token',
                success: function(data) {
                    $('#changing-contentimage2')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=549&h=825&pw=252&ph=448&token='+data+'&thumb=30&CH=highlight_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                    // .html('<iframe src="http://wp.dens.tv/uploaders?w=700&h=700&pw=252&ph=252&token='+data+'&thumb=30&CH=highlight_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backimageportrait').click(function () {
            $(".loadimage2").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>highlights/compare_image_portrait',
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
        // image portrait

        var lastImageUrlLandscape = "<?= set_value('banner_highlight') ?>";
        if (lastImageUrlLandscape) {
            $('#img_landscape').attr('src', lastImageUrlLandscape);
        }

        var lastImageUrlPortrait = "<?= set_value('url_image_portrait') ?>";
        if (lastImageUrlPortrait) {
            $('#img_portrait').attr('src', lastImageUrlPortrait);
        }
    })

    function initTypeSelect2(category_id) {
        $('#type_highlight').select2({
            ajax: {
                url: '<?= base_url() ?>highlights/get_list_type',
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
            placeholder: "Select a type",
            templateResult: format,
            templateSelection: formatSelection
        })
    }

    function initContentSelect2(type_id,category_id,type_name) {
        $('#content_highlight').select2({
            ajax: {
                url: '<?= base_url() ?>highlights/get_list_content_'+type_name,
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page,
                        category_id: category_id,
                        type_id: type_id
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
            placeholder: "Select a content",
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

    function getUrlLandscape() {
        var img = $('#modal-imagelandscape .image_picker_selector').find('.selected').find('img').attr('src');
        var image = 'https://picture.dens.tv/wp/img/highlight_v1/1280x720/'+img.replace(/.*\//, '');
        var images = 'https://picture.dens.tv/wp/img/highlight_v1/1280x720/thumbnail/'+img.replace(/.*\//, '');
        $('#poster_content1').val(image);
        $('#poster_content2').val(images);
        $('#poster_content3').val(images);
        $('#banner_highlight').val(image);
        $('#img_landscape').attr('src',img);
        $('#modal-imagelandscape').modal('hide');
    }

    function getUrlPortrait() {
        var img = $('#modal-imageportrait .image_picker_selector').find('.selected').find('img').attr('src');
        var image = 'https://picture.dens.tv/wp/img/highlight_v1/549x825/'+img.replace(/.*\//, '');
        // var image = 'https://picture.dens.tv/wp/img/highlight_v1/700x700/'+img.replace(/.*\//, '');
        $('#url_image_portrait').val(image);
        $('#img_portrait').attr('src',img);
        $('#modal-imageportrait').modal('hide');
    }

    $(function () {
        $("#startdate_highlight").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
            defaultDate: "<?= set_value('startdate_highlight', $highlight['start_date']) ?>"
        });
        $("#startdate_highlight").prop('readonly', false);
    });

    $( function() {
        $("#enddate_highlight").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
            defaultDate: "<?= set_value('enddate_highlight', $highlight['end_date']) ?>"
        })
        $("#enddate_highlight").prop('readonly', false)
    });
</script>