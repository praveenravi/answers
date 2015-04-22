<?php
/*
    Include components
*/
  include 'Components/wa_wrapper/WolframAlphaEngine.php';
  include 'Components/unirest-php/src/Unirest.php';

/*
    get question and prefix
*/

if(@$_POST['type'] == 'search') {

	findAnswers($_POST['question'],$_POST['question_prefix']);
} else if(@$_POST['type'] == 'suggestion') {
  getGoogleSuggestions($_POST['question']);
}



/*

Main function to check answers

*/

function findAnswers($question,$question_prefix) {
    $question = urlencode($question);
	$answer = '';
	//
	//


    // what
    if($question_prefix == '1' || $question_prefix == '2' || $question_prefix == '3' || $question_prefix == '4') {
        // $answer_webHose = getAnswerFromWebhose($question);
        // $answer .= $answer_webHose;

        $answer_bing = getAnsersFromBing($question);
        $answer .= $answer_bing;

        $answer_wolpharmAlpha = getAnswerFromWolpharAlpha($question);
        $answer .= $answer_wolpharmAlpha;



        $answer_duckDuckGo = getAnswerFromDuckDuckGo($question);
        $answer .= $answer_duckDuckGo;

        
    }

    // where
    if($question_prefix == '5') {
        $answer_weather = getAnswerWeatherForcast($question);
        $answer .= $answer_weather;

        $answer_wolpharmAlpha = getAnswerFromWolpharAlpha($question);
        $answer .= $answer_wolpharmAlpha;
    }

    // who
    if($question_prefix == '6') {

        if(is_numeric($question)) {
            //echo "1";
           // echo strlen((string) $question);
            if( strlen((string) $question) > 8) {
                //echo "hrere";

                $answer_mobileNumber = getAnswerMobileInformation($question);
                $answer .= $answer_mobileNumber;

                $answer_bsnlMobileNumber = getBsnlAccountInfo($question);
                $answer .= $answer_bsnlMobileNumber;

            }
        }
 //exit();


       //$answer_personalDetails = getAnswerPersonalInfo($question);
       //$answer .= $answer_personalDetails;

        $answer_filmDetails = getAnswerFilmDetails($question,$question_prefix);
       $answer .= $answer_filmDetails;

       $answer_wolpharmAlpha = getAnswerFromWolpharAlpha($question);
       $answer .= $answer_wolpharmAlpha;
    }





	echo $answer;


}





function getGoogleSuggestions($user_input) {

//  $ans =   file_get_contents('http://suggestqueries.google.com/complete/search?q=mohan&client=toolbar');
  $result  = simplexml_load_file('http://suggestqueries.google.com/complete/search?q='.$user_input.'&client=toolbar');
  // $xml = new SimpleXMLElement('http://suggestqueries.google.com/complete/search?q=mohan&client=toolbar');
  $array1 = json_encode($result);
$array2 = json_decode($array1, true);
  //echo "<pre>";
  //$answers =  $result;
//  echo count($answers->CompleteSuggestion);
//  print_r($answers->CompleteSuggestion[0][0]->{'@attributes'}->data );
//
//
 $answer = '';
  if(isset($array2['CompleteSuggestion'])) {
    $answer .= '<ul>';
    foreach($array2['CompleteSuggestion'] as $key=>$value) {
     //print_r($value[0]['@attributes']['data']);
     $answer .= '<li class="suggestion_list">'.$value[0]['@attributes']['data'].'</li>';
    }
    $answer .= '</ul>';
  }
  echo $answer;
//  exit();

}





function getAnswerPersonalInfo($question) {
        // These code snippets use an open-source library. http://unirest.io/php
    $response = Unirest\Request::get("https://api.fullcontact.com/v2/person.json?email=".$question."&apiKey=d30fed36cf576f85",
      array(
        "Accept" => "application/json"
      )
    );
    $result = $response->body;

    // echo "<pre>";
    //  print_r($result); exit();
    if(($result != NULL) && ($result->status == 200)) {
        $answer = '<table class="u-full-width">

                        <tr>
                          <td colspan="100%"><b>Photos</b></td>
                        </tr>

                     ';
        foreach ($result->{'photos'} as $key => $value) {
            $answer .= '
                        <tr>
                          <td>'.$value->typeName.'</td>
                          <td><img src="'.$value->url.'"  width="100px"/></td>

                        </tr>';
        }

        // foreach ($result->{'photos'} as $key => $value) {
        //     $answer .= '
        //                 <tr>
        //                   <td>'.$value->typeName.'</td>
        //                   <td><img src="'.$value->url.'"  width="200px"/></td>

        //                 </tr>';
        // }

        $answer .= '</table>';
    } else {
        return ' ';
    }
    //print_r($result);
    //exit();
    return $answer;
}






