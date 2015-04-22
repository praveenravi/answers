$( document ).ready(function() {
	console.log( "ready!" );
	//$('#loading_image').hide();
	$('#loading_image').fadeOut("slow")
	$('#suggestion').hide();
	//$('#suggestion').hide();
	$('#question').focus();
	$('#question').keyup(function(event) {
		/* Act on the event */
		var question = $.trim($("#question").val());
		//console.log(question.length);
		if(question.length == 0) {
			$('#suggestion').hide();
		} else {

			getSuggestions(question);

			//$('#suggestion').show();
		}

	});



$("#suggestion").on('click', '.suggestion_list' ,function(event){
	//alert("here");
	suggested_value = $(this).html();
	$('#question').val(suggested_value);
	$('#suggestion').hide();
	getAnswers();
//	console.log(a);
});

/*
 get suggestions

 */
function getSuggestions(question) {
  var formData = {type:'suggestion',question:question};
	$.ajax({
			url : "Controllers/appController.php",
			type: "POST",
		// dataType: 'text/html',
			data : formData,
			success: function(data, textStatus, jqXHR)
			{
				$('#suggestion').show();
					$('#suggestion').html(data);

			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//alert("herer");
			}
	});
}


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
		var question_prefix = $.trim($("#question_prefix").val());


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
