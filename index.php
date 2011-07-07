<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/vendor/Twig-1.0.0/lib/Twig/Autoloader.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/scripts/cys.class.php');

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(dirname(__FILE__).'/templates');
$twig = new Twig_Environment($loader, array(
  //'cache' => dirname(__FILE__).'/cache',
  'debug' => true,
  'auto_reload' => true
));
$escaper = new Twig_Extension_Escaper(false);
$twig->addExtension($escaper);

$cys = new cys($twig);

switch ($_GET['a']) {

    // Single fullscreen Design Image
    case "gallery":
        $design = $cys->getDesignById($_GET['id']);
        //var_dump($design);
        $cys->display('image', array('design' => $design));
    break;
    
    // Homepage
    default:   
        $allDesigns         = $cys->getDesigns();
        $designsByProject   = $cys->orderDesignsByProject($allDesigns);
        $allProjects        = $cys->getProjects();
        $recentProjects     = $allProjects;
        $featuredProject    = array_shift($recentProjects); 
        //var_dump($designsByProject);
        $cys->display('main', array(
                'allProjects'       => $allProjects,
                'featuredProject'   => $featuredProject, 
                'recentProjects'    => $recentProjects,
                'allDesigns'        => $allDesigns,
                'designsByProject'  => $designsByProject
            ));
    break;


}



