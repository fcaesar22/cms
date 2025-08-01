<?php
$CI =& get_instance();
$CI->load->model('Menu_model');
$role_id = $CI->session->userdata('role_id');

if (!$role_id) {
    echo 'Role ID tidak ditemukan di session.';
    return;
}

$menus = $CI->Menu_model->get_menu_by_role($role_id);

// Susun menu menjadi pohon (tree)
$menu_tree = [];
foreach ($menus as $menu) {
    $menu->submenus = [];
    $menu_tree[$menu->id] = $menu;
}

$tree = [];
foreach ($menu_tree as $id => $menu) {
    if ($menu->parent_id && isset($menu_tree[$menu->parent_id])) {
        $menu_tree[$menu->parent_id]->submenus[] = $menu;
    } else {
        $tree[] = $menu;
    }
}

$current_uri = $CI->uri->uri_string();
?>

<aside class="sidebar">
    <div class="scrollbar-inner">
        <div class="user">
            <div class="user__info" data-toggle="dropdown">
                <img class="user__img" src="<?= base_url() ?>assets/demo/img/profile-pics/8.jpg" alt="">
                <div>
                    <div class="user__name"><?= html_escape($CI->session->userdata('username')) ?></div>
                </div>
            </div>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?= base_url('auth/logout') ?>">Logout</a>
            </div>
        </div>

        <ul class="navigation">
            <?php foreach ($tree as $menu): 
                $is_active = !empty($menu->url) && strpos($current_uri, $menu->url) === 0;
                $submenu_active = false;

                foreach ($menu->submenus as $submenu) {
                    if (!empty($submenu->url) && strpos($current_uri, $submenu->url) === 0) {
                        $submenu_active = true;
                        break;
                    }
                }
            ?>
                <?php if (empty($menu->submenus)): ?>
                    <li class="<?= $is_active ? 'navigation__active' : '' ?>">
                        <a href="<?= base_url($menu->url) ?>">
                            <i class="<?= $menu->icon ?>"></i> <?= html_escape($menu->name) ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="navigation__sub <?= $submenu_active ? 'navigation__sub--active' : '' ?>">
                        <a href="#">
                            <i class="<?= $menu->icon ?>"></i> <?= html_escape($menu->name) ?>
                        </a>
                        <ul class="navigation__sub" style="<?= $submenu_active ? 'display:block;' : 'display:none;' ?>">
                            <?php foreach ($menu->submenus as $submenu): ?>
                                <li class="<?= (!empty($submenu->url) && strpos($current_uri, $submenu->url) === 0) ? 'navigation__active' : '' ?>">
                                    <a href="<?= base_url($submenu->url) ?>"><?= html_escape($submenu->name) ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>