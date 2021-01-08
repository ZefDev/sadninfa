window.onload = function() {

var isSelectedProduct = false;

document.getElementById('load').addEventListener('change', selectMainFile, false);
document.getElementById('tableProduct').addEventListener('click', clickCell, false);
document.getElementById('tableCategory').addEventListener('click', clickCell, false);
document.getElementById('tableUser').addEventListener('click', clickCell, false);

document.getElementById('mainPhoto').addEventListener('change', selectMainFile, false);
document.getElementById('clearphoto').addEventListener('click', clearphoto, false);
document.getElementById('clearphotoModal').addEventListener('click', clearphotoModal, false);
document.getElementById('loadModal').addEventListener('change', handleFileSelectModal, false);
//document.getElementById('updateProduct').addEventListener('click', updateProduct, false);
document.getElementById('delCategory').addEventListener('click', delCategories, false);
document.getElementById('saveCategory').addEventListener('click', saveCategory, false);
document.getElementById('saveUser').addEventListener('click', saveUser, false);
document.getElementById('delUser').addEventListener('click', delUser, false);
document.getElementById('addUser').addEventListener('click', addUser, false);
document.getElementById('pagerProduct').addEventListener('click', pagerProduct, false);
document.getElementById('selectAllProduct').addEventListener('click', selectAll, false);
document.getElementById('searching_products').addEventListener('click', searching_products, false);
document.getElementById('addCategory').addEventListener('click', addCategory, false);
document.getElementById('selectAllCategory').addEventListener('click', selectAll, false);
document.getElementById('searching_categorys').addEventListener('click', searching_categorys, false);
document.getElementById('pagerCategory').addEventListener('click', pagerCategory, false);

function debounce(func, wait, immediate) {
      var timeout;
      return function() {
        var context = this, args = arguments;
        var later = function() {
          timeout = null;
          if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
      };
    };
     
    // Использование
    var myEfficientFn = debounce(function() {
     checked_name_product();
    }, 2000);
    //window.
    //window.addEventListener('resize', myEfficientFn);
    document.getElementById('name').addEventListener('keypress', myEfficientFn);
//document.getElementById('name').addEventListener('onkeypress', checked_name_product);

/*function debounce(func, wait, immediate) {
  var timeout;
  return function() {
    var context = this, args = arguments;
    var later = function() {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
};
 
// Использование
var checked_name_product = debounce(function() {
var title = document.getElementById('name').value.trim();
  ajax({url: "includes/workingWithBase.php?tag=checked_name_product", tag:"checked_name_product", method:"POST", data: { title}});
}, 250);*/

/*Функция для перехода по страницам продуктов*/
function pagerCategory(event){
   event = event || window.event
  var t = event.target;
  var array; 
  //alert(t.id);
  switch (t.tagName) {
  case 'A':
      var page = t.id;
      var per_page = document.getElementById('selectPerPageCategory').value;
      var filter_title_category = document.getElementById('filter_title_category').value;
      ajax({url: "includes/workingWithBase.php?tag=refresh_table_category",statbox:"tableCategory", tag:"refresh_table_category", method:"POST", data: { page,per_page,filter_title_category}});
    
    break;
  default:
    //alert("Какая-та уйня");
    break;
}
}

/*Это функция для выбора количества отображаемы продуктов на странице*/
var selectPerPageCategory = document.getElementById('selectPerPageCategory'); 
selectPerPageCategory.addEventListener("change", function (e) {
  //alert();
    var page = 1;
    var per_page = selectPerPageCategory.value;
    var filter_title_category = document.getElementById('filter_title_category').value;
      ajax({url: "includes/workingWithBase.php?tag=refresh_table_category",statbox:"tableCategory", tag:"refresh_table_category", method:"POST", data: { page,per_page,filter_title_category}});
});

/*Эта функция висит на поле ввода поиска категорий*/
 var input_filter_category = document.getElementById('filter_title_category');
  input_filter_category.addEventListener("keyup",function(event){
    if(event.keyCode == 13){
        textRequest = document.getElementById('filter_title_category').value;
        var page = 1;
        var per_page = selectPerPageCategory.value;
        var filter_title_category = document.getElementById('filter_title_category').value;
        ajax({url: "includes/workingWithBase.php?tag=refresh_table_category",statbox:"tableCategory", tag:"refresh_table_category", method:"POST", data: { page,per_page,filter_title_category}});
    }
});

/*Эта функция висит на кнопке поиска продуктов, так же поиск работает и при переходе страниц и т.д*/
function searching_categorys(){
  //alert();
    var page = 1;
    var per_page = selectPerPageCategory.value;
    var filter_title_category = document.getElementById('filter_title_category').value;
    ajax({url: "includes/workingWithBase.php?tag=refresh_table_category",statbox:"tableCategory", tag:"refresh_table_category", method:"POST", data: { page,per_page,filter_title_category}});

}

function addCategory(){
  var title = document.getElementById('title_category').value;
  //alert(title);
        ajax({url: "includes/workingWithBase.php?tag=add_category",statbox:"notify-category", tag:"add_category", 
          method:"POST", data: { title}});

}

/*Эта функция висит на поле ввода поиска продуктов*/
 var inputFilter = document.getElementById('filter_title_product');
  inputFilter.addEventListener("keyup",function(event){
    if(event.keyCode == 13){
        textRequest = document.getElementById('filter_title_product').value;
        var page = 1;
        var per_page = selectPerPage.value;
        var filter_title_product = document.getElementById('filter_title_product').value;
        ajax({url: "includes/workingWithBase.php?tag=refresh_table_product",statbox:"tableProduct", tag:"refresh_table_product", method:"POST", data: { page,per_page,filter_title_product}});
    }
});

/*Эта функция висит на кнопке поиска продуктов, так же поиск работает и при переходе страниц и т.д*/
function searching_products(){
  //alert();
    var page = 1;
    var per_page = selectPerPage.value;
    var filter_title_product = document.getElementById('filter_title_product').value;
    ajax({url: "includes/workingWithBase.php?tag=refresh_table_product",statbox:"tableProduct", tag:"refresh_table_product", method:"POST", data: { page,per_page,filter_title_product}});

}

/*Это функция для выбора количества отображаемы продуктов на странице*/
var selectPerPage = document.getElementById('selectPerPage'); 
selectPerPage.addEventListener("change", function (e) {
    var page = 1;
    var per_page = selectPerPage.value;var filter_title_product = document.getElementById('filter_title_product').value;
    var filter_title_product = document.getElementById('filter_title_product').value;
      ajax({url: "includes/workingWithBase.php?tag=refresh_table_product",statbox:"tableProduct", tag:"refresh_table_product", method:"POST", data: { page,per_page,filter_title_product}});
});

/*Это функция для выделения всех чекбоксов в таблице продукты или категории*/
function selectAll(event){
    var checks=document.getElementsByName(this.name);
    var array = new Array();
    var count =0;
    isSelectedProduct = !isSelectedProduct;
        for (i=0; i<checks.length; i++){
            checks[i].checked = isSelectedProduct;
        }
}

  

/*Функция для перехода по страницам продуктов*/
function pagerProduct(event){
   event = event || window.event
  var t = event.target;
  var array; 
  //alert(t.id);
  switch (t.tagName) {
  case 'A':
      var page = t.id;
      var per_page = document.getElementById('selectPerPage').value;
      var filter_title_product = document.getElementById('filter_title_product').value;
      ajax({url: "includes/workingWithBase.php?tag=refresh_table_product",statbox:"tableProduct", tag:"refresh_table_product", method:"POST", data: { page,per_page,filter_title_product}});
    
    break;
  default:
    //alert("Какая-та уйня");
    break;
}
}

/*Для выобра многих картинки*/
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
/*Для выобра одной картинки*/
function selectMainFile(evt) {
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
                var img = document.getElementById('mainPhoto');
                img.src = e.target.result;
                //var span = '<img width="200" height="200" class="thumb" title="'+ escape(theFile.name)+ '" src="'+ e.target.result+ '" />';
                //document.getElementById('containerMainPhoto').innerHTML = span;
            };
        })(f);
        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
    }
}


