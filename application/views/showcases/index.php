<style type="text/css">
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    .page-link a {color: white;}
    .page-link {width: 35px; height: 35px;}
    #searchinputactive, #searchinputinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonactive, #searchbuttoninactive { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow_active, #selectrow_inactive { float: left; width: 7%; padding: 3.8px; color: white; font-size: 14px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    #mytable1 .more-content, #mytable2 .more-content {display: none;}
    #mytable1 .read-more, #mytable2 .read-more {cursor: pointer; color: rgba(255, 255, 255, .7); padding: 0;}
    #mytable1 .descdiv, #mytable2 .descdiv {white-space: pre-wrap; text-align: justify; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Showcase</h1>
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
                <?php if (has_permission('create_showcases')): ?>
                    <a href="<?= base_url('showcases/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Showcase</a>
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
                            <input type="hidden" name="sort_table" id="sort_table" value="id">
                            <input type="hidden" name="order_table" id="order_table" value="desc">
                            <input type="hidden" name="visible" id="visible" value="Y">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Category</label><br>
                                    <select class="form-control" name="category_showcaseactive" id="category_showcaseactive" required>
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
                                            <th>Category</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status Visible</th>
                                            <th>Status Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableactive" style="cursor: all-scroll;">
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
                                    <select class="form-control" name="category_showcaseinactive" id="category_showcaseinactive" required>
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
                                            <th>Category</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status Visible</th>
                                            <th>Status Active</th>
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

