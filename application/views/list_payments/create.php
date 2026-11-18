<style type="text/css">
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    #headingOne a {pointer-events: none;}
    #headingTwo a {pointer-events: none;}
    select.image-picker {margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 200px;height: 130px;}
    .contacts__img>img {width: 100px;height: 100px;}
    .select2-container--default .select2-selection--multiple {min-height: 38px; max-height: 250px; overflow-y: auto;}
    .select2-container--default .select2-selection--multiple
    .select2-selection__rendered {display: flex; flex-wrap: wrap;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Add Payment</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('list_payments') ?>">List Payments</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>','</div>'); ?>
                <?= form_open('list_payments/create') ?>
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
                                                <label>Title (*required)</label>
                                                <input type="text" name="title" id="title" class="form-control" value="<?= set_value('title') ?>" placeholder="Please Input Title" required>
                                                <span class="invalid-feedback" style="display:block;"><?= form_error('title') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Payment Channel (*required)</label>
                                                <input type="text" name="payment_channel" id="payment_channel" class="form-control" value="<?= set_value('payment_channel') ?>" placeholder="Please Input Payment Channel" required>
                                                <span class="invalid-feedback" style="display:block;"><?= form_error('payment_channel') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bank Code (*required)</label>
                                                <input type="text" name="bank_code" id="bank_code" class="form-control" value="<?= set_value('bank_code') ?>" placeholder="Please Input Bank Code" required>
                                                <span class="invalid-feedback" style="display:block;"><?= form_error('bank_code') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Admin Fee Type (*required)</label>
                                                <select class="form-control" name="type" id="type" required>
                                                </select>
                                                <span class="invalid-feedback" style="display:block;"><?= form_error('type') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Admin Fee (*required)</label>
                                                <input type="number" name="admin_fee" id="admin_fee" class="form-control" value="<?= set_value('admin_fee', '0') ?>" min="0" step="1" onfocus="if(this.value == '0') this.value = ''" onblur="if(this.value == '') this.value = '0'" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Please Input Admin Fee">
                                                <span class="invalid-feedback" style="display:block;"><?= form_error('admin_fee') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>URL API Transaction (*required)</label>
                                                <input type="text" name="url_api_transaction" id="url_api_transaction" class="form-control" value="<?= set_value('url_api_transaction') ?>" placeholder="Please Input URL" required>
                                                <span class="invalid-feedback" style="display:block;"><?= form_error('url_api_transaction') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>URL API Status</label>
                                                <input type="text" name="url_api_status" id="url_api_status" class="form-control" value="<?= set_value('url_api_status') ?>" placeholder="Please Input URL">
                                                <span class="invalid-feedback" style="display:block;"><?= form_error('url_api_status') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Image (*required)</label>
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
                                        <br>
                                        <div class="col-md-12" align="center">
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                        </div>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#type').select2({
            ajax: {
                url: '<?= base_url() ?>list_payments/getListType',
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
                url: '<?= base_url() ?>list_payments/getSingleType',
                data: {id: selectedType},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#type').append(option).trigger('change')
                }
            })
        }

        $("select").imagepicker()

        // image banner
        $('.callfunction').click(function () {
            $(".loadimage1").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>list_payments/compareBannerImage',
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
                url: '<?php echo base_url() ?>list_payments/getToken',
                success: function (data) {
                    $('#changing-contentimage1')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=10000&h=535&pw=100&ph=50&token='+data+'&thumb=50&CH=paymentch_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>')
                }
            })
        })

        $('#backimagebanner').click(function () {
            $(".loadimage1").show()
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>list_payments/compareBannerImage',
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

    var selectedType = <?= json_encode($selected_type ?? '') ?>;
</script>