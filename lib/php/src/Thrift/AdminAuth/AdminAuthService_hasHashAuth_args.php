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


class AdminAuthService_hasHashAuth_args {
  static $_TSPEC;

  /**
   * @var string
   */
  public $hash = null;
  /**
   * @var string
   */
  public $checkUrl = null;
  /**
   * @var string
   */
  public $adminId = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'hash',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'checkUrl',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'adminId',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['hash'])) {
        $this->hash = $vals['hash'];
      }
      if (isset($vals['checkUrl'])) {
        $this->checkUrl = $vals['checkUrl'];
      }
      if (isset($vals['adminId'])) {
        $this->adminId = $vals['adminId'];
      }
    }
  }

  public function getName() {
    return 'AdminAuthService_hasHashAuth_args';
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
            $xfer += $input->readString($this->hash);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->checkUrl);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->adminId);
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
    $xfer += $output->writeStructBegin('AdminAuthService_hasHashAuth_args');
    if ($this->hash !== null) {
      $xfer += $output->writeFieldBegin('hash', TType::STRING, 1);
      $xfer += $output->writeString($this->hash);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->checkUrl !== null) {
      $xfer += $output->writeFieldBegin('checkUrl', TType::STRING, 2);
      $xfer += $output->writeString($this->checkUrl);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->adminId !== null) {
      $xfer += $output->writeFieldBegin('adminId', TType::STRING, 3);
      $xfer += $output->writeString($this->adminId);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

