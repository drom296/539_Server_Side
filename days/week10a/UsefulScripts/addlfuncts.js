jQuery.download = function(url, data, method){
	//url and data options required
	if( url && data ){ 
		//data can be string of parameters or array/object
		data = typeof data == 'string' ? data : jQuery.param(data);
		//split params into form inputs
		var inputs = '';
		jQuery.each(data.split('&'), function(){ 
			var pair = this.split('=');
			inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />'; 
		});
		
		//send request
		jQuery('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>')
		.appendTo('body').submit().remove();
	};
};

function processUpload() {
		//starting setting some animation when the ajax starts and completes
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});
		
		/*
			prepareing ajax file upload
			url: the url of script file handling the uploaded files
                        fileElementId: the file type of input element id and it will be the index of  $_FILES Array()
			dataType: it support json, xml
			secureuri:use secure protocol
			success: call back function when the ajax complete
			error: callback function when the ajax failed
			
                */
		$.ajaxFileUpload
		(
			{
				url:'upload.php', 
				secureuri:false,
				fileElementId:'uploaded_file',
				dataType: 'json',
        		beforeSend:function()
				{
					$("#loading").show();
				},
				complete:function()
				{
					$("#loading").hide();
				},			
        success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							alert(data.msg);
						}
					}
					else {
            alert("Some other issue: "+data.msg+ " "+data.error + " "+status);
          }
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

} //processUpload