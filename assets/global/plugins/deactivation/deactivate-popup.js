jQuery(document).ready(function($) {
	$( '#the-list #limit-attempts-booster-plugin-disable-link' ).click(function(e) {
		e.preventDefault();

		var reason = $( '#limit-attempts-booster-feedback-content .limit-attempts-booster-reason' ),
			deactivateLink = $( this ).attr( 'href' );

	    $( "#limit-attempts-booster-feedback-content" ).dialog({
	    	title: 'Quick Feedback Form',
	    	dialogClass: 'limit-attempts-booster-feedback-form',
	      	resizable: false,
	      	minWidth: 430,
	      	minHeight: 300,
	      	modal: true,
	      	buttons: {
	      		'go' : {
		        	text: 'Continue',
        			icons: { primary: "dashicons dashicons-update" },
		        	id: 'limit-attempts-booster-feedback-dialog-continue',
					class: 'button',
		        	click: function() {
		        		var dialog = $(this),
		        			go = $('#limit-attempts-booster-feedback-dialog-continue'),
		          			form = dialog.find('form').serializeArray(),
							result = {};
						$.each( form, function() {
							if ( '' !== this.value )
						    	result[ this.name ] = this.value;
						});
						if ( ! jQuery.isEmptyObject( result ) ) {
							result.action = 'post_user_feedback_limit_attempts_booster';
						    $.ajax({
						        url: post_feedback.admin_ajax,
						        type: 'POST',
						        data: result,
						        error: function(){},
						        success: function(msg){},
						        beforeSend: function() {
						        	go.addClass('limit-attempts-booster-ajax-progress');
						        },
						        complete: function() {
						        	go.removeClass('limit-attempts-booster-ajax-progress');
						            dialog.dialog( "close" );
						            location.href = deactivateLink;
						        }
						    });
						}
		        	},
	      		},
	      		'cancel' : {
		        	text: 'Cancel',
		        	id: 'limit-attempts-booster-feedback-cancel',
		        	class: 'button button-primary',
		        	click: function() {
		          		$( this ).dialog( "close" );
		        	}
	      		},
	      		'skip' : {
		        	text: 'Skip',
		        	id: 'limit-attempts-booster-feedback-dialog-skip',
		        	click: function() {
		          		$( this ).dialog( "close" );
		          		location.href = deactivateLink;
		        	}
	      		},
	      	}
	    });
	});
});
