var dataTable, parentRecord = false;
function successMessage(message) {
    new PNotify({
        text: message,
        type: 'success',
        addclass: 'bg-success border-success'
    });
}
function errorMessage(message) {
    new PNotify({
        text: message,
        type: 'danger',
        addclass: 'alert bg-danger border-danger alert-styled-right',
    });
}
$("body").on('click', '.delete-record', function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    if (parentRecord && parentRecord == true) {
        var message = "The record which you going to delete is currently in use. And if you delete this record then related all records will be delete. Are you sure, still you want to delete this record?";
    } else { 
        var message = "Are you sure you want to delete?";
    }
    $.confirm({
        'title': 'Confirm',
        'content': "<strong>" + message + "</strong>",
        theme: 'supervan',
        'buttons': {'Yes': {'class': 'special',
        'action': function(){
            if(url!='')
            {
                $.ajax({
                    url: url,
                    type: "GET",
                    beforeSend: function() {
                        $('.custom-loader').css('display', 'block');
                    },
                    dataType:'json',
                    success:function(data) {
                        if (data.success) {
                            successMessage(data.success);
                        } else {
                            errorMessage(data.error);
                        }
                        $('.custom-loader').css('display', 'none');
                        dataTable.draw();
                    }
                });
            }
    }},'No' : {'class'  : ''}}});
});
$("body").on('click', '#check-all', function(){
    var checked = this.checked
    $('.check-box').each(function(){
        this.checked = checked;
    });
});
$('body').on('click', '.delete-all', function(e){
    e.preventDefault();
    var arrId = new Array(), i = 0;
    $('.check-box').each(function(){
        if (this.checked) {
            arrId[i++] = $(this).val();
        }
    });
    if (arrId.length == 0) {
        $.confirm({
        'title': 'Confirm',
        'content': "<strong> Please select at least one record. </strong>",
        theme: 'supervan',
        'buttons': {'OK': {'class': 'special'}}
        });
        return;
    }
    var url = $(this).attr('href');
    if (parentRecord && parentRecord == true) {
        var message = "The record which you going to delete is currently in use. And if you delete this record then related all records will be delete. Are you sure, still you want to delete all records?";
    } else { 
        var message = "Are you sure you want to delete all selected record?";
    }
    $.confirm({
        'title': 'Confirm',
        'content': "<strong>" + message + "</strong>  ",
        theme: 'supervan',
        'buttons': {'Yes': {'class': 'special',
        'action': function(){
            if(url!='')
            {
                $.ajax({
                    url: url,
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    beforeSend: function() {
                        $('.custom-loader').css('display', 'block');
                    },
                    data: {id: arrId},
                    dataType:'json',
                    success:function(data) {
                        if (data.success) {
                             successMessage(data.success);
                             setTimeout(function(){location.reload();}, 600);
                        } else {
                            errorMessage(data.error);
                        }
                        $('.custom-loader').css('display', 'none');
                        dataTable.draw();
                    }
                });
            }
    }},'No' : {'class'  : ''}}});
});
$("body").on('click', '.delete-record-custom', function(e){ 
    e.preventDefault();
    var url = $(this).attr('href'); 
     $.confirm({
        'title': 'Confirm',
        'content': "<strong> Are you sure you want to delete? </strong>",
        theme: 'supervan',
        'buttons': {'Yes': {'class': 'special',
        'action': function(){
            if(url!='')
            {
                $.ajax({
                    url: url,
                    type: "GET",
                    headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
					}).then(function (data) { 
						window.location.reload();
					   }).fail(function (data) {
						   		   
				   	});
            }
    }},'No' : {'class'  : ''}}});
});
$("body").on('click', '#check-all', function(){
    var checked = this.checked
    $('.check-box').each(function(){
        this.checked = checked;
    });
});


<!--Speaker Custom auto status search-->
$('body').on('change', '#status', function(e){
	var status = $(this).val(); 
	var queries = {};
    $.each(document.location.search.substr(1).split('&'), function(c,q){
	    var i = q.split('=');
		if(i.length>1)
        queries[i[0].toString()] = unescape(i[1].toString()); // change escaped characters in actual format
    });

    // modify your parameter value and reload page using below two lines
    queries['status']=status;
    
	document.location.href="?"+$.param(queries); // it reload page
    //OR
    history.pushState({}, '', "?"+$.param(queries)); // it change url but not reload page		
	
});

$('body').on('change', '#webinar_type', function(e){
	var status = $(this).val(); 
	var queries = {};
    $.each(document.location.search.substr(1).split('&'), function(c,q){
	    var i = q.split('=');
		if(i.length>1)
        queries[i[0].toString()] = unescape(i[1].toString()); // change escaped characters in actual format
    });

    // modify your parameter value and reload page using below two lines
    queries['webinar_type']=status;
    
	document.location.href="?"+$.param(queries); // it reload page
    //OR
    history.pushState({}, '', "?"+$.param(queries)); // it change url but not reload page		
	
});