function getAnswerMobileInformation($question) {


   // These code snippets use an open-source library. http://unirest.io/php
    $response = Unirest\Request::get("https://sphirelabs-indian-caller-info-with-name-v1.p.mashape.com/caller/v1/get/callerinfo.php?number=".$question,
      array(
        "X-Mashape-Key" => "ExJpEHTH0ymshNk99iLRmF0QHHj5p1VioOKjsnBZYlCBp4NlgO",
        "Accept" => "application/json"
      )
    );
    $result = $response->body;
   //print_r($response); exit();
    if(($result != NULL) && ($response->code == 200)) {
        $answer = '<table class="u-full-width">
                      <thead>
                        <tr>
                          <th>Telecom circle</th>
                          <th>Operator</th>

                        </tr>
                      </thead>
                      <tbody>';
       // foreach ($result as $key => $value) {
           // print_r($value); exit();
            $answer .= '
                        <tr>
                          <td>'.$result->{"Telecom circle"}.'</td>
                          <td>'.$result->Operator.'</td>

                        </tr>
                     ';
        //}
        $answer .= ' </tbody>
                    </table>';
    } else {
        return ' ';
    }
    //print_r($result);
    //exit();
    return $answer;
}










function getAnswerFilmDetails($question,$question_prefix) {

    if($question_prefix == 1) { //what
        $query = "title=".$question;
    } else if ($question_prefix == 6) { //who
        //$query = "title=".$question."&actor=".$question."&director=".$question;
        $query = "actor=".$question;
    }

   // echo $query;

   // These code snippets use an open-source library. http://unirest.io/php
    $response = Unirest\Request::get("https://community-netflix-roulette.p.mashape.com/api.php?".$query,
      array(
        "X-Mashape-Key" => "ExJpEHTH0ymshNk99iLRmF0QHHj5p1VioOKjsnBZYlCBp4NlgO",
        "Accept" => "application/json"
      )
    );
    $result = $response->body;
  // print_r($response);
    if(($result != NULL) && ($response->code == 200)) {
        $answer = '<table class="u-full-width">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Director</th>
                          <th>Poster</th>
                          <th>Year</th>
                          <th>Category</th>
                          <th>Rating</th>
                        </tr>
                      </thead>
                      <tbody>';
        foreach ($result as $key => $value) {
           // print_r($value); exit();
            $answer .= '
                        <tr>
                          <td>'.$value->show_title.'</td>
                          <td>'.$value->director.'</td>
                          <td><a href="'.$value->poster.'" target="_blank">poster</a></td>
                          <td>'.$value->release_year.'</td>
                          <td>'.$value->category.'</td>
                          <td>'.$value->rating.'</td>
                        </tr>
                     ';
        }
        $answer .= ' </tbody>
                    </table>';
    } else {
        return ' ';
    }
    //print_r($result);
    //exit();
    return $answer;
}






function getBsnlAccountInfo($question) {

   // These code snippets use an open-source library.
    $response = Unirest\Request::get("https://bsnlaccountinfo.p.mashape.com/index.php?mobileno=".$question,
      array(
        "X-Mashape-Key" => "anbjVsOIbamshYDqGH29cFF0ujqxp11S6nDjsni6ghNS0Qf2ii",
        "Accept" => "application/json"
      )
    );
    $result = $response->body;
   // print_r($response);
    if(($result != NULL) && (isset($result->mobileNumber))) {
        $answer = '<table class="u-full-width">
                      <thead>
                        <tr>
                          <th>Mobile Number</th>
                          <th>Current Balance</th>
                          <th>Expiry Date</th>
                        </tr>
                      </thead>
                      <tbody>';
      //  foreach ($result as $key => $value) {
           // print_r($value); exit();
            $answer .= '
                        <tr>
                          <td>'.$result->mobileNumber.'</td>
                          <td>'.$result->currentBalance.'</td>
                          <td>'.$result->expiryDate.'</td>
                        </tr>
                     ';
       // }
        $answer .= ' </tbody>
                    </table>';
    } else {
        return ' ';
    }
    //print_r($result);
    //exit();
    return $answer;
}



