<?php
	class clsBackupSphere {
    	
		public $database_name;
		public $timeStamp;		
		public $app_path;
		public $size;
		public $files_path;

		private $status;


	    public function __construct() {

	         global $wpdb;

	         $this->database_name = $wpdb->dbname;
	         $this->timeStamp = "";
	         $this->status = false;
	         $this->size = 0;

	         $this->dir_path = BACKUPSHERE__PLUGIN_DIR;
	        
	    }

	    public function databaseDirectory()
	    {
			$name = $this->database_name;

	    	if(!file_exists($this->dir_path . $name)){

	    		mkdir($this->dir_path . $name);

	    		$this->files_path = $this->dir_path . $name;
	    	}
	    	else{
	    		$this->files_path = $this->dir_path . $name;
	    	}
	    }


	    public function queryTables(){

	    	global $wpdb; 

	    	return $wpdb->get_results("SHOW TABLES");
	    }	    

    	public function queryColumns($table) {
	       	
			global $wpdb; 

			$existing_columns = $wpdb->get_col("DESC {$table}", 0); 

			$existing_columns = implode( ',', $existing_columns);

			return $existing_columns;      	
    	}


    	public function queryTableData($table) {
	       	
			global $wpdb;

			$primaryArray = array(); 
			$columns = array();

			$rows=$wpdb->get_results("SELECT * FROM {$table}"); 

			$columns = $this->queryColumns($table);

			//push table columns    
			if(!empty($columns)){
				array_push($primaryArray, $columns);
			}	

			foreach ($rows as $rws){
	            //array for every row
	            $secondaryArray = array();

	            //for each item in the array of the row 
	            foreach ($rws as $r){                  
	                //encode with base 64 to avoid comma's confussion when creating csv                    
	                $encodedText = base64_encode($r); 

	                //push into a secondary array to hold a row in the table
	                array_push($secondaryArray, $encodedText); 
	            }

	            if(!empty($secondaryArray)){
				   $secondaryArray = implode(',', $secondaryArray); 
				}

		        //push the rows per table
		        array_push($primaryArray, $secondaryArray);
	            
	        }	        

	        return $primaryArray;
    	
    	}


    	public function create_csv($table, $primaryArray){
		
			$file = fopen($this->files_path ."/". $table . ".csv","w");
	                
	        foreach ($primaryArray as $line){
	                    
	            fputcsv($file,explode(',',$line));                    
	        }

		    fclose($file);   
		}


		public function create_dbSchema_txt(){		

			global $wpdb; 
			$db_name = $wpdb->dbname;

		    $existing_schema=$wpdb->get_results("SELECT * FROM information_schema.columns 
		                    WHERE table_schema = '{$db_name}'");

		    $txtFile = fopen($this->files_path ."/". "{$db_name}.txt", "w");

		    $json_serialized_text = json_encode($existing_schema);

		    fwrite($txtFile, $json_serialized_text);

		    fclose($txtFile);    
		}



		public function Zip($source, $destination){

	    if (is_string($source)) $source_arr = array($source); // convert it to array

	    if (!extension_loaded('zip')) {
	        return false;
	    }

	    $zip = new ZipArchive();
	    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
	        return false;
	    }

	    foreach ($source_arr as $source)
	    {
	        if (!file_exists($source)) continue;
			$source = str_replace('\\', '/', realpath($source));

			if (is_dir($source) === true)
			{
			    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

			    foreach ($files as $file)
			    {
			        $file = str_replace('\\', '/', realpath($file));

			        if (is_dir($file) === true)
			        {
			            $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
			        }
			        else if (is_file($file) === true)
			        {
			            $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
			        }
			    }
			}
			else if (is_file($source) === true)
			{
			    $zip->addFromString(basename($source), file_get_contents($source));
			}

		}

		    return $zip->close();

		}

	}


