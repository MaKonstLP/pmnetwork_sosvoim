'use strict';

export default class Burger{
    constructor(){
        
        $(document).ready(function() {
            // $('.main_menu_items').hide();
            $('.menu_burger').click(function() {
                $('.main_menu_items').slideToggle( "fast", function(){} );
                $(this).toggleClass(' _active');
            });
        });

    }
}
