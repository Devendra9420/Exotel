<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="<?php echo base_url(); ?>"><img alt="image" src="<?= base_url(); ?>logo.png" class="img-fluid mr-1 pr-3"></a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?php echo base_url(); ?>"><img alt="image" src="<?= base_url(); ?>logo_small.png" class="img-fluid mt-3 pb-2 shadow-light"></a>
          </div>
          <ul class="sidebar-menu"> 
            <li class="<?php echo $this->uri->segment(2) == '' || $this->uri->segment(2) == 'index' || $this->uri->segment(2) == 'index_0' ? 'active' : ''; ?>">
              <a href="<?php echo base_url(); ?>" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a> 
            </li>
			 
            <li class="menu-header">Menu</li>
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			 
			  <?php $parent_nav = get_sidebar_menu(); ?>
			  <?php foreach ($parent_nav as $prow): ?>
                    <?php //if($this->rbac->check_module_permission($prow->link)==1){  ?>
                        <li class="dropdown"> 
							
                    <a href="<?php if ($prow->link == "#") {
                        echo "javascript:;";
						$menu_level1 = '#';
                    } else {
                        echo base_url() . $prow->link;
						$menu_level1 = $prow->link;
                    } ?>" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas <?php echo $prow->fa_icon; ?>"></i>
                        <span class="title"><b><?php echo $prow->menu_name; ?></b></span> 
                    </a>
                     <ul class="dropdown-menu">
                        <?php $child_menus = get_sidebar_sub_menu($prow->id); ?>
                        <?php foreach ($child_menus as $child_menuss => $val) {
                             //if($this->rbac->check_sub_module_permission($prow->link, $val->link)==1){ 
                            ?>
                            <?php if ($prow->id == $val->parent) { ?>
                                <?php
									if ($val->menu_name == $this->session->userdata('child_name')) {
                                    $class1 = 'active';
                                   	} else { 
									$class1 = '';
									}
									$link_split = explode('/',$val->link);
							   if($this->rbac->check_sub_module_permission($link_split[0],$link_split[1])==1) { 
						 			?>
                                    <li class="layout_default <?= $class1 ?>">  
                                <a href="<?php echo base_url() . $val->link; ?>" class="nav-link">
									 
                                    <span class="title"><?php echo $val->menu_name; ?></span>
                                </a>
                                </li>
                            <?php } ?>
                        <?php  } ?>
						<?php } ?> 
                    </ul>
                    </li>
			  <?php //} ?>
                <?php endforeach; ?>
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
          
              
          </ul>

          <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="#" class="btn btn-primary btn-lg btn-block btn-icon-split">
              <i class="fas fa-rocket"></i> Support
            </a>
          </div>
        </aside>
      </div>
