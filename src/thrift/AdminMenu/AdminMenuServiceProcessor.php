<?php
namespace Ridibooks\Cms\Thrift\AdminMenu;
/**
 * Autogenerated by Thrift Compiler (1.0.0-dev)
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


class AdminMenuServiceProcessor {
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

  protected function process_getMenuList($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminMenu\AdminMenuService_getMenuList_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminMenu\AdminMenuService_getMenuList_result();
    try {
      $result->success = $this->handler_->getMenuList($args->isUse);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getMenuList', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getMenuList', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_getAllMenuList($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminMenu\AdminMenuService_getAllMenuList_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminMenu\AdminMenuService_getAllMenuList_result();
    try {
      $result->success = $this->handler_->getAllMenuList();
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getAllMenuList', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getAllMenuList', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_getAllMenuAjax($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminMenu\AdminMenuService_getAllMenuAjax_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminMenu\AdminMenuService_getAllMenuAjax_result();
    try {
      $result->success = $this->handler_->getAllMenuAjax();
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getAllMenuAjax', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getAllMenuAjax', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_getMenus($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminMenu\AdminMenuService_getMenus_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminMenu\AdminMenuService_getMenus_result();
    try {
      $result->success = $this->handler_->getMenus($args->menuIds);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getMenus', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getMenus', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_getAdminIdsByMenuId($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminMenu\AdminMenuService_getAdminIdsByMenuId_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminMenu\AdminMenuService_getAdminIdsByMenuId_result();
    try {
      $result->success = $this->handler_->getAdminIdsByMenuId($args->menuId);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getAdminIdsByMenuId', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getAdminIdsByMenuId', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_getAllUserIds($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminMenu\AdminMenuService_getAllUserIds_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminMenu\AdminMenuService_getAllUserIds_result();
    try {
      $result->success = $this->handler_->getAllUserIds($args->menuId);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getAllUserIds', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getAllUserIds', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
}
