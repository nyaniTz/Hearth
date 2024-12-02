<!DOCTYPE html>
<html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<body>
    <div id="graphData">
        
    </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>


$(document).ready(function(){
    $.ajax({
      type: "POST",
      url: "getTempRecord.php?UName=<?php echo $_REQUEST['UName']; ?>", 
      
      success: function(result){
          
    $("#graphData").html(result);
    
    
  }});
    
setInterval(function(){
  $.ajax({
      type: "POST",
      url: "getTempRecord.php", 
      data:{
          UName:"<?php echo $_REQUEST['UName']; ?>",
      },
      success: function(result){
          
    $("#graphData").html(result);
    
    
  }});
	// 3sec
},5000);
  
});

</script>

</body>
</html>