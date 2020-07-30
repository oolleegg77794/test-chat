<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
	<title>Chat</title>

  <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">Chat</h5>


    <div class="dropdown" style="margin-right: 40px;">
<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    All users
  </a>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

        <?php
      $errors = "";
      $link = mysqli_connect('localhost', 'root', '','chat') 
      or die("Ошибка " . mysqli_error($link));
      $query ="SELECT name, count(*)  FROM chats GROUP BY `name`";
      $result = mysqli_query($link, $query) or die("Ошибка" . mysqli_error($link)); 
    
      $rows = mysqli_num_rows($result); // количество полученных строк
      for ($i = 1 ; $i <= $rows ; ++$i)
      {
        $row = mysqli_fetch_array($result);?>
        <a class="dropdown-item" href="#"><?php echo $row['name'];?></a>
      <?php }
      mysqli_close($link);?>

      </div>
    </div>

  </div>
</head>

<body>


	<div id="messages"></div>
	<form>
		<input type="text" id="message" autocomplete="off" autofocus="" placeholder="Type message...">
		<input type="submit" value="Send">
	</form>
	 
</body>



<script type="text/javascript">

var name = null, start = 1, url = "chat.php";

    $(document).ready(function(){
      name = prompt("Please enter your name");

      if (name != '') {ding();}

      console.log(name)  
      $('form').submit(function(){
      	message = $('#message').val();
        $.post(
        	url, 
        {
        	message:message,
          name: name
        });
        $('#message').val('');

        return false;
      })
    })

    function ding(){
      $('#messages').append(renderNotification(name));
    }

    

    function load(){
    	$.get(url + '?start=' + start, function(result){
    		if (result.items){
    			result.items.forEach(item =>{
	    			start = item.id;
	    			$('#messages').append(renderMessage(item));
    			});		
    		  $('#messages').animate({scrollTop:$('#messages')[0].scrollHeight});
        };
    		load();		
    	});
    }
    
    function renderMessage(item){
    	console.log(item)
      let time = new Date(item.created);
      time = `${time.getHours()}:${time.getMinutes() < 10 ?'0': ''}${time.getMinutes()}`
    	return `<div class="msg"><p>${item.name}</p>${item.message}<span>${time}</span></div>`
    }

    function renderNotification(name){
      console.log(name)
      return `<div class="alert alert-primary" role="alert">User ${name} entered  chat</div>`
    }

  load();  
	
</script>