//document.getElementById('clearDate').addEventListener('click', clearDate, false);

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
                var img = document.getElementById('photoModal');
                img.src = e.target.result;
                //document.getElementById('containerModal').insertBefore(span, null);
            };
        })(f);
        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
    }
}


}

function clearphoto(){
   var img = document.getElementById('mainPhoto');
   img.src = "img/nophoto.jpg";
   document.getElementById("load").value = "";
   //var inputFile = document.getElementById('load').files;
}

function clearphotoModal(){
   var img = document.getElementById('photoModal');
   img.src = "img/nophoto.jpg";
   document.getElementById("loadModal").value = "";
   var id = document.getElementById('codModal').value;
    //$('.del').click(function (e) { var image = $(this).attr("src"); var delete_var = 'act=delete_image&image='+image+'';
   ajax({url: "includes/workingWithBase.php?tag=del_photo",tag:"del_photo",statbox:"photoModal", method:"POST", data: { id}
    });
}

function clearDate(){
  document.getElementById('datestart').value = "";
  document.getElementById('dateend').value = "";
}

function saveUser(){
  var id = document.getElementById('idUser').value;
  var login = document.getElementById('login').value;
  var password = document.getElementById('password').value;
  ajax({url: "includes/workingWithBase.php?tag=save_user", tag:"save_user",statbox:"tableUser", method:"POST", data: { id,login,password},
        success:function(data){document.getElementById("tableUser").innerHTML=data;}
    });
}

