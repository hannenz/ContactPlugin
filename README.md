#ContactPlugin

CakePHP plugin (Cake >= 2.0)

Handles standard contact forms with arbitrary form fields. Handles validation of user input and optionally stores messages in database.

###Install

Drop Plugin into `app/Plugin`
[Optional] Create database tables as found in `app/Plugin/Contact/Config/contact.sql`

(You may configure the plugin not to store messages in the database, in which case
you don't need the tables of course)


###Configuration

- Configure global E-Mail settings in `app/Config/email.php`

- Configure Plugin in `app/Plugin/Contact/Config/contact.php`

###Usage
Include the Plugin's helper, in your (App)Controller:

~~~
public $helpers = array('Contact.Contact');
~~~

To output the contact form from inside your view:

~~~
echo $this->Contact->form();
~~~

###E-Mail Templates

The layouts and templates for the e-mails can be found at `app/Plugin/Contact/View/Layouts/Email` and `/app/Plugin/Contact/View/Email`.

That's it. Enjoy

