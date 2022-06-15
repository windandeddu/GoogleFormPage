<?php
namespace WindAndeddu\GoogleFormPage\Block\Adminhtml\System\Config\Field;

/**
 * Class GoogleFormPageConfig
 *
 * @package WindAndeddu\GoogleFormPage\Block\Adminhtml\Form\Field
 */
class GoogleFormPageConfig extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    protected $_arrayRowsCache;

    /**
     * @inheritdoc
     */
    protected function _prepareToRender()
    {
        $this->addColumn('page_url_key',
            [
                'label' => __('Url Key'),
                'class' => 'input-text no-whitespace required-entry',
            ]
        );
        $this->addColumn('iframe_height',
            [
                'label' => __('Form Frame Height'),
                'class' => 'input-text required-entry integer',
                'comment' => 'Enter only numbers',
            ]
        );
        $this->addColumn('iframe_url',
            [
                'label' => __('Form Url'),
                'class' => 'input-text validate-url required-entry',
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Item');
    }

    /**
     * @inheritdoc
     */
    public function getArrayRows()
    {
        if (null !== $this->_arrayRowsCache) {
            return $this->_arrayRowsCache;
        }
        $result = [];
        /** @var \Magento\Framework\Data\Form\Element\AbstractElement */
        $element = $this->getElement();
        if ($element->getValue() && is_array($element->getValue())) {
            foreach ($element->getValue() as $rowId => $row) {
                $rowColumnValues = [];
                if ($row) {
                    foreach ($row as $key => $value) {
                        $row[$key] = $value;
                        $rowColumnValues[$this->_getCellInputElementId($rowId, $key)] = $row[$key];
                    }
                    $row['_id'] = $rowId;
                    $row['column_values'] = $rowColumnValues;
                    $result[$rowId] = new \Magento\Framework\DataObject($row);

                    $this->_prepareArrayRow($result[$rowId]);
                }
            }
        }
        $this->_arrayRowsCache = $result;

        return $this->_arrayRowsCache;
    }
}
