<?php

/* This file was autogenerated by spec/parser.php - Do not modify */

namespace AmqpLib\Helper\Protocol;

use AmqpLib\Wire\AMQPWriter;
use AmqpLib\Wire\AMQPReader;

class Protocol080
{
    /**
     * @param int $version_major
     * @param int $version_minor
     * @param mixed $server_properties
     * @param string $mechanisms
     * @param string $locales
     * @return array
     */
    public function connectionStart($version_major = 0, $version_minor = 8, $server_properties, $mechanisms = 'PLAIN', $locales = 'en_US')
    {
        $writer = new AMQPWriter();
        $writer->write_octet($version_major);
        $writer->write_octet($version_minor);
        $writer->write_table(empty($server_properties) ? array() : $server_properties);
        $writer->write_longstr($mechanisms);
        $writer->write_longstr($locales);
        return array(10, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function connectionStartOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_table();
        $response[] = $reader->read_shortstr();
        $response[] = $reader->read_longstr();
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param string $challenge
     * @return array
     */
    public function connectionSecure($challenge)
    {
        $writer = new AMQPWriter();
        $writer->write_longstr($challenge);
        return array(10, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function connectionSecureOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_longstr();
        return $response;
    }

    /**
     * @param int $channel_max
     * @param int $frame_max
     * @param int $heartbeat
     * @return array
     */
    public function connectionTune($channel_max = 0, $frame_max = 0, $heartbeat = 0)
    {
        $writer = new AMQPWriter();
        $writer->write_short($channel_max);
        $writer->write_long($frame_max);
        $writer->write_short($heartbeat);
        return array(10, 30, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function connectionTuneOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_short();
        $response[] = $reader->read_long();
        $response[] = $reader->read_short();
        return $response;
    }

    /**
     * @param string $virtual_host
     * @param string $capabilities
     * @param bool $insist
     * @return array
     */
    public function connectionOpen($virtual_host = '/', $capabilities = '', $insist = false)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($virtual_host);
        $writer->write_shortstr($capabilities);
        $writer->write_bits(array($insist));
        return array(10, 40, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function connectionOpenOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param string $host
     * @param string $known_hosts
     * @return array
     */
    public function connectionRedirect($host, $known_hosts = '')
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($host);
        $writer->write_shortstr($known_hosts);
        return array(10, 50, $writer);
    }

    /**
     * @param int $reply_code
     * @param string $reply_text
     * @param int $class_id
     * @param int $method_id
     * @return array
     */
    public function connectionClose($reply_code, $reply_text = '', $class_id, $method_id)
    {
        $writer = new AMQPWriter();
        $writer->write_short($reply_code);
        $writer->write_shortstr($reply_text);
        $writer->write_short($class_id);
        $writer->write_short($method_id);
        return array(10, 60, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function connectionCloseOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**
     * @param string $out_of_band
     * @return array
     */
    public function channelOpen($out_of_band = '')
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($out_of_band);
        return array(20, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function channelOpenOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**
     * @param bool $active
     * @return array
     */
    public function channelFlow($active)
    {
        $writer = new AMQPWriter();
        $writer->write_bits(array($active));
        return array(20, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function channelFlowOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_bit();
        return $response;
    }

    /**
     * @param int $reply_code
     * @param string $reply_text
     * @param array $details
     * @return array
     */
    public function channelAlert($reply_code, $reply_text = '', $details = array())
    {
        $writer = new AMQPWriter();
        $writer->write_short($reply_code);
        $writer->write_shortstr($reply_text);
        $writer->write_table(empty($details) ? array() : $details);
        return array(20, 30, $writer);
    }

    /**
     * @param int $reply_code
     * @param string $reply_text
     * @param int $class_id
     * @param int $method_id
     * @return array
     */
    public function channelClose($reply_code, $reply_text = '', $class_id, $method_id)
    {
        $writer = new AMQPWriter();
        $writer->write_short($reply_code);
        $writer->write_shortstr($reply_text);
        $writer->write_short($class_id);
        $writer->write_short($method_id);
        return array(20, 40, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function channelCloseOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**
     * @param string $realm
     * @param bool $exclusive
     * @param bool $passive
     * @param bool $active
     * @param bool $write
     * @param bool $read
     * @return array
     */
    public function accessRequest($realm = '/data', $exclusive = false, $passive = true, $active = true, $write = true, $read = true)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($realm);
        $writer->write_bits(array($exclusive, $passive, $active, $write, $read));
        return array(30, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function accessRequestOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_short();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $exchange
     * @param string $type
     * @param bool $passive
     * @param bool $durable
     * @param bool $auto_delete
     * @param bool $internal
     * @param bool $nowait
     * @param array $arguments
     * @return array
     */
    public function exchangeDeclare($ticket = 1, $exchange, $type = 'direct', $passive = false, $durable = false, $auto_delete = false, $internal = false, $nowait = false, $arguments = array())
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($type);
        $writer->write_bits(array($passive, $durable, $auto_delete, $internal, $nowait));
        $writer->write_table(empty($arguments) ? array() : $arguments);
        return array(40, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function exchangeDeclareOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $exchange
     * @param bool $if_unused
     * @param bool $nowait
     * @return array
     */
    public function exchangeDelete($ticket = 1, $exchange, $if_unused = false, $nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($exchange);
        $writer->write_bits(array($if_unused, $nowait));
        return array(40, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function exchangeDeleteOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param bool $passive
     * @param bool $durable
     * @param bool $exclusive
     * @param bool $auto_delete
     * @param bool $nowait
     * @param array $arguments
     * @return array
     */
    public function queueDeclare($ticket = 1, $queue = '', $passive = false, $durable = false, $exclusive = false, $auto_delete = false, $nowait = false, $arguments = array())
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_bits(array($passive, $durable, $exclusive, $auto_delete, $nowait));
        $writer->write_table(empty($arguments) ? array() : $arguments);
        return array(50, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function queueDeclareOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_shortstr();
        $response[] = $reader->read_long();
        $response[] = $reader->read_long();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param string $exchange
     * @param string $routing_key
     * @param bool $nowait
     * @param array $arguments
     * @return array
     */
    public function queueBind($ticket = 1, $queue = '', $exchange, $routing_key = '', $nowait = false, $arguments = array())
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        $writer->write_bits(array($nowait));
        $writer->write_table(empty($arguments) ? array() : $arguments);
        return array(50, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function queueBindOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param bool $nowait
     * @return array
     */
    public function queuePurge($ticket = 1, $queue = '', $nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_bits(array($nowait));
        return array(50, 30, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function queuePurgeOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_long();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param bool $if_unused
     * @param bool $if_empty
     * @param bool $nowait
     * @return array
     */
    public function queueDelete($ticket = 1, $queue = '', $if_unused = false, $if_empty = false, $nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_bits(array($if_unused, $if_empty, $nowait));
        return array(50, 40, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function queueDeleteOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_long();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param string $exchange
     * @param string $routing_key
     * @param array $arguments
     * @return array
     */
    public function queueUnbind($ticket = 1, $queue = '', $exchange, $routing_key = '', $arguments = array())
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        $writer->write_table(empty($arguments) ? array() : $arguments);
        return array(50, 50, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function queueUnbindOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**
     * @param int $prefetch_size
     * @param int $prefetch_count
     * @param bool $global
     * @return array
     */
    public function basicQos($prefetch_size = 0, $prefetch_count = 0, $global = false)
    {
        $writer = new AMQPWriter();
        $writer->write_long($prefetch_size);
        $writer->write_short($prefetch_count);
        $writer->write_bits(array($global));
        return array(60, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function basicQosOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param string $consumer_tag
     * @param bool $no_local
     * @param bool $no_ack
     * @param bool $exclusive
     * @param bool $nowait
     * @return array
     */
    public function basicConsume($ticket = 1, $queue = '', $consumer_tag = '', $no_local = false, $no_ack = false, $exclusive = false, $nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_shortstr($consumer_tag);
        $writer->write_bits(array($no_local, $no_ack, $exclusive, $nowait));
        return array(60, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function basicConsumeOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param string $consumer_tag
     * @param bool $nowait
     * @return array
     */
    public function basicCancel($consumer_tag, $nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($consumer_tag);
        $writer->write_bits(array($nowait));
        return array(60, 30, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function basicCancelOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $exchange
     * @param string $routing_key
     * @param bool $mandatory
     * @param bool $immediate
     * @return array
     */
    public function basicPublish($ticket = 1, $exchange = '', $routing_key = '', $mandatory = false, $immediate = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        $writer->write_bits(array($mandatory, $immediate));
        return array(60, 40, $writer);
    }

    /**
     * @param int $reply_code
     * @param string $reply_text
     * @param string $exchange
     * @param string $routing_key
     * @return array
     */
    public function basicReturn($reply_code, $reply_text = '', $exchange, $routing_key)
    {
        $writer = new AMQPWriter();
        $writer->write_short($reply_code);
        $writer->write_shortstr($reply_text);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        return array(60, 50, $writer);
    }

    /**
     * @param string $consumer_tag
     * @param int $delivery_tag
     * @param bool $redelivered
     * @param string $exchange
     * @param string $routing_key
     * @return array
     */
    public function basicDeliver($consumer_tag, $delivery_tag, $redelivered = false, $exchange, $routing_key)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($consumer_tag);
        $writer->write_longlong($delivery_tag);
        $writer->write_bits(array($redelivered));
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        return array(60, 60, $writer);
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param bool $no_ack
     * @return array
     */
    public function basicGet($ticket = 1, $queue = '', $no_ack = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_bits(array($no_ack));
        return array(60, 70, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function basicGetOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_longlong();
        $response[] = $reader->read_bit();
        $response[] = $reader->read_shortstr();
        $response[] = $reader->read_shortstr();
        $response[] = $reader->read_long();
        return $response;
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function basicGetEmpty(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param int $delivery_tag
     * @param bool $multiple
     * @return array
     */
    public function basicAck($delivery_tag = 0, $multiple = false)
    {
        $writer = new AMQPWriter();
        $writer->write_longlong($delivery_tag);
        $writer->write_bits(array($multiple));
        return array(60, 80, $writer);
    }

    /**
     * @param int $delivery_tag
     * @param bool $requeue
     * @return array
     */
    public function basicReject($delivery_tag, $requeue = true)
    {
        $writer = new AMQPWriter();
        $writer->write_longlong($delivery_tag);
        $writer->write_bits(array($requeue));
        return array(60, 90, $writer);
    }

    /**
     * @param bool $requeue
     * @return array
     */
    public function basicRecoverAsync($requeue = false)
    {
        $writer = new AMQPWriter();
        $writer->write_bits(array($requeue));
        return array(60, 100, $writer);
    }

    /**
     * @param bool $requeue
     * @return array
     */
    public function basicRecover($requeue = false)
    {
        $writer = new AMQPWriter();
        $writer->write_bits(array($requeue));
        return array(60, 110, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function basicRecoverOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**
     * @param int $prefetch_size
     * @param int $prefetch_count
     * @param bool $global
     * @return array
     */
    public function fileQos($prefetch_size = 0, $prefetch_count = 0, $global = false)
    {
        $writer = new AMQPWriter();
        $writer->write_long($prefetch_size);
        $writer->write_short($prefetch_count);
        $writer->write_bits(array($global));
        return array(70, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function fileQosOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param string $consumer_tag
     * @param bool $no_local
     * @param bool $no_ack
     * @param bool $exclusive
     * @param bool $nowait
     * @return array
     */
    public function fileConsume($ticket = 1, $queue = '', $consumer_tag = '', $no_local = false, $no_ack = false, $exclusive = false, $nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_shortstr($consumer_tag);
        $writer->write_bits(array($no_local, $no_ack, $exclusive, $nowait));
        return array(70, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function fileConsumeOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param string $consumer_tag
     * @param bool $nowait
     * @return array
     */
    public function fileCancel($consumer_tag, $nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($consumer_tag);
        $writer->write_bits(array($nowait));
        return array(70, 30, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function fileCancelOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param string $identifier
     * @param int $content_size
     * @return array
     */
    public function fileOpen($identifier, $content_size)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($identifier);
        $writer->write_longlong($content_size);
        return array(70, 40, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function fileOpenOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_longlong();
        return $response;
    }

    /**

     * @return array
     */
    public function fileStage()
    {
        $writer = new AMQPWriter();
        return array(70, 50, $writer);
    }

    /**
     * @param int $ticket
     * @param string $exchange
     * @param string $routing_key
     * @param bool $mandatory
     * @param bool $immediate
     * @param string $identifier
     * @return array
     */
    public function filePublish($ticket = 1, $exchange = '', $routing_key = '', $mandatory = false, $immediate = false, $identifier)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        $writer->write_bits(array($mandatory, $immediate));
        $writer->write_shortstr($identifier);
        return array(70, 60, $writer);
    }

    /**
     * @param int $reply_code
     * @param string $reply_text
     * @param string $exchange
     * @param string $routing_key
     * @return array
     */
    public function fileReturn($reply_code = 200, $reply_text = '', $exchange, $routing_key)
    {
        $writer = new AMQPWriter();
        $writer->write_short($reply_code);
        $writer->write_shortstr($reply_text);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        return array(70, 70, $writer);
    }

    /**
     * @param string $consumer_tag
     * @param int $delivery_tag
     * @param bool $redelivered
     * @param string $exchange
     * @param string $routing_key
     * @param string $identifier
     * @return array
     */
    public function fileDeliver($consumer_tag, $delivery_tag, $redelivered = false, $exchange, $routing_key, $identifier)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($consumer_tag);
        $writer->write_longlong($delivery_tag);
        $writer->write_bits(array($redelivered));
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        $writer->write_shortstr($identifier);
        return array(70, 80, $writer);
    }

    /**
     * @param int $delivery_tag
     * @param bool $multiple
     * @return array
     */
    public function fileAck($delivery_tag = 0, $multiple = false)
    {
        $writer = new AMQPWriter();
        $writer->write_longlong($delivery_tag);
        $writer->write_bits(array($multiple));
        return array(70, 90, $writer);
    }

    /**
     * @param int $delivery_tag
     * @param bool $requeue
     * @return array
     */
    public function fileReject($delivery_tag, $requeue = true)
    {
        $writer = new AMQPWriter();
        $writer->write_longlong($delivery_tag);
        $writer->write_bits(array($requeue));
        return array(70, 100, $writer);
    }

    /**
     * @param int $prefetch_size
     * @param int $prefetch_count
     * @param int $consume_rate
     * @param bool $global
     * @return array
     */
    public function streamQos($prefetch_size = 0, $prefetch_count = 0, $consume_rate = 0, $global = false)
    {
        $writer = new AMQPWriter();
        $writer->write_long($prefetch_size);
        $writer->write_short($prefetch_count);
        $writer->write_long($consume_rate);
        $writer->write_bits(array($global));
        return array(80, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function streamQosOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param string $consumer_tag
     * @param bool $no_local
     * @param bool $exclusive
     * @param bool $nowait
     * @return array
     */
    public function streamConsume($ticket = 1, $queue = '', $consumer_tag = '', $no_local = false, $exclusive = false, $nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_shortstr($consumer_tag);
        $writer->write_bits(array($no_local, $exclusive, $nowait));
        return array(80, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function streamConsumeOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param string $consumer_tag
     * @param bool $nowait
     * @return array
     */
    public function streamCancel($consumer_tag, $nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($consumer_tag);
        $writer->write_bits(array($nowait));
        return array(80, 30, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function streamCancelOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $exchange
     * @param string $routing_key
     * @param bool $mandatory
     * @param bool $immediate
     * @return array
     */
    public function streamPublish($ticket = 1, $exchange = '', $routing_key = '', $mandatory = false, $immediate = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        $writer->write_bits(array($mandatory, $immediate));
        return array(80, 40, $writer);
    }

    /**
     * @param int $reply_code
     * @param string $reply_text
     * @param string $exchange
     * @param string $routing_key
     * @return array
     */
    public function streamReturn($reply_code = 200, $reply_text = '', $exchange, $routing_key)
    {
        $writer = new AMQPWriter();
        $writer->write_short($reply_code);
        $writer->write_shortstr($reply_text);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        return array(80, 50, $writer);
    }

    /**
     * @param string $consumer_tag
     * @param int $delivery_tag
     * @param string $exchange
     * @param string $queue
     * @return array
     */
    public function streamDeliver($consumer_tag, $delivery_tag, $exchange, $queue)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($consumer_tag);
        $writer->write_longlong($delivery_tag);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($queue);
        return array(80, 60, $writer);
    }

    /**

     * @return array
     */
    public function txSelect()
    {
        $writer = new AMQPWriter();
        return array(90, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function txSelectOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**

     * @return array
     */
    public function txCommit()
    {
        $writer = new AMQPWriter();
        return array(90, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function txCommitOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**

     * @return array
     */
    public function txRollback()
    {
        $writer = new AMQPWriter();
        return array(90, 30, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function txRollbackOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**

     * @return array
     */
    public function dtxSelect()
    {
        $writer = new AMQPWriter();
        return array(100, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function dtxSelectOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**
     * @param string $dtx_identifier
     * @return array
     */
    public function dtxStart($dtx_identifier)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($dtx_identifier);
        return array(100, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function dtxStartOk(AMQPReader $reader)
    {
        $response = [];
        return $response;
    }

    /**
     * @param mixed $meta_data
     * @return array
     */
    public function tunnelRequest($meta_data)
    {
        $writer = new AMQPWriter();
        $writer->write_table(empty($meta_data) ? array() : $meta_data);
        return array(110, 10, $writer);
    }

    /**
     * @param mixed $integer_1
     * @param int $integer_2
     * @param int $integer_3
     * @param int $integer_4
     * @param mixed $operation
     * @return array
     */
    public function testInteger($integer_1, $integer_2, $integer_3, $integer_4, $operation)
    {
        $writer = new AMQPWriter();
        $writer->write_octet($integer_1);
        $writer->write_short($integer_2);
        $writer->write_long($integer_3);
        $writer->write_longlong($integer_4);
        $writer->write_octet($operation);
        return array(120, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function testIntegerOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_longlong();
        return $response;
    }

    /**
     * @param string $string_1
     * @param string $string_2
     * @param mixed $operation
     * @return array
     */
    public function testString($string_1, $string_2, $operation)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($string_1);
        $writer->write_longstr($string_2);
        $writer->write_octet($operation);
        return array(120, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function testStringOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_longstr();
        return $response;
    }

    /**
     * @param mixed $table
     * @param mixed $integer_op
     * @param mixed $string_op
     * @return array
     */
    public function testTable($table, $integer_op, $string_op)
    {
        $writer = new AMQPWriter();
        $writer->write_table(empty($table) ? array() : $table);
        $writer->write_octet($integer_op);
        $writer->write_octet($string_op);
        return array(120, 30, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function testTableOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_longlong();
        $response[] = $reader->read_longstr();
        return $response;
    }

    /**

     * @return array
     */
    public function testContent()
    {
        $writer = new AMQPWriter();
        return array(120, 40, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function testContentOk(AMQPReader $reader)
    {
        $response = [];
        $response[] = $reader->read_long();
        return $response;
    }
}
