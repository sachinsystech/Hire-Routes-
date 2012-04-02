<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <!--
    Copyright Facebook Inc.

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
  -->
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Connect JavaScript - jQuery Login Example</title>
  </head>
  <body>
    <h1>Connect JavaScript - jQuery Login Example</h1>
    <div>
      <button id="login">Login</button>
      <button id="logout">Logout</button>
      <button id="disconnect">Disconnect</button>
    </div>

    <script>

/*************************************************************/
       function fillLinkedinFriend(){
            //get list of facebook friend from ajax request
            $("#facebook").html("<img src='/img/loading.gif'>");
            $.ajax({
                type: 'POST',
                url: '/companies/getLinkedinFriendList',
                dataType: 'json',
                success: function(response){
                   switch(response.error){
                        case 0: // success
                            createHTMLforFacebookFriends(response.data);
                            break;
                        case 1: // we don't have user's facebook token
                            alert(response.message);
                            window.open(response.URL);
                            break;
                        case 2: // something went wrong when we connect with facebook.Need to login by facebook 
                            alert(response.message);
                            break;
                   }
            
                },
                error: function(message){
                    alert(message);
                }
            });
            
        }
/**************************************************************/

        
        function facebookComment(){
            usersId=$("input[class=facebookfriend]:checked").map(function () {return this.value;}).get().join(",");
            $.ajax({
                type: 'POST',
                url: '/companies/commentAtFacebook',
                dataType: 'json',
                data: "usersId="+usersId+"&message="+$("#message").val(),
                success: function(response){
                   switch(response.error){
                        case 0: // success
                            // show success message
                            break;
                        case 1: // we don't have user's facebook token
                            // show error message
                            break;
                   }
            
                },
                error: function(message){
                    alert(message);
                }
            });
        }


/****** linked in comment ******/


        function linkedInComment(){
            usersId=$("input[class=facebookfriend]:checked").map(function () {return this.value;}).get().join(",");
            $.ajax({
                type: 'POST',
                url: '/companies/sendMessagetoLinkedinUser',
                dataType: 'json',
                data: "usersId="+usersId+"&message="+$("#message").val(),
                success: function(response){
                   switch(response.error){
                        case 0: // success
                            // show success message
                            break;
                        case 1: // we don't have user's facebook token
                            // show error message
                            break;
                   }
            
                },
                error: function(message){
                    alert(message);
                }
            });
        }

/**********************/


        function fillFacebookFriend(){
            //get list of facebook friend from ajax request
            $("#facebook").html("<img src='/img/loading.gif'>");
            $.ajax({
                type: 'POST',
                url: '/companies/getFaceBookFriendList',
                dataType: 'json',
                success: function(response){
                   switch(response.error){
                        case 0: // success
                            createHTMLforFacebookFriends(response.data);
                            break;
                        case 1: // we don't have user's facebook token
                            alert(response.message);
                            window.open(response.URL);
                            break;
                        case 2: // something went wrong when we connect with facebook.Need to login by facebook 
                            alert(response.message);
                            break;
                   }
            
                },
                error: function(message){
                    alert(message);
                }
            });
            
        }

    function createHTMLforFacebookFriends(friends){
       
       length = friends.length;
       html="";        
       for(i=0;i<length;i++){
           html += '<div class="contactBox"><div style="position:relative"><div class="contactImage"><img src="' + friends[i].url +'" title="'+ friends[i].name + '"/></div><div class="contactCheckBox"><input class="facebookfriend" value="'+friends[i].id+'" type="checkbox"></div></div><div class="contactName">'+friends[i].name+'</div></div>';
       }
       $("#facebook").html(html);
    }
    </script>

    <div class="socialContainer">
        <div class="tabMenu">
            <div class="tabItem" title="facebook">Facebook</div>
            <div  id="linkedin">LinkedIn</div>
            <div class="tabItem" title="twitter">Twitter</div>
            <div class="tabItem" title="email">Email</div>
        </div>
        <div class="tabContainer">
            <div id="facebook">testtststs</div>
            <div id="linkedin"></div>
            <div id="twitter"></div>
            <div id="email"></div>
        </div>
    </div>

    All <input type="checkbox" onclick='var flag=this.checked; $(".facebookfriend").each(function(){ this.checked = flag; });
'> 
        <textarea id="message"></textarea>
        <input type="button" onclick="linkedInComment();" value="Send">
    <script>
        //fillFacebookFriend();
        fillLinkedinFriend();
    </script>
  </body>
</html>

