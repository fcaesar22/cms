<style type="text/css">
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    select.image-picker {margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 200px;height: 200px;}
    .contacts__img>img {width: 100px;height: 100px;}
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
    .select2-container--default .select2-selection--multiple {min-height: 38px; max-height: 250px; overflow-y: auto;}
    .select2-container--default .select2-selection--multiple
    .select2-selection__rendered {display: flex; flex-wrap: wrap;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Add Package</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('packages') ?>">List Packages</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>','</div>'); ?>
                <?= form_open('packages/create') ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type (*required)</label>
                                <select class="form-control" name="pkgtype" id="pkgtype" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('pkgtype') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Affiliate (*required)</label>
                                <select class="form-control" name="affiliate" id="affiliate" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('affiliate') ?></span>
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
                                <label>List Price</label>
                                <input type="number" name="price" id="price" class="form-control" value="<?= set_value('price', '0') ?>" min="0" step="1" onfocus="if(this.value == '0') this.value = ''" onblur="if(this.value == '') this.value = '0'" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Please Input Price">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('price') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sell Price</label>
                                <input type="number" name="price2" id="price2" class="form-control" value="<?= set_value('price2', '0') ?>" min="0" step="1" onfocus="if(this.value == '0') this.value = ''" onblur="if(this.value == '') this.value = '0'" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Please Input Price">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('price2') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="datetimepicker">Publish Date (*required)</label>
                                <div class='input-group date'>
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <input type="text" id="publish_date" name="publish_date" placeholder="Pick a date & time" class="form-control datetime-picker" value="<?= set_value('publish_date') ?>">
                                    <i class="form-group__bar"></i>
                                </div>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('publish_date') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Watching</label>
                                <input type="number" name="watching" id="watching" class="form-control" value="<?= set_value('watching', '0') ?>" min="0" step="1" onfocus="if(this.value == '0') this.value = ''" onblur="if(this.value == '') this.value = '0'" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Please Input Watching">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('watching') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Option VOD</label>
                                <input type="number" name="optVod" id="optVod" class="form-control" value="<?= set_value('optVod', '0') ?>" min="0" step="1" onfocus="if(this.value == '0') this.value = ''" onblur="if(this.value == '') this.value = '0'" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Please Input Option VOD">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('optVod') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Option TV</label>
                                <input type="number" name="optTv" id="optTv" class="form-control" value="<?= set_value('optTv', '0') ?>" min="0" step="1" onfocus="if(this.value == '0') this.value = ''" onblur="if(this.value == '') this.value = '0'" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Please Input Option TV">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('optTv') ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>TV Content</label>
                                <select class="form-control" name="tv_id[]" id="tv_id" multiple="multiple">
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('tv_id') ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>VOD Content</label>
                                <select class="form-control" name="vod_id[]" id="vod_id" multiple="multiple">
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('vod_id') ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Movie Content</label>
                                <select class="form-control" name="movie_id[]" id="movie_id" multiple="multiple">
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('movie_id') ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Include Category</label>
                                <select class="form-control" name="keyword[]" id="keyword" multiple="multiple">
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('keyword') ?></span>
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
    var selectedTv = <?= json_encode((array) $selected_tv) ?>;
    var selectedVod = <?= json_encode((array) $selected_vod) ?>;
    var selectedMovie = <?= json_encode((array) $selected_movie) ?>;
    var selectedCategory = <?= json_encode((array) $selected_category) ?>;

    $(document).ready(function () {
        $('#pkgtype').select2({
            ajax: {
                url: '<?= base_url() ?>packages/getListType',
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
            placeholder: "Select a type",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedType) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>packages/getSingleType',
                data: {id: selectedType},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#pkgtype').append(option).trigger('change')
                }
            })
        }

        $('#affiliate').select2({
            ajax: {
                url: '<?= base_url() ?>packages/getListAffiliate',
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
            placeholder: "Select a affiliate",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedAffiliate) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>packages/getSingleAffiliate',
                data: {id: selectedAffiliate},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#affiliate').append(option).trigger('change')
                }
            })
        }

        $('#tv_id').select2({
            ajax: {
                url: '<?= base_url() ?>packages/getListTv',
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
            placeholder: "Select a tv",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedTv.length > 0) {
            $.ajax({
                url: '<?= base_url("packages/getMultipleTv") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedTv },
                success: function (response) {
                    response.forEach(function (group) {
                        var option = new Option(group.text, group.id, true, true);
                        $('#tv_id').append(option).trigger('change');
                    });
                }
            });
        }

        $('#vod_id').select2({
            ajax: {
                url: '<?= base_url() ?>packages/getListVod',
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
            placeholder: "Select a vod",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedVod.length > 0) {
            $.ajax({
                url: '<?= base_url("packages/getMultipleVod") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedVod },
                success: function (response) {
                    response.forEach(function (group) {
                        var option = new Option(group.text, group.id, true, true);
                        $('#vod_id').append(option).trigger('change');
                    });
                }
            });
        }

        $('#movie_id').select2({
            ajax: {
                url: '<?= base_url() ?>packages/getListMovie',
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
            placeholder: "Select a movie",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedMovie.length > 0) {
            $.ajax({
                url: '<?= base_url("packages/getMultipleMovie") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedMovie },
                success: function (response) {
                    response.forEach(function (group) {
                        var option = new Option(group.text, group.id, true, true);
                        $('#movie_id').append(option).trigger('change');
                    });
                }
            });
        }

        $('#keyword').select2({
            ajax: {
                url: '<?= base_url() ?>packages/getListKeyword',
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
            placeholder: "Select a category",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedCategory.length > 0) {
            $.ajax({
                url: '<?= base_url("packages/getMultipleKeyword") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedCategory },
                success: function (response) {
                    response.forEach(function (group) {
                        var option = new Option(group.text, group.id, true, true);
                        $('#keyword').append(option).trigger('change');
                    });
                }
            });
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

    $( function () {
        $("#publish_date").flatpickr({
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: "<?= set_value('publish_date') ?>"
        })
        $("#publish_date").prop('readonly', false)
    })

    var selectedType = <?= json_encode($selected_type ?? '') ?>;
    var selectedAffiliate = <?= json_encode($selected_affiliate ?? '') ?>;
</script>