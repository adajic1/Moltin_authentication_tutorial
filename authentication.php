<?php
error_reporting(E_ALL & ~E_NOTICE); 
require __DIR__ . '/vendor/autoload.php';
function getVar($var) {
	// Safely get the submitted variable (POST or GET method);
	// Returns NULL if there is no variable with the specified name;
	if (isset($_POST[$var])) 
		return get_magic_quotes_gpc() ? stripslashes($_POST[$var]) : $_POST[$var];
	else if (isset($_GET[$var])) 
		return get_magic_quotes_gpc() ? stripslashes($_GET[$var]) : $_GET[$var];
	else return NULL;
}
use Moltin\SDK\Request\CURL as Request;
use Moltin\SDK\Storage\Session as Storage;
$moltin = new \Moltin\SDK\SDK(new Storage(), new Request());
try {	
	$result = Moltin::Authenticate('ClientCredentials', [
	    'client_id'     => getVar('client_id'),
	    'client_secret' => getVar('client_secret')
	]);
	if ($result == true) { 
	    ?>
		<font color='blue'><b>Successful authentication.</b></font>
		&nbsp;
		<input type="button" value="back" onclick="window.location = 'index.html';">
		<br><br>
		Products listing:<br>		
		<?php
		$products = Product::Listing();
		var_dump($products['result']);
	} else {
		?>
		<font color='red'>ERROR: </font>Wrong credentials. 
		Hit the back button and try again.
		<br>
		<input type="button" value="back" onclick="window.location = 'index.html';">
		<br><br>
		<?php		
	}
} catch (Exception $e) {
    print "<font color='red'>Caught exception: </font>".$e->getMessage();
}
session_unset();
?>