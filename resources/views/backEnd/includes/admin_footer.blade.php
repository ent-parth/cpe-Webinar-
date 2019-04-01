<div class="pull-right hidden-xs">
<!-- <b>Version</b> 2.4.0 -->
</div>
<strong>Copyright &copy; <?php echo date("Y"); ?> <!-- <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
reserved. -->

<script type="text/javascript">
function AdminNotification(id,link) {
		   $.ajax({
			   method: 'get',
			   url: '/admin_notification',
			   data: {
						id : id,
						link : link,
					},
			   headers: {
				   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			   },
		   }).then(function (data) {

			if(data.link == 'nolink'){
			  	$('#'+data.id).hide();
			  	$('#notification_count').text(data.notification_count);
			  	if(data.notification_count == 0){
				  	$('#message_li').hide();
			  	}
			  	
			  }else{

			  	window.location.href = data.link;
			  }
			  // document.getElementById('comment').value = '';
			  // $('.newscomment').html(data);
			   //$('#likeBtn_div_'+news_id).remove();
			   }).fail(function (data) {
			   	alert('fail')
				 //  $('#likeBtn_div_'+news_id).show();
		   });
	}  

</script>
