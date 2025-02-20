<?php 
	$title="The phorm class methods.";
	include("header.php");
?>
<h2 align="center">inPhorm</h2>
<h3>Table of Contents</h3>
<ol>
<li><a href="#intro">Introduction</a>
<li><a href="#methods">Public Methods</a>
</ol>

<h3><a name="intro">Introduction</a></h3>

<p>The main phorm class implements several methods that are made available to you to get information about the state of your form.</p>

<h3><a name="methods">Public Methods</a></h3>

<h4><u>function phorm ($values = NULL)</u></h4>

<p>This is the constructor for the phorm class.  This should always be called from the constructor of your child class.  It optionally takes an associative array of default values for your form where the array keys are the names of your components.  This array of default values takes precedence over any default values specified in your form definition.</p>

<h4><u>function add_comp($name, $comp)</u></h4>

<p>This method allows you to add components to your form at run time.  The add_comp method takes two arguments, the name of the component to add, and an array containing the configuration for the component.  This method returns TRUE if the add succeeds or FALSE if a component with the given name already exists.</p>

<h4><u>function remove_comp($name)</u></h4>

<p>This method allows you to remove components at run time and takes the name of the component to remove as it's only argument.  This method returns TRUE if a component is removed or FALSE if the component you tried to remove doesn't exist.</p>

<h4><u>function edit_comp($comp_name, $key, $value)</u></h4>

<p>This method allows you to edit a component's configuration.  The three arguments are the component's name, the configuration key, and the value.  This method will return TRUE if the component's value is successfully changed or return FALSE if the component whose configuration you tried to change doesn't exist.</p>

<h4><u>function conf ($name, $value = NULL)</u></h4>

<p>This method allows you to get and set configuration values for the form, such as the language and template style.  The value argument is optional.  If no value is supplied, the method will return the value of the configuration setting.  If a value is supplied, the method will set the value of the configuration setting.</p>

<h4><u>function data ($name)</u></h4>

<p>This method returns the entire definiton array for the given component name, or for all components if no name is given.  Generally, you won't need to make use of this method (it's mainly for internal use).</p>

<h4><u>function display ()</u></h4>

<p>This method displays your form.</p>

<h4><u>function template ($name)</u></h4>

<p>Returns the template file name for a given component, or all components if no name is specified.  Like the data() method, this is mainly for internal use.</p>

<h4><u>function to_string ($name)</u></h4>

<p>This attempts to represent the value of a component as a simple, human readable string.  If no component name is specified, it will return an associative array containing the to_string values for all of the components.  Do NOT use this to get the value of a component - for that, use the value() method.</p>

<h4><u>function validate ()</u></h4>

<p>Attempts to validate all of the components.  Returns TRUE if all of the components validated without error, or FALSE if there was an error.</p>

<h4><u>function value ($name)</u></h4>

<p>Returns the value of a given component (which could be a simple scalar0 or an array, depending on the component), or an array of name =&gt; value pairs if no component name is specified.</p>

<?php include("footer.php"); ?>
