<?php

namespace Bread\BreadCheckout\Block\Product;

/**
 * Class Category
 *
 * @package Bread\BreadCheckout\Block\Product
 */
class Category extends \Magento\Framework\View\Element\Template
{

    protected $_template = 'Bread_BreadCheckout::breadcheckout/list_product.phtml';
    /**
     * @var \Bread\BreadCheckout\Helper\Category
     */
    private $categoryHelper;
    /**
     * @var \Bread\BreadCheckout\Helper\Customer
     */
    private $customerHelper;
    /**
     * @var \Bread\BreadCheckout\Helper\Catalog
     */
    private $catalogHelper;
    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    private $jsonHelper;
    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    private $moduleList;

    /**
     * Category constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Bread\BreadCheckout\Helper\Category             $categoryHelper
     * @param \Bread\BreadCheckout\Helper\Customer             $customerHelper
     * @param \Bread\BreadCheckout\Helper\Catalog              $catalogHelper
     * @param \Magento\Framework\Module\ModuleListInterface    $moduleList
     * @param \Magento\Framework\Json\Helper\Data              $jsonHelper
     * @param array                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Bread\BreadCheckout\Helper\Category $categoryHelper,
        \Bread\BreadCheckout\Helper\Customer $customerHelper,
        \Bread\BreadCheckout\Helper\Catalog $catalogHelper,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->categoryHelper = $categoryHelper;
        $this->customerHelper = $customerHelper;
        $this->catalogHelper  = $catalogHelper;
        $this->jsonHelper     = $jsonHelper;
        $this->moduleList     = $moduleList;
    }

    /**
     * @return mixed
     */
    public function useDefaultButtonSizeCategory()
    {
        if ($this->categoryHelper->useDefaultButtonSizeCategory()) {
            return 'data-bread-default-size="true"';
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getShippingAddressData()
    {
        return $this->customerHelper->getShippingAddressData();
    }

    /**
     * @return string
     */
    public function getBillingAddressData()
    {
        return $this->customerHelper->getBillingAddressData();
    }

    /**
     * @return mixed
     */
    public function isLabelOnlyOnCategories()
    {
        return $this->categoryHelper->isLabelOnlyOnCategories() ? 'true' : 'false';
    }

    /**
     * @return mixed
     */
    public function getCATButtonDesign()
    {
        $design = $this->categoryHelper->getCATButtonDesign();
        if (!$design) {
            $design = $this->catalogHelper->getPDPButtonDesign();
        }
        return $this->categoryHelper->escapeCustomCSS($design);
    }

    /**
     * @return string
     */
    public function isAsLowAsCAT()
    {
        return (string)$this->categoryHelper->isAsLowAsCAT() ? 'true' : 'false';
    }

    /**
     * @return mixed
     */
    public function getShowInWindowCAT()
    {
        return $this->categoryHelper->getShowInWindowCAT() ? 'true' : 'false';
    }

    /**
     * @return bool
     */
    public function isHealthcare()
    {
        return $this->categoryHelper->isHealthcare();
    }

    /**
     * Get button location string for category page
     *
     * @return string
     */
    public function getCategoryPageLocation()
    {
        return $this->categoryHelper->getCategoryPageLocation();
    }

    /**
     * @return string
     */
    public function getValidateOrderURL()
    {
        return $this->categoryHelper->getValidateOrderURL();
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     *
     * @return array
     */
    public function getProductDataArray($product)
    {
        return $this->catalogHelper->getProductDataArray($product, null);
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     *
     * @return bool|string
     */
    public function getProductDataJson($product)
    {
        $product->unsetData("final_price");
        return $this->jsonHelper->jsonEncode($this->getProductDataArray($product));
    }

    /**
     * @return string
     */
    public function getModuleVersion()
    {
        $module = $this->moduleList->getOne($this->getModuleName());
        return isset($module["setup_version"]) ? $module["setup_version"] : "";
    }
}