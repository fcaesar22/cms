<style type="text/css">
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    select.image-picker {margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 130px;height: 200px;}
    #changing-contentimage2 .image_picker_image {width: 200px;height: 130px;}
    .contacts__img>img {width: 100px;height: 100px;}
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    .page-link a {color: white;}
    .modal-body {max-height: 70vh; overflow-y: auto;}
    .modal-body::-webkit-scrollbar {width: 6px;}
    .modal-body::-webkit-scrollbar-thumb {background-color: rgba(255, 255, 255, 0.2); border-radius: 3px;}
    .modal-body::-webkit-scrollbar-thumb:hover {background-color: rgba(255, 255, 255, 0.35);}
    .modal-body::-webkit-scrollbar-track {background: transparent;}
    .modal-body {scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.2) transparent;}
    #tbody-tooltip {position: absolute; padding: 6px 12px; background: #fff; color: #333; border-radius: 4px; font-size: 13px; font-weight: 500; box-shadow: 0 2px 6px rgba(0,0,0,0.3); pointer-events: none; white-space: nowrap; z-index: 2000; display: none;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Create STB</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('stb') ?>">List STB</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>','</div>'); ?>
                <?= form_open('stb/create') ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Model (*required)</label>
                                <select class="form-control" name="model" id="model" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('model') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Serial Number (*required)</label>
                                <input type="text" name="serial_number" id="serial_number" class="form-control" value="<?= set_value('serial_number') ?>" placeholder="Please Input Serial Number" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('serial_number') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Version</label>
                                <input type="text" name="current_version" id="current_version" class="form-control" value="<?= set_value('current_version') ?>" placeholder="Please Input Version">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('current_version') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Mac Address</label>
                                <input type="text" name="mac" id="mac" class="form-control" value="<?= set_value('mac') ?>" placeholder="Please Input Mac Address">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('mac') ?></span>
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
    $(document).ready(function(){
        $('#model').select2({
            ajax: {
                url: '<?= base_url() ?>stb/getListModels',
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
            placeholder: "Select a model",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedModel) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>stb/getSingleModel',
                data: {id: selectedModel},
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true)
                    $('#model').append(option).trigger('change')
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

    var selectedModel = <?= json_encode($selected_model ?? '') ?>;
</script>