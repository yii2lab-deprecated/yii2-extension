<?php

namespace yii2lab\extension\common\helpers;

class TableMatrixHelper {
	
	public $debug = false;
	public $cellSize = 30;
	public $colors = [];
	public $border = 1;

	public function draw($data) {
		$code = '';
		foreach($data as $x => $line) {
			$codeLine = '';
			foreach($line as $y => $cell) {
				$color = $this->colors[ $cell ];
				$value = $this->debug ? "$x-$y" : null;
				$codeLine .= $this->drawCell($color, $value);
			}
			$code .= $this->wrapLine($codeLine);
		}
		return $this->wrapTable($code);
	}
	
	private function drawCell($color, $value = '') {
		$borderCode = '';
		if($this->border) {
			$borderCode = '
				border-bottom: 1px solid black;
                border-left: 1px solid black;';
		}
		$code = '<td
			title="'.$value.'"
            height="' . $this->cellSize . '"
            width="' . $this->cellSize . '"
            style="
               '.$borderCode.'
                font-size: 7pt;
                text-align: center;
                font-family: Menlo, Monaco, Consolas, monospace;
                line-height: 0;
                margin: 0;
                padding: 0;
                background-color: ' . $color . '"
        ></td>';
		return $code;
	}
	
	private function wrapLine($content) {
		$code = '';
		$code .= '<tr>';
		$code .= $content;
		$code .= '</tr>';
		return $code;
	}
	
	private function wrapTable($content) {
		$borderCode = '';
		if($this->border) {
			$borderCode = '
				border-top: 1px solid black;
            border-right: 1px solid black;';
		}
		$code = '<table cellspacing="0" cellpadding="0" style="
			'.$borderCode.'
			padding: 0;
		">';
		$code .= $content;
		$code .= '</table>';
		return $code;
	}
}