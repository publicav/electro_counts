function menuInit() {
    var dropdown = $( "dropdown-item" );
    var submenu = $( "submenu" );

    dropdown.mouseover( function () {
        $( "#submenu" ).addClass( "show-submenu" ).removeClass( "hide-submenu" )
    } )
    submenu.mouseover( function () {
        $( "#submenu" ).addClass( "show-submenu" ).removeClass( "hide-submenu" )
    } )
}