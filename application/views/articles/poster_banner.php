<style type="text/css">
    select{display: block !important;}
    select.image-picker{margin-bottom: 20px;}
    #changing-contentimage1 .image_picker_image {width: 200px;height: 130px;}
    .contacts__img>img{width: 100px;height: 100px;}
</style>
<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Articles</h1>
            <?php echo $this->session->flashdata('msg');?>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('articles') ?>">Articles</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('articles/edit/'.$article_id) ?>">Edit Articles</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('articles/create_edit_article_content/'.$article_id) ?>">Edit Article Content</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php
                function getPosterValue($posters, $type, $key = 'poster_url') {
                    foreach ($posters as $p) {
                        if ($p['poster_type'] === $type) {
                            return $p[$key];
                        }
                    }
                    return '';
                }
                ?>
                <?= form_open('articles/create_edit_poster_banner/'.$article_id) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Poster Banner (*required)</label>
                                <div class="contacts__item">
                                    <a class="contacts__img">
                                        <img id="img_landscape" src="<?= set_value('poster_banner1') ?: getPosterValue($posters, 'arp_1280x720') ?: base_url().'assets/img/defaultuploadimage.png' ?>" alt="">
                                    </a>
                                    <a class="btn btn-light callfunction" data-toggle="modal" data-target="#modal-imagelandscape">Upload</a>
                                    <input name="poster_banner1" id="poster_banner1" type="hidden" class="form-control" value="<?= set_value('poster_banner1') ?: getPosterValue($posters, 'arp_1280x720') ?>" required>
                                    <input name="poster_id1" id="poster_id1" type="hidden" value="<?= set_value('poster_id1') ?: getPosterValue($posters, 'arp_1280x720', 'poster_id') ?>">
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('poster_banner1') ?></span>
                                    <input name="poster_banner2" id="poster_banner2" type="hidden" class="form-control" value="<?= set_value('poster_banner2') ?: getPosterValue($posters, 'arp_410x230') ?>" required>
                                    <input name="poster_id2" id="poster_id2" type="hidden" value="<?= set_value('poster_id2') ?: getPosterValue($posters, 'arp_410x230', 'poster_id') ?>">
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('poster_banner2') ?></span>
                                    <input name="poster_banner3" id="poster_banner3" type="hidden" class="form-control" value="<?= set_value('poster_banner3') ?: getPosterValue($posters, 'arp_235x132') ?>" required>
                                    <input name="poster_id3" id="poster_id3" type="hidden" value="<?= set_value('poster_id3') ?: getPosterValue($posters, 'arp_235x132', 'poster_id') ?>">
                                    <span class="invalid-feedback" style="display:block;"><?= form_error('poster_banner3') ?></span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="status" id="status" value="<?= $status ?>">
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

<script type="text/javascript">
    $(document).ready(function(){
        // image landscape
        $("select").imagepicker();

        $('.callfunction').click(function () {
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>articles/compare_image_banner',
                success: function(data){
                    data = JSON.parse(data);
                    var _gallery = "<select class='image-picker show-html'>";
                    if (data.error==0) {
                        var content = data.content
                        if(content!=null){
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
                url: '<?php echo base_url() ?>articles/get_token',
                success: function(data){
                    $('#changing-contentimage1')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=denslife_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backimagelandscape').click(function () {
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>articles/compare_image_banner',
                success: function(data){
                    data = JSON.parse(data);
                    var _gallery = "<select class='image-picker show-html'>";
                    if (data.error==0) {
                        var content = data.content
                        if(content!=null){
                            for (var i = 0; i < content.length; i++) {
                                var _counter = parseInt(i+1);
                                _gallery = _gallery + "<option data-img-src='"+content[i]+"' data-img-alt='Image "+_counter+"' value='"+content[i]+"'> Image "+_counter+"</option>";
                            }
                        }
                    }
                    _gallery = _gallery+"</select>";
                    $('#changing-contentimage1').html(_gallery);
                    $("select").imagepicker();
                }
            });
        });
        // image landscape
    })

    function getUrlLandscape() {
        var img = $('#modal-imagelandscape .image_picker_selector').find('.selected').find('img').attr('src');
        var image = 'https://picture.dens.tv/wp/img/denslife_v1/1280x720/'+img.replace(/.*\//, '');
        var image2 = 'https://picture.dens.tv/wp/img/denslife_v1/1280x720/thumbnail/'+img.replace(/.*\//, '');
        $('#poster_banner1').val(image);
        $('#poster_banner2').val(image2);
        $('#poster_banner3').val(image2);
        $('#img_landscape').attr('src',img);
        $('#modal-imagelandscape').modal('hide');
    }
</script>