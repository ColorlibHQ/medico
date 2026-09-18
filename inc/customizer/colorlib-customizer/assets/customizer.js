/**
 * Behaviour for the Colorlib Customizer controls.
 *
 * Each control keeps one hidden or text input that carries the value, marked
 * with data-customize-setting-link. WordPress watches those, so writing to one
 * and firing `change` is all that is needed to record a change — there is no
 * separate save path to keep in step.
 */
( function () {
	'use strict';

	/**
	 * Tell WordPress an input's value changed.
	 *
	 * @param {HTMLElement} input The input carrying the setting.
	 */
	function commit( input ) {
		if ( ! input ) {
			return;
		}

		input.dispatchEvent( new Event( 'change', { bubbles: true } ) );
	}

	/* ---------------------------------------------------------------------
	 * Repeater
	 * ------------------------------------------------------------------ */

	/**
	 * Read every row out of the DOM and write it to the hidden input.
	 *
	 * The value is URL-encoded JSON, which is what the setting decodes.
	 *
	 * @param {HTMLElement} repeater The repeater wrapper.
	 */
	function serializeRepeater( repeater ) {
		var input = repeater.querySelector( '.colorlib-repeater__value' );
		var rows  = [];

		repeater.querySelectorAll( '.colorlib-repeater__row' ).forEach( function ( row, index ) {
			var values = {};

			row.querySelectorAll( '[data-field]' ).forEach( function ( field ) {
				var key = field.getAttribute( 'data-field' );

				if ( 'checkbox' === field.type ) {
					values[ key ] = field.checked;
				} else {
					values[ key ] = field.value;
				}
			} );

			// Epsilon stored the position alongside the values and some themes
			// read it, so it is kept.
			values.index = index;
			rows.push( values );
		} );

		input.value = encodeURIComponent( JSON.stringify( rows ) );
		commit( input );
	}

	/**
	 * Refresh a row's collapsed title from its own fields.
	 *
	 * @param {HTMLElement} row The row.
	 */
	function refreshRowTitle( row ) {
		var repeater = row.closest( '.colorlib-repeater' );
		var titleEl  = row.querySelector( '.colorlib-repeater__row-title' );
		var source   = repeater && repeater.getAttribute( 'data-row-label-field' );

		if ( ! titleEl || ! source ) {
			return;
		}

		var field = row.querySelector( '[data-field="' + source + '"]' );
		if ( field && field.value ) {
			titleEl.textContent = field.value;
		}
	}

	/**
	 * Renumber rows after an add, remove or move.
	 *
	 * @param {HTMLElement} repeater The repeater wrapper.
	 */
	function reindex( repeater ) {
		repeater.querySelectorAll( '.colorlib-repeater__row' ).forEach( function ( row, index ) {
			row.setAttribute( 'data-index', index );
		} );
	}

	/**
	 * Wire one repeater.
	 *
	 * @param {HTMLElement} repeater The repeater wrapper.
	 */
	function initRepeater( repeater ) {
		if ( repeater.dataset.colorlibReady ) {
			return;
		}
		repeater.dataset.colorlibReady = '1';

		var list     = repeater.querySelector( '.colorlib-repeater__rows' );
		var template = repeater.querySelector( '.colorlib-repeater__template' );
		var addBtn   = repeater.querySelector( '.colorlib-repeater__add' );

		// Make sure the hidden input matches what is on screen from the start,
		// so a save without edits cannot blank the setting.
		serializeRepeater( repeater );

		if ( addBtn && template ) {
			addBtn.addEventListener( 'click', function () {
				var count = list.querySelectorAll( '.colorlib-repeater__row' ).length;
				var html  = template.innerHTML.replace( /__INDEX__/g, String( count ) );
				var holder = document.createElement( 'tbody' );

				holder.innerHTML = '<table><tr><td><ul>' + html + '</ul></td></tr></table>';
				var row = holder.querySelector( '.colorlib-repeater__row' );

				if ( ! row ) {
					return;
				}

				list.appendChild( row );
				initRowExtras( row );
				reindex( repeater );
				serializeRepeater( repeater );

				// Open the row that was just added.
				var body = row.querySelector( '.colorlib-repeater__row-body' );
				if ( body ) {
					body.hidden = false;
				}
			} );
		}

		repeater.addEventListener( 'click', function ( event ) {
			var toggle = event.target.closest( '.colorlib-repeater__toggle' );
			var remove = event.target.closest( '.colorlib-repeater__remove' );
			var move   = event.target.closest( '.colorlib-repeater__move' );

			if ( toggle ) {
				var body = toggle.closest( '.colorlib-repeater__row' ).querySelector( '.colorlib-repeater__row-body' );
				body.hidden = ! body.hidden;
				toggle.setAttribute( 'aria-expanded', body.hidden ? 'false' : 'true' );
				return;
			}

			if ( remove ) {
				remove.closest( '.colorlib-repeater__row' ).remove();
				reindex( repeater );
				serializeRepeater( repeater );
				return;
			}

			if ( move ) {
				var row = move.closest( '.colorlib-repeater__row' );
				if ( 'up' === move.getAttribute( 'data-dir' ) && row.previousElementSibling ) {
					row.parentNode.insertBefore( row, row.previousElementSibling );
				} else if ( 'down' === move.getAttribute( 'data-dir' ) && row.nextElementSibling ) {
					row.parentNode.insertBefore( row.nextElementSibling, row );
				}
				reindex( repeater );
				serializeRepeater( repeater );
			}
		} );

		repeater.addEventListener( 'input', function ( event ) {
			if ( ! event.target.matches( '[data-field]' ) ) {
				return;
			}

			var row = event.target.closest( '.colorlib-repeater__row' );
			refreshRowTitle( row );

			var preview = row.querySelector( '.colorlib-repeater__icon-preview' );
			if ( preview && event.target.closest( '.colorlib-repeater__icon' ) ) {
				preview.className = 'colorlib-repeater__icon-preview ' + event.target.value;
			}

			serializeRepeater( repeater );
		} );

		repeater.addEventListener( 'change', function ( event ) {
			if ( event.target.matches( '[data-field]' ) ) {
				serializeRepeater( repeater );
			}
		} );

		repeater.querySelectorAll( '.colorlib-repeater__row' ).forEach( initRowExtras );
	}

	/**
	 * Controls inside a row that need their own setup.
	 *
	 * @param {HTMLElement} row The row.
	 */
	function initRowExtras( row ) {
		// Media picker.
		row.querySelectorAll( '.colorlib-repeater__media-pick' ).forEach( function ( button ) {
			button.addEventListener( 'click', function () {
				if ( ! window.wp || ! window.wp.media ) {
					return;
				}

				var target = button.parentNode.querySelector( '[data-field]' );
				var frame  = window.wp.media( { multiple: false } );

				frame.on( 'select', function () {
					var attachment = frame.state().get( 'selection' ).first().toJSON();
					target.value = attachment.url;
					target.dispatchEvent( new Event( 'input', { bubbles: true } ) );
				} );

				frame.open();
			} );
		} );

		// Colour fields, using the picker WordPress already ships.
		if ( window.jQuery && window.jQuery.fn.wpColorPicker ) {
			window.jQuery( row ).find( '.colorlib-repeater__color' ).wpColorPicker( {
				change: function ( event, ui ) {
					var input = event.target;
					input.value = ui.color.toString();
					input.dispatchEvent( new Event( 'input', { bubbles: true } ) );
				}
			} );
		}
	}

	/* ---------------------------------------------------------------------
	 * Icon picker
	 * ------------------------------------------------------------------ */

	/**
	 * @param {HTMLElement} picker The picker wrapper.
	 */
	function initIconPicker( picker ) {
		if ( picker.dataset.colorlibReady ) {
			return;
		}
		picker.dataset.colorlibReady = '1';

		var input   = picker.querySelector( '.colorlib-icon-picker__input' );
		var preview = picker.querySelector( '.colorlib-icon-picker__preview' );
		var search  = picker.querySelector( '.colorlib-icon-picker__search' );

		picker.addEventListener( 'click', function ( event ) {
			var button = event.target.closest( '.colorlib-icon-picker__icon' );
			if ( ! button ) {
				return;
			}

			var icon = button.getAttribute( 'data-icon' );
			input.value = icon;
			preview.className = 'colorlib-icon-picker__preview ' + icon;

			picker.querySelectorAll( '.colorlib-icon-picker__icon' ).forEach( function ( other ) {
				other.classList.toggle( 'is-selected', other === button );
			} );

			commit( input );
		} );

		input.addEventListener( 'input', function () {
			preview.className = 'colorlib-icon-picker__preview ' + input.value;
		} );

		if ( search ) {
			search.addEventListener( 'input', function () {
				var term = search.value.toLowerCase();

				picker.querySelectorAll( '.colorlib-icon-picker__icon' ).forEach( function ( button ) {
					var icon = button.getAttribute( 'data-icon' ).toLowerCase();
					button.hidden = term && -1 === icon.indexOf( term );
				} );
			} );
		}
	}

	/* ---------------------------------------------------------------------
	 * Slider and layouts
	 * ------------------------------------------------------------------ */

	/**
	 * Keep the range and number inputs in step; the number carries the value.
	 *
	 * @param {HTMLElement} slider The slider wrapper.
	 */
	function initSlider( slider ) {
		if ( slider.dataset.colorlibReady ) {
			return;
		}
		slider.dataset.colorlibReady = '1';

		var range  = slider.querySelector( '.colorlib-slider__range' );
		var number = slider.querySelector( '.colorlib-slider__number' );

		if ( ! range || ! number ) {
			return;
		}

		range.addEventListener( 'input', function () {
			number.value = range.value;
			number.dispatchEvent( new Event( 'input', { bubbles: true } ) );
			commit( number );
		} );

		number.addEventListener( 'input', function () {
			range.value = number.value;
		} );
	}

	/**
	 * Store the column count in the shape the themes read.
	 *
	 * @param {HTMLElement} layouts The layouts wrapper.
	 */
	function initLayouts( layouts ) {
		if ( layouts.dataset.colorlibReady ) {
			return;
		}
		layouts.dataset.colorlibReady = '1';

		var input = layouts.parentNode.querySelector( '.colorlib-layouts__value' );

		layouts.addEventListener( 'change', function ( event ) {
			var radio = event.target.closest( '.colorlib-layouts__radio' );
			if ( ! radio || ! input ) {
				return;
			}

			var count   = parseInt( radio.value, 10 ) || 1;
			var columns = {};

			for ( var i = 1; i <= count; i++ ) {
				// Bootstrap's grid is twelve wide; an even split is what the
				// themes' own defaults use.
				columns[ i ] = { index: i, span: Math.floor( 12 / count ) };
			}

			input.value = JSON.stringify( { columnsCount: count, columns: columns } );
			commit( input );

			layouts.querySelectorAll( '.colorlib-layouts__choice' ).forEach( function ( choice ) {
				choice.classList.toggle( 'is-selected', choice.contains( radio ) );
			} );
		} );
	}

	/* ---------------------------------------------------------------------
	 * Boot
	 * ------------------------------------------------------------------ */

	/**
	 * Controls are rendered as their section opens, so this runs on demand
	 * rather than only once.
	 */
	function boot( root ) {
		var scope = root || document;

		scope.querySelectorAll( '.colorlib-repeater' ).forEach( initRepeater );
		scope.querySelectorAll( '.colorlib-icon-picker' ).forEach( initIconPicker );
		scope.querySelectorAll( '.colorlib-slider' ).forEach( initSlider );
		scope.querySelectorAll( '.colorlib-layouts' ).forEach( initLayouts );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		boot();
	} );

	if ( window.wp && window.wp.customize ) {
		window.wp.customize.bind( 'ready', function () {
			boot();

			// Sections render their controls lazily; catch those too.
			window.wp.customize.section.each( function ( section ) {
				section.expanded.bind( function ( expanded ) {
					if ( expanded ) {
						boot( section.container[ 0 ] );
					}
				} );
			} );
		} );
	}
}() );
