<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* -------------------------------------------------------------------
 * EXPLANATION OF VARIABLES
 * -------------------------------------------------------------------
 *
 * ['mongo_hostbase'] The hostname (and port number) of your mongod or mongos instances. Comma delimited list if connecting to a replica set.
 * ['mongo_database'] The name of the database you want to connect to
 * ['mongo_username'] The username used to connect to the database (if auth mode is enabled)
 * ['mongo_password'] The password used to connect to the database (if auth mode is enabled)
 * ['mongo_persist']  Persist the connection. Highly recommend you don't set to FALSE
 * ['mongo_persist_key'] The persistant connection key
 * ['mongo_replica_set'] If connecting to a replica set, the name of the set. FALSE if not.
 * ['mongo_query_safety'] Safety level of write queries. "safe" = committed in memory, "fsync" = committed to harddisk
 * ['mongo_suppress_connect_error'] If the driver can't connect by default it will throw an error which dislays the username and password used to connect. Set to TRUE to hide these details.
 * ['mongo_host_db_flag']   If running in auth mode and the user does not have global read/write then set this to true
 */
/** 
 * mongodb://appfog_aab02bb5ab3b:appfog_aab02bb5ab3b@ds033907.mongolab.com:33907/appfog_aab02bb5ab3b_dd5c64a01867
 * mongodb://mvelikov:Aby55sh@ds033907.mongolab.com:33907/appfog_aab02bb5ab3b_dd5c64a01867
 * mongodb://<user>:<password>@ds033907.mongolab.com:33907/appfog_aab02bb5ab3b_dd5c64a01867
 */
$config['default']['mongo_hostbase'] = 'ds033907.mongolab.com:33907/appfog_aab02bb5ab3b_dd5c64a01867';
$config['default']['mongo_database'] = 'appfog_aab02bb5ab3b_dd5c64a01867';
$config['default']['mongo_username'] = 'mvelikov';
$config['default']['mongo_password'] = 'Aby55sh';
$config['default']['mongo_persist']  = TRUE;
$config['default']['mongo_persist_key']	 = 'ci_persist';
$config['default']['mongo_replica_set']  = FALSE;
$config['default']['mongo_query_safety'] = 'safe';
$config['default']['mongo_suppress_connect_error'] = TRUE;
$config['default']['mongo_host_db_flag']   = FALSE;