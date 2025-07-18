<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <?php foreach ($menus as $menu): ?>
                    <?php if (empty($_SESSION['user_level']) || $menu['level'] > $_SESSION['user_level']):
                        continue;
                    endif; ?>
                    <?php if (empty($menu['children'])): ?>
                        <li>
                            <a href="./?<?php echo $menu['uri']; ?>" class="waves-effect">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span>
                                    <?php echo $menu['title']; ?>
                                </span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span>
                                    <?php echo $menu['title']; ?>
                                </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="list-unstyled">
                                <?php foreach ($menu['children'] as $child): ?>
                                    <?php if (empty($_SESSION['user_level']) || $child['level'] > $_SESSION['user_level']):
                                        continue;
                                    endif; ?>
                                    <li>
                                        <a href="./?<?php echo $child['uri']; ?>"><?php echo $child['title']; ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <!-- Sidebar -left -->

</div>