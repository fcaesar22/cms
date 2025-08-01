<?php
// Group permissions berdasarkan menu parent dan child
$grouped = [];
foreach ($permissions as $perm) {
    $parent = $perm->parent_menu_name ?? 'Uncategorized';
    $child = $perm->child_menu_name ?? 'Uncategorized';

    if (!isset($grouped[$parent])) {
        $grouped[$parent] = [];
    }
    if (!isset($grouped[$parent][$child])) {
        $grouped[$parent][$child] = [];
    }
    $grouped[$parent][$child][] = $perm;
}
?>

<section class="content">
    <div class="content__inner">
        <header class="content__title">
            <h1><?= html_escape($title) ?></h1>
        </header>
        <div class="card">
            <div class="card-body">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('roles') ?>">Roles</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= html_escape($title) ?></li>
                    </ol>
                </nav>

                <?= form_open('roles/permissions/' . $role->id) ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php foreach ($grouped as $parent_name => $children): ?>
                            <h4 class="mt-4"><?= html_escape($parent_name) ?></h4>
                            <?php foreach ($children as $child_name => $perms): ?>
                                <strong><?= html_escape($child_name) ?></strong>
                                <div class="ml-3 mb-3">
                                    <?php foreach ($perms as $perm): ?>
                                        <div class="form-check">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" name="permissions[]" value="<?= $perm->id ?>" class="custom-control-input" <?= in_array($perm->id, $role_permissions) ? 'checked' : '' ?>>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">
                                                    <?= html_escape($perm->name) ?>
                                                </span>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                            <hr>
                        <?php endforeach; ?>
                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success">Update Permissions</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>
