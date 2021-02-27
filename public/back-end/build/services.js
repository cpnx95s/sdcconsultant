var fullUrl = window.location.origin+'/webpanel/services';
if($('textarea.tiny').length > 0){
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

$('.status').on('click',function(){
    const $this = $(this), id = $(this).data('id');
    $.ajax({type:'get',url:fullUrl+'/status/'+id,success:function(res){if(res==false){$(this).prop('checked',false)}}});
})
$('#selectAll').on('click',function(){
    if($(this).is(':checked')){ $('#delSelect').prop('disabled',false);$('.ChkBox').prop('checked',true) }else{ $('#delSelect').prop('disabled',true); $('.ChkBox').prop('checked',false) }
})
$('.ChkBox').click(function(){
    const checked = []; const $this = $(this).prop("checked");
    $('.ChkBox').each(function(){ if($(this).is(':checked')){ checked.push($this) } })
    if(checked.length>0){ $('#delSelect').prop('disabled',false); }else{ $('#delSelect').prop('disabled',true); }
})
$('.deleteItem').on('click',function(){
    const id =[$(this).data('id')];
    if(id.length>0){ destroy(id) }
})
$('#delSelect').on('click',function(){
    const id = $('.ChkBox:checked').map(function(){ return $(this).val() }).get();
    console.log(id);
    if(id.length>0){ destroy(id) }
});

function destroy(id)
{
    Swal.fire({
        title:"ลบข้อมูล",text:"คุณต้องการลบข้อมูลใช่หรือไม่?",icon:"warning",showCancelButton:true,confirmButtonColor:"#DD6B55",showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(fullUrl+'/destroy?id='+id)
            .then(response => response.json())
            .then(data => location.reload())
            .catch(error => { Swal.showValidationMessage(`Request failed: ${error}`)})
        }
    });
}

$('#sort').on('click',function(){
    const $this = $(this), text = $this.html(); 
    if(text=='Sort'){ $this.html('Cancel'); }else{ $this.html($this.data('text')) }
    $('.handle').toggleClass('d-none'); 
    $('.no').toggleClass('d-none');
})

if($('#sort_table').length>0)
{
    var el = document.getElementById('sort_table');
    var dragger = tableDragger(el, { mode:'row', dragHandler:'.handle', onlyBody: true, animation: 300, });
    dragger.on('drop',function(from,to){
        const id = $('tr[data-row="'+from+'"]').data('id');
        dragsort(id,from,to);
    });    
    
}
function dragsort(id,from,to)
{
    $.ajax({url:fullUrl+'/dragsort',type:'post',data:{id:id,from:from,to:to, _token:$('input[name="_token"]').val()},dataType:'json',success:function(data){/*if(data==true){ if(confirm('Refresh to change the display effect.')==true){ location.reload();}}*/}})
}

/* ========== Gallery ========== */

$('#add_gallery').click(function(){ 
    const text = $(this).html();
    if(text=='Add'){ 
        $(this).html('Cancel');
        $("#gallery").slideDown('fast');
    }else{ 
        $(this).html('Add');
        $("#gallery").slideUp('fast');
    }
    
})
$('.reset-upload').click(function(){
    $(this).parent().find('input[type="file"]').val(null);
    $(this).parent().find('input[type="text"]').val(null);
    $('#galleryPreview').find('.preview-item').remove();
})
function readGallery() 
{
    const target = $('#galleryPreview');
    var total_file=document.getElementById("galleryUpload").files.length;
    target.find('.new-pre').remove();
    for(var i=0;i<total_file;i++)
    {
        target.append("<div class='col-lg-2 col-md-2 col-xs-6 p-2 preview-item'><div class='img-thumbnail'><div class='img-preview'><img class='img-fluid' src='"+URL.createObjectURL(event.target.files[i])+"'/></div><div class='caption' style='margin-top:5px;'><i class='fas fa-upload'></i></div></div></div>");
    }
}
$('input[name="gallerImg"]').click(function(){
    selectGallery()
})
$('.cancel').on('click',function(){
    const toggle = $(this).data('toggle');
    $('input[name^="'+toggle+'"]').prop('checked',false);
    selectGallery()
})
$('.deleteGallerys').click(function(){
    const id = $('input[name="gallerImg"]:checked').map(function(){ return $(this).val() }).get(), row = $(this).data('row');
    if(id.length>0){ deleteGallery(id,row); }
})
$('.deleteGallery').click(function(){
    const id = [$(this).data('id')], row = $(this).data('row');
    deleteGallery(id,row);
})
function selectGallery()
{
    const checked = $('input[name="gallerImg"]:checked').map(function(){ return $(this).val() }).get();
    const action = $('.action-gallery');
    const btnC = $('.action-gallery').find('.cancel');
    const btnD = $('.action-gallery').find('.deleteGallerys');
    // console.log(btnC)
    if(checked.length>0){
        action.slideDown('fast');
        btnC.removeAttr('disabled');
        btnD.removeAttr('disabled');
        if(!btnD.hasClass('btn-danger'))
        {
            btnD.toggleClass('btn-secondary btn-danger');
        }
    }else{ 
        action.slideUp('fast');
        btnC.attr('disabled','');
        btnD.attr('disabled','');
        if(btnD.hasClass('btn-danger'))
        {
            btnD.toggleClass('btn-secondary btn-danger');
        }
    }
}
function deleteGallery(id,row)
{
    Swal.fire({
        title:"ยืนยันลบ",text:"คุณแน่ใจใช่หรือไม่?",icon:"warning",showCancelButton:true,confirmButtonColor:"#DD6B55",showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(fullUrl+'/gallery/destroy?id='+id)
            .then(response => response.json())
            .then(data => { 
                // if(data===true){location.reload()}
                $.each(id,function(i,v){$('#gallery'+v).remove()})
            })
            .catch(error => { Swal.showValidationMessage(`Request failed: ${error}`)})
        }
    });

}