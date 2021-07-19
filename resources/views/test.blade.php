<!DOCTYPE html>
<html>
<head>
  <title></title>
  {{-- <link rel="stylesheet" href="//www.codermen.com/css/bootstrap.min.css"> --}}
  <script src="{{asset('back-end/build/jquery10.js')}}"></script>
  {{-- <script src="{{asset('back-end/build/jquery10.js')}}"></script> --}}
  {{-- <script src="back-end/build/jquery10.js"></script> --}}
  {{-- {{ HTML::script('back-end/build/jquery10.js') }} --}}
</head>
<body>

<div >
  <div >
   {{-- <div >Ajax dynamic dependent country state city dropdown using jquery ajax in Laravel 5.6</div> --}}
   <div >
      <div >
        <select id="country" name=category_id  >
        <option value="" selected disabled>Select</option>
         @foreach($countries as $key => $country)
         <option value="{{$key}}"> {{$country}}</option>
         @endforeach
         </select>
      </div>
      <div >
        <label for="title"></label>
        <select name=state id="state" >
        </select>
      </div>

      <div >
        <label for="title"></label>
        <select name=city id="city" >
        </select>
      </div>
   </div>
  </div>
</div>

<script>

</script>
<script type=text/javascript>
  $('#country').change(function(){
  var countryID = $(this).val();
  if(countryID){
    $.ajax({
      type:"GET",
      url:"{{url('get-state-list')}}?country_id="+countryID,
      success:function(res){
      if(res){
        $("#state").empty();
        $("#state").append('<option>Select</option>');
        $.each(res,function(key,value){
          $("#state").append('<option value="'+key+'">'+value+'</option>');
        });

      }else{
        $("#state").empty();
      }
      }
    });
  }else{
    $("#state").empty();
    $("#city").empty();
  }
  });
  $('#state').on('change',function(){
  var stateID = $(this).val();
  if(stateID){
    $.ajax({
      type:"GET",
      url:"{{url('get-city-list')}}?state_id="+stateID,
      success:function(res){
      if(res){
        $("#city").empty();
        $.each(res,function(key,value){
          $("#city").append('<option value="'+key+'">'+value+'</option>');
        });

      }else{
        $("#city").empty();
      }
      }
    });
  }else{
    $("#city").empty();
  }

  });
</script>
</body>
</html>
