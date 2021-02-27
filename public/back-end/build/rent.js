var fullUrl = window.location.origin+'/webpanel/rent';
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

if($('#formEdit').length>0){
    $('#tree').treeview({debug:false, data:[$('input[name="position_id"]').val()], disable:false});
    var position=[], _id=[];
    $('.tree').on('click',function(){
        var current = $(this);
        const collapsed = 'fa-angle-right', expanded = 'fa-angle-down';
        if(current.is(':checked')){ 
            $('.tree').not(this).prop('checked',false);
            $('i.fa-angle-down').not(this).removeClass(expanded).addClass(collapsed);
            $('ul.show').not(this).removeClass('show').addClass('hide');
            position.push(current.data('position'));
            _id.push(current.data('id'));
        }else{
            position.splice($.inArray(current.data('position'), position),1);
            _id.splice($.inArray(current.data('id'), _id),1);
        }
        evTree(position,_id)
    })
    function evTree(position,_id)
    {
        $('input[name="position"]').val(position);
        $('input[name="position_id"]').val(_id);
    }
    $(function(){ checkOption($('#option')) })
    $('#option').on('click',function(){
        checkOption($(this))
    })
    checkOption = function(el)
    {
        if(!el.is(':checked')){
            $('p.option').addClass('text-secondary');
            $('input[name="value[]"]').prop('disabled',true);            
        }else{
            $('p.option').removeClass('text-secondary');
            $('input[name="value[]"]').removeAttr('disabled');            
        }
    }
}
//

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

