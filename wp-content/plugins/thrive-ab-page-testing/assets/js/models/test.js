var base = require( './base' ),
	variations_collection = require( '../collections/variations' ),
	test_item_model = require( './test-item' ),
	test_items_collection = require( '../collections/test-items' );

module.exports = base.extend( {

	idAttribute: 'id',

	defaults: function () {
		var items = this.get( 'items' );
		return _.extend( {}, {
			id: '',
			auto_win_enabled: 0,
			auto_win_min_conversions: items && items.length ? (items.length - 1) * 100 : 100,
			auto_win_min_duration: 14,
			auto_win_chance_original: 95
		} );
	},

	get_route: function () {

		return 'route=tests';
	},

	initialize: function ( attrs ) {

		if ( ! attrs.items ) {
			throw new Error( 'Test model must have items defined' );
		}

		/**
		 * convert
		 */
		if ( attrs.items instanceof variations_collection ) {
			var items = [];
			attrs.items.each( function ( variation, index ) {
				items.push( {
					variation_id: variation.get( 'ID' ),
					title: variation.get( 'post_title' ),
					is_control: variation.get( 'is_control' ) === true,
					has_form: variation.get( 'has_form' )
				} );
			} );
			this.set( 'items', new test_items_collection( items ) );
		} else if ( attrs.items.length ) {
			this.set( 'items', new test_items_collection( attrs.items ) );
		}
	},

	validate: function ( attrs, options ) {

		var _errors = [];

		if ( options.step !== undefined ) {
			_errors = _.union( _errors, this['validate_step_' + options.step].apply( this, arguments ) );
			return _errors.length ? _errors : undefined;
		}

		if ( ! attrs.type ) {
			_errors.push( this.validation_error( 'type', '', function () {
				TVE_Dash.err( 'Select type' );
			} ) );

			return _errors;
		}

		if ( attrs.type != 'optins' && ( ! attrs.goal_pages || Object.keys( attrs.goal_pages ).length === 0 ) ) {
			_errors.push( this.validation_error( 'goal_page', '', function () {
				TVE_Dash.err( 'Select ' + (attrs.type == 'monetary' ? 'thank you' : 'goal') + ' page' );
			} ) );

			return _errors;
		}

		return _errors.length ? _errors : undefined;
	},

	parse: function ( response ) {

		if ( response.items ) {
			response.items = new test_items_collection( response.items );
		}

	},

	validate_step_winner_settings: function ( attrs, options ) {

		var fields = {
			auto_win_min_conversions: attrs.auto_win_min_conversions,
			auto_win_min_duration: attrs.auto_win_min_duration,
			auto_win_chance_original: attrs.auto_win_chance_original
		};

		return this._validate_fields( fields );
	},

	_validate_fields: function ( fields ) {

		var _errors = [];

		/**
		 * check if one of the fields has validator; if yes then and execute it and stack any error
		 */
		_.each( fields, function ( value, prop ) {
			if ( typeof this['validate_' + prop] === 'function' ) {
				_errors = _.union( _errors, this['validate_' + prop]( value ) );
			}
		}, this );

		if ( _errors.length ) {
			return _errors;
		}
	},

	validate_step_0: function ( attrs, options ) {

		var fields = {
			title: attrs.title,
			auto_win_min_conversions: attrs.auto_win_min_conversions,
			auto_win_min_duration: attrs.auto_win_min_duration,
			auto_win_chance_original: attrs.auto_win_chance_original
		};

		return this._validate_fields( fields );
	},

	validate_title: function ( value ) {

		if ( ! value ) {
			return [
				this.validation_error( 'title', ThriveAB.t.invalid_test_title )
			];
		}

		return [];
	},

	validate_auto_win_min_conversions: function ( value ) {

		if ( isNaN( parseInt( value ) ) ) {
			return [
				this.validation_error( 'auto_win_min_conversions', ThriveAB.t.not_number_min_win_conversions )
			];
		}

		if ( parseInt( value ) <= 0 ) {
			return [
				this.validation_error( 'auto_win_min_conversions', ThriveAB.t.greater_zero_min_win_conversions )
			];
		}

		return [];
	},

	validate_auto_win_min_duration: function ( value ) {

		if ( isNaN( parseInt( value ) ) ) {
			return [
				this.validation_error( 'auto_win_min_duration', ThriveAB.t.invalid_auto_win_min_duration )
			];
		}

		if ( parseInt( value ) <= 0 ) {
			return [
				this.validation_error( 'auto_win_min_duration', ThriveAB.t.invalid_auto_win_min_duration )
			];
		}

		return [];
	},

	validate_auto_win_chance_original: function ( value ) {

		if ( isNaN( parseInt( value ) ) ) {
			return [
				this.validation_error( 'auto_win_chance_original', ThriveAB.t.invalid_auto_win_chance_original )
			];
		}

		if ( parseInt( value ) <= 0 || parseInt( value ) > 100 ) {
			return [
				this.validation_error( 'auto_win_chance_original', ThriveAB.t.invalid_auto_win_chance_original )
			];
		}

		return [];
	},

	search_page_label: function () {

		var _label = 'Search Page',
			_type = this.get( 'type' );

		if ( _type === 'monetary' ) {
			_label = 'Thank you page'
		} else if ( _type === 'visits' ) {
			_label = 'Goal page';
		}

		return _label;
	}
} );
