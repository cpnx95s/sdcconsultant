tinymce.init({
    selector: 'textarea.tiny',
    menubar : false,
    force_br_newlines : true,
    force_p_newlines : false,
    forced_root_block : '',
    height: 600, 
    //width : 1100,
    plugins: ["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker","searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking","save table contextmenu directionality emoticons template paste textcolor colorpicker layer textpattern moxiemanager"],    
    toolbar: 'insertfile undo redo | table | styleselect fontsizeselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | print nonbreaking hr emoticons code',
    
});
if($('#editForm').length>0){
	$('#add_event').click(function(){
		addEvent()
	})
}

function addEvent()
{
	var dest = $('#event_content');
	console.log(dest);
	var title_th = $('<div class="col-lg-4"><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">Title(TH)</span></div><input type="text" class="form-control" name="title_th"></div></di>');
	var title_en = $('<div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">Title(EN)</span></div><input type="text" class="form-control" name="title_en></div>');
	var detail_th = $('<div class="col-lg-8"><div class="input-group mb-3""><div class="input-group-prepend"><span class="input-group-text">Detail(TH)</span></div><textarea name="detail_th" class="form-control"></textarea></div></div>');
	var detail_en = $('<div class="input-group mb-3""><div class="input-group-prepend"><span class="input-group-text">Detail(EN)</span></div><textarea name="detail_en" class="form-control"></textarea></div>');
	dest.append(title_th,detail_th,title_en,detail_en);
}

$("#image").on('change',function(){
    var $this = $(this);
    const input = $this[0];
    const fileName = $this.val().split("\\").pop();
    $this.siblings(".custom-file-label").addClass("selected").html(fileName);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }
});