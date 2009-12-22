;
/**
 * @author Alexandre Magno
 * @desc Center a element with jQuery
 * @version 1.0
 * @example
 * $("element").center({
 *
 * 		vertical: true,
 *      horizontal: true
 *
 * });
 * @obs With no arguments, the default is above
 * @license free
 * @param bool vertical, bool horizontal
 * @contribution Paulo Radichi
 * @web http://www.alexandremagno.net/jquery/plugins/center/
 */
jQuery.fn.center = function(params) {

		var options = {

			vertical: true,
			horizontal: true

		}
		op = jQuery.extend(options, params);

   this.each(function(){

		//initializing variables
		var $self = jQuery(this);
		//get the dimensions using dimensions plugin
		var width = $self.width();
		var height = $self.height();
		//get the paddings
		var paddingTop = parseInt($self.css("padding-top"));
		var paddingBottom = parseInt($self.css("padding-bottom"));
		//get the borders
		var borderTop = parseInt($self.css("border-top-width"));
		var borderBottom = parseInt($self.css("border-bottom-width"));
		//get the media of padding and borders
		var mediaBorder = (borderTop+borderBottom)/2;
		var mediaPadding = (paddingTop+paddingBottom)/2;
		//get the type of positioning
		var positionType = $self.parent().css("position");
		// get the half minus of width and height
		var halfWidth = (width/2)*(-1);
		var halfHeight = ((height/2)*(-1))-mediaPadding-mediaBorder;
		// initializing the css properties
		var cssProp = {
			position: 'absolute'
		};

		if(op.vertical) {
			cssProp.height = height;
			cssProp.top = '50%';
			cssProp.marginTop = halfHeight;
		}
		if(op.horizontal) {
			//cssProp.width = width;
			cssProp.left = '50%';
			cssProp.marginLeft = halfWidth;
		}
		//check the current position
		if(positionType == 'static') {
			$self.parent().css("position","relative");
		}
		//aplying the css
		$self.css(cssProp);


   });

};

$(function () {
	var o = $("input.inputtext");
	var form = $("#urlform");	
	var ds_text = $("div.description").text();
	var ds_html = $("div.description").html();
	var log = $("#dialog");

	if(o.attr('value') == ''){
		o.attr('value', ds_text);
		o.css('color', '#aaaaaa').attr('st', 0).focus(function(){
			$(this).attr('value', '');
			$(this).css('color', '#333333');
			$(this).attr('st', 1);
		});
	}
	
	form.submit(function(){
		if(o.attr('st') == 0){
			log.attr('title', '错误');
			log.html('<p>' + ds_html + '</p>');	
			log.dialog({
				bgiframe: true,
				modal: true,
				resizable: false,
				buttons: {
					Ok: function() {
						$(this).dialog('close');
					}
				}
			});
			log.dialog('open');
			return false;
		}
	});

	$("table.ui-widget").center({
		vertical: false,
		horizontal: true
	});
});