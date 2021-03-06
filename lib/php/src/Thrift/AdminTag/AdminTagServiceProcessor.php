<?php
namespace Ridibooks\Cms\Thrift\AdminTag;
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


class AdminTagServiceProcessor {
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

  protected function process_getAdminIdsFromTags($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminTag\AdminTagService_getAdminIdsFromTags_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminTag\AdminTagService_getAdminIdsFromTags_result();
    try {
      $result->success = $this->handler_->getAdminIdsFromTags($args->tag_ids);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getAdminIdsFromTags', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getAdminIdsFromTags', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_getAdminTagMenus($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminTag\AdminTagService_getAdminTagMenus_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminTag\AdminTagService_getAdminTagMenus_result();
    try {
      $result->success = $this->handler_->getAdminTagMenus($args->tag_id);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getAdminTagMenus', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getAdminTagMenus', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_getMappedAdminMenuHashes($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminTag\AdminTagService_getMappedAdminMenuHashes_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminTag\AdminTagService_getMappedAdminMenuHashes_result();
    try {
      $result->success = $this->handler_->getMappedAdminMenuHashes($args->check_url, $args->tag_id);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getMappedAdminMenuHashes', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getMappedAdminMenuHashes', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_getAdminTag($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminTag\AdminTagService_getAdminTag_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminTag\AdminTagService_getAdminTag_result();
    try {
      $result->success = $this->handler_->getAdminTag($args->tag_id);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getAdminTag', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getAdminTag', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_getAdminTags($seqid, $input, $output) {
    $args = new \Ridibooks\Cms\Thrift\AdminTag\AdminTagService_getAdminTags_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Ridibooks\Cms\Thrift\AdminTag\AdminTagService_getAdminTags_result();
    try {
      $result->success = $this->handler_->getAdminTags($args->tag_ids);
    } catch (\Ridibooks\Cms\Thrift\Errors\UserException $userException) {
      $result->userException = $userException;
        } catch (\Ridibooks\Cms\Thrift\Errors\SystemException $systemException) {
      $result->systemException = $systemException;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getAdminTags', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getAdminTags', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
}
