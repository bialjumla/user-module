<?php
namespace Modules\UserModule\Services;

use Modules\UserModule\Entities\CompanyCustomerSay;
use App\Traits\UploadTrait;

use function PHPUnit\Framework\isNull;

class CompanyCustomerSayService{

    use UploadTrait;

    public $customerName;
    public $customerSay;
    public $customerImage;

    public function createCompanyCustomerSay(){

            return CompanyCustomerSay::create(
            [
                'customer_name'        =>$this->customerName,
                'customer_say'         =>$this->customerSay,
                'customer_image'       =>$this->customerImage,

            ]
            );
    }

    public function updateCompanyCustomerSay(CompanyCustomerSay $CompanyCustomerSay)
    {
         $CompanyCustomerSay->update(
            [
                'customer_name'        =>$this->customerName,
                'customer_say'         =>$this->customerSay,
                'customer_image'       =>($this->customerImage??$CompanyCustomerSay->customer_image),
            ]
        );
        return CompanyCustomerSay::find($CompanyCustomerSay->id);

    }
     /**
     * @param mixed $customerName
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
        return $this;
    }


      /**
     * @param mixed $customerSay
     */
    public function setCustomerSay($customerSay)
    {
        $this->customerSay = $customerSay;
        return $this;
    }


    /**
     * @param mixed $customerImage
     */
    public function setCustomerImage($customerImage)
    {

        $this->customerImage = $this->storeImage($customerImage,'assets/images/company_customers_say');
        return $this;
    }
         /**
     * @param mixed $customerImage
     */
    public function updateCustomerImg($customerImage ,$old_image)
    {
        if(isNull($old_image)){
            $this->customerImage =$this->storeImage($customerImage,'assets/images/company_customers_say');
        }else
            $this->customerImage =$this->updateImage($customerImage,'assets/images/company_customers_say',$old_image);
    }

}