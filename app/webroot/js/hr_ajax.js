/*Function to fill specifications for selected industry*/
function fillSpecification($industry_id, specification_field_id,loader_id){
	$('#'+specification_field_id+' option').each(function(i, option){ $(option).remove(); });
	document.getElementById(specification_field_id).options[0]=new Option("--All Specification--",'');
	$.ajax({
		url: "/utilities/getSpecificationOfIndustry/"+$industry_id,
	 	dataType:'json',
	 	async:false,
	 	beforeSend: function(){
     		$('#'+loader_id).html('<img src="/img/ajax-loader.gif" border="0" alt="Loading, please wait..." />');
   		},
		complete: function(){
   	    	$('#'+loader_id).html("&nbsp;");
   		},
  		success: function(response){
	 		//document.getElementById(specification_field_id).options[0]=new Option("--All Specification--",'');
			$.each(response, function(index, specification) {
				document.getElementById(specification_field_id).options[document.getElementById(specification_field_id).options.length] = new Option(specification, index);
            });
  		}
	});
}

/*Function to fill cities for selected State*/
function fillCities(state_id, city_field_id, loader_id)
{
	$('#'+city_field_id+' option').each(function(i, option){ $(option).remove(); });
	document.getElementById(city_field_id).options[0]=new Option("--All Cities--",'');
	$.ajax({
		url: "/utilities/getCitiesOfState/"+state_id,
	 	dataType:'json',
	 	async:false,
	 	beforeSend: function(){
     		$('#'+loader_id).html('<img src="/img/ajax-loader.gif" border="0" alt="Loading, please wait..." />');
   		},
		complete: function(){
   	    	$('#'+loader_id).html("&nbsp;");
   		},
  		success: function(response){
	 		//document.getElementById(city_field_id).options[0]=new Option("--All Cities--",'');
			$.each(response, function(index, city) {
				document.getElementById(city_field_id).options[document.getElementById(city_field_id).options.length] = new Option(city, index);
            });

  		}
	});
}
