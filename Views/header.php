<!doctype html>
<html lang="en">

<head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="<?php echo CSS_PATH; ?>bootstrap.min.css">

     <link rel="stylesheet" href="<?php echo CSS_PATH; ?>estilos.css">
     <link rel="stylesheet" href="<?php echo CSS_PATH; ?>uikit.min.css">

     <link rel="application/javascript" href="<?php echo JS_PATH; ?>bootstrap.min.js">

     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

     <title>Movie-Pass</title>

     <!-- no sirve de mucho por que se llama al footer y header en index.php 
     seria interesante cambiarlo pero no encuentro una manera limpia de dejarlo (
          $REQUEST = new Request();
          
          if ($REQUEST->getcontroller() == "AjaxRequest") 
	          Router::Route($REQUEST);
	
          else {
	          require_once(VIEWS_PATH . "header.php");

	          Router::Route($REQUEST);

	          require_once(VIEWS_PATH . "footer.php");
          }
     ) 
     
     no es agradable a la vista limpio --^

     <script>
          function SendAjaxRequest(request, method, url, funct) {
               if (typeof url != 'string')
                    return;

               method = method == "GET" ? "GET" : "POST";

               var keys = Object.keys(request);
               var param = "";

               keys.forEach((key, index) => {
                    if (param != "")
                         param += "&";

                    param += key + "=" + request[key];
               });

               var xmlhttp;

               function Request() {
                    xmlhttp = new XMLHttpRequest();

                    xmlhttp.onreadystatechange = function() {
                         if (this.readyState == 4 && this.status == 200) {
                              funct(this.responseText);
                         }
                    };

                    switch (method) {
                         case "GET":
                              xmlhttp.open(method, url + "?" + param, true);
                              xmlhttp.send();

                              break;

                         case "POST":
                              xmlhttp.open(method, url, true);
                              xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                              xmlhttp.send(param);

                              break;
                    }
               }

               Request()
          }
     </script>

     <script>
          SendAjaxRequest({id: 17}, 'POST', '?php echo FRONT_ROOT ?AjaxRequest/GetFunctionStatistics', (string) => {
               console.log(string);
          });
     </script>
     -->
</head>

<body>