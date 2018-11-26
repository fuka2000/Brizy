<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/26/18
 * Time: 5:00 PM
 */

class Brizy_Editor_Forms_Account extends Brizy_Admin_Serializable {

	/**
	 * @var string[]
	 */
	private $data;

	/**
	 * Brizy_Editor_Forms_Account constructor.
	 *
	 * @param null $data
	 */
	public function __construct( $data = null ) {
		if ( ! is_array( $data ) ) {
			$this->data = array();
		}
		$this->data = $data;
	}

	/**
	 * @return string
	 */
	public function serialize() {
		return serialize( $this->jsonSerialize() );
	}

	public function jsonSerialize() {
		return $this->data;
	}

	public function convertToOptionValue() {
		return $this->data;
	}

	static public function createFromSerializedData( $data ) {
		$instance = new self();

		foreach ( $data as $key => $val ) {
			$instance->set( $key, $val );
		}

		return $instance;
	}

	/**
	 * @return Brizy_Editor_Forms_Form
	 * @throws Exception
	 */
	public static function createFromJson( $json_obj ) {

		if ( ! isset( $json_obj ) ) {
			throw new Exception( 'Bad Request', 400 );
		}

		if ( is_object( $json_obj ) ) {
			return self::createFromSerializedData( $json_obj );
		}

		return new self();
	}


	/**
	 * @param $name
	 * @param $arguments
	 *
	 * @return mixed|null
	 */
	public function __call( $name, $arguments ) {
		$method = substr( $name, 0, 3 );
		$key    = substr( $name, 3 );

		switch ( $method ) {
			case 'set':
				return $this->set( $key, $arguments[0] );
				break;
			case 'get':
				return $this->get( $key );
				break;
		}
	}

	/**
	 * @param $name
	 *
	 * @return null|mixed
	 */
	protected function get( $name ) {

		if ( is_null( $name ) ) {
			return;
		}

		if ( isset( $this->data[ $name ] ) ) {
			return $this->data[ $name ];
		}

		return null;
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return null|mixed
	 */
	protected function set( $key, $value ) {
		if ( is_null( $value ) ) {
			return null;
		}

		return $this->data[ $key ] = $value;
	}

}