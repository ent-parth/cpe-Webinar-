	// ajax function for like webinar
	function WebinarLike(webinar_id) {
		   $.ajax({
			   method: 'get',
			   url: 'course-like',
			   data: {
						webinar_id : webinar_id,
					},
			   headers: {
				   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			   },
		   }).then(function (data) {
			   if(data.msg == 'like') {
				  $('#herat_'+webinar_id).attr("src","front_side/images/icon-hart.png"); 
			   }else{
				  $('#herat_'+webinar_id).attr("src","front_side/images/icon-hart-default.png"); 
			   }
			  // document.getElementById('comment').value = '';
			  // $('.newscomment').html(data);
			   //$('#likeBtn_div_'+news_id).remove();
			   }).fail(function (data) {
				 //  $('#likeBtn_div_'+news_id).show();
		   });
	}  

	// ajax function for follow speaker
	function SpeakerFollow(speaker_id) {
		   $.ajax({
			   method: 'get',
			   url: 'speaker-follow',
			   data: {
						speaker_id : speaker_id,
					},
			   headers: {
				   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			   },
		   }).then(function (data) {
			   if(data.msg == 'follow') {
				  $('#follow_'+speaker_id).attr("src","images/icon-follow.png"); 
			   }else{
				  $('#follow'+speaker_id).attr("src","images/icon-unfollow.png"); 
			   }
			  // document.getElementById('comment').value = '';
			  // $('.newscomment').html(data);
			   //$('#likeBtn_div_'+news_id).remove();
			   }).fail(function (data) {
				 //  $('#likeBtn_div_'+news_id).show();
		   });
	}  
