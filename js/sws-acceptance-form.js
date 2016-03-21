jQuery( document ).ready(function() {
	var height = jQuery(window).height() * 0.90;
	if(height < 340){height = 340;}
	var body_height = height - 295; 
	
	jQuery('#AcceptanceForm .modal-content').height(height+'px');
	jQuery('#AcceptanceForm .modal-body').height(body_height+'px');

    jQuery(window).on('resize', function(){
    	var height = jQuery(window).height() * 0.90;
    	if(height <= 340){height = 340;}
    	var body_height = height - 295;
	    jQuery('#AcceptanceForm .modal-content').height(height+'px');
	    jQuery('#AcceptanceForm .modal-body').height(body_height+'px');
	    centerModals();
    });
    
    /* center modal */
    function centerModals(){
        jQuery('.modal').each(function(i){
          var $clone = jQuery(this).clone().css('display', 'block').appendTo('body');
          var top = Math.round(($clone.height() - $clone.find('.modal-content').height()) / 2);
          top = top > 0 ? top : 0;
          $clone.remove();
          jQuery(this).find('.modal-content').css("margin-top", top);

          clearDecline();
        });
    }
    jQuery('.modal').on('show.bs.modal', centerModals);
    //jQuery(window).on('resize', centerModals);

    //Clear Decline Reason and remove error class
    function clearDecline(){
            jQuery('#decline_reason').removeClass("inputError", 700);
            jQuery('#decline_reason').val("");
    }

    //On Confirm Decline Button Push
    jQuery('#DeclineForm #submit').click(function(){
            var postid = jQuery('#inst_view_postid').text();
            if(jQuery('#decline_reason').val() == "" ){jQuery('#decline_reason').addClass("inputError", 700);}
    });

	
	
	
	
});