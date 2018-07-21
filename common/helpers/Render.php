<?php

namespace common\helpers;

use common\widgets\grid\ExportMenu;
use common\widgets\grid\GridView;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\DataProviderInterface;
use yii\helpers\ArrayHelper;

class Render {
	/**
	 * 后台用的表格
	 * @param array $config
	 * @return string
	 */
	public static function gridView($config = []) {
		/** @var \yii\data\DataProviderInterface $dataProvider */
		$dataProvider = ArrayHelper::getValue($config, 'dataProvider');
		if (!$dataProvider instanceof DataProviderInterface) {
			throw new InvalidConfigException('The "dataProvider" param must implement DataProviderInterface.');
		}

		$filterModel = ArrayHelper::getValue($config, 'filterModel');
		if (!empty($filterModel) && !($filterModel instanceof Model)) {
			throw new InvalidConfigException('The "filterModel" param must be instance of yii\base\Model');
		}

		$columns = ArrayHelper::getValue($config, 'columns');
		if (!is_array($columns) || empty($columns)) {
			throw new InvalidConfigException('The "columns" param must be a not null array');
		}

		$gridDefaultConfig = [
			'layout' => "{toolbar}{summary}\n{items}\n{pager}",
			'emptyTextOptions' => [
				'class' => ['empty'],
				'style' => ['text-align' => 'center'],
			],
			'toolbar' => [],
			'pjax' => true,
			'pjaxSettings' => [
				'options' => [
					'id' => 'kartik-grid-pjax',
				],
			],
		];

		$gridConfig = ArrayHelper::merge($config, $gridDefaultConfig);

		// 导出
		$exportConfig = ArrayHelper::remove($config, 'export');
		if ($exportConfig) {
			$exportDefaultConfig = [
				'dataProvider' => $dataProvider,
				'columns' => $columns,
				'exportConfig' => [
					ExportMenu::FORMAT_HTML => false,
					ExportMenu::FORMAT_TEXT => false,
					ExportMenu::FORMAT_PDF => false,
					ExportMenu::FORMAT_EXCEL => false,
				],
				'pjaxContainerId' => 'kartik-grid-pjax',
			];
			if (is_array($exportConfig) && !empty($exportConfig)) {
				$exportConfig = ArrayHelper::merge($exportDefaultConfig, $exportConfig);
			} else {
				$exportConfig = $exportDefaultConfig;
			}
			$exportMenu = ExportMenu::widget($exportConfig);
			$gridConfig['toolbar'][] = $exportMenu;
		}

		return GridView::widget($gridConfig);
	}
}
