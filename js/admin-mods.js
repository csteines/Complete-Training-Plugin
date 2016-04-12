jQuery( document ).ready(function() {
    jQuery('input:radio[value=Tribe__Tickets_Plus__Commerce__WooCommerce__Main][id=ticket_provider]').prop('checked', true);
    jQuery('#tribe-tickets-hide-attendees-list').prop('checked', true);
    
    var rows = jQuery("tr.ticket");
    rows.eq(0).hide();
    
    
});
