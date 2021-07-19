var fullUrl = window.location.origin+'/webpanel/insurance/option';
if($('#sort_table').length>0)
{
    var el = document.getElementById('sort_table');
    var dragger = tableDragger(el, { mode:'row', dragHandler:'.handle', onlyBody: true, animation: 300, });
    dragger.on('drop',function(from,to){
        const id = $('tr[data-row="'+from+'"]').data('id'), position = $('tr[data-row="'+from+'"]').data('position'), _id = $('tr[data-row="'+from+'"]').data('relate');
        dragsort(id,position,_id,from,to);
    });    
    
}
function dragsort(id,position,_id,from,to)
{
    $.ajax({url:fullUrl+'/dragsort',type:'post',data:{id:id,position:position,_id:_id,from:from,to:to, _token:$('input[name="_token"]').val()},dataType:'json',success:function(data){/*if(data==true){ if(confirm('Refresh to change the display effect.')==true){ location.reload();}}*/}})
}
$('#sort').on('click',function(){
    const $this = $(this), text = $this.html(); 
    if(text=='Sort'){ $this.html('Cancel'); }else{ $this.html($this.data('text')) }
    $('.handle').toggleClass('d-none'); 
    $('.no').toggleClass('d-none');
})
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
    const id =[$(this).data('id')]; if(id.length>0){ destroy(id) }
})
$('#delSelect').on('click',function(){
    const id = $('.ChkBox:checked').map(function(){ return $(this).val() }).get(); if(id.length>0){ destroy(id) }
})
function destroy(id)
{
    Swal.fire({
        title:"Do you want to delete the data?",
        text:"Once the data has been deleted, it cannot be recovered.",
        icon:"warning",
        showCancelButton:true,confirmButtonColor:"#DD6B55",showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(fullUrl+'/destroy?id[]='+id)
            .then(response => response.json())
            .then(data => location.reload())
            .catch(error => { Swal.showValidationMessage(`Request failed: ${error}`)})
        }
    });
}
var opContent = $('#option_content'),no = 0;
$('#addOp').on('click',function(){

    const type = $('input[name="type"]:checked').val(), 
          contentRow = $('<div class="row mb-4"></div>'),
          theme = {
              first : $('<div class="col-lg-12"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><input type="radio" name="OPfirst[]" ></div></div><input type="text" class="form-control"><div class="input-group-append"><button class="btn btn-outline-danger" type="button" name="first"><i class="fa fa-times"></i></button></div></div></div>'),
              second : $('<div class="col-lg-12"><div class="input-group mb-2"><div class="input-group-prepend"><span class="input-group-text">Option :</span></div><input type="text" class="form-control"><div class="input-group-append"><button class="btn btn-outline-danger" type="button" name="second"><i class="fa fa-times"></i></button></div></div></div></div>'),
          }

    if(typeof type !== typeof undefined){
        theme.first.find('input[type="text"]').attr('name','first['+no+']').attr('data-first',no)
        if(type=='first'){
            opContent.append(
                contentRow.append(theme.first)
            ).find('input[type="radio"]')
             .prop('checked',true);
        }else{
            const run = $('input[name="OPfirst[]"]:checked').parent().parent().parent().find('.form-control').data('first');
            if(typeof run !== typeof undefined){ theme.second.find('input[type="text"]').attr('name','option['+run+'][]'); }else{ theme.second.find('input[type="text"]').attr('name','option[]'); }
            $('input[name="OPfirst[]"]:checked').parent().parent().parent().parent().parent().append(
                theme.second
            )
        }
    }else{
        $('input[name="type"]')[0].focus();
    } 
    no++;          
})
if($('#formAdd').length>0)
{
    $(document).on('click','.btn-outline-danger',function(){
        const $this = $(this), type = $this.attr('name');
        if(typeof type !== typeof undefined){
            if(confirm('Confirm to delete?')){
                if(type=='first'){
                    $this.parent().parent().parent().parent().remove();
                }else{
                    $this.parent().parent().parent().remove();
                }
            }
        }
    })
}
if($('#formEdit').length>0)
{
    $(document).on('click','.btn-outline-danger',function(){
        const $this = $(this), id = $(this).parent().parent().find('input[name="opt_id[]"]').val();
        console.log($this)
        if(typeof id !== typeof undefined){ destroy(id) }else{ $this.parent().parent().parent().remove(); }
    }) 
}

