var fullUrl = window.location.origin+'/webpanel/member';
var FULLURL="member";
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
function destroy(id)
{
    Swal.fire({
        title:"ลบข้อมูล",text:"คุณต้องการลบข้อมูลใช่หรือไม่?",icon:"warning",showCancelButton:true,confirmButtonColor:"#DD6B55",showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(fullUrl+'/destroy?id[]='+id)
            .then(response => response.json())
            .then(data => location.reload())
            .catch(error => { Swal.showValidationMessage(`Request failed: ${error}`)})
        }
    });
}
$('#position').on('change',function(){
    if($('option:selected',this).val()=='secondary'){ $('#_id').prop('selectedIndex',0).prop('disabled',false) }else{ $('#_id').prop('disabled',true) }
})
// tinymce.init({
//     selector: 'textarea.tiny',
//     menubar : false,
//     force_br_newlines : true,
//     force_p_newlines : false,
//     forced_root_block : '',
//     height: 600, 
//     //width : 1100,
//     plugins: ["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker","searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking","save table contextmenu directionality emoticons template paste textcolor colorpicker layer textpattern moxiemanager"],    
//     toolbar: 'insertfile undo redo | table | styleselect fontsizeselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | print nonbreaking hr emoticons code',
    
// });
$('.fa-eye').on('click',function(){
    $(this).toggleClass('password-show');
    if($(this).hasClass('password-show')){ $('#'+$(this).data('id')).attr('type','text'); }else{ $('#'+$(this).data('id')).attr('type','password'); }
});

// Form Validate
$('#signupForm').validate({
    ignore:[],
    rules:{
        name: 'required',
        phone: 'required',
        username: { 
            required: true, 
            email: true ,
            remote: { url:window.location.origin+'/webpanel/member/exist', type:"post", data:{ _token:$('input[name="_token"]').val() }, }
        },
        password: { required:true, minlength:6 },
        confirm_password: { required:true, minlength:6, equalTo:"#password" },
    },
    messages:{
        confirm_password:{ equalTo: "Password mismatch" },
        username:{ remote: "Username is Existing" },
    },
    errorPlacement : function(error,element){
        if(element.parent().hasClass('input-group'))
        { 
            error.insertAfter(element.parent()) 
        }else{ 
            error.insertAfter(element) 
        }
    },
});

$('#new_username').on('click',function(el){
    if($(this).is(':checked')){ 
        $('#username').prop('disabled',false) 
    }else{  
        $('#username').removeClass('error').prop('disabled',true).val(''); 
        $('#'+$('#username').attr('id')+'-error').remove();
    }
});
$('#resetForm').validate({
    ignore:[],
    rules:{
        username: { 
            required: function(){ if($('#new_username').is(':checked')){ return true }else{ return false }},
            email: true,
            remote: { url: window.location.origin+'/webpanel/member/exist-on-reset', type:"get" }
        },
        password: { required:true, minlength:6 },
        confirm_password: { required:true, minlength:6, equalTo:"#password" },
    },
    messages:{
        confirm_password:{ equalTo: "Password mismatch" },
        username:{ remote: "Username is Existing" },
    },
    errorPlacement : function(error,element){
        if(element.parent().hasClass('input-group'))
        { 
            error.insertAfter(element.parent()) 
        }else{ 
            error.insertAfter(element) 
        }
    },
});

$(document).on('change','.provinces',function(){
    const val= $(this).val();
    const id = $(this).data("id");
    $.get(FULLURL+'/getdistrict',{id:val})
    .done(function(data){
  
        $('#district'+id).html('<option value="" hidden>กรุณาเลือก</option>')  
        $('#district'+id).append(data)
    })
})


$(document).on('change','.district',function(){
    const val= $(this).val();
    const id = $(this).data("id");

    $.get(FULLURL+'/getsubdistrict',{id:val})
    .done(function(data){
        $('#subdistrict'+id).html('<option value="" hidden>กรุณาเลือก</option>')
        $('#subdistrict'+id).append(data)
    })
})
$(document).on('change','.subdistrict',function(){
    const id = $(this).data("id");
    const zipcode= $('option:selected',this).data("postcode");
    $('#postcode'+id).html('')
    $('#postcode'+id).val(zipcode)
})
$('#add-address').click(function(){
    addAddress()
})
function addAddress(){
    const datetime = new Date;
    const id = datetime.getTime();
    var provinces
    $.get(FULLURL+'/getprovinces',function(data){

        var addressContent ='	<div class"clearfix"></div><div class="col-lg-12 col-md-6">\
        <hr/><div class="form-group">\
            <textarea name="address[]" id="address" autocomplete="off" type="text" rows="3" class="form-control" placeholder="ที่อยู่"></textarea>\
        </div>\
        </div>\
        <div class="col-lg-6 col-md-6">\
        <div class="form-group">\
            <select name="provinces[]" class="form-control provinces" id="provinces'+id+'" data-id="'+id+'">\
                <option value=""hidden>กรุณาเลือก</option>'+data+'\
            </select>\
        </div>\
        </div>\
        <div class="col-lg-6 col-md-5">\
        <div class="form-group">\
            <select name="district[]" class="form-control district" id="district'+id+'" data-id="'+id+'">\
                <option value="">กรุณาเลือก</option>\
            </select>\
        </div>\
        </div>\
        <div class="col-lg-6 col-md-5">\
        <select name="subdistrict[]" class="form-control subdistrict" id="subdistrict'+id+'" data-id="'+id+'">\
            <option value="">กรุณาเลือก</option>\
        </select>\
        </div>\
        <div class="col-lg-6 col-md-5">\
        <div class="form-group">\
            <input name="postcode[]" id="postcode'+id+'" type="text" class="form-control" placeholder="รหัสไปรษณีย์">\
        </div>\
        </div>';
        $('#address-content').append(addressContent)
    });
}