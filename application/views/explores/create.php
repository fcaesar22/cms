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
                        <li class="breadcrumb-item"><a href="<?= base_url('explores') ?>">List Explore</a></li>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Show Number (*required)</label>
                                <select class="form-control" name="show_number" id="show_number" required>
                                    <option>Please select</option>
                                    <option value="Y">Active</option>
                                    <option value="N">Inactive</option>
                                </select>
                                <span id="shownumber_val" class="notify" style="color: red"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Type (*required)</label>
                                <select class="form-control" name="type" id="type" required>
                                    <option>Please select type</option>
                                    <option value="1">Random</option>
                                    <option value="2">Live TV</option>
                                    <option value="3">Catch Up Selection</option>
                                    <option value="4">VOD</option>
                                    <option value="5">Article</option>
                                    <option value="6">Trailer</option>
                                    <option value="7">Catch Up Schedule</option>
                                    <option value="8">Banner Ads</option>
                                </select>
                                <span id="type_val" class="notify" style="color: red"></span>
                            </div>
                        </div>

                        <div style="display: none;" class="col-md-12 pleaseselect">
                            <br>
                            <label>Please Select Content</label>
                            <hr>
                            <span id="content_val" class="notify" style="color: red"></span>
                        </div>
                        <div style="display:none;" class="col-md-2 vodopt">
                            <div class="form-group">
                                <label>VOD</label>
                                <select class="form-control" name="vod" id="vod" required>
                                </select>
                                <span id="vod_val" class="notify" style="color: red"></span>
                            </div>
                        </div>
                        <div style="display:none;" class="col-md-2 livetvopt">
                            <div class="form-group">
                                <label>Live TV</label>
                                <select class="form-control" name="livetv" id="livetv" required>
                                </select>
                                <span id="livetv_val" class="notify" style="color: red"></span>
                            </div>
                        </div>
                        <div style="display:none;" class="col-md-2 catchupopt">
                            <div class="form-group">
                                <label>Catch Up Selection</label>
                                <select class="form-control" name="catchup" id="catchup" required>
                                </select>
                                <span id="catchup_val" class="notify" style="color: red"></span>
                            </div>
                        </div>
                        <div style="display:none;" class="col-md-2 articleopt">
                            <div class="form-group">
                                <label>Article</label>
                                <select class="form-control" name="article" id="article" required>
                                </select>
                                <span id="article_val" class="notify" style="color: red"></span>
                            </div>
                        </div>
                        <div style="display:none;" class="col-md-2 traileropt">
                            <div class="form-group">
                                <label>Trailer</label>
                                <select class="form-control" name="trailer" id="trailer" required>
                                </select>
                                <span id="trailer_val" class="notify" style="color: red"></span>
                            </div>
                        </div>
                        <div style="display:none;" class="col-md-2 cuscheduleopt">
                            <div class="form-group">
                                <label>Catch Up Schedule</label>
                                <select class="form-control" name="cuschedule" id="cuschedule" required>
                                </select>
                                <span id="cuschedule_val" class="notify" style="color: red"></span>
                            </div>
                        </div>
                        <div style="display:none;" class="col-md-2 episodeopt">
                            <div class="form-group">
                                <label>Episode</label>
                                <select class="form-control" name="episode" id="episode" required>
                                </select>
                                <span id="episode_val" class="notify" style="color: red"></span>
                            </div>
                        </div>
                        <div style="display:none;" class="col-md-2 banneradsopt">
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
                                            <th style="display: none;">slug</th>
                                            <th style="display: none;">description</th>
                                            <th style="display: none;">image_square</th>
                                            <th style="display: none;">image_landscape</th>
                                            <th style="display: none;">image_potrait</th>
                                            <th style="display: none;">category</th>
                                            <th style="display: none;">id_content_category</th>
                                            <th style="display: none;">title_content_category</th>
                                            <th style="display: none;">trailer_url</th>
                                            <th style="display: none;">vod_url_web</th>
                                            <th style="display: none;">vod_url_stb</th>
                                            <th style="display: none;">vod_url_android</th>
                                            <th style="display: none;">vod_url_ios</th>
                                            <th style="display: none;">category_channel</th>
                                            <th style="display: none;">id_channel</th>
                                            <th style="display: none;">catchup_day_limit_web</th>
                                            <th style="display: none;">catchup_day_limit_stb</th>
                                            <th style="display: none;">catchup_day_limit_android</th>
                                            <th style="display: none;">catchup_day_limit_ios</th>
                                            <th style="display: none;">starttime</th>
                                            <th style="display: none;">endtime</th>
                                            <th style="display: none;">stream_url_web</th>
                                            <th style="display: none;">stream_url_stb</th>
                                            <th style="display: none;">stream_url_android</th>
                                            <th style="display: none;">stream_url_ios</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="my-tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="display: none;" class="col-md-12 listtableads">
                            <div class="table-responsive">
                                <table style="width: 100%; user-select: none; -moz-user-select: none; -khtml-user-select: none;" onselectstart="javascript:return false;" class="table table-bordered mb-0" id="mytableads">
                                    <thead>
                                        <tr>
                                            <th>no</th>
                                            <th>id</th>
                                            <th>title</th>
                                            <th>type</th>
                                            <th style="display: none;">banner_url</th>
                                            <th>target</th>
                                            <th>location</th>
                                            <th>category_content</th>
                                            <th>content_id</th>
                                            <th style="display: none;">start_date</th>
                                            <th style="display: none;">end_date</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="my-tbody-ads">
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
        $('#show_number').select2()

        $('#type').select2()
    })

    createSelect2('#vod', 'getListVod', 'movie')
    createSelect2('#livetv', 'getListTv', 'tv channel')
    createSelect2('#catchup', 'getListCatchupSelection', 'catchup selection')
    createSelect2('#article', 'getListArticle', 'article')
    createSelect2('#trailer', 'getListTrailer', 'trailer')
    createSelect2('#cuschedule', 'getListCatchupSchedule', 'catchup schedule')
    createSelect2('#banner_ads', 'getListBannerAds', 'banner ads')

    function createSelect2(idSelect, type, placeholder) {
        var url = '<?= base_url() ?>explores/' + type
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

    $(function () {
        var html = "",
            index = -1
        $(document).on("mouseup", "#mytable tr", function (e) {
            var index1 = $(this).index()
            var index2 = index
            if (index1 == index2) {
                e.epreventDefault()
                return
            }
            var spaceIndex1 = index2 + 1
            var html1 = "<tr>" + $(this).html().trim() + "<tr>"
            var html2 = "<tr>" + html + "</tr>"
            $('#mytable > tbody > tr').eq(index1).replaceWith(html2)
            $('#mytable > tbody > tr').eq(index2).replaceWith(html1)
            $('#mytable > tbody > tr').eq(spaceIndex1).remove()
            $('td.number').text(function (i) {
                return i + 1
            })
        })

        $(document).on("mousedown","#mytable tr",function (e) {
            html = $(this).html().trim()
            index = $(this).index()
            $('td.number').text(function (i) {
                return i + 1
            })
        })

        $(document).on("change","#type",function (e) {
            $("#mytable > tbody > tr").remove()
            $("#mytableads > tbody > tr").remove()
            clear_select()
            $(".pleaseselect").css("display", "block")
            var val_type = $('#type').val()
            if (val_type == 1) {
                $(".livetvopt").css("display", "block")
                $(".catchupopt").css("display", "block")
                $(".vodopt").css("display", "block")
                $(".articleopt").css("display", "block")
                $(".traileropt").css("display", "block")
                $(".cuscheduleopt").css("display", "block")
            } else if (val_type == 2) {
                $(".livetvopt").css("display", "block")
            } else if (val_type == 3) {
                $(".catchupopt").css("display", "block")
            } else if (val_type == 4) {
                $(".vodopt").css("display", "block")
            } else if (val_type == 5) {
                $(".articleopt").css("display", "block")
            } else if (val_type == 6) {
                $(".traileropt").css("display", "block")
            } else if (val_type == 7) {
                $(".cuscheduleopt").css("display", "block")
            } else if (val_type == 8) {
                $(".banneradsopt").css("display", "block")
            }
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

    $('#vod').on('select2:select', function (e) {
        var type_select = 'vod'
        var data = $('#vod')
        var id_select = data.select2('data')[0]['id']
        var text_select = data.select2('data')[0]['text']
        var text_slug = convertToSlug(text_select)
        var data_movies = data.select2('data')[0]['data']
        var description = data_movies['movie_description']
        if (data_movies['image_landscape'] == null||data_movies['image_landscape'] == '') {
            var image_landscape = ""
        } else {
            var image_landscape = data_movies['image_landscape']
        }
        if (data_movies['image_potrait'] == null||data_movies['image_potrait'] == '') {
            var image_potrait = ""
        } else {
            var image_potrait = data_movies['image_potrait']
        }
        var image_square =""
        var movie_type = data_movies['movie_type']
        var category = ""
        var id_content = ""
        var title_content = ""
        if (data_movies['movie_trailer'] == null||data_movies['movie_trailer'] == '') {
            var trailer_url = ""
        } else {
            var trailer_url = data_movies['movie_trailer']
        }
        if (data_movies['url_web'] == null||data_movies['url_web'] == '') {
            var vod_url_web = ""
        } else {
            var vod_url_web = data_movies['url_web']
        }
        if (data_movies['url_stb'] == null||data_movies['url_stb'] == '') {
            var vod_url_stb = ""
        } else {
            var vod_url_stb = data_movies['url_stb']
        }
        if (data_movies['url_android'] == null||data_movies['url_android'] == '') {
            var vod_url_android = ""
        } else {
            var vod_url_android = data_movies['url_android']
        }
        if (data_movies['url_ios'] == null||data_movies['url_ios'] == '') {
            var vod_url_ios = ""
        } else {
            var vod_url_ios = data_movies['url_ios']
        }
        var category_channel = ""
        var id_channel = ""
        var catchup_day_limit_web = ""
        var catchup_day_limit_stb = ""
        var catchup_day_limit_android = ""
        var catchup_day_limit_ios = ""
        var starttime = ""
        var endtime = ""
        var stream_url_web = ""
        var stream_url_stb = ""
        var stream_url_android = ""
        var stream_url_ios = ""
        if (movie_type == 'SIN') {
            $(".episodeopt").css("display", "none")
            create_table(type_select,id_select,text_select,text_slug,description,image_square,image_landscape,image_potrait,category,id_content,title_content,trailer_url,vod_url_web,vod_url_stb,vod_url_android,vod_url_ios,category_channel,id_channel,catchup_day_limit_web,catchup_day_limit_stb,catchup_day_limit_android,catchup_day_limit_ios,starttime,endtime,stream_url_web,stream_url_stb,stream_url_android,stream_url_ios)
        } else {
            $(".episodeopt").css("display", "block")
            // select movies episode
            $('#episode').select2({
                width: '100%',
                ajax: {
                    url: '<?= base_url() ?>explores/getListEpisode',
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term,
                            page: params.page,
                            movie_id: id_select
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
                placeholder: "Select an episode",
                templateResult: format,
                templateSelection: formatSelection
            })
        }
    })

    $('#episode').on('select2:select', function (e) {
        var type_select = 'vod'
        var data = $('#episode')
        var id_select = data.select2('data')[0]['id']
        var text_select = data.select2('data')[0]['text']
        var text_slug = convertToSlug(text_select)
        var data_episode = data.select2('data')[0]['data']
        var description = data_episode['movie_description']
        var image_landscape = data_episode['image_landscape']
        var image_potrait = data_episode['image_potrait']
        var image_square =""
        var movie_type = data_episode['movie_type']
        var category = ""
        var id_content = ""
        var title_content = ""
        if (data_episode['movie_trailer'] == null||data_episode['movie_trailer'] == '') {
            var trailer_url = ""
        } else {
            var trailer_url = data_episode['movie_trailer']
        }
        if (data_episode['url_web'] == null||data_episode['url_web'] == '') {
            var vod_url_web = ""
        } else {
            var vod_url_web = data_episode['url_web']
        }
        if (data_episode['url_stb'] == null||data_episode['url_stb'] == '') {
            var vod_url_stb = ""
        } else {
            var vod_url_stb = data_episode['url_stb']
        }
        if (data_episode['url_android'] == null||data_episode['url_android'] == '') {
            var vod_url_android = ""
        } else {
            var vod_url_android = data_episode['url_android']
        }
        if (data_episode['url_ios'] == null||data_episode['url_ios'] == '') {
            var vod_url_ios = ""
        } else {
            var vod_url_ios = data_episode['url_ios']
        }
        var category_channel = ""
        var id_channel = ""
        var catchup_day_limit_web = ""
        var catchup_day_limit_stb = ""
        var catchup_day_limit_android = ""
        var catchup_day_limit_ios = ""
        var starttime = ""
        var endtime = ""
        var stream_url_web = ""
        var stream_url_stb = ""
        var stream_url_android = ""
        var stream_url_ios = ""
        create_table(type_select,id_select,text_select,text_slug,description,image_square,image_landscape,image_potrait,category,id_content,title_content,trailer_url,vod_url_web,vod_url_stb,vod_url_android,vod_url_ios,category_channel,id_channel,catchup_day_limit_web,catchup_day_limit_stb,catchup_day_limit_android,catchup_day_limit_ios,starttime,endtime,stream_url_web,stream_url_stb,stream_url_android,stream_url_ios)
    })

    $('#livetv').on('select2:select', function (e) {
        var type_select = 'live_tv'
        var data = $('#livetv')
        var id_select = data.select2('data')[0]['id']
        var text_select = data.select2('data')[0]['text']
        var text_slug = convertToSlug(text_select)
        var data_livetv = data.select2('data')[0]['data']
        var description = data_livetv['description']
        var image_square = 'https://pic.dens.tv/tv_183x174/'+data_livetv['file1']
        var image_landscape = ""
        var image_potrait = ""
        var category = data_livetv['genrelist']
        if (category.includes(',1,')) {
            category = '1'
        } else if (category.includes(',2,')) {
            category = '2'
        } else if (category.includes(',3,')) {
            category = '3'
        } else if (category.includes(',13,')) {
            category = '13'
        }
        var id_content = ""
        var title_content = ""
        if (data_livetv['trailer_url'] == null || data_livetv['trailer_url'] == '') {
            var trailer_url = ""
        } else {
            var trailer_url = data_livetv['trailer_url']
        }
        var vod_url_web = ""
        var vod_url_stb = ""
        var vod_url_android = ""
        var vod_url_ios = ""
        var category_channel = ""
        var id_channel = ""
        var catchup_day_limit_web = ""
        var catchup_day_limit_stb = ""
        var catchup_day_limit_android = ""
        var catchup_day_limit_ios = ""
        var starttime = ""
        var endtime = ""
        var stream_url_web = ""
        var stream_url_stb = ""
        var stream_url_android = ""
        var stream_url_ios = ""
        create_table(type_select,id_select,text_select,text_slug,description,image_square,image_landscape,image_potrait,category,id_content,title_content,trailer_url,vod_url_web,vod_url_stb,vod_url_android,vod_url_ios,category_channel,id_channel,catchup_day_limit_web,catchup_day_limit_stb,catchup_day_limit_android,catchup_day_limit_ios,starttime,endtime,stream_url_web,stream_url_stb,stream_url_android,stream_url_ios)
    })

    $('#catchup').on('select2:select', function (e) {
        var type_select = 'catchup_selection'
        var data = $('#catchup')
        var id_select = data.select2('data')[0]['id']
        var text_select = data.select2('data')[0]['text']
        var text_slug = convertToSlug(text_select)
        var data_catchup = data.select2('data')[0]['data']
        var description = data_catchup['description']
        var image_landscape = data_catchup['thumbnail']
        var image_square = ""
        var image_potrait = ""
        var category = ""
        var id_content = ""
        var title_content = ""
        var trailer_url = ""
        var vod_url_web = ""
        var vod_url_stb = ""
        var vod_url_android = ""
        var vod_url_ios = ""
        var category_channel = ""
        var id_channel = ""
        var catchup_day_limit_web = ""
        var catchup_day_limit_stb = ""
        var catchup_day_limit_android = ""
        var catchup_day_limit_ios = ""
        var starttime = ""
        var endtime = ""
        var stream_url_web = ""
        var stream_url_stb = ""
        var stream_url_android = ""
        var stream_url_ios = ""
        create_table(type_select,id_select,text_select,text_slug,description,image_square,image_landscape,image_potrait,category,id_content,title_content,trailer_url,vod_url_web,vod_url_stb,vod_url_android,vod_url_ios,category_channel,id_channel,catchup_day_limit_web,catchup_day_limit_stb,catchup_day_limit_android,catchup_day_limit_ios,starttime,endtime,stream_url_web,stream_url_stb,stream_url_android,stream_url_ios)
    })

    $('#article').on('select2:select', function (e) {
        var type_select = 'article'
        var data = $('#article')
        var id_select = data.select2('data')[0]['id']
        var text_select = data.select2('data')[0]['text']
        var text_slug = convertToSlug(text_select)
        var data_article = data.select2('data')[0]['data']
        var description = data_article['article_summary']
        var image_landscape = data_article['poster_url']
        var image_square = ""
        var image_potrait = ""
        var idcontentcategory = data_article['id_content_category']
        var titlecontentcategory = data_article['title_content_category']
        var category = ""
        var id_content = idcontentcategory
        var title_content = titlecontentcategory
        var trailer_url = ""
        var vod_url_web = ""
        var vod_url_stb = ""
        var vod_url_android = ""
        var vod_url_ios = ""
        var category_channel = ""
        var id_channel = ""
        var catchup_day_limit_web = ""
        var catchup_day_limit_stb = ""
        var catchup_day_limit_android = ""
        var catchup_day_limit_ios = ""
        var starttime = ""
        var endtime = ""
        var stream_url_web = ""
        var stream_url_stb = ""
        var stream_url_android = ""
        var stream_url_ios = ""
        create_table(type_select,id_select,text_select,text_slug,description,image_square,image_landscape,image_potrait,category,id_content,title_content,trailer_url,vod_url_web,vod_url_stb,vod_url_android,vod_url_ios,category_channel,id_channel,catchup_day_limit_web,catchup_day_limit_stb,catchup_day_limit_android,catchup_day_limit_ios,starttime,endtime,stream_url_web,stream_url_stb,stream_url_android,stream_url_ios)
    })

    $('#trailer').on('select2:select', function (e) {
        var type_select = 'trailer'
        var data = $('#trailer')
        var id_select = data.select2('data')[0]['id']
        var text_select = data.select2('data')[0]['text']
        var text_slug = convertToSlug(text_select)
        var data_trailer = data.select2('data')[0]['data']
        var description = data_trailer['description']
        var image_landscape = data_trailer['image_landscape']
        var image_potrait = data_trailer['image_potrait']
        var image_square = ""
        var category = ""
        var id_content = ""
        var title_content = ""
        var trailer_url = data_trailer['url_trailer']
        var vod_url_web = ""
        var vod_url_stb = ""
        var vod_url_android = ""
        var vod_url_ios = ""
        var category_channel = ""
        var id_channel = ""
        var catchup_day_limit_web = ""
        var catchup_day_limit_stb = ""
        var catchup_day_limit_android = ""
        var catchup_day_limit_ios = ""
        var starttime = ""
        var endtime = ""
        var stream_url_web = ""
        var stream_url_stb = ""
        var stream_url_android = ""
        var stream_url_ios = ""
        create_table(type_select,id_select,text_select,text_slug,description,image_square,image_landscape,image_potrait,category,id_content,title_content,trailer_url,vod_url_web,vod_url_stb,vod_url_android,vod_url_ios,category_channel,id_channel,catchup_day_limit_web,catchup_day_limit_stb,catchup_day_limit_android,catchup_day_limit_ios,starttime,endtime,stream_url_web,stream_url_stb,stream_url_android,stream_url_ios)
    })

    $('#cuschedule').on('select2:select', function (e) {
        var type_select = 'catchup_schedule'
        var data = $('#cuschedule')
        var id_select = data.select2('data')[0]['id']
        var text_select = data.select2('data')[0]['text']
        var text_slug = convertToSlug(text_select)
        var data_schedule = data.select2('data')[0]['data']
        var description = data_schedule['description']
        var image_landscape = data_schedule['banner_image']
        var image_potrait = data_schedule['banner_image_potrait']
        var image_square = ""
        var category = ""
        var id_content = ""
        var title_content = ""
        if (data_schedule['trailer_url'] == null || data_schedule['trailer_url'] == '') {
            var trailer_url = ""
        } else {
            var trailer_url = data_schedule['trailer_url']
        }
        var vod_url_web = ""
        var vod_url_stb = ""
        var vod_url_android = ""
        var vod_url_ios = ""
        var category_channel = data_schedule['category_channel']
        var id_channel = data_schedule['id_channel']
        var catchup_day_limit_web = data_schedule['catchup_day_limit_web']
        var catchup_day_limit_stb = data_schedule['catchup_day_limit_stb']
        var catchup_day_limit_android = data_schedule['catchup_day_limit_android']
        var catchup_day_limit_ios = data_schedule['catchup_day_limit_ios']
        var starttime = data_schedule['starttime']
        var endtime = data_schedule['endtime']
        var stream_url_web = data_schedule['stream_url_web']
        var stream_url_stb = data_schedule['stream_url_stb']
        var stream_url_android = data_schedule['stream_url_android']
        var stream_url_ios = data_schedule['stream_url_ios']
        create_table(type_select,id_select,text_select,text_slug,description,image_square,image_landscape,image_potrait,category,id_content,title_content,trailer_url,vod_url_web,vod_url_stb,vod_url_android,vod_url_ios,category_channel,id_channel,catchup_day_limit_web,catchup_day_limit_stb,catchup_day_limit_android,catchup_day_limit_ios,starttime,endtime,stream_url_web,stream_url_stb,stream_url_android,stream_url_ios)
    })

    $('#banner_ads').on('select2:select', function (e) {
        var type_select = 'banner_ads'
        var data = $('#banner_ads')
        var id_select = data.select2('data')[0]['id']
        var text_select = data.select2('data')[0]['text']
        var data_ads = data.select2('data')[0]['data']
        var logo = data_ads['image_url']
        var target = data_ads['target']
        var location = data_ads['location']
        var type_content = data_ads['type_content']
        var content_id = data_ads['content_id']
        var start_date = data_ads['start_date']
        var end_date = data_ads['end_date']
        create_table_ads(type_select,id_select,text_select,logo,target,location,type_content,content_id,start_date,end_date)
    })

    function convertToSlug(Text) {
        return Text.toLowerCase().replace(/[^\w ]+/g, "").replace(/ +/g, "-")
    }

    function create_table(type_select,id_select,text_select,text_slug,description,image_square,image_landscape,image_potrait,category,id_content,title_content,trailer_url,vod_url_web,vod_url_stb,vod_url_android,vod_url_ios,category_channel,id_channel,catchup_day_limit_web,catchup_day_limit_stb,catchup_day_limit_android,catchup_day_limit_ios,starttime,endtime,stream_url_web,stream_url_stb,stream_url_android,stream_url_ios) {
        var count_row = $('#mytable tbody').find('tr').length
        var number = count_row+1
        $(".listtable").css("display", "block")
        var tr = "<tr>"
        tr += "<td class='number'>"+ number +"</td>"
        tr += "<td>"+ id_select +"</td>"
        tr += "<td>"+ text_select +"</td>"
        tr += "<td>"+ type_select +"</td>"
        tr += "<td style='display: none;'>"+ text_slug +"</td>"
        tr += "<td style='display: none;'>"+ description +"</td>"
        tr += "<td style='display: none;'>"+ image_square +"</td>"
        tr += "<td style='display: none;'>"+ image_landscape +"</td>"
        tr += "<td style='display: none;'>"+ image_potrait +"</td>"
        tr += "<td style='display: none;'>"+ category +"</td>"
        tr += "<td style='display: none;'>"+ id_content +"</td>"
        tr += "<td style='display: none;'>"+ title_content +"</td>"
        tr += "<td style='display: none;'>"+ trailer_url +"</td>"
        tr += "<td style='display: none;'>"+ vod_url_web +"</td>"
        tr += "<td style='display: none;'>"+ vod_url_stb +"</td>"
        tr += "<td style='display: none;'>"+ vod_url_android +"</td>"
        tr += "<td style='display: none;'>"+ vod_url_ios +"</td>"
        tr += "<td style='display: none;'>"+ category_channel +"</td>"
        tr += "<td style='display: none;'>"+ id_channel +"</td>"
        tr += "<td style='display: none;'>"+ catchup_day_limit_web +"</td>"
        tr += "<td style='display: none;'>"+ catchup_day_limit_stb +"</td>"
        tr += "<td style='display: none;'>"+ catchup_day_limit_android +"</td>"
        tr += "<td style='display: none;'>"+ catchup_day_limit_ios +"</td>"
        tr += "<td style='display: none;'>"+ starttime +"</td>"
        tr += "<td style='display: none;'>"+ endtime +"</td>"
        tr += "<td style='display: none;'>"+ stream_url_web +"</td>"
        tr += "<td style='display: none;'>"+ stream_url_stb +"</td>"
        tr += "<td style='display: none;'>"+ stream_url_android +"</td>"
        tr += "<td style='display: none;'>"+ stream_url_ios +"</td>"
        tr += "<td><button type='button' id='delete_row' class='btn btn-light btn--icon'><i class='zmdi zmdi-delete zmdi-hc-fw'></i></button></td>"
        tr += "</tr>"
        $('#mytable tbody').append(tr)
    }

    function create_table_ads(type_select,id_select,text_select,logo,target,location,type_content,content_id,start_date,end_date) {
        if (target == null || target == '') {
            target = ''
        }
        if (location == null || location == '') {
            location = ''
        }
        if (type_content == null || type_content == '') {
            type_content = ''
        }
        if (content_id == null || content_id == '') {
            content_id = ''
        }
        var count_row = $('#mytableads tbody').find('tr').length
        var number = count_row+1
        if (number > 1) {
            alert('content max 1.')
        } else {
            $(".listtableads").css("display", "block")
            var tr = "<tr>"
            tr += "<td class='number'>"+ number +"</td>"
            tr += "<td>"+ id_select +"</td>"
            tr += "<td>"+ text_select +"</td>"
            tr += "<td>"+ type_select +"</td>"
            tr += "<td style='display: none;'>"+ logo +"</td>"
            tr += "<td>"+ target +"</td>"
            tr += "<td>"+ location +"</td>"
            tr += "<td>"+ type_content +"</td>"
            tr += "<td>"+ content_id +"</td>"
            tr += "<td style='display: none;'>"+ start_date +"</td>"
            tr += "<td style='display: none;'>"+ end_date +"</td>"
            tr += "<td><button type='button' id='delete_row' class='btn btn-light btn--icon'><i class='zmdi zmdi-delete zmdi-hc-fw'></i></button></td>"
            tr += "</tr>"
            $('#mytableads tbody').append(tr)
        }
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

    $('#mytableads').on('click', '#delete_row', function(e) {
        e.preventDefault()
        if ($('#mytableads tr').length > 1) {
            $(this).closest('tr').remove()
            $('td.number').text(function (i) {
                return i + 1
            })
        }
        return false
    })

    const tbody = document.querySelectorAll('#my-tbody, #my-tbody-ads')
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
        var self = $('#form_submit')
        var title_res = $(self).find('#title').val()
        var shownumber_res = $(self).find('#show_number').val()
        var type_res = $(self).find('#type').val()
        
        if (type_res == '8') {
            var table = $('#mytableads').tableToJSON({
                ignoreColumns: [11]
            })
        } else {
            var table = $('#mytable').tableToJSON({
                ignoreColumns: [19]
            })
        }

        let count=0

        if (shownumber_res == '' || shownumber_res == null) {
            $('#shownumber_val').text('* Please select show number')
            ++count
        }
        if (title_res == '' || title_res == null) {
            $('#title_val').text('* Please input title')
            ++count
        }
        if (type_res == '' || type_res == null) {
            $('#type_val').text('* Please select type')
            ++count
        }
        if (table.length <= 0) {
            $('#content_val').text('* Please select content')
            ++count
        }
        if (count > 0) {
            $("html, body").animate({ scrollTop: 0 }, "slow")
            return
        } else {
            $('#modal-submit').modal('show')
        }
    })

    $(document).on('click', '#submit_data', function () {
        event.preventDefault()
        var el = $(this)
        var self = $('#form_submit')
        var title_res = $(self).find('#title').val()
        var shownumber_res = $(self).find('#show_number').val()
        var type_res = $(self).find('#type').val()
        if (type_res == '8') {
            var table = $('#mytableads').tableToJSON({
                ignoreColumns: [11]
            })
        } else {
            var obj_table = $('#mytable').tableToJSON({
                ignoreColumns: [19]
            })
            var table = []
            $.each(obj_table, function (key, value) {
                if (value.type == 'live_tv') {
                    var obj = {
                        "no" : value.no,
                        "id" : value.id,
                        "title" : value.title,
                        "slug" : value.slug,
                        "description" : value.description,
                        "type" : value.type,
                        "image_square" : value.image_square,
                        "image_landscape" : value.image_landscape,
                        "image_potrait" : value.image_potrait,
                        "category" : value.category,
                        "trailer_url" : value.trailer_url
                    }
                } else if (value.type == 'article') {
                    var obj = {
                        "no" : value.no,
                        "id" : value.id,
                        "title" : value.title,
                        "slug" : value.slug,
                        "description" : value.description,
                        "type" : value.type,
                        "image_square" : value.image_square,
                        "image_landscape" : value.image_landscape,
                        "image_potrait" : value.image_potrait,
                        "id_content_category" : value.id_content_category,
                        "title_content_category" : value.title_content_category,
                        "trailer_url" : value.trailer_url
                    }
                } else if (value.type == 'vod') {
                    var obj = {
                        "no" : value.no,
                        "id" : value.id,
                        "title" : value.title,
                        "slug" : value.slug,
                        "description" : value.description,
                        "type" : value.type,
                        "image_square" : value.image_square,
                        "image_landscape" : value.image_landscape,
                        "image_potrait" : value.image_potrait,
                        "trailer_url" : value.trailer_url,
                        "vod_url_web" : value.vod_url_web,
                        "vod_url_stb" : value.vod_url_stb,
                        "vod_url_android" : value.vod_url_android,
                        "vod_url_ios" : value.vod_url_ios,
                    }
                } else if (value.type == 'catchup_schedule') {
                    var obj = {
                        "no" : value.no,
                        "id" : value.id,
                        "title" : value.title,
                        "slug" : value.slug,
                        "description" : value.description,
                        "type" : value.type,
                        "image_square" : value.image_square,
                        "image_landscape" : value.image_landscape,
                        "image_potrait" : value.image_potrait,
                        "trailer_url" : value.trailer_url,
                        "category_channel" : value.category_channel,
                        "id_channel" : value.id_channel,
                        "catchup_day_limit_web" : value.catchup_day_limit_web,
                        "catchup_day_limit_stb" : value.catchup_day_limit_stb,
                        "catchup_day_limit_android" : value.catchup_day_limit_android,
                        "catchup_day_limit_ios" : value.catchup_day_limit_ios,
                        "starttime" : value.starttime,
                        "endtime" : value.endtime,
                        "stream_url_web" : value.stream_url_web,
                        "stream_url_stb" : value.stream_url_stb,
                        "stream_url_android" : value.stream_url_android,
                        "stream_url_ios" : value.stream_url_ios,
                    }
                } else {
                    var obj = {
                        "no" : value.no,
                        "id" : value.id,
                        "title" : value.title,
                        "slug" : value.slug,
                        "description" : value.description,
                        "type" : value.type,
                        "image_square" : value.image_square,
                        "image_landscape" : value.image_landscape,
                        "image_potrait" : value.image_potrait,
                        "trailer_url" : value.trailer_url
                    }
                }
                table.push(obj);
            })
        }
        var json_content = JSON.stringify(table)
        
        var url = '<?php echo base_url() ?>explores/insertExplore'
        $.ajax({
            type: "POST",
            url: url,
            data: {
                title: title_res,
                show_number: shownumber_res,
                type: type_res,
                json_content: json_content
            },
            success: function (response) {
                var result = JSON.parse(response)
                if (result.res == 0) {
                    window.location.href ='<?php echo base_url() ?>explores'
                } else {
                    $('#warding_submit').html(result.msg)
                    $("#warding_submit").show()
                    setTimeout(function () {
                        $("#warding_submit").hide()
                    }, 5000)
                }
            }
        })
    })
</script>