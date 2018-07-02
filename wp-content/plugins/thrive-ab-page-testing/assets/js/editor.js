(function ( $ ) {
	TVE.ResetStatsModal = require( './modals/reset-stats' );
	var ThriveAB = {
		domtoimage: null,
		selector: 'body',
		init: function () {
			var self = this;
			if ( TVE.CONST.ajax.thrive_ab.running_test ) {
				TVE.add_filter( 'validate_saved_content', function () {
					if( typeof TVE.CONST.reset_stats === 'undefined' ){
						var ResetStatsModal = TVE.ResetStatsModal.get_instance( TVE.modal.get_element( 'reset-stats' ) );
						ResetStatsModal.open( {
							top: '20%'
						} );
						ResetStatsModal.on( 'reset_stats', self.save_with_reset_stats, self );
						return false;
					}else{
						if( ! TVE.CONST.reset_stats ){
							delete TVE.CONST.reset_stats;
						}

						return true;
					}

				} );
			} else {
				TVE.main.on( 'tve.tve_save_post', $.proxy( this.on_save, this ) );
			}
		},
		save_with_reset_stats: function ( running_test ) {
			TVE.CONST.reset_stats = running_test;
			this.on_save();
		},

		on_save: function () {
			this.get_image_source( this.save );
		},

		get_image_source: function ( _then_callback ) {

			if ( ! this.domtoimage ) {
				return null;
			}

			var $element = TVE.inner_$( this.selector );

			if ( ! $element.length ) {
				return null;
			}

			$element.find( '#fb-root' ).remove();
			$element.find( 'img' ).removeAttr( 'srcset' );

			this.domtoimage.toBlob( $element[0], {
				    bgcolor: 'white',
				    style: {
					    padding: 0,
					    margin: 0,
					    outline: 'none',
					    'overflow-y': 'hidden'
				    },
				    width: $element.width(),
				    height: 1000
			    } )
			    .then( typeof _then_callback === 'function' ? _then_callback : function ( data_source ) {
				    console.log( 'no data callback/promise provided for image source' );
			    } )
			    .catch( function () {
				    console.log( 'ops... something went wrong when getting image source' );
				    console.log( arguments );
			    } );
		},

		save: function ( data_source ) {

			if ( ! data_source ) {
				return null;
			}

			var form = new FormData();
			form.append( 'preview_file', data_source, TVE.CONST.post_id + '.png' );
			form.append( 'custom', 'save_variation_thumb' );
			form.append( 'action', TVE.CONST.ajax.thrive_ab.action );
			form.append( 'post_id', TVE.CONST.post_id );
			form.append( 'reset_data', TVE.CONST.reset_stats );

			$.ajax( {
				type: 'POST',
				url: TVE.CONST.ajax_url,
				data: form,
				processData: false,
				contentType: false,
				always: function () {
					$( '#tcb-template-clone-elem' ).remove();
				}
			} );

			if ( typeof TVE.CONST.reset_stats !== 'undefined' ) {
				TVE.main.editor_settings.$('.tve-save')[0].click();
			}
		}
	};

	function check_editor() {

		if ( TVE.inner === undefined ) {
			return setTimeout( check_editor, 100 );
		}

		ThriveAB.domtoimage = TVE.inner.window.domtoimage;
		ThriveAB.init();
	}

	check_editor();

})( jQuery );
