'use strict';

export default class TabLinks{
    constructor(){
        $('._map').click(function() {
            $('#tabMap').css({'display': 'block'});
            $('#tabList').css({'display': 'none'});
            $('._map').addClass(' _active');
            $('._list').removeClass(' _active');
        })
        $('._list').click(function() {
            $('#tabMap').css({'display': 'none'});
            $('#tabList').css({'display': 'block'});
            $('._map').removeClass(' _active');
            $('._list').addClass(' _active');
        })
        $('.order_help_block .order_block_call').click( function(){
            $('.order_recall_block').css({'display': 'block'});
            $('.order_help_block').css({'display': 'none'});
        })
        $('.order_succes_block .retype_call').click( function(){
            $('.order_recall_block').css({'display': 'block'});
            $('.order_succes_block').css({'display': 'none'});
        })
    }
}
