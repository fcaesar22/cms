<style type="text/css">
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    .page-link a {color: white;}
    #searchinputactive, #searchinputinactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonactive, #searchbuttoninactive { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow_active, #selectrow_inactive { float: left; width: 7%; padding: 3.8px; color: white; font-size: 14px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
    .modal-footer {justify-content: center;}
    .loadingTable {width: 100%; height: 100%; position: fixed; align-items: center; justify-content: center; background-color: transparent;}
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Highlight</h1>
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
                <?php if (has_permission('create_highlights')): ?>
                    <a href="<?= base_url('highlights/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Highlight</a>
                <?php endif; ?>
                <input type="hidden" name="sort_table" id="sort_table" value="covers_id">
                <input type="hidden" name="order_table" id="order_table" value="desc">
                <h6 class="card-title" align="center">List Highlight</h6>
                <label>Category</label><br>
                <select class="form-control col-md-6" name="category_content" id="category_content">
                    <option></option>
                </select>
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
                                <th>Title</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <div class="page-loader loadingTable">
                        <div class="page-loader__spinner">
                            <svg viewBox="25 25 50 50">
                                <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                            </svg>
                        </div>
                    </div>
                    <div class="dataTables_info" id="data-table_info" role="status" aria-live="polite"></div>
                    <div style='margin-top: 10px;' id='pagination'></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        activaTab()

        $('#category_content').select2({
            ajax: {
                url: '<?= base_url() ?>highlights/get_list_content',
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
            placeholder: "Select a category",
            templateResult: format,
            templateSelection: formatSelection
        })

        $('#rowselect_active').select2()

        $('#category_content').on('select2:select', function (e) {
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var key_search = $('#searchinputactive').val()
            if (key_search=='') {
                key_search = null
            }
            var category = $('#category_content').val()
            if (category=='') {
                category = null
            }
            skipRowChange = true;
            $('#rowselect_active').val(10).trigger('change');
            skipRowChange = false;
            var rowperpage = $('#rowselect_active').val()
            loadPagination(key_search,sort_by,order_sort,category,rowperpage,0);
        })
    })

    let skipRowChange = false;

    function activaTab(tab) {
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_content').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,category,rowperpage,0);
    };

    $(document).on("change","#rowselect_active",function (e) {
        if (skipRowChange) return;
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_content').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,category,rowperpage,0);
    });

    $("#searchbuttonactive").click(function() {
        var search =  $("#searchinputactive").val();
        var length = search.length
        if (length < 5) {
            $("#wardingsearchactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchactive').css("display", "none");
            }, 5000)
        } else {
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var category = $('#category_content').val()
            if (category=='') {
                category = null
            }
            skipRowChange = true;
            $('#rowselect_active').val(10).trigger('change');
            skipRowChange = false;
            var rowperpage = $('#rowselect_active').val()
            loadPagination(search,sort_by,order_sort,category,rowperpage,0);
        }
    });

    $('#pagination').on('click','a',function(e) {
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_content').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,category,rowperpage,pageno);
    });

    $('#pagination').on('click','.page-link',function(e) {
        e.preventDefault(); 
        var pageno = e.currentTarget.firstElementChild.attributes[1].nodeValue
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var category = $('#category_content').val()
        if (category=='') {
            category = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search,sort_by,order_sort,category,rowperpage,pageno);
    });

    function loadPagination(key_search,sort_by,order_sort,category,rowperpage,pageno) {
        $(".loadingTable").show();
        $.ajax({
            url: '<?=base_url()?>highlights/list_highlight/'+key_search+'/'+sort_by+'/'+order_sort+'/'+category+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var order_sort = response.order;
                var x = response.x;
                var y = response.y;
                var z = response.z;
                var show = 'Showing '+x+' to '+y+' of '+z+' entries';
                $('#data-table_info').html(show);
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
                    $('#pagination').html(page1);
                } else {
                    $('#pagination').html(response.pagination);
                }
                createTable(response.result,response.row);
                setTimeout(function(){$(".loadingTable").fadeOut()},500)
            }
        });
    }

    function createTable(result,sno) {
        $('#mytable1 tbody').empty();
        if (result.length > 0) {
            sno = Number(sno);
            for (index in result) {
                var id = result[index].covers_id;
                var title = result[index].id_goto;
                var categories = result[index].category_covers;
                var type = result[index].type_highlight;
                var image = result[index].poster_url;
                var start_date = result[index].start_date;
                var end_date = result[index].end_date;
                var htmlimage = '<img id="myImg" src="' + image + '" alt="" width="128" height="72">'
                sno+=1;
                var base_url ='<?php echo base_url()?>'
                var tr = "<tr id='"+id+"'>";
                tr += "<td>"+ sno +"</td>";
                tr += "<td>"+ htmlimage +"</td>";
                tr += "<td>"+ title +"</td>";
                tr += "<td>"+ categories +"</td>";
                tr += "<td>"+ type +"</td>";
                tr += "<td>"+ start_date +"</td>";
                tr += "<td>"+ end_date +"</td>";
                tr += `<td>
                            <div class='dropdown'>
                                <button class='btn btn-light' data-toggle='dropdown' aria-expanded='false'>ACTION</button>
                                <div class='dropdown-menu dropdown-menu--icon'>
                                <?php if (has_permission('edit_highlights')): ?>
                                    <a href="<?= base_url('highlights/edit/${id}') ?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                <?php endif; ?>
                                </div>
                            </div>
                        </td>`
                tr += "</tr>";
                $('#mytable1 tbody').append(tr);
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No matching records found</td></tr>`
            $('#mytable1 tbody').append(tr);
        }
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