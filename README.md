# MailMonkey v1.0.2 (Beta)

### Install

• Clone this repo than delete the .git folder
• Run the composer command ```composer require``` to download all the necessary packages

### Configuration

• Inside the config folder, you can use the 'config.json' file to set any configuration you want
• Set your SMTP config inside the MailMonkey.php class file

### Creating templates

To create a new template, you need to create a new HTML file inside the 'Templates' folder. 
You can create variables inside your template as you like and convert this values into php values using associative array syntax
To see an example, check out the *How to send HTML files as template*

### How to send simple emails

```
$mailMonkey = new MailMonkey();
$mailMonkey->prepare('person@email.com', 'John Doe', 'My email subject');
$mailMonkey->setMessage('this is my message');
$mailMonkey->send();
```

### How to send HTML files as templates
```
$mailMonkey = new MailMonkey();
$mailMonkey->prepare('person@email.com', 'John Doe', 'My email subject');
$mailMonkey->sendMessageUsingTemplate('myTemplate', [':var1:' => $var1]);
$mailMonkey->send();
```