function delUser(){
  var checks=document.getElementsByName("users");
  var array = new Array();
  var count =0;
  for (i=0; i<checks.length; i++){
      if (checks[i].checked){
          array[count] = checks[i].id;
          count++;
      }
  }
  
  ajax({url: "includes/workingWithBase.php?tag=del_user", tag:"del_user", statbox:"tableUser", method:"POST", data: { array},
        success:function(data){document.getElementById("tableUser").innerHTML=data;}
    });
}
function addUser(){
  var loginUser = document.getElementById('loginUser').value;
  var passwordUser =  document.getElementById('passwordUser').value;
  var doublePasswordUser = document.getElementById('doublePasswordUser').value; 
  var isloginUser = validate('loginUser');
  var ispasswordUser = validate('passwordUser');
  var ispasswordUser = validate('passwordUser');
  if(isloginUser && ispasswordUser && ispasswordUser)
  {
    if(passwordUser == doublePasswordUser){
      ajax({url: "includes/workingWithBase.php?tag=add_user",tag:"add_user", statbox:"notify-user", method:"POST", data: { loginUser,passwordUser},
            success:function(data){document.getElementById("tableUser").innerHTML=data;}
        });
    }
    else{
       d.getElementById('notify-user').innerHTML = 'Пароли не совпадают';
    }
  }
  else{
    d.getElementById('notify-user').innerHTML = 'Заполните выделенные поля';
  }
}  

function saveCategory(){
  var id = document.getElementById('idCategory').value;
  var title = document.getElementById('titleCategory').value;
  ajax({url: "includes/workingWithBase.php?tag=save_category", tag:"save_category",statbox:"tableCategory", method:"POST", data: { id,title},
        success:function(data){document.getElementById("tableCategory").innerHTML=data;}
    });
}

function clickCell(event) {

  event = event || window.event
  var t = event.target;
  var array; 
  switch (this.id) {
  case 'tableProduct':
    if(t.parentNode.tagName=="TR") {
      array = t.parentNode.getElementsByTagName("td");
    }
    else{
      array = t.parentNode.parentNode.getElementsByTagName("td");
    }
    var td;
    if(t.id =='change'){
      var id = document.getElementById('codModal').value = array[1].innerHTML;
      ajax({url: "includes/workingWithBase.php?tag=change_product", tag:"change_product", method:"POST", data: { id}});
    }
    
    break;
  case 'tableCategory':
      if(t.parentNode.tagName=="TR") {
        array = t.parentNode.getElementsByTagName("td");
      }
      else{
        array = t.parentNode.parentNode.getElementsByTagName("td");
      }
    if(t.id =='changeCategory'){
      //document.getElementById('idCategory').value = array[1].innerHTML;
      //document.getElementById('titleCategory').value = array[2].innerHTML;
      var elements = document.getElementsByClassName('titleCategory');
      for(var i=0; i<elements.length; i++)
      {
          if(elements[i].children.length>0){
              //alert(elements[i].children.length);
               elements[i].innerHTML = elements[i].childNodes[0].value;
               elements[i].id="";
          }
      }
      
      var str = array[2].innerHTML;
      if(str.indexOf('input')<0){
          array[2].innerHTML = "<input id='editField' type='text' value='"+array[2].innerHTML+"' onClick='changeCategory("+array[1].innerHTML+");'>";
          array[2].id="tdd";
      }
      //alert(str.indexOf('input'));
    }
    break;
   case 'tableUser':
      if(t.parentNode.tagName=="TR") {
        array = t.parentNode.getElementsByTagName("td");
      }
      else{
        array = t.parentNode.parentNode.getElementsByTagName("td");
      }
    if(t.id =='changeUser'){
      var id = document.getElementById('idUser').value = array[1].innerHTML;
      ajax({url: "includes/workingWithBase.php?tag=change_user", tag:"change_user", method:"POST", data: { id}});
    
    }
    break;
  default:
    //alert("Какая-та уйня");
    break;
}
    
}

