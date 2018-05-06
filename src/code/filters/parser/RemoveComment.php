<?php

namespace yii2lab\extension\code\filters\parser;

class RemoveComment extends BaseRemove {
	
	protected $ignoreTypes = [
		T_DOC_COMMENT,
		T_COMMENT,
	];
	
}
