<?php
    //does the project exist in the URL 
    if(isset($_GET['project_name']) ) {
        
        //get project name from the URL
        $client_name = $_GET['project_name'];
        
        //load the HarvestAPI
        require_once(dirname(__FILE__) . '/GetHarvest/HarvestAPI.php');

        /* Register Auto Loader */
        spl_autoload_register(array('HarvestAPI', 'autoload'));

        //Connect to Harvest and authenticate
        $api = new HarvestAPI();
        $api->setUser( "username" );
        $api->setPassword( "password" );
        $api->setAccount( "subdomain" );
        $api->setRetryMode( HarvestAPI::RETRY );      

        //get all current projects
        $projects_result = $api->getProjects();
            if ($projects_result->isSuccess() ) {
                $all_projects = $projects_result->data;
            }
            else {
                error_log("could not return all projects",0);
            }
        
        //does the current project exist and get the Project_ID
        if (array_key_exists($project_id, $all_projects)){
                $project_id = $result->data;  
        }
        else {
            error_log("could not locate project_name",0);
        }
        
        //archive the project
        $project = new Harvest_Project();
        $project->set ( "id", $project_id);
        $project->set ("activate", false);
        
        $project_result = $api->updateProject($project);
        if( $project_result->isSuccess() ){
            // get id of created client
            $project_id = $project_result->data;   
        }
        else {
            error_log("could not archive project",0);
        }
    }
    else {
        error_log("project_name not in the URL",0);
    }
?>
