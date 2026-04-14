<style type="text/css">
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    .page-link a {color: white;}
    .page-link {width: 35px; height: 35px;}
    .modal-body {max-height: 70vh; overflow-y: auto;}
    .modal-body::-webkit-scrollbar {width: 6px;}
    .modal-body::-webkit-scrollbar-thumb {background-color: rgba(255, 255, 255, 0.2); border-radius: 3px;}
    .modal-body::-webkit-scrollbar-thumb:hover {background-color: rgba(255, 255, 255, 0.35);}
    .modal-body::-webkit-scrollbar-track {background: transparent;}
    .modal-body {scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.2) transparent;}
    #searchinputactive, #searchinputinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonactive, #searchbuttoninactive { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow_active, #selectrow_inactive { float: left; width: 7%; padding: 3.8px; color: white; font-size: 14px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    #mytable1 .more-content, #mytable2 .more-content {display: none;}
    #mytable1 .read-more, #mytable2 .read-more {cursor: pointer; color: rgba(255, 255, 255, .7); padding: 0;}
    #mytable1 .descdiv, #mytable2 .descdiv {white-space: pre-wrap; text-align: justify; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;}
    #searchinputcodeactive, #searchinputcodeinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 60%; color: white; background: transparent;}
    #searchbuttoncodeactive, #searchbuttoncodeinactive {float: left; width: 20%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrowcodeactive, #selectrowcodeinactive {float: left; width: 20%; padding: 5px; color: white; font-size: 12px; border: 1px solid gray; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #searchinputkeywordactive, #searchinputkeywordinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 60%; color: white; background: transparent;}
    #searchbuttonkeywordactive, #searchbuttonkeywordinactive {float: left; width: 20%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrowkeywordactive, #selectrowkeywordinactive {float: left; width: 20%; padding: 5px; color: white; font-size: 12px; border: 1px solid gray; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #tbody-tooltip {position: absolute; padding: 6px 12px; background: #fff; color: #333; border-radius: 4px; font-size: 13px; font-weight: 500; box-shadow: 0 2px 6px rgba(0,0,0,0.3); pointer-events: none; white-space: nowrap; z-index: 2000; display: none;}
    #select_keyword_active + .select2-container--default .select2-selection--single, #select_keyword_inactive + .select2-container--default .select2-selection--single {background-color: #222323; border: 1px solid gray; border-radius: 2px; height: 35px; display: flex; align-items: center;}
    #select_keyword_active + .select2-container--default .select2-selection__rendered, #select_keyword_inactive + .select2-container--default .select2-selection__rendered {color: #ffffff !important; padding-left: 10px;}
    .keyword-select2-dark {background-color: #222323 !important;}
    #modal-keyword .dropdown-menu, #modal-code .dropdown-menu {background-color: #222323;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Movies</h1>
            <?php echo $this->session->flashdata('msg');?>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php if (has_permission('create_movies')): ?>
                    <a href="<?= base_url('movies/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Movie</a>
                    <button class="btn btn-outline-info btn--icon-text" id="code" name="code" data-toggle="modal" data-target="#modal-code"><i class="zmdi zmdi-key zmdi-hc-fw"></i>Manage Code</button>
                    <button class="btn btn-outline-warning btn--icon-text" id="keyword" name="keyword" data-toggle="modal" data-target="#modal-keyword"><i class="zmdi zmdi-label zmdi-hc-fw"></i>Manage Keyword</button>
                <?php endif; ?>
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a id="tab_1" class="nav-link" data-toggle="tab" href="#tab1" role="tab">Active</a>
                        </li>
                        <li class="nav-item">
                            <a id="tab_2" class="nav-link" data-toggle="tab" href="#tab2" role="tab">Inactive</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active fade show" id="tab1" role="tabpanel">
                            <input type="hidden" name="sort_table" id="sort_table" value="movie_id">
                            <input type="hidden" name="order_table" id="order_table" value="desc">
                            <input type="hidden" name="visible" id="visible" value="Y">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Category</label><br>
                                    <select class="form-control" name="category_moviesactive" id="category_moviesactive" required>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <br><br>
                            <span class="invalid-feedback" id="wardingsearchactive" name="wardingsearchactive" style="display:none;">minimum 5 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputactive" id="searchinputactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttonactive" id="searchbuttonactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrow_active" id="selectrow_active" class="btn btn-light">
                                <select name="rowselect_active" id="rowselect_active" style="width: 100%;">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytable1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Image</th>
                                            <th>Code</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_info" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination'></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Category</label><br>
                                    <select class="form-control" name="category_moviesinactive" id="category_moviesinactive" required>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <br><br>
                            <span class="invalid-feedback" id="wardingsearchinactive" name="wardingsearchinactive" style="display:none;">minimum 5 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputinactive" id="searchinputinactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttoninactive" id="searchbuttoninactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrow_inactive" id="selectrow_inactive" class="btn btn-light">
                                <select name="rowselect_inactive" id="rowselect_inactive" style="width: 100%;">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytable2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Image</th>
                                            <th>Code</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_info2" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination2'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Active Article Confirmation-->
<div class="modal fade" id="activeMovieModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-confirmactive" class="btn btn-success" href="#">Yes</a>
            </div>
        </div>
    </div>
</div>

<!--Inactive Article Confirmation-->
<div class="modal fade" id="inactiveMovieModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-confirminactive" class="btn btn-danger" href="#">Yes</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-preview" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Preview Video</h5>
            </div>
            <div class="modal-body">
                <div id="changing-embed">
                    <div id="bungkus" style="margin: 0 auto;display: none;"><video id="my-video" class="video-js vjs-theme-forest" controls preload="auto" width="410" height="230" data-setup="{}"><p class="vjs-no-js"> To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank"> supports HTML5 video</a></p></video></div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-code" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Manage Code</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" name="visible_code" id="visible_code" value="Y">
                <input type="hidden" name="sort_table_code" id="sort_table_code" value="code_id">
                <input type="hidden" name="order_table_code" id="order_table_code" value="desc">
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link tab_code_active active" data-toggle="tab" href="#tab_code_active" role="tab">Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tab_code_inactive" data-toggle="tab" href="#tab_code_inactive" role="tab">Inactive</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <button class="btn btn-outline-info btn--icon-text" id="addCode" name="addCode"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Code</button><br><br>
                        <div class="tab-pane active fade show" id="tab_code_active" role="tabpanel">
                            <span class="invalid-feedback" id="wardingsearchcodeactive" name="wardingsearchcodeactive" style="display:none;">minimum 3 charachters</span><br>
                            <input type="search" placeholder="Search for title..." name="searchinputcodeactive" id="searchinputcodeactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttoncodeactive" id="searchbuttoncodeactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrowcodeactive" id="selectrowcodeactive" class="btn btn-light">
                                <select name="rowselectcodeactive" id="rowselectcodeactive">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <br>
                            <div id="mvCodeActive" class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="tableCodeActive" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>ID</th>
                                            <th>Initial</th>
                                            <th>Remark</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="table_info_code_active" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination_code_active'></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_code_inactive" role="tabpanel">
                            <span class="invalid-feedback" id="wardingsearchcodeinactive" name="wardingsearchcodeinactive" style="display:none;">minimum 3 charachters</span><br>
                            <input type="search" placeholder="Search for title..." name="searchinputcodeinactive" id="searchinputcodeinactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttoncodeinactive" id="searchbuttoncodeinactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrowcodeinactive" id="selectrowcodeinactive" class="btn btn-light">
                                <select name="rowselectcodeinactive" id="rowselectcodeinactive">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <br>
                            <div id="mvCodeInactive" class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="tableCodeInactive" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>ID</th>
                                            <th>Initial</th>
                                            <th>Remark</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="table_info_code_inactive" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination_code_inactive'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-code-cu" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Movie Code</h5>
            </div>
            <div class="modal-body">
                <div id="changing-code">
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button id="crud_code" name="crud_code" type="button" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-keyword" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Manage Keyword</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" name="visible_keyword" id="visible_keyword" value="Y">
                <input type="hidden" name="sort_table_keyword" id="sort_table_keyword" value="keyword_id">
                <input type="hidden" name="order_table_keyword" id="order_table_keyword" value="desc">
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link tab_keyword_active active" data-toggle="tab" href="#tab_keyword_active" role="tab">Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tab_keyword_inactive" data-toggle="tab" href="#tab_keyword_inactive" role="tab">Inactive</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <button class="btn btn-outline-warning btn--icon-text" id="add_keyword" name="add_keyword"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Keyword</button><br><br>
                        <div class="tab-pane active fade show" id="tab_keyword_active" role="tabpanel">
                            <select class="form-control" name="select_keyword_active" id="select_keyword_active" required>
                                <option value="STD">Studio</option>
                                <option value="GEN">Genre</option>
                                <option value="SUBGEN">Sub Genre</option>
                            </select>
                            <br><br>
                            <span class="invalid-feedback" id="wardingsearchkeywordactive" name="wardingsearchkeywordactive" style="display:none;">minimum 3 charachters</span><br>
                            <input type="search" placeholder="Search for title..." name="searchinputkeywordactive" id="searchinputkeywordactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttonkeywordactive" id="searchbuttonkeywordactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrowkeywordactive" id="selectrowkeywordactive" class="btn btn-light">
                                <select name="rowselectkeywordactive" id="rowselectkeywordactive">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <br>
                            <div id="table_keyword" class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytablekeyword1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="my-tbody" class="tableactive">
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_keyword" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination_keyword'></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_keyword_inactive" role="tabpanel">
                            <select class="form-control" name="select_keyword_inactive" id="select_keyword_inactive" required>
                                <option value="STD">Studio</option>
                                <option value="GEN">Genre</option>
                                <option value="SUBGEN">Sub Genre</option>
                            </select>
                            <br><br>
                            <span class="invalid-feedback" id="wardingsearchkeywordinactive" name="wardingsearchkeywordinactive" style="display:none;">minimum 3 charachters</span><br>
                            <input type="search" placeholder="Search for title..." name="searchinputkeywordinactive" id="searchinputkeywordinactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttonkeywordinactive" id="searchbuttonkeywordinactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrowkeywordinactive" id="selectrowkeywordinactive" class="btn btn-light">
                                <select name="rowselectkeywordinactive" id="rowselectkeywordinactive">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </button>
                            <br>
                            <div id="table_keyword" class="table-responsive">
                                <table class="table table-striped table-inverse table-bordered mb-0" id="mytablekeyword2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="data-table_keyword2" role="status" aria-live="polite"></div>
                                <div style='margin-top: 10px;' id='pagination_keyword2'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-keyword-cu" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Keywords</h5>
            </div>
            <div class="modal-body">
                <div id="changing-keyword">
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button id="crud_keyword" name="crud_keyword" type="button" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div id="tbody-tooltip">Drag & drop keywords to reorder</div>

<script type="text/javascript">
    $(document).ready(function () {
        activaTab('tab1')

        $('#rowselect_active').select2()

        $('#rowselect_inactive').select2()
    })

    function activaTab(tab) {
        $('#category_moviesactive').html('<option value="-1" selected>All</option>')
        $('.nav-tabs a[href="#' + tab + '"]').tab('show')
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search == '') {
            key_search = null
        }
        var category = $('#category_moviesactive').val()
        if (category == '') {
            category = null
        }
        $('#rowselect_active').select2()
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search, sort_by, order_sort, visible, category, rowperpage, 0)
    }

    function handleTab(type) {
        var isActive = type === 'active'
        $('#category_movies' + type).html('<option value="-1" selected>All</option>')
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = isActive ? 'Y' : 'N'
        $('#visible').val(visible)
        $('#searchinput' + type).val(null)
        var key_search = null
        var category = $('#category_movies' + type).val() || null
        $('#rowselect_' + type).val(10).trigger('change.select2')
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(key_search, sort_by, order_sort, visible, category, rowperpage, 0)
        if (isActive) {
            $("#tab2").hide()
            $("#tab1").show()
        } else {
            $("#tab1").hide()
            $("#tab2").show()
        }
    }

    $(document).on('click', '#tab_1', function () {
        handleTab('active')
    })

    $(document).on('click', '#tab_2', function () {
        handleTab('inactive')
    })

    function initCategorySelect(selector) {
        $(selector).select2({
            ajax: {
                url: '<?= base_url() ?>movies/category_movies',
                type: 'post',
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
            placeholder: 'Select a movies category',
            width: '100%',
            templateResult: format,
            templateSelection: formatSelection
        })
    }

    initCategorySelect('#category_moviesactive')

    initCategorySelect('#category_moviesinactive')

    function handleCategorySelect(categorySelector, rowSelector, searchSelector) {
        $(categorySelector).on('select2:select', function () {
            const visible = $('#visible').val()
            const sort_by = $('#sort_table').val()
            const order_sort = $('#order_table').val()
            const key_search = $(searchSelector).val() || null
            const category = $(this).val() || null
            const $row = $(rowSelector)
            $row.val(10).trigger('change.select2')
            loadPagination(key_search, sort_by, order_sort, visible, category, $row.val(), 0)
        })
    }

    handleCategorySelect('#category_moviesactive', '#rowselect_active', '#searchinputactive')

    handleCategorySelect('#category_moviesinactive', '#rowselect_inactive', '#searchinputinactive')

    function handleRowSelect(type) {
        var pageno = 0
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinput' + type).val() || null
        var category = $('#category_movies' + type).val() || null
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(key_search, sort_by, order_sort, visible, category, rowperpage, pageno)
    }

    $(document).on('change', '#rowselect_active', function () {
        handleRowSelect('active')
    })

    $(document).on('change', '#rowselect_inactive', function () {
        handleRowSelect('inactive')
    })

    function handleSearch(type) {
        var search = $('#searchinput' + type).val()
        if (!search || search.length < 4) {
            $('#wardingsearch' + type).show()
            setTimeout(function () {
                $('#wardingsearch' + type).hide()
            }, 5000)
            return
        }
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var category = $('#category_movies' + type).val() || null
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(search, sort_by, order_sort, visible, category, rowperpage, 0)
    }

    $(document).on('click', '#searchbuttonactive', function () {
        handleSearch('active')
    })

    $(document).on('click', '#searchbuttoninactive', function () {
        handleSearch('inactive')
    })

    function handlePaginationClick(paginationSelector, type) {
        $(paginationSelector).on('click', '.page-link', function (e) {
            e.preventDefault()
            var link = $(this).find('a')
            var pageno = link.data('ci-pagination-page')
            if (!pageno) {
                var text = $(this).text().trim()
                if (!isNaN(text)) {
                    pageno = parseInt(text, 10)
                }
            }
            if (!pageno) {
                return
            }
            var isActive = type === 'active'
            var key_search = $('#searchinput' + type).val() || null
            var category = $('#category_movies' + type).val() || null
            var rowperpage = $('#rowselect_' + type).val()
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var visible = $('#visible').val()
            loadPagination(key_search, sort_by, order_sort, visible, category, rowperpage, pageno)
        })
    }

    handlePaginationClick('#pagination', 'active')

    handlePaginationClick('#pagination2', 'inactive')

    function loadPagination(key_search, sort_by, order_sort, visible, category, rowperpage, pageno) {
        $.ajax({
            url: '<?=base_url()?>movies/list_movies/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+category+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var order_sort = response.order
                var x = response.x
                var y = response.y
                var z = response.z
                var show = 'Showing '+x+' to '+y+' of '+z+' entries'
                $('#data-table_info').html(show)
                if (visible == 'Y') {
                    $('#data-table_info').html(show)
                } else {
                    $('#data-table_info2').html(show)
                }
                if (response.pagination == "") {
                    var page1 = `<div class="pagging text-center">
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item active">
                                                <span class="page-link">1<span class="sr-only">(current)</span></span>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>`
                    if (visible == 'Y') {
                        $('#pagination').html(page1)
                    } else {
                        $('#pagination2').html(page1)
                    }
                } else {
                    if (visible == 'Y') {
                        $('#pagination').html(response.pagination)
                    } else {
                        $('#pagination2').html(response.pagination)
                    }
                }
                createTable(response.result, response.row)
            }
        })
    }

    function createTable(result, sno) {
        var statustable = $('#visible').val()
        if (statustable == 'Y') {
            $('#mytable1 tbody').empty()
        } else {
            $('#mytable2 tbody').empty()
        }
        if (result.length > 0) {
            sno = Number(sno)
            for (index in result) {
                var id = result[index].movie_id
                var code = result[index].movie_code
                var title = result[index].movie_title
                var type = result[index].movie_type
                var parent_id = result[index].movie_parent_id
                var image_url = result[index].imageUrl
                var image_type = result[index].imageType
                var stream_url = result[index].streamUrl
                if (image_url === null) {
                    var htmlimage = '<img id="myImg" src="assets/img/defaultuploadimage.png" alt="" width="60" height="60">'
                } else {
                    if (image_type === 'portrait') {
                        var htmlimage = '<img id="myImg" src="' + image_url + '" alt="" width="72" height="108">'
                    } else {
                        var htmlimage = '<img id="myImg" src="' + image_url + '" alt="" width="128" height="72">'
                    }
                }
                var previewurl = ""
                if (stream_url !== null) {
                    previewurl = "<a href='#!' onclick='preview(\""+stream_url+"\")' class='dropdown-item'><i class='zmdi zmdi-eye zmdi-hc-fw'></i>Preview</a>"
                }
                sno+=1
                var base_url = '<?php echo base_url()?>'
                var activeinactive = result[index].movie_visible == "N" 
                    ? `<a onclick="confirmAction('${id}', 'activate')" href="#!" class="dropdown-item">
                         <i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate Movie
                       </a>`
                    : `<a onclick="confirmAction('${id}', 'deactivate')" href="#!" class="dropdown-item">
                         <i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate Movie
                       </a>`
                var tr = "<tr id='"+id+"'>"
                tr += "<td>"+ sno +"</td>"
                tr += "<td>"+ htmlimage +"</td>"
                tr += "<td>"+ code +"</td>"
                tr += "<td>"+ title +"</td>"
                tr += "<td>"+ type +"</td>"
                tr += `<td>
                            <div class='dropdown'>
                                <button class='btn btn-light' data-toggle='dropdown' aria-expanded='false'>ACTION</button>
                                <div class='dropdown-menu dropdown-menu--icon'>
                                <?php if (has_permission('edit_movies')): ?>
                                    ${previewurl}
                                    <a href="<?= base_url('movies/edit/${id}') ?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                <?php endif; ?>
                                <?php if (has_permission('delete_movies')): ?>
                                    ${activeinactive}
                                <?php endif; ?>
                                </div>
                            </div>
                        </td>`
                tr += "</tr>"
                if (statustable == 'Y') {
                    $('#mytable1 tbody').append(tr)
                } else {
                    $('#mytable2 tbody').append(tr)
                }
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="10" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable == 'Y') {
                $('#mytable1 tbody').append(tr)
            } else {
                $('#mytable2 tbody').append(tr)
            }
        }
    }

    function confirmAction(id, action) {
        const settings = {
            activate: {
                url: '<?=base_url()?>movies/activated_movie',
                confirmText: 'Activate',
                confirmClass: 'btn btn-success',
                tabSelector: '#tab_1',
            },
            deactivate: {
                url: '<?=base_url()?>movies/inactivated_movie',
                confirmText: 'Deactivate',
                confirmClass: 'btn btn-danger',
                tabSelector: '#tab_2',
            }
        }
        const config = settings[action]
        if (!config) {
            return
        }
        swal({
            title: 'Are you sure?',
            type: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonClass: config.confirmClass,
            confirmButtonText: config.confirmText,
            cancelButtonClass: 'btn btn-light',
            background: '#222323',
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then(function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: config.url,
                    type: 'post',
                    data: {id: id},
                    dataType: 'json',
                    success: function (response) {
                        swal({
                            title: response.error === '0' ? 'Success' : 'Failed',
                            text: response.message,
                            type: response.error === '0' ? 'success' : 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(function (ok) {
                            if (ok && response.error === '0') {
                                $(config.tabSelector).trigger('click')
                            }
                        })
                    },
                    error: function () {
                        swal({
                            title: 'Failed',
                            text: 'Failed to process request',
                            type: 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        })
                    },
                })
            }
        })
    }

    function format (repo) {
        if (repo.loading) {
            return repo.text
        }
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'></div>" +
            "</div>"
        )
        $container.find('.select2-result-repository__title').text(repo.text)
        return $container
    }

    function formatSelection (repo) {
        return repo.text
    }

    window.player = videojs('my-video')

    function preview(url) {
        var vid_preview = '<video id="my-video" style="margin: 0 auto;" class="video-js vjs-theme-forest" controls preload="auto" width="410" height="230" data-setup="{}"><p class="vjs-no-js"> To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank"> supports HTML5 video</a></p></video>'
        var bungkus
        if ($('#bungkus').html() != undefined) {
            bungkus = $('#bungkus').html('').css({
                display: 'block',
                margin: '0 auto'
            })
            $('#changing-embed').html($(bungkus).append(vid_preview))
        } else {
            $('#changing-embed').html($('<div id="bungkus" style="display:block; margin: 0 auto;"></div>').append(vid_preview))
        }

        if (window.player.isReady_) {
            window.player.dispose()
        }

        window.player = videojs('my-video')
        window.player.src({
            src: url,
            type: 'application/x-mpegURL',
            // withCredentials: true
        })
        $('#modal-preview').modal('show')
        player.play()
    }

    $('#modal-preview').on('hidden.bs.modal', function (e) {
        player.pause()
    })

    // management code
    $('#code').click(function () {
        $('.tab_code_active').trigger('click')
    })

    function handleCodeTab(type) {
        var tableId = type === 'active' ? '#tableCodeActive' : '#tableCodeInactive'
        var tabShow = type === 'active' ? '#tab_code_active' : '#tab_code_inactive'
        var tabHide = type === 'active' ? '#tab_code_inactive' : '#tab_code_active'
        $(tableId + ' tbody').empty()
        var visible = type === 'active' ? 'Y' : 'N'
        $('#visible_code').val(visible)
        var sort_by = $('#sort_table_code').val()
        var order_sort = $('#order_table_code').val()
        $('#rowselectcode' + type).val(10).trigger('change.select2')
        var rowperpage = $('#rowselectcode' + type).val()
        sortPagination(null, sort_by, order_sort, visible, rowperpage, 0)
        $(tabHide).hide()
        $(tabShow).show()
    }

    $(document).on('click', '.tab_code_active', function () {
        handleCodeTab('active')
    })

    $(document).on('click', '.tab_code_inactive', function () {
        handleCodeTab('inactive')
    })

    $('#rowselectcodeactive').select2({
        minimumResultsForSearch: Infinity,
        width: '100%',
        dropdownParent: $('#modal-code'),
        dropdownCssClass: 'keyword-select2-dark'
    })

    $('#rowselectcodeinactive').select2({
        minimumResultsForSearch: Infinity,
        width: '100%',
        dropdownParent: $('#modal-code'),
        dropdownCssClass: 'keyword-select2-dark'
    })

    function handleRowSelectCode(type) {
        var pageno = 0
        var sort_by = $('#sort_table_code').val()
        var order_sort = $('#order_table_code').val()
        var visible = $('#visible_code').val()
        var key_search = $('#searchinputcode' + type).val() || null
        var rowperpage = $('#rowselectcode' + type).val()
        sortPagination(key_search, sort_by, order_sort, visible, rowperpage, pageno)
    }

    $(document).on('change', '#rowselectcodeactive', function () {
        handleRowSelectCode('active')
    })

    $(document).on('change', '#rowselectcodeinactive', function () {
        handleRowSelectCode('inactive')
    })

    function handleCodePaginationClick(paginationSelector, type) {
        $(paginationSelector).on('click', '.page-link', function (e) {
            e.preventDefault()
            var link = $(this).find('a')
            var pageno = link.data('ci-pagination-page')
            if (!pageno) {
                var text = $(this).text().trim()
                if (!isNaN(text)) {
                    pageno = parseInt(text, 10)
                }
            }
            if (!pageno) {
                return
            }
            var visible = $('#visible_code').val()
            var sort_by = $('#sort_table_code').val()
            var order_sort = $('#order_table_code').val()
            var key_search = $('#search_code_' + type).val() || null
            var rowperpage = $('#rowselectcode' + type).val()
            sortPagination(key_search, sort_by, order_sort, visible, rowperpage, pageno)
        })
    }

    handleCodePaginationClick('#pagination_code_active', 'active')

    handleCodePaginationClick('#pagination_code_inactive', 'inactive')

    function handleSearchCode(type) {
        var search = $('#searchinputcode' + type).val()
        if (!search || search.length < 3) {
            $('#wardingsearchcode' + type).show()
            setTimeout(function () {
                $('#wardingsearchcode' + type).hide()
            }, 5000)
            return
        }
        var sort_by = $('#sort_table_code').val()
        var order_sort = $('#order_table_code').val()
        var visible = $('#visible_code').val()
        var rowperpage = $('#rowselectcode' + type).val()
        sortPagination(search, sort_by, order_sort, visible, rowperpage, 0)
    }

    $(document).on('click', '#searchbuttoncodeactive', function () {
        handleSearchCode('active')
    })

    $(document).on('click', '#searchbuttoncodeinactive', function () {
        handleSearchCode('inactive')
    })

    function sortPagination(key_search, sort_by, order_sort, visible, rowperpage, pagno) {
        var statustable = $('#visible_code').val()
        $.ajax({
            url: '<?=base_url()?>movies/list_movie_code/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+rowperpage+'/'+pagno,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var order_sort = response.order
                var x = response.x
                var y = response.y
                var z = response.z
                var show = 'Showing '+x+' to '+y+' of '+z+' entries'
                $('#table_info_code_active').html(show)
                if (statustable == 'Y') {
                    $('#table_info_code_active').html(show)
                } else {
                    $('#table_info_code_inactive').html(show)
                }
                if (response.pagination == "") {
                    var page1 = `<div class="pagging text-center">
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item active">
                                                <span class="page-link">1<span class="sr-only">(current)</span></span>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>`
                    if (statustable=='Y') {
                        $('#pagination_code_active').html(page1)
                    } else {
                        $('#pagination_code_inactive').html(page1)
                    }
                } else {
                    if (statustable=='Y') {
                        $('#pagination_code_active').html(response.pagination)
                    } else {
                        $('#pagination_code_inactive').html(response.pagination)
                    }
                }
                createTableCode(response.result, response.row)
            }
        })
    }

    function createTableCode(result, sno) {
        var statustable = $('#visible_code').val()
        if (statustable == 'Y') {
            $('#tableCodeActive tbody').empty()
        } else {
            $('#tableCodeInactive tbody').empty()
        }
        if (result.length > 0) {
            sno = Number(sno)
            for (index in result) {
                var id = result[index].code_id
                var code_init = result[index].code_init
                var code_remark = result[index].code_remark
                sno += 1
                var base_url = '<?php echo base_url()?>'
                var html = result[index].code_visible == "N" 
                    ? `<a onclick="confirmCodeAction('${id}', 'activate')" href="#!" class="dropdown-item">
                         <i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate
                       </a>`
                    : `<a onclick="confirmCodeAction('${id}', 'deactivate')" href="#!" class="dropdown-item">
                         <i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate
                       </a>`
                var tr = "<tr>"
                tr += "<td>"+ sno +"</td>"
                tr += "<td>"+ id +"</td>"
                tr += "<td>"+ code_init +"</td>"
                tr += "<td>"+ code_remark +"</td>"
                tr += "<td><div class='dropdown'><button class='btn btn-light dropdown-toggle' data-toggle='dropdown'>ACTION</button><div class='dropdown-menu dropdown-menu--icon'>"+ html +"<a href='#!' onclick='edit_code(\""+id+"\")' class='dropdown-item'><i class='zmdi zmdi-edit zmdi-hc-fw'></i>Edit</a></div></div></td>"
                tr += "</tr>"
                if (statustable == 'Y') {
                    $('#tableCodeActive tbody').append(tr)
                } else {
                    $('#tableCodeInactive tbody').append(tr)
                }
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable == 'Y') {
                $('#tableCodeActive tbody').append(tr)
            } else {
                $('#tableCodeInactive tbody').append(tr)
            }
        }
    }

    function confirmCodeAction(id, action) {
        const settings = {
            activate: {
                url: '<?=base_url()?>movies/activate_code',
                confirmText: 'Activate',
                confirmClass: 'btn btn-success',
                tabSelector: '.tab_code_active',
            },
            deactivate: {
                url: '<?=base_url()?>movies/inactivate_code',
                confirmText: 'Deactivate',
                confirmClass: 'btn btn-danger',
                tabSelector: '.tab_code_inactive',
            }
        }
        const config = settings[action]
        if (!config) {
            return
        }
        swal({
            title: 'Are you sure?',
            type: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonClass: config.confirmClass,
            confirmButtonText: config.confirmText,
            cancelButtonClass: 'btn btn-light',
            background: '#222323',
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then(function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: config.url,
                    type: 'post',
                    data: {id: id},
                    dataType: 'json',
                    success: function (response) {
                        swal({
                            title: response.error === '0' ? 'Success' : 'Failed',
                            text: response.message,
                            type: response.error === '0' ? 'success' : 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(function (ok) {
                            if (ok && response.error === '0') {
                                $(config.tabSelector).trigger('click')
                            }
                        })
                    },
                    error: function () {
                        swal({
                            title: 'Failed',
                            text: 'Failed to process request',
                            type: 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        })
                    },
                })
            }
        })
    }

    $(document).on('click', '#addCode', (function (e) {
        e.preventDefault()
        var html = `<form action="#" method="post" id="form_code_crud" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Initial Code (*required)</label>
                                    <input name="initial_code" id="initial_code" type="text" class="form-control" placeholder="Please Input Initial Code" value="" maxlength="5" oninput="this.value = this.value.toUpperCase()" required>
                                    <span id="code_val" name="code_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Remark (*required)</label>
                                    <input name="remark" id="remark" type="text" class="form-control" placeholder="Please Input Remark" value="" required>
                                    <span id="remark_val" name="remark_val" style="color: red;"></span>
                                </div>
                            </div>
                        </div>`
        $('#changing-code').html(html)
        $('#modal-code-cu').modal('show')
    }))

    function edit_code(id) {
        var html = `<form action="#" method="post" id="form_code_crud" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Initial Code (*required)</label>
                                    <input name="initial_code" id="initial_code" type="text" class="form-control" placeholder="Please Input Initial Code" value="" maxlength="5" oninput="this.value = this.value.toUpperCase()" required>
                                    <span id="code_val" name="code_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Remark (*required)</label>
                                    <input name="remark" id="remark" type="text" class="form-control" placeholder="Please Input Remark" value="" required>
                                    <span id="remark_val" name="remark_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input type="hidden" name="code_id" id="code_id" value="${id}">
                        </div>`
        $('#changing-code').html(html)
        $.ajax({
            url: '<?php echo site_url("movies/get_data_edit_code") ?>',
            method: "POST",
            data: {id:id},
            async: true,
            dataType: 'json',
            success: function (data) {
                var val_init = data[0]['code_init']
                var val_remark = data[0]['code_remark']
                $('#form_code_crud [name="initial_code"]').val(val_init).trigger('change')
                $('#form_code_crud [name="remark"]').val(val_remark).trigger('change')
            }
        })
        $('#modal-code-cu').modal('show')
    }

    $(document).on('click', '#crud_code', (function (e) {
        e.preventDefault()
        var self = $('#form_code_crud')
        var initialCode_res = $(self).find('#initial_code').val()
        var remark_res = $(self).find('#remark').val()
        var codeId_res = $(self).find('#code_id').val()
        if (initialCode_res == '' || initialCode_res == null) {
            $('#code_val').text('* Please input initial code')
            $('#code_val').show()
        } else {
            $('#code_val').hide()
        }
        if (remark_res == '' || remark_res == null) {
            $('#remark_val').text('* Please input remark')
            $('#remark_val').show()
        } else {
            $('#remark_val').hide()
        }
        if (initialCode_res != '' && remark_res != '') {
            $('#crud_code').text('Submit...')
            $('#crud_code').attr('disabled', true)
            swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Yes',
                cancelButtonClass: 'btn btn-light',
                background: '#222323',
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '<?php echo site_url("movies/codeCreateUpdate") ?>',
                        type: 'post',
                        data: $('#form_code_crud').serialize(),
                        dataType: 'json',
                        success: function (response) {
                            swal({
                                title: response.error === '0' ? 'Success' : 'Failed',
                                text: response.message,
                                type: response.error === '0' ? 'success' : 'error',
                                buttonsStyling: false,
                                confirmButtonClass: 'btn btn-light',
                                background: '#222323',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            }).then(function (ok) {
                                if (ok && response.error === '0') {
                                    $('#crud_code').text('Submit')
                                    $('#crud_code').attr('disabled', false)
                                    $('#modal-code-cu').modal('hide')
                                    $(".tab_code_active").trigger('click')
                                } else {
                                    $('#crud_code').text('Submit')
                                    $('#crud_code').attr('disabled', false)
                                }
                            })
                        },
                        error: function () {
                            swal({
                                title: 'Failed',
                                text: 'Failed to process request',
                                type: 'error',
                                buttonsStyling: false,
                                confirmButtonClass: 'btn btn-light',
                                background: '#222323',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            }).then(function (ok) {
                                if (ok && response.error === '0') {
                                    $('#crud_code').text('Submit')
                                    $('#crud_code').attr('disabled', false)
                                }
                            })
                        },
                    })
                }
            })
        }
    }))
    // management code

    // management keyword
    $('#keyword').click(function () {
        $('.tab_keyword_active').trigger('click')
    })

    function handleKeywordTab(type) {
        var tableId = type === 'active' ? '#mytablekeyword1' : '#mytablekeyword2'
        var tabShow = type === 'active' ? '#tab_keyword_active' : '#tab_keyword_inactive'
        var tabHide = type === 'active' ? '#tab_keyword_inactive' : '#tab_keyword_active'
        var tabSelect = type === 'active' ? '#select_keyword_active' : '#select_keyword_inactive'
        $(tableId + ' tbody').empty()
        var visible = type === 'active' ? 'Y' : 'N'
        $('#visible_keyword').val(visible)
        var sort_by = $('#sort_table_keyword').val()
        var order_sort = $('#order_table_keyword').val()
        var contentKey = $(tabSelect).val()
        $('#rowselectkeyword' + type).val(10).trigger('change.select2')
        var rowperpage = $('#rowselectkeyword' + type).val()
        sortPaginationKeyword(null, sort_by, order_sort, visible, contentKey, rowperpage, 0)
        $(tabHide).hide()
        $(tabShow).show()
    }

    $(document).on('click', '.tab_keyword_active', function () {
        handleKeywordTab('active')
    })

    $(document).on('click', '.tab_keyword_inactive', function () {
        handleKeywordTab('inactive')
    })

    $('#rowselectkeywordactive').select2({
        minimumResultsForSearch: Infinity,
        width: '100%',
        dropdownParent: $('#modal-keyword'),
        dropdownCssClass: 'keyword-select2-dark'
    })

    $('#rowselectkeywordinactive').select2({
        minimumResultsForSearch: Infinity,
        width: '100%',
        dropdownParent: $('#modal-keyword'),
        dropdownCssClass: 'keyword-select2-dark'
    })

    function handleRowSelectKeyword(type) {
        var pageno = 0
        var sort_by = $('#sort_table_keyword').val()
        var order_sort = $('#order_table_keyword').val()
        var visible = $('#visible_keyword').val()
        var key_search = $('#searchinputkeyword' + type).val() || null
        var contentKey = $('#select_keyword_' + type).val() || null
        var rowperpage = $('#rowselectkeyword' + type).val()
        sortPaginationKeyword(key_search, sort_by, order_sort, visible, contentKey, rowperpage, pageno)
    }

    $(document).on('change', '#rowselectkeywordactive', function () {
        handleRowSelectKeyword('active')
    })

    $(document).on('change', '#rowselectkeywordinactive', function () {
        handleRowSelectKeyword('inactive')
    })

    $('#select_keyword_active').select2({
        minimumResultsForSearch: Infinity,
        width: '50%',
        dropdownParent: $('#modal-keyword'),
        dropdownCssClass: 'keyword-select2-dark'
    })

    $('#select_keyword_inactive').select2({
        minimumResultsForSearch: Infinity,
        width: '50%',
        dropdownParent: $('#modal-keyword'),
        dropdownCssClass: 'keyword-select2-dark'
    })

    function handleKeywordSelect(categorySelector, rowSelector, searchSelector) {
        $(categorySelector).on('select2:select', function () {
            const visible = $('#visible_keyword').val()
            const sort_by = $('#sort_table_keyword').val()
            const order_sort = $('#order_table_keyword').val()
            const key_search = $(searchSelector).val() || null
            var contentKey = $(categorySelector).val() || null
            const $row = $(rowSelector)
            $row.val(10).trigger('change.select2')
            sortPaginationKeyword(key_search, sort_by, order_sort, visible, contentKey, $row.val(), 0)
        })
    }

    handleKeywordSelect('#select_keyword_active', '#rowselectkeywordactive', '#searchinputkeywordactive')

    handleKeywordSelect('#select_keyword_inactive', '#rowselectkeywordinactive', '#searchinputkeywordinactive')

    function handlePaginationKeywordClick(paginationSelector, type) {
        $(paginationSelector).on('click', '.page-link', function (e) {
            e.preventDefault()
            var link = $(this).find('a')
            var pageno = link.data('ci-pagination-page')
            if (!pageno) {
                var text = $(this).text().trim()
                if (!isNaN(text)) {
                    pageno = parseInt(text, 10)
                }
            }
            if (!pageno) {
                return
            }
            var isActive = type === 'active'
            var visible = $('#visible_keyword').val()
            var sort_by = $('#sort_table_keyword').val()
            var order_sort = $('#order_table_keyword').val()
            var contentKey = $('#select_keyword_' + type).val()
            var key_search = $('#searchinputkeyword' + type).val() || null
            var rowperpage = $('#rowselectkeyword' + type).val()
            sortPaginationKeyword(key_search, sort_by, order_sort, visible, contentKey, rowperpage, pageno)
        })
    }

    handlePaginationKeywordClick('#pagination_keyword', 'active')

    handlePaginationKeywordClick('#pagination_keyword2', 'inactive')

    function handleSearchKeyword(type) {
        var search = $('#searchinputkeyword' + type).val()
        if (!search || search.length < 3) {
            $('#wardingsearchkeyword' + type).show()
            setTimeout(function () {
                $('#wardingsearchkeyword' + type).hide()
            }, 5000)
            return
        }
        var sort_by = $('#sort_table_keyword').val()
        var order_sort = $('#order_table_keyword').val()
        var visible = $('#visible_keyword').val()
        var category = $('#category_movies' + type).val() || null
        var contentKey = $('#select_keyword_' + type).val() || null
        var rowperpage = $('#rowselectkeyword' + type).val()
        sortPaginationKeyword(search, sort_by, order_sort, visible, contentKey, rowperpage, 0)
    }

    $(document).on('click', '#searchbuttonkeywordactive', function () {
        handleSearchKeyword('active')
    })

    $(document).on('click', '#searchbuttonkeywordinactive', function () {
        handleSearchKeyword('inactive')
    })

    function sortPaginationKeyword(key_search, sort_by, order_sort, visible, contentKey, rowperpage, pagno) {
        var statustable = $('#visible_keyword').val()
        $.ajax({
            url: '<?=base_url()?>movies/list_movie_keyword/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+contentKey+'/'+rowperpage+'/'+pagno,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var order_sort = response.order
                var x = response.x
                var y = response.y
                var z = response.z
                var show = 'Showing '+x+' to '+y+' of '+z+' entries'
                $('#data-table_keyword').html(show)
                if (statustable == 'Y') {
                    $('#data-table_keyword').html(show)
                } else {
                    $('#data-table_keyword2').html(show)
                }
                if (response.pagination == "") {
                    var page1 = `<div class="pagging text-center">
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item active">
                                                <span class="page-link">1<span class="sr-only">(current)</span></span>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>`
                    if (statustable == 'Y') {
                        $('#pagination_keyword').html(page1)
                    } else {
                        $('#pagination_keyword2').html(page1)
                    }
                } else {
                    if (statustable == 'Y') {
                        $('#pagination_keyword').html(response.pagination)
                    } else {
                        $('#pagination_keyword2').html(response.pagination)
                    }
                }
                createTableKeyword(response.result, response.row, contentKey)
            }
        })
    }

    function createTableKeyword(result, sno, contentKey) {
        var statustable = $('#visible_keyword').val()
        if (statustable == 'Y') {
            $tbody = $('#mytablekeyword1 tbody')
            $('#mytablekeyword1 tbody').empty()
            var contentKey = $('#select_keyword_active').val()
            if (contentKey == 'STD') {
                $('#mytablekeyword1 tbody').css('cursor', 'all-scroll')
            } else {
                $('#mytablekeyword1 tbody').css('cursor', 'default')
            }
        } else {
            $tbody = $('#mytablekeyword2 tbody')
            $('#mytablekeyword2 tbody').empty()
        }
        if (result.length > 0) {
            sno = Number(sno)
            for (index in result) {
                var id = result[index].keyword_id
                var title = result[index].keyword_name
                if (contentKey == 'SUBGEN') {
                    var genreName = result[index].genre_name
                    title = title + " ("+genreName+")"
                }
                sno+=1
                var base_url ='<?php echo base_url()?>'
                var html = result[index].keyword_visible == "N" 
                    ? `<a onclick="confirmKeywordAction('${id}', 'activate')" href="#!" class="dropdown-item">
                         <i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate
                       </a>`
                    : `<a onclick="confirmKeywordAction('${id}', 'deactivate')" href="#!" class="dropdown-item">
                         <i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate
                       </a>`
                var tr = "<tr id='"+id+"'>"
                tr += "<td>"+ sno +"</td>"
                tr += "<td>"+ title +"</td>"
                tr += "<td><div class='dropdown'><button class='btn btn-light dropdown-toggle' data-toggle='dropdown'>ACTION</button><div class='dropdown-menu dropdown-menu--icon'>"+ html +"<a href='#!' onclick='edit_keyword(\""+id+"\")' class='dropdown-item'><i class='zmdi zmdi-edit zmdi-hc-fw'></i>Edit</a></div></div></td>"
                tr += "</tr>"
                if (statustable=='Y') {
                    $('#mytablekeyword1 tbody').append(tr)
                } else {
                    $('#mytablekeyword2 tbody').append(tr)
                }
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="3" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable == 'Y') {
                $('#mytablekeyword1 tbody').append(tr)
            } else {
                $('#mytablekeyword2 tbody').append(tr)
            }
        }
        if (statustable == 'Y' && contentKey == 'STD') {
            if (!$tbody.hasClass('ui-sortable')) {
                $tbody.sortable({
                    placeholder : 'ui-state-highlight',
                    update: function (event, ui) {
                        swal({
                            title: 'Are you sure?',
                            type: 'warning',
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-success',
                            confirmButtonText: 'Yes',
                            cancelButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(function (isConfirm) {
                            if (isConfirm) {
                                var page_id_array = new Array()
                                $('tbody tr').each(function () {
                                    page_id_array.push($(this).attr('id'))
                                })

                                $.ajax({
                                    url: '<?=base_url()?>movies/update_sort',
                                    method: 'POST',
                                    data: {page_id_array: page_id_array, action: 'update'},
                                    dataType: 'json',
                                    success: function (response) {
                                        swal({
                                            title: response.error === '0' ? 'Success' : 'Failed',
                                            text: response.message,
                                            type: response.error === '0' ? 'success' : 'error',
                                            buttonsStyling: false,
                                            confirmButtonClass: 'btn btn-light',
                                            background: '#222323',
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                        }).then(function (ok) {
                                            if (ok && response.error === '0') {
                                                $('.tab_keyword_active').trigger('click')
                                            } else {
                                                $tbody.sortable('cancel')
                                            }
                                        })
                                    },
                                    error: function () {
                                        swal({
                                            title: 'Failed',
                                            text: 'Failed to process request',
                                            type: 'error',
                                            buttonsStyling: false,
                                            confirmButtonClass: 'btn btn-light',
                                            background: '#222323',
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                        }).then(function (ok) {
                                            if (ok) {
                                                $tbody.sortable('cancel')
                                            }
                                        })
                                    },
                                })
                            }
                        }).catch(function () {
                            $tbody.sortable('cancel')
                        })
                    }
                })
            }
        } else {
            if ($tbody.hasClass('ui-sortable')) {
                $tbody.sortable('destroy')
            }
        }
    }

    const tbody = document.getElementById('my-tbody')
    const tooltip = document.getElementById('tbody-tooltip')

    function updateTooltipVisibility() {
        const contentKey = $('#select_keyword_active').val()
        return contentKey === 'STD'
    }

    tbody.addEventListener('mousemove', function (e) {
        if (!updateTooltipVisibility()) {
            tooltip.style.display = 'none'
            return
        }
        tooltip.style.left = (e.pageX + 10) + 'px' 
        tooltip.style.top = (e.pageY + 15) + 'px'
    })

    tbody.addEventListener('mouseenter', function () {
        if (updateTooltipVisibility()) {
            tooltip.style.display = 'block'
        } else {
            tooltip.style.display = 'none'
        }
    })

    tbody.addEventListener('mouseleave', function () {
        tooltip.style.display = 'none'
    })

    function confirmKeywordAction(id, action) {
        const settings = {
            activate: {
                url: '<?=base_url()?>movies/activate_keyword',
                confirmText: 'Activate',
                confirmClass: 'btn btn-success',
                tabSelector: '.tab_keyword_active',
            },
            deactivate: {
                url: '<?=base_url()?>movies/inactivate_keyword',
                confirmText: 'Deactivate',
                confirmClass: 'btn btn-danger',
                tabSelector: '.tab_keyword_inactive',
            }
        }
        const config = settings[action]
        if (!config) {
            return
        }
        swal({
            title: 'Are you sure?',
            type: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonClass: config.confirmClass,
            confirmButtonText: config.confirmText,
            cancelButtonClass: 'btn btn-light',
            background: '#222323',
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then(function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: config.url,
                    type: 'post',
                    data: {id: id},
                    dataType: 'json',
                    success: function (response) {
                        swal({
                            title: response.error === '0' ? 'Success' : 'Failed',
                            text: response.message,
                            type: response.error === '0' ? 'success' : 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(function (ok) {
                            if (ok && response.error === '0') {
                                $(config.tabSelector).trigger('click')
                            }
                        })
                    },
                    error: function () {
                        swal({
                            title: 'Failed',
                            text: 'Failed to process request',
                            type: 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-light',
                            background: '#222323',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        })
                    },
                })
            }
        })
    }

    $('#select_keyword_active').on('change', function () {
        tooltip.style.display = updateTooltipVisibility() ? 'block' : 'none'
    })

    $(document).on('click', '#add_keyword', (function (e) {
        e.preventDefault()
        var html = `<form action="#" method="post" id="form_crud_keyword" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name (*required)</label>
                                    <input name="keyword_name" id="keyword_name" type="text" class="form-control" placeholder="Please Input Keyword Name" value="" required>
                                    <span id="keyname_val" name="keyname_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Child (*required)</label>
                                    <select class="form-control" name="keyword_child" id="keyword_child" required>
                                        <option value="SIN">SIN</option>
                                        <option value="SEA">SEA</option>
                                        <option value="SER">SER</option>
                                        <option value="MIX">MIX</option>
                                    </select>
                                    <span id="child_val" name="child_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Ref (*required)</label>
                                    <select class="form-control" name="keyword_ref" id="keyword_ref" required>
                                        <option value="STD">STD</option>
                                        <option value="GEN">GEN</option>
                                        <option value="SUBGEN">SUBGEN</option>
                                    </select>
                                    <span id="ref_val" name="ref_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-12" name="genreforsubgenre" id="genreforsubgenre" style="display: none;">
                                <div class="form-group">
                                    <label>Genre (*required)</label>
                                    <select class="form-control" name="genre_id" id="genre_id" required>
                                    </select>
                                    <span id="genre_val" name="genre_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input type="hidden" name="keyword_id" id="keyword_id" value="">
                        </div>`
        $('#changing-keyword').html(html)

        $('#keyword_child').select2({
            minimumResultsForSearch: Infinity,
            width: '100%',
            dropdownParent: $('#modal-keyword-cu'),
            dropdownCssClass: 'keyword-select2-dark'
        })

        $('#keyword_ref').select2({
            minimumResultsForSearch: Infinity,
            width: '100%',
            dropdownParent: $('#modal-keyword-cu'),
            dropdownCssClass: 'keyword-select2-dark'
        })

        $('#keyword_ref').on('select2:select', function (e) {
            var ref = $('#keyword_ref').val()
            if (ref == 'SUBGEN') {
                $('#genreforsubgenre').css('display', 'block')
                $('#genre_id').select2({
                    ajax: {
                        url: '<?= base_url() ?>movies/get_list_genre',
                        type: 'post',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                searchTerm: params.term,
                                page: params.page,
                            }
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1
                            return {
                                results: data.items.map(function (item) {
                                    return {
                                        id: item.keyword_id,
                                        text: item.keyword_name.trim()
                                    }
                                }),
                                pagination: {
                                    more: (params.page * 10) < data.total_count
                                }
                            }
                        },
                        cache: true
                    },
                    placeholder: 'Select genre',
                    minimumResultsForSearch: Infinity,
                    width: '100%',
                    dropdownParent: $('#modal-keyword-cu'),
                    dropdownCssClass: 'keyword-select2-dark',
                    templateResult: format,
                    templateSelection: formatSelection
                })
            } else {
                $('#genreforsubgenre').css('display', 'none')
                $('#genre_id').val(null).trigger('change')
            }
        })
        $('#modal-keyword-cu').modal('show')
    }))

    function edit_keyword(id) {
        var html = `<form action="#" method="post" id="form_crud_keyword" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name (*required)</label>
                                    <input name="keyword_name" id="keyword_name" type="text" class="form-control" placeholder="Please Input Keyword Name" value="" required>
                                    <span id="keyname_val" name="keyname_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Child (*required)</label>
                                    <select class="form-control" name="keyword_child" id="keyword_child" required>
                                        <option value="SIN">SIN</option>
                                        <option value="SEA">SEA</option>
                                        <option value="SER">SER</option>
                                        <option value="MIX">MIX</option>
                                    </select>
                                    <span id="child_val" name="child_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Ref (*required)</label>
                                    <select class="form-control" name="keyword_ref" id="keyword_ref" required>
                                        <option value="STD">STD</option>
                                        <option value="GEN">GEN</option>
                                        <option value="SUBGEN">SUBGEN</option>
                                    </select>
                                    <span id="ref_val" name="ref_val" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-12" name="genreforsubgenre" id="genreforsubgenre" style="display: none;">
                                <div class="form-group">
                                    <label>Genre (*required)</label>
                                    <select class="form-control" name="genre_id" id="genre_id" required>
                                    </select>
                                    <span id="genre_val" name="genre_val" style="color: red;"></span>
                                </div>
                            </div>
                            <input type="hidden" name="keyword_id" id="keyword_id" value="${id}">
                        </div>`
        $('#changing-keyword').html(html)

        $('#keyword_child').select2({
            minimumResultsForSearch: Infinity,
            width: '100%',
            dropdownParent: $('#modal-keyword-cu'),
            dropdownCssClass: 'keyword-select2-dark'
        })

        $('#keyword_ref').select2({
            minimumResultsForSearch: Infinity,
            width: '100%',
            dropdownParent: $('#modal-keyword-cu'),
            dropdownCssClass: 'keyword-select2-dark'
        })

        $('#keyword_ref').on('select2:select', function (e) {
            var ref = $('#keyword_ref').val()
            if (ref == 'SUBGEN') {
                $('#genreforsubgenre').css('display', 'block')
                $('#genre_id').select2({
                    ajax: {
                        url: '<?= base_url() ?>movies/get_list_genre',
                        type: 'post',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                searchTerm: params.term,
                                page: params.page,
                            }
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1
                            return {
                                results: data.items.map(function (item) {
                                    return {
                                        id: item.keyword_id,
                                        text: item.keyword_name.trim()
                                    }
                                }),
                                pagination: {
                                    more: (params.page * 10) < data.total_count
                                }
                            }
                        },
                        cache: true
                    },
                    placeholder: 'Select genre',
                    minimumResultsForSearch: Infinity,
                    width: '100%',
                    dropdownParent: $('#modal-keyword-cu'),
                    dropdownCssClass: 'keyword-select2-dark',
                    templateResult: format,
                    templateSelection: formatSelection
                })
            } else {
                $('#genreforsubgenre').css('display', 'none')
                $('#genre_id').val(null).trigger('change')
            }
        })

        $.ajax({
            url : '<?php echo site_url("movies/get_data_edit_keyword") ?>',
            method : 'POST',
            data : {id:id},
            async : true,
            dataType : 'json',
            success : function (data) {
                var val_name = data[0]['keyword_name']
                var val_child = data[0]['keyword_child']
                var val_ref = data[0]['keyword_ref']
                var val_genreid = data[0]['keyword_parentid']
                $('#form_crud_keyword [name="keyword_name"]').val(val_name).trigger('change')
                $('#form_crud_keyword [name="keyword_child"]').val(val_child).trigger('change')
                $('#form_crud_keyword [name="keyword_ref"]').val(val_ref).trigger('change')
                if (val_ref == 'GEN') {
                    if (val_genreid != '' || val_genreid != null) {
                        $('#genreforsubgenre').css('display', 'block')
                        $('#form_crud_keyword [name="keyword_ref"]').val('SUBGEN').trigger('change')
                        $('#genre_id').select2({
                            ajax: {
                                url: '<?= base_url() ?>movies/get_list_genre',
                                type: 'post',
                                dataType: 'json',
                                delay: 250,
                                data: function (params) {
                                    return {
                                        searchTerm: params.term,
                                        page: params.page,
                                    }
                                },
                                processResults: function (data, params) {
                                    params.page = params.page || 1
                                    return {
                                        results: data.items.map(function (item) {
                                            return {
                                                id: item.keyword_id,
                                                text: item.keyword_name.trim()
                                            }
                                        }),
                                        pagination: {
                                            more: (params.page * 10) < data.total_count
                                        }
                                    }
                                },
                                cache: true
                            },
                            placeholder: 'Select genre',
                            minimumResultsForSearch: Infinity,
                            width: '100%',
                            dropdownParent: $('#modal-keyword-cu'),
                            dropdownCssClass: 'keyword-select2-dark',
                            templateResult: format,
                            templateSelection: formatSelection
                        })
                        var id_parent = data[0]['id_parent']
                        var name_parent = data[0]['name_parent']
                        var str = ''
                        str += '<option value = "'+id_parent+'" selected >'+name_parent+'</option>'
                        $("#genre_id").append(str)
                    }
                }
            }
        })
        $('#modal-keyword-cu').modal('show')
    }

    $("#crud_keyword").click(function () {
        var self = $('#form_crud_keyword')
        var keyname_res = $(self).find('#keyword_name').val()
        var keychild_res = $(self).find('#keyword_child').val()
        var keyref_res = $(self).find('#keyword_ref').val()
        var genid_res = $(self).find('#genre_id').val()
        if (keyname_res == '' || keyname_res == null) {
            $('#keyname_val').text('* Please input name')
            $('#keyname_val').show()
        } else {
            $("#keyname_val").hide()
        }
        if (keychild_res == '' || keychild_res == null) {
            $('#child_val').text('* Please select child')
            $('#child_val').show()
        } else {
            $("#child_val").hide()
        }
        if (keyref_res == '' || keyref_res == null) {
            $('#ref_val').text('* Please select ref')
            $('#ref_val').show()
        } else {
            $("#ref_val").hide()
        }
        if (keyref_res == 'SUBGEN') {
            if (genid_res == '' || genid_res == null) {
                $('#genre_val').text('* Please select genre')
                return $('#genre_val').show()
            } else {
                $("#genre_val").hide()
            }
        }
        if (keyname_res != '' && keychild_res != '' && keyref_res != '') {
            $('#crud_keyword').text('Submit...')
            $('#crud_keyword').attr('disabled', true)
            swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Yes',
                cancelButtonClass: 'btn btn-light',
                background: '#222323',
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '<?php echo site_url("movies/cu_keyword") ?>',
                        type: 'post',
                        data: $('#form_crud_keyword').serialize(),
                        dataType: 'json',
                        success: function (response) {
                            swal({
                                title: response.error === '0' ? 'Success' : 'Failed',
                                text: response.message,
                                type: response.error === '0' ? 'success' : 'error',
                                buttonsStyling: false,
                                confirmButtonClass: 'btn btn-light',
                                background: '#222323',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            }).then(function (ok) {
                                if (ok && response.error === '0') {
                                    $('#crud_keyword').text('Submit')
                                    $('#crud_keyword').attr('disabled', false)
                                    $('#modal-keyword-cu').modal('hide')
                                    $(".tab_keyword_active").trigger('click')
                                } else {
                                    $('#crud_keyword').text('Submit')
                                    $('#crud_keyword').attr('disabled', false)
                                }
                            })
                        },
                        error: function () {
                            swal({
                                title: 'Failed',
                                text: 'Failed to process request',
                                type: 'error',
                                buttonsStyling: false,
                                confirmButtonClass: 'btn btn-light',
                                background: '#222323',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            }).then(function (ok) {
                                if (ok && response.error === '0') {
                                    $('#crud_keyword').text('Submit')
                                    $('#crud_keyword').attr('disabled', false)
                                }
                            })
                        },
                    })
                }
            })
        }
    })
    // management keyword
</script>