function delProduct(){
  var checks=document.getElementsByName("products");
  var array = new Array();
  var count =0;
  for (i=0; i<checks.length; i++){
      if (checks[i].checked){
          array[count] = checks[i].id;
          count++;
      }
  }
  if(count!=0){
      ajax({url: "includes/workingWithBase.php?tag=del_product", tag:"del_product", statbox:"tableProduct", method:"POST", data: { array},
            success:function(data){document.getElementById("tableProduct").innerHTML=data;}
        });
  }
}

function delCategories(){
  var checks=document.getElementsByName("categories");
  var array = new Array();
  var count =0;
  for (i=0; i<checks.length; i++){
      if (checks[i].checked){
          array[count] = checks[i].id;
          count++;
      }
  }
  
    if(count!=0){
      ajax({url: "includes/workingWithBase.php?tag=del_category", tag:"del_category", statbox:"tableCategory", method:"POST", data: { array},
        success:function(data){document.getElementById("tableCategory").innerHTML=data;}
    });
    }
}

function first(id){
  ajax({url: "includes/workingWithBase.php?tag=del_product", tag:"del_product", statbox:"tableProduct", method:"POST", data: { id},
        success:function(data){document.getElementById("tableProduct").innerHTML=data;}
    });
}  

//document.getElementById('add').addEventListener('click', addProduct, false);
var id = document.getElementById('idCategory').value;
  var title = document.getElementById('titleCategory').value;
  ajax({url: "includes/workingWithBase.php?tag=save_category", tag:"save_category",statbox:"tableCategory", method:"POST", data: { id,title},
        success:function(data){document.getElementById("tableCategory").innerHTML=data;}
    });
function changeCategory(id){
    var td = document.getElementById('tdd');
    var editField = document.getElementById('editField');
    editField.addEventListener("keyup",function(event){
    if(event.keyCode == 13){
        var title = editField.value;
        td.innerHTML = editField.value;
        td.id="";
        ajax({url: "includes/workingWithBase.php?tag=save_category", tag:"save_category",method:"POST", data: { id,title}
         });
    }
});
};


function addProduct(){
  var name = document.getElementById('name').value;
  var coast =  document.getElementById('coast').value;
  var category = document.getElementById('selectСategory').value; 
  ajax({url: "includes/workingWithBase.php?tag=add_product", statbox:"tableProduct", method:"POST", data: { name,coast,category},
        success:function(data){document.getElementById("tableProduct").innerHTML=data;}
    });
} 

