<?php
/**
 * A view. Handles loading the PHP file representing the view, and passing data to it
 * @author Daniel15 <daniel at dan.cx>
 */
class View
{
	private $dir;
	private $name;
	
	/**
	 * Create a new view
	 * @param	string		Name of the view file
	 */
	public function __construct($name)
	{
		$this->dir = __DIR__ . '/../views/';
		$this->name = $name;
	}
	
	/**
	 * Set a view variable. Returns the view so that calls can be chained
	 * @param	string		Variable to set
	 * @param	string		Value to set variable to
	 * @return	This
	 */
	public function set($variable, $value)
	{
		$this->$variable = $value;
		return $this;
	}
	
	/**
	 * Render this view to the output
	 */
	public function render()
	{
		// First get the page body and stick it into $this->body
		ob_start();
		require($this->dir . $this->name . '.php');
		$this->body = ob_get_clean();
		
		// Now render the template
		require($this->dir . 'template.php');
	}
	
	/**
	 * Create a new view. Used so calls can be chained
	 * @param	string		Name of the view
	 * @return The view
	 */
	public static function factory($name)
	{
		return new self($name);
	}
}
?>