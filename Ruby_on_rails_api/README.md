# 1DV450_rn222cx

Url to application: https://ancient-savannah-60021.herokuapp.com/  
Url to client repo: https://github.com/rn222cx/1DV450_rn222cx_client

### Install
* bundle install
* rake db:schema:load  
* rake db:seed

You should see a login page when navigate to the site.

#### Admin credentials
username: admin  
email: admin@admin.com  
password: 1234  

### Non admin user  
username: johndoe  
email: test@test.com  
password: 1234  

For CrUD management the users email and password must be sent encoded in the header to make requests.  
Don't worry it's included in the postman collection for johndoe.    
You can create your own encoding in the terminal like this `Base64.encode64("test@test.com:1234")`    

### Tests
The tests are old and will not work anymore

### Api

Postman collection https://www.getpostman.com/collections/0893639f23f89b9ca0fe

To create requests you have to generate your own Api-Key or login as admin and copy the existing one.

The index and show methods are generated with RABL and are located in the views directory.

The api works for booth json and xml.


Enjoy!
