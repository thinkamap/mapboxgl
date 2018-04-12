<?php
    $conn = new PDO('odbc:Driver={ODBC Driver 13 for SQL Server};Server=prvcugdb.database.windows.net;Database=prvcugdb; Uid=gisadmin;Pwd=Prvcu2018');
    
    # query
    $query = $conn->query('SELECT * FROM rincon');
	
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