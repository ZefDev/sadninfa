            <!--МОДАЛЬНОЕ ОКНО-->
	<div id="openModal2" class="modalDialog" >
		<div class="special_krest">
		<a href='#close' title='Закрыть' class='close'>X</a>
		<div class="modal" id="modal" >	
			
		
            <form method="POST" id="feedback-form" class="form_mini">
            <div class="vlock1">
            Как к Вам обращаться:<br>
            <input type="text" name="nameFF" required placeholder="фамилия имя отчество" x-autocompletetype="name">
            </div>
            <div class="vlock2">
            Телефон для связи:<br>
            <input type="text" name="phoneFF" required placeholder="телефонный номер" x-autocompletetype="phone">
            </div>
            <div class="vlock3">
            <br>Что бы вы хотели заказать:<br>
            <textarea  name="messageFF" required rows="1"></textarea>
            </div>
            <div class="vlock4">
            <input type="submit" value="ОТПРАВИТЬ" class="submit_button" style="width:150px;height:50px;background:#013d45;color:#fff;">
            </div>
            </form>

            <script>
            document.getElementById('feedback-form').addEventListener('submit', function(evt){
              var http = new XMLHttpRequest(), f = this;
              evt.preventDefault();
              http.open("POST", "includes/contacts.php", true);
              http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
              http.send("nameFF=" + f.nameFF.value + "&phoneFF=" + f.phoneFF.value + "&messageFF=" + f.messageFF.value);
              http.onreadystatechange = function() {
                if (http.readyState == 4 && http.status == 200) {
                  alert(' Ваше сообщение получено.\nНаши флористы перезвонят вам в ближайщее время.\nБлагодарим за интерес к нашему магазину!');    
                  f.messageFF.removeAttribute('value'); // очистить поле сообщения (две строки)
                  f.messageFF.value='';
                }
              }
              http.onerror = function() {
                alert('Извините, данные не были переданы');
              }
            }, false);
            </script>
            </div>
		</div>
	</div>
	<!--МОДАЛЬНОЕ ОКНО-->
