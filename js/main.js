// jQuery Window Load (Images must be loaded)
$(window).load(function() {
    $('#swipegallery').swipeGallery({
        'autoHeight'    : false,
        'width'         : '280px',
        'height'        : '280px'
    }); 
});
  
// jQuery
$(document).ready(function() {  
 
    // Share-Button
    $('#shareBtn').live('click', function(event, ui) {        
        var design = $('#design-' + $(this).attr('data-id'));    
        var subject = design.find('h1').text();  
        var url = design.attr('data-cysurl');        
        $('#share h3').text(subject);
        $('#share a.mailto').attr('href', 'mailto: ?subject=' + subject + '&body=Look at this! http://create-your-style.com' + url);                
    })
    
    // Link to fullscreen Design
    $('.designImage').live('click', function(event, ui) {
        var designId = $(this).attr('data-id');
        $.mobile.changePage("index.php?a=gallery&id=" + designId, "flip", false, true);	
    })
    
    //cys.init();

})

var cys = {

/**      
    apiUrl: "http://www.create-your-style.com/Content.Node/scripts/api/api.php",

    p     [json|xml]     p = Protokoll. Hiermit wird das Rückgabeformat angegeben. Falls der Parameter nicht gesetzt ist, wird JSON ausgegeben.
    a     [getAllThemes|getAllThemeTitles|getAllDesigns|getAllDesignTitles|getDesign|getChecksum]     a = Aktion
    t     Themekey     t = Theme. Hiermit kann die Aktion getAllDesigns und getAllDesignTitles nach einem Thema gefilter werden.
    d     DesignId     d = Design. Hiermit kann für die Aktion getDesign ein bestimmtes Design angesprochen werden.
    jsoncallback     id     Hiermit kann z.B. für JSONP ein Rückgabewert deffiniert werden um nicht auf eine Domain begrenzt zu sein.     
*/    
 
    version: "0.1",
    apiUrl: "/scripts/api.php",
     
    init: function() {

        cys.listProjects();
    
    },
    
    listProjects: function() {
        
        $.getJSON(cys.apiUrl + '?a=getAllThemes', function(data){
            var projects = '';          
            $.each(data, function(key, val) {
                projects += '<li id="' + key + '">' + val.title + '</li>';
            });           
            console.log(projects);
            $('#projectList li').replaceWith(projects);
        });
        
    },
    
}
    