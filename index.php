<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>ans </title>
  <meta name="description" content="Answer your problems">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">
  <link rel="stylesheet" href="css/custom.css">


   <!-- Scripts
  –––––––––––––––––––––––––––––––––––––––––––––––––– 
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
   <!-- <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>-->
  <script src="js/jquery-1.11.2.js"></script>
  <script src="js/custom.js"></script>


  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div class="twelve columns" id="question_area">
        
       
          <select name="question_prefix" id="question_prefix">
            <option value="1">What</option>
            <option value="2">Why</option>
            <option value="3">How</option>
            <option value="4">When</option>
            <option value="5">Where</option>
            <option value="6">Who</option>
          </select>
          <div id="suggestion">suggestions</div>
          <input type="text" name="question" id="question" size="60" placeholder="Ask your questions">

          &nbsp;
          <button type="submit" class="button-primary" id="search">Search</button>
        
       
      </div>
    </div>

    <div class="row">
      <div class="twelve columns"> 
        <table id="loading_image" class="u-full-width">
          <tr><td>
             <img src="images/478.GIF" >    
     
          </td></tr>
        </table>
       
      <div id="answers" class="answers">
        
           



      </div>



      </div>
      <div class="four columns"> 
         

       </div>
    </div>


  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
