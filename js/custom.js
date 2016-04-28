// // Get the modal
// var modal = document.getElementById('myModal');

// // Get the button that opens the modal
// var btn = document.getElementsByClassName("answer_url_link");

// // Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// // When the user clicks on the button, open the modal
// btn.onclick = function() {
//     modal.style.display = "block";
// }

// // When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//     modal.style.display = "none";
// }

// When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//     if (event.target == modal) {
//         modal.style.display = "none";
//     }
// }





$( document ).ready(function() {

	// $(".answer_url_link").click(function(event) {
	// 	 Act on the event 
	// 	$("#myModal").show();
	// });

	$(".container").on('click', '.answer_url_link', function(event) {
		//alert("sdfsdf");
		//event.preventDefault();
		/* Act on the event */
		//console.log($(this).attr('url'));
		url = $(this).attr('url');
		$('.modal-body').html('<iframe style="border: 0px; " src="' + url + '" width="100%" height="100%"></iframe>');
		$("#myModal").show();
	});

	$("#myModal").on('click', '.close', function(event) {
		//alert("sdfsdf");
		//event.preventDefault();
		/* Act on the event */

		$("#myModal").hide();
	});

	console.log( "ready!" );
	//$('#loading_image').hide();
	$('#loading_image').fadeOut("slow")
	$('#suggestion').hide();
	//$('#suggestion').hide();
	$('#question').focus();


	// $('#question').keyup(function(event) {
	// 	/* Act on the event */
	// 	var question = $.trim($("#question").val());
	// 	//console.log(question.length);
	// 	if(question.length == 0) {
	// 		$('#suggestion').hide();
	// 	} else {

	// 		//getSuggestions(question);

	// 		//$('#suggestion').show();
	// 	}

	// });


// Handle search box autocomplete
$("#question").autocomplete({
  delay: 0,
  source: function(request, response) {
  	$('#answers').hide();
    var limit = 5;
    getSuggestions(request, response, limit);
    $('.search-engine-label').show();
  },
  // Hide number of results message
  messages: {
    noResults: '',
    results: function() {}
  }
});



/***** NEW SEARCH ENGINE LISTING ********/

// Pass term to search engines (requests), and poulate lists of suggestions (responses)
function getSuggestions(request, response, limit) {

  // Google request
  var googSuggestURL = "http://suggestqueries.google.com/complete/search?client=chrome&q=%QUERY";
  googSuggestURL = googSuggestURL.replace('%QUERY', request.term);
  $.ajax({
      method: 'GET',
      dataType: 'jsonp',
      jsonpCallback: 'jsonCallback',
      url: googSuggestURL
    })
    .success(function(data) {
      // Remove any previous suggestions
      $('#goog-suggestions li').remove();
      // Build list of suggestion links
      $.each(data[1], function(key, val) {
        var link = getLink("https://www.google.com/#q=", val, "Google");
        $('#goog-suggestions').append("<li>" + link + "</li>");
        return key < limit - 1;
      });
    });

  // Bing request
  var bingSuggestURL = "http://api.bing.com/osjson.aspx?JsonType=callback&JsonCallback=?";
  $.getJSON(bingSuggestURL, {
    query: request.term
  }, function(data) {
    $('#bing-suggestions li').remove();
    $.each(data[1], function(key, val) {
      var link = getLink("http://www.bing.com/search?q=", val, "Bing");
      $('#bing-suggestions').append("<li>" + link + "</li>");
      return key < limit - 1;
    });
  });

  // Yahoo request
  var yahooSuggestURL = "http://ff.search.yahoo.com/gossip";
  $.ajax({
      url: yahooSuggestURL,
      dataType: "jsonp",
      data: {
        "output": "jsonp",
        "command": request.term
      }
    })
    .success(function(data) {
      $('#yahoo-suggestions li').remove();
      $.each(data.gossip.results, function(key, val) {
        var link = getLink("https://search.yahoo.com/search?p=", val.key, "Yahoo");
        $('#yahoo-suggestions').append("<li>" + link + "</li>");
        return key < limit - 1;
      });
    });
}

// Generate link for suggestions
function getLink(url, term, label) {
  formattedTerm = term.split(' ').join('+');
  return "<a target=\"_blank\" href=\"" + url + formattedTerm + "\" title=\"View results on " + label + "\"\">" + term + "</a>";
}




















// $("#suggestion").on('click', '.suggestion_list' ,function(event){
// 	//alert("here");
// 	suggested_value = $(this).html();
// 	$('#question').val(suggested_value);
// 	$('#suggestion').hide();
// 	getAnswers();
// //	console.log(a);
// });

/*
 get suggestions

 */
// function getSuggestions(question) {
//   var formData = {type:'suggestion',question:question};
// 	$.ajax({
// 			url : "Controllers/appController.php",
// 			type: "POST",
// 		// dataType: 'text/html',
// 			data : formData,
// 			success: function(data, textStatus, jqXHR)
// 			{
// 				$('#suggestion').show();
// 					$('#suggestion').html(data);

// 			},
// 			error: function (jqXHR, textStatus, errorThrown)
// 			{
// 				//alert("herer");
// 			}
// 	});
// }


/*

Search
 */
	$('#search').click(function(event) {
		/* Act on the event */
		getAnswers();
	});



	function getAnswers() {
		$('#suggestion').hide();
		$('#answers').hide();
		$('#loading_image').show();
		//$('#loading_image').fadeOut("slow")
		var question = $.trim($("#question").val());
	//	var question_prefix = $.trim($("#question_prefix").val());
		var question_prefix = 1;

		if((question_prefix > 0) && (question.length > 0)) {
			var answer = '';
			var formData = {type:'search',question:question,question_prefix:question_prefix};
			$.ajax({
			    url : "Controllers/appController.php",
			    type: "POST",
			   // dataType: 'text/html',
			    data : formData,
			    success: function(data, textStatus, jqXHR)
			    {
			    	//$('#loading_image').hide();
			    	$('#loading_image').fadeOut("slow");
			    	//console.log(data);
			    	//alert("herer");
			        //data - response from server
			      //  i = 1;

			      //  $.each(data.answers, function(index, element) {
			           // $("#answer-"+(index+1)).children("div.answer_title").html(element.title);
   			        //    $("#answer-"+(index+1)).children("div.answer_description").html(element.description);
			           // $("#answer-"+(index+1)).children("div.answer_url a").attr("href",element.url);
			         //  $("a").attr("href", "http://www.google.com/")


			         // 	answer += '<div id="answer-'+index+'" class="results">';
				        // answer += '<div class="answer_title">'+element.title+'</div>';
				        // answer += '<div class="answer_description">'+element.description+'</div>';
				        // answer += '<div class="answer_url"><a href="'+element.url+'">'+element.url+'</a></div>';
				        // answer += '</div>';
				        // answer += '<hr/>';

			           //i++;
			       // });
$('#answers').show();
			        $('#answers').html(data);

			    },
			    error: function (jqXHR, textStatus, errorThrown)
			    {
			 		//alert("herer");
			    }
			});
		}

	}




});
