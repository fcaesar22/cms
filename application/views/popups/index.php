<style type="text/css">
    td {text-align: center; vertical-align: middle !important;}
    .table thead>tr>th {text-align: center; vertical-align: middle;}
    .table td, .table th {padding: 1rem 1rem;}
    td {overflow-wrap: anywhere; white-space: normal;}
    .page-link a {color: white;}
    .page-link {width: 35px; height: 35px;}
    #searchinputactive {padding: 10px; font-size: 14px; border: 1px solid grey; float: left; width: 86%; color: white; background: transparent;}
    #searchbuttonactive { float: left; width: 7%; padding: 10px; color: white; font-size: 17px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    #selectrow_active { float: left; width: 7%; padding: 3.8px; color: white; font-size: 14px; border: 1px solid grey; border-left: none; cursor: pointer; margin-bottom: 10px;}
    ::placeholder {color: #8f9295; opacity: 1;} /* Firefox */
    :-ms-input-placeholder {color: #8f9295;} /* Internet Explorer 10-11 */
    ::-ms-input-placeholder {color: #8f9295;} /* Microsoft Edge */
</style>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Pop Up, Logo, & Splashscreen</h1>
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
                <?php if (has_permission('create_popups')): ?>
                    <a href="<?= base_url('popups/create') ?>" class="btn btn-outline-primary btn--icon-text"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Pop Up, Logo, & Splashscreen</a><br>
                <?php endif; ?>
                <input type="hidden" name="sort_table" id="sort_table" value="id">
                <input type="hidden" name="order_table" id="order_table" value="desc">
                <input type="hidden" name="status" id="status" value="active">
                <span class="invalid-feedback" id="wardingsearchactive" name="wardingsearchactive" style="display:none;">minimum 3 charachters</span>
                <br>
                <input type="search" placeholder="Search for title..." name="searchinputactive" id="searchinputactive" minlength="3" maxlength="50">
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
                                <th>Content</th>
                                <th>Pop Up Link</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Create Date</th>
                                <th>Update Date</th>
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
        </div>
    </div>
</section>

<!--Inactive Explore Confirmation-->
<div class="modal fade" id="inactiveExploreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<script type="text/javascript">
    $(document).ready(function () {
        activaTab('tab1')

        $('#rowselect_active').select2()
    })

    function activaTab(tab) {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show')
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var status = $('#status').val()
        var key_search = $('#searchinputactive').val()
        if (key_search == '') {
            key_search = null
        }
        var rowperpage = $('#rowselect_active').val()
        loadPagination(key_search, sort_by, order_sort, status, rowperpage, 0)
    }

    function handleRowSelect(type) {
        var pageno = 0
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var status = $('#status').val()
        var key_search = $('#searchinput' + type).val() || null
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(key_search, sort_by, order_sort, status, rowperpage, pageno)
    }

    $(document).on('change', '#rowselect_active', function () {
        handleRowSelect('active')
    })

    function handleSearch(type) {
        var search = $('#searchinput' + type).val()
        if (!search || search.length < 3) {
            $('#wardingsearch' + type).show()
            setTimeout(function () {
                $('#wardingsearch' + type).hide()
            }, 5000)
            return
        }
        var sort_by = $('#sort_table').val()
        var order_sort = $('#order_table').val()
        var status = $('#status').val()
        var rowperpage = $('#rowselect_' + type).val()
        loadPagination(search, sort_by, order_sort, status, rowperpage, 0)
    }

    $(document).on('click', '#searchbuttonactive', function () {
        handleSearch('active')
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
            var rowperpage = $('#rowselect_' + type).val()
            var sort_by = $('#sort_table').val()
            var order_sort = $('#order_table').val()
            var status = $('#status').val()
            loadPagination(key_search, sort_by, order_sort, status, rowperpage, pageno)
        })
    }

    handlePaginationClick('#pagination', 'active')

    function loadPagination(key_search, sort_by, order_sort, status, rowperpage, pageno) {
        $.ajax({
            url: '<?=base_url()?>popups/list_popups/'+key_search+'/'+sort_by+'/'+order_sort+'/'+status+'/'+rowperpage+'/'+pageno,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var order_sort = response.order
                var x = response.x
                var y = response.y
                var z = response.z
                var show = 'Showing '+x+' to '+y+' of '+z+' entries'
                $('#data-table_info').html(show)
                if (status == 'active') {
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
                    if (status == 'active') {
                        $('#pagination').html(page1)
                    } else {
                        $('#pagination2').html(page1)
                    }
                } else {
                    if (status == 'active') {
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
        var statustable = $('#status').val()
        if (statustable == 'active') {
            $('#mytable1 tbody').empty()
        } else {
            $('#mytable2 tbody').empty()
        }

        if (result.length > 0) {
            sno = Number(sno)
            for (index in result) {
                var id = result[index].id
                var content_url = result[index].img_url
                var popup_link = result[index].link ?? ''
                var location = result[index].location_name
                var status = result[index].status
                var create_date = result[index].created_at
                var update_date = result[index].updated_at
                
                sno+=1
                var base_url ='<?php echo base_url()?>'
                var activeinactive = ""
                var statusRow = ""

                if (status === "active") {
                    activeinactive = "<a onclick='inactiveConfirm(\""+base_url+'popups/inactivatedPopups/'+id+"\")' href='#!' class='dropdown-item'><i class='zmdi zmdi-minus-circle zmdi-hc-fw'></i>Deactivate</a>"
                    statusRow = "<button type='button' class='btn btn-outline-success' disabled>Active</button>"
                }

                var tr = "<tr id='"+id+"'>"
                tr += "<td>"+ sno +"</td>"
                tr += "<td>"+ content_url +"</td>"
                tr += "<td>"+ popup_link +"</td>"
                tr += "<td>"+ location +"</td>"
                tr += "<td>"+ statusRow +"</td>"
                tr += "<td>"+ create_date +"</td>"
                tr += "<td>"+ update_date +"</td>"
                tr += `<td>
                            <div class='dropdown'>
                                <button class='btn btn-light' data-toggle='dropdown' aria-expanded='false'>ACTION</button>
                                <div class='dropdown-menu dropdown-menu--icon'>
                                <?php if (has_permission('edit_popups')): ?>
                                    <a href="<?= base_url('popups/edit/${id}') ?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                <?php endif; ?>
                                <?php if (has_permission('delete_popups')): ?>
                                    ${activeinactive}
                                <?php endif; ?>
                                </div>
                            </div>
                        </td>`
                tr += "</tr>"
                if (statustable == 'active') {
                    $('#mytable1 tbody').append(tr)
                } else {
                    $('#mytable2 tbody').append(tr)
                }
            }
        } else {
            var tr = `<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No matching records found</td></tr>`
            if (statustable == 'active') {
                $('#mytable1 tbody').append(tr)
            } else {
                $('#mytable2 tbody').append(tr)
            }
        }
    }

    function inactiveConfirm(url) {
        $('#btn-confirminactive').attr('href', url)
        $('#inactiveExploreModal').modal()
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
</script>