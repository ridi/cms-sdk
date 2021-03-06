<?php
namespace Ridibooks\Cms\Thrift\AdminUser;
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


class AdminUserServiceProcessor {
  protected $handler_ = null;
  public function __construct($handler) {
    $this->handler_ = $handler;
  }

  public function process($input, $output) {
    $rseqid = 0;
    $fname = null;
    $mtype = 0;

    $input->readMessageBegin($fname, $mtype, $rseqid);
    $methodname = 'process_'.$fname;
    if (!method_exists($this, $methodname)) {
      $input->skip(TType::STRUCT);
      $input->readMessageEnd();
      $x = new TApplicationException('Function '.$fname.' not implemented.', TApplicationException::UNKNOWN_METHOD);
      $output->writeMessageBegin($fname, TMessageType::EXCEPTION, $rseqid);
      $x->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
      return;
    }
    $this->$methodname($rseqid, $input, $output);
    return true;
  }

  protected function process_getAllAdminUserArray($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_getAllAdminUserArray_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_getAllAdminUserArray_result();
    try {
      $result->success = $this->handler_->getAllAdminUserArray();
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getAllAdminUserArray', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getAllAdminUserArray', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_getUser($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_getUser_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_getUser_result();
    try {
      $result->success = $this->handler_->getUser($args->userId);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getUser', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getUser', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_getAdminUserTag($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_getAdminUserTag_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_getAdminUserTag_result();
    try {
      $result->success = $this->handler_->getAdminUserTag($args->userId);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getAdminUserTag', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getAdminUserTag', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_getAdminUserMenu($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_getAdminUserMenu_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_getAdminUserMenu_result();
    try {
      $result->success = $this->handler_->getAdminUserMenu($args->userId);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getAdminUserMenu', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getAdminUserMenu', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_getAllMenuIds($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_getAllMenuIds_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_getAllMenuIds_result();
    try {
      $result->success = $this->handler_->getAllMenuIds($args->userId);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getAllMenuIds', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getAllMenuIds', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_updateMyInfo($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_updateMyInfo_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_updateMyInfo_result();
    try {
      $result->success = $this->handler_->updateMyInfo($args->name, $args->team, $args->isUse, $args->passwd);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'updateMyInfo', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('updateMyInfo', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_updatePassword($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_updatePassword_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminUser\AdminUserService_updatePassword_result();
    try {
      $result->success = $this->handler_->updatePassword($args->userId, $args->plainPassword);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'updatePassword', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('updatePassword', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
}
