<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Blank Page</h1>
          </div>

          <div class="section-body">
			  <?php echo json_encode($this->session->userdata). '<br>'; ?>
			  
			  <?php echo '1 '. $this->rbac->createPermission. '<br>';?>
			  <?php echo '2 '.  $this->rbac->updatePermission. '<br>';?>
			  <?php echo '3 '.  $this->rbac->readPermission. '<br>';?>
			  <?php echo '4 '.  $this->rbac->deletePermission. '<br>';?>
			  
				<?php if(!empty($this->rbac->createPermission_custom)){   echo '5 '.  $this->rbac->createPermission_custom. '<br>';  } ?>
			  
			  	<?php if(!empty($this->rbac->updatePermission_custom)){  echo '6 '.  $this->rbac->updatePermission_custom. '<br>';   } ?>
			  
			  	<?php if(!empty($this->rbac->readPermission_custom)){    echo '7 '.  $this->rbac->readPermission_custom. '<br>';     } ?>
			  
			  	<?php if(!empty($this->rbac->deletePermission_custom)){   echo '8 '.  $this->rbac->deletePermission_custom. '<br>';  } ?>
			  
			  
          </div>
        </section>
      </div>
 