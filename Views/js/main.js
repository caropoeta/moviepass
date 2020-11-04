function Print(string) {
  var out = document.getElementById("out");

  out.innerHTML += "</br>" + string;
  out.scrollTop = out.scrollHeight;
}

function Send(request, method, url, funct) {
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

    xmlhttp.onreadystatechange = function () {
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