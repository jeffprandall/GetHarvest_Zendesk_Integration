<?php
    //does the project exist in the URL 
    if(isset($_GET['project_name']) ) {
        
        //get project name from the URL
        $project_name = $_GET['project_name'];
        
        //load the HarvestAPI
        require_once(dirname(__FILE__) . '/GetHarvest/HarvestAPI.php');

        /* Register Auto Loader */
        spl_autoload_register(array('HarvestAPI', 'autoload'));

        //Connect to Harvest and authenticate
        $api = new HarvestAPI();
        $api->setUser( "support@iaak.net" );
        $api->setPassword( "Kids123" );
        $api->setAccount( "IAAK" );
        $api->setRetryMode( HarvestAPI::RETRY );      

        //get all current projects and find the project_id
        $projects_result = $api->getProjects();
            if ($projects_result->isSuccess() ) {
                foreach( $projects_result->data as $project ) {
                    if ($project->name == $project_name) {$project_id = $project->id;}                  
                }
                if ($project_id == null) {error_log("Could not find id", 0);}
            }
            else {error_log("could find all projects",0); }
        
        //archive/toggle the project
        $project = new Harvest_Project();
        
        $project_result = $api->toggleProject($project_id);
        if( $project_result->isSuccess() ){$project_id = $project_result->data;}
        else {error_log("could not archive project",0);}
    }
    else {error_log("project_name not in the URL",0);}
?>
