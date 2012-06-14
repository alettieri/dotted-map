<?php
	
	error_reporting(E_ALL);
	
	$path_count = 0;
	
	function parse_xml($xml, $node){
		
		$paths = array();
		$group = array();
		$count = 0;
		$group_id = $count;
		$path;
		$countryPoints = array();
		
		foreach( $xml->children() as $region )
		{

			if( ( $region->getName() == "g" ) && ( $region->count() > 0 ) )
			{

    
              foreach( $region->children() as $country )
                {
                    
                   if( $country->getName() == "g" && ( $country->count() > 0 ) )
					{
                    	
                    	$country_id = strtolower( $country[ "id" ] );

                    	if( $country->path )
                    		$paths[ $country_id ][ "path" ] = array( "d" => $country->path["d"] );
                    
                	}
					
				
			    }//end foreach $region    
		    }
       
	   }
	   	
	   	

	   return json_encode( $paths );
	}
	  
	
		
	function points($point){
		
		return array(
			"x"	=>	$point["cx"],
			"y"	=>	$point['cy'],
			"r"	=>	$point['r']
			);
		
	}
	
	
	$xml = simplexml_load_file("dotted-map.svg");
	
	$assoc = parse_xml($xml, "root");
	
	$fh = fopen("map-path-data.js","w");
	$json = "var country_paths = {$assoc};";
	fwrite($fh,$json);
	fclose($fh);
	



?>
