<?php

namespace hubeiwei\yii2tools\helpers;

use hubeiwei\yii2tools\grid\ExportMenu;
use hubeiwei\yii2tools\grid\GridView;
use liyunfang\pager\LinkPager;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class RenderHelper
{
    /**
     * GridView 枚举类字段搜索用到下拉框
     * 使用 DynaGrid 的默认过滤功能时不会选中，建议使用 Select2
     * @see \hubeiwei\yii2tools\widgets\Select2
     *
     * @param Model $model
     * @param string $attribute
     * @param array $map
     * @param array $options
     * @return string
     */
    public static function dropDownFilter(Model $model, $attribute, $map, $options = [])
    {
        $options = ArrayHelper::merge(
            [
                'class' => ['form-control'],
                'style' => ['min-width' => '120px'],
            ],
            $options
        );
        return Html::dropDownList(
            $model->formName() . '[' . $attribute . ']',
            $model->{$attribute},
            ['' => '全部'] + $map,
            $options
        );
    }

    /**
     * 根据业务来封装的 GridView
     *
     * @param $dataProvider \yii\data\ActiveDataProvider|\yii\data\ArrayDataProvider|\yii\data\SqlDataProvider
     * @param $gridColumns array
     * @param $searchModel \yii\base\Model
     * @param $hasExport bool
     * @param $showPageSummary bool
     * @return string
     */
    public static function gridView($dataProvider, $gridColumns, $searchModel = null, $hasExport = false, $showPageSummary = false)
    {
        $config = [
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
        ];

        $gridConfig = ArrayHelper::merge($config, [
            'condensed' => true,
            'layout' => '<p>{toolbar}</p>{summary}{items}{pager}',
            'headerRowOptions' => [
                'class' => ['grid-thead'],
            ],
            'tableOptions' => [
                'style' => ['margin-bottom' => '0'],
            ],
            'containerOptions' => [
                'style' => ['margin-bottom' => '20px'],
            ],
            'pjax' => true,
            'pjaxSettings' => [
                'options' => [
                    'id' => 'kartik-grid-pjax',
                ],
            ],
            'showPageSummary' => $showPageSummary,
            'toolbar' => [],
            'filterSelector' => 'select[name="' . $dataProvider->getPagination()->pageSizeParam . '"], input[name="' . $dataProvider->getPagination()->pageParam . '"]',
            'pager' => [
                'class' => LinkPager::className(),
                'firstPageLabel' => '首页',
                'lastPageLabel' => '尾页',
                'options' => [
                    'class' => ['pagination', 'pagination-sm'],
                    'style' => ['margin-top' => '0', 'margin-bottom' => '-4px'],
                ],
                'pageSizeList' => [10, 15, 20, 30, 50],
                'pageSizeOptions' => [
                    'class' => ['form-control', 'input-sm'],
                    'style' => ['width' => '80px'],
                ],
                'customPageOptions' => [
                    'class' => ['form-control', 'input-sm'],
                    'style' => ['width' => '50px'],
                ],
                'template' => '
<div class="form-inline">
    <div class="form-group">{pageButtons}</div>
    <div class="form-group">
        <label>跳转到：</label>
        {customPage}
    </div>
    <div class="form-group">
        <label>每页：</label>
        {pageSize}
    </div>
</div>
',
                'pageSizeMargin' => null,
                'customPageWidth' => '0',
                'customPageMargin' => null,
            ],
        ]);
        if ($searchModel !== null) {
            $gridConfig['filterModel'] = $searchModel;
        }
        if ($hasExport) {
            $export = ExportMenu::widget(ArrayHelper::merge($config, [
                'exportConfig' => [
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_EXCEL => false,
                ],
                'pjaxContainerId' => 'kartik-grid-pjax',
            ]));
            $gridConfig['toolbar'][] = $export;
        }

        return GridView::widget($gridConfig);
    }
}