/* ================================================= */
/* ==================== Gallery ==================== */
/* ================================================= */
$('#add_gallery').click(function(){ 
    const text = $(this).html();
    if(text=='Add'){ 
        $(this).html('Cancel');
        $("#gallery").slideDown('fast');
    }else{ 
        $(this).html('Add');
        $("#gallery").slideUp('fast');
    }
    
});
$('.reset-upload').click(function(){
    $(this).parent().find('input[type="file"]').val(null);
    $(this).parent().find('input[type="text"]').val(null);
    $('#galleryPreview').find('.preview-item').remove();
    $(this).parent().parent().find(".custom-file-label").removeClass('selected').html('');
})
$('input[name="gallery[]"]').on('change',function(){

    var $this = $(this);
    const fileName = [];
    const files = $this[0].files;
    for(let i = 0; i<files.length; i++)
    {
        fileName.push(files[i].name);
    } 
    $this.siblings(".custom-file-label").addClass("selected").html(fileName.toString());

});
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
/* ================================================= */
/* ===================== Video ===================== */
/* ================================================= */
const videoId = [];
$('#add_video').click(function(){
    $('#video_product').append( videoContent() );
})
function videoContent(id,key)
{
    if(id==undefined){id=Date.now()}
    var theme='<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 p-2" data-row="videoRow" id="videoRow'+id+'">\
        <div class="img-thumbnail p-2">\
        <a href="javascript:" class="float-right deleteVideo" data-row="videoRow" data-id="'+id+'" data-timing="add" style="margin-bottom:5px;"><i class="fas fa-times fa-lg"></i></a>\
            <iframe width="100%" height="250" id="myIframe'+id+'" name="myIframe" src="//www.youtube.com/embed/?feature=player_detailpage"  frameborder="0" allowfullscreen="allowfullscreen"></iframe>\
            <div class="caption">\
                <div class="form-group"><h6>Video ID :</h6>\
                    <div class="form-line">\
                        <input type="text" name="vid[]" class="form-control" onkeyup="vChange($(this))" data-row="videoRow" data-id="'+id+'" value="">\
                    </div>\
                </div>\
            </div>\
        </div>\
    </div>';
    return theme;
}
function vChange(el) {
    const val = el.val();
    var id = el.data('id');
    $("#myIframe"+id).attr("src","//www.youtube.com/embed/"+val+"?feature=player_detailpage");
    // sitesgohere.src = "//www.youtube.com/embed/"+val+"?feature=player_detailpage";
}
$('input[name="youtube"]').on('click',function(){
    if($(this).is(':checked')){ videoId.push($(this).val()) }else{ videoId.splice( $.inArray($(this).val(), videoId), 1 ); }
    (videoId.length>0)? $('.deleteVideos').removeAttr('disabled') : $('.deleteVideos').attr('disabled','disabled') ;
})
$('.deleteVideos').click(function(){
    const val = $('input[name="youtube"]:checked').map(function(){ return $(this).val() }).get(),
    row = $(this).data('row');
    if(val.length>0){ deleteVideo(val,row) }
});
$(document).on('click','.deleteVideo',function(){
    const id=[$(this).data('id')], row=$(this).data('row'), timing=$(this).data('timing'); 
    if(id.length>0){ deleteVideo(id,row,timing) }
});
function deleteVideo(id,row,timing)
{
    Swal.fire({
        title:'ยืนยันลบ?',
        text:'คุณแน่ใจใช่หรือไม่!',
        icon:'warning',
        confirmButtonText:'ใช่. ลบเลย!',
        confirmButtonColor:'#DD6B55',
        showCancelButton:true,
        cancelButtonText:'ยกเลิก',
    }).then((res)=>{
        if(timing=='add'){$.each(id,function(i,v){$('#'+row+v).fadeOut(500).remove()})}
        else{
            $.ajax({
                url:fullUrl+'/destroy/videos',type:'post',dataType:'json',data:{'id[]':id,_method:'DELETE',_token:$('input[name="_token"]').val()},
                success:function(res){
                    if(res==true){
                        Swal.fire('สำเร็จ!','ไฟล์ถูกลบแล้ว.','success');$.each(id,function(i,v){$('#'+row+v).fadeOut(500).remove()});
                    }else{
                        Swal.fire('ล้มเหลว!','มีบางอย่างผิดพลาด กรุณาทำรายการใหม่ภายหลัง.','error')
                    }
                },
                error:function(){swal('ล้มเหลว!','มีบางอย่างผิดพลาด กรุณาทำรายการใหม่ภายหลัง.','error');}
            });
        }
    })
}
/* ================================================= */
/* ================= File Download ================= */
/* ================================================= */
$('#add_file').click(function(){ 
    const text = $(this).html();
    if(text=='Add'){
        $(this).html('Cancel');
        $("#file").slideDown('fast');
    }else{
        $(this).html('Add');
        $("#file").slideUp('fast');
    }
});
$('input[name="file"]').click(function(){
    selectFile()
})
$('.cancel').on('click',function(){
    const toggle = $(this).data('toggle');
    $('input[name^="'+toggle+'"]').prop('checked',false);
    selectFile()
})
$('.delete-files').click(function(){
    const id = $('input[name="file"]:checked').map(function(){ return $(this).val() }).get(), row = $(this).data('row');
    if(id.length>0){ deleteFile(id,row); }
})
$('.delete-file').click(function(){
    const id = [$(this).data('id')], row = $(this).data('row');
    deleteFile(id,row);
})
function selectFile()
{
    const checked = $('input[name="file"]:checked').map(function(){ return $(this).val() }).get();
    const action = $('.action-files');
    const btnC = $('.action-files').find('.cancel');
    const btnD = $('.action-files').find('.delete-files');
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
function deleteFile(id,row)
{
    Swal.fire({
        title:"ยืนยันลบ",text:"คุณแน่ใจใช่หรือไม่?",icon:"warning",showCancelButton:true,confirmButtonColor:"#DD6B55",showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(fullUrl+'/file/destroy?id='+id)
            .then(response => response.json())
            .then(data => { 
                // if(data===true){location.reload()}
                $.each(id,function(i,v){$('#file-item-'+v).remove()})
            })
            .catch(error => { Swal.showValidationMessage(`Request failed: ${error}`)})
        }
    });

}