function getAnswerWeatherForcast($question) {

    $response = Unirest\Request::get("https://george-vustrey-weather.p.mashape.com/api.php?location=".$question,
      array(
        "X-Mashape-Key" => "ExJpEHTH0ymshNk99iLRmF0QHHj5p1VioOKjsnBZYlCBp4NlgO"
        //"Accept" => "application/json"
      )
    );
    $result = $response->body;
    if($result != NULL) {
        $answer = '<table class="u-full-width">
                      <thead>
                        <tr>
                          <th>Day</th>
                          <th>Low (Celsius)</th>
                          <th>High (Celsius)</th>
                          <th>condition</th>
                        </tr>
                      </thead>
                      <tbody>';
        foreach ($result as $key => $value) {
           // print_r($value); exit();
            $answer .= '
                        <tr>
                          <td>'.$value->day_of_week.'</td>
                          <td>'.$value->low_celsius.'</td>
                          <td>'.$value->high_celsius.'</td>
                          <td>'.$value->condition.'</td>
                        </tr>
                     ';
        }
        $answer .= ' </tbody>
                    </table>';
    } else {
        return ' ';
    }
    //print_r($result);
    //exit();
    return $answer;
}




function getAnswerFromDuckDuckGo($question) {
        $target_url = "http://api.duckduckgo.com/?q=".$question."&format=json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST,0);
       // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $result = curl_exec ( $ch );
        $err = curl_errno ( $ch );
        $errmsg = curl_error ( $ch );
        $header = curl_getinfo ( $ch );
        $httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
        //print_r($result);
       // $result = trim($result);
        if(empty($result)) {
            //echo "No results Found";
            return ' ';
        } else {
            //echo $result;

            $result_duck = json_decode($result,true);
            //echo "<pre>";
           //  print_r($result_duck);
            // exit();
            $posts = $result_duck['RelatedTopics'];
            $i=1;
            $answer = '';
            foreach ($posts as $key => $value)
            {
              //  print_r($value);
                if(isset($value['Text'])) {


                    $answer .= '<div id="answer-duck'.$i.'" class="results">';
                    $answer .= '<div class="answer_title"><a href="'.$value['FirstURL'].'"><b>'.$value['Text'].'</b></a></div>';
                    //$answer .= '<div class="answer_description">'.$value['thread']['title_full'].'</div>';
                   // $answer .= '<div class="answer_url">'.$value['FirstURL'].'</a></div>';
                    $answer .= '</div>';
                    $answer .= '<hr/>';
                     $i++;
                 }
            }

           return $answer;

        }
}



