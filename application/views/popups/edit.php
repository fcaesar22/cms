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
            <h1>Edit Pop Up, Logo, & Splashscreen</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('popups') ?>">List Pop Up, Logo, & Splashscreen</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>','</div>'); ?>
                <?= form_open('popups/edit/'.$popups['id']) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Location (*required)</label>
                                <select class="form-control" name="location_id" id="location_id" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('location_id') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Device (*required)</label>
                                <select class="form-control" name="device" id="device" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('device') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Content URL (*required)</label>
                                <input type="text" name="content_url" id="content_url" class="form-control" value="<?= set_value('content_url', $popups['img_url']) ?>" placeholder="Please Input URL" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('content_url') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Link URL</label>
                                <input type="text" name="link" id="link" class="form-control" value="<?= set_value('link', $popups['link']) ?>" placeholder="Please Input URL">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('link') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Category (*required)</label>
                                <select class="form-control" name="category" id="category" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('category') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Content ID</label>
                                <input type="text" name="content_id" id="content_id" class="form-control" value="<?= set_value('content_id', $popups['content_id']) ?>" placeholder="Please Input Content ID">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('content_id') ?></span>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#location_id').select2({
            ajax: {
                url: '<?= base_url() ?>popups/getListLocation',
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
            placeholder: "Select a location",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedLocation) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>popups/getSingleLocation',
                data: {id: selectedLocation},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#location_id').append(option).trigger('change')
                }
            })
        }

        $('#device').select2({
            ajax: {
                url: '<?= base_url() ?>popups/getListDevice',
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
            placeholder: "Select a device",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedDevice) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>popups/getSingleDevice',
                data: {id: selectedDevice},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#device').append(option).trigger('change')
                }
            })
        }

        $('#category').select2({
            ajax: {
                url: '<?= base_url() ?>popups/getListCategory',
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
            placeholder: "Select a category",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedCategory) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>popups/getSingleCategory',
                data: {id: selectedCategory},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#category').append(option).trigger('change')
                }
            })
        }
    })

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

    var selectedLocation = <?= json_encode($selected_location ?? '') ?>;
    var selectedDevice = <?= json_encode($selected_device ?? '') ?>;
    var selectedCategory = <?= json_encode($selected_category ?? '') ?>;
</script>