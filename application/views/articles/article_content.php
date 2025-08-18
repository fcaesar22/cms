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
                        <li class="breadcrumb-item"><a href="<?= base_url('articles/edit/'.$article['article_id']) ?>">Edit Articles</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?= form_open('articles/create_edit_article_content/'.$article['article_id']) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Article Content 1 (*required)</label>
                                <textarea name="article_content_1" id="article_content_1" class="wysiwyg-editor" required><?= set_value('article_content_1', $article['article_content_1']) ?></textarea>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('article_content_1') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Article Content 2 (*required)</label>
                                <textarea name="article_content_2" id="article_content_2" class="wysiwyg-editor"><?= set_value('article_content_2', $article['article_content_2']) ?></textarea>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('article_content_2') ?></span>
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

<div class="modal fade" id="modal-content" tabindex="-1" style="display: none;" aria-hidden="true">
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
                    <select class='image-picker show-html' id='img_sel' name='img_sel'>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="art_id" name="art_id" value="<?php echo $article['article_id'] ?>">
                <button id="uploadimagelandscape" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlLandscape()">Save</button>
                <button id="backimagelandscape" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-embed" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="" method="get" id="form_embed">
                <div class="modal-header">
                    <h5 class="modal-title pull-left">Embed Video</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>URL Embed</label>
                            <input type="text" name="url_embed" id="url_embed">
                        </div>
                        <div class="col-md-12">
                            <label>Width</label>
                            <input type="text" name="maxwidth_embed" id="maxwidth_embed" value="600">
                        </div>
                        <div class="col-md-12">
                            <label>Height</label>
                            <input type="text" name="maxheight_embed" id="maxheight_embed" value="450">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" onclick="getUrlEmbed()">Save</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // image landscape
        $("select").imagepicker();

        $('#uploadimagelandscape').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>articles/get_token',
                success: function(data) {
                    $('#changing-contentimage1')
                    .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=denslife_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backimagelandscape').click(function () {
            $(".loadimage1").show();
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>articles/compare_image_article',
                success: function(data) {
                    data = JSON.parse(data);
                    var _gallery = "<select class='image-picker show-html' id='img_sel' name='img_sel'>";
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
        });
        // image landscape
    })

    $('#article_content_1').trumbowyg({
        removeformatPasted: true,
        tagsToRemove: ['script'],
        btnsDef: {
            uplImg: {
                fn: function() {
                    $('#modal-content').attr('data-trumbo', 1);
                    $('#modal-content').modal('show');
                    $('#backimagelandscape').click();
                },
                tag: 'imgcUpload',
                title: 'Upload Image',
                text: 'Upload Image',
                hasIcon: true,
                ico: 'insertImage',
            },
            embedvideo: {
                fn: function() {
                    $('#modal-embed').attr('data-trumbo', 1);
                    $('#modal-embed').modal('show');
                },
                tag: 'Embed Video',
                title: 'Embed Video',
                text: 'Embed Video',
                hasIcon: true,
                ico: 'noembed'
            }
        },
        btns: [
            ["viewHTML"],
            ["undo", "redo"],
            ["formatting"],
            ["strong", "em", "del"],
            ["superscript", "subscript"],
            ["link"],
            ['uplImg'],
            ['embedvideo'],
            ["justifyLeft", "justifyCenter", "justifyRight", "justifyFull"],
            ["unorderedList", "orderedList"],
            ["horizontalRule"],
            ["removeformat"]
        ],
    });

    $('#article_content_2').trumbowyg({
        removeformatPasted: true,
        tagsToRemove: ['script'],
        btnsDef: {
            uplImg: {
                fn: function() {
                    $('#modal-content').attr('data-trumbo', 2);
                    $('#modal-content').modal('show');
                    $('#backimagelandscape').click();
                },
                tag: 'imgcUpload',
                title: 'Upload Image',
                text: 'Upload Image',
                hasIcon: true,
                ico: 'insertImage'
            },
            embedvideo: {
                fn: function() {
                    $('#modal-embed').attr('data-trumbo', 2);
                    $('#modal-embed').modal('show');
                },
                tag: 'Embed Video',
                title: 'Embed Video',
                text: 'Embed Video',
                hasIcon: true,
                ico: 'noembed'
            }
        },
        btns: [
            ["viewHTML"],
            ["undo", "redo"],
            ["formatting"],
            ["strong", "em", "del"],
            ["superscript", "subscript"],
            ["link"],
            ['uplImg'],
            ['embedvideo'],
            ["justifyLeft", "justifyCenter", "justifyRight", "justifyFull"],
            ["unorderedList", "orderedList"],
            ["horizontalRule"],
            ["removeformat"]
        ],
    });

    function getUrlLandscape() {
        var info = $('#modal-content').attr('data-trumbo');
        var image = $('#modal-content #img_sel').val();
        var image = 'https://picture.dens.tv/wp/img/denslife_v1/1280x720/'+image.replace(/.*\//, '');
        var art_id = $('#art_id').val()
        if (info == 1) {
            var editorVal = $('#article_content_1').val();
            var newHtml = editorVal + '<img src="' + image + '">';
            $('#article_content_1').trumbowyg('html', newHtml);
        } else {
            var editorVal = $('#article_content_2').val();
            var newHtml = editorVal + '<img src="' + image + '">';
            $('#article_content_2').trumbowyg('html', newHtml);
        }
        $('#modal-content').modal('hide');
        insert_poster(image,art_id);
    }

    function insert_poster(image,art_id) {
        $.ajax({
            url : '<?php echo base_url() ?>articles/insert_poster_article',
            method : "POST",
            data :{image :image, art_id :art_id},
            async : true,
            dataType : 'json',
            success : function(data) {
                
            }
        });
    }
</script>