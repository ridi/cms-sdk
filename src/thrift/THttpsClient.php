<?php

namespace Ridibooks\Cms\Thrift;

use Thrift\Transport\THttpClient;
use Thrift\Exception\TTransportException;
use Thrift\Factory\TStringFuncFactory;

class THttpsClient extends THttpClient
{
	public function flush()
	{
		// God, PHP really has some esoteric ways of doing simple things.
		$host = $this->host_.($this->port_ != 80 ? ':'.$this->port_ : '');

		$headers = array();
		$defaultHeaders = array('Host' => $host,
			'Accept' => 'application/x-thrift',
			'User-Agent' => 'PHP/THttpClient',
			'Content-Type' => 'application/x-thrift',
			'Content-Length' => TStringFuncFactory::create()->strlen($this->buf_));
		foreach (array_merge($defaultHeaders, $this->headers_) as $key => $value) {
			$headers[] = "$key: $value";
		}

		$options = array('method' => 'POST',
			'header' => implode("\r\n", $headers),
			'max_redirects' => 1,
			'content' => $this->buf_);
		if ($this->timeout_ > 0) {
			$options['timeout'] = $this->timeout_;
		}
		$this->buf_ = '';

		$contextid = stream_context_create(array(
			'http' => $options,
			'ssl' => array(
				'allow_self_signed' => true,
				'verify_peer' => false,
				'verify_peer_name' => false,
			)
		));
		$this->handle_ = @fopen($this->scheme_.'://'.$host.$this->uri_, 'r', false, $contextid);

		// Connect failed?
		if ($this->handle_ === FALSE) {
			$this->handle_ = null;
			$error = 'THttpClient: Could not connect to '.$host.$this->uri_;
			throw new TTransportException($error, TTransportException::NOT_OPEN);
		}
	}
}
