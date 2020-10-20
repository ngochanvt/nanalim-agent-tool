<nav id="sidebar">
	<div class="sidebar-header">
        <h3>Nanalim Agency Tools</h3>
        <form method="POST" id="form-language" action="action/a_config.php">
            <div class="form-group">
                <select class="form-control" name="language" id="language">
                    <option value="vi" <?=$glb_config['lang']=='vi'?'selected':''?>>Vietnamese</option>
                    <option value="kr" <?=$glb_config['lang']=='kr'?'selected':''?>>한국어</option>
                    <option value="en" <?=$glb_config['lang']=='en'?'selected':''?>>English</option>
                </select>
            </div>
        </form>
    </div>

    <ul class="list-unstyled components">
        <?php 
            $data_menu = file_get_contents('config/menu.json');
            $menus = json_decode($data_menu, true);
            foreach ($menus as $menu) { 
                if(in_array($menu['role'], $glb_config['accept_role'])) {?>
                    <li class="<?=$glb_config['current_role']==$menu['role']?'active':''?>">
                        <a href="<?=$glb_config['baseurl'].'index.php?route='.$menu['route']?>"><?=$menu['title'][$glb_config['lang']]?></a>
                    </li>
        <?php } } ?>
    </ul>
</nav>