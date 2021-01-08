
var textRequest ="";
var category = 0;

window.onload = function() {
	/*Подсказка для поиска*/
	var full_searching = document.getElementById('full_searching');
  	full_searching.addEventListener("keyup",function(event){
    //if(event.keyCode == 13){
        var full_searching = document.getElementById('full_searching').value;
        ajax({url: "includes/loadingMainPage.php?tag=prompt_for_searching",statbox:"result_searching", tag:"prompt_for_searching", method:"POST", data: {full_searching}});
    //}
});
    /*Поиск по продутам который возвращает содержимое*/
    var button_searching = document.getElementById('searching_product');
    button_searching.addEventListener("click",function(event){
    //if(event.keyCode == 13){
        var full_searching = document.getElementById('full_searching').value;
        ajax({url: "includes/loadingMainPage.php?tag=full_searching",statbox:"types-blocks", tag:"full_searching", method:"POST", data: {full_searching}});
    //}
});
/**/




}


function flex(x){
  var full_searching = document.getElementById('full_searching');
  var page = x;
  category = 
 ajax({url: "includes/loadingMainPage.php?tag=full_searching",statbox:"types-blocks", tag:"full_searching", method:"POST", data: {full_searching,page,category}});
    //}
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
              if(param.tag == "prompt_for_searching"){
                    d.getElementById('result_searching').innerHTML =  array.result_searching;
              }
              else if(param.tag == "full_searching"){
                    d.getElementById('types-blocks').innerHTML =  array.result_searching;
                    alert(array.pager);
                    d.getElementById('types-pages').innerHTML =  array.pager;
              }
           }
        }
}