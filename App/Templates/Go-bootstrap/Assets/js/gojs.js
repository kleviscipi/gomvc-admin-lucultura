
var Request={
	
	init:function(conf){
		// init codes
		this.conf = conf;
	},
	callPost:function(link,data,callback,text){
	  $.ajax({

			url:link,
			type:'POST',
			data:data,
			dataType:'json',
			success:function(response){
				Request.successView(text);
				setTimeout( function(){
					Request.hidesuccessView();
				}, 10000);
				callback(response);			
			},
			error: function() {
            	Request.errorView('Error......genereting');
 				setTimeout( function(){
					Request.hideerrorView();
				}, 10000);           	

       		 }

		});

		 

	},
	callGet:function(link,data,callback,text){
		$.ajax({
			url:link,
			type:'GET',
			data:data,
			dataType:'json',
			success:function(response){
				Request.successView(text);
				setTimeout( function(){
					hideAlert(msgbox);
				}, 10000);

				callback(response);
			},
			error:function(){
				Request.errorView('Error......genereting');
				 setTimeout( function(){
					Request.hideerrorView();
				}, 10000); 
			}
		});

	},
	errorView:function(text){
		self = Request;

		self.conf.diverror.css({
			'position'	:'absolute',
			'right'		:'5px',
			'bottom'	:'10px',
			'width'		:'auto',
			'border'	:'1px solid  red',
			'padding'	:'10px 8px',
			'color'		:'red',
			'font-family':'serif'

		});
		self.conf.diverror.html(text);
	},
	hideerrorView:function(){
		self = Request;

		self.conf.diverror.css({
			'display'	:'none',
		});
	},
	successView:function(text){
		self = Request;

			self.conf.diverror.css({
				'position'	:'absolute',
				'right'		:'5px',
				'bottom'	:'10px',
				'width'		:'auto',
				'border'	:'1px solid  green',
				'padding'	:'10px 8px',
				'color'		:'green',
				'font-family':'serif'


			});
			self.conf.diverror.html(text);
	},
	hidesuccessView:function(){
		self = Request;

		self.conf.diverror.css({
			'display'	:'none',
		});
	},
	check:function(input){
		///
	}



}

Request.init({
	diverror:$('#error_ajax'),

});

