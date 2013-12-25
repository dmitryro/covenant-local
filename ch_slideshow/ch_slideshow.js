/**
 * Author:		Richard Castera
 * Date:		06/08/2010
 * Comments:	used to display a slideshow with the slideshow content type.
 **/
Drupal.behaviors.ch_slideshow = function(context) {
	if(Drupal.jsEnabled) {
        $('#slideshow').cycle({
            fx:      'scrollHorz',
            timeout:  0,
            prev:    '#prev',
            next:    '#next',
            pager:   '#slideshow_page',
            pagerAnchorBuilder: pagerFactory
        });
    }
}

function pagerFactory(idx, slide) {
    var s = idx > 50 ? ' style="display:none"' : '';
    return '<li'+s+'><a href="javascript:void(0);">'+(idx+1)+'</a></li>';
};