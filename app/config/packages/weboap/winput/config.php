<?php  

return array(
    
    'trim'      => true,
    
    'clean' 	=> true,
    
    'sanitize'  => true,
    
    'cache'     => storage_path().'/cache', //HTML Purifier cache
    
    'htmlFilters' => array(
                   'Core.Encoding'              =>  'UTF-8',
                   'HTML.Doctype'               =>  'XHTML 1.0 Transitional',
                   'HTML.AllowedElements'       =>  '',
                   'Attr.AllowedClasses'        => '',
                   'HTML.AllowedAttributes'     =>  '',
                   'AutoFormat.RemoveEmpty'     => true,
                   'HTML.Allowed'               => ''
                    )
      
  
  );
