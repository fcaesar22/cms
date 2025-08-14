<style type="text/css">
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
    #searchinputactive{padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 60%; color: white; background: transparent;}
    #searchinputinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 80%; color: white; background: transparent;}
    #searchbuttonactive, #searchbuttoninactive { float: left; width: 20%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow {float: left; width: 20%; padding: 5px; color: white; font-size: 12px; border: 1px solid white; border-left: none; cursor: pointer; margin-bottom: 10px;}
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    .flatpickr-calendar.animate.open {width: 325px;}
    .flatpickr-prev-month svg path, .flatpickr-next-month svg path {fill: white;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Movies</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('movies') ?>">Movies</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?= form_open('movies/create') ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Movie Code (*required)</label>&nbsp;
                                <a class="btn btn-light btn-sm" data-toggle="modal" name="code" id="code" data-target="#modal-code"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Movie Code</a>
                                <select class="form-control" name="movie_code" id="movie_code" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('movie_code') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Movie Type(*required)</label>
                                <select class="form-control" name="movie_type" id="movie_type" required>
                                    <option value="">Select a movie type</option>
                                    <option value="SIN" <?= set_select('movie_type', 'SIN') ?>>Single / Episode</option>
                                    <option value="SEA" <?= set_select('movie_type', 'SEA') ?>>Season</option>
                                    <option value="SER" <?= set_select('movie_type', 'SER') ?>>Series Cover</option>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('movie_type') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Movie Parent (*required)</label>
                                <select class="form-control" name="movie_parent" id="movie_parent">
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('movie_parent') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Movie Parent ID (*required)</label>
                                <select class="form-control" name="movie_parent_id" id="movie_parent_id">
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('movie_parent_id') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Movie Child (*required)</label>
                                <select class="form-control" name="movie_child" id="movie_child" required>
                                    <option value="">Select a movie parent</option>
                                    <option value="SEA" <?= set_select('movie_child', 'SEA') ?>>Season</option>
                                    <option value="SIN" <?= set_select('movie_child', 'SIN') ?>>Episode</option>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('movie_child') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Group Keyword (*required)</label>&nbsp;
                                <a class="btn btn-light btn-sm" data-toggle="modal" name="keyword" data-target="#modal-keyword" id="keyword"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Keyword</a>
                                <select class="form-control" name="group_keyword[]" id="group_keyword" multiple="multiple" required>
                                </select>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('group_keyword') ?></span>
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
                                <label>Actor (*required)</label>
                                <input type="text" name="actor" id="actor" class="form-control" value="<?= set_value('actor') ?>" placeholder="Please Input Actor" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('actor') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Director (*required)</label>
                                <input type="text" name="director" id="director" class="form-control" value="<?= set_value('director') ?>" placeholder="Please Input Director" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('director') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Year</label>
                                <input class="form-control" type="text" name="year" id="year" value="<?= set_value('year', '0') ?>" placeholder="Please Input Year" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onfocus="this.select()" onblur="if(this.value === '') this.value = '0';">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('year') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Parental Guide (*required)</label>
                                <input type="text" name="parental_guide" id="parental_guide" class="form-control" value="<?= set_value('parental_guide') ?>" placeholder="ex: G, PG, PG-13, R" required>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('parental_guide') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sequence Number</label>
                                <input class="form-control" type="text" name="sequence_number" id="sequence_number" value="<?= set_value('sequence_number', '0') ?>" placeholder="Please Input Sequence Number" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onfocus="this.select()" onblur="if(this.value === '') this.value = '0';">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('sequence_number') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Price</label>
                                <input class="form-control" type="text" name="price" id="price" value="<?= set_value('price', '0') ?>" placeholder="Please Input Price" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onfocus="this.select()" onblur="if(this.value === '') this.value = '0';">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('price') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rental Duration</label>
                                <input class="form-control" type="text" name="rental_duration" id="rental_duration" value="<?= set_value('rental_duration', '0') ?>" placeholder="Please Input Rental Duration" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onfocus="this.select()" onblur="if(this.value === '') this.value = '0';">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('rental_duration') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>URL Trailer</label>
                                <input type="text" name="url_trailer" id="url_trailer" class="form-control" value="<?= set_value('url_trailer') ?>" placeholder="Please Input URL Trailer">
                                <span class="invalid-feedback" style="display:block;"><?= form_error('url_trailer') ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Allowed on devices</label>
                            <div class="form-group">
                                <label>PC</label>
                                <div class="btn-group btn-group--colors pcs" data-toggle="buttons">
                                    <label class="btn <?= set_checkbox('allowed_pc', '1') ? 'active' : '' ?>">
                                        <input name="allowed_pc" id="allowed_pc" type="checkbox" value="1" autocomplete="off" <?= set_checkbox('allowed_pc', '1') ?>>
                                    </label>
                                </div>
                                <label>STB</label>
                                <div class="btn-group btn-group--colors stbs" data-toggle="buttons">
                                    <label class="btn <?= set_checkbox('allowed_stb', '1') ? 'active' : '' ?>">
                                        <input name="allowed_stb" id="allowed_stb" type="checkbox" value="1" autocomplete="off" <?= set_checkbox('allowed_stb', '1') ?>>
                                    </label>
                                </div>
                                <label>Android</label>
                                <div class="btn-group btn-group--colors adrs" data-toggle="buttons">
                                    <label class="btn <?= set_checkbox('allowed_android', '1') ? 'active' : '' ?>">
                                        <input name="allowed_android" id="allowed_android" type="checkbox" value="1" autocomplete="off" <?= set_checkbox('allowed_android', '1') ?>>
                                    </label>
                                </div>
                                <label>iOS</label>
                                <div class="btn-group btn-group--colors ioss" data-toggle="buttons">
                                    <label class="btn <?= set_checkbox('allowed_ios', '1') ? 'active' : '' ?>">
                                        <input name="allowed_ios" id="allowed_ios" type="checkbox" value="1" autocomplete="off" <?= set_checkbox('allowed_ios', '1') ?>>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Sell Methode (*required)</label>
                            <div class="form-group">
                                <label class="custom-control custom-radio">
                                    <input name="sell_methode" type="radio" class="custom-control-input" value="1" <?= set_radio('sell_methode', '1', TRUE); ?>>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Retail</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input name="sell_methode" type="radio" class="custom-control-input" value="0" <?= set_radio('sell_methode', '0'); ?>>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Package Sell</span>
                                </label>
                                <br>
                                <span class="invalid-feedback" style="display:block;"><?= form_error('sell_methode') ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
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
                        <div class="col-md-12" align="center">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-code" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title pull-left">Add Category</h5> -->
            </div>
            <div class="modal-body">
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link adds active" data-toggle="tab" href="#tab_add_code" role="tab">Add</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menulist" data-toggle="tab" href="#tab_list_code" role="tab">List</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active fade show" id="tab_add_code" role="tabpanel">
                            
                        </div>
                        <div class="tab-pane fade" id="tab_list_code" role="tabpanel">
                            <input type="hidden" name="visible_code" id="visible_code" value="Y">
                            <input type="hidden" name="sort_table_code" id="sort_table_code" value="code_id">
                            <input type="hidden" name="order_table_code" id="order_table_code" value="desc">
                            <h5>List Movie Code</h5><hr>
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
                                    <div class="tab-pane active fade show" id="tab_code_active" role="tabpanel">
                                        <div id="data-table_filter" class="dataTables_filter">
                                            <label>Search:
                                                <input type="search" id="search_word" name="search_word" maxlength="50" placeholder="Search for movie code..." aria-controls="data-table">
                                            </label>
                                        </div>
                                        <br>
                                        <div id="table_category" class="table-responsive">
                                            <table class="table table-striped table-inverse table-bordered mb-0" id="mytable1" width="100%" cellspacing="0">
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
                                            <div class="dataTables_info" id="data-table_info" role="status" aria-live="polite"></div>
                                            <div style='margin-top: 10px;' id='pagination'></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_code_inactive" role="tabpanel">
                                        <div id="data-table_filter" class="dataTables_filter">
                                            <label>Search:
                                                <input type="search" id="search_word2" name="search_word2" maxlength="50" placeholder="Search for category name..." aria-controls="data-table">
                                            </label>
                                        </div>
                                        <br>
                                        <div id="table_category" class="table-responsive">
                                            <table class="table table-striped table-inverse table-bordered mb-0" id="mytable2" width="100%" cellspacing="0">
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
                                            <div class="dataTables_info" id="data-table_info2" role="status" aria-live="polite"></div>
                                            <div style='margin-top: 10px;' id='pagination2'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" id="insert_code" class="btn btn-light">Submit</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Edit</h5>
            </div>
            <div class="modal-body">
                <div id="changing-edit">
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button id="update_code" type="button" class="btn btn-light">Update</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-keyword" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">List Keywords</h5>
                <hr>
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
                        <div class="tab-pane active fade show" id="tab_keyword_active" role="tabpanel">
                            <button class="btn btn-light" name="add_keyword" id="add_keyword">Add Keyword</button>
                            <br>
                            <br>
                            <select class="form-control" name="select_keyword_active" id="select_keyword_active" required>
                                <option value="STD">Studio</option>
                                <option value="GEN">Genre</option>
                                <option value="SUBGEN">Sub Genre</option>
                            </select>
                            <br><br>
                            <span class="invalid-feedback" id="wardingsearchactive" name="wardingsearchactive" style="display:none;">minimum 5 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputactive" id="searchinputactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttonactive" id="searchbuttonactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                            <button type="button" name="selectrow" id="selectrow" class="btn btn-light">
                                <select name="rowselect" id="rowselect">
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
                                    <tbody class="tableactive">
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
                            <span class="invalid-feedback" id="wardingsearchinactive" name="wardingsearchinactive" style="display:none;">minimum 5 charachters</span>
                            <input type="search" placeholder="Search for title..." name="searchinputinactive" id="searchinputinactive" minlength="5" maxlength="50">
                            <button type="button" name="searchbuttoninactive" id="searchbuttoninactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
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
                <button id="crud_keyword" type="button" class="btn btn-light">Submit</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

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
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button id="submit_data" type="button" class="btn btn-link">Save</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var selectedGroupKeyword = <?= json_encode((array) $selected_group_keyword) ?>;

    $(document).ready(function(){
        $('#movie_code').select2({
            ajax: {
                url: '<?= base_url() ?>movies/get_list_movie_code',
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
            placeholder: "Select a Movie Code",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedMovieCode) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>movies/get_single_movie_code',
                data: { id: selectedMovieCode },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#movie_code').append(option).trigger('change');
                }
            });
        }

        $('#movie_type').select2({})

        $('#movie_parent').select2({})

        $('#movie_parent_id').select2({})

        $('#movie_child').select2({})

        $('#movie_type').on('select2:select', function (e) {
            $('#movie_parent').val(null).trigger('change');
            $('#movie_parent_id').val(null).trigger('change');
            $('#movie_child').val(null).trigger('change');
            var type = $('#movie_type').val()
            initMovieParentSelect2(type);
        })

        var selectedType = $('#movie_type').val();
        if (selectedType) {
            initMovieParentSelect2(selectedType);
        }

        if (selectedMovieParent) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>movies/get_single_movie_parent',
                data: { id: selectedMovieParent },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#movie_parent').append(option).trigger('change');
                }
            });
        }

        $('#movie_parent').on('select2:select', function (e) {
            $('#movie_parent_id').val(null).trigger('change');
            $('#movie_child').val(null).trigger('change');
            var parent = $('#movie_parent').val()
            initMovieParentIDSelect2(parent)
        })


        if (selectedMovieParentID && selectedMovieParent) {
            initMovieParentIDSelect2(selectedMovieParent);
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>movies/get_single_movie_parent_id',
                data: {
                    id: selectedMovieParentID,
                    movie_parent: selectedMovieParent
                },
                dataType: 'json'
            }).then(function (data) {
                if (data && data.id) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#movie_parent_id').append(option).trigger('change');
                }
            });
        }

        $('#group_keyword').select2({
            ajax: {
                url: '<?= base_url() ?>movies/get_list_group_keyword',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page,
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
            placeholder: "Select a group keyword",
            templateResult: format,
            templateSelection: formatSelection
        })

        if (selectedGroupKeyword.length > 0) {
            $.ajax({
                url: '<?= base_url("movies/get_multiple_group_keyword") ?>',
                type: 'POST',
                dataType: 'json',
                data: { ids: selectedGroupKeyword },
                success: function (response) {
                    response.forEach(function (group) {
                        var option = new Option(group.text, group.id, true, true);
                        $('#group_keyword').append(option).trigger('change');
                    });
                }
            });
        }
    })

    function initMovieParentSelect2(type) {
        $('#movie_parent').select2({
            ajax: {
                url: '<?= base_url() ?>movies/get_list_movie_parent',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page,
                        movie_type: type
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
            placeholder: "Select Movie Parent",
            templateResult: format,
            templateSelection: formatSelection
        });
    }

    function initMovieParentIDSelect2(parent) {
        $('#movie_parent_id').select2({
            ajax: {
                url: '<?= base_url() ?>movies/get_list_movie_parent_id',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        page: params.page,
                        movie_parent: parent
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
            placeholder: "Select Movie Parent ID",
            templateResult: format,
            templateSelection: formatSelection
        })
    }

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

    $( function() {
        $("#publish_date").flatpickr({
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: "<?= set_value('publish_date') ?>"
        })
        $("#publish_date").prop('readonly', false)
    });

    // management code
    $(".adds").click(function(){
        $('#insert_code').css('display', 'block')
    });

    $(".menulist").click(function(){
        $(".tab_code_active").trigger('click');
    });

    $(".tab_code_active").click(function(){
        $('#insert_code').css('display', 'none')
        $('#mytable1 tbody').empty();
        $('#visible_code').val('Y')
        var visible = $('#visible_code').val()
        var sort_by = $('#sort_table_code').val()
        var order_sort = $('#order_table_code').val()
        sortPagination(null,sort_by,order_sort,visible,0);
        $("#tab_code_inactive").hide();
        $("#tab_code_active").show();
    });

    $(".tab_code_inactive").click(function(){
        $('#insert_code').css('display', 'none')
        $('#mytable2 tbody').empty();
        $('#visible_code').val('N')
        var visible = $('#visible_code').val()
        var sort_by = $('#sort_table_code').val()
        var order_sort = $('#order_table_code').val()
        sortPagination(null,sort_by,order_sort,visible,0);
        $("#tab_code_active").hide();
        $("#tab_code_inactive").show();
    });

    $('#pagination').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var visible = $('#visible_code').val()
        var sort_by = $('#sort_table_code').val()
        var order_sort = $('#order_table_code').val()
        var key_search = $('#search_word').val()
        if (key_search=='') {
            key_search = null
        }
        sortPagination(key_search,sort_by,order_sort,visible,pageno);
    });

    $('#pagination2').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var visible = $('#visible_code').val()
        var sort_by = $('#sort_table_code').val()
        var order_sort = $('#order_table_code').val()
        var key_search = $('#search_word').val()
        if (key_search=='') {
            key_search = null
        }
        sortPagination(key_search,sort_by,order_sort,visible,pageno);
    });

    $("#search_word").keyup(function(){
        var strval =  $("#search_word").val();
        var visible = $('#visible_code').val()
        var sort_by = $('#sort_table_code').val()
        var order_sort = $('#order_table_code').val()
        var norow = 0;
        if(strval == "")
        {
            sortPagination(null,sort_by,order_sort,visible,0);
        } 
        else
        {
            sortPagination(strval,sort_by,order_sort,visible,0)
        }
    });

    $("#search_word2").keyup(function(){
        var strval =  $("#search_word2").val();
        var visible = $('#visible_code').val()
        var sort_by = $('#sort_table_code').val()
        var order_sort = $('#order_table_code').val()
        var norow = 0;
        if(strval == "")
        {
            sortPagination(null,sort_by,order_sort,visible,0);
        } 
        else
        {
            sortPagination(strval,sort_by,order_sort,visible,0)
        }
    });

    function sortPagination(key_search,sort_by,order_sort,visible,pagno){
        var sort_by_name = 'keyword_name'
        var statustable = $('#visible_code').val()
        $.ajax({
            url: '<?=base_url()?>movies/list_movie_code/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+pagno,
            type: 'get',
            dataType: 'json',
            success: function(response){
                var order_sort = response.order;
                var x = response.x;
                var y = response.y;
                var z = response.z;
                var show = 'Showing '+x+' to '+y+' of '+z+' entries';
                $('#data-table_info').html(show);
                if (statustable=='Y') {
                    $('#data-table_info').html(show);
                } else {
                    $('#data-table_info2').html(show);
                }
                if (response.pagination=="")
                {
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
                        $('#pagination').html(page1);
                    } else {
                        $('#pagination2').html(page1);
                    }
                }
                else
                {
                    var pageee = response.pagination
                    if (statustable=='Y') {
                        $('#pagination').html(response.pagination);
                    } else {
                        $('#pagination2').html(response.pagination);
                    }
                }
                createTable(response.result,response.row);
            }
        });
    }

    function createTable(result,sno){
        var statustable = $('#visible_code').val()
        if (statustable=='Y') {
            $('#mytable1 tbody').empty();
        } else {
            $('#mytable2 tbody').empty();
        }

        if (result.length > 0)
        {
            sno = Number(sno);
            for(index in result){
                var id = result[index].code_id;
                var code_init = result[index].code_init;
                var code_remark = result[index].code_remark;
                sno+=1;
                var base_url ='<?php echo base_url()?>'
                if (result[index].code_visible=="N") {
                    var html = '<a onclick="activeConfirm(\''+id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate</a>'
                } else {
                    var html = '<a onclick="inactiveConfirm(\''+id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate</a>'
                }

                var tr = "<tr>";
                tr += "<td>"+ sno +"</td>";
                tr += "<td>"+ id +"</td>";
                tr += "<td>"+ code_init +"</td>";
                tr += "<td>"+ code_remark +"</td>";
                tr += "<td><div class='dropdown'><button class='btn btn-light dropdown-toggle' data-toggle='dropdown'>ACTION</button><div class='dropdown-menu dropdown-menu--icon'>"+ html +"<a href='#!' onclick='edit_code(\""+id+"\")' class='dropdown-item'><i class='zmdi zmdi-edit zmdi-hc-fw'></i>Edit</a></div></div></td>";
                tr += "</tr>";
                if (statustable=='Y') {
                    $('#mytable1 tbody').append(tr);
                } else {
                    $('#mytable2 tbody').append(tr);
                }
            }
        }
        else
        {
            var tr = `<tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable=='Y') {
                $('#mytable1 tbody').append(tr);
            } else {
                $('#mytable2 tbody').append(tr);
            }
        }
    }

    $(document).on("click","#code",(function(e){
        e.preventDefault();
        $('#insert_code').css('display', 'block')
        $('.nav-tabs a[href="#tab_add_code"]').tab('show');
        var contentid = $('#contentid').val()
        
        var html = `<form action="#" method="post" id="form_code" autocomplete="off">
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
        $('#tab_add_code').html(html);
    }))

    $("#insert_code").click(function(){
        var self = $('#form_code');
        var initialcode_res = $(self).find('#initial_code').val();
        var remark_res = $(self).find('#remark').val();
        if (initialcode_res == '') {
            $('#code_val').text('* Please input your initial code');
            $('#code_val').show()
        } else {
            $("#code_val").hide();
        }
        if (remark_res == '') {
            $('#remark_val').text('* Please input your remark');
            $('#remark_val').show()
        } else {
            $("#remark_val").hide();
        }

        if (initialcode_res!='' && remark_res!='') {
            $('#insert_code').text('Submit...'); //change button text
            $('#insert_code').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('movies/insert_code')?>",
                type: "POST",
                data: $('#form_code').serialize(),
                dataType: "JSON",
                success: function(data)
                {
                    if(data.error==='0')
                    {
                        alert(data.message);
                        $('#insert_code').text('Submit'); //change button text
                        $('#insert_code').attr('disabled',false); //set button enable
                        $(".menulist").trigger('click');
                    }else{
                        $('#insert_code').text('Submit'); //change button text
                        $('#insert_code').attr('disabled',false); //set button enable
                        alert(data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Data gagal disimpan, silahkan isi category!');
                    $('#insert_code').text('Submit'); //change button text
                    $('#insert_code').attr('disabled',false); //set button enable 
                }
            });
        }
    });

    function edit_code(id) {
        var html = `<form action="#" method="post" id="form_code_edit" autocomplete="off">
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
        $('#changing-edit').html(html);

        $.ajax({
            url : "<?php echo site_url('movies/get_data_edit_code');?>",
            method : "POST",
            data :{id:id},
            async : true,
            dataType : 'json',
            success : function(data){
                var val_init = data[0]['code_init']
                var val_remark = data[0]['code_remark']
                $('#form_code_edit [name="initial_code"]').val(val_init).trigger('change');
                $('#form_code_edit [name="remark"]').val(val_remark).trigger('change');
            }
        });
        $('#modal-edit').modal('show');
    }

    $("#update_code").click(function(){
        var self = $('#form_code_edit');
        var initialcode_res = $(self).find('#initial_code').val();
        var remark_res = $(self).find('#remark').val();
        if (initialcode_res == ''){
            $('#code_val').text('* Please input your initial code');
            $('#code_val').show()
        } else {
            $("#code_val").hide();
        }
        if (remark_res == '') {
            $('#remark_val').text('* Please input your remark');
            $('#remark_val').show()
        } else {
            $("#remark_val").hide();
        }

        if (initialcode_res!='' && remark_res!='') {
            $('#update_code').text('Submit...'); //change button text
            $('#update_code').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('movies/update_code')?>",
                type: "POST",
                data: $('#form_code_edit').serialize(),
                dataType: "JSON",
                success: function(data)
                {
                    if(data.error==='0')
                    {
                        alert(data.message);
                        $('#update_code').text('Submit'); //change button text
                        $('#update_code').attr('disabled',false); //set button enable
                        $('#modal-edit').modal('hide');
                        $(".menulist").trigger('click');
                    }else{
                        $('#update_code').text('Submit'); //change button text
                        $('#update_code').attr('disabled',false); //set button enable
                        alert(data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Data gagal disimpan, silahkan isi category!');
                    $('#update_code').text('Submit'); //change button text
                    $('#update_code').attr('disabled',false); //set button enable 
                }
            });
        }
    });

    function activeConfirm(id) {
        $.ajax({
            url: '<?=base_url()?>movies/activate_code',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                console.log(response.error)
                if (response.error==='0') {
                    $(".menulist").trigger('click');
                }
            }
        });
    }

    function inactiveConfirm(id) {
        $.ajax({
            url: '<?=base_url()?>movies/inactivate_code',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                console.log(response.error)
                if (response.error==='0') {
                    $(".menulist").trigger('click');
                }
            }
        });
    }
    // management code

    // management keyword
    $("#keyword").click(function(){
        $(".tab_keyword_active").trigger('click');
    });

    $(".tab_keyword_active").click(function(){
        $('#mytablekeyword1 tbody').empty();
        $('#visible_keyword').val('Y')
        var visible = $('#visible_keyword').val()
        var sort_by = $('#sort_table_keyword').val()
        var order_sort = $('#order_table_keyword').val()
        var contentKey = $('#select_keyword_active').val()
        var rowperpage = $('#rowselect').val()
        loadPagination(null,sort_by,order_sort,visible,contentKey,rowperpage,0);
        $("#tab_keyword_inactive").hide();
        $("#tab_keyword_active").show();
    });

    $(".tab_keyword_inactive").click(function(){
        $('#mytablekeyword2 tbody').empty();
        $('#visible_keyword').val('N')
        var visible = $('#visible_keyword').val()
        var sort_by = $('#sort_table_keyword').val()
        var order_sort = $('#order_table_keyword').val()
        var contentKey = $('#select_keyword_active').val()
        var rowperpage = 10
        loadPagination(null,sort_by,order_sort,visible,contentKey,rowperpage,0);
        $("#tab_keyword_active").hide();
        $("#tab_keyword_inactive").show();
    });

    $(document).on("change","#rowselect",function (e) {
        var checkpage = $('.pagination .active span').text()
        var pageno = parseInt(checkpage.replace('(current)(current)',''))
        $('#visible_keyword').val('Y')
        var visible = $('#visible_keyword').val()
        var sort_by = $('#sort_table_keyword').val()
        var order_sort = $('#order_table_keyword').val()
        var contentKey = $('#select_keyword_active').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = $('#rowselect').val()
        loadPagination(key_search,sort_by,order_sort,visible,contentKey,rowperpage,pageno);
    });

    $('#select_keyword_active').on('select2:select', function (e) {
        var visible = $('#visible_keyword').val()
        var sort_by = $('#sort_table_keyword').val()
        var order_sort = $('#order_table_keyword').val()
        var contentKey = $('#select_keyword_active').val()
        var rowperpage = $('#rowselect').val()
        loadPagination(null,sort_by,order_sort,visible,contentKey,rowperpage,0);
    })

    $('#select_keyword_inactive').on('select2:select', function (e) {
        var visible = $('#visible_keyword').val()
        var sort_by = $('#sort_table_keyword').val()
        var order_sort = $('#order_table_keyword').val()
        var contentKey = $('#select_keyword_inactive').val()
        var rowperpage = 10
        loadPagination(null,sort_by,order_sort,visible,contentKey,rowperpage,0);
    })

    $('#pagination_keyword').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var visible = $('#visible_keyword').val()
        var sort_by = $('#sort_table_keyword').val()
        var order_sort = $('#order_table_keyword').val()
        var contentKey = $('#select_keyword_inactive').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = $('#rowselect').val()
        loadPagination(key_search,sort_by,order_sort,visible,contentKey,rowperpage,pageno);
    });

    $('#pagination_keyword2').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var visible = $('#visible_keyword').val()
        var sort_by = $('#sort_table_keyword').val()
        var order_sort = $('#order_table_keyword').val()
        var contentKey = $('#select_keyword_inactive').val()
        var key_search = $('#searchinputinactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = 10
        loadPagination(key_search,sort_by,order_sort,visible,contentKey,rowperpage,pageno);
    });

    $("#searchbuttonactive").click(function(){
        var search =  $("#searchinputactive").val();
        var length = search.length
        if (length < 3) {
            $("#wardingsearchactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchactive').css("display", "none");
            }, 5000)
        } else {
            var visible = $('#visible_keyword').val()
            var sort_by = $('#sort_table_keyword').val()
            var order_sort = $('#order_table_keyword').val()
            var contentKey = $('#select_keyword_active').val()
            var rowperpage = $('#rowselect').val()
            loadPagination(search,sort_by,order_sort,visible,contentKey,rowperpage,0)
        }
    });

    $("#searchbuttoninactive").click(function(){
        var search =  $("#searchinputinactive").val();
        var length = search.length
        if (length < 3) {
            $("#wardingsearchinactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchinactive').css("display", "none");
            }, 5000)
        } else {
            var visible = $('#visible_keyword').val()
            var sort_by = $('#sort_table_keyword').val()
            var order_sort = $('#order_table_keyword').val()
            var contentKey = $('#select_keyword_inactive').val()
            var rowperpage = $('#rowselect').val()
            loadPagination(search,sort_by,order_sort,visible,contentKey,rowperpage,0)
        }
    });

    $('.tableactive').sortable({
        placeholder : "ui-state-highlight",
        update : function(event, ui)
        {
            var page_id_array = new Array();
            $('tbody tr').each(function(){
                page_id_array.push($(this).attr('id'));
            });

            $.ajax({
                url:"<?=base_url()?>movies/update_sort",
                method:"POST",
                data:{page_id_array:page_id_array, action:'update'},
                success:function()
                {
                    $(".tab_keyword_active").trigger('click');
                }
            })
        }
    });

    $('#rowselect').select2({
        minimumResultsForSearch: Infinity,
        width: '100%',
        dropdownParent: $('#modal-keyword')
    })

    $('#select_keyword_active').select2({
        minimumResultsForSearch: Infinity,
        width: '50%',
        dropdownParent: $('#modal-keyword')
    })

    $('#select_keyword_inactive').select2({
        minimumResultsForSearch: Infinity,
        width: '50%',
        dropdownParent: $('#modal-keyword')
    })

    function loadPagination(key_search,sort_by,order_sort,visible,contentKey,rowperpage,pagno){
        var statustable = $('#visible_keyword').val()
        $.ajax({
            url: '<?=base_url()?>movies/list_movie_keyword/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+contentKey+'/'+rowperpage+'/'+pagno,
            type: 'get',
            dataType: 'json',
            success: function(response){
                var order_sort = response.order;
                var x = response.x;
                var y = response.y;
                var z = response.z;
                var show = 'Showing '+x+' to '+y+' of '+z+' entries';
                $('#data-table_keyword').html(show);
                if (statustable=='Y') {
                    $('#data-table_keyword').html(show);
                } else {
                    $('#data-table_keyword2').html(show);
                }
                if (response.pagination=="")
                {
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
                        $('#pagination_keyword').html(page1);
                    } else {
                        $('#pagination_keyword2').html(page1);
                    }
                }
                else
                {
                    var pageee = response.pagination
                    if (statustable=='Y') {
                        $('#pagination_keyword').html(response.pagination);
                    } else {
                        $('#pagination_keyword2').html(response.pagination);
                    }
                }
                createTableKeyword(response.result,response.row,contentKey);
            }
        });
    }

    function createTableKeyword(result,sno,contentKey){
        var statustable = $('#visible_keyword').val()
        if (statustable=='Y') {
            $('#mytablekeyword1 tbody').empty();
            var contentKey = $('#select_keyword_active').val()
            if (contentKey == 'STD') {
                $("#mytablekeyword1 tbody").css("cursor", "all-scroll");
            } else {
                $("#mytablekeyword1 tbody").css("cursor", "default");
            }
        } else {
            $('#mytablekeyword2 tbody').empty();
        }

        if (result.length > 0)
        {
            sno = Number(sno);
            for(index in result){
                var id = result[index].keyword_id;
                var title = result[index].keyword_name;
                if (contentKey=='SUBGEN') {
                    var genreName = result[index].genre_name
                    title = title + " ("+genreName+")"
                }
                sno+=1;
                var base_url ='<?php echo base_url()?>'
                if (result[index].keyword_visible=="N") {
                    var html = '<a onclick="activeKeywordConfirm(\''+id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate</a>'
                } else {
                    var html = '<a onclick="inactiveKeywordConfirm(\''+id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate</a>'
                }

                var tr = "<tr id='"+id+"'>";
                tr += "<td>"+ sno +"</td>";
                tr += "<td>"+ title +"</td>";
                tr += "<td><div class='dropdown'><button class='btn btn-light dropdown-toggle' data-toggle='dropdown'>ACTION</button><div class='dropdown-menu dropdown-menu--icon'>"+ html +"<a href='#!' onclick='edit_keyword(\""+id+"\")' class='dropdown-item'><i class='zmdi zmdi-edit zmdi-hc-fw'></i>Edit</a></div></div></td>";
                tr += "</tr>";
                if (statustable=='Y') {
                    $('#mytablekeyword1 tbody').append(tr);
                } else {
                    $('#mytablekeyword2 tbody').append(tr);
                }
            }
        }
        else
        {
            var tr = `<tr class="odd"><td valign="top" colspan="3" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable=='Y') {
                $('#mytablekeyword1 tbody').append(tr);
            } else {
                $('#mytablekeyword2 tbody').append(tr);
            }
        }
    }

    $(document).on("click","#add_keyword",(function(e){
        e.preventDefault();
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
        $('#changing-keyword').html(html);

        $('#keyword_child').select2({
            minimumResultsForSearch: Infinity,
            width: '100%',
            dropdownParent: $('#modal-keyword-cu')
        })

        $('#keyword_ref').select2({
            minimumResultsForSearch: Infinity,
            width: '100%',
            dropdownParent: $('#modal-keyword-cu')
        })

        $('#keyword_ref').on('select2:select', function (e) {
            var ref = $('#keyword_ref').val()
            if (ref=='SUBGEN')
            {
                $('#genreforsubgenre').css('display', 'block')
                $('#genre_id').select2({
                    ajax: {
                        url: '<?= base_url() ?>movies/get_list_genre',
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                searchTerm: params.term,
                                page: params.page,
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.items.map(function(item) {
                                    return {
                                        id: item.keyword_id,
                                        text: item.keyword_name.trim()
                                    };
                                }),
                                pagination: {
                                    more: (params.page * 10) < data.total_count
                                }

                            };
                        },
                        cache: true
                    },
                    placeholder: "Select genre",
                    minimumResultsForSearch: Infinity,
                    width: '100%',
                    dropdownParent: $('#modal-keyword-cu'),
                    templateResult: format,
                    templateSelection: formatSelection
                })
            }
            else
            {
                $('#genreforsubgenre').css('display', 'none')
                $('#genre_id').val(null).trigger('change');
            }
        })

        $('#modal-keyword-cu').modal('show');
    }))

    $("#crud_keyword").click(function(){
        var self = $('#form_crud_keyword');
        var keyname_res = $(self).find('#keyword_name').val();
        var keychild_res = $(self).find('#keyword_child').val();
        var keyref_res = $(self).find('#keyword_ref').val();
        var genid_res = $(self).find('#genre_id').val();
        if (keyname_res == '' || keyname_res == null) {
            $('#keyname_val').text('* Please input name');
            $('#keyname_val').show()
        } else {
            $("#keyname_val").hide();
        }
        if (keychild_res == '' || keychild_res == null) {
            $('#child_val').text('* Please select child');
            $('#child_val').show()
        } else {
            $("#child_val").hide();
        }
        if (keyref_res == '' || keyref_res == null) {
            $('#ref_val').text('* Please select ref');
            $('#ref_val').show()
        } else {
            $("#ref_val").hide();
        }
        if (keyref_res=='SUBGEN') {
            if (genid_res == '' || genid_res == null) {
                $('#genre_val').text('* Please select genre');
                return $('#genre_val').show()
            } else {
                $("#genre_val").hide();
            }
        }

        if (keyname_res!='' && keychild_res!='' && keyref_res!='') {
            $('#crud_keyword').text('Submit...'); //change button text
            $('#crud_keyword').attr('disabled',true); //set button disable
            // ajax adding data to database
            $.ajax({
                url : "<?php echo site_url('movies/cu_keyword')?>",
                type: "POST",
                data: $('#form_crud_keyword').serialize(),
                dataType: "JSON",
                success: function(data)
                {
                    if(data.error==='0')
                    {
                        alert(data.message);
                        $('#crud_keyword').text('Submit');
                        $('#crud_keyword').attr('disabled',false);
                        $('#modal-keyword-cu').modal('hide');
                        $(".tab_keyword_active").trigger('click');
                    }else{
                        $('#crud_keyword').text('Submit');
                        $('#crud_keyword').attr('disabled',false);
                        alert(data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Data gagal disimpan, silahkan isi category!');
                    $('#crud_keyword').text('Submit');
                    $('#crud_keyword').attr('disabled',false);
                }
            });
        }
    });

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
        $('#changing-keyword').html(html);

        $('#keyword_child').select2({
            minimumResultsForSearch: Infinity,
            width: '100%',
            dropdownParent: $('#modal-keyword-cu')
        })

        $('#keyword_ref').select2({
            minimumResultsForSearch: Infinity,
            width: '100%',
            dropdownParent: $('#modal-keyword-cu')
        })

        $('#keyword_ref').on('select2:select', function (e) {
            var ref = $('#keyword_ref').val()
            if (ref=='SUBGEN')
            {
                $('#genreforsubgenre').css('display', 'block')
                $('#genre_id').select2({
                    ajax: {
                        url: '<?= base_url() ?>movies/get_list_genre',
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                searchTerm: params.term,
                                page: params.page,
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.items.map(function(item) {
                                    return {
                                        id: item.keyword_id,
                                        text: item.keyword_name.trim()
                                    };
                                }),
                                pagination: {
                                    more: (params.page * 10) < data.total_count
                                }

                            };
                        },
                        cache: true
                    },
                    placeholder: "Select genre",
                    minimumResultsForSearch: Infinity,
                    width: '100%',
                    dropdownParent: $('#modal-keyword-cu'),
                    templateResult: format,
                    templateSelection: formatSelection
                })
            }
            else
            {
                $('#genreforsubgenre').css('display', 'none')
                $('#genre_id').val(null).trigger('change');
            }
        })

        $.ajax({
            url : "<?php echo site_url('movies/get_data_edit_keyword');?>",
            method : "POST",
            data :{id:id},
            async : true,
            dataType : 'json',
            success : function(data){
                var val_name = data[0]['keyword_name']
                var val_child = data[0]['keyword_child']
                var val_ref = data[0]['keyword_ref']
                var val_genreid = data[0]['keyword_parentid']
                $('#form_crud_keyword [name="keyword_name"]').val(val_name).trigger('change');
                $('#form_crud_keyword [name="keyword_child"]').val(val_child).trigger('change');
                $('#form_crud_keyword [name="keyword_ref"]').val(val_ref).trigger('change');
                if (val_ref=='GEN') {
                    if (val_genreid!='' || val_genreid!=null) {
                        $('#genreforsubgenre').css('display', 'block')
                        $('#form_crud_keyword [name="keyword_ref"]').val('SUBGEN').trigger('change');
                        $('#genre_id').select2({
                            ajax: {
                                url: '<?= base_url() ?>movies/get_list_genre',
                                type: "post",
                                dataType: 'json',
                                delay: 250,
                                data: function (params) {
                                    return {
                                        searchTerm: params.term,
                                        page: params.page,
                                    };
                                },
                                processResults: function (data, params) {
                                    params.page = params.page || 1;
                                    return {
                                        results: data.items.map(function(item) {
                                            return {
                                                id: item.keyword_id,
                                                text: item.keyword_name.trim()
                                            };
                                        }),
                                        pagination: {
                                            more: (params.page * 10) < data.total_count
                                        }

                                    };
                                },
                                cache: true
                            },
                            placeholder: "Select genre",
                            minimumResultsForSearch: Infinity,
                            width: '100%',
                            dropdownParent: $('#modal-keyword-cu'),
                            templateResult: format,
                            templateSelection: formatSelection
                        })
                        var id_parent = data[0]['id_parent']
                        var name_parent = data[0]['name_parent']
                        var str='';
                        str+='<option value = "'+id_parent+'" selected >'+name_parent+'</option>';
                        $("#genre_id").append(str);
                    }
                }
            }
        });
        $('#modal-keyword-cu').modal('show');
    }
    // management keyword

    var selectedMovieCode = <?= json_encode($selected_movie_code ?? '') ?>;
    var selectedMovieParent = <?= json_encode($selected_movie_parent ?? '') ?>;
    var selectedMovieParentID = <?= json_encode($selected_movie_parent_id ?? '') ?>;
</script>