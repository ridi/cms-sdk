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


class AdminAuthService_authorize_result {
  static $_TSPEC;

  /**
   * @var \Ridibooks\Cms\Thrift\Errors\SystemException
   */
  public $systemException = null;
  /**
   * @var \Ridibooks\Cms\Thrift\Errors\NoTokenException
   */
  public $noTokenException = null;
  /**
   * @var \Ridibooks\Cms\Thrift\Errors\MalformedTokenException
   */
  public $malformedTokenException = null;
  /**
   * @var \Ridibooks\Cms\Thrift\Errors\ExpiredTokenException
   */
  public $expiredTokenException = null;
  /**
   * @var \Ridibooks\Cms\Thrift\Errors\UnauthorizedException
   */
  public $unauthorizedException = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'systemException',
          'type' => TType::STRUCT,
          'class' => '\Ridibooks\Cms\Thrift\Errors\SystemException',
          ),
        2 => array(
          'var' => 'noTokenException',
          'type' => TType::STRUCT,
          'class' => '\Ridibooks\Cms\Thrift\Errors\NoTokenException',
          ),
        3 => array(
          'var' => 'malformedTokenException',
          'type' => TType::STRUCT,
          'class' => '\Ridibooks\Cms\Thrift\Errors\MalformedTokenException',
          ),
        4 => array(
          'var' => 'expiredTokenException',
          'type' => TType::STRUCT,
          'class' => '\Ridibooks\Cms\Thrift\Errors\ExpiredTokenException',
          ),
        5 => array(
          'var' => 'unauthorizedException',
          'type' => TType::STRUCT,
          'class' => '\Ridibooks\Cms\Thrift\Errors\UnauthorizedException',
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['systemException'])) {
        $this->systemException = $vals['systemException'];
      }
      if (isset($vals['noTokenException'])) {
        $this->noTokenException = $vals['noTokenException'];
      }
      if (isset($vals['malformedTokenException'])) {
        $this->malformedTokenException = $vals['malformedTokenException'];
      }
      if (isset($vals['expiredTokenException'])) {
        $this->expiredTokenException = $vals['expiredTokenException'];
      }
      if (isset($vals['unauthorizedException'])) {
        $this->unauthorizedException = $vals['unauthorizedException'];
      }
    }
  }

  public function getName() {
    return 'AdminAuthService_authorize_result';
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
          if ($ftype == TType::STRUCT) {
            $this->systemException = new \Ridibooks\Cms\Thrift\Errors\SystemException();
            $xfer += $this->systemException->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::STRUCT) {
            $this->noTokenException = new \Ridibooks\Cms\Thrift\Errors\NoTokenException();
            $xfer += $this->noTokenException->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::STRUCT) {
            $this->malformedTokenException = new \Ridibooks\Cms\Thrift\Errors\MalformedTokenException();
            $xfer += $this->malformedTokenException->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::STRUCT) {
            $this->expiredTokenException = new \Ridibooks\Cms\Thrift\Errors\ExpiredTokenException();
            $xfer += $this->expiredTokenException->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 5:
          if ($ftype == TType::STRUCT) {
            $this->unauthorizedException = new \Ridibooks\Cms\Thrift\Errors\UnauthorizedException();
            $xfer += $this->unauthorizedException->read($input);
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
    $xfer += $output->writeStructBegin('AdminAuthService_authorize_result');
    if ($this->systemException !== null) {
      $xfer += $output->writeFieldBegin('systemException', TType::STRUCT, 1);
      $xfer += $this->systemException->write($output);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->noTokenException !== null) {
      $xfer += $output->writeFieldBegin('noTokenException', TType::STRUCT, 2);
      $xfer += $this->noTokenException->write($output);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->malformedTokenException !== null) {
      $xfer += $output->writeFieldBegin('malformedTokenException', TType::STRUCT, 3);
      $xfer += $this->malformedTokenException->write($output);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->expiredTokenException !== null) {
      $xfer += $output->writeFieldBegin('expiredTokenException', TType::STRUCT, 4);
      $xfer += $this->expiredTokenException->write($output);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->unauthorizedException !== null) {
      $xfer += $output->writeFieldBegin('unauthorizedException', TType::STRUCT, 5);
      $xfer += $this->unauthorizedException->write($output);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}