function checked_name_product(){
  var title = document.getElementById('name').value.trim();
  ajax({url: "includes/workingWithBase.php?tag=checked_name_product", tag:"checked_name_product", method:"POST", data: { title}});
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
                      if(param.tag == "change_product"){
                            d.getElementById('codModal').value =  array.id;
                            d.getElementById('nameModal').value =  array.title;
                            d.getElementById('coastModal').value =  array.coast;
                            d.getElementById('selectСategoryModal').innerHTML = array.selectСategoryModal;
                            var arrayCategory =  d.getElementById('selectСategoryModal');
                            for (var i = 0; i < arrayCategory.length; i++) {
                              if(arrayCategory[i].innerText == array.titleCategory){
                                arrayCategory.selectedIndex = i;
                              }
                            }
                            

                            d.getElementById('descriptionModal').value =  array.description;
                            if(array.isNew =="on"){
                              array.isNew = true;
                            }
                            else{
                              array.isNew = false;
                            }
                            if(array.isPopuler =="on"){
                              array.isPopuler = true;
                            }
                            else{
                              array.isPopuler = false;
                            }
                            d.getElementById('isNewModal').checked  =   array.isNew;
                            d.getElementById('isPopulerModal').checked  =  array.isPopuler;
                            d.getElementById('photoModal').src = array.photo;
                       
                           // var id = document.getElementById('codModal').value = array[1].innerHTML;
                           // document.getElementById('nameModal').value = array[2].innerHTML;
                            //document.getElementById('coastModal').value = array[3].innerHTML;
                      }
                      else if(param.tag == "del_photo"){
                        //d.getElementById('tableProduct').innerHTML = array.tableProduct;
                      } 
                      else if(param.tag == "del_product"){
                        d.getElementById('tableProduct').innerHTML = array.tableProduct;
                        d.getElementById('pagerProduct').innerHTML = array.pagerProduct;
                      }
                      else if(param.tag == "update_product"){
                          d.getElementById('tableProduct').innerHTML = array.tableProduct;
                          d.getElementById('pagerProduct').innerHTML = array.pagerProduct;
                      } 
                      else if(param.tag =="add_category"){
                        d.getElementById('tableCategory').innerHTML = array.tableCategory;
                        d.getElementById('notify-category').innerHTML = array.message;
                        d.getElementById('selectСategory').innerHTML = array.listCategory;
                        document.getElementById('title_category').value = "";
                      }
                      else if(param.tag == "save_category"){
                          //d.getElementById('tableCategory').innerHTML = array.tableCategory;
                      }
                      else if(param.tag == "del_category"){
                          d.getElementById('tableCategory').innerHTML = array.tableCategory;
                      }
                      else if(param.tag == "change_user"){
                        d.getElementById('idUser').value = array.id;
                        d.getElementById('login').value = array.login;
                        d.getElementById('password').value = array.password;
                      }
                      else if(param.tag == "save_user"){
                         d.getElementById('tableUser').innerHTML = array.tableUser;
                      }
                      else if(param.tag == "del_user"){
                          d.getElementById('tableUser').innerHTML = array.tableUser;
                      }
                      else if(param.tag == "add_user"){
                          d.getElementById('tableUser').innerHTML = array.tableUser;
                          d.getElementById('notify-user').innerHTML = array.resultRequest;
                          //alert(array.resultRequest);
                      }
                      else if(param.tag == "refresh_table_product"){
                          d.getElementById('tableProduct').innerHTML = array.tableProduct;
                          d.getElementById('pagerProduct').innerHTML = array.pagerProduct;
                      }
                      else if(param.tag == "refresh_table_category"){
                          d.getElementById('tableCategory').innerHTML = array.tableCategory;
                          d.getElementById('pagerCategory').innerHTML = array.pagerCategory;
                      }
                      else if(param.tag =="checked_name_product"){
                        if(array.answer=="true"){
                          document.getElementById('label_for_name').innerHTML='Наименование не занято';
                          document.getElementById('label_for_name').style.color='green';
                        }
                        else{
                          document.getElementById('label_for_name').innerHTML='Наименование уже занято';
                          document.getElementById('label_for_name').style.color='red';
                        }
                      }
                   }
                }
}

function updateProduct(){
  var id = document.getElementById('codModal').value;
  var name = document.getElementById('nameModal').value;
  var coast =  document.getElementById('coastModal').value;
   var images =  document.getElementById('loadModal').value;
  ajax({url: "includes/workingWithBase.php?tag=updateProduct", tag: "updateProduct", statbox:"tableProduct", method:"POST", data: { id,name,coast,images}
    });
}

function validate(id){
   //Считаем значения из полей name и email в переменные x и y
   //alert(id);
   var x = document.getElementById(id).value;
   //Если поле name пустое выведем сообщение и предотвратим отправку формы
   if (x.length==0){
      document.getElementById(id).placeholder="*данное поле обязательно для заполнения";
      return false;
   }
   return true;
   //Если поле email пустое выведем сообщение и предотвратим отправку формы
/*
   //Проверим содержит ли значение введенное в поле email символы @ и .
   at=y.indexOf("@");
   dot=y.indexOf(".");
   //Если поле не содержит эти символы знач email введен не верно
   if (at<1 || dot <1){
      document.getElementById("emailf").innerHTML="*email введен не верно";
      return false;
   }*/
}


