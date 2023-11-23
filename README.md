# Stuffed_Pals_Site
A design for an online store website with a database backend utilizing XAMPP.

# Contact Form Configuration
<p align="center">
  <img src="https://github.com/Eteiz/Stuffed_Pals_Site/assets/97179185/40d33ce9-127b-4991-9219-4b5fb5da1453" />
</p>

Stuffed Pals allows shoppers to mail company's team with simple contact form located in `customer_service.php` that can be reached by clicking Help hyperlink on navigation bar.
In order to work properly, it is required to configure both `php/php.ini` and `sendmail/sendmail.ini` located in main xampp directory and  `htdocs\php_scripts\contactform_sender.php`. 

## php.ini, sendmail.ini
It is important to know on what **email address** (and **password** to access it) we would like the forms to be delivered, its **smpt server name, port and encryption method**.

Options that have to be configured in `php.ini` under `[mail function]`:
```
SMTP= [smtp server name]
smtp_port= [smtp server port]
sendmail_from = [email address]
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"
```

Options that have to be configured in `sendmail.ini`:
```
smtp_server= [smtp server name]
smtp_port= [smtp server port]
smtp_ssl=auto 
auth_username= [email address]
auth_password= [email password]
force_sender= [email address] (optional) 
```
## contactform_sender.php
The only part of the code that needs to be changed is `[email address]` in the main body of function responsible for sending prepared message to our email address. **The email address have to match the one that was given in .ini files!**
```
    if (mail("[email address]", "Stuffed Pals Contact Form", $message_body, $headers)) {
        $response['status'] = 1;
        $response['msg'] = "Mail successfully sent";
    } else {
        $response['status'] = 0;
        $response['msg'] = "There was a problem sending the email.";
    }
```
