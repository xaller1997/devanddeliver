**Sign In**
----
  Route used for sign in.

* **URL**

  api/auth/login

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

   **Required:**
 
   `email=[required|email]`
   
   `password=[required|string|min:6]`

* **Success Response:**

  * **Code:** 200 OK<br />
    **Content example:** `{"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYwNTA5NTg3OSwiZXhwIjoxNjA1MDk5NDc5LCJuYmYiOjE2MDUwOTU4NzksImp0aSI6InNrMWxMaTg3Y1poZHBKVlgiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.mdG9PbVgaA-LlAQfurc1Pmj-_H92j3A-oY7HUafid6c","token_type":"bearer","expires_in":3600,"user":{"id":1,"name":"Grzegorz","email":"email@gmail.com","email_verified_at":null,"hero_id":1,"created_at":"2020-11-10T19:20:34.000000Z","updated_at":"2020-11-10T19:20:34.000000Z"}}`
 
* **Error Response:**

  * **Code:** 422 Unprocessable Entity <br />
    **Content example:** `{"email":["The email must be a valid email address."],"password":["The password must be at least 6 characters."]}`

  OR

  * **Code:** 401 Unauthorized <br />
    **Content:** `{"error":"Unauthorized"}`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/auth/login",
      method: "post",
      dataType: "json",
      data: {
          email: "email@gmail.com",
          password: "password"
      },
      success : function(response) {
        console.log(response);
      }
    });
  ```
---

**Sign Up**
----
  Route used for sign up.

* **URL**

  api/auth/register

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

   **Required:**
 
   `email=[required|string|email|max:100|unique:users]`
   
   `password=[required|string|confirmed|min:6]`
   
   `password_confirmation=[required|string]`
   
   **Not Required:**
   
   `name=[nullable|string|between:2,100]`

* **Success Response:**

  * **Code:** 201 Created <br />
    **Content example:** `{"message":"User successfully registered","user":{"name":"Grzegorz","email":"email@gmail.com","hero_id":1,"updated_at":"2020-11-11T12:08:55.000000Z","created_at":"2020-11-11T12:08:55.000000Z","id":1}}`
 
* **Error Response:**

  * **Code:** 400 Bad Request <br />
    **Content example:** `{"email":["The email has already been taken."],"password":["The password confirmation does not match.","The password must be at least 6 characters."]}`

  OR

  * **Code:** 400 Bad Request <br />
    **Content:** `{"error":"API did not return required data"}`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/auth/register",
      method: "post",
      dataType: "json",
      data: {
          email: "email@gmail.com",
          password: "password",
          password_confirmation: "password"
      },
      success : function(response) {
        console.log(response);
      }
    });
  ```
---

**Logout**
----
  Route used for logout.

* **URL**

  api/auth/logout

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

   None

* **Success Response:**

  * **Code:** 200 OK <br />
    **Content example:** `{"message":"User successfully signed out"}`
 
* **Error Response:**

  * **Code:** 401 Unauthorized <br />
    **Content:** `{"error":"Unauthorized"}`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/auth/logout",
      method: "post",
      dataType: "json",
      success : function(response) {
        console.log(response);
      }
    });
  ```
---

**Refresh Token**
----
  Route used for refresh token.

* **URL**

  api/auth/refresh

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

   None

* **Success Response:**

  * **Code:** 200 OK <br />
    **Content example:** `{"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9yZWZyZXNoIiwiaWF0IjoxNjA1MDk3MzQ5LCJleHAiOjE2MDUxMDA5NjIsIm5iZiI6MTYwNTA5NzM2MiwianRpIjoienZabWRVTHpYVmR4ODh2MCIsInN1YiI6MywicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.QDoXZtEzM2JTW2-uAKek4HEWvjIqyVf6RhYuT3u1L98","token_type":"bearer","expires_in":3600,"user":{"id":1,"name":"Grzegorz","email":"email@gmail.com","email_verified_at":null,"hero_id":1,"created_at":"2020-11-11T12:08:55.000000Z","updated_at":"2020-11-11T12:08:55.000000Z"}}`
 
* **Error Response:**
    
  * **Code:** 401 Unauthorized <br />
    **Content:** `{"error":"Unauthorized"}`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/auth/refresh",
      method: "post",
      dataType: "json",
      success : function(response) {
        console.log(response);
      }
    });
  ```

**Update user e-mail**
----
  Route used for update user e-mail address.

* **URL**

  api/auth/update-user-email

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

   **Required:**
 
   `email=[required|string|email|max:100|unique:users]`

* **Success Response:**

  * **Code:** 200 OK <br />
    **Content example:** `{"message":"User e-mail successfully updated"}`
 
* **Error Response:**

  * **Code:** 400 Bad Request <br />
    **Content:** `{"email":["The email has already been taken."]}`
    
  OR
    
  * **Code:** 401 Unauthorized <br />
    **Content:** `{"error":"Unauthorized"}`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/auth/update-user-email",
      method: "post",
      dataType: "json",
      data: {
          email: "email@gmail.com"
      }, 
      success : function(response) {
        console.log(response);
      }
    });
  ```

**User resources**
----
  Route used for get user resources.

* **URL**

  api/auth/user-resource

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

   **Required:**
 
   `resource=[required|string]`
   
   **Not Required:**
    
   `id=[nullable|integer]`

* **Success Response:**

  * **Code:** 200 OK <br />
    **Content example:** `{"planets":["http:\/\/swapi.dev\/api\/planets\/45\/"]}`
    
  OR
  
    * **Code:** 200 OK <br />
      **Content example:** `{"name":"Iridonia","rotation_period":"29","orbital_period":"413","diameter":"unknown","climate":"unknown","gravity":"unknown","terrain":"rocky canyons, acid pools","surface_water":"unknown","population":"unknown","residents":["http:\/\/swapi.dev\/api\/people\/54\/"],"films":[],"created":"2014-12-20T10:26:05.788000Z","edited":"2014-12-20T20:58:18.497000Z","url":"http:\/\/swapi.dev\/api\/planets\/45\/"}`
 
* **Error Response:**

  * **Code:** 400 Bad Request <br />
    **Content:** `{"id":["The id must be an integer."],"resource":["The resource field is required."]}`
    
  OR
  
  * **Code:** 400 Bad Request <br />
    **Content:** `{"error":"Resource not exists"}`
    
  OR
    
  * **Code:** 401 Unauthorized <br />
    **Content:** `{"error":"Unauthorized"}`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/auth/user-resource",
      method: "post",
      dataType: "json",
      data: {
          resource: "vehicles",
          id: 1
      }, 
      success : function(response) {
        console.log(response);
      }
    });
  ```
  
**User profile**
----
  Route used for get user profile.

* **URL**

  api/auth/user-profile

* **Method:**

  `GET`
  
*  **URL Params**

   None

* **Data Params**

   None

* **Success Response:**

  * **Code:** 200 OK <br />
    **Content example:** `{"id":1,"name":"Grzegorz","email":"email@gmail.com","email_verified_at":null,"hero_id":1,"created_at":"2020-11-11T12:08:55.000000Z","updated_at":"2020-11-11T12:28:12.000000Z"}`

* **Error Response:**
    
  * **Code:** 401 Unauthorized <br />
    **Content:** `{"error":"Unauthorized"}`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/auth/user-profile",
      method: "get",
      dataType: "json",
      success : function(response) {
        console.log(response);
      }
    });
  ```
