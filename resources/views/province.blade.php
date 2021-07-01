<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
    border:1px solid #ccc;
   }
  </style>
</head>
<body>
    <div class="container box">
        <h3 align="center">ทดสอบ</h3><br />
        <div class="form-group">
         <select name="province" id="province" class="form-control province" >
          <option value="">ชื่อโปรเจค</option>
          @foreach ($list as $row)
          <option value="{{ $row->id }}">{{ $row->name }}</option>
          @endforeach
         </select>
        </div>

        <div class="form-group">
            <select name="province" class="form-control amphures" >
             <option value="">ประเภทการขนส่ง</option>
            </select>
           </div>
    </div>
         {{ csrf_field() }}
</body>

<script>
    $('.province').change(function(){
        var select=$(this).val();
        var _token=$('input[name="_token"]').val();

        $.ajax({
            url:"{{ Route ('droupdown.fetch') }}",
            method:"POST",
            data:{select:select,_token:_token},
            success:function(result){
                $('.amphures').html(result);
            }

        })
    });
</script>

</html>
