<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>change demo</title>
  <style>
  div {
    color: red;
  }
  </style>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
 
<select name="sweets" id="customer">
  <option>Chocolate</option>
  <option selected="selected">Candy</option>
  <option>Taffy</option>
  <option>Caramel</option>
  <option>Fudge</option>
  <option>Cookie</option>
</select>
<div>
      <input name="tes" type="text" id="tes">
      <label id=""></label>
</div>
 
<script>
$( "#customer" )
  .change(function () {
    var str = "";
    $( "select option:selected" ).each(function() {
      str += $( this ).text() + " ";
    });
    $( "#tes" ).val( str );
  })
  .change();
</script>
 
</body>
</html>