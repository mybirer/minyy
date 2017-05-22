saved=false;
$(function(){
	/*
	 * Is flowplayer loaded successfully? 
	 */
	var fwp=videojs('#player');
	if(!fwp){
		throw "Video not loaded!";
	}

	/*
	 * Keyboard shortcuts 
	 */
	$(document).keydown(function (event) {
		var code = (event.keyCode ? event.keyCode : event.which);
		if (code == 9) { 
			if(event.shiftKey){ //shift+tab key
				fwp.currentTime(fwp.currentTime()-4);
			}
			else{//tab key
				if(fwp.paused()){
					fwp.play();
				}
				else{
					fwp.pause();
				}
			}
			return false;
		}
	});
	$('.subtitle-list').on('keydown', 'textarea', function(event){
		if (event.keyCode == 13) {
			if(!event.shiftKey){
				newLine();
				return false;
			}
		}
	});
	// $('textarea').keyup(function (event) {
	// 	if (event.keyCode == 13) {
	// 		var content = this.value;  
	// 		var caret = getCaret(this);          
	// 		if(event.shiftKey){
	// 			this.value = content.substring(0, caret - 1) + "\n" + content.substring(caret, content.length);
	// 			event.stopPropagation();
	// 		} else {
	// 			this.value = content.substring(0, caret - 1) + content.substring(caret, content.length);
	// 			$('form').submit();
	// 		}
	// 	}
	// });
	// function getCaret(el) { 
	// 	if (el.selectionStart) { 
	// 		return el.selectionStart; 
	// 	} else if (document.selection) { 
	// 		el.focus();
	// 		var r = document.selection.createRange(); 
	// 		if (r == null) { 
	// 			return 0;
	// 		}
	// 		var re = el.createTextRange(), rc = re.duplicate();
	// 		re.moveToBookmark(r.getBookmark());
	// 		rc.setEndPoint('EndToStart', re);
	// 		return rc.text.length;
	// 	}  
	// 	return 0; 
	// }

	/*
	 * Attempt on exit 
	 */
	window.onbeforeunload = function(){
		if(saved){
			return;
		}
		return "You have attempted to leave this page. If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
	}

	/**
	 * Events
	 */
	$('.subtitle-list').on('blur', 'textarea', function(){
		$(this).hide();
		$(this).siblings('.subtitle-text').html($(this).val()).show();
	});
	$('.subtitle-list').on('click', '.subtitle-text', function(){
		$(this).hide();
		$(this).siblings('.subtitle-edit').show().focus();
	});
	$('.subtitle-list').on('mouseover', '.sub-tools', function(){
		$(this).hide();
		$(this).siblings().show();
	});
	$('.subtitle-list').on('mouseleave', '.sub-toolbox-menu', function(){
		$(this).hide();
		$(this).siblings().show();
	});
	$('.subtitle-list').on('click', '.sub-toolbox-menu .remove', function(){
		$(this).parentsUntil('.subtitle-list').remove();
		if($('.subtitle-list .sub').length==0){
			newLine();
		}
	});
	$('[data-toggle="play-pause"]').on('click',function(){
		if(fwp.paused()){
			fwp.play();
		}
		else{
			fwp.pause();
		}
	});
	$('[data-toggle="skip-back"]').on('click',function(){
		fwp.currentTime(fwp.currentTime()-4);
	});
	$('.save-button').on('click',function(){
		$('#sentences-form').trigger('submit');
		return false;
	});
	$('.save-and-exit-button').on('click',function(){
		$('#sentences-form').trigger('submit');
	});

	/**
	 * Functions
	 */
	function newLine(){
		$('.subtitle-list').append(
            '<li class="sub">'+
                '<span class="timing">--</span>'+
                '<span class="subtitle-text">Type a subtitle and press Enter</span>'+
                '<div class="sub-toolbox">'+
                    '<div class="sub-toolbox-inside">'+
                        '<a href="#" class="sub-tools"><i class="fa fa-wrench"></i></a>'+
                        '<ul class="sub-toolbox-menu">'+
                            '<li><a class="jump-to" title="Seek to subtitle"><i class="fa fa-sign-in"></i></a></li>'+
                            '<li><a class="insert-top" title="Insert subtitle above"><i class="fa fa-arrow-circle-o-up"></i></a></li>'+
                            '<li><a class="insert-down" title="Insert subtitle below"><i class="fa fa-arrow-circle-o-down"></i></a></li>'+
                            '<li><a class="remove" title="Delete subtitle"><i class="fa fa-close"></i></a></li>'+
                        '</ul>'+
                    '</div>'+
                '</div>'+
                '<textarea class="subtitle-edit" name="texts[]" placeholder="Type a subtitle and press Enter"></textarea>'+
                '<input type="hidden" name="starts[]" value="19.191494040054323">'+
                '<input type="hidden" name="ends[]" value="22.881494040054656">'+
            '</li>');
		$('.subtitle-list li:last-child .subtitle-text').hide();
		$('.subtitle-list li:last-child .subtitle-edit').show().focus();
	}
});