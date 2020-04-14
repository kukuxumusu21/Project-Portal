
<br><br><br>
<style>

.custom_hr {
    margin: 25px 0;
    height: 1px;
    border: 0;
    background: gray;
    background: -webkit-gradient(linear, 0 0, 100% 0, from(white), to(white), color-stop(50%, gray));
}

</style>

<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox-button").fancybox({
			prevEffect		: 'none',
			nextEffect		: 'none',
			closeBtn		: false,
			helpers		: {
				title	: { type : 'inside' },
				buttons	: {}
			}
		});

	// 	$('#picture').change(function(){
	// 		var picture = $('#picture')[0].picture;
	// 		var error = '';
	// 		var form_data = new FormData();
	// 		for(var count = 0; count<picture; count++) {
	// 			var name = picture[count].name;
	// 			var extension = name.split('.').pop().toLowerCase();
	// 			if(jQuery.inArray(extension, ['png','jpg','jpeg']) == -1) {
	// 				error += "Invalid " + count + " Image File"
	// 			} else {
	// 				form_data.append("picture[]", picture[count]);
	// 			}
	// 		}
	// 	});

	});

	function add_proj() {
    	save_method = 'add';
    	$('#form')[0].reset();
    	$('.control-group').removeClass('has-error');
    	$('.help-block').empty();
		$('#modal_add').modal('show'); 
	}

	function save()
	{
	    $('#btnSave').text('Saving...'); //change button text
	    $('#btnSave').attr('disabled',true); //set button disable 
	    var url;
	 
	    if(save_method == 'add') {
	        url = "<?php echo site_url('dashboard/addProject')?>";
	    } else {
	        url = "<?php echo site_url('dashboard/addProject')?>";
	    }
	 
	    // ajax adding data to database
	    var formData = new FormData($('#form')[0]);
	    $.ajax({
	        url : url,
	        type: "POST",
	        data: formData,
	        contentType: false,
	        processData: false,
	        dataType: "JSON",
	        success: function(data) {
	            if(data.status) {
	                $('#modal_add').modal('hide');
	            } else {
	                for (var i = 0; i < data.inputerror.length; i++) {
	                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
	                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
	                }
	            }
	            $('#btnSave').text('Save'); 
	            $('#btnSave').attr('disabled',false); 
	        },
	        error: function (jqXHR, textStatus, errorThrown) {
	            alert('Error adding / update data');
	            $('#btnSave').text('Save'); //change button text
	            $('#btnSave').attr('disabled',false); //set button enable 
	 
	        }
	    });
	}
</script>

<?php if($this->authentication->is_signed_in()):?>
<div class="container">
	<button onclick="add_proj()" class="btn btn-default"><i class="icon-plus icon-black"></i>&nbsp;Add</button>
</div>
<?php endif;?>


<div class="modal hide fade form-horizontal" tabindex="-1" id="modal_add" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-center" style="color:gray;">PROJECT DETAILS</h4>
            </div>

            <div class="modal-body form">
            	<?php echo form_open_multipart('#',array('id'=>'form'))?>
	            	<div class="control-group">
	            		<label class="control-label">Title :</label>
	            		<div class="controls">
	            			<?php echo form_input(array(
	            				'name' => 'prj_title',
	                            'value' => set_value('prj_title')
	            			));?>
	            			<span class="help-block"></span>
	            		</div>
	            	</div>

	                <div class="control-group">
	                    <label class="control-label">Link :</label>
	                    <div class="controls">
	                        <?php echo form_input(array(
	                            'name' => 'prj_website',
	                            'value' => set_value('website')
	                        ));?>
	                        <span class="help-block"></span>
	                    </div>
	                </div>

	                <!-- <div class="control-group">
	                    <label class="control-label">Photo :</label>
	                    <div class="controls">
	                        <input type="file" name="files" id="files" multiple/>
	                        <div class="gallery"></div>
	                    </div>
	                </div> -->

                    <div class="control-group">
                        <label class="control-label" id="label-photo">Photo :</label>
                        <div class="controls">
                            <input name="picture" type="file" multiple/>
                            <span class="help-block"></span>
                        </div>
                    </div>
	                        
	                <div class="control-group">
	                    <label class="control-label">Description :</label>
	                    <div class="controls">
	                        <?php echo form_textarea(array(
	                            'name' => 'prj_description',
	                            'value' => set_value('description')
	                        ));?>
	                        <span class="help-block"></span>
	                    </div>
	                </div>
            	</form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <!-- <button type="submit" class="btn btn-primary">Save</button> -->
                
            </div>
        </div>
    </div>
</div>

<hr class="custom_hr">

<div class="container">
	<div class="row">
		<?php foreach($all_projects as $proj):?>
		<div class="span3">

			<div></div>


			<div class="" style="position: relative; top: auto; left: auto; right: auto; margin: 0 auto 40px; z-index: 1; max-width: 100%; border: 1px solid #ddd; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<div class="view overlay">
								<?php if($proj['picture'] != NULL):?>
									<a href="<?php echo base_url(); ?>upload/<?php echo $proj['picture']?>" rel="fancybox-button" class="fancybox-button">
										<style type="text/css">
											img.custom-image {
											    max-width: 100%; height: auto;
										</style>
										<img class="custom-image" style="width: 180px; min-height: 180px; max-height: auto; float: left; margin: 1px;padding: 2px" src="<?php echo base_url(); ?>upload/<?php echo $proj['picture']?>" salt="Image">
									</a>
								<?php else :?>
									<a href="<?php echo base_url().RES_DIR; ?>/img/default.png" rel="fancybox-button" class="fancybox-button">
										<img class="custom-image" style="width: 150px; min-height: 150px; max-height: auto; float: left; margin: 1px;padding: 2px" src="<?php echo base_url().RES_DIR; ?>/img/default.png" salt="Image">
									</a>
								<?php endif;?>
								<a href="#!">
								  <div class="mask rgba-white-slight"></div>
								</a>
							</div>
							<h5 class="card-title"><?php echo $proj['title'];?></h5>
						<p class="card-text"><?php echo $proj['description'];?></p>
						</div>

						<div class="modal-footer">
							<a href="<?php echo $proj['website'];?>" target="_blank" class="btn btn-success" title="View"><i class="icon-eye-open icon-white"></i>&nbsp;View</a>
							<a href="javascript:void()" class="btn btn-danger"><i class="icon-trash icon-white"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>



<?php $this->load->view('components/footer');?>