function getAnsersFromBing($question) {
  $accountKey = 'wxoEO+TfgAV8a0dwDet1c7Nl6TFTT29sLqeRK6brrHk=';
 // $serviceRootURL =  'https://api.datamarket.azure.com/Bing/SearchWeb/';  
  $serviceRootURL =  'https://api.datamarket.azure.com/Bing/Search/v1/';
  $webSearchURL = $serviceRootURL . 'Web?$format=json&Query=';

  $request = $webSearchURL . "%27" . urlencode( "$question" ) . "%27";

  $process = curl_init($request);
  curl_setopt($process, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($process, CURLOPT_USERPWD,  "$accountKey:$accountKey");
  curl_setopt($process, CURLOPT_TIMEOUT, 30);
  curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
  $response = curl_exec($process);
  $result = json_decode($response,TRUE);

  //print_r($response);
  if(($result != NULL) && (count($result['d']['results']) > 0)) {
        $answer = '<table ><tbody>';
        
        $i = 0;
        foreach ($result['d']['results'] as $key => $value) {
          if($i < 5){
            
          
           // print_r($value); exit();
            // $answer .= '
                        
            //              <tr><td>'.$value['Title'].'</td></tr>
            //              <tr> <td>'.$value['Description'].'</td></tr>
            //              <tr><td><a href="'.$value['DisplayUrl'].'" target="_blank">'.$value['Url'].'</a></td></tr>
            //              <tr><td><hr/></td></tr>
                         
                        
            //          ';

          $answer .= '<tr><td>';
            $answer .= '<div class="results">';
            $answer .= '<div class="answer_title"><b>'.$value['Title'].'</b></div>';
           $answer .= '<div class="answer_description">'.$value['Description'].'</div>';
            $answer .= '<div class="answer_url"><a href="'.$value['Url'].'">'.$value['DisplayUrl'].'</a></div>';
            $answer .= '</div>';
          //  $answer .= '<hr/>';
            $answer .= '</td></tr>';
            }
             $i++;
        }
        $answer .= ' </tbody>
                    </table>';
    } else {
        return ' ';
    }
    //print_r($result);
    //exit();
    return $answer;
}









function getAnswerFromWebhose($question) {
	//Your API key is: 24517f6b-35e8-473c-a84d-f4554ae70611
        //prepare data for cUrl
        $target_url = "https://webhose.io/search?token=24517f6b-35e8-473c-a84d-f4554ae70611&format=json&q=".$question;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST,0);
       // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $result = curl_exec ( $ch );
        $err = curl_errno ( $ch );
        $errmsg = curl_error ( $ch );
        $header = curl_getinfo ( $ch );
        $httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
        //print_r($result);
       // $result = trim($result);
        if(empty($result)) {
        	//echo "No results Found";
        	return ' ';
        } else {
        	//echo $result;

        	$result_webhose = json_decode($result,true);
        	//echo "<pre>";
        	//print_r($result_webhose);
        	$posts = $result_webhose['posts'];
        	$i=1;
        	$answer = '';
        	foreach ($posts as $key => $value)
			{
				//print_r($value);
				$answer .= '<div id="answer-who'.$i.'" class="results">';
		       	$answer .= '<div class="answer_title">'.$value['title'].'</div>';
		       // $answer .= '<div class="answer_description">'.$value['thread']['title_full'].'</div>';
		        $answer .= '<div class="answer_url"><a href="'.$value['thread']['url'].'">'.$value['thread']['url'].'</a></div>';
		        $answer .= '</div>';
		        $answer .= '<hr/>';
		        $i++;
			}

			return $answer;

        }

}


function getAnswerFromWolpharAlpha($question) {
        $answer = '';
          $_REQUEST['q'] = $question;
          $appID = '6TRP89-YWAVE28ALA';

         // if (!$queryIsSet) die();

          $qArgs = array();
          if (isset($_REQUEST['assumption']))
            $qArgs['assumption'] = $_REQUEST['assumption'];

          // instantiate an engine object with your app id
          $engine = new WolframAlphaEngine( $appID );

          // we will construct a basic query to the api with the input 'pi'
          // only the bare minimum will be used
          $response = $engine->getResults( $_REQUEST['q'], $qArgs);

          // getResults will send back a WAResponse object
          // this object has a parsed version of the wolfram alpha response
          // as well as the raw xml ($response->rawXML)

          // we can check if there was an error from the response object
          if ( $response->isError() ) {
            return ' ';

          }

          // if there are any pods, display them
        if ( count($response->getPods()) > 0 ) {


            $answer .= '<table class="u-full-width" >';
            foreach ( $response->getPods() as $pod ) {

            $answer .= '<tr>
                <td>
                <h3>'.$pod->attributes['title'].'</h3>';

                // each pod can contain multiple sub pods but must have at least one
                foreach ( $pod->getSubpods() as $subpod ) {
                  // if format is an image, the subpod will contain a WAImage object

                  $answer .= '<img src="'.$subpod->image->attributes['src'].'">
                  <hr>';

                }


             $answer .= '</td>
              </tr>';

            }

             $answer .= '</table>';

        }

        return $answer;
}
//getAnswerFromWolpharAlpha();
