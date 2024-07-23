# Programs and tools installed
This is a brief listing of all the tools that were used in the creation of this system, however not all of them are required for make use of it. Nested elements are for elements that are, in one way or another, part of another, so it should be included when installing these programs or when downloading/pulling the project folders.

- Composer v2.7.7 [Not required to install]

- XAMPP v3.3.0 (found online as 8.2.12) **[REQUIRED TO INSTALL]**
	- Apache v2.4.58 (Windows x64)
	- OpenSSL v3.1.3
	- PHP v8.2.12
	- libmysql mysqlnd v8.2.12
	- ------------------
	- Laravel v11.16.0
	- pestphp/pest v^2.34

- Node JS v20.15.1 **[REQUIRED TO INSTALL]**
	- npm v10.8.2
	- ------------------
	- Vue CLI v5.0.8
	- Vuetify 3 (VUE CLI [Preview])

- Postman v11.4.0 [Not required to install]


# Set up
## Downloading programs
If you lack any of the two required tools in the list above, you should search their respective installers online in the official sites, preferably the indicated version. If you have these tools but with a version below the ones listed, it is likely the system won't work as intended. You obviously have to select the installer that corresponds your operative system.

- For XAMPP, you can use the following link to search the version with PHP v8.2.12: [https://www.apachefriends.org/download.html] (https://www.apachefriends.org/download.html)
- For Node.js, you can use the following link to search version 20.15.1: [https://nodejs.org/en/download/package-manager] (https://nodejs.org/en/download/package-manager) There is a combo box control which let's you select the desired version.

## Installing programs
Once the installers have been downloaded, execute them to install the required tools and environment, if there are any extra questions or checkboxes or anything else to specify, leave it in the default setting and continue.

## Setting up the system
### Setting up the database
Open XAMPP if not opened already, you should be able to find the Apache and MySQL services, each one has their **Start** and **Admin** button. Click on the **Start** button of those two services only, wait for them to change into a Ready state with a green back color in their labels. Once they're ready, click on the button **Admin** of the service MySQL.

This should open the service PhpMyAdmin. Once there, click on the option **Import** at the top task bar. Click on a button that has a text "Attach file" or something similar, with the File Explorer opened, search for one of the provided files, **userstest.sql**.

**CAUTION**: This will create a userstest database, if you already had xampp and made a database of the same name, this script will remove it from your database to replace it with the database this system makes use of. It is suggested to make a backup copy of your database and then execute the file.
If you don't have any database of that name or once you made that backup, scroll down in that Import page and click on the button **Import**.


### Setting up the services
If you pulled the git repository in XAMPP's htdocs folder, you may ignore the following paragraph and skip to the third paragraph of this section.

You might've notice there are two folders, one called "**backendproject**" and the other "**frontendproject**", these two folders should be moved inside XAMPP's "htdocs" folder. To locate this folder, you should find it inside the directory where XAMPP was installed.

You need a tool able to execute commands. In Windows, by default, this should be the "Command Prompt"; in macOS and any Linux operative system, by default, this should be the "Terminal". You can use any other tool able to execute commands, just make sure these are uninterrupted for any permission or security type of boundaries. Two instances of the terminal are required, they might be two instances of the same tool or different tools, with the "cd" command, in one you should enter inside the **backendproject** folder, and in the other inside **frontendproject** folder.

Inside the **backendproject** terminal instance, execute the command:
```bash
php artisan serve
```

Inside the **frontendproject** terminal instance, execute the command:
```bash
npm run serve
```

# Testing/Using the system
In each terminal, after a short while, should display a result letting you know the address or IP, and port where you can find these services running. The only one we care about seeing functioning is the **frontendproject** results. So copy and paste the address inside an internet browser and see where it takes you. The system should instantly redirect you to the Login page right after entering the main page.
If you are confused, it is likely the site is found at:
**http://localhost:8080/**
Feel free to copy and paste it in your internet browser.

You may login with one of these credentials:
- Email address: **new1@gmail.com**
- Password: **new1**

- Email address: **new2@gmail.com**
- Password: **new2**

- Email address: **expert@gmail.com**
- Password: **expert**

- Email address: **newbie@gmail.com**
- Password: **newbie

- Email address: **user1@gmail.com**
- Password: **user1**

- Email address: **user2@gmail.com**
- Password: **user2**

- DO NOT make any user registry with the Username: **testUser**
- DO NOT make any user registry with the Email address: **testUser@gmail.com**

- DO NOT make any user registry with the Username: **anotherUser**
- DO NOT make any user registry with the Email address: **anotherUser@gmail.com**

(These last two should be avoided because these are the credentials utilized in the test script).

Or maybe you prefer to enter by registering a new account, just make sure not to repeat any username nor email address (the usernames of these sample registries are the same as the name in the email addresses)

Inside there, feel free to tes whatever function you like!, just keep in mind that these operations might take a while, so please be patient whenever executing a command, whether that is logging in, getting to see all registries, editting a user account, deleting one, etc.


# Run tests
If you want to run the PEST tests, you can either open another terminal and enter inside **backendproject** folder again, or stop the terminal running the backendproject service by pressing twice: Ctrl C

In the same terminal, run the command
```bash
./vendor/bin/pest tests/Feature/UserSessionsTests.php
```

As long as you did not create any user registry that has any of the fields, This should display all tests being executed successfully. What this test does is:
- Register a new account: testUser
- testUser logs out
- testUser logs in
- testUser gets all user registries
- testUser gets the data of the first user registry
- testUser adds a new account: anotherUser
- testUser edits anotherUser, changing the username to: anotherUserEdited
- testUser deletes anotherUserEdited
- testUser deletes itself
After running the test, the database should look the same as before it was executed.


# Notes to consider
The password field has an eye button to toggle the visibility of the characters, however it only updates after typing inside the text field, which seems a little risky to leave and isn't really practical in real scenarios.
The system, a previously mentioned, may be slow, so whatever operation is made, it is suggested to be patient and wait for it to update. In real scenarios, there should be some loading bar to let the user know their request is being processed.
The main/default page is the dashboard, however to be in the dashboard, the user should be in  an authorized registered account. Thus by default, whenever you begin the system and enter in that site, you'll always get the message saying "Session expired" and redirecting you to Login page.
Although in the repository, the two folders are separate, you may create a folder and place both inside the folder to have everything a little more organized. You may name the folder as something like "UserManagement_Test" and organize the folders as:
- UserManagement_Test
	- backendproject
	- frontenproject
