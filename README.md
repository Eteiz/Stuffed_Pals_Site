# Stuffed_Pals_Site 🐻
<p align="center">
  <img src="https://github.com/Eteiz/Stuffed_Pals_Site/assets/97179185/0b438f73-50a1-49fc-bba9-94ca71b70964" />
</p>

## About 📚
This project was undertaken as part of a course requirement for "Internet Database Applications" at the Łódź University of Technology. The aim was to create **an online store integrated with a database**, offering users functions such as:
- **Account creation and login**,
- **Adding and removing products from the cart, searching for them using filters**,
- **Reservation of products for a specific time and placing orders**.

The site also includes a simple administrative panel, enabling:
- **Performing basic CRUD operations on store products**,
- **Viewing orders placed by users and changing their status**,
- **Viewing all site users and deleting them**.

<p align="center">
  <img src="https://github.com/Eteiz/Stuffed_Pals_Site/assets/97179185/7d172e9d-1eee-4632-b0ca-71b638ecfde6" />
  <img src="https://github.com/Eteiz/Stuffed_Pals_Site/assets/97179185/3f76014f-87f7-45c3-8dec-632c9e41f3f5" />
</p>

## Technology and tools ⚙️
XAMPP software was used for PHP code interpretation and setting up a local server. The site is primarily written in **PHP for database connection and data display**. Sessions were used for login and verification. The site was built **using HTML, CSS, and JavaScript, with JQuery for asynchronous requests, ensuring a responsive and user-friendly interface**.

## Safety measures 🔐
The main goal of the project was to **minimize the risk of security breaches such as SQL injection or Cross-Site Scripting**. To this end, security measures were implemented at every stage of user data input that could affect the database, **including verification, validation, and data sanitization** using methods like:

- `filter_var()`,
- `real_escape_string()`,
- `intval()`,
- `substr()`,
- `htmlspecialchars()`,
- `bindParam()`

Additionally, database permissions were set to limit default access to basic operations and procedure calls. User passwords were secured with PHP-recommended methods like `password_hash()`. The administrative account has both the password and username secured.

## Shop, product page 🛒
The website features a panel that displays the store's products. Here, users can find products that match the filters and criteria, which can be adjusted or cleared in the panel on the left side. The available filters include: product category, supplier, availability and price range.
<p align="center">
  <img src="https://github.com/Eteiz/Stuffed_Pals_Site/assets/97179185/82b36af1-f83a-41ae-9f65-8e299435f51b" />
</p>

If a user is interested in a product, they also have the option to visit its page, which provides more detailed information. In the initial plans, there was also an intention to add a section for reviews and product ratings. However, due to time constraints, it was not possible to implement this feature. Therefore, every product currently uses the same template for ratings.
<p align="center">
  <img src="https://github.com/Eteiz/Stuffed_Pals_Site/assets/97179185/95afd5bc-4711-4197-9554-0d3aad8a5248" />
</p>

## User features 👥
### Login / register panel
Users have the option to log in to the site by clicking the user icon in the top right corner of the navigation bar, which redirects them to the login page. There, they can choose to create an account if they do not already have one. After creating an account, users are redirected back to the login page, where, **upon logging in, they gain access to their profile, addresses and cart**. 

> [!IMPORTANT]
> Username, password and email during registration process have to meet criteria such as:
> - **Username**: **between 5 to 40 characters**, matching the pattern `'^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź0-9]+$'`, and not previously used,
> - **Email address**: **up to 255 characters**, matching the pattern `'^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$'`, and not previously used,
> - **Password**: **up to 60 characters**.

### Profile details / addresses
On their profile, users have access to an account data panel and an addresses panel. The account data panel displays information about the user's account, such as the **account creation date, username, and email**. It also allows the user to **log out and delete** their account. In the address panel, users can **add or modify addresses, which can then be used for auto-filling details during order placement**.

### Cart / checkout
Each user is assigned a shopping cart that is created when the first product is added to the cart. Users can navigate to the cart section using the icon in the top right corner of the navigation bar. In the cart, the user sees the number of products, which can be deleted or their quantity changed. Then, the user can proceed to the order fulfillment section, **which initiates a 15-minute reservation of the cart**.
> [!CAUTION]
> During the reservation process, the user cannot modify the cart until they cancel the reservation. This can be done through a pop-up window that appears when attempting to perform a prohibited action.

