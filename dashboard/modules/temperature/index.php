
<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

</style>
<!-- JS, Popper.js, and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>


$(document).ready(function(){
    
setInterval(function(){
  $.ajax({
      url: "getCurrentTemp.php", 
      success: function(result){
          
    $("#temData").html(result);
    
    
  }});
	// 3sec
},3000);
  
});

</script>
</head>
<body>


<div id="temData">
    
</div>

</body>
</html>
