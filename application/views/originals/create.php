<style type="text/css">
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    #select option {color: black;}
    td {text-align: center; vertical-align: middle !important; cursor: all-scroll;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    #tbody-tooltip {position: absolute; padding: 6px 12px; background: #fff; color: #333; border-radius: 4px; font-size: 13px; font-weight: 500; box-shadow: 0 2px 6px rgba(0,0,0,0.3); pointer-events: none; white-space: nowrap; z-index: 2000; display: none;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Section</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('originals') ?>">List Original</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>','</div>'); ?>
                <form method="POST" action="" id="form_submit" name="form_submit" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Title (*required)</label>
                                <input type="text" name="title" id="title" class="form-control" value="" placeholder="Please Input Title" required>
                                <span id="title_val" class="notify" style="color: red"></span>
                            </div>
                        </div>

                        <div class="col-md-12 pleaseselect">
                            <br>
                            <label>Please Select Content</label>
                            <hr>
                            <span id="content_val" class="notify" style="color: red"></span>
                        </div>
                        <div class="col-md-2 sizeopt">
                            <div class="form-group">
                                <label>Size</label>
                                <select class="form-control" name="size" id="size" required>
                                    <option value="small">small</option>
                                    <option value="big">big</option>
                                </select>
                                <span id="size_val" class="notify" style="color: red"></span>
                            </div>
                        </div>
                        <div class="col-md-2 vodopt">
                            <div class="form-group">
                                <label>VOD</label>
                                <select class="form-control" name="vod" id="vod" required>
                                </select>
                                <span id="vod_val" class="notify" style="color: red"></span>
                            </div>
                        </div>
                        <div class="col-md-2 banneradsopt">
                            <div class="form-group">
                                <label>Banner Ads</label>
                                <select class="form-control" name="banner_ads" id="banner_ads" required>
                                </select>
                                <span id="bannerads_val" class="notify" style="color: red"></span>
                            </div>
                        </div>

                        <div style="display: none;" class="col-md-12 listtable">
                            <div class="table-responsive">
                                <table style="width: 100%; user-select: none; -moz-user-select: none; -khtml-user-select: none;" onselectstart="javascript:return false;" class="table table-bordered mb-0" id="mytable">
                                    <thead>
                                        <tr>
                                            <th>no</th>
                                            <th>id</th>
                                            <th>title</th>
                                            <th>type</th>
                                            <th>size</th>
                                            <th>subtitle</th>
                                            <th style="display: none;">slug</th>
                                            <th style="display: none;">description</th>
                                            <th style="display: none;">image_landscape</th>
                                            <th style="display: none;">image_potrait</th>
                                            <th style="display: none;">trailer_url</th>
                                            <th style="display: none;">banner_ads_url</th>
                                            <th style="display: none;">target</th>
                                            <th style="display: none;">location</th>
                                            <th style="display: none;">category_content</th>
                                            <th style="display: none;">content_id</th>
                                            <th style="display: none;">start_date</th>
                                            <th style="display: none;">end_date</th>
                                            <th style="display: none;">subtitle_value</th>
                                            <th style="display: none;">keywords</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12" align="center" style="margin-top:40px;">
                            <button class="btn btn-success" type="button" id="upload" name="upload">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-submit" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left"></h5>
            </div>
            <div class="modal-body">
                <div id="warding_submit" style="text-align: center; color: red; font-size: 14px; margin-bottom: 10px;"></div>
                <h5 style="text-align: center;">are you sure?</h5>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button id="submit_data" type="button" class="btn btn-link">Save</button>
            </div>
        </div>
    </div>
</div>

<div id="tbody-tooltip">Drag & drop keywords to reorder</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#size').select2()
    })

    createSelect2('#vod', 'getListVod', 'movie')
    createSelect2('#banner_ads', 'getListBannerAds', 'banner ads')

    function createSelect2(idSelect, type, placeholder) {
        var url = '<?= base_url() ?>originals/' + type
        var placeholder = "Select a " + placeholder

        $(idSelect).select2({
            width: '100%',
            ajax: {
                url: url,
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
            placeholder: placeholder,
            templateResult: format,
            templateSelection: formatSelection
        })
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

    $('#vod').on('select2:select', function (e) {
        var type_select = 'vod'
        var data = $('#vod')
        var id_select = data.select2('data')[0]['id']
        var text_select = data.select2('data')[0]['text']
        var text_slug = convertToSlug(text_select)
        var data_movies = data.select2('data')[0]['data']
        var description = data_movies['movie_description']
        if (data_movies['image_landscape']==null||data_movies['image_landscape']=='') {
            var image_landscape = ""
        } else {
            var image_landscape = JSON.stringify(data_movies['image_landscape']);
        }
        if (data_movies['image_potrait']==null||data_movies['image_potrait']=='') {
            var image_potrait = ""
        } else {
            var image_potrait = JSON.stringify(data_movies['image_potrait']);
        }
        var movie_type = data_movies['movie_type']
        var category = ""
        var id_content = ""
        var title_content = ""
        if (data_movies['movie_trailer']==null||data_movies['movie_trailer']=='') {
            var trailer_url = ""
        } else {
            var trailer_url = data_movies['movie_trailer']
        }
        var banner_ads_url = ""
        var target = ""
        var location = ""
        var category_content = ""
        var content_id = ""
        var start_date = ""
        var end_date = ""
        var size = $('#size').val()
        if (data_movies['keywords']==null||data_movies['keywords']=='') {
            var keywords = ""
        } else {
            var keywords = JSON.stringify(data_movies['keywords']);
        }
        create_table(id_select,text_select,type_select,size,text_slug,description,image_landscape,image_potrait,trailer_url,banner_ads_url,target,location,category_content,content_id,start_date,end_date,keywords)
    })

    $('#banner_ads').on('select2:select', function (e) {
        var type_select = 'banner_ads'
        var data = $('#banner_ads')
        var id_select = data.select2('data')[0]['id']
        var text_select = data.select2('data')[0]['text']
        var text_slug = convertToSlug(text_select)
        var data_ads = data.select2('data')[0]['data']
        var banner_ads_url = data_ads['image_url']
        var target = data_ads['target']
        var location = data_ads['location']
        var category_content = data_ads['type_content']
        var content_id = data_ads['content_id']
        var start_date = data_ads['start_date']
        var end_date = data_ads['end_date']
        var description = ""
        var image_landscape = ""
        var image_potrait = ""
        var trailer_url = ""
        var size = ""
        var keywords = ""
        create_table(id_select,text_select,type_select,size,text_slug,description,image_landscape,image_potrait,trailer_url,banner_ads_url,target,location,category_content,content_id,start_date,end_date,keywords)
    })

    function convertToSlug(Text) {
        return Text.toLowerCase().replace(/[^\w ]+/g, "").replace(/ +/g, "-")
    }

    function create_table(id_select,text_select,type_select,size,text_slug,description,image_landscape,image_potrait,trailer_url,banner_ads_url,target,location,category_content,content_id,start_date,end_date,keywords) {
        var count_row = $('#mytable tbody').find('tr').length;
        var number = count_row+1
        $(".listtable").css("display", "block")
        var tr = "<tr>";
        tr += "<td class='number'>"+ number +"</td>";
        tr += "<td>"+ id_select +"</td>";
        tr += "<td>"+ text_select +"</td>";
        tr += "<td>"+ type_select +"</td>";
        tr += "<td>"+ size +"</td>";
        if (type_select=='vod')
        {
            tr += "<td><input type='text' name='test"+number+"' id='test"+number+"' class='form-control' value='' placeholder='subtitle ex:channel name | year | episode | rating film'></td>";
        }
        else
        {
            tr += "<td><input type='hidden' name='test"+number+"' id='test"+number+"' class='form-control' value='' placeholder='subtitle ex:channel name | year | episode | rating film'></td>";
        }
        tr += "<td style='display: none;'>"+ text_slug +"</td>";
        tr += "<td style='display: none;'>"+ description +"</td>";
        tr += "<td style='display: none;'>"+ image_landscape +"</td>";
        tr += "<td style='display: none;'>"+ image_potrait +"</td>";
        tr += "<td style='display: none;'>"+ trailer_url +"</td>";
        tr += "<td style='display: none;'>"+ banner_ads_url +"</td>";
        tr += "<td style='display: none;'>"+ target +"</td>";
        tr += "<td style='display: none;'>"+ location +"</td>";
        tr += "<td style='display: none;'>"+ category_content +"</td>";
        tr += "<td style='display: none;'>"+ content_id +"</td>";
        tr += "<td style='display: none;'>"+ start_date +"</td>";
        tr += "<td style='display: none;'>"+ end_date +"</td>";
        tr += "<td id='subval"+number+"' style='display: none;'></td>";
        tr += "<td style='display: none;'>"+ keywords +"</td>";
        tr += "<td><button type='button' id='delete_row' class='btn btn-light btn--icon'><i class='zmdi zmdi-delete zmdi-hc-fw'></i></button></td>";
        tr += "</tr>";
        $('#mytable tbody').append(tr);
        
        let activeInput = null;
        // Ketika input difokuskan, simpan elemen yang sedang aktif
        $('input').on('focus', function() {
            activeInput = $(this);
        });
        
        $('input').on('input', function() {
            if (activeInput) {
                let isi = activeInput.val()
                let currentId = activeInput.attr('id');
                $('#' + currentId).val(isi)
                var subval = currentId.replace('test', 'subval');
                 $('#' + subval).text(activeInput.val())
            }
        });

        $('input').on('paste', function() {
            if (activeInput) {
                let currentId = activeInput.attr('id');
                $('#' + currentId).val(activeInput.val())
                var subval = currentId.replace('test', 'subval');
                 $('#' + subval).text(activeInput.val())
            }
        });
    }

    $(function () {
        var html = "",
            index = -1
        $(document).on("mouseup", "#mytable tr", function (e) {
            var index1 = $(this).index()
            var index2 = index
            if (index1 == index2) {
                e.preventDefault();
                return;
            }
            var spaceIndex1 = index2 + 1;
            var html1 = "<tr>" + $(this).html().trim() + "<tr>";
            var html2 = "<tr>" + html + "</tr>";
            $('#mytable > tbody > tr').eq(index1).replaceWith(html2);
            $('#mytable > tbody > tr').eq(index2).replaceWith(html1);
            $('#mytable > tbody > tr').eq(spaceIndex1).remove();
            $('td.number').text(function (i) {
                return i + 1;
            })
        })

        $(document).on("mousedown", "#mytable tr", function (e) {
            html = $(this).html().trim()
            index = $(this).index()
            $('td.number').text(function (i) {
                return i + 1
            })
        })
    })

    function clear_select() {
        $(".livetvopt").css("display", "none")
        $(".catchupopt").css("display", "none")
        $(".vodopt").css("display", "none")
        $(".articleopt").css("display", "none")
        $(".traileropt").css("display", "none")
        $(".cuscheduleopt").css("display", "none")
        $(".episodeopt").css("display", "none")
        $(".banneradsopt").css("display", "none")
        $(".listtable").css("display", "none")
        $(".listtableads").css("display", "none")
    }

    $('#mytable').on('click', '#delete_row', function(e) {
        e.preventDefault()
        if ($('#mytable tr').length > 1) {
            $(this).closest('tr').remove()
            $('td.number').text(function (i) {
                return i + 1
            })
        }
        return false
    })

    const tbody = document.querySelectorAll('#my-tbody')
    const tooltip = document.getElementById('tbody-tooltip')

    tbody.forEach(function (el) {
        el.addEventListener('mousemove', function (e) {
            tooltip.style.left = (e.pageX + 10) + 'px'
            tooltip.style.top = (e.pageY + 15) + 'px'
        })

        el.addEventListener('mouseenter', function () {
            tooltip.style.display = 'block'
        })

        el.addEventListener('mouseleave', function () {
            tooltip.style.display = 'none'
        })
    })

    $(document).on('click', '#upload', function () {
        var self = $('#form_submit');
        var title_res = $(self).find('#title').val();
        var table = $('#mytable').tableToJSON({
            ignoreColumns: [17]
        });

        let count=0;
        if (title_res == '' || title_res == null) {
            $('#title_val').text('* Please input title');
            ++count;
        }
        if (table.length<=0) {
            $('#content_val').text('* Please select content');
            ++count;
        }
        if (count>0) {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            return;
        } else {
            $('#modal-submit').modal('show')
        }
    })

    $(document).on('click', '#submit_data', function () {
        event.preventDefault();
        var el = $(this);
        var self = $('#form_submit');
        var title_res = $(self).find('#title').val();
        var obj_table = $('#mytable').tableToJSON({
            ignoreColumns: [17]
        });
        var table = [];
        $.each(obj_table, function( key, value ) {
            if (value.type=='vod') {
                var linkpot = value.image_potrait
                var linkland = value.image_landscape
                var linkkey = value.keywords
                var img_pot = null;
                var img_land = null;
                var keys = null;
                try {
                    img_pot = JSON.parse(linkpot);
                } catch (e) {
                    console.warn("image_potrait bukan JSON valid:", e);
                }
                try {
                    img_land = JSON.parse(linkland);
                } catch (e) {
                    console.warn("image_landscape bukan JSON valid:", e);
                }
                try {
                    keys = JSON.parse(linkkey);
                } catch (e) {
                    console.warn("keywords bukan JSON valid:", e);
                }
                var obj={
                    "no" : value.no,
                    "id" : value.id,
                    "title" : value.title,
                    "subtitle" : value.subtitle_value,
                    "slug" : value.slug,
                    "description" : value.description,
                    "type" : value.type,
                    "size" : value.size,
                    "image_landscape" : img_land,
                    "image_potrait" : img_pot,
                    "trailer_url" : value.trailer_url,
                    "keywords" : keys,
                }
            } else {
                var obj={
                    "no" : value.no,
                    "id" : value.id,
                    "title" : value.title,
                    "slug" : value.slug,
                    "description" : value.description,
                    "type" : value.type,
                    "banner_ads_url" : value.banner_ads_url,
                    "target" : value.target,
                    "location" : value.location,
                    "category_content" : value.category_content,
                    "content_id" : value.content_id,
                    "start_date" : value.start_date,
                    "end_date" : value.end_date,
                }
            }
            table.push(obj);
        });
        var json_content = JSON.stringify(table)
        
        var url = '<?php echo base_url() ?>originals/insertOriginal';
        $.ajax({
            type: "POST",
            url: url,
            data: {
                title:title_res,
                json_content:json_content
            },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.res == 0) {
                    window.location.href ='<?php echo base_url() ?>originals';
                } else {
                    $('#warding_submit').html(result.msg)
                    $("#warding_submit").show();
                    setTimeout(function () {
                        $("#warding_submit").hide();
                    }, 5000);
                }
            }
        });
    })
</script>