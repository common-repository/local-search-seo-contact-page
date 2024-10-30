jQuery(function($){
	var frame,
		locMetaBox = $('#upload_ebs_seo_cp_logo_img'), // Your meta box id here
		locAddImgLink = locMetaBox.find('.ebs-seo-cp-img-upload'),
		locDelImgLink = locMetaBox.find( '.ebs-seo-cp-img-delete'),
		locImgContainer = locMetaBox.find( '.ebs-seo-cp-img-container'),
		locImgIdInput = locMetaBox.find( '.ebs-seo-cp-img-id' );
	
		locAddImgLink.on( 'click', function( event ){	  
	  event.preventDefault();	  
	  if ( frame ) {
		frame.open();
		return;
	  }	  
	  // Create a new media frame
	  frame = wp.media({
		title: 'Select or upload image',
		button: {
		  text: 'Use this image'
		},
		multiple: false  // Set to true to allow multiple files to be selected
	  });
	  frame.on( 'select', function() {
		var attachment = frame.state().get('selection').first().toJSON();
		locImgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:200px;"/>' );
		locImgIdInput.val( attachment.url );
		locAddImgLink.addClass( 'hidden' );
		locDelImgLink.removeClass( 'hidden' );
	  });  
	  frame.open();
	});
	
	locDelImgLink.on( 'click', function( event ){  
	  event.preventDefault();
	  locImgContainer.html( '' );
	  locAddImgLink.removeClass( 'hidden' );
	  locDelImgLink.addClass( 'hidden' );
	  locImgIdInput.val( '' );  
	});  
});
jQuery(function($){
	var frame,
		locMetaBox = $('#upload_ebs_seo_cp_location_img'), // Your meta box id here
		locAddImgLink = locMetaBox.find('.ebs-seo-cp-img-upload'),
		locDelImgLink = locMetaBox.find( '.ebs-seo-cp-img-delete'),
		locImgContainer = locMetaBox.find( '.ebs-seo-cp-img-container'),
		locImgIdInput = locMetaBox.find( '.ebs-seo-cp-img-id' );
	
		locAddImgLink.on( 'click', function( event ){	  
		event.preventDefault();	  
		if ( frame ) {
		frame.open();
		return;
		}	  
		// Create a new media frame
		frame = wp.media({
		title: 'Select or upload image',
		button: {
			text: 'Use this image'
		},
		multiple: false  // Set to true to allow multiple files to be selected
		});
		frame.on( 'select', function() {
		var attachment = frame.state().get('selection').first().toJSON();
		locImgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:200px;"/>' );
		locImgIdInput.val( attachment.url );
		locAddImgLink.addClass( 'hidden' );
		locDelImgLink.removeClass( 'hidden' );
		});  
		frame.open();
	});
	
	locDelImgLink.on( 'click', function( event ){  
		event.preventDefault();
		locImgContainer.html( '' );
		locAddImgLink.removeClass( 'hidden' );
		locDelImgLink.addClass( 'hidden' );
		locImgIdInput.val( '' );  
	});  
});