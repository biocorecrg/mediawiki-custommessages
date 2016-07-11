<?php
class ApiCustomMessages extends ApiBase {

	public function execute() {

		$params = $this->extractRequestParams();
		
		if ( empty( $params['format-source'] ) ) {
			$params['format-source'] = "ini";
		}

		$messages = CustomMessages::processMessages( $params['source'], $params['format-source'] );

		$this->getResult()->addValue( null, $this->getModuleName(), array ( 'messages' => $messages ) );
	}

	public function getAllowedParams() {
		return array(
			'source' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'format-source' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			)	
		);
	}

	public function getDescription() {
		return array(
			'API for handling custom messages'
		);
	}
	public function getParamDescription() {
		return array(
			'source' => 'Source page of the messages',
			'format-source' => 'Format of the page'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': 1.1';
	}

}