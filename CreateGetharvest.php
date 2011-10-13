if(isset($_GET['client_name']) ) {

//get client name from the URL
$client_name = $_GET['client_name'];

//load the HarvestAPI
require_once(dirname(__FILE__) . ‘/GetHarvest/HarvestAPI.php’);

/* Register Auto Loader */
spl_autoload_register(array(‘HarvestAPI’, ‘autoload’));

//Connect to Harvest and authenticate
$api = new HarvestAPI();
$api->setUser( “username” );
$api->setPassword( “password” );
$api->setAccount( “subdomain” );
$api->setRetryMode( HarvestAPI::RETRY );

//assign client variables
$client = new Harvest_Client();
$client->set( “name”, $client_name );

//get client notes from URL
if(isset($_GET['client_description']) ){
$client_description = $_GET['client_description'];
$client->set( “details”, $client_description );
}

//create clients
$client_result = $api->createClient( $client );
if( $client_result->isSuccess() ) {
// get id of created client
$client_id = $client_result->data;
}

//get the project from the URL
$project_name = $_GET['project_name'];
$project_notes = $_GET['project_notes'];

//assign project variables
$project = new Harvest_Project();
$project->set( “name”, $project_name );
$project->set( “client-id”, $client_id );
$project->set( “notes”, $project_notes);

//create projects
$project_result = $api->createProject( $project );
if( $project_result->isSuccess() ) {
// get id of created project
$project_id = $project_result->data;
}
}
else {
error_log(“Something went wrong”, 0);
}

