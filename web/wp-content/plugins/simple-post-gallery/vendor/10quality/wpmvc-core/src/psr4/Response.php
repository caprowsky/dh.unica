<?php

namespace WPMVC;

use Exception;

/**
 * Handles http / ajax responses.
 *
 * @author Cami Mostajo <info@10quality.com>
 * @copyright 10Quality <http://www.10quality.com>
 * @license MIT
 * @package WPMVC
 * @version 3.0.0
 */
class Response
{
    /**
     * List of errors in response.
     * @since 3.0.0
     * @var array
     */
    protected $errors = [];
    /**
     * Response message.
     * @since 3.0.0
     * @var string
     */
    protected $message;
    /**
     * Flag that indicates if response status is ok or with error.
     * @since 3.0.0
     * @var bool
     */
    protected $success = false;
    /**
     * Data returned in response.
     * @since 3.0.0
     * @var mixed
     */
    protected $data;
    /**
     * Redirect url
     * @since 3.0.0
     * @var string
     */
    protected $redirect;
    /**
     * ID of the record inserted or saved.
     * @since 3.0.0
     * @var mixed
     */
    protected $id;
    /**
     * Query information
     * @since 3.0.0
     * @var array
     */
    protected $query;
    /**
     * Default constructor.
     * @since 3.0.0
     *
     * @param bool $success Success flag.
     */
    public function __construct( $success = false )
    {
        $this->success = $success;
    }
    /**
     * Class getter function.
     * @since 3.0.0
     *
     * @param string $property Property name.
     *
     * @return mixed
     */
    public function &__get( $property )
    {
        if ( property_exists( $this, $property ) )
            return $this->$property;
        $value = null;
        switch ( $property ) {
            case 'passes':
                $value = empty( $this->errors );
                break;
            case 'fails':
                $value = !empty( $this->errors );
                break;
        }
        return $value;
    }
    /**
     * Class setter function.
     * @since 3.0.0
     *
     * @param string $property Property name.
     * @param mixed  $value    Property value.
     */
    public function __set( $property, $value )
    {
        if ( property_exists( $this, $property ) )
            $this->$property = $value;
    }
    /**
     * Returns object as array.
     * @since 3.0.0
     * 
     * @return array
     */
    public function to_array()
    {
        $output = [
            'error'     => !$this->success || !empty( $this->errors ),
            'status'    => $this->success ? 200 : 500,
        ];
        if ( isset( $this->message ) && !empty( $this->message ) )
            $output['message'] = $this->message;
        if ( isset( $this->redirect ) && !empty( $this->redirect ) )
            $output['redirect'] = $this->redirect;
        if ( !empty( $this->errors ) )
            $output['errors'] = $this->errors;
        if ( isset( $this->data ) )
            $output['data'] = method_exists( $this->data, 'to_array' )
                ? $this->data->to_array()
                : $this->data;
        if ( isset( $this->query ) )
            $output['query'] = $this->query;
        if ( isset( $this->id ) )
            $output['id'] = $this->id;
        return $output;
    }
    /**
     * Returns object as string.
     * Forces JSON_NUMERIC_CHECK
     * @since 3.0.0
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode( $this->to_array(), JSON_NUMERIC_CHECK );
    }

    /**
     * Returns object as JSON string.
     * @since 3.0.0
     *
     * @return string
     */
    public function to_json()
    {
        return (string)$this;
    }
    /**
     * Outputs (prints) response as json.
     * Forces JSON_NUMERIC_CHECK
     * @since 1.0.1
     */
    public function json()
    {
        header( 'Content-Type: application/json' );
        echo json_encode( $this->to_array(), JSON_NUMERIC_CHECK );
        die;
    }
    /**
     * Adds error to list.
     * @since 3.0.0
     *
     * @param string $key   Error key.
     * @param string $error Error message.
     */
    protected function _error( $key, $error )
    {
        if ( !array_key_exists( $key, $this->errors ) )
            $this->errors[$key] = [];
        $this->errors[$key][] = $error;
    }

    /**
     * Calls to method.
     * @since 3.0.0
     *
     * @param string $method Method name.
     * @param string $params Method parameters.
     *
     * @return mixed
     */
    public function __call( $method, $params = [] )
    {
        switch ( $method ) {
            case 'error':
                return call_user_func_array( [&$this, '_error'], $params );
            default:
                return call_user_func_array( [&$this, $method], $params );
        }
        throw new Exception( $method.' method not found.' );
    }
    /**
     * Calls to static method.
     * @since 3.0.0
     *
     * @param string $method Method name.
     * @param string $params Method parameters.
     *
     * @return mixed
     */
    public static function __callStatic( $method, $params = [] )
    {
        $response = new self;
        switch ( $method ) {
            case 'error':
                return call_user_func_array( [&$response, '_error'], $params );
            default:
                return call_user_func_array( [&$response, $method], $params );
        }
        throw new Exception( $method.' method not found.' );
    }
}