var fullUrl = window.location.origin+'/webpanel/trucktype';
$('#sort').on('click',function(){
    const $this = $(this), text = $this.html(); 
    if(text=='Sort'){ $this.html('Cancel'); }else{ $this.html($this.data('text')) }
    $('.handle').toggle(); $('.no').toggle();
})
if($('#sorted_gallery').length>0){
    var el = document.getElementById('sorted_gallery');
    var dragger = tableDragger(el, { mode:'row', dragHandler:'.handle', onlyBody: true, animation: 300, });
    dragger.on('drop',function(from,to){
        const id = $('tr[data-row="'+from+'"]').data('id');
        dragsort(id,from,to);
    });
}
if($('#sorted_table').length>0)
{
    var el = document.getElementById('sorted_table');
    var dragger = tableDragger(el, { mode:'row', dragHandler:'.handle', onlyBody: true, animation: 300, });
    dragger.on('drop',function(from,to){
        const id = $('tr[data-row="'+from+'"]').data('id');
        dragsort(id,from,to);
    });
}
function dragsort(id,from,to){
    $.ajax({
        url:fullUrl+'/dragsort', type:'post', data:{id:id, from:from, to:to, _token:$('input[name="_token"]').val()}, dataType:'json',
        success:function(data){ if(data==true){ if(confirm('Refresh to change the display effect.')==true){ location.reload();} } }
    })
}
if($('#trucktypeForm').length>0){
    $('#trucktypeForm').validate({
        ignore:[],
        rules:{
            position:{ required: true },
            _id:{ required: function(){ const val = $('#position option:selected').val(); if(val=='secondary'){ return true }else{ return false }}},
            icon:{ required: function(){ const val = $('#position option:selected').val(); if(val=='main'|| val==''){ return true }else{ return false } } },
            name:{ required: true },
            url:{ required: true },
        },
        errorPlacement : function(error,element){
            if(element.parent().hasClass('input-group')){ 
                error.insertAfter(element.parent());
            }else{ 
                error.insertAfter(element);
            }
        },
    });
}
$('#position').on('change',function(){
    if($('option:selected',this).val()=='secondary'){ $('#icon').prop('disabled',true).removeClass('error'); }else{ $('#icon').prop('disabled',false); }
})
$('#icon').on('keyup',function(){
    $('#icon-preview').find('i').removeAttr('class').addClass($(this).val());
});
$('.status').on('click',function(){
    const $this = $(this), id = $(this).data('id');
    $.ajax({type:'get',url:fullUrl+'/status/'+id,success:function(res){if(res==false){$(this).prop('checked',false)}}});
})
$('.badge-status').on('click',function(){
    
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
    const id = $('.ChkBox:checked').map(function(){ return $(this).val() }).get(); if(id.length>0){ destroy(id) }
})

$('#copySelect').on('click',function(){
    const id = $('.ChkBox:checked').map(function(){ return $(this).val() }).get(); if(id.length>0){ copy(id) }
})

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
function copy(id)
{
    Swal.fire({
        title:"คัดลอก",text:"คุณต้องการคัดลอกข้อมูลใช่หรือไม่?",icon:"warning",showCancelButton:true,confirmButtonColor:"#DD6B55",showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(fullUrl+'/copy?id='+id)
            .then(response => response.json())
            .then(data => location.reload())
            .catch(error => { Swal.showValidationMessage(`Request failed: ${error}`)})
        }
    });
}
$('#position').on('change',function(){
    if($('option:selected',this).val()=='secondary'){ $('#_id').prop('selectedIndex',0).prop('disabled',false) }else{ $('#_id').prop('disabled',true) }
})

