<?php

class Cys
{

    // Twig Instance
    public $twig;
    private $apiUrl = "http://www.create-your-style.com/Content.Node/scripts/api/api.php";


    // Constructor
    public function __construct($tpl_engine) {
        $this->twig = $tpl_engine;    
    }
    
    // Display Templates
    public function display($tpl, $data = array()) {
        $template = $this->twig->loadTemplate($tpl.'.html');
        $template->display($data);
    }
    
    // Get all Designs for Overview-Page
    public function getProjects() {
        $data = $this->api('getAllThemes');
        return $data;
    }
    
    // Get a single Design
    public function getDesignById($id) {
        $data = $this->api('getDesign', null, $id);
        return $data; 
    }
    
    // Get All Designs
    public function getDesigns($project = null) {
        $data = $this->api('getAllDesigns');
        return $data;
    }
    
    // Get a single Project by its name
    public function getProjectByName($name) {
        $data = $this->api('getAllThemes');
        return $data[$name];
    }
    
    // Order return Value from getAllDesigns by Themekey
    public function orderDesignsByProject($designs) {
        $sorted = array();      
        foreach($designs as $design) {
            $theme = $design['themeValue'];
            if(array_key_exists($theme, $sorted)) {
                array_push($sorted[$theme], $design);                
            } else {
                $sorted[$theme] = array($design);
            }
        }
        return $sorted;
    }
    
    
    /**
     * API Client
     *
     *  p     [json|xml]     p = Protokoll. Hiermit wird das Rückgabeformat angegeben. Falls der Parameter nicht gesetzt ist, wird JSON ausgegeben.
     *  a     [getAllThemes|getAllThemeTitles|getAllDesigns|getAllDesignTitles|getDesign|getChecksum]     a = Aktion
     *  t     Themekey     t = Theme. Hiermit kann die Aktion getAllDesigns und getAllDesignTitles nach einem Thema gefilter werden.
     *  d     DesignId     d = Design. Hiermit kann für die Aktion getDesign ein bestimmtes Design angesprochen werden.
     *   jsoncallback     id     Hiermit kann z.B. für JSONP ein Rückgabewert deffiniert werden um nicht auf eine Domain begrenzt zu sein. 
     */    
    private function api($action, $themekey = null, $designid= null, $format = 'json') {
        
        $handle = fopen ($this->apiUrl.'?a='.$action.'&t='.$themekey.'&d='.$designid.'&p='.$format, 'r');
        $data = stream_get_contents($handle);
        fclose($handle);
        if ($format == 'json') {
            $data = json_decode($data, true); 
            array_walk_recursive(&$data, create_function('&$value, $key','$value = utf8_decode(&$value);'));
            array_walk_recursive(&$data, create_function('&$value, $key','$value = htmlentities(&$value);'));
        }
        
        return $data;
    
    }
    
}
