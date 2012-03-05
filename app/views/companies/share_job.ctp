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
    <div id="user-info" style="display: none;"></div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

    <div id="fb-root"></div>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script>
      // initialize the library with the API key
      FB.init({ apiKey: '340495732660166' });

      // fetch the status on load
      FB.getLoginStatus(handleSessionResponse);

      $('#login').bind('click', function() {
        FB.login(handleSessionResponse);
      });

      $('#logout').bind('click', function() {
        FB.logout(handleSessionResponse);
      });

      $('#disconnect').bind('click', function() {
        FB.api({ method: 'Auth.revokeAuthorization' }, function(response) {
          clearDisplay();
        });
      });

      // no user, clear display
      function clearDisplay() {
        $('#user-info').hide('fast');
      }

      // handle a session response from any of the auth related calls
      function handleSessionResponse(response) {
        // if we dont have a session, just hide the user info
        if (!response.session) {
          clearDisplay();
          return;
        }

        // if we have a session, query for the user's profile picture and name
        FB.api(
          {
            method: 'fql.query',
            query: 'SELECT name, pic FROM profile WHERE id=' + FB.getSession().uid
          },
          function(response) {
            var user = response[0];
            $('#user-info').html('<img src="' + user.pic + '">' + user.name).show('fast');
          }
        );
      }

      function getFriends() {
        FB.api('/me/friends', function(response) {
            if(response.data) {
                $.each(response.data,function(index,friend) {
                    alert(friend.name + ' has id:' + friend.id);
                });
            } else {
                alert("Error!");
            }
      });
}

    </script>
  </body>
</html>
