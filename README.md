#ContactPlugin

CakePHP plugin (Cake >= 2.0)

Handles standard contact forms

##Install

Drop Plugin into `app/Plugin`
[Optional] Create database tables as found in `Contact/Config/contact.sql`

(You may configure the plugin not to store messages in the database, in which case
you don't need the tables of course)


##Configuration

Configure global E-Mail settings in app/Config/email.php
Configure Plugin in `app/Plugin/Contact/Config/contact.php`

##Usage
Include the Plugin's helper, in your (App)Controller do:

~~~
public $helpers = array('Contact.Contact');
~~~

In your view to output the contact form do:

~~~
echo $this->Contact->form();
~~~

##E-Mail views

The layouts and templates for the e-mails can be found at `app/Plugin/Contact/View/Layouts/Email` and `/app/Plugin/Contact/View/Email`.

That's it. Enjoy

