$(document).ready(function(){
  /****************************************************************
  *****************************************************************
  *Variables
  *****************************************************************
  ****************************************************************/
  //Temp manual user state variable
  var userLoggedIn = 'false';

  var loggedIn = '<li><p class="navbar-text">Welcome!</p></li>';


  /****************************************************************
  *****************************************************************
  *Set of default head tags to include
  *on every page that includes the main.js
  *file
  *****************************************************************
  ****************************************************************/

  $('head').append('<meta charset="utf-8">');
  //Set the default viewport size to the device width and set the initial zoom
  $('head').append('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
  //Link CSS stylesheets
  $('head').append('<link rel="stylesheet" type="text/css" href="css/bootstrap/bootstrap.min.css">');
  $('head').append('<link rel="stylesheet" type="text/css" href="css/logginDropDown.css">');
  $('head').append('<link rel="stylesheet" type="text/css" href="css/main.css">');

  /****************************************************************
  *****************************************************************
  *Include partial HTML elements from other html doctments
  *****************************************************************
  ****************************************************************/

  //Load partial html elements into the main DOM
  $("div[data-includeHTML]").each(function (){
    $(this).load($(this).attr("data-includeHTML"), function() {
      //Use load function's callback to manipulate partial elements after the content is loaded.
      loadedContent();
    });
  });

  //Edit HTML content after it is asynchronously loaded
  function loadedContent () {
    //temp method of setting user state
    if (userLoggedIn === 'false'){
      $('#headerLoginButton').load('include/loggedOut_Partial.html', function(){
        //manipulate partial elements here
      });
    } else {
      $('#headerLoginButton').html(loggedIn);
    }
  };

});
