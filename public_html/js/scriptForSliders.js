
window.onload = function() {

  document.getElementById('new-slider').addEventListener('click', click_new_slider, false);
  document.getElementById('popular-slider').addEventListener('click', click_new_slider, false);
}

function click_new_slider(event){
  event = event || window.event
  var t = event.target;
  //alert(t.id);
  switch (t.id) {
  case 'new-next':
    var new_box_page = document.getElementById(t.id).alt;
     ajax({url: "includes/workingWithUser.php?tag=reload_new_slider",statbox:"new-boxes", 
      tag:"reload_new_slider", method:"POST", data: {new_box_page}});
    break;
   case 'new-prev':
    var new_box_page = document.getElementById(t.id).alt;
     ajax({url: "includes/workingWithUser.php?tag=reload_new_slider",statbox:"new-boxes", 
      tag:"reload_new_slider", method:"POST", data: {new_box_page}});
    break;
    case 'popular-next':
    var populer_box_page = document.getElementById(t.id).alt;
     ajax({url: "includes/workingWithUser.php?tag=reload_populer_slider",statbox:"popular-boxes", 
      tag:"reload_populer_slider", method:"POST", data: {populer_box_page}});
    break;
   case 'popular-prev':
    var populer_box_page = document.getElementById(t.id).alt;
     ajax({url: "includes/workingWithUser.php?tag=reload_populer_slider",statbox:"popular-boxes", 
      tag:"reload_populer_slider", method:"POST", data: {populer_box_page}});

    break;
  default:
    //alert("Какая-та уйня");
    break;
  }
}

function ajax(param)
{
        if (window.XMLHttpRequest) req = new XMLHttpRequest();
        method=(!param.method ? "POST" : param.method.toUpperCase());

        if(method=="GET")
        {
                       send=null;
                       param.url=param.url+"&ajax=true";
        }
        else
        {
                       send="";
                       for (var i in param.data) send+= i+"="+param.data[i]+"&";
                       send=send+"ajax=true";
        }
        req.open(method, param.url, true);
        if(param.statbox)document.getElementById(param.statbox).innerHTML = '';
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        req.send(send);
        req.onreadystatechange = function()
        {
           if (req.readyState == 4 && req.status == 200) //если ответ положительный
           {
               var a = req.responseText;
               //alert(a);
                var array = JSON.parse(a);
                d = document;
                /*change для подгрузки инфы в диологовые окна а update для обнавление записей*/
              if(param.tag == "reload_new_slider"){
                  d.getElementById('new-boxes').innerHTML =  array.new_slider;
                  d.getElementById('new-prev').alt =  array.new_prev;
                  d.getElementById('new-next').alt =  array.new_next;
              }
              else if(param.tag == "reload_populer_slider"){
                  d.getElementById('popular-boxes').innerHTML =  array.popular_slider;
                  d.getElementById('popular-prev').alt =  array.popular_prev;
                  d.getElementById('popular-next').alt =  array.popular_next;
                  //d.getElementById('popular-slider').innerHTML =  array.populer_slider;
              }
           }
        }
}