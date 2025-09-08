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
            <h1>Webinar</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('webinars') ?>">List Webinar</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?= form_open('webinars/create') ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Category (*required)</label>&nbsp;
                                <a class="btn btn-light btn-sm visibilitys" data-toggle="modal" name="category" data-target="#modal-category" id="category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Category</a>
                                <select class="form-control" name="category_id[]" id="category_id" multiple="multiple" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('category_id') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email Confirmation Template (*required)</label>
                                <textarea name="email_confirmation" id="email_confirmation" class="wysiwyg-editor" required><?= set_value('email_confirmation', $webinar['email_confirmation']) ?></textarea>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('email_confirmation') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Vendor (*required)</label>
                                <input type="text" name="vendor" id="vendor" class="form-control" value="<?= set_value('vendor', $webinar['vendor']) ?>" placeholder="Please Input Vendor" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('vendor') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Methode (*required)</label>
                            <div class="form-group">
                                <label class="custom-control custom-radio">
                                    <input name="flag" type="radio" class="custom-control-input" value="0" <?= set_radio('flag', '0', ($webinar['flag'] == '0')); ?>>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Free</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input name="flag" type="radio" class="custom-control-input" value="1" <?= set_radio('flag', '1', ($webinar['flag'] == '1')); ?>>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Paid</span>
                                </label>
                                <br>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('flag') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Input Webinar ID (*required)</label>
                                <input type="text" name="webinarID" id="webinarID" class="form-control" value="<?= set_value('webinarID', $webinar['webinarID']) ?>" placeholder="Please Input WebinarID get from zoom" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('webinarID') ?></span>
                            </div>
                            <a class="btn btn-light btn-sm pull-right" onclick="getWebinar()" id="get-webinar"><i class="zmdi zmdi-search zmdi-hc-fw"></i>Get Webinar</a>
                        </div>
                        <hr>
                        <div class="col-md-12 info">
                            
                        </div>
                        <input type="hidden" name="webinar_id" value="<?php echo $webinar['webinar_id'] ?>" required>
                        <div class="col-md-12" align="center">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-category" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Add Category</h5>
            </div>
            <form action="#" method="post" id="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" type="text" name="keyword_name" placeholder="keyword name" required="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var selectedCategory = <?= json_encode($selected_category ?? []) ?>;

    $(document).ready(function(){
        $('#category_id').select2({
            ajax: {
                url: '<?= base_url() ?>webinars/get_category',
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
            placeholder: "Select category",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedCategory.length > 0) {
            $.ajax({
                url: '<?= base_url("webinars/get_multiple_category") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedCategory },
                success: function (response) {
                    response.forEach(function (group) {
                        var option = new Option(group.text, group.id, true, true);
                        $('#category_id').append(option).trigger('change');
                    });
                }
            });
        }

        $('#email_confirmation').trumbowyg({
            removeformatPasted: true,
            tagsToRemove: ['script'],
            btns: [
                ["viewHTML"],
                ["undo", "redo"],
                ["formatting"],
                ["strong", "em", "del"],
                ["superscript", "subscript"],
                ["link"],
                ["justifyLeft", "justifyCenter", "justifyRight", "justifyFull"],
                ["unorderedList", "orderedList"],
                ["horizontalRule"],
                ["removeformat"]
            ],
        });

        getWebinar()
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

    function save() {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        // ajax adding data to database
        $.ajax({
            url: "<?php echo site_url('webinars/save_keyword') ?>",
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#modal-category').modal('hide');
                    alert("Data Berhasil disimpan");
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Data gagal disimpan, silahkan isi category!');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }

    function createInfoElement(dataObj) {
        $('.infodetail').remove();
        // debugger
        let el = '';
        let d = new Date(dataObj.start_time);
        let date_format_str = dateFormat(d);
        let password = dataObj.password ?? 'password is empty'
        el += '<div class="form-group infodetail">';
        el += '<label>Webinar Name</label>';
        el += '<input type="text" value="' + dataObj.topic + '" name="topic" id="topic" class="form-control" placeholder="WebinarName" required="" readonly>';
        el += '<br><label>Dens Registration Url</label>';
        el += '<input type="text" value="' + dataObj.dens_regis_url + '" name="dens_regis" id="dens_regis" class="form-control" placeholder="WebinarName" required="" readonly>';
        el += '<i class="form-group__bar"></i>';
        el += '<input class="form-control" type="hidden" value="' + dataObj.uuid + '" name="uuid" id="uuid" required="">';
        el += '<input class="form-control" type="hidden" value="' + password + '" name="webinarPassword" id="webinarPassword" required="">';
        el += '<input class="form-control" type="hidden" value="' + dataObj.host_id + '" name="hostID" id="hostID" required="">';
        el += '<input class="form-control" type="hidden" value="' + dataObj.host_email + '" name="hostEmail" id="hostEmail" required="">';
        el += '<input class="form-control" type="hidden" value="' + dataObj.agenda + '" name="agenda" id="agenda" required="">';
        el += '<input class="form-control" type="hidden" value="' + date_format_str + '" name="startTime" id="startTime" required="">';
        el += '<input class="form-control" type="hidden" value="' + dataObj.duration + '" name="duration" id="duration" required="">';
        el += '<input class="form-control" type="hidden" value="' + dataObj.join_url + '" name="joinUrl" id="joinUrl" required="">';
        el += '<input class="form-control" type="hidden" value="' + dataObj.registration_url + '" name="regisUrl" id="regisUrl" required="">';
        el += '<input class="form-control" type="hidden" value="' + dataObj.dens_join_url + '" name="dens_join" id="dens_join" required="">';
        el += '</div>';
        $('.info').html(el); // create playlist element
    }

    function dateFormat(d) {
        var date_format_str = d.getFullYear().toString() + "-" + ((d.getMonth() + 1).toString().length == 2 ? (d.getMonth() + 1).toString() : "0" + (d.getMonth() + 1).toString()) + "-" + (d.getDate().toString().length == 2 ? d.getDate().toString() : "0" + d.getDate().toString()) + " " + (d.getHours().toString().length == 2 ? d.getHours().toString() : "0" + d.getHours().toString()) + ":" + ((parseInt(d.getMinutes() / 5) * 5).toString().length == 2 ? (parseInt(d.getMinutes() / 5) * 5).toString() : "0" + (parseInt(d.getMinutes() / 5) * 5).toString()) + ":00";
        return date_format_str;
    }

    function getWebinar(e) {
        //debugger
        let route = '<?php echo base_url() ?>';
        let webinarID = $('#webinarID').val();
        if (webinarID != '') {
            //alert('webinarID = ' + webinarID);
            $.post(route + 'webinars/getWebinar', {
                    webinarID: webinarID,
                })
                .done(function(res) {
                    //debugger
                    createInfoElement(res);
                })
                .fail(function(resError) {
                    console.log(resError); // error response
                })
        } else {
            alert('WebinarID Kosong');
        }
    }
</script>