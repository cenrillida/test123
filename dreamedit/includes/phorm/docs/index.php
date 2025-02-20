<?php
	$title="Documentation";
	include("header.php");
?>
<a href="http://sourceforge.net/projects/inphorm/"><h2 align="center">inPhorm</h2></a>
<h4>Table of Contents</h4>
<ol>
<li><a href="#intro">Introduction</a>
<li><a href="#using">Using inPhorm in your application.</a>
<li><a href="#components">Creating new inPhorm components.</a>
<li><a href="#validation">Writing new validation classes for inPhorm.</a>
<li><a href="#templates">Developing new template sets for inPhorm.</a>
<li><a href="#language">Creating new language files for inPhorm.</a>
<li><a href="phorm.class.php">Main inPhorm class documentation</a>
<li><a href="components/">Components documentation</a>
</ol>
<h4><a name="intro">Introduction</a></h4>
<p>inPhorm is a PHP class which provides a framework for creating, displaying and validating HTML forms from your PHP applications.  It has been designed to be extremely flexible and extensible by using an abstract factory pattern to dynamically load components (PHP classes which implement HTML form elements) at runtime.  This manual first describes how to use the inPhorm class in your code, and then covers the multiple ways you can expand inPhorm and contribute to development.  inPhorm is licensed under the GNU LGPL.</p>

<h4><a name="using">Using inPhorm in your application</a></h4>
<p>In order to use inPhorm, we must first create our form definition class.  Below is a simple example.</p>
<font size="-1">
<?php highlight_file("phorm.example.class.php"); ?>
</font>

<p>First, we include the main phorm class file.  You will need to change the path in this include statement to the directory where inPhorm is installed.  This path has to be relative to the file which is actually being requested by the browser, not your form definition class.  If you have problems, just add the inPhorm directory to your include_path.</p>

<p>Now we define the class for our form and tell PHP that we wish to extend the base "phorm" class.  Our first function is the "phorm_test" function which is the constructor for our class (the constructor gets called when an instance of the class is created with the "new" method. Constructors must have the same name as the class). If you are unfamiliar with using objects/classes in PHP, please refer to the <a href="http://www.zend.com/manual/language.oop.php">PHP OOP documentation.</a>  It is important that your constructor call "$this-&gt;phorm()" <b>after</b> you have created your form definition.</p>

<p>The "_test_phorm" function is responsible for creating our form definition.  This function can be named whatever you wish, but it must be called properly from your constructor.  The form definition consists of a series of array strunctures which provide all of the information needed to create and validate the form.  The first line sets the name of the form to "TestForm".  This will be used as part of the &lt;form&gt; tag so you can reference your form elements from embedded languages such as javascript.</p>

<p>Now we set the template style to be used by setting "template_dir" to one of the template directories.  Here we'll use the "plain_table" template set which generates a basic HTML 4.0 compliant table to display the form elements.  Creating custom templates is covered in a later section.  The language file is used to provide the text that is displayed for error messages.  Currently, only american_english is available, but we hope to have translations available soon.  Finally, we have the include_path, which should be set to the path of your inPhorm installation.</p>

