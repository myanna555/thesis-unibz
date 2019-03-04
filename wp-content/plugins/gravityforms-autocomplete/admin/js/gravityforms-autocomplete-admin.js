jQuery(function($) {
   
    /*$.each( l35.sources, function( key, value ) {
           
            $('.gform_autocomplete.auto.'+key).each(function(){
                var el = $(this);
                el.select2({
                      minimumInputLength : 3,
                      ajax: {
                        url: l35.ajaxurl,
                        dataType: 'json',
                        data: function (params) {
                          var query = {
                            action: 'ga_get_choices_ajax',
                            query: params.term,
                            type: key
                          }

                          return query;
                        }
                      }
                });
            });
    });*/
    
    
    /*if ($('.gform_autocomplete.manual').length > 0){
        $('.gform_autocomplete.manual').each(function(){
             var el = $(this),
             choices = $(this).data('choices');
             
             
             el.select2({
                minimumInputLength : 3,
                createTag: function (params) {
                    var term = $.trim(params.term);

                    if (term === '') {
                      return null;
                    }

                    return {
                      id: term,
                      text: term,
                      newTag: true
                    }
                },
                templateResult: function (data) {
                    var $result = $("<span></span>");

                    $result.text(data.text);

                    if (data.newTag) {
                      $result.append(" <em>(new)</em>");
                    }

                    return $result;
                }, 
                data: choices
             });   
            
        });    
    }*/
    
    /*if ($('.gform_autocomplete.ajax').length > 0){
        $('.gform_autocomplete.ajax').each(function(){
             var el = $(this);
             el.select2({
                minimumInputLength : 3,
                ajax: {
                    url: l35.ajaxurl,
                    dataType: 'json',
                    data: function (params) {
                      var query = {
                        action: 'ga_get_choices_ajax',
                        query: params.term,
                        type: 'json',
                        delay: 250,
                        'url' : el.data('ajax')
                      }

                      return query;
                    }
                }
             });   
            
        });    
    }*/

});


var placeSearch, google_autocomplete = [];
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    //var autocomplete_id = jQuery('.gform_autocomplete.autocomplete_search_line input').attr('id');
    
    jQuery('.gform_autocomplete.autocomplete_search_line input').each(function(){
        var autocomplete_id = jQuery(this).attr('id'); 
        var google_autocomplete_item = new google.maps.places.Autocomplete(/** @type {!HTMLInputElement} */(document.getElementById(autocomplete_id)), {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        google_autocomplete_item.addListener('place_changed', function(){
            fillInAddress(autocomplete_id, google_autocomplete_item);
        });
        
        google_autocomplete.push(google_autocomplete_item);  
    });

    //google_autocomplete = new google.maps.places.Autocomplete(/** @type {!HTMLInputElement} */(//document.getElementById(autocomplete_id)), {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    //google_autocomplete.addListener('place_changed', fillInAddress);

 
}


function fillInAddress(autocomplete_id, google_autocomplete_item) {
    
    var gform_autocomplete_container = jQuery('input[id="' + autocomplete_id + '"]').parents('.gform_autocomplete_container');
    var place = google_autocomplete_item.getPlace();
    
    var street_number = '';
    var street_name = '';
    
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        var long_name = place.address_components[i].long_name;
        var short_name = place.address_components[i].short_name;
        
        if(addressType === 'street_number'){
            street_number = long_name;
        }
        if(addressType === 'route'){
            street_name = short_name;
        }
        if(addressType === 'administrative_area_level_1'){
            gform_autocomplete_container.find('.address_state input').val(long_name);
        }
        if(addressType === 'locality'){
            gform_autocomplete_container.find('.address_city input').val(long_name);
        }
        if(addressType === 'country'){
            gform_autocomplete_container.find('.address_country select').val(short_name);
        }
        if(addressType === 'postal_code'){
            gform_autocomplete_container.find('.address_zip input').val(long_name);
        }
    }
    
      gform_autocomplete_container.find('.address_line_1 input').val(street_name+', '+street_number);
           
}


function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            google_autocomplete.setBounds(circle.getBounds());
        });
    }
}

