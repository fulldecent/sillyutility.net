<?php
namespace SillyUtility;

class Bill
{
  ##############################################################################
  ## DATA MODEL
  ##############################################################################
  
  /// INT NOT NULL, auto increment
  public $id;
  
  /// VARCHAR(36) NOT NULL
  public $uuid;
  
  /// INT(5) NOT NULL (in database as zip_code)
  public $zipCode;
  
  /// VARCHAR(100) NULL
  public $company;
  
  /// DATETIME NULL (in database as billing_date)
  public $billingDate;
  
  /// ENUM('NEEDS REVIEW','PUBLISHED','DELETED','READY PUBLISH') NOT NULL
  public $status;
  
  /// INT NULL
  public $subscriber;
  
  /// DATETIME NOT NULL
  public $updated;
  
  /// FLOAT NULL
  public $totalPrice;
 
  ##############################################################################
  ## BUSINESS
  ##############################################################################

  // Returns like array(1=>true, 2=>false)
  // False means only the file bill-images-NOT-REVIEWED/[UUID]-page-3.png exists
  // True means bill-images-EDITED/[UUID]-page-2.jpg also exists
  function getUnpublishedImages()
  {
    $retval = array();
    $files = glob('bill-images-NOT-REVIEWED/' . $this->uuid . '-page-*.png');
    foreach ($files as $file) {
      $file = basename($file);
      if (preg_match('/^([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12})-page-([0-9]+).png$/', $file, $matches)) {
        $uuid = $matches[1];
        $pageNumber = $matches[2];
      } else {
        die('no bueno');
      }
      $retval[intval($pageNumber)] = false;
    }
    $files = glob('bill-images-EDITED/' . $this->uuid . '-page-*.jpg');
    foreach ($files as $file) {
      $file = basename($file);
      if (preg_match('/^([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12})-page-([0-9]+).jpg$/', $file, $matches)) {
        $uuid = $matches[1];
        $pageNumber = $matches[2];
      } else {
        die('no2');
      }
      $retval[intval($pageNumber)] = true;
    }    
    return $retval;
  }
  
  function getNumberOfPublishedImages()
  {
    $retval = 0;
    $files = glob('bill-images/' . $this->uuid . '-page-*.jpg');
    foreach ($files as $file) {
      $file = basename($file);
      if (preg_match('/^([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12})-page-([0-9]+).jpg$/', $file, $matches)) {
        $uuid = $matches[1];
        $pageNumber = $matches[2];
      } else {
        die('no2');
      }
      $retval++;
    }    
    return $retval;
  }
  
  function publish()
  {
    foreach ($this->getUnpublishedImages() as $i => $reviewed) {
      if (!$reviewed) {
        $error = ErrorPage::userErrorWithTitleAndMessage('Publish bill', 'Bill image has not been reviewed, cannot publish');
        $error->renderAndDie();        
      }      
      $fileName = $this->uuid . '-page-' . $i . '.jpg';
      rename('bill-images-EDITED/' . $fileName, 'bill-images/' . $fileName);
    }
    $this->status = 'PUBLISHED';
    $this->store();
    foreach ($this->getUnpublishedImages() as $i => $reviewed) {
      if (!$reviewed) {
        $fileName = $this->uuid . '-page-' . $i . '.jpg';
        unlink('bill-images-NOT-REVIEWED/' . $fileName);
      }      
    }
  }

  ##############################################################################
  ## FACTORY
  ##############################################################################

  public function __construct()
  {
    $this->uuid = gen_uuid();
    $this->status = 'NEEDS REVIEW';
  }  
  
  /// Create Player from database array
  static public function initWithStdClass(\stdClass $class)
  {    
    $bill = new self();
    $bill->id = $class->id;
    $bill->uuid = $class->uuid;
    $bill->zipCode = $class->zip_code;
    $bill->company = $class->company;
    $bill->billingDate = $class->billing_date;
    $bill->status = $class->status;
    $bill->subscriber = $class->subscriber;
    $bill->updated = $class->updated;
    $bill->totalPrice = round($class->total_price, 2);
    return $bill;
  }

  ##############################################################################
  ## DATA ACCESS
  ##############################################################################

  public static function fetchWithId($id)
  {
    global $database;
    $rows = $database->select('bills', 'id=:id', array('id'=>$id));
    return self::initWithStdClass((object) $rows[0]);
  }

  public static function fetchWithUUID($uuid)
  {
    global $database;
    $rows = $database->select('bills', 'uuid=:uuid', array('uuid'=>$uuid));
    return self::initWithStdClass((object) $rows[0]);
  }

  public function store()
  {
//TODO: validate UUID with ([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12})    
    
    global $database;
    $row = array();
    $row['zip_code'] = $this->zipCode;
    $row['uuid'] = $this->uuid;
    $row['company'] = $this->company;
    if (!empty($this->billingDate)) {
      $row['billing_date'] = $this->billingDate;    
    }
    $row['status'] = $this->status;
    if (intval($this->subscriber)) {
      $row['subscriber'] = $this->subscriber;    
    }
    if (!empty($this->totalPrice)) {
      $row['total_price'] = $this->totalPrice;
    }
    $database->replace('bills', $row, true);
  }

  /// NONE: Store with the Player class
}