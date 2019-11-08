<?php
namespace Ridibooks\Cms\Thrift\AdminAuth;
/**
 * Autogenerated by Thrift Compiler (0.10.0)
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *  @generated
 */
use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


class AdminAuthService_authorizeAdminByUrl_args {
  static $_TSPEC;

  /**
   * @var string
   */
  public $admin_id = null;
  /**
   * @var string
   */
  public $check_url = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'admin_id',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'check_url',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['admin_id'])) {
        $this->admin_id = $vals['admin_id'];
      }
      if (isset($vals['check_url'])) {
        $this->check_url = $vals['check_url'];
      }
    }
  }

  public function getName() {
    return 'AdminAuthService_authorizeAdminByUrl_args';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->admin_id);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->check_url);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('AdminAuthService_authorizeAdminByUrl_args');
    if ($this->admin_id !== null) {
      $xfer += $output->writeFieldBegin('admin_id', TType::STRING, 1);
      $xfer += $output->writeString($this->admin_id);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->check_url !== null) {
      $xfer += $output->writeFieldBegin('check_url', TType::STRING, 2);
      $xfer += $output->writeString($this->check_url);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

