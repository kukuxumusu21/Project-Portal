<br><br><br>
<style>

.custom_hr {
    margin: 25px 0;
    height: 1px;
    border: 0;
    background: black;
    background: -webkit-gradient(linear, 0 0, 100% 0, from(white), to(white), color-stop(50%, black));
}

</style>

<script type="text/javascript">
$(document).ready(function(){
    var save_method;

    var imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.file) {
            var filesAmount = input.file.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $($.parseHTML('<img style="height:64px; width:auto; margin:0 auto;">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.file[i]);
            }
        }
    };
    $('#picture').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });

    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    
    show_product();
});

function show_product(){
    $.ajax({
        type  : 'ajax',
        url   : '<?php echo site_url('home/get_website_apps')?>',
        async : false,
        dataType : 'json',
        success : function(data){
            var html = '';
            var i;
            for(i=0; i<data.length; i++){
                html += '<div class="">'+
                            '<div class="span3">'+
                                '<div class="bs-docs-example">'+
                                   '<div class="modal-content" style="position: relative; top: auto; left: auto; right: auto; margin: 0 auto 20px; z-index: 1; max-width: 100%;"'+
                                        '<div class=" modal-body">'+
                                            '<span>'+data[i].website+'</span>'+ '<br>'+
                                            '<span>'+data[i].description+'</span>'+
                                        '</div>'+
                                        '<div class="">'+
                                            '<a href="javascript:void(0);"  target="_blank" class="btn btn-info btn-sm" data-product_code="'+data[i].website+'" >View</a>'+' '+
                                            '<a href="javascript:void(0);" class="btn btn-danger btn-sm item_delete" data-product_code="'+data[i].product_code+'">Delete</a>'+
                                        '</div>'+
                                   '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
            }
            $('#show_data').html(html);
        }

    });
}

function add_proj() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    // $('.control-group').removeClass('has-error'); // clear error class
    $('.help-inline').empty(); // clear error string
    $('#modal_add').modal('show'); // show bootstrap modal\
    // $('#photo-preview').hide(); // hide photo preview modal

    // $('#label-photo').text('Upload Photo'); // label photo upload
}

function reloadTable()
{
    table.ajax.reload(null,false); //reload datatable ajax
    // $('#deleteList').hide();
}

function save_photo() {
    $('#files').change(function(){
            var files = $('#files')[0].files;
            var error = '';
            var form_data = new FormData();

        for(var count = 0; count<files.length; count++) {
            var name = files[count].name;
            var extension = name.split('.').pop().toLowerCase();

            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1) {
                error += "Invalid " + count + " Image File"
            }
            else {
                form_data.append("files[]", files[count]);
            }
        }
        if(error == '') {
            $.ajax({
                url:"<?php echo base_url('home/photoSaved')?>",
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data) {
                    // $('#uploaded_images').html(data);
                    // $('#files').val('');
                    return true;
                }
            })
        } else {
            alert(error);
        }
    });
}

function save_proj() {
    $('#btnSave').text('Saving..');
    $('#btnSave').attr('disabled',true);
    // var requestCallback = new MyRequestsCompleted({
    //     numRequest: 3
    // });

    var url;
    if(save_method == 'add') {
        url = "<?php echo base_url('home/websiteApps')?>";
    } else {
        url = "<?php echo base_url('home/websiteApps')?>";
    }
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            // console.log(data.error);
            if(data.status) {
                $('#modal_add').modal('hide');
                // reload_table();
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            save_photo();
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
            // requestCallback.addCallbackToQueue(true);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            // console.log(textStatus, errorThrown);
            alert('Error adding / update data');
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
        }
    });
    // $.ajax({
    //     url: '',
        
    // });
}

</script>
<div class="container">
    <button onclick="add_proj()" class="btn btn-primary"><i class="icon-plus icon-white"></i> Add Project</button>
<br>

<div class="modal hide fade form-horizontal" tabindex="-1" id="modal_add" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-center" style="color:gray;">PROJECT DETAILS</h4>
            </div>

            <div class="modal-body form">
                <?php echo form_open('#',array('id' => 'form'));?>
                    <div class="control-group">
                        <label class="control-label">Link :</label>
                        <div class="controls">
                            <?php echo form_input(array(
                                'type' => 'text',
                                'name' => 'website',
                                'value' => set_value('website')
                            ));?>
                            <span class="help-inline"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Photo :</label>
                        <div class="controls">
                            <input type="file" name="files" id="files" multiple/>
                            <!-- <input type="file" name="photo"/> -->
                            <div class="gallery"></div>
                        </div>
                    </div>

                            
                    <div class="control-group">
                        <label class="control-label">Description :</label>
                        <div class="controls">
                            <?php echo form_textarea(array(
                                'name' => 'description',
                                'value' => set_value('description')
                            ));?>
                            <span class="help-inline"></span>
                            <!-- <textarea ></textarea> -->
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnSave" onclick="save_proj()" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<hr class="custom_hr">
</div>

<div class="container">
    <div class="row">
        <div id="show_data">
        </div>
    </div>
</div>