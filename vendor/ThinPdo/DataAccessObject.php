<?php
  
  IN PROGRESS

namespace ThinPdo;

class DataAccessObject
{
  protected $databaseTable;
  
  // The STD class is the transport to the database
  public abstract function initWithStdClass(\stdClass $class);
  
  // That should be ready to store in the database
  public abstract function toStdClass();
  
  // Database should have a unique constraint for the set of keys provided
  // Returns one or zero rows
  protected function fetchUniqueConstrained(array $keysAndValues) {
    
  }
  
  // ADD YOUR OWN PUBLIC fetchWith_____ functions for each unique constraint
  // like fetchWithId($id) or fetchWithXAndY($x, $y)
  
  public insert() {
    
  }
  
  xxxxxxx
  
  ##############################################################################
  ## DATA MODEL
  ##############################################################################
  
  /// INT NOT NULL, PRIMARY
  public $id;
  
  /// VARCHAR(36) NOT NULL
  public $uuid;
  
  /// VARCHAR(255) NOT NULL
  public $email;
  
  /// INT(5) NOT NULL (in database as zip_code)
  public $zipCode;
  
  /// TIMESTAMP NOT NULL, default to CURRENT_TIMESTAMP
  public $updated;
 
  ##############################################################################
  ## FACTORY
  ##############################################################################
  
  /// Disallow constructor
  public function __construct()
  {
    $this->uuid = gen_uuid();
  }
  
  static public function initWithStdClass(\stdClass $class)
  {    
    $retval = new self();
    $retval->id = $class->id;
    $retval->uuid = $class->uuid;
    $retval->email = $class->email;
    $retval->zipCode = $class->zip_code;
    $retval->updated = $class->updated;
    return $retval;
  }

  ##############################################################################
  ## DATA ACCESS
  ##############################################################################
  
  public static function fetchWithUUID($uuid)
  {
    global $database;
    $rows = $database->select('subscribers', 'uuid=:uuid', array('uuid'=>$uuid));
    return self::initWithStdClass((object) $rows[0]);
  }
  
  public function store()
  {
    global $database;
    $row = array();
    $row['uuid'] = $this->uuid;
    $row['email'] = $this->email;
    $row['zip_code'] = $this->zipCode;
    $database->insert('subscribers', $row, true);
  }  
}