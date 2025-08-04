<style type="text/css">
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    .page-link a {color: white;}
    #searchinputactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonactive { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow { float: left; width: 7%; padding: 3.8px; color: white; font-size: 14px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Menu Sidebar</h1>
        </header>
        <div class="card">
            <div class="card-body">                
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php if (has_permission('create_menus')): ?>
                    <a href="<?= base_url('menus/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Menu</a>
                <?php endif; ?>
                <br><br>
                <input type="hidden" name="sort_table" id="sort_table" value="id">
                <input type="hidden" name="order_table" id="order_table" value="asc">
                <span class="invalid-feedback" id="wardingsearchactive" name="wardingsearchactive" style="display:none;">minimum 5 charachters</span>
                <input type="search" placeholder="Search for title..." name="searchinputactive" id="searchinputactive" minlength="5" maxlength="50">
                <button type="button" name="searchbuttonactive" id="searchbuttonactive" class="btn btn-light"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                <button type="button" name="selectrow" id="selectrow" class="btn btn-light">
                    <select name="rowselect" id="rowselect" style="width: 100%;">
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
                                <th>Name</th>
                                <th>URL</th>
                                <th>Icon</th>
                                <th>Parent</th>
                                <th>Sort</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Delete Confirmation-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-confirmactive" class="btn btn-danger" href="#">Yes</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#rowselect').select2()
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = $('#rowselect').val()
        loadPagination(key_search,sort_by,order_sort,rowperpage,0);
    })

    $(document).on("change","#rowselect",function (e) {
        var checkpage = $('.pagination .active span').text()
        // var pageno = parseInt(checkpage.replace('(current)(current)',''))
        var pageno = 0        
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = $('#rowselect').val()
        loadPagination(key_search,sort_by,order_sort,rowperpage,pageno);
    });

    $("#searchbuttonactive").click(function(){
        var search =  $("#searchinputactive").val();
        var length = search.length
        if (length < 4) {
            $("#wardingsearchactive").css("display", "block");
            setTimeout(function () {
                $('#wardingsearchactive').css("display", "none");
            }, 5000)
        } else {
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var rowperpage = $('#rowselect').val()
            loadPagination(search,sort_by,order_sort,rowperpage,0);
        }
    });

    // Detect pagination click
    $('#pagination').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = $('#rowselect').val()
        loadPagination(key_search,sort_by,order_sort,rowperpage,pageno);
    });

    $('#pagination').on('click','.page-link',function(e){
        e.preventDefault(); 
        var pageno = e.currentTarget.firstElementChild.attributes[1].nodeValue
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var key_search = $('#searchinputactive').val()
        if (key_search=='') {
            key_search = null
        }
        var rowperpage = $('#rowselect').val()
        loadPagination(key_search,sort_by,order_sort,rowperpage,pageno);
    });

    function loadPagination(key_search,sort_by,order_sort,rowperpage,pageno){
        $.ajax({
            url: '<?=base_url()?>menus/list_menus/'+key_search+'/'+sort_by+'/'+order_sort+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function(response){
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
            }
        });
    }

    function createTable(result,sno){
        $('#mytable1 tbody').empty();

        if (result.length > 0)
        {
            sno = Number(sno);
            for(index in result){
                var id = result[index].id;
                var name = result[index].name;
                var url = result[index].url;
                var icon = result[index].icon;
                var parent_id = result[index].parent_id;
                var sort_order = result[index].sort_order;
                sno+=1;
                var base_url ='<?php echo base_url()?>'

                var tr = "<tr id='"+id+"'>";
                tr += "<td>"+ sno +"</td>";
                tr += "<td>"+ name +"</td>";
                tr += "<td>"+ url +"</td>";
                tr += "<td>"+ icon +"</td>";
                tr += "<td>"+ parent_id +"</td>";
                tr += "<td>"+ sort_order +"</td>";
                tr += `<td>
                            <?php if (has_permission('edit_menus')): ?>
                                <a href="<?= base_url('menus/set_permission_menu/${id}') ?>" class="btn btn-outline-info btn--icon-text"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Set Permission Menu</a>
                            <?php endif; ?>
                            <?php if (has_permission('edit_menus')): ?>
                                <a href="<?= base_url('menus/edit/${id}') ?>" class="btn btn-outline-warning btn--icon-text"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                            <?php endif; ?>
                            <?php if (has_permission('delete_menus')): ?>
                                <a href="#!" class="btn btn-outline-danger btn--icon-text" onclick="deleteConfirm('${base_url}menus/delete/${id}')"><i class="zmdi zmdi-delete zmdi-hc-fw"></i>Delete</a>
                            <?php endif; ?>
                        </td>`
                tr += "</tr>";
                $('#mytable1 tbody').append(tr);
            }
        }
        else
        {
            var tr = `<tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No matching records found</td></tr>`
            $('#mytable1 tbody').append(tr);
        }
    }

    function deleteConfirm(url){
        $('#btn-confirmactive').attr('href', url);
        $('#deleteModal').modal();
    }
</script>