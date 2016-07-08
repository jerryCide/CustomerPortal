  <link rel="stylesheet" href="css/jquery-ui.css">
  
  
  <!--<link rel="stylesheet" href="http://jqueryui.com/jquery-wp-content/themes/jqueryui.com/style.css">-->
  
  <style>
  .ui-autocomplete-loading {
    background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat;
  }
  </style>
  <script>
  $(function() {
    function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }
 
    $( "#username_input" ).autocomplete({
      source: "php/search.username.json.php",
      minLength: 2,
      select: function( event, ui ) {
		  //when item is selected perform action here
        /*log( ui.item ?
          "Selected: " + ui.item.value + " aka " + ui.item.id :
          "Nothing selected, input was " + this.value );*/
      }
    });
  });
  </script>
</head>
<body>
 <div style="height:100px">
 </div>
 
<div class="ui-widget">
  <label for="username_input">User: </label>
  <input id="username_input" class="form-control">
</div>
 
<div class="ui-widget" style="margin-top:2em; font-family:Arial">
  Result:
  <div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
</div>
 
 
