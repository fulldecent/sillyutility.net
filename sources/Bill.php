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
    $statement = $database->prepare('SELECT * FROM bills WHERE uuid = ?');
    $statement->execute([$uuid]);
    return self::initWithStdClass($statement->fetch());
  }

  public static function fetchAllNotPublished()
  {
    global $database;
    $statement = $database->query('SELECT * FROM bills WHERE status!="DELETED" AND status!="PUBLISHED"');
    $retval = [];
    foreach ($statement as $row) {
      $retval[] = self::initWithStdClass($row);
    }
    return $retval;
  }
  
  public static function fetchAllInZipCode($zipcode)
  {
    global $database;
    $statement = $database->prepare('SELECT * FROM bills WHERE status != "DELETED" AND zip_code = ?');
    $statement->execute([$zipcode]);
    $retval = [];
    foreach ($statement as $row) {
      $retval[] = self::initWithStdClass($row);
    }
    return $retval;
  }
  
  public function store()
  {
    global $database;
    $row = array();
    $row['zip_code'] = $this->zipCode;
    $row['uuid'] = $this->uuid;
    $row['company'] = $this->company;
    if (!empty($this->billingDate)) {
      $row['billing_date'] = $this->billingDate;
    } else {
      $row['billing_date'] = null;
    }
    $row['status'] = $this->status;
    if (intval($this->subscriber)) {
      $row['subscriber'] = $this->subscriber;    
    } else {
      $row['subscriber'] = null;
    }
    if (!empty($this->totalPrice)) {
      $row['total_price'] = $this->totalPrice;
    } else {
      $row['total_price'] = null;
    }
    $statement = $database->prepare('REPLACE INTO bills (zip_code, uuid, company, billing_date, status, subscriber, total_price) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $statement->execute([$row['zip_code'], $row['uuid'], $row['company'], $row['billing_date'], $row['status'], $row['subscriber'], $row['total_price']]);
  }

  /// NONE: Store with the Player class
}