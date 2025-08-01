<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1><?= html_escape($title) ?>: <?= html_escape($menu->name) ?></h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('menus') ?>">Menus</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?>: <?= html_escape($menu->name) ?></li>
                    </ol>
                </nav>
                <?= form_open('menus/set_permission_menu/' . $menu->id) ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Permissions</label>
                            <div class="row">
                                <?php foreach ($permissions as $permission): ?>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <label class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" name="permissions[]" value="<?= $permission->id ?>" <?= in_array($permission->id, $menu_permission_ids) ? 'checked' : '' ?>>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"><?= html_escape($permission->name) ?></span>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" align="center">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>