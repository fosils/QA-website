
var pageProcess = function($,n,e,d,c,b,nn,en,dn,cn,ne,ee) {
  (function ($){
     var button = b;
     $(document).ready(function(){
			 (function(id){
			    id.change(function(){
					$('#hosted_button_id').val(button[this.value]);
				      });
			    $('#hosted_button_id').val(button[id.val()]);
			  })(c);
			 $('#paypalbutton').click(function(ev){
						    //validate
						    ev.preventDefault();
						    var error = [];
						    if (n[0].value == '') {
						      error.push(ne);
						      n.addClass('error');
						    }
						    else{
						      n.removeClass('error');
						    }
						    if (!e[0].value.match(/^[^@]+@[^@\.]+\.[^@]+$/)){
						      error.push(ee);
						      e.addClass('error');
						    }
						    else{
						      e.removeClass('error');
						    }
						    if(error.length){
						      $('#error_msg').html( error.join('<br />'));
						      return;
						    }
						    //ping to server
						    var data = {};
						    data[nn] = n.val();
						    data[en] = e.val();
						    data[dn] = d.val();
						    data[cn] = c.val();
						    $.ajax({
							     url:'index.php?q=question #searcharea>div',
							     type: 'POST',
							     data: data
							   }).done( function(){
								      $('#paypalform').submit();
								    });
						  });
		       });
   })(jQuery);
};
