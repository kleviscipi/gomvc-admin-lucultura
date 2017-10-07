
var Request={
	
	init:function(conf){
		// init codes
		this.conf = conf;
		this.conf.language.on('click',function(){
			action = $(this).data('action');
			value = $(this).data('value');
			if(action == "language"){
				Request.language(value);
			}
		});
		this.notifications();
		this.search();
	},
	callPost:function(link,data,callback,message,title='Notice',text=false){
	  data +='&key='+key; // key secret for call
	  data +='&work=action'; // key action for no session
	  $.ajax({

			url:link,
			type:'POST',
			data:data,
			dataType:'json',
			success:function(response){
				if(typeof response == "undefined" || response ==null){
					Request.gritererror('Notice for developers',"Json data is empty or is undefined on api!");
					return false;
				}
				if(text){
					Request.successView(message);
					setTimeout( function(){
						hideAlert(msgbox);
					}, 10000);
				}else{
					if(response.error < 1){
						if(response.sms == '' || typeof response.sms=='undefined'){
							console.log('Response sms is empty insert: inset on php $response["sms"] = "somthing"');
						}else{
							Request.gritersuccess(title,response.sms);

						}
					}else{
						if(response.sms == '' || typeof response.sms=='undefined'){
							console.log('Response sms is empty insert: inset on php $response["sms"] = "somthing"');

						}else{
							Request.gritererror(title,response.sms);

						}
					}
						
				}
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
	callGet:function(link,data,callback,message,title='Notice',text=false){
	    data +='&key='+key; // key secret for call
	    data +='&work=action'; // key action for no session
		$.ajax({
			url:link,
			type:'GET',
			data:data,
			dataType:'json',
			success:function(response){
				if(typeof response == "undefined" || response ==null){
					Request.gritererror('Notice for developers',"Json data is empty or is undefined on api!");
					return false;
				}
				if(text){
					Request.successView(message);
					setTimeout( function(){
						hideAlert(msgbox);
					}, 10000);
				}else{
					if(response.error < 1){
						if(response.sms == '' || typeof response.sms=='undefined'){
							console.log('Response sms is empty insert: inset on php $response["sms"] = "somthing"');
						}else{
							Request.gritersuccess(title,response.sms);

						}
					}else{
						if(response.sms == '' || typeof response.sms=='undefined'){
							console.log('Response sms is empty insert: inset on php $response["sms"] = "somthing"');

						}else{
							Request.gritererror(title,response.sms);

						}
					}
				}
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
	dataGet:function(link,data='',callback){
	    data +='&key='+key; // key secret for call

		$.ajax({
			url:link,
			type:'GET',
			data:data,
			dataType:'json',
			success:function(response){
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
	dataPost:function(link,data='',callback){
	    data +='&key='+key; // key secret for call

		$.ajax({
			url:link,
			type:'POST',
			data:data,
			dataType:'json',
			success:function(response){
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
	gritersuccess:function(title,text){
		$.gritter.add({
			title:	title,
			text:	text,
			sticky: false,
			class_name:'gritter-success'
		});
	},
	gritererror:function(title,text){
		$.gritter.add({
			title:	title,
			text:	text,
			sticky: false,
		});
	},
	input:function(id,type = true){
		if(type){
			$('#'+id).css('border','1px solid red');
		}else{
			$('#'+id).css('border','');
		}
	},
	check:function(input){
		if(input == ''){
			return false;
		}else{
			return true;
		}
	},
	checkemail:function(input){
  		var regex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
  		return regex.test(input);
	},
	session:function(session){
		
	},
	deletealert:function(id,data,content,text = ''){
		var html = "";
		if(!text==''){
			text = text;
		}else{
			text = "Are you sure?";
		}
		if(data && id && content){
			html +='<div style="position:absolute;right:1px;margin-top:-31px;" class="alert alert-error">'
			+'<strong>Notice!</strong>  '+text+'  <a href="#" id="'+id+'" data-content="'+content+'"  data-action="'+data+'" class="btn btn-danger btn-mini">Delete</a> <button class="btn btn-inverse btn-mini" data-dismiss="alert">Close</button></div>';
			$('#'+content).append(html);

		}

	},
	cleardelete:function(content){
		$('#'+content).empty();
	},
	redirect:function(link='',speeds=''){
		if(link == '' || typeof link == "undefined"){
			link ="/";	
		}else{
			link = link;
		}
		if(speeds == '' || typeof link == "undefined"){
			speeds =3000;	
		}else{
			speeds = speeds;
		}
        window.setTimeout(function() {
            window.location.href = link;
        }, speeds);
	},
	logout:function(link=''){
		if(link == '' || typeof link == "undefined"){
			link ="/Admin/login";	
		}else{
			link = link;
		}
		post ='';
	    Request.callPost('/Api/Admin/logout',post,function(response){
	        if(response.error < 1){
	        	Request.gritersuccess(response.title,response.body);
	            Request.redirect(link,2000);
	        }
	    });

	},
	language:function(value = ''){
		if(!value == "" && value =="it" || value == "en"){
			post = "&value="+value;
			post +="&from=login";
		}else{
			post ='';
		}

	    Request.callPost('/Api/Admin/language',post,function(response){
	        if(response.error < 1){
	        	Request.redirect('/',2000);
	        }
	    });
	},
	notifications:function(){
		var self  = Request;
		if(self.conf.notifications.data('superuser') > 0){
			post ='';
		    Request.dataPost('/Api/Admin/notifications',post,function(response){
		        if(response.error < 1){
		        	self.conf.countnotice.html(response.count);
		        	if(response.count > 0){
						$.gritter.add({
							title:	response.title,
							text:	response.sms,
							image: 	'/Templates/Matrix/Assets/img/demo/envelope.png',
							sticky: false
						});	
		        	}
		        }
		    });
		}
	},
	search(){
		var self = Request,html = "";
		var htmlauthor  ="";
		var htmlbooks	="";
		var htmlmovies  ="";
		var htmlactors	="";
		var htmlpages	="";
		var htmlmore	="";
		var htmlsearch	="";
		self.conf.lusearch.on('click',function(){
        	$(this).animate({ width: 350 });			
		});

		self.conf.lusearch.live('keyup',function(){
			val = $(this).val();
			if(!val == ""){
				$("#contenuto").css("display","block");

			}else{
				$("#contenuto").css("display","none");
			}
			post ='&words='+val;
		    Request.dataPost('/Api/Admin/search',post,function(response){
		        if(response.error < 1){
		        	datas =response.data;
					
		        	if(!datas == "" || !datas == null){
		        		
		        		if(!datas.actors == "" || !datas.actors ==null){
			        		lengthdatas = Object.keys(datas.actors).length;

			        		htmlactors = '<div class="widget-title">'
							        +'<h5>Actors</h5>'
							        +'</div>'
							        +'<div class="widget-content nopadding">'
							         +'<ul class="recent-posts">'
			        		for (var i = lengthdatas - 1; i >= 0; i--) {
							        htmlactors +='<li>'
							              +'<div class="user-thumb"><img style="height:48px !important;width:40px" alt="'+datas.actors[i].name+'" src="'+datas.actors[i].image+'"></div>'
							              +'<div class="article-post">'
							                +'<div class="fr"><a  id="'+datas.actors[i].idm_id+'" data-redirect="actorlucultura" class="btn btn-primary btn-mini">View</a><a id="'+datas.actors[i].idm_id+'" data-redirect="actoronsite" class="btn btn-inverse btn-mini">Origin</a></div>'
							                +'<span class="user-info">'+datas.actors[i].name+'</span>'
							                +'<p><a>'+datas.actors[i].ocupation.replace('{', '').replace('}', '')+'</a> </p>'
							              +'</div>'
							            +'</li>'

			            	self.conf.actorscontenuto.html(htmlactors);
		
			        		}
		        			htmlactors +='</ul></div>';
		        			self.conf.actorscontenuto.html(htmlactors);
		        		}else{
		        			htmlactors = "";
		        			self.conf.actorscontenuto.html(htmlactors);
		        		}
		        		if(!datas.movies == "" || !datas.movies ==null){
			        		lengthmovie = Object.keys(datas.movies).length;
			        		htmlmovies = '<div class="widget-title">'
							        +'<h5>Movies</h5>'
							        +'</div>'
							        +'<div class="widget-content nopadding">'
							         +'<ul class="recent-posts">'
			        		for (var i = lengthmovie - 1; i >= 0; i--) {
							    htmlmovies +='<li>'
							              +'<div class="user-thumb"><img style="height:48px !important;width:40px" alt="'+datas.movies[i].title+'" src="'+datas.movies[i].image+'"></div>'
							              +'<div class="article-post">'
							                +'<div class="fr"><a id="'+datas.movies[i].id+'" data-redirect="movielucultura" class="btn btn-primary btn-mini">View</a><a id="'+datas.movies[i].idm_id+'" data-redirect="movieonsite" class="btn btn-inverse btn-mini">Origin</a></div>'
							                +'<span class="user-info">'+datas.movies[i].title+ ' / '+datas.movies[i].released+'</span>'
							                +'<p><a>'+datas.movies[i].genres.replace('{', '').replace('}', '')+'</a> </p>'
							              +'</div>'
							            +'</li>'		            	
			            	self.conf.moviescontenuto.html(htmlmovies);
					        		}
			        			html +='</ul></div>';
	        				self.conf.moviescontenuto.html(htmlmovies);
		        		}else{
		        			htmlmovies = "";
		        			self.conf.moviescontenuto.html(htmlmovies);
		        		}
		        		if(!datas.authors == "" || !datas.authors ==null){
			        		lengthauthors = Object.keys(datas.authors).length;
			        		htmlauthor = '<div class="widget-title">'
							        +'<h5>Authors of Books</h5>'
							        +'</div>'
							        +'<div class="widget-content nopadding">'
							         +'<ul class="recent-posts">'
			        		for (var i = lengthauthors - 1; i >= 0; i--) {
							        htmlauthor +='<li>'
							              +'<div class="article-post">'
							                +'<div class="fr"><a  id="'+datas.authors[i].id+'" data-redirect="authorlucultura" class="btn btn-primary btn-mini">View</a></div>'
							                +'<span class="user-info">'+datas.authors[i].fullname+' </span>'
							              +'</div>'
							            +'</li>'		            	
			            	self.conf.authorscontenuto.html(htmlauthor);
					        		}
			        			htmlauthor +='</ul></div>';
			        			self.conf.authorscontenuto.html(htmlauthor);
	        				
		        		}else{
		        			htmlauthor = "";
		        			self.conf.moviescontenuto.html(htmlauthor);
		        		}
		        		if(!datas.books == "" || !datas.books ==null){
			        		lengthbooks = Object.keys(datas.books).length;
			        		htmlbooks = '<div class="widget-title">'
							        +'<h5>Books</h5>'
							        +'</div>'
							        +'<div class="widget-content nopadding">'
							         +'<ul class="recent-posts">'
			        		for (var i = lengthbooks - 1; i >= 0; i--) {
									    htmlbooks +='<li>'
							              +'<div class="user-thumb"><img style="height:48px !important;width:40px" alt="User" src="'+datas.books[i].image+'"></div>'
							              +'<div class="article-post">'
							                +'<div class="fr"><a  id="'+datas.books[i].google_id+'" data-redirect="booklucultura" class="btn btn-primary btn-mini">View</a><a  id="'+datas.books[i].previewlink+'" data-redirect="bookonsite"  class="btn btn-inverse btn-mini">Origin</a></div>'
							                +'<span class="user-info">'+datas.books[i].title+'/ '+datas.books[i].title+' </span>'
							                +'<p><a>'+datas.books[i].categories.replace('{', '').replace('}', '')+'</a> </p>'
							              +'</div>'
							            +'</li>'		            	
			            		self.conf.bookscontenuto.html(htmlbooks);
					        		}
			        			html +='</ul></div>';
			        			self.conf.bookscontenuto.html(htmlbooks);
	        				
		        		}else{
		        			htmlbooks = "";
		        			self.conf.bookscontenuto.html(htmlbooks);
		        		}
		        		if(!datas.pages == "" || !datas.pages ==null){
			        		lengthpages = Object.keys(datas.pages).length;
			        		htmlpages += '<div class="widget-title">'
							        +'<h5>Pages and Links</h5>'
							        +'</div>'
							        +'<div class="widget-content nopadding">'
							         +'<ul class="recent-posts">'
			        		for (var i = lengthpages - 1; i >= 0; i--) {
									    htmlpages +='<li>'
							              +'<div class="article-post">'
							                +'<div class="fr"><a href="/'+datas.pages[i].controller+'/'+datas.pages[i].method+'" class="btn btn-inverse btn-mini">Go to Page</a></div>'
							                +'<span class="user-info">'+datas.pages[i].controller+'/'+datas.pages[i].method+' </span>'
							              +'</div>'
							            +'</li>'		            	
			            				self.conf.pagescontenuto.html(htmlpages);
					        		}
			        			htmlpages ='</ul></div>';
			        			self.conf.pagescontenuto.html(htmlpages);
	        				
		        		}else{
		        			htmlpages = "";
		        			self.conf.pagescontenuto.html(htmlpages);
		        		}
		        			htmlsearch='<div id="searchclose" style="cursor:pointer;position: absolute;right: 2px;padding: 2px 12px;background: red;color:white;font-style: oblique;top: 1px;">X</div>'
        					self.conf.closecontenuto.html(htmlsearch);
	        			    htmlmore ='<div class="widget-content nopadding">'
						             +'<ul class="recent-posts">'
						               +'<li>'
						                +'<button id="searchsall"  class="btn btn-warning btn-mini">View All</button>'
						              +'</li>'
						            +'</ul>'
						        +'</div>'
						self.conf.morecontenuto.html(htmlmore);
		        	}else{
		        		htmlpages  ="";
		        		htmlbooks  = "";
		        		htmlmovies ="";
		        		htmlactors ="";
		        		htmlauthor = "";
		        		htmlmore 	= "";  
						self.conf.morecontenuto.html(htmlmore);
						self.conf.moviescontenuto.html(htmlmovies);
						self.conf.actorscontenuto.html(htmlactors);
						self.conf.bookscontenuto.html(htmlbooks);
						self.conf.pagescontenuto.html(htmlpages);
						self.conf.authorscontenuto.html(htmlauthor);

		      		  }

		        }
		    });			
		});
		$('#searchclose').live('click',function(){
			$('#contenuto').css("display","none");
        	 self.conf.lusearch.animate({ width: 100 }).val("");			
		});
		$('#typesearchs').on('click',function(){
			window.location="/Admin/Search/?&rf_words="+val;   
		});
		$('#searchsall').live('click',function(){
			window.location="/Admin/Search/?&rf_words="+val;   
		});
		$('.mysearchbutton').on('click',function(){
			var myval;
			myval =$('.mysearch').val();
			window.location="/Admin/Search/?&rf_words="+myval;   
		});
	}

}

Request.init({
	diverror:$('#error_ajax'),
	language:$('#setlanguage a'),
	notifications:$('#menu-messages'),
	countnotice:$('#countnotice'),
	lusearch:$('#lusearch'),
	contenuto: $('#contenuto'),
	bookscontenuto 		: $('#bookscontenuto'),
	authorscontenuto 	: $('#authorscontenuto'),
	moviescontenuto 	: $('#moviescontenuto'),
	actorscontenuto 	: $('#actorscontenuto'),
	pagescontenuto 		: $('#pagescontenuto'),
	morecontenuto 		: $('#morecontenuto'),
	closecontenuto		: $('#closecontenuto')

});

