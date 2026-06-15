<?php

use Wikimedia\ParamValidator\ParamValidator;

class ApiCustomMessages extends ApiBase {

	public function execute() {

		$params = $this->extractRequestParams();

		if ( empty( $params['format-source'] ) ) {
			$params['format-source'] = "ini";
		}

		$messages = CustomMessages::processMessages( $params['source'], $params['format-source'] );

		$this->getResult()->addValue( null, $this->getModuleName(), [ 'messages' => $messages ] );
	}

	public function getAllowedParams() {
		return [
			'source' => [
				ParamValidator::PARAM_TYPE => 'string',
				ParamValidator::PARAM_REQUIRED => true,
			],
			'format-source' => [
				ParamValidator::PARAM_TYPE => 'string',
				ParamValidator::PARAM_REQUIRED => false,
			],
		];
	}

	protected function getExamplesMessages() {
		return [
			'action=custommsg&source=Help:Event&format-source=ini'
				=> 'apihelp-custommsg-example-1',
		];
	}

}