<p>The components array defines a series of components for your form.  The components will be validated and displayed in the order they are defined here.  Components may make use of custom settings, but all components will have a class setting, and almost all will have a prompt setting.  The class setting defines the component to be loaded to handle the validation of this form object as well as the template file to use to display it.  If you wish to use a template file other than the default, you may explicitly specify a template using the template setting.  For example, if you created a component called "my::emailaddress", but wanted to use the "base::textbox" template to display it, you can tell inPhorm this by explicitly setting the "template" to "base::textbox" (a better way would be to overload the template() method in your component class - see the "Creating new inPhorm components section below).  Documentation for each individual component is available in the <a href="components/">components documentation</a></p>

<p>Now that we have our form definition class setup, we must create a simple PHP script to make use of it.</p>

<font size="-1">
<?php highlight_file("phorm_example.php"); ?>
</font>

<p>That's it!  Try out the <a href="phorm_example.php">example form.</a></p>


<h4><a name="components">Creating new inPhorm components</a></h4>


<p>The main way to extend inPhorm is to create new components.  In inPhorm, components are PHP classes that extend the core components class.  Components are made up of one or more HTML form elements.  Some simple components, such as the textbox component, only require one form element, while others, such as a date component may require several (one for the month, day and year).  A very simple case of a component which requires multiple form elements is the password component.  The password component uses two text boxes so the user can enter their password twice to avoid typographical errors.</p>

<p>The best way to learn to write components is to look at the source for the base components that come with inPhorm.  A bare-bones component skeleton is shown below.</p>

<font size="-1">
<?php highlight_file("skeleton_comp.php"); ?>
</font>


<p>The one method that all components must have is "_validate()".  This method is the internal method responsible for validating the component's value and returns an array of errors, or an empty array if no errors occurred.  The an associative array stored in "$this-&gt;comp" has all of the values from your form definition (such as the class, prompt, etc) and an additional array key, "value" which stores the current value of the component.</p>

<p>The core component class that your components inherit from implements a few other methods that you may wish to overload.  These methods are:</p>

<ul>
<li>to_string()
<li>template()
<li>value()
<li>_init()
<li>_init_value()
</ul>


<h5>to_string()</h5>

<p>The to_string method is responsible for translating the value of a component into a human readable string.  This is often used when outputting the value of a component to the user (The to_string method <b>should not</b> be used to get the value of the component). The to_string implementation in the core component class is rather simple, so if you are building a fairly complex component, you'll probably need to overload to_string.  The default to_string implementation returns the value of the component if it's a scalar (simple string) or joins all of the values with a ", " and returns the resulting string if the value is an array.  The to_string method takes no arguments and returns a string.</p>

<h5>template()</h5>

<p>The template method tells inPhorm which template file should be used to display the component.  The default implementation of the template method (in the component class that all components extend) prepends "component::" to the component's class name unless a specific template has been specified in the form definition.  For example, the "base::textbox" component's template would be "components::base::textbox".  If you want your component to use a different template (so it can share a single template file with other similar components), you can overload this method.</p>


<h5>value()</h5>

<p>The component class's implementation of the value() method simply returns the value stored in the "$this-&gt;comp" array.  In some instances, you may wish to alter this behavior.  As was pointed out previously, the password component uses two textbox fields for user input.  Because it uses multiple fields, it's value (as stored in the "$this-&gt;comp" array) is an array consisting of a value for each of the two fields.  It isn't very useful for the user to get this array when they ask for the value of the component because the component has already been validated and the equivalence of these two values has been checked as part of this validation.  The user is also probably not expecting to get an array for the value of the password field.  For these reasons, the password component overloads the default value method (as implemented in the component class) to simply return a string.</p>


<h5>_init()</h5>

<p>This method is called when the component instance is created (it is the very last init method called, so the value of the component (as determined by _init_value) is set).  The default implementation of _init() is an empty method that returns nothing. If you need to do any initialization for your component, do it here.</p>


<h5>_init_value()</h5>

<p>The _init_value method is responsible for getting the value of the component and assiging it to "$this-&gt;comp['value']". The component class's implementation of the _init_value() method checks HTTP_POST_VARS, HTTP_GET_VARS, the default value passed to the phorm class constructor, the default value specified in the form definition - in that order (that is, HTTP_POST_VARS has the highest priority and the default value specified in the form definition has the lowest priority).  This is fine for most cases, but if the value for your component is not stored in HTTP_POST_VARS (for file uploads, for example) you will need to overload this method.  If you plan on overloading this method, be sure to check out the implementation in the main components class (components/components.php) and consider including the checks for default values.</p>




<?php include("footer.php"); ?>
