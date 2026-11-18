<style type="text/css">
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    select.image-picker {margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 200px;height: 200px;}
    .contacts__img>img {width: 100px;height: 100px;}
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Edit Notification</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('notifications') ?>">List Notifications</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>','</div>'); ?>
                <?= form_open('notifications/edit/'.$notification['id']) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>To (*required)</label>
                                <select class="form-control" name="to" id="to" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('to') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12" id="uidflag" style="display: none;">
                            <div class="form-group">
                                <label>UID</label>
                                <select class="form-control" name="uid[]" id="uid" multiple="multiple">
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('uid') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Title (*required)</label>
                                <input type="text" name="title" id="title" class="form-control" value="<?= set_value('title', $notification['title']) ?>" placeholder="Please Input Title" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('title') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description (*required)</label>
                                <textarea name="description" id="description" class="form-control" rows="1" placeholder="Please Input Description" required><?= set_value('description', $notification['description']) ?></textarea>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('description') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Content Type</label>
                                <select class="form-control" name="content_type" id="content_type">
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('content_type') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Content ID</label>
                                <input type="text" name="content_id" id="content_id" class="form-control" value="<?= set_value('content_id', $notification['content_id']) ?>" placeholder="Please Input Content ID">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('content_id') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Location</label>
                                <input type="text" name="location" id="location" class="form-control" value="<?= set_value('location', $notification['location']) ?>" placeholder="Please Input Location">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('location') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="datetimepicker">Send Date (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="send_date" name="send_date" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('send_date', $notification['send_date']) ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('send_date') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Image</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_banner" src="<?= $notification['image_url'] ? $notification['image_url'] : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-bannerimage">Upload</a>
                                    <input name="banner_image" id="banner_image" type="hidden" class="form-control" value="<?= set_value('banner_image', $notification['image_url']) ?>">
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('banner_image') ?></span>
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

<script type="text/javascript">
    var selectedUid = <?= json_encode(array_column($notification['uid'], 'id')) ?>;

    $(document).ready(function () {
        $('#to').select2({
            ajax: {
                url: '<?= base_url() ?>notifications/getListTo',
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
            placeholder: "Select a to",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedTo) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>notifications/getSingleTo',
                data: {id: selectedTo},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#to').append(option).trigger('change')
                }
            })
        }

        $('#content_type').select2({
            ajax: {
                url: '<?= base_url() ?>notifications/getListContentType',
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
            placeholder: "Select a content type",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedContentType) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>notifications/getSingleContentType',
                data: {id: selectedContentType},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#content_type').append(option).trigger('change')
                }
            })
        }

        $('#uid').select2({
            ajax: {
                url: '<?= base_url() ?>notifications/getListUid',
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
            width: '100%',
            placeholder: "Select a to",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedUid.length > 0) {
            $.ajax({
                url: '<?= base_url("notifications/getMultipleUid") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedUid },
                success: function (response) {
                    response.forEach(function (group) {
                        var option = new Option(group.text, group.id, true, true);
                        $('#uid').append(option).trigger('change');
                    });
                }
            });
        }

        $("select").imagepicker()

        // image landscape
        $('.callfunction').click(function () {
            $(".loadimage1").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>notifications/compareBannerImage',
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
                url: '<?php echo base_url() ?>notifications/getToken',
                success: function (data) {
                    $('#changing-contentimage1')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=3840&h=3840&pw=200&ph=200&token='+data+'&thumb=50&CH=notif_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>')
                }
            })
        })

        $('#backimagebanner').click(function () {
            $(".loadimage1").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>notifications/compareBannerImage',
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

        var lastImageUrlBanner = "<?= set_value('banner_image') ?>"
        if (lastImageUrlBanner) {
            $('#img_banner').attr('src', lastImageUrlBanner)
        }
    })

    $(document).on("change", "#to", function (e) {
        var unlimitedVal = $('#to').val()
        if (unlimitedVal=='SELECTION') {
            $("#uidflag").css("display", "block")
        } else {
            $("#uidflag").css("display", "none")
            $('#uid').val(null).trigger('change');
        }
    })

    function getUrlBanner() {
        var image = $('#modal-bannerimage .image_picker_selector').find('.selected').find('img').attr('src')
        $('#banner_image').val(image)
        $('#img_banner').attr('src',image)
        $('#modal-bannerimage').modal('hide')
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
        $("#send_date").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
            defaultDate: "<?= set_value('send_date', $notification['send_date']) ?>"
        });
        $("#send_date").prop('readonly', false);
    });

    var selectedTo = <?= json_encode($selected_to ?? '') ?>;
    var selectedContentType = <?= json_encode($selected_content_type ?? '') ?>;
</script>