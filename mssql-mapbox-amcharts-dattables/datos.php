<?php
    $conn = new PDO('odbc:Driver={ODBC Driver 13 for SQL Server};Server=example.com;Database=database; Uid=user;Pwd=password');
    
    # query
    $query = $conn->query('SELECT * FROM table');
	
	# Empty geojson array
	$geojson = array(
		'type'      => 'FeatureCollection',
		'features'  => array()
	);
	
	# Loop through rows to build feature arrays
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
	    
	    $properties = $row;

	    $feature = array(
	        'type' => 'Feature',
	        'geometry' => array(
	            'type' => 'Point',
	            'coordinates' => array(
	                $row['latitude'],
	                $row['longitude']
	            )
	        ),
	        'properties' => $properties
	    );
	    
	    # Add feature arrays to feature collection array
	    array_push($geojson['features'], $feature);
	}
	
	header('Content-type: application/json');
	echo json_encode($geojson, JSON_NUMERIC_CHECK);
	$conn = NULL;
?> 