<!-- Active/Inactive && Visible/Unvisible Confirmation-->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left"></h5>
            </div>
            <div class="modal-body">
                <h5 class="modal-title text-center" id="exampleModalLabel">Are you sure?</h5>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <a id="btn-status" class="btn btn-link" href="#">Yes</a>
                <button class="btn btn-link" type="button" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#category_showcaseactive').select2({
            ajax: {
                url: '<?= base_url() ?>showcases/category_showcase',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term || '', // kosong agar ambil semua
                        page: params.page || 1
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
            placeholder: "Select a category",
            width: '100%',
            templateResult: format,
            templateSelection: formatSelection
        });

        $.ajax({
            url: '<?= base_url() ?>showcases/category_showcase',
            type: 'POST',
            dataType: 'json',
            data: {
                searchTerm: '',
                page: 1
            },
            success: function (data) {
                if (data.items && data.items.length > 0) {
                    const firstItem = data.items[0];
                    const option = new Option(firstItem.text, firstItem.id, true, true);
                    $('#category_showcaseactive').append(option).trigger('change');
                    activaTab('tab1');
                }
            }
        });

        $('#category_showcaseinactive').select2({
            ajax: {
                url: '<?= base_url() ?>showcases/category_showcase',
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
            placeholder: "Select a showcase category",
            width: '100%',
            templateResult: format,
            templateSelection: formatSelection
        })

        $('#rowselect_active').select2()

        $('#rowselect_inactive').select2()
    })

    function activaTab(tab) {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_showcaseactive').val()
        if (category=='') {
            category = null
        }
        $('#rowselect_active').select2()
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
    };

    $("#tab_1").click(function() {
        $.ajax({
            url: '<?= base_url() ?>showcases/category_showcase',
            type: 'POST',
            dataType: 'json',
            data: {
                searchTerm: '',
                page: 1
            },
            success: function (data) {
                if (data.items && data.items.length > 0) {
                    const firstItem = data.items[0];
                    const option = new Option(firstItem.text, firstItem.id, true, true);
                    $('#category_showcaseactive').append(option).trigger('change');
                    var sort_by = $('#sort_table').val()
                    var order_sort = $('#order_table').val()
                    $('#visible').val('Y')
                    var visible = $('#visible').val()
                    $('#searchinputactive').val(null)
                    var key_search = null
                    var category = $('#category_showcaseactive').val()
                    if (category=='') {
                        category = null
                    }
                    $('#rowselect_active').val(10).trigger('change');
                    var rowperpage = $('#rowselect_active').val()
                    loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
                    $("#tab2").hide();
                    $("#tab1").show();
                }
            }
        });
    });

    $("#tab_2").click(function() {
        $.ajax({
            url: '<?= base_url() ?>showcases/category_showcase',
            type: 'POST',
            dataType: 'json',
            data: {
                searchTerm: '',
                page: 1
            },
            success: function (data) {
                if (data.items && data.items.length > 0) {
                    const firstItem = data.items[0];
                    const option = new Option(firstItem.text, firstItem.id, true, true);
                    $('#category_showcaseinactive').append(option).trigger('change');
                    var sort_by = $('#sort_table').val()
                    var order_sort = $('#order_table').val()
                    $('#visible').val('N')
                    var visible = $('#visible').val()
                    $('#searchinputinactive').val(null)
                    var key_search = null
                    var category = $('#category_showcaseinactive').val()
                    if (category=='') {
                        category = null
                    }
                    $('#rowselect_inactive').val(10).trigger('change');
                    var rowperpage = $('#rowselect_inactive').val()
                    loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
                    $("#tab1").hide();
                    $("#tab2").show();
                }
            }
        });
    });

    $('#category_showcaseactive').on('select2:select', function (e) {
        var visible = $('#visible').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_showcaseactive').val()
        if (category=='') {
            category = null
        }
        $('#rowselect_active').val(10).trigger('change');
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
    })

    $('#category_showcaseinactive').on('select2:select', function (e) {
        var visible = $('#visible').val()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_showcaseinactive').val()
        if (category=='') {
            category = null
        }
        $('#rowselect_inactive').val(10).trigger('change');
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,0);
    })

    $(document).on("change","#rowselect_active",function (e) {
        var pageno = 0
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_showcaseactive').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
    });

    $(document).on("change","#rowselect_inactive",function (e) {
        var pageno = 0
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputinactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_showcaseinactive').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
    });

    $("#searchbuttonactive").click(function() {
        var search =  $("#searchinputactive").val();
        var length = search.length
        if (length < 3) {
            $("#wardingsearchactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchactive').css("display", "none");
            }, 5000)
        } else {
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var visible = $('#visible').val()
            var category = $('#category_showcaseactive').val()
            if (category=='') {
                category = null
            }
            var rowperpage = $('#rowselect_active').val()
            loadPagination(search,sort_by,order_sort,visible,category,rowperpage,0);
        }
    });

    $('#pagination').on('click','a',function(e) {
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_showcaseactive').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
    });

    $('#pagination').on('click','.page-link',function(e) {
        e.preventDefault(); 
        var pageno = e.currentTarget.firstElementChild.attributes[1].nodeValue
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_showcaseactive').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
    });

    $("#searchbuttonacinactive").click(function() {
        var search =  $("#searchinputinactive").val();
        var length = search.length
        if (length < 3) {
            $("#wardingsearchinactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchinactive').css("display", "none");
            }, 5000)
        } else {
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var visible = $('#visible').val()
            var category = $('#category_showcaseinactive').val()
            if (category=='') {
                category = null
            }
            var rowperpage = $('#rowselect_inactive').val()
            loadPagination(search,sort_by,order_sort,visible,category,rowperpage,0);
        }
    });

    $('#pagination2').on('click','a',function(e) {
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_showcaseinactive').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
    });

    $('#pagination2').on('click','.page-link',function(e) {
        e.preventDefault(); 
        var pageno = e.currentTarget.firstElementChild.attributes[1].nodeValue
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var visible = $('#visible').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_showcaseinactive').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_inactive').val()
        loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno);
    });

    $('.tableactive').sortable({
        placeholder: "ui-state-highlight",
        update: function(event, ui) {
            var page_id_array = new Array();
            $('tbody tr').each(function(){
                page_id_array.push($(this).attr('id'));
            });
            $.ajax({
                url: "<?=base_url()?>showcases/update_sort",
                method: "POST",
                data: {page_id_array:page_id_array, action:'update'},
                success: function() {
                    location.reload();
                }
            })
        }
    });

    function loadPagination(key_search,sort_by,order_sort,visible,category,rowperpage,pageno) {
        $.ajax({
            url: '<?=base_url()?>showcases/list_showcases/'+key_search+'/'+sort_by+'/'+order_sort+'/'+visible+'/'+category+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function(response){
                var order_sort = response.order;
                var x = response.x;
                var y = response.y;
                var z = response.z;
                var show = 'Showing '+x+' to '+y+' of '+z+' entries';
                $('#data-table_info').html(show);
                if (visible=='Y') {
                    $('#data-table_info').html(show);
                } else {
                    $('#data-table_info2').html(show);
                }
                if (response.pagination=="") {
                    var page1 = `<div class="pagging text-center">
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item active">
                                                <span class="page-link">1<span class="sr-only">(current)</span></span>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>`
                    if (visible=='Y') {
                        $('#pagination').html(page1);
                    } else {
                        $('#pagination2').html(page1);
                    }
                } else {
                    if (visible=='Y') {
                        $('#pagination').html(response.pagination);
                    } else {
                        $('#pagination2').html(response.pagination);
                    }
                }
                createTable(response.result,response.row);
            }
        });
    }

    function createTable(result,sno) {
        var statustable = $('#visible').val()
        if (statustable=='Y') {
            $('#mytable1 tbody').empty();
        } else {
            $('#mytable2 tbody').empty();
        }
        if (result.length > 0) {
            sno = Number(sno);
            for(index in result){
                var id = result[index].id;
                var title = result[index].title;
                var category_name = result[index].category_name;
                var poster_url = result[index].poster_url;
                var sort = result[index].sort;
                var start_date = result[index].start_date;
                var end_date = result[index].end_date;
                var visible = result[index].visible;
                var active = result[index].active;
                var htmlimage = '<img id="myImg" src="' + poster_url + '" alt="" width="80" height="80">'
                sno+=1;
                var base_url ='<?php echo base_url()?>'
                var activeinactive = ""
                if (visible==="N") {
                    var visible_status = "<button type='button' class='btn btn-outline-danger' disabled>Unvisible</button>"
                    activeinactive = "<a onclick='statusConfirm(\""+base_url+'showcases/visible_showcase/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-plus-circle zmdi-hc-fw'></i>Visible</a>";
                } else {
                    var visible_status = "<button type='button' class='btn btn-outline-success' disabled>Visible</button>"
                    activeinactive = "<a onclick='statusConfirm(\""+base_url+'showcases/unvisible_showcase/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-minus-circle zmdi-hc-fw'></i>Unvisible</a>";
                }
                if (active==="N") {
                    var active_status = "<button type='button' class='btn btn-outline-danger' disabled>Inactive</button>"
                    activeinactivestatus = "<a onclick='statusConfirm(\""+base_url+'showcases/activated/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-plus-circle zmdi-hc-fw'></i>Activate</a>";
                } else {
                    var active_status = "<button type='button' class='btn btn-outline-success' disabled>Active</button>"
                    activeinactivestatus = "<a onclick='statusConfirm(\""+base_url+'showcases/inactivated/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-minus-circle zmdi-hc-fw'></i>Deactivate</a>";
                }
                var tr = "<tr id='"+id+"'>";
                tr += "<td>"+ sno +"</td>";
                tr += "<td>"+ category_name +"</td>";
                tr += "<td>"+ htmlimage +"</td>";
                tr += "<td>"+ title +"</td>";
                tr += "<td>"+ start_date +"</td>";
                tr += "<td>"+ end_date +"</td>";
                tr += "<td>"+ visible_status +"</td>";
                tr += "<td>"+ active_status +"</td>";
                tr += `<td>
                            <div class='dropdown'>
                                <button class='btn btn-light' data-toggle='dropdown' aria-expanded='false'>ACTION</button>
                                <div class='dropdown-menu dropdown-menu--icon'>
                                <?php if (has_permission('edit_showcases')): ?>
                                    <a href="<?= base_url('showcases/edit/${id}') ?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                <?php endif; ?>
                                <?php if (has_permission('delete_showcases')): ?>
                                    ${activeinactive}
                                    ${activeinactivestatus}
                                <?php endif; ?>
                                </div>
                            </div>
                        </td>`
                tr += "</tr>";
                if (statustable=='Y') {
                    $('#mytable1 tbody').append(tr);
                } else {
                    $('#mytable2 tbody').append(tr);
                }
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="10" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable=='Y') {
                $('#mytable1 tbody').append(tr);
            } else {
                $('#mytable2 tbody').append(tr);
            }
        }
    }

    function statusConfirm(url) {
        $('#btn-status').attr('href', url);
        $('#statusModal').modal();
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
</script>