<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1>Create Menu Sidebar</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('menus') ?>">Menu</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>','</div>'); ?>
                <?= form_open('menus/edit/'.$menu->id) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="<?= set_value('name', $menu->name) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>URL</label>
                                <input type="text" name="url" class="form-control" value="<?= set_value('url', $menu->url) ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Icon</label>
                                <input type="text" name="icon" class="form-control" value="<?= set_value('icon', $menu->icon) ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Parent</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="">-- Select Parent --</option>
                                    <?php foreach ($parents as $p): ?>
                                        <option value="<?= $p->id ?>" <?= set_select('parent_id', $p->id, $menu->parent_id == $p->id) ?>><?= html_escape($p->name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="<?= set_value('sort_order', $menu->sort_order) ?>" required>
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

<script type="text/javascript">
    $(document).ready(function(){
        $('#parent_id').select2()
    })
</script>