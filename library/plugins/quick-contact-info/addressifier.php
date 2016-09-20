<?php

/*
 * Addressifier
 * Makin' abbreviations for addresses so's we can display them differently if need be.
 */

function addressify_map_url($address) {

	$addr = preg_replace("/\W+/", "+", strip_tags($address) );
	return 'https:maps.apple.com?q=' . $addr;
}


/*
 * addressify()
 * take a plain string of text and mark up abbreviations
 */
function addressify($text) {

	// first, split text by the spaces.
	$t = explode(' ', $text);
	
	// load directions and street abbreviations and put in one array
	$directions = cardinal_directions();
	$street_abbrevs = street_abbreviations();
	$replace = array_merge( $directions, $street_abbrevs );
	$find = array_keys( $replace );
	
	foreach( $find as $k => $v ) {
		$find[$k] = "/\b$v\b/u";
	}
	
	foreach( $replace as $k => $v ) {
		$replace[$k] = "<abbr title='$k'><span>$v</span></abbr>";
	}
	
/*	// check each piece of text to see if it should be rewritten
	foreach( $t as $k => $word ) {
		if( array_key_exists( $word, $words_to_check ) ) {
			$t[$k] = "<abbr title='$word'><span>{$words_to_check[$word]}</span></abbr>";
		}
	}

	// put back together
	// $text = implode(' ', $t);
	*/
	$text = preg_replace( $find, $replace, $text);
	
	return $text;
}

function cardinal_directions() {

	$directions = array(
		'Northeast' => 'NE',
		'Southeast' => 'SE',
		'Northwest' => 'NW',
		'Southwest' => 'SW',
		'North' => 'N',
		'South' => 'S',
		'East' => 'E',
		'West' => 'W',
	);

	return $directions;
}

function street_abbreviations() {

	// http://access.ewu.edu/mail-services/references/abbreviations-for-street-designators
	$street_abbrevs = array(
		'Alley' => 'ALY',
		'Annex' => 'ANX',
		'Arcade' => 'ARC',
		'Avenue' => 'AVE',
		'Bayou' => 'YU',
		'Beach' => 'BCH',
		'Bend' => 'BND',
		'Bluff' => 'BLF',
		'Bottom' => 'BTM',
		'Boulevard' => 'BLVD',
		'Branch' => 'BR',
		'Bridge' => 'BRG',
		'Brook' => 'BRK',
		'Burg' => 'BG',
		'Bypass' => 'BYP',
		'Camp' => 'CP',
		'Canyon' => 'CYN',
		'Cape' => 'CPE',
		'Causeway' => 'CSWY',
		'Center' => 'CTR',
		'Circle' => 'CIR',
		'Cliffs' => 'CLFS',
		'Club' => 'CLB',
		'Corner' => 'COR',
		'Corners' => 'CORS',
		'Course' => 'CRSE',
		'Court' => 'CT',
		'Courts' => 'CTS',
		'Cove' => 'CV',
		'Creek' => 'CRK',
		'Crescent' => 'CRES',
		'Crossing' => 'XING',
		'Dale' => 'DL',
		'Dam' => 'DM',
		'Divide' => 'DV',
		'Drive' => 'DR',
		'Estates' => 'EST',
		'Expressway' => 'EXPY',
		'Extension' => 'EXT',
		'Fall' => 'FALL',
		'Falls' => 'FLS',
		'Ferry' => 'FRY',
		'Field' => 'FLD',
		'Fields' => 'FLDS',
		'Flats' => 'FLT',
		'Ford' => 'FOR',
		'Forest' => 'FRST',
		'Forge' => 'FGR',
		'Fork' => 'FORK',
		'Forks' => 'FRKS',
		'Fort' => 'FT',
		'Freeway' => 'FWY',
		'Gardens' => 'GDNS',
		'Gateway' => 'GTWY',
		'Glen' => 'GLN',
		'Green' => 'GN',
		'Grove' => 'GRV',
		'Harbor' => 'HBR',
		'Haven' => 'HVN',
		'Heights' => 'HTS',
		'Highway' => 'HWY',
		'Hill' => 'HL',
		'Hills' => 'HLS',
		'Hollow' => 'HOLW',
		'Inlet' => 'INLT',
		'Island' => 'IS',
		'Islands' => 'ISS',
		'Isle' => 'ISLE',
		'Junction' => 'JCT',
		'Key' => 'CY',
		'Knolls' => 'KNLS',
		'Lake' => 'LK',
		'Lakes' => 'LKS',
		'Landing' => 'LNDG',
		'Lane' => 'LN',
		'Light' => 'LGT',
		'Loaf' => 'LF',
		'Locks' => 'LCKS',
		'Lodge' => 'LDG',
		'Loop' => 'LOOP',
		'Mall' => 'MALL',
		'Manor' => 'MNR',
		'Meadows' => 'MDWS',
		'Mill' => 'ML',
		'Mills' => 'MLS',
		'Mission' => 'MSN',
		'Mount' => 'MT',
		'Mountain' => 'MTN',
		'Neck' => 'NCK',
		'Orchard' => 'ORCH',
		'Oval' => 'OVAL',
		'Park' => 'PARK',
		'Parkway' => 'PKY',
		'Pass' => 'PASS',
		'Path' => 'PATH',
		'Pike' => 'PIKE',
		'Pines' => 'PNES',
		'Place' => 'PL',
		'Plain' => 'PLN',
		'Plains' => 'PLNS',
		'Plaza' => 'PLZ',
		'Point' => 'PT',
		'Port' => 'PRT',
		'Prairie' => 'PR',
		'Radial' => 'RADL',
		'Ranch' => 'RNCH',
		'Rapids' => 'RPDS',
		'Rest' => 'RST',
		'Ridge' => 'RDG',
		'River' => 'RIV',
		'Road' => 'RD',
		'Row' => 'ROW',
		'Run' => 'RUN',
		'Shoal' => 'SHL',
		'Shoals' => 'SHLS',
		'Shore' => 'SHR',
		'Shores' => 'SHRS',
		'Spring' => 'SPG',
		'Springs' => 'SPGS',
		'Spur' => 'SPUR',
		'Square' => 'SQ',
		'Station' => 'STA',
		'Stravenues' => 'STRA',
		'Stream' => 'STRM',
		'Street' => 'ST',
		'Summit' => 'SMT',
		'Terrace' => 'TER',
		'Trace' => 'TRCE',
		'Track' => 'TRAK',
		'Trail' => 'TRL',
		'Trailer' => 'TRLR',
		'Tunnel' => 'TUNL',
		'Turnpike' => 'TPKE',
		'Union' => 'UN',
		'Valley' => 'VLY',
		'Viaduct' => 'VIA',
		'View' => 'VW',
		'Village' => 'VLG',
		'Ville' => 'VL',
		'Vista' => 'VIS',
		'Walk' => 'WALK',
		'Way' => 'WAY',
		'Wells' => 'WLS',
	);

	return $street_abbrevs;
}
