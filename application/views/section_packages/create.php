<style type="text/css">
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    #headingOne a {pointer-events: none;}
    #headingTwo a {pointer-events: none;}
    select.image-picker {margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 200px;height: 130px;}
    #changing-contentimage2 .image_picker_image {width: 200px;height: 130px;}
    .contacts__img>img {width: 100px;height: 100px;}
    .select2-container--default .select2-selection--multiple {min-height: 38px; max-height: 250px; overflow-y: auto;}
    .select2-container--default .select2-selection--multiple
    .select2-selection__rendered {display: flex; flex-wrap: wrap;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Add Section Package</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('section_packages') ?>">List Section Packages</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>','</div>'); ?>
                <?= form_open('section_packages/create') ?>
                    <div class="accordion" role="tablist">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne">
                                <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Type</a>
                            </div>
                            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Package Type (*required)</label>
                                                <select class="form-control" name="package_type" id="package_type" required>
                                                </select>
                                                <span class="invalid-feedback" style="display:block;"><?= form_error('package_type') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion d-none" id="accordionType" role="tablist">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingTwo">
                                <a data-toggle="collapse" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" id="labelType">Detail Package</a>
                            </div>
                            <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordionType" style="">
                                <div class="card-body">
                                    <div class="row" id="detailSection">
                                    </div>
                                </div>
                            </div>
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
                <button type="button" class="btn btn-link" onclick="getUrlPopup()">Save</button>
                <button id="backimagepopup" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var selectedIncludeAddon = <?= json_encode((array) $selected_include_addon) ?>;

    $(document).ready(function () {
        $('#package_type').select2({
            ajax: {
                url: '<?= base_url() ?>section_packages/getListTypeSection',
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
                url: '<?= base_url() ?>section_packages/getSingleTypeSection',
                data: {id: selectedType},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#package_type').append(option).trigger('change')
                }
            })
        }
    })

    $('#package_type').on('change', function () {
        let type = $(this).val();
        let label = '';
        let html = '';

        if (type === '0') {
            label = 'Detail Main Package';
            html = `
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Device (*required)</label>
                        <select class="form-control" name="device" id="device" required>
                        </select>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('device') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Package (*required)</label>
                        <select class="form-control" name="package" id="package" required>
                        </select>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('package') ?></span>
                    </div>
                </div>
                <div class="col-md-12 apple" style="display: none;">
                    <div class="form-group">
                        <label>ID Package Apple</label>
                        <input class="form-control" type="text" name="id_package_apple" id="id_package_apple" value="<?= set_value('id_package_apple') ?>" placeholder="id package apple">
                        <span class="invalid-feedback" style="display:block;"><?= form_error('id_package_apple') ?></span>
                    </div>
                </div>
                <div class="col-md-12 android" style="display: none;">
                    <div class="form-group">
                        <label>ID Package Android</label>
                        <input class="form-control" type="text" name="id_package_android" id="id_package_android" value="<?= set_value('id_package_android') ?>" placeholder="id package android">
                        <span class="invalid-feedback" style="display:block;"><?= form_error('id_package_android') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Group Name (*required)</label>
                        <input type="text" name="group_name" id="group_name" class="form-control" value="<?= set_value('group_name') ?>" placeholder="Please Input Name" required>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('group_name') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Renewal (*required)</label>
                        <select class="form-control" name="renewal" id="renewal" required>
                        </select>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('renewal') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Price 1</label>
                        <input type="number" name="price1" id="price1" class="form-control" value="<?= set_value('price1', '0') ?>" min="0" step="1" onfocus="if(this.value == '0') this.value = ''" onblur="if(this.value == '') this.value = '0'" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Please Input Price">
                        <span class="invalid-feedback" style="display:block;"><?= form_error('price1') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Price 2</label>
                        <input type="number" name="price2" id="price2" class="form-control" value="<?= set_value('price2', '0') ?>" min="0" step="1" onfocus="if(this.value == '0') this.value = ''" onblur="if(this.value == '') this.value = '0'" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Please Input Price">
                        <span class="invalid-feedback" style="display:block;"><?= form_error('price2') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Label Deal</label>
                        <input type="text" name="label_deal" id="label_deal" class="form-control" value="<?= set_value('label_deal') ?>" placeholder="Please Input Label">
                        <span class="invalid-feedback" style="display:block;"><?= form_error('label_deal') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Label Access</label>
                        <input type="text" name="label_access" id="label_access" class="form-control" value="<?= set_value('label_access') ?>" placeholder="Please Input Label">
                        <span class="invalid-feedback" style="display:block;"><?= form_error('label_access') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Heading</label>
                        <input type="text" name="heading" id="heading" class="form-control" value="<?= set_value('heading') ?>" placeholder="Please Input Heading">
                        <span class="invalid-feedback" style="display:block;"><?= form_error('heading') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sub Heading</label>
                        <input type="text" name="sub_heading" id="sub_heading" class="form-control" value="<?= set_value('sub_heading') ?>" placeholder="Please Input Sub Heading">
                        <span class="invalid-feedback" style="display:block;"><?= form_error('sub_heading') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Optional Add-On (*required)</label>
                        <select class="form-control" name="optional_addon" id="optional_addon" required>
                        </select>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('optional_addon') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Include Add-On (*required)</label>
                        <select class="form-control" name="include_addon[]" id="include_addon" multiple="multiple">
                        </select>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('include_addon') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Required Sign In (*required)</label>
                        <select class="form-control" name="required_signin" id="required_signin">
                        </select>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('required_signin') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Button Flag (*required)</label>
                        <select class="form-control" name="button_flag" id="button_flag">
                        </select>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('button_flag') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Label Button Sudah Sign In</label>
                        <input type="text" name="label_button_sudah_signin" id="label_button_sudah_signin" class="form-control" value="<?= set_value('label_button_sudah_signin') ?>" placeholder="Please Input Label">
                        <span class="invalid-feedback" style="display:block;"><?= form_error('label_button_sudah_signin') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Label Button Belum Sign In</label>
                        <input type="text" name="label_button_belum_signin" id="label_button_belum_signin" class="form-control" value="<?= set_value('label_button_belum_signin') ?>" placeholder="Please Input Label">
                        <span class="invalid-feedback" style="display:block;"><?= form_error('label_button_belum_signin') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Notes</label>
                        <input type="text" name="notes" id="notes" class="form-control" value="<?= set_value('notes') ?>" placeholder="Please Input Notes">
                        <span class="invalid-feedback" style="display:block;"><?= form_error('notes') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>List (*required)</label>
                        <textarea name="list" id="list" class="form-control" rows="1" placeholder="Please Input List" required><?= set_value('list') ?></textarea>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('list') ?></span>
                    </div>
                </div>
                <br>
                <div class="col-md-12" align="center">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            `;
        } else if (type === '1') {
            label = 'Detail Add-On Package';
            html = `
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Device (*required)</label>
                        <select class="form-control" name="device" id="device" required>
                        </select>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('device') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Package (*required)</label>
                        <select class="form-control" name="package" id="package" required>
                        </select>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('package') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Price 1</label>
                        <input type="number" name="price1" id="price1" class="form-control" value="<?= set_value('price1', '0') ?>" min="0" step="1" onfocus="if(this.value == '0') this.value = ''" onblur="if(this.value == '') this.value = '0'" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Please Input Price">
                        <span class="invalid-feedback" style="display:block;"><?= form_error('price1') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Price 2</label>
                        <input type="number" name="price2" id="price2" class="form-control" value="<?= set_value('price2', '0') ?>" min="0" step="1" onfocus="if(this.value == '0') this.value = ''" onblur="if(this.value == '') this.value = '0'" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Please Input Price">
                        <span class="invalid-feedback" style="display:block;"><?= form_error('price2') ?></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Buy Add-On (*required)</label>
                        <select class="form-control" name="buy_addon" id="buy_addon" required>
                        </select>
                        <span class="invalid-feedback" style="display:block;"><?= form_error('buy_addon') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Banner Image</label>
                        <div class="contacts__item">
                            <a class="contacts__img">
                                <img id="img_banner" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                            </a>
                            <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-bannerimage">Upload</a>
                            <input name="banner_image" id="banner_image" type="hidden" class="form-control" value="<?= set_value('banner_image') ?>">
                            <span class="invalid-feedback" style="display:block;"><?= form_error('banner_image') ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pop Up Image</label>
                        <div class="contacts__item">
                            <a class="contacts__img">
                                <img id="img_popup" src="<?=base_url()?>assets/img/defaultuploadimage.png" alt="">
                            </a>
                            <a class="btn btn-light callfunction2" data-toggle="modal" data-target="#modal-popupimage">Upload</a>
                            <input name="popup_image" id="popup_image" type="hidden" class="form-control" value="<?= set_value('popup_image') ?>">
                            <span class="invalid-feedback" style="display:block;"><?= form_error('popup_image') ?></span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-12" align="center">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            `;
        } else {
            $('#accordionType').addClass('d-none');
            $('#detailSection').empty();
            return;
        }

        $('#accordionType').removeClass('d-none');

        $('#labelType').text(label);

        $('#detailSection').html(html);

        $('#device').select2({
            ajax: {
                url: '<?= base_url() ?>section_packages/getListDeviceSection',
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

        if (selectedDevice) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>section_packages/getSingleDeviceSection',
                data: {id: selectedDevice},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#device').append(option).trigger('change')
                }
            })
        }

        $('#package').select2({
            ajax: {
                url: '<?= base_url() ?>section_packages/getListPackageSection',
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
            placeholder: "Select a package",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedPackage) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>section_packages/getSinglePackageSection',
                data: {id: selectedPackage},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#package').append(option).trigger('change')
                }
            })
        }

        $('#renewal, #optional_addon, #required_signin').select2({
            ajax: {
                url: '<?= base_url() ?>section_packages/getListBooleanSection',
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
            placeholder: "Select a status",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedRenewal) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>section_packages/getSingleBooleanSection',
                data: {id: selectedRenewal},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#renewal').append(option).trigger('change')
                }
            })
        }

        if (selectedOptionalAddon) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>section_packages/getSingleBooleanSection',
                data: {id: selectedOptionalAddon},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#optional_addon').append(option).trigger('change')
                }
            })
        }

        if (selectedRequiredSignin) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>section_packages/getSingleBooleanSection',
                data: {id: selectedRequiredSignin},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#required_signin').append(option).trigger('change')
                }
            })
        }

        $('#button_flag').select2({
            ajax: {
                url: '<?= base_url() ?>section_packages/getListButtonFlagSection',
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
            placeholder: "Select option",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedButtonFlag) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>section_packages/getSingleButtonFlagSection',
                data: {id: selectedButtonFlag},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#button_flag').append(option).trigger('change')
                }
            })
        }

        $('#include_addon').select2({
            ajax: {
                url: '<?= base_url() ?>section_packages/getListPackageAddonSection',
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
            placeholder: "Select a package",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedIncludeAddon.length > 0) {
            $.ajax({
                url: '<?= base_url("section_packages/getMultiplePackageAddonSection") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedIncludeAddon },
                success: function (response) {
                    response.forEach(function (group) {
                        var option = new Option(group.text, group.id, true, true);
                        $('#include_addon').append(option).trigger('change');
                    });
                }
            });
        }

        $('#list').trumbowyg({
            btns: [
                ["unorderedList"],
            ],
        })

        $('#buy_addon').select2({
            ajax: {
                url: '<?= base_url() ?>section_packages/getListBuyAddonSection',
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
            placeholder: "Select option",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedBuyAddon) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>section_packages/getSingleBuyAddonSection',
                data: {id: selectedBuyAddon},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#buy_addon').append(option).trigger('change')
                }
            })
        }

        $("select").imagepicker()

        // image banner
        $('.callfunction').click(function () {
            $(".loadimage1").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>section_packages/compareBannerImage',
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
                url: '<?php echo base_url() ?>section_packages/getToken',
                success: function (data) {
                    $('#changing-contentimage1')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=470&h=260&pw=448&ph=252&token='+data+'&thumb=50&CH=addon_banner_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>')
                }
            })
        })

        $('#backimagebanner').click(function () {
            $(".loadimage1").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>section_packages/compareBannerImage',
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
        // image banner

        // image popup
        $('.callfunction2').click(function () {
            $(".loadimage2").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>section_packages/comparePopupImage',
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
                url: '<?php echo base_url() ?>section_packages/getToken',
                success: function (data) {
                    $('#changing-contentimage2')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=970&h=501&pw=448&ph=252&token='+data+'&thumb=50&CH=addon_popup_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>')
                }
            })
        })

        $('#backimagepopup').click(function () {
            $(".loadimage2").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>section_packages/comparePopupImage',
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
        // image popup

        var lastImageUrlBanner = "<?= set_value('banner_image') ?>"
        if (lastImageUrlBanner) {
            $('#img_banner').attr('src', lastImageUrlBanner)
        }

        var lastImageUrlPopup = "<?= set_value('popup_image') ?>"
        if (lastImageUrlPopup) {
            $('#img_popup').attr('src', lastImageUrlPopup)
        }
    })

    function getUrlBanner() {
        var image = $('#modal-bannerimage .image_picker_selector').find('.selected').find('img').attr('src')
        $('#banner_image').val(image)
        $('#img_banner').attr('src',image)
        $('#modal-bannerimage').modal('hide')
    }

    function getUrlPopup() {
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

    $(document).on("change", "#device", function (e) {
        var type = $('#package_type').val()
        if (type == '0') {
            var dev = $('#device').val()
            if (dev == '40') {
                $('#id_package_android').val(null)
                $(".apple").css("display", "block")
                $(".android").css("display", "none")
            } else if (dev == '30') {
                $('#id_package_apple').val(null)
                $(".android").css("display", "block")
                $(".apple").css("display", "none")
            } else {
                $('#id_package_apple').val(null)
                $('#id_package_android').val(null)
                $(".apple").css("display", "none")
                $(".android").css("display", "none")
            }
        }
    });

    var selectedType = <?= json_encode($selected_type ?? '') ?>;
    var selectedDevice = <?= json_encode($selected_device ?? '') ?>;
    var selectedPackage = <?= json_encode($selected_package ?? '') ?>;
    var selectedRenewal = <?= json_encode($selected_renewal ?? '') ?>;
    var selectedOptionalAddon = <?= json_encode($selected_optional_addon ?? '') ?>;
    var selectedRequiredSignin = <?= json_encode($selected_required_signin ?? '') ?>;
    var selectedButtonFlag = <?= json_encode($selected_button_flag ?? '') ?>;
    var selectedBuyAddon = <?= json_encode($selected_buy_addon ?? '') ?>;
</script>