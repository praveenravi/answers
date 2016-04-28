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
        
       
        <!--   <select name="question_prefix" id="question_prefix">
            <option value="1">What</option>
            <option value="2">Why</option>
            <option value="3">How</option>
            <option value="4">When</option>
            <option value="5">Where</option>
            <option value="6">Who</option>
          </select> -->
          <div id="suggestion">suggestions</div>
          <input type="text" name="question" id="question" size="60" placeholder="Ask your questions">

          &nbsp;
          <button type="submit" class="button-primary" id="search">Search</button>
        

      




       
      </div>
    </div>


    <div class="row">
      
        <!-- SEARCH ENGINE RESULTS -->

        <div class="four columns">
        <p class="search-engine-label" style="display: none;">Google suggests:</p>
        <ul id="goog-suggestions" class="sugg-ul"></ul>
      </div>
      <div class="four columns">
        <p class="search-engine-label" style="display: none;">Bing suggests:</p>
        <ul id="bing-suggestions" class="sugg-ul"></ul>
      </div>
     <div class="four columns">
        <p class="search-engine-label" style="display: none;">Yahoo suggests:</p>
        <ul id="yahoo-suggestions" class="sugg-ul"></ul>
      </div>

      <!-- ENDS HERE-->

    </div>

    <div class="row">
      <div class="twelve columns"> 
   

          <!-- class="se-pre-con" Paste this code after body tag -->
          <div  id="loading_image" ></div>
          <!-- Ends -->
       
      <div id="answers" class="answers">
        
           



      </div>



      </div>
      <div class="four columns"> 
         

       </div>
    </div>


  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->

  <!-- The Modal -->
<div id="myModal" class="modal">
 <!-- Modal content -->
<div class="modal-content">
  <div class="modal-header">
    <span class="close">×</span>
    
  </div>
  <div class="modal-body">
   
  </div>
  <div class="modal-footer">
   <a href="#"> Save </a>
  </div>
</div>
  </div>

  <script src="js/jquery_and_jqueryui.js"></script>
  <script src="js/custom.js"></script>
</body>
</html>