## Admin features 🧰
Redirecting to the admin dashboard requires first logging in on a separate page available at `/admin_pages/admin_login_page.php`. Currently, there's only one admin accounts on whuch you can log on, which allows access to the dashboard, where the administrator has the capabilities mentioned in the first paragraph of this README. **The administrator has the option to log out, but administrative permissions do not affect the operation of the default page in any way**.
<p align="center">
  <img src="https://github.com/Eteiz/Stuffed_Pals_Site/assets/97179185/c3d11748-10c8-4091-910a-289b4f5d172a" />
</p>

> [!IMPORTANT]
> Both the login and the password for the administrative account are encrypted using PHP's hashing functions.
> - **Username**: StuffyAdmin
> - **Password**: Teddy123

# Environment setup 🛠️
To be able to run the site on your computer, it is recommended to download [XAMPP](https://www.apachefriends.org/pl/download.html) suitable for your operating system. After doing this, open the XAMPP Control Panel application and start the **Apache and MySQL services**. To display the content of the site, you need to place the entire contents of the repository in the  `C:/xampp/htdocs` folder. From this point, the homepage is available at [http://localhost/index.php](http://localhost/index.php).
<p></p>

Then, go to the `C:/xampp/htdocs/database-copy` folder and import the copy of the database located there into MySQL, accessible at [http://localhost/phpmyadmin/index.php](http://localhost/phpmyadmin/index.php).
> [!CAUTION]
> In case of an error displayed on the website regarding the lack of permissions for a user named `user@`, it is necessary to create a new permission group named `user` in `stuffedpals_database`, **which does not require a password and has permissions such as**:
> <img src="https://github.com/Eteiz/Stuffed_Pals_Site/assets/97179185/f782bb88-6419-4bab-9564-29a4003bd2ec" />

# Additional features 💡
The website also includes additional functionalities that were not required in the project specifications, but I felt compelled to implement them.
## Newsletter 📧
<p align="center">
  <img src="https://github.com/Eteiz/Stuffed_Pals_Site/assets/97179185/12e7f4d7-beca-49f1-beb2-0b600655bfa2" />
</p>

Users have the opportunity to symbolically register their email address for the Stuffed Pals Newsletter, which will then be stored in a table in the database.

## Contact Form 📃
<p align="center">
  <img src="https://github.com/Eteiz/Stuffed_Pals_Site/assets/97179185/796de39b-fd8a-4999-8c14-daa32c8df4ec" />
</p>

Stuffed Pals provides shoppers with the ability to contact the company's team through a simple contact form. This form is located in the file `customer_service_page/customer_service.php`, which can be accessed by clicking the `Help` hyperlink on the navigation bar. To ensure the contact form functions correctly, it is necessary to configure several files: `php/php.ini` and `sendmail/sendmail.ini` located in the main XAMPP directory, as well as `customer_service\contactform_sender.php`.
<p></p>

When setting up the contact form in Stuffed Pals, it is crucial to know specific details regarding the email address that will be used to receive the forms. This includes:
- **Email Address**: The specific email address where the forms should be delivered.
- **Password**: The password to access this email account.
- **SMTP Server Name**: The name of the SMTP server that will be used for sending emails.
- **Port**: The port number used by the SMTP server.
- **Encryption Method**: The type of encryption used for securing email communications, such as SSL or TLS.

### php.ini, sendmail.ini
Options that have to be configured in `php.ini` under `[mail function]` header:
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

### contactform_sender.php
The only part of the code that needs to be changed is `[email address]` in the main body of function responsible for sending prepared message to our email address. 
> [!IMPORTANT]
> The email address have to match the one given in .ini files.
```
    if (mail("[email address]", "Stuffed Pals Contact Form", $message_body, $headers)) {
        $response['status'] = 1;
        $response['msg'] = "Mail successfully sent";
    } else {
        $response['status'] = 0;
        $response['msg'] = "There was a problem sending the email.";
    }
```

# Credits and Acknowledgements 👏
Sources of data and elements used in the project:
**I do not have any rights to the following elements, and they were used for educational purposes**
- Interface icons from [Flaticon](https://www.flaticon.com),
- Banners and graphic design from [Canva](https://www.canva.com),
- Product photos and logos found on [Google Images](https://www.google.pl/imghp),
- Text on the website, modified to fit the theme, including the creation of descriptions, pricing, and product names done with [ChatGPT](https://openai.com/blog/chatgpt).
