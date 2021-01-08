window.onload = function() {

 alert("fdsfsfs");
function handleFileSelect(evt) {
    var file = evt.target.files; // FileList object
    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = file[i]; i++) {
        // Only process image files.
        if (!f.type.match('image.*')) {
            alert("Image only please....");
        }
        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = (function (theFile) {
            return function (e) {
                // Render thumbnail.
                var span = document.createElement('span');
                span.innerHTML = ['<img width="200" height="200" class="thumb" title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
                document.getElementById('container').insertBefore(span, null);
            };
        })(f);
        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
    }
}
document.getElementById('load').addEventListener('change', handleFileSelect, false);
document.getElementById('tableProduct').addEventListener('click', clickCell, false);
document.getElementById('tableCategory').addEventListener('click', clickCell, false);

function handleFileSelectModal(evt,id,name,coast) {
    var file = evt.target.files; // FileList object
    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = file[i]; i++) {
        // Only process image files.
        if (!f.type.match('image.*')) {
            alert("Image only please....");
        }
        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = (function (theFile) {
            return function (e) {
                // Render thumbnail.
                //document.getElementById('containerModal').innerHTML="";
                var span = document.createElement('span');
                span.innerHTML = ['<img width="200" height="200" class="thumb" title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
                document.getElementById('containerModal').insertBefore(span, null);
            };
        })(f);
        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
    }
  /*document.getElementById('codModal').value = id;
  document.getElementById('nameModal').value = name;
  document.getElementById('coastModal').value = coast;*/
}
document.getElementById('loadModal').addEventListener('change', handleFileSelectModal, false);
//document.getElementById('updateProduct').addEventListener('click', updateProduct, false);

}

function clickCell(event) {
 
  event = event || window.event
  var t = event.target;
  alert(this.id);
  //alert(t.parentNode.tagName);
  var array; 
  alert(typeof(this.id));
  switch (this.id) {
  case 'tableProduct':
    if(t.parentNode.tagName=="TR") {
      array = t.parentNode.getElementsByTagName("td");
    }
    else{
      array = t.parentNode.parentNode.getElementsByTagName("td");
    }
    var td;
    var str="";

    var id = document.getElementById('codModal').value = array[0].innerHTML;
    document.getElementById('nameModal').value = array[1].innerHTML;
    document.getElementById('coastModal').value = array[2].innerHTML;
    ajax({url: "workingWithBase.php?tag=load_products_images", statbox:"containerModal", method:"POST", data: { id},
          success:function(data){document.getElementById("containerModal").innerHTML=data;}
      });
    break;
  case 'tableCategory':
    break;
  default:
    alert("Какая-та уйня");
    break;

    
}

function first(id){
  ajax({url: "workingWithBase.php?tag=del_product", statbox:"txt_2", method:"POST", data: { id},
        success:function(data){document.getElementById("txt_2").innerHTML=data;}
    });
}  

//document.getElementById('add').addEventListener('click', addProduct, false);

function addProduct(){
  var name = document.getElementById('name').value;
  var coast =  document.getElementById('coast').value;
  ajax({url: "workingWithBase.php?tag=add_product", statbox:"txt_2", method:"POST", data: { name,coast},
        success:function(data){document.getElementById("txt_2").innerHTML=data;}
    });
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
                if(param.statbox)document.getElementById(param.statbox).innerHTML = '<p>Я загружаю, не мешай!!!</p>';
                req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                req.send(send);
                req.onreadystatechange = function()
                {
                               if (req.readyState == 4 && req.status == 200) //если ответ положительный
                               {
                                               if(param.success)param.success(req.responseText);      
                               }
                }
}

function updateProduct(){
  var id = document.getElementById('codModal').value;
  var name = document.getElementById('nameModal').value;
  var coast =  document.getElementById('coastModal').value;
   var images =  document.getElementById('loadModal').value;
  ajax({url: "workingWithBase.php?tag=update_product", statbox:"txt_2", method:"POST", data: { id,name,coast,images},
        success:function(data){document.getElementById("txt_2").innerHTML=data;}
    });
}


