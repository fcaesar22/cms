<style type="text/css">
    select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    #changing-contentimage .image_picker_image {width: 130px;height: 200px;}
    #select option {color: black;}
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Vshort</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('vshorts') ?>">List Vshort</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?= form_open('vshorts/edit/'.$vshort['id']) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (*required)</label>
                                <input type="text" name="title" id="title" class="form-control" value="<?= set_value('title', $vshort['title']) ?>" placeholder="Please Input Title" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('title') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description (*required)</label>
                                <textarea name="description" id="description" class="form-control" rows="1" placeholder="Please Input Description" required><?= set_value('description', $vshort['description']) ?></textarea>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('description') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Video URL (*required)</label>
                                <input type="text" name="video_url" id="video_url" class="form-control" value="<?= set_value('video_url', $vshort['video_url']) ?>" placeholder="Please Input Link RSS">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('video_url') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tags (*required)</label>&nbsp;
                                <a class="btn btn-light btn-sm visibilitys2" data-toggle="modal" name="tagging" data-target="#modal-tags" id="tagging"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Tags</a>
                                <select class="form-control" name="tags[]" id="tags" multiple="multiple" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('tags') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type (*required)</label>
                                <select class="form-control" name="type" id="type" required>
                                    <option value="">Select a type</option>
                                    <option value="external" <?= set_select('type', 'external', $vshort['content_type'] == 'external') ?>>External</option>
                                    <option value="tv" <?= set_select('type', 'tv', $vshort['content_type'] == 'tv') ?>>TV</option>
                                    <option value="vod" <?= set_select('type', 'vod', $vshort['content_type'] == 'vod') ?>>VOD</option>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('type') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Content ID (*required)</label>
                                <input type="text" name="content_id" id="content_id" class="form-control" value="<?= set_value('content_id', $vshort['content_id']) ?>" placeholder="Please Input Content ID">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('content_id') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Target (*required)</label>
                                <select class="form-control" name="target" id="target" required>
                                    <option value="">Select a type</option>
                                    <option value="_self" <?= set_select('target', '_self', $vshort['target'] == '_self') ?>>Self</option>
                                    <option value="_blank" <?= set_select('target', '_blank', $vshort['target'] == '_blank') ?>>Blank</option>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('target') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Location (*required)</label>
                                <input type="text" name="location" id="location" class="form-control" value="<?= set_value('location', $vshort['location']) ?>" placeholder="Please Input Location">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('location') ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Unlimited List (*required)</label>
                                <select class="form-control" name="unlimited_list" id="unlimited_list" required>
                                    <option value="Y" <?= set_select('unlimited_list', 'Y', $vshort['unlimited_list'] == 'Y') ?>>Active</option>
                                    <option value="N" <?= set_select('unlimited_list', 'N', $vshort['unlimited_list'] == 'N') ?>>Inactive</option>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('unlimited_list') ?></span>
                            </div>
                        </div>
                        <div class="col-md-4" id="startDates" style="display:none;">
                            <div class="form-group">
                                <label for="datetimepicker">Start Date (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="start_date" name="start_date" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('start_date', $vshort['start_date']) ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" id="endDates" style="display:none;">
                            <div class="form-group">
                                <label for="datetimepicker">End Date (*required)</label><span id="enddate_val" class="notify" style="color: red"></span>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="end_date" name="end_date" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('end_date', $vshort['end_date']) ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Thumbnail Image</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_potrait" src="<?= $vshort['thumbnail_url'] ? $vshort['thumbnail_url'] : base_url('assets/img/defaultuploadimage.png') ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-imagepotrait">Upload</a>
                                    <input class="form-control" type="hidden" name="thumbnail_url" id="thumbnail_url" value="<?= set_value('thumbnail_url', $vshort['thumbnail_url']) ?>">
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('thumbnail_url') ?></span>
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

<div class="modal fade" id="modal-tags" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Add Tags</h5>
            </div>
            <form action="#" method="post" id="form_tags" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">                         
                            <table style="width: 100%" class="table">
                                <thead><tr><th>No.</th><th>Tag</th></tr></thead>
                                <tbody id="table-details">
                                    <tr id="row1" class="jdr1">
                                        <td><span class="btn btn-sm btn-default">1</span><input type="hidden" value="6437" name="count[]"></td>
                                        <td><input type="text" required="" class="form-control input-sm" placeholder="Tag" name="jtag[]"></td>
                                        <td><input type="hidden" value="1" class="form-control input-sm" placeholder="Tag" name="jsort[]"></td>
                                        <td><input type="hidden" value="SIN" class="form-control input-sm" placeholder="Tag" name="jchild[]"></td>
                                        <td><input type="hidden" value="N" class="form-control input-sm" placeholder="Tag" name="jsub[]"></td>
                                        <td><input type="hidden" value="TSH" class="form-control input-sm" placeholder="Tag" name="jref[]"></td>
                                        <td><input type="hidden" value="Y" class="form-control input-sm" placeholder="Tag" name="jvis[]"></td>
                                        <td><input type="hidden" value="NULL" class="form-control input-sm" placeholder="Tag" name="jpar[]"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-primary btn-sm btn-add-more">Add More</button>
                            <button class="btn btn-sm btn-warning btn-remove-detail-row">X<i class="glyphicon glyphicon-remove"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save_tags()" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
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
                <div class="page-loader loadimage">
                    <div class="page-loader__spinner">
                        <svg viewBox="25 25 50 50">
                            <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                        </svg>
                    </div>
                </div>
                <div id="changing-contentimage">
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

<script type="text/javascript">
    var selectedTag = <?= json_encode($selected_tag ?? []) ?>;

    $(document).ready(function(){
        $('#type').select2()

        $('#target').select2()

        $('#unlimited_list').select2()

        var ul = $('#unlimited_list').val()
        if (ul == 'Y') {
            $("#startDates").css("display", "none")
            $("#endDates").css("display", "none")
        } else {
            $("#startDates").css("display", "block")
            $("#endDates").css("display", "block")
        }

        $('#tags').select2({
            ajax: {
                url: '<?= base_url() ?>vshorts/get_tags',
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
            placeholder: "Select tags",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedTag.length > 0) {
            $.ajax({
                url: '<?= base_url("vshorts/get_multiple_tags") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedTag },
                success: function (response) {
                    response.forEach(function (group) {
                        var option = new Option(group.text, group.id, true, true);
                        $('#tags').append(option).trigger('change');
                    });
                }
            });
        }

        // image potrait
        $('.callfunction').click(function () {
            $(".loadimage").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>vshorts/compare_image_portrait',
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
                    setTimeout(function(){$(".loadimage").fadeOut()},500)
                    $('#changing-contentimage').html(_gallery);
                    $("select").imagepicker();
                }
            });
        })

        $('#uploadimagepotrait').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>vshorts/get_token',
                success: function(data) {
                    $('#changing-contentimage')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=720&h=1280&pw=130&ph=200&token='+data+'&thumb=50&CH=reels_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backimagepotrait').click(function () {
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>vshorts/compare_image_portrait',
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
                    $('#changing-contentimage').html(_gallery);
                    $("select").imagepicker();
                }
            });
        });
        // image potrait
    })

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

    function getUrlPotrait(){
        var img = $('#modal-imagepotrait .image_picker_selector').find('.selected').find('img').attr('src');
        var image = 'https://picture.dens.tv/wp/img/reels_v1/720x1280/'+img.replace(/.*\//, '');
        $('#thumbnail_url').val(image);
        $('#img_potrait').attr('src',img);
        $('#modal-imagepotrait').modal('hide');
    }

    $(function () {
        $("#start_date").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
            defaultDate: "<?= set_value('start_date', $vshort['start_date']) ?>"
        });
        $("#start_date").prop('readonly', false);
    });

    $( function() {
        $("#end_date").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
            defaultDate: "<?= set_value('end_date', $vshort['end_date']) ?>"
        })
        $("#end_date").prop('readonly', false)
    });

    $(document).on("change","#unlimited_list",function (e) {
        var unlimitedVal = $('#unlimited_list').val()
        if (unlimitedVal=='Y') {
            $("#startDates").css("display", "none")
            $("#endDates").css("display", "none")
        } else {
            $("#startDates").css("display", "block")
            $("#endDates").css("display", "block")
        }
    });

    $("body").on('click', '.btn-add-more', function (e) {
        e.preventDefault();
        var $sr = ($(".jdr1").length + 1);
        var rowid = Math.random();
        var $html = '<tr class="jdr1" id="' + rowid + '">' +
                '<td><span class="btn btn-sm btn-default">' + $sr + '</span><input type="hidden" name="count[]" value="'+Math.floor((Math.random() * 10000) + 1)+'"></td>' +
                '<td><input type="text" required="" name="jtag[]" placeholder="tag" class="form-control input-sm"></td>' +
                '<td><input type="hidden" value="1" class="form-control input-sm" placeholder="Tag" name="jsort[]"></td>' +
                '<td><input type="hidden" value="SIN" class="form-control input-sm" placeholder="Tag" name="jchild[]"></td>' +
                '<td><input type="hidden" value="N" class="form-control input-sm" placeholder="Tag" name="jsub[]"></td>' +
                '<td><input type="hidden" value="TSH" class="form-control input-sm" placeholder="Tag" name="jref[]"></td>' +
                '<td><input type="hidden" value="Y" class="form-control input-sm" placeholder="Tag" name="jvis[]"></td>' +
                '<td><input type="hidden" value="NULL" class="form-control input-sm" placeholder="Tag" name="jpar[]"></td>' +
                '</tr>';
        $("#table-details").append($html);
    });
    
    $("body").on('click', '.btn-remove-detail-row', function (e) {
        e.preventDefault();
        if($("#table-details tr:last-child").attr('id') != 'row1'){
            $("#table-details tr:last-child").remove();
        }
    });

    function save_tags() {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        // ajax adding data to database
        $.ajax({
            url : "<?php echo site_url('vshorts/save_tags')?>",
            type: "POST",
            data: $('#form_tags').serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#modal-tags').modal('hide');
                    alert("Data Berhasil disimpan");
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Data gagal disimpan, silahkan isi category!');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });
    }
</script>