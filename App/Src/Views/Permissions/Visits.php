<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;
use Go\Crypt as Crypt;
/***********************************
* 2016-11-16                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/


?>
<h1>Visits</h1>
<hr>
<div class="row-fluid">
<div class="span6">
		<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-time"></i></span>
            <h5>List of visits</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>IP</th>
                  <th>Broswer</th>
                  <th>Status Ip</th>
                </tr>
              </thead>
              <tbody id="contentvisits"></tbody>
            </table>
          </div>
        </div>	
</div>
</div>


<script type="text/javascript">
$(document).ready(function(){

  var Visits={
    init:function(conf){
      this.conf = conf;
      this.events();
      this.visits();
    },
    events:function(){
    	this.conf.updateip.live('click',function(){
    		value=$(this).data('value');
    		id 	 =$(this).data('id');
    		Visits.updateip(value,id);
    	});
    },
    visits:function(){
    	var html = "",self = Visits;
    	post = "";
    	Request.dataPost('/Api/Permissions/visits',post,function(response){
    		console.log(response.data);
    		data = response.data;
    		length = Object.keys(data).length;
    		for (var i = length - 1; i >= 0; i--) {
    			if(data[i].state){
    				cl = "done";
    				txt = "Permited";
    				state ="false";
    			}else{
     				cl = "pending";
    				txt = "Blocked"; 
    				state ="true";  				
    			}

	    		html +='<tr>'
	                  +'<td class="taskDesc"><i class="icon-info-sign"></i>'+data[i].ip+'</td>'
	                  +'<td class="taskDesc"><i class="icon-info-sign"></i>'+data[i].broswer+'</td>'
	                  +'<td class="taskStatus"><span data-id="'+data[i].id+'" data-value="'+state+'" id="updateip" style="cursor:pointer" class="'+cl+'">'+txt+'</span></td>'
	                +'</tr>';  
	                self.conf.contentvisits.html(html);  			
    		}

    		
    	});
    },
    updateip:function(val,id){
    	post ="&state="+val;
    	post +="&id="+id;
    	Request.callPost('/Api/Permissions/updateip',post,function(response){
    		Visits.visits();
    	});
    }
}
  Visits.init({
  	contentvisits: $('#contentvisits'),
  	updateip: $('#updateip')
  });
});
</script>