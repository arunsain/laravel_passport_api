 Api detail 


1. register Api

   Path : localhost:8000/api/register

   method : post

   parameter : { "name" :"abww4www4wdwdwd", "email":"a4534w4@gmail.com", "password": "123456789","device_token":"s2s2ws2ss","device_type":"frefgtg" }

2. Login Api    

	Path : localhost:8000/api/login

	method : post

   parameter : { "email" :"abww4www4wdwdwd", "password":"a4534w4@gmail.com" }

3. user Detail Api 

	Path : localhost:8000/api/details

	method:post 

	header :  Authorization  =>  Bearer Toke
				Accept			 =>	application/json


4. user activateUser Api 

	Path : localhost:8000/api/activateUser

	method:post 

	parameter : { otp : "6 digit otp"}

	header :  Authorization  =>  Bearer Toke
				Accept			 =>	application/json


5.  user logout Api 

	Path : localhost:8000/api/logout

	method:post 

	header :  Authorization  =>  Bearer Toke
				Accept			 =>	application/json