 
 
<script type="text/javascript"> 
 
 
	
    $(document).ready(function(){
       getData(1); 
			});
	  
	
		function getData(select_id){
			
			if(select_id===''){ select_id = 1; }
			 
			if(select_id==="1"){ 
			$("#btn_prev").attr('disable',true);
			}else if($("#total_pages")===select_id){ 
			$("#btn_prev").attr('disable',false); 
			$("#btn_prev").data('id',select_id-1);	
			$("#btn_next").attr('disable',true);
			}else{ 
			$("#btn_prev").attr('disable',false); 
			$("#btn_prev").data('id',select_id-1);
			$("#btn_next").data('id',select_id+1);
			}
			
			$.ajax({
				url: "<?php echo base_url(); ?>mechanicapi/mechanic_cases/<?php echo $mechanic_id; ?>/",
				type: 'POST',
                dataType: 'html', 
				data: {
					'resulting_page_id' : select_id, 'mechanic_id': <?php echo $mechanic_id; ?>
				},
				cache: false,
				success: function(dataResult){
					$("#case-content").html(dataResult);
					$(".page-item").removeClass("active");
					$("#page-item-"+select_id).addClass("active");  
							
						$('[data-toggle="collapse"]').click(function(e){
						  e.preventDefault();
						  var target_element= $(this).attr("data-collapse");
						  $(target_element).collapse('toggle');
						  return false;
							});
					
				}
			});
				 
		} 
            

	
</script>  
  