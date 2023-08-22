<?php

class Finance_Model_InvoiceStatement extends Zend_Db_Table_Abstract {

    /**
     * Set Primary Key Id as a Parameter
     *
     * @param string $cp_id
     * @return single dimention array
     */   
	
	public function getAccountStatement()
	{
	
		$select ="SELECT sales_invoice.sales_invoice_id, DATE_FORMAT(sales_invoice.invoice_date,'%Y-%m-%d') as date, sales_invoice.grand_total AS `paid_amount`, `customer`.`dealer_company_name` as vendor_name, `sales_invoice`.`receipt_status` as payment_status, (CASE WHEN `sales_invoice`.`receipt_status` = '4' THEN 'SI' END) as payment_type, sales_invoice.invoice_increment_id, sales_invoice.name_of_transport, sales_invoice.no_of_packages, sales_invoice.despatched_through, sales_invoice.private_mark, receipt.payment_by FROM `erp_sales_invoice` AS `sales_invoice` LEFT JOIN `erp_sales_invoice_items` AS `sales_items` ON sales_items.sales_invoice_id = sales_invoice.sales_invoice_id LEFT JOIN `erp_dealer_master` AS `customer` ON customer.dealer_id=sales_invoice.dealer_id LEFT JOIN `finance_receipt_voucher` AS `receipt` ON receipt.invoice_id=sales_invoice.sales_invoice_id and receipt.payment_by = '1' WHERE sales_invoice.invoice_status !=2 GROUP BY sales_items.sales_invoice_id		
		UNION 		
		SELECT invoice.purchase_invoice_id, DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date, invoice.grand_total_amount AS `paid_amount`, `vendor`.`vendor_name`, `invoice`.`payment_status`, (CASE WHEN `invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, (invoice.purchase_invoice_id) as invoice_increment_id, null, null, null, null, payment.payment_by FROM `erp_purchase_invoice` AS `invoice` LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id LEFT JOIN `finance_payment_vouvher` AS `payment` ON payment.invoice_id=invoice.purchase_invoice_id and payment.payment_by = '1' WHERE purchase_invoice_status !=2 GROUP BY invoice.purchase_invoice_id
		UNION
		SELECT finance_payment_vouvher.`payment_voucher_id`, DATE_FORMAT(finance_payment_vouvher.add_date,'%Y-%m-%d') as date, paid_amount, party_names as vendor_name, payment_status, (CASE WHEN payment_status = '4' THEN 'PV' END) as payment_type, remarks as invoice_increment_id, null, null, null, null, null FROM `finance_payment_vouvher` left join erp_vendor_master on erp_vendor_master.vendor_id=finance_payment_vouvher.vendor_id WHERE `status` !='2' and payment_by !='1'
		
		UNION 
		
		SELECT finance_receipt_voucher.`receipt_voucher_id`, DATE_FORMAT(finance_receipt_voucher.add_date,'%Y-%m-%d') as date, `paid_amount`,  party_names as vendor_name, `receipt_status` as payment_status, (CASE WHEN receipt_status = '5' THEN 'RV' END) as payment_type, remarks as invoice_increment_id, null, null, null, null, null FROM `finance_receipt_voucher` left join erp_dealer_master on erp_dealer_master.dealer_id=finance_receipt_voucher.dealer_id WHERE `status` !='2' and payment_by !='1'
		
		UNION

		SELECT `id`, DATE_FORMAT(date,'%Y-%m-%d') as date, `credit_amount` as paid_amount, `dealer_id` as vendor_name, (`payment_type`) as payment_status, payment_type, remarks as invoice_increment_id, null, null, null, null, null FROM `journal_voucher` WHERE status !=2 and payment_type = '5'

		UNION

		SELECT `id`, DATE_FORMAT(date,'%Y-%m-%d') as date, `debit_amount` as paid_amount, `vendor_id` as vendor_name, (CASE WHEN `payment_type` = '5' THEN '4' END) as payment_status, payment_type, remark1 as invoice_increment_id, null, null, null, null, null FROM `journal_voucher` WHERE status !=2 and payment_type = '5'
		
		UNION
		
		SELECT invoice.`commercial_invoice_id`, DATE_FORMAT(invoice.invoice_due_date,'%Y-%m-%d') as date, invoice.amount_inr as paid_amount, erp_vendor_master.vendor_name, invoice.payment_status, (CASE WHEN invoice.payment_status = '5' THEN 'PCI' END) as payment_type, invoice.commercial_invoice_id as invoice_increment_id, null, null, null, null, payment.payment_by FROM `erp_purchase_commercial_invoice` as invoice left join erp_vendor_master on erp_vendor_master.vendor_id=invoice.vendor_id LEFT JOIN `finance_payment_vouvher` AS `payment` ON payment.commercial_invoice_id=invoice.commercial_invoice_id and payment.payment_by = '1' WHERE `commercial_invoice_status` !='2' group by invoice.commercial_invoice_id		
		UNION		
		SELECT erp_sales_waybill.`waybill_id`, DATE_FORMAT(erp_sales_waybill.waybill_date,'%Y-%m-%d') as date, erp_sales_waybill.total_amount as paid_amount, erp_dealer_master.custom_name as vendor_name, erp_sales_waybill.`receipt_status` as payment_status, (CASE WHEN erp_sales_waybill.receipt_status = '4' THEN 'WB' END) as payment_type, null, null, null, null, null, receipt.payment_by 
		FROM `erp_sales_waybill` 
		left join erp_dealer_master on erp_dealer_master.dealer_id=erp_sales_waybill.sales_dealer_id 
		LEFT JOIN `finance_receipt_voucher` AS `receipt` ON receipt.waybill_id=erp_sales_waybill.waybill_id and receipt.payment_by = '1' 
		WHERE `waybill_status` !='2'  group by erp_sales_waybill.waybill_id
		
		ORDER BY date";
		//echo $select; die;		
		$result = $this->getAdapter()
                ->fetchAll($select);
        return $result;	
	} 
	   // echo $query = $user->select()->where('firstname LIKE ?', $uname.'%')->ORwhere('lastname LIKE ?', $_POST['lname'].'%')->ORwhere('emailid LIKE ?', $_POST['email'].'%');

	public function getAccountStatementByDates($data)
	{
		//print_r($data);die;
		/* if( !empty( $data['type'] ) && ($data['type'] == 5) )
		{
			$where = '';			
			if(!empty( $data['vendor_id'] )){
				$where .= ' and vendor_id ='.$data['vendor_id'];
			}
			if(!empty( $data['start_date'] )){
				$where .= " and add_date between '.".$data['start_date']."' and ADDDATE('".$data['end_date']."',INTERVAL 1 DAY)";
			}
			
			//$select ="SELECT *, DATE_FORMAT(add_date,'%Y-%m-%d') as date, erp_vendor_master.vendor_name FROM `finance_payment_vouvher` left join erp_vendor_master on erp_vendor_master.vendor_id=finance_payment_vouvher.vendor_id where status !='2' ".$where." ORDER BY add_date";
			
		}else*/
		if( !empty($data['party_id']) ){
		
			$where = '';
			$where1 = '';
			$where2 = '';
			$where3 = '';
			$where4 = '';
			$where5 = '';
			$where6 = '';
			$where7 = '';
			$where8 = '';
			/* if(!empty( $data['type'] )){
				$where .= " and receipt_status ='".$data['type']."'";
				$where1 .= " and payment_status ='".$data['type']."'";
			} */

			if(!empty( $data['party_id'] )){
				$where .= " and customer.dealer_id ='".$data['search_id']."' and cus_search_type='".$data['search_type']."'";
				$where1 .= " and vendor.vendor_id ='".$data['search_id']."' and vendor_search_type='".$data['search_type']."'";
				$where2 .= " and finance_receipt_voucher.dealer_id ='".$data['search_id']."' and party_type ='".$data['search_type']."'";
				$where3 .= " and finance_payment_vouvher.vendor_id ='".$data['search_id']."' and party_type ='".$data['search_type']."'";
				$where4 .= " and credit_party_id ='".$data['search_id']."' and credit_party_type ='".$data['search_type']."'";
				$where5 .= " and debit_party_id ='".$data['search_id']."' and debit_party_type ='".$data['search_type']."'";
				$where6 .= " and erp_vendor_master.vendor_id ='".$data['search_id']."' and vendor_search_type='".$data['search_type']."'";
				$where7 .= " and erp_dealer_master.dealer_id ='".$data['search_id']."' and cus_search_type='".$data['search_type']."'";
				$where8 .= " and account.account_id ='".$data['search_id']."' and account_search_type='".$data['search_type']."'";	
			}
			if(!empty( $data['start_date'] )){
				$where .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";
				$where1 .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";
				$where2 .= " and add_date >='".$data['start_date']."' and add_date <='".$data['end_date']."'";
				$where3 .= " and add_date >='".$data['start_date']."' and add_date <='".$data['end_date']."'";
				$where4 .= " and date >='".$data['start_date']."' and date <='".$data['end_date']."'";
				$where5 .= " and date >='".$data['start_date']."' and date <='".$data['end_date']."'";
				$where6 .= " and invoice_due_date >='".$data['start_date']."' and invoice_due_date <='".$data['end_date']."'";
				$where7 .= " and waybill_date >='".$data['start_date']."' and waybill_date <='".$data['end_date']."'";
				$where8 .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";
			}
			//echo $where2; die;
			$select ="SELECT sales_invoice.sales_invoice_id, DATE_FORMAT(sales_invoice.invoice_date,'%Y-%m-%d') as date, sales_invoice.grand_total AS `paid_amount`, `customer`.`dealer_company_name` as vendor_name, `sales_invoice`.`receipt_status` as payment_status, (CASE WHEN `sales_invoice`.`receipt_status` = '4' THEN 'SI' END) as payment_type, sales_invoice.invoice_increment_id FROM `erp_sales_invoice` AS `sales_invoice` LEFT JOIN `erp_sales_invoice_items` AS `sales_items` ON sales_items.sales_invoice_id = sales_invoice.sales_invoice_id 
			LEFT JOIN `erp_dealer_master` AS `customer` ON customer.dealer_id=sales_invoice.dealer_id 
			LEFT JOIN `finance_receipt_voucher` AS `receipt` ON receipt.invoice_id=sales_invoice.sales_invoice_id and receipt.payment_by = '1' WHERE sales_invoice.invoice_status !=2 and cash_status != '1'  ".$where." GROUP BY sales_items.sales_invoice_id		
			UNION 		
			SELECT invoice.purchase_invoice_id, DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date, invoice.grand_total_amount AS `paid_amount`, `vendor`.`vendor_name`,  invoice.payment_status as payment_status, (CASE WHEN `invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, (invoice.purchase_invoice_id) as invoice_increment_id FROM `erp_purchase_invoice` AS `invoice`
			LEFT JOIN `erp_purchse_invoice_items` AS `purchase_items` ON purchase_items.purchase_invoice_no = invoice.purchase_invoice_id
			LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id 
			LEFT JOIN `finance_payment_vouvher` AS `payment` ON payment.invoice_id=invoice.purchase_invoice_id and payment.payment_by = '1' 			
			WHERE purchase_invoice_status !=2 and cash_status != '1' ".$where1." GROUP BY invoice.purchase_invoice_id
			UNION 
			SELECT invoice.purchase_invoice_id, DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date, (purchase_items.purchase_invoice_item_price * purchase_items.purchase_invoice_item_approved_quantity) AS `paid_amount`, `vendor`.`vendor_name`, (CASE WHEN purchase_items.account_id != '' THEN '4' END) as payment_status, (CASE WHEN `invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, (invoice.purchase_invoice_id) as invoice_increment_id FROM `erp_purchase_invoice` AS `invoice` 
			LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id 
			LEFT JOIN `finance_payment_vouvher` AS `payment` ON payment.invoice_id=invoice.purchase_invoice_id and payment.payment_by = '1' 
			LEFT JOIN `erp_purchse_invoice_items` AS `purchase_items` ON purchase_items.purchase_invoice_no = invoice.purchase_invoice_id
			LEFT JOIN `account_master` AS `account` ON account.account_id=purchase_items.account_id 
			WHERE purchase_invoice_status !=2 and purchase_items.account_id !='' and cash_status != '1'  ".$where8." GROUP BY invoice.purchase_invoice_id
			
			UNION
			SELECT finance_payment_vouvher.`payment_voucher_id`, DATE_FORMAT(finance_payment_vouvher.add_date,'%Y-%m-%d') as date, paid_amount, party_names as vendor_name, (CASE WHEN account_master.vat_status = '1' THEN '5' ELSE finance_payment_vouvher.payment_status END) as payment_status, (CASE WHEN payment_status = '4' THEN 'PV' END) as payment_type,  remarks as invoice_increment_id FROM `finance_payment_vouvher` left join erp_vendor_master on erp_vendor_master.vendor_id=finance_payment_vouvher.vendor_id left join account_master on account_master.account_id=finance_payment_vouvher.vendor_id and party_type='A' WHERE finance_payment_vouvher.status !='2' ".$where3."
			
			UNION 
			
			SELECT finance_receipt_voucher.`receipt_voucher_id`, DATE_FORMAT(finance_receipt_voucher.add_date,'%Y-%m-%d') as date, `paid_amount`,  party_names as vendor_name, (CASE WHEN account_master.vat_status = '1' THEN '4' ELSE finance_receipt_voucher.receipt_status END) as payment_status, (CASE WHEN receipt_status = '5' THEN 'RV' END) as payment_type, remarks as invoice_increment_id FROM `finance_receipt_voucher` left join erp_dealer_master on erp_dealer_master.dealer_id=finance_receipt_voucher.dealer_id left join account_master on account_master.account_id=finance_receipt_voucher.dealer_id and party_type='A' WHERE finance_receipt_voucher.status !='2' ".$where2." 
			
			UNION

			SELECT `id`, DATE_FORMAT(date,'%Y-%m-%d') as date, `credit_amount` as paid_amount, `dealer_id` as vendor_name, (`payment_type`) as payment_status, payment_type, remarks as invoice_increment_id FROM `journal_voucher` WHERE status !=2 and payment_type = '5' ".$where4."

			UNION

			SELECT `id`, DATE_FORMAT(date,'%Y-%m-%d') as date, `debit_amount` as paid_amount, `vendor_id` as vendor_name, (CASE WHEN `payment_type` = '5' THEN '4' END) as payment_status, payment_type, remark1 as invoice_increment_id FROM `journal_voucher` WHERE status !=2 and payment_type = '5' ".$where5."
			
			UNION
		
			SELECT invoice.`commercial_invoice_id`, DATE_FORMAT(invoice.invoice_due_date,'%Y-%m-%d') as date, invoice.amount_inr as paid_amount,  erp_vendor_master.vendor_name, invoice.payment_status, (CASE WHEN invoice.payment_status = '5' THEN 'PCI' END) as payment_type, invoice.commercial_invoice_id as invoice_increment_id FROM `erp_purchase_commercial_invoice` as invoice left join erp_vendor_master on erp_vendor_master.vendor_id=invoice.vendor_id LEFT JOIN `finance_payment_vouvher` AS `payment` ON payment.commercial_invoice_id=invoice.commercial_invoice_id and payment.payment_by = '1' WHERE `commercial_invoice_status` !='2' ".$where6." group by invoice.commercial_invoice_id
			UNION		
			SELECT erp_sales_waybill.`waybill_id`, DATE_FORMAT(erp_sales_waybill.waybill_date,'%Y-%m-%d') as date, erp_sales_waybill.total_amount as paid_amount, erp_dealer_master.custom_name as vendor_name, erp_sales_waybill.`receipt_status` as payment_status, (CASE WHEN erp_sales_waybill.receipt_status = '4' THEN 'WB' END) as payment_type, null FROM `erp_sales_waybill` left join erp_dealer_master on erp_dealer_master.dealer_id=erp_sales_waybill.sales_dealer_id 
			LEFT JOIN `finance_receipt_voucher` AS `receipt` ON receipt.waybill_id=erp_sales_waybill.waybill_id and receipt.payment_by = '1' WHERE `waybill_status` !='2' ".$where7." group by erp_sales_waybill.waybill_id
						
			ORDER BY date";
			
			/* $select ="
			SELECT DATE_FORMAT(sales_invoice.invoice_date,'%Y-%m-%d') as date, sum(sales_items.total_price) AS `paid_amount`, (CASE WHEN sales_invoice.operator1 = '1' THEN sum(sales_invoice.price1) WHEN sales_invoice.operator2 = '1' THEN sum(sales_invoice.price2) WHEN sales_invoice.operator3 = '1' THEN sum(sales_invoice.price3) END) AS `add_amount`, (CASE WHEN sales_invoice.operator1 = '2' THEN sum(sales_invoice.price1) WHEN sales_invoice.operator2 = '2' THEN sum(sales_invoice.price2) WHEN sales_invoice.operator3 = '2' THEN sum(sales_invoice.price3) END) AS `sub_amount`, `customer`.`dealer_id`, `customer`.`dealer_name` as vendor_name, `sales_invoice`.`receipt_status` as payment_status FROM `erp_sales_invoice` AS `sales_invoice` LEFT JOIN `erp_sales_invoice_items` AS `sales_items` ON sales_items.sales_invoice_id = sales_invoice.sales_invoice_id LEFT JOIN `erp_dealer_master` AS `customer` ON customer.dealer_id=sales_invoice.dealer_id WHERE sales_invoice.invoice_status !=2 ".$where." GROUP BY sales_items.sales_invoice_id
		
			UNION 
			
			SELECT DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date, sum(purchase_invoice_item_price * purchase_invoice_item_approved_quantity ) AS `paid_amount`, (CASE WHEN invoice.operator1 = '1' THEN sum(invoice.price) END) AS `add_amount`, (CASE WHEN invoice.operator1 = '2' THEN sum(invoice.price) END) AS `sub_amount`, `vendor`.`vendor_id`, `vendor`.`vendor_name`, `invoice`.`payment_status` FROM `erp_purchase_invoice` AS `invoice` LEFT JOIN `erp_purchse_invoice_items` AS `purchase_items` ON purchase_items.purchase_invoice_no = invoice.purchase_invoice_id LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id WHERE purchase_invoice_status !=2 ".$where1." GROUP BY purchase_items.purchase_invoice_no ORDER BY date"; */
									
		}else{
			
			$select ="SELECT sales_invoice.sales_invoice_id, DATE_FORMAT(sales_invoice.invoice_date,'%Y-%m-%d') as date, sales_invoice.grand_total AS `paid_amount`, `customer`.`dealer_company_name` as vendor_name, `sales_invoice`.`receipt_status` as payment_status, (CASE WHEN `sales_invoice`.`receipt_status` = '4' THEN 'SI' END) as payment_type, sales_invoice.invoice_increment_id, sales_invoice.name_of_transport, sales_invoice.no_of_packages, sales_invoice.despatched_through, sales_invoice.private_mark FROM `erp_sales_invoice` AS `sales_invoice` LEFT JOIN `erp_sales_invoice_items` AS `sales_items` ON sales_items.sales_invoice_id = sales_invoice.sales_invoice_id LEFT JOIN `erp_dealer_master` AS `customer` ON customer.dealer_id=sales_invoice.dealer_id WHERE sales_invoice.invoice_status !='2' and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."' and cash_status != 1 GROUP BY sales_items.sales_invoice_id		
			UNION 		
			SELECT invoice.purchase_invoice_id, DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date, invoice.grand_total_amount AS `paid_amount`, `vendor`.`vendor_name`, `invoice`.`payment_status`, (CASE WHEN `invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, (invoice.purchase_invoice_id) as invoice_increment_id, null, null, null, null FROM `erp_purchase_invoice` AS `invoice` LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id WHERE purchase_invoice_status !='2' and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'  and cash_status != 1 GROUP BY invoice.purchase_invoice_id
			UNION
			SELECT finance_payment_vouvher.`payment_voucher_id`, DATE_FORMAT(finance_payment_vouvher.add_date,'%Y-%m-%d') as date, paid_amount, party_names as vendor_name, payment_status, (CASE WHEN payment_status = '4' THEN 'PV' END) as payment_type, remarks as invoice_increment_id, null, null, null, null FROM `finance_payment_vouvher` left join erp_vendor_master on erp_vendor_master.vendor_id=finance_payment_vouvher.vendor_id WHERE `status` !='2' and payment_by !='1' and add_date >='".$data['start_date']."' and add_date <='".$data['end_date']."'
			
			UNION 
			
			SELECT finance_receipt_voucher.`receipt_voucher_id`, DATE_FORMAT(finance_receipt_voucher.add_date,'%Y-%m-%d') as date, `paid_amount`, party_names as vendor_name, `receipt_status` as payment_status, (CASE WHEN receipt_status = '5' THEN 'RV' END) as payment_type, remarks as invoice_increment_id, null, null, null, null FROM `finance_receipt_voucher` left join erp_dealer_master on erp_dealer_master.dealer_id=finance_receipt_voucher.dealer_id WHERE `status` !='2' and payment_by !='1' and add_date >='".$data['start_date']."' and add_date <='".$data['end_date']."' 
			
			UNION

			SELECT `id`, DATE_FORMAT(date,'%Y-%m-%d') as date, `credit_amount` as paid_amount, `dealer_id` as vendor_name, (`payment_type`) as payment_status, payment_type, remarks as invoice_increment_id, null, null, null, null FROM `journal_voucher` WHERE status !=2 and payment_type = '5' and date >='".$data['start_date']."' and date <='".$data['end_date']."'

			UNION

			SELECT `id`, DATE_FORMAT(date,'%Y-%m-%d') as date, `debit_amount` as paid_amount, `vendor_id` as vendor_name, (CASE WHEN `payment_type` = '5' THEN '4' END) as payment_status, payment_type, remark1 as invoice_increment_id, null, null, null, null FROM `journal_voucher` WHERE status !=2 and payment_type = '5' and date >='".$data['start_date']."' and date <='".$data['end_date']."'
			
			UNION
		
			SELECT invoice.`commercial_invoice_id`, DATE_FORMAT(invoice.invoice_due_date,'%Y-%m-%d') as date, invoice.amount_inr as paid_amount, erp_vendor_master.vendor_name, payment_status, (CASE WHEN payment_status = '5' THEN 'PCI' END) as payment_type, invoice.commercial_invoice_id as invoice_increment_id, null, null, null, null FROM `erp_purchase_commercial_invoice` as invoice left join erp_vendor_master on erp_vendor_master.vendor_id=invoice.vendor_id WHERE `commercial_invoice_status` !='2' and invoice_due_date >='".$data['start_date']."' and invoice_due_date <='".$data['end_date']."'
			UNION		
			SELECT erp_sales_waybill.`waybill_id`, DATE_FORMAT(erp_sales_waybill.waybill_date,'%Y-%m-%d') as date, erp_sales_waybill.total_amount as paid_amount, erp_dealer_master.custom_name as vendor_name, `receipt_status` as payment_status, (CASE WHEN receipt_status = '4' THEN 'WB' END) as payment_type, null, null, null, null, null FROM `erp_sales_waybill` left join erp_dealer_master on erp_dealer_master.dealer_id=erp_sales_waybill.sales_dealer_id WHERE `waybill_status` !='2' and waybill_date >='".$data['start_date']."' and waybill_date <='".$data['end_date']."'			
			ORDER BY date";
			
		}		
		//echo $select; die;
		$result = $this->getAdapter()
                ->fetchAll($select);
        return $result;	
	}
	
	// Customer Accounts Transaction
	public function getAccountStatementByDatesForCustomerAccount($data)
	{
		if( !empty($data['party_id']) ){		
			
			$where = '';
			$where1 = '';
			if(!empty( $data['party_id'] )){				
				$where .= " and customer.dealer_id ='".$data['search_id']."' and cus_search_type='".$data['search_type']."'";
				$where1 .= " and erp_dealer_master.dealer_id ='".$data['search_id']."' and cus_search_type='".$data['search_type']."'";
			}
			if(!empty( $data['start_date'] )){				
				$where .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";
				$where1 .= " and waybill_date >='".$data['start_date']."' and waybill_date <='".$data['end_date']."'";	
			}
			
			$select ="SELECT sales_invoice.sales_invoice_id, DATE_FORMAT(sales_invoice.invoice_date,'%Y-%m-%d') as date, sales_invoice.grand_total AS `paid_amount`, `customer`.`dealer_company_name` as vendor_name, `sales_invoice`.`receipt_status` as payment_status, (CASE WHEN `sales_invoice`.`receipt_status` = '4' THEN 'SI' END) as payment_type, sales_invoice.invoice_increment_id, ( IF(sales_invoice.operator1 = '1', sales_invoice.price1, 0) + IF(sales_invoice.operator2 = '1', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '1', sales_invoice.price3, 0) ) AS add_amount, ( IF(sales_invoice.operator1 = '2', sales_invoice.price1, 0) + IF(sales_invoice.operator2 = '2', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '2', sales_invoice.price3, 0) ) AS sub_amount, sum(sales_items.total_price - discount) AS invoice_amount FROM `erp_sales_invoice` AS `sales_invoice` LEFT JOIN `erp_sales_invoice_items` AS `sales_items` ON sales_items.sales_invoice_id = sales_invoice.sales_invoice_id LEFT JOIN `erp_dealer_master` AS `customer` ON customer.dealer_id=sales_invoice.dealer_id WHERE sales_invoice.invoice_status !='2' and cash_status != 1 ".$where." GROUP BY sales_items.sales_invoice_id	
			UNION		
			SELECT erp_sales_waybill.`waybill_id`, DATE_FORMAT(erp_sales_waybill.waybill_date,'%Y-%m-%d') as date, erp_sales_waybill.total_amount as paid_amount, erp_dealer_master.custom_name as vendor_name, `receipt_status` as payment_status, (CASE WHEN receipt_status = '4' THEN 'WB' END) as payment_type, erp_sales_waybill.waybill_id as invoice_increment_id, null, null, erp_sales_waybill.total_amount as invoice_amount FROM `erp_sales_waybill` left join erp_dealer_master on erp_dealer_master.dealer_id=erp_sales_waybill.sales_dealer_id WHERE `waybill_status` !='2' ".$where1."			
			ORDER BY date";
		}else{
			$select ="SELECT sales_invoice.sales_invoice_id, DATE_FORMAT(sales_invoice.invoice_date,'%Y-%m-%d') as date, sum(sales_invoice.grand_total) AS `paid_amount`, `customer`.`dealer_company_name` as vendor_name, `sales_invoice`.`receipt_status` as payment_status, (CASE WHEN `sales_invoice`.`receipt_status` = '4' THEN 'SI' END) as payment_type, sales_invoice.invoice_increment_id, sum( IF(sales_invoice.operator1 = '1', sales_invoice.price1, 0) + IF(sales_invoice.operator2 = '1', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '1', sales_invoice.price3, 0) ) AS add_amount, sum( IF(sales_invoice.operator1 = '2', sales_invoice.price1, 0) + IF(sales_invoice.operator2 = '2', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '2', sales_invoice.price3, 0) ) AS sub_amount, (SELECT sum(sales_items.total_price - sales_items.discount) FROM erp_sales_invoice_items AS `sales_items` WHERE sales_items.sales_invoice_id = sales_invoice.sales_invoice_id) AS invoice_amount FROM `erp_sales_invoice` AS `sales_invoice` LEFT JOIN `erp_dealer_master` AS `customer` ON customer.dealer_id=sales_invoice.dealer_id WHERE sales_invoice.invoice_status !='2' and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."' and cash_status != 1 GROUP BY sales_invoice.dealer_id	
			UNION		
			SELECT erp_sales_waybill.`waybill_id`, DATE_FORMAT(erp_sales_waybill.waybill_date,'%Y-%m-%d') as date, erp_sales_waybill.total_amount as paid_amount, erp_dealer_master.custom_name as vendor_name, `receipt_status` as payment_status, (CASE WHEN receipt_status = '4' THEN 'WB' END) as payment_type, erp_sales_waybill.waybill_id as invoice_increment_id, null, null, erp_sales_waybill.total_amount as invoice_amount FROM `erp_sales_waybill` left join erp_dealer_master on erp_dealer_master.dealer_id=erp_sales_waybill.sales_dealer_id WHERE `waybill_status` !='2' and waybill_date >='".$data['start_date']."' and waybill_date <='".$data['end_date']."' GROUP BY erp_sales_waybill.sales_dealer_id 			
			ORDER BY date";
		}
			
		$result = $this->getAdapter()
				->fetchAll($select);
		return $result;
	}
	
	//Vendors Accounts Transaction
	public function getAccountStatementByDatesForVendorAccount($data)
	{
			if( !empty($data['party_id']) ){		
				
				$where1 = '';			
				$where2 = '';				
				if(!empty( $data['party_id'] )){				
					$where1 .= " and vendor.vendor_id ='".$data['search_id']."' and vendor_search_type='".$data['search_type']."'";
					$where2 .= " and erp_vendor_master.vendor_id ='".$data['search_id']."' and vendor_search_type='".$data['search_type']."'";
				}
				if(!empty( $data['start_date'] )){				
					$where1 .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";				
					$where2 .= " and invoice_due_date >='".$data['start_date']."' and invoice_due_date <='".$data['end_date']."'";
				}
				
				$select ="SELECT invoice.purchase_invoice_id as sales_invoice_id, DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date, invoice.grand_total_amount AS `paid_amount`, `vendor`.`vendor_name`, `invoice`.`payment_status`, (CASE WHEN `invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, (invoice.purchase_invoice_id) as invoice_increment_id, ( IF(invoice.operator1 = '1', invoice.price, 0) ) AS add_amount, ( IF(invoice.operator1 = '2', invoice.price, 0) ) AS sub_amount, sum(purchase_invoice_item_price * purchase_invoice_item_approved_quantity ) as invoice_amount FROM `erp_purchase_invoice` AS `invoice` LEFT JOIN `erp_purchse_invoice_items` AS `purchase_items` ON purchase_items.purchase_invoice_no = invoice.purchase_invoice_id LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id WHERE purchase_invoice_status !='2' ".$where1."  and cash_status != 1 GROUP BY invoice.purchase_invoice_id				
				UNION			
				SELECT invoice.`commercial_invoice_id`, DATE_FORMAT(invoice.invoice_due_date,'%Y-%m-%d') as date, invoice.amount_inr as paid_amount, erp_vendor_master.vendor_name, payment_status, (CASE WHEN payment_status = '5' THEN 'PCI' END) as payment_type, invoice.commercial_invoice_id as invoice_increment_id, null, null, invoice.amount_inr as invoice_amount FROM `erp_purchase_commercial_invoice` as invoice left join erp_vendor_master on erp_vendor_master.vendor_id=invoice.vendor_id WHERE `commercial_invoice_status` !='2' ".$where2."					
				ORDER BY date";			
			}else{
				$select ="SELECT invoice.purchase_invoice_id as sales_invoice_id, DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date, sum(invoice.grand_total_amount) AS `paid_amount`, `vendor`.`vendor_name`, `invoice`.`payment_status`, (CASE WHEN `invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, (invoice.purchase_invoice_id) as invoice_increment_id, sum( IF(invoice.operator1 = '1', invoice.price, 0) ) AS add_amount, sum( IF(invoice.operator1 = '2', invoice.price, 0) ) AS sub_amount, sum(purchase_invoice_item_price * purchase_invoice_item_approved_quantity ) as invoice_amount FROM `erp_purchase_invoice` AS `invoice` LEFT JOIN `erp_purchse_invoice_items` AS `purchase_items` ON purchase_items.purchase_invoice_no = invoice.purchase_invoice_id LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id WHERE purchase_invoice_status !='2' and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'  and cash_status != 1 GROUP BY invoice.vendor_id
				
				UNION
			
				SELECT invoice.`commercial_invoice_id`, DATE_FORMAT(invoice.invoice_due_date,'%Y-%m-%d') as date, invoice.amount_inr as paid_amount, erp_vendor_master.vendor_name, payment_status, (CASE WHEN payment_status = '5' THEN 'PCI' END) as payment_type, invoice.commercial_invoice_id as invoice_increment_id, null, null, sum(invoice.amount_inr) as invoice_amount FROM `erp_purchase_commercial_invoice` as invoice left join erp_vendor_master on erp_vendor_master.vendor_id=invoice.vendor_id WHERE `commercial_invoice_status` !='2' and invoice_due_date >='".$data['start_date']."' and invoice_due_date <='".$data['end_date']."' GROUP BY invoice.vendor_id					
				ORDER BY date";
			}
			//echo $select; die;
			$result = $this->getAdapter()
					->fetchAll($select);
			return $result;
	}
	
	
	public function getAccountStatementByDatesForPurchase($data)
	{
				
		if( !empty($data['party_id']) ){		
			
			$where1 = '';			
			$where6 = '';
			$where8 = '';
			/* if(!empty( $data['type'] )){
				$where .= " and receipt_status ='".$data['type']."'";
				$where1 .= " and payment_status ='".$data['type']."'";
			} */
			if(!empty( $data['party_id'] )){				
				//$where1 .= " and vendor_name ='".$data['party_id']."'";				
				//$where6 .= " and vendor_name ='".$data['party_id']."'";				
				//$where7 .= " OR account_name ='".$data['party_id']."'";
				$where1 .= " and vendor.vendor_id ='".$data['search_id']."' and vendor_search_type='".$data['search_type']."'";
				$where6 .= " and erp_vendor_master.vendor_id ='".$data['search_id']."' and vendor_search_type='".$data['search_type']."'";
				$where8 .= " and account.account_id ='".$data['search_id']."' and account_search_type='".$data['search_type']."'";
			}
			if(!empty( $data['start_date'] )){				
				$where1 .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";				
				$where6 .= " and invoice_due_date >='".$data['start_date']."' and invoice_due_date <='".$data['end_date']."'";
				$where8 .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";
			}
			
			$select ="SELECT invoice.purchase_invoice_id as sales_invoice_id, DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date, sum(purchase_invoice_item_price * purchase_invoice_item_approved_quantity ) AS `paid_amount`, (IF(invoice.operator1 = '1', invoice.price, 0) ) AS add_amount, ( IF(invoice.operator1 = '2', invoice.price, 0) ) AS sub_amount, `vendor`.`vendor_name`, `invoice`.`payment_status`, (CASE WHEN `invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, (invoice.purchase_invoice_id) as invoice_increment_id, account.account_id,account.account_name, null, null FROM `erp_purchase_invoice` AS `invoice` 
			LEFT JOIN `erp_purchse_invoice_items` AS `purchase_items` ON purchase_items.purchase_invoice_no = invoice.purchase_invoice_id 
			LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id 
			LEFT JOIN `account_master` AS `account` ON account.account_id=purchase_items.account_id 
			WHERE purchase_invoice_status !=2 and (purchase_items.account_id='' OR purchase_items.account_id='0') ".$where1." GROUP BY purchase_items.purchase_invoice_no
			
			UNION
			
			SELECT invoice.purchase_invoice_id as sales_invoice_id, DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date, sum(purchase_invoice_item_price * purchase_invoice_item_approved_quantity ) AS `paid_amount`, (IF(invoice.operator1 = '1', invoice.price, 0) ) AS add_amount, ( IF(invoice.operator1 = '2', invoice.price, 0) ) AS sub_amount, `vendor`.`vendor_name`, (CASE WHEN purchase_items.account_id != '' THEN '4' END) as payment_status, (CASE WHEN `invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, (invoice.purchase_invoice_id) as invoice_increment_id, account.account_id,account.account_name, null, null FROM `erp_purchase_invoice` AS `invoice` 
			LEFT JOIN `erp_purchse_invoice_items` AS `purchase_items` ON purchase_items.purchase_invoice_no = invoice.purchase_invoice_id 
			LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id 
			LEFT JOIN `account_master` AS `account` ON account.account_id=purchase_items.account_id 
			WHERE purchase_invoice_status !=2 and purchase_items.account_id !='' ".$where8." GROUP BY purchase_items.purchase_invoice_no
			
			UNION
		
			SELECT invoice.`commercial_invoice_id`, DATE_FORMAT(invoice.invoice_due_date,'%Y-%m-%d') as date, invoice.amount_inr as paid_amount, null, null, erp_vendor_master.vendor_name, payment_status, (CASE WHEN payment_status = '5' THEN 'PCI' END) as payment_type, invoice.commercial_invoice_id as invoice_increment_id, null, null, null, null FROM `erp_purchase_commercial_invoice` as invoice left join erp_vendor_master on erp_vendor_master.vendor_id=invoice.vendor_id WHERE `commercial_invoice_status` !='2' ".$where6."
												
			ORDER BY date";
			
									
		}else{
			
			$select ="		
			SELECT invoice.purchase_invoice_id as sales_invoice_id, DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date, sum(purchase_invoice_item_price * purchase_invoice_item_approved_quantity ) AS `paid_amount`, (CASE WHEN invoice.operator1 = '1' THEN sum(invoice.price) END) AS `add_amount`, (CASE WHEN invoice.operator1 = '2' THEN sum(invoice.price) END) AS `sub_amount`, `vendor`.`vendor_name`, `invoice`.`payment_status`, (CASE WHEN `invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, (invoice.purchase_invoice_id) as invoice_increment_id, null, null, null, null FROM `erp_purchase_invoice` AS `invoice` LEFT JOIN `erp_purchse_invoice_items` AS `purchase_items` ON purchase_items.purchase_invoice_no = invoice.purchase_invoice_id LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id WHERE purchase_invoice_status !='2' and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."' and (purchase_items.account_id='' OR purchase_items.account_id='0') GROUP BY purchase_items.purchase_invoice_no
			
			UNION
		
			SELECT invoice.`commercial_invoice_id`, DATE_FORMAT(invoice.invoice_due_date,'%Y-%m-%d') as date, invoice.amount_inr as paid_amount, null, null, erp_vendor_master.vendor_name, payment_status, (CASE WHEN payment_status = '5' THEN 'PCI' END) as payment_type, invoice.commercial_invoice_id as invoice_increment_id, null, null, null, null FROM `erp_purchase_commercial_invoice` as invoice left join erp_vendor_master on erp_vendor_master.vendor_id=invoice.vendor_id WHERE `commercial_invoice_status` !='2' and invoice_due_date >='".$data['start_date']."' and invoice_due_date <='".$data['end_date']."'
			
			ORDER BY date";			
			
		}		
		//echo $select; die;
		$result = $this->getAdapter()
                ->fetchAll($select);
        return $result;	
	}
	
	//Get Vat For Domestic Purchase
	public function getAccountStatementByDatesForPurchaseVat($data)
	{
				
		if( !empty($data['party_id']) ){		
			$where = '';
			$where1 = '';
			$where2 = '';
			$where3 = '';
			$where4 = '';
			$where5 = '';
			$where6 = '';
			
			if(!empty( $data['party_id'] )){
				$where .= " and customer.dealer_id ='".$data['search_id']."' and cus_search_type='".$data['search_type']."'";
				$where1 .= " and vendor.vendor_id ='".$data['search_id']."' and vendor_search_type='".$data['search_type']."'";
				$where2 .= " and account.account_id ='".$data['search_id']."' and account_search_type='".$data['search_type']."'";
				$where3 .= " and finance_payment_vouvher.vendor_id ='".$data['search_id']."' and party_type ='".$data['search_type']."'";
				$where4 .= " and finance_receipt_voucher.dealer_id ='".$data['search_id']."' and party_type ='".$data['search_type']."'";				
				$where5 .= " and credit_party_id ='".$data['search_id']."' and credit_party_type ='".$data['search_type']."'";
				$where6 .= " and debit_party_id ='".$data['search_id']."' and debit_party_type ='".$data['search_type']."'";
			}
			if(!empty( $data['start_date'] )){
				$where .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";
				$where1 .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";
				$where3 .= " and add_date >='".$data['start_date']."' and add_date <='".$data['end_date']."'";
				$where4 .= " and add_date >='".$data['start_date']."' and add_date <='".$data['end_date']."'";
				$where5 .= " and date >='".$data['start_date']."' and date <='".$data['end_date']."'";	
				$where6 .= " and date >='".$data['start_date']."' and date <='".$data['end_date']."'";
				$where2 .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";
			}
						
			$select ="SELECT invoice.purchase_invoice_id as sales_invoice_id, DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date,  sum(invoice.grand_total_amount) AS `paid_amount`, ( IF(invoice.operator1 = '1', invoice.price, 0) + IF(invoice.operator2 = '1', invoice.price1, 0) + IF(invoice.operator3 = '1', invoice.price2, 0) ) AS add_amount, ( IF(invoice.operator1 = '2', invoice.price, 0) + IF(invoice.operator2 = '2', invoice.price1, 0) + IF(invoice.operator3 = '2', invoice.price2, 0)) AS sub_amount, `vendor`.`vendor_name` as vendor_name, `invoice`.`payment_status`,`invoice`.`price`, (CASE WHEN `invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, (invoice.bill_no) as invoice_increment_id  FROM `erp_purchase_invoice` AS `invoice` 
			LEFT JOIN `erp_purchse_invoice_items` AS `purchase_items` ON purchase_items.purchase_invoice_no = invoice.purchase_invoice_id 
			LEFT JOIN `account_master` AS `account` ON account.account_id=purchase_items.account_id 
			LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id 
			WHERE invoice.price !='' and invoice.purchase_invoice_status !=2 and (purchase_items.account_id='' OR purchase_items.account_id='0') ".$where1." GROUP BY purchase_items.purchase_invoice_no
			UNION
			SELECT invoice.purchase_invoice_id as sales_invoice_id, DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date,  sum(invoice.grand_total_amount) AS `paid_amount`, ( IF(invoice.operator1 = '1', invoice.price, 0) + IF(invoice.operator2 = '1', invoice.price1, 0) + IF(invoice.operator3 = '1', invoice.price2, 0) ) AS add_amount, ( IF(invoice.operator1 = '2', invoice.price, 0) + IF(invoice.operator2 = '2', invoice.price1, 0) + IF(invoice.operator3 = '2', invoice.price2, 0)) AS sub_amount, `vendor`.`vendor_name` as vendor_name, `invoice`.`payment_status`,`invoice`.`price`, (CASE WHEN `invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, (invoice.bill_no) as invoice_increment_id  FROM `erp_purchase_invoice` AS `invoice` 
			LEFT JOIN `erp_purchse_invoice_items` AS `purchase_items` ON purchase_items.purchase_invoice_no = invoice.purchase_invoice_id 
			LEFT JOIN `account_master` AS `account` ON account.account_id=purchase_items.account_id 
			LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id 
			WHERE invoice.price !='' and invoice.purchase_invoice_status !=2 and purchase_items.account_id !='' ".$where2." GROUP BY purchase_items.purchase_invoice_no
			UNION			
			SELECT sales_invoice.sales_invoice_id, DATE_FORMAT(sales_invoice.invoice_date,'%Y-%m-%d') as date, sum(sales_items.total_price) AS `paid_amount`, ( IF(sales_invoice.operator1 = '0' && sales_invoice.tax_type='2', sales_invoice.price1, 0) + IF(sales_invoice.operator2 = '1' && sales_invoice.tax_type1='2', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '1' && sales_invoice.tax_type2='2', sales_invoice.price3, 0) ) AS add_amount, ( IF(sales_invoice.operator2 = '2' && sales_invoice.tax_type1='2', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '2' && sales_invoice.tax_type2='2', sales_invoice.price3, 0) ) AS sub_amount, `customer`.`dealer_company_name` as vendor_name, `sales_invoice`.`receipt_status` as payment_status, null ,(CASE WHEN `sales_invoice`.`receipt_status` = '4' THEN 'SI' END) as payment_type, sales_invoice.invoice_increment_id  FROM `erp_sales_invoice` AS `sales_invoice` LEFT JOIN `erp_sales_invoice_items` AS `sales_items` ON sales_items.sales_invoice_id = sales_invoice.sales_invoice_id LEFT JOIN `erp_dealer_master` AS `customer` ON customer.dealer_id=sales_invoice.dealer_id WHERE sales_invoice.invoice_status !=2 and (sales_invoice.tax_type='2' OR sales_invoice.tax_type1='2' OR sales_invoice.tax_type2='2') ".$where." GROUP BY sales_items.sales_invoice_id
			UNION
			
			SELECT finance_payment_vouvher.`payment_voucher_id` as sales_invoice_id, DATE_FORMAT(finance_payment_vouvher.add_date,'%Y-%m-%d') as date, paid_amount, paid_amount as add_amount,null,party_names as vendor_name, (CASE WHEN `finance_payment_vouvher`.`payment_status` = '4' THEN '4' END) as payment_status, null, (CASE WHEN payment_status = '4' THEN 'PV' END) as payment_type, remarks as invoice_increment_id FROM `finance_payment_vouvher` left join account_master on account_master.account_id=finance_payment_vouvher.vendor_id and party_type='A' WHERE vat_status ='1' ".$where3."
			
			UNION 
			
			SELECT  finance_receipt_voucher.`receipt_voucher_id` as sales_invoice_id, DATE_FORMAT(finance_receipt_voucher.add_date,'%Y-%m-%d') as date, paid_amount, paid_amount as add_amount,null,party_names as vendor_name,(CASE WHEN `finance_receipt_voucher`.`receipt_status` = '5' THEN '5' END) as payment_status ,null, (CASE WHEN receipt_status = '5' THEN 'RV' END) as payment_type, remarks as invoice_increment_id FROM `finance_receipt_voucher` left join account_master on account_master.account_id=finance_receipt_voucher.dealer_id and party_type='A' WHERE vat_status ='1' ".$where4."
			
			UNION
			
			SELECT `id` as sales_invoice_id, DATE_FORMAT(date,'%Y-%m-%d') as date,credit_amount, `credit_amount` as add_amount,null, `dealer_id` as vendor_name, (CASE WHEN `journal_voucher`.`payment_type` = '5' THEN '5' END) as payment_status,null,(CASE WHEN payment_type = '5' THEN 'JV' END) payment_type, remarks as invoice_increment_id FROM `journal_voucher` left join account_master on account_master.account_id=journal_voucher.credit_party_id and credit_party_type='A' WHERE payment_type = '5' and vat_status = '1' ".$where5."
			
			UNION

			SELECT `id` as sales_invoice_id, DATE_FORMAT(date,'%Y-%m-%d') as date,debit_amount, `debit_amount` as add_amount,null, `vendor_id` as vendor_name, (CASE WHEN `journal_voucher`.`payment_type` = '5' THEN '5' END) as payment_status,null,(CASE WHEN `payment_type` = '5' THEN 'JV' END) as payment_type , remark1 as invoice_increment_id FROM `journal_voucher` left join account_master on account_master.account_id=journal_voucher.debit_party_id and debit_party_type='A' WHERE  payment_type = '5' and account_master.vat_status='1' ".$where6."
			
			
			ORDER BY date";
			
		}else{
			$select ="		
			SELECT invoice.purchase_invoice_id as sales_invoice_id, DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date, sum(purchase_invoice_item_price * purchase_invoice_item_approved_quantity ) AS `paid_amount`, (IF(invoice.operator1 = '1', invoice.price, 0) + IF(invoice.operator2 = '1', invoice.price1, 0) + IF(invoice.operator3 = '1', invoice.price2, 0)) AS add_amount, ( IF(invoice.operator1 = '2', invoice.price, 0) + IF(invoice.operator2 = '2', invoice.price1, 0) + IF(invoice.operator3 = '2', invoice.price2, 0)) AS sub_amount, `vendor`.`vendor_name`, `invoice`.`payment_status`, (CASE WHEN `invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, (invoice.bill_no) as invoice_increment_id FROM `erp_purchase_invoice` AS `invoice` LEFT JOIN `erp_purchse_invoice_items` AS `purchase_items` ON purchase_items.purchase_invoice_no = invoice.purchase_invoice_id LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id LEFT JOIN `account_master` AS `account` ON account.account_id=purchase_items.account_id  WHERE purchase_invoice_status !='2' and invoice.price !='' and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."' GROUP BY invoice.purchase_invoice_id 
			UNION
			SELECT sales_invoice.sales_invoice_id, DATE_FORMAT(sales_invoice.invoice_date,'%Y-%m-%d') as date, sum(sales_items.total_price) AS `paid_amount`, ( IF(sales_invoice.operator1 = '0' && sales_invoice.tax_type='2', sales_invoice.price1, 0) + IF(sales_invoice.operator2 = '1' && sales_invoice.tax_type1='2', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '1' && sales_invoice.tax_type2='2', sales_invoice.price3, 0) ) AS add_amount, ( IF(sales_invoice.operator2 = '2' && sales_invoice.tax_type1='2', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '2' && sales_invoice.tax_type2='2', sales_invoice.price3, 0) ) AS sub_amount, `customer`.`dealer_company_name` as vendor_name, `sales_invoice`.`receipt_status` as payment_status, (CASE WHEN `sales_invoice`.`receipt_status` = '4' THEN 'SI' END) as payment_type, sales_invoice.invoice_increment_id FROM `erp_sales_invoice` AS `sales_invoice` LEFT JOIN `erp_sales_invoice_items` AS `sales_items` ON sales_items.sales_invoice_id = sales_invoice.sales_invoice_id LEFT JOIN `erp_dealer_master` AS `customer` ON customer.dealer_id=sales_invoice.dealer_id WHERE sales_invoice.invoice_status !=2 and (sales_invoice.tax_type='2' OR sales_invoice.tax_type1='2' OR sales_invoice.tax_type2='2') and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."' GROUP BY sales_items.sales_invoice_id 
			UNION
			
			SELECT finance_payment_vouvher.`payment_voucher_id` as sales_invoice_id, DATE_FORMAT(finance_payment_vouvher.add_date,'%Y-%m-%d') as date, paid_amount, paid_amount as add_amount,null,party_names as vendor_name, (CASE WHEN `finance_payment_vouvher`.`payment_status` = '4' THEN '4' END) as payment_status, (CASE WHEN payment_status = '4' THEN 'PV' END) as payment_type, remarks as invoice_increment_id FROM `finance_payment_vouvher` left join account_master on account_master.account_id=finance_payment_vouvher.vendor_id and party_type='A' WHERE vat_status ='1' and add_date >='".$data['start_date']."' and add_date <='".$data['end_date']."'
			
			UNION 
			
			SELECT  finance_receipt_voucher.`receipt_voucher_id` as sales_invoice_id, DATE_FORMAT(finance_receipt_voucher.add_date,'%Y-%m-%d') as date, paid_amount, paid_amount as add_amount,null,party_names as vendor_name,(CASE WHEN `finance_receipt_voucher`.`receipt_status` = '5' THEN '5' END) as payment_status , (CASE WHEN receipt_status = '5' THEN 'RV' END) as payment_type, remarks as invoice_increment_id FROM `finance_receipt_voucher` left join account_master on account_master.account_id=finance_receipt_voucher.dealer_id and party_type='A' WHERE vat_status ='1' and add_date >='".$data['start_date']."' and add_date <='".$data['end_date']."'
			
			UNION
			
			SELECT `id` as sales_invoice_id, DATE_FORMAT(date,'%Y-%m-%d') as date,credit_amount, `credit_amount` as add_amount,null, `dealer_id` as vendor_name, (CASE WHEN `journal_voucher`.`payment_type` = '5' THEN '4' END) as payment_status,(CASE WHEN payment_type = '5' THEN 'JV' END) payment_type, remarks as invoice_increment_id FROM `journal_voucher` left join account_master on account_master.account_id=journal_voucher.credit_party_id and credit_party_type='A' WHERE payment_type = '5' and account_master.vat_status='1' and date >='".$data['start_date']."' and date <='".$data['end_date']."'
			
			UNION

			SELECT `id` as sales_invoice_id, DATE_FORMAT(date,'%Y-%m-%d') as date,debit_amount, `debit_amount` as add_amount,null, `vendor_id` as vendor_name, (CASE WHEN `journal_voucher`.`payment_type` = '5' THEN '5' END) as payment_status,(CASE WHEN `payment_type` = '5' THEN 'JV' END) as payment_type , remark1 as invoice_increment_id FROM `journal_voucher` left join account_master on account_master.account_id=journal_voucher.debit_party_id and debit_party_type='A' WHERE  payment_type = '5' and account_master.vat_status='1' and date >='".$data['start_date']."' and date <='".$data['end_date']."'
			
			ORDER BY date";
			}		
		//echo $select; die;
		$result = $this->getAdapter()
                ->fetchAll($select);
			//	echo '<pre>';
		//print_r($result); die;
        return $result;	
	}
	
	public function getAccountStatementByDatesBeforePurchase($data)
	{					
			$select ="		
			SELECT invoice.purchase_invoice_id as sales_invoice_id, DATE_FORMAT(invoice.invoice_date,'%Y-%m-%d') as date, sum(purchase_invoice_item_price * purchase_invoice_item_approved_quantity ) AS `paid_amount`, (CASE WHEN invoice.operator1 = '1' THEN sum(invoice.price) END) AS `add_amount`, (CASE WHEN invoice.operator1 = '2' THEN sum(invoice.price) END) AS `sub_amount`, `vendor`.`vendor_name`, `invoice`.`payment_status`, (CASE WHEN `invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, (invoice.purchase_invoice_id) as invoice_increment_id, null, null, null, null FROM `erp_purchase_invoice` AS `invoice` LEFT JOIN `erp_purchse_invoice_items` AS `purchase_items` ON purchase_items.purchase_invoice_no = invoice.purchase_invoice_id LEFT JOIN `erp_vendor_master` AS `vendor` ON vendor.vendor_id=invoice.vendor_id WHERE purchase_invoice_status !='2' and invoice_date <='".$data['start_date']."'			
			ORDER BY date";	
		//echo $select; die;
		$result = $this->getAdapter()
                ->fetchRow($select);
        return $result;	
	}
	
	public function getAccountStatementByDatesForCash($data)
	{
		
				
		if( !empty($data['party_id']) ){		
			
			$where2 = '';			
			$where3 = '';
			$where4 = '';
			$where5 = '';
			/* if(!empty( $data['type'] )){
				$where .= " and receipt_status ='".$data['type']."'";
				$where1 .= " and payment_status ='".$data['type']."'";
			} */
			if(!empty( $data['party_id'] )){				
				//$where2 .= " and dealer_company_name ='".$data['party_id']."' OR party_names ='".$data['party_id']."'"; 
				//$where3 .= " and vendor_name ='".$data['party_id']."' OR party_names ='".$data['party_id']."'";
				$where2 .= " and finance_receipt_voucher.dealer_id ='".$data['search_id']."' and party_type ='".$data['search_type']."'";
				$where3 .= " and finance_payment_vouvher.vendor_id ='".$data['search_id']."' and party_type ='".$data['search_type']."'";
				$where4 .= " and erp_sales_invoice.dealer_id ='".$data['search_id']."' and cus_search_type='".$data['search_type']."'";
				$where5 .= " and erp_purchase_invoice.vendor_id ='".$data['search_id']."' and vendor_search_type='".$data['search_type']."'";
			}
			if(!empty( $data['start_date'] )){				
				$where2 .= " and add_date >='".$data['start_date']."' and add_date <='".$data['end_date']."'";
				$where3 .= " and add_date >='".$data['start_date']."' and add_date <='".$data['end_date']."'";
				$where4 .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";
				$where5 .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";
			}
			
			$select ="SELECT finance_payment_vouvher.`payment_voucher_id` as sales_invoice_id, DATE_FORMAT(finance_payment_vouvher.add_date,'%Y-%m-%d') as date, paid_amount, party_names as vendor_name, (CASE WHEN payment_status = '4' THEN '5' END) as payment_status, (CASE WHEN payment_status = '4' THEN 'PV' END) as payment_type,  remarks as invoice_increment_id FROM `finance_payment_vouvher` left join erp_vendor_master on erp_vendor_master.vendor_id=finance_payment_vouvher.vendor_id WHERE `status` !='2' and payment_by='1' ".$where3."
			
			UNION 
			
			SELECT finance_receipt_voucher.`receipt_voucher_id` as sales_invoice_id, DATE_FORMAT(finance_receipt_voucher.add_date,'%Y-%m-%d') as date, `paid_amount`, party_names as vendor_name, (CASE WHEN receipt_status = '5' THEN '4' END) as payment_status, (CASE WHEN receipt_status = '5' THEN 'RV' END) as payment_type, remarks as invoice_increment_id FROM `finance_receipt_voucher` left join erp_dealer_master on erp_dealer_master.dealer_id=finance_receipt_voucher.dealer_id WHERE `status` !='2' and payment_by='1' ".$where2."
			UNION 
			
			SELECT erp_sales_invoice.`sales_invoice_id` as sales_invoice_id, DATE_FORMAT(erp_sales_invoice.invoice_date,'%Y-%m-%d') as date,(actual_grand_total) as paid_amount,dealer_company_name as vendor_name, (CASE WHEN `erp_sales_invoice`.`receipt_status` = '4' THEN '4' END) as payment_status, (CASE WHEN `erp_sales_invoice`.`receipt_status` = '4' THEN 'SI' END) as payment_type, null FROM `erp_sales_invoice` left join erp_dealer_master on erp_dealer_master.dealer_id=erp_sales_invoice.dealer_id WHERE `invoice_status` !='2' and cash_status= '1' ".$where4."
			
			UNION 
			
			SELECT erp_purchase_invoice.`purchase_invoice_id` as sales_invoice_id, DATE_FORMAT(erp_purchase_invoice.invoice_date,'%Y-%m-%d') as date,(grand_total_amount) as paid_amount,vendor_name as vendor_name, (CASE WHEN `erp_purchase_invoice`.`payment_status` = '5' THEN '5' END) as payment_status, (CASE WHEN `erp_purchase_invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, null FROM `erp_purchase_invoice` LEFT JOIN `erp_purchse_invoice_items` AS `purchase_items` ON purchase_items.purchase_invoice_no = erp_purchase_invoice.purchase_invoice_id left join erp_vendor_master on erp_vendor_master.vendor_id=erp_purchase_invoice.vendor_id WHERE `purchase_invoice_status` !='2' and (purchase_items.account_id='' OR purchase_items.account_id='0') and cash_status = '1' 
			".$where5." 
			
			ORDER BY date";	
											
									
		}else{
			
			$select ="SELECT finance_payment_vouvher.`payment_voucher_id` as sales_invoice_id, DATE_FORMAT(finance_payment_vouvher.add_date,'%Y-%m-%d') as date, paid_amount, party_names as vendor_name, (CASE WHEN payment_status = '4' THEN '5' END) as payment_status, (CASE WHEN payment_status = '4' THEN 'PV' END) as payment_type, remarks as invoice_increment_id FROM `finance_payment_vouvher` left join erp_vendor_master on erp_vendor_master.vendor_id=finance_payment_vouvher.vendor_id WHERE `status` !='2' and payment_by='1' and add_date >='".$data['start_date']."' and add_date <='".$data['end_date']."'
			
			UNION 
			
			SELECT finance_receipt_voucher.`receipt_voucher_id` as sales_invoice_id, DATE_FORMAT(finance_receipt_voucher.add_date,'%Y-%m-%d') as date, `paid_amount`, party_names as vendor_name, (CASE WHEN receipt_status = '5' THEN '4' END) as payment_status, (CASE WHEN receipt_status = '5' THEN 'RV' END) as payment_type, remarks as invoice_increment_id FROM `finance_receipt_voucher` left join erp_dealer_master on erp_dealer_master.dealer_id=finance_receipt_voucher.dealer_id WHERE `status` !='2' and payment_by='1' and add_date >='".$data['start_date']."' and add_date <='".$data['end_date']."'
			
			UNION 
			
			SELECT erp_sales_invoice.`sales_invoice_id` as sales_invoice_id, DATE_FORMAT(erp_sales_invoice.invoice_date,'%Y-%m-%d') as date,(actual_grand_total) as paid_amount,dealer_company_name as vendor_name, (CASE WHEN `erp_sales_invoice`.`receipt_status` = '4' THEN '4' END) as payment_status, (CASE WHEN `erp_sales_invoice`.`receipt_status` = '4' THEN 'SI' END) as payment_type, null FROM `erp_sales_invoice` left join erp_dealer_master on erp_dealer_master.dealer_id=erp_sales_invoice.dealer_id WHERE `invoice_status` !='2' and cash_status= 1 and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'
			
			UNION 
			
			SELECT erp_purchase_invoice.`purchase_invoice_id` as sales_invoice_id, DATE_FORMAT(erp_purchase_invoice.invoice_date,'%Y-%m-%d') as date,(grand_total_amount) as paid_amount,vendor_name as vendor_name, (CASE WHEN `erp_purchase_invoice`.`payment_status` = '5' THEN '5' END) as payment_status, (CASE WHEN `erp_purchase_invoice`.`payment_status` = '5' THEN 'PI' END) as payment_type, null FROM `erp_purchase_invoice` left join erp_vendor_master on erp_vendor_master.vendor_id=erp_purchase_invoice.vendor_id WHERE `purchase_invoice_status` !='2' and cash_status = 1 and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'
			
			ORDER BY date";	
			
		}		
		//echo $select; die;
		$result = $this->getAdapter()
                ->fetchAll($select);
        return $result;	
	}
	
	//CST Account
	public function getAccountStatementByDatesForSalesCST($data)
	{
				
		if( !empty($data['party_id']) ){		
			
			$where = '';
			if(!empty( $data['party_id'] )){				
				$where .= " and customer.dealer_id ='".$data['search_id']."' and cus_search_type='".$data['search_type']."'";
			}
			if(!empty( $data['start_date'] )){				
				$where .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";
			}
			
			$select ="SELECT sales_invoice.sales_invoice_id, DATE_FORMAT(sales_invoice.invoice_date,'%Y-%m-%d') as date, sum(sales_items.total_price) AS `paid_amount`, ( IF(sales_invoice.operator1 = '0' && sales_invoice.tax_type='1', sales_invoice.price1, 0) + IF(sales_invoice.operator2 = '1' && sales_invoice.tax_type1='1', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '1' && sales_invoice.tax_type2='1', sales_invoice.price3, 0) ) AS add_amount, ( IF(sales_invoice.operator2 = '2' && sales_invoice.tax_type1='1', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '2' && sales_invoice.tax_type2='1', sales_invoice.price3, 0) ) AS sub_amount, `customer`.`dealer_company_name` as vendor_name, `sales_invoice`.`receipt_status` as payment_status, (CASE WHEN `sales_invoice`.`receipt_status` = '4' THEN 'SI' END) as payment_type, sales_invoice.invoice_increment_id, sales_invoice.name_of_transport, sales_invoice.no_of_packages, sales_invoice.despatched_through, sales_invoice.private_mark FROM `erp_sales_invoice` AS `sales_invoice` LEFT JOIN `erp_sales_invoice_items` AS `sales_items` ON sales_items.sales_invoice_id = sales_invoice.sales_invoice_id LEFT JOIN `erp_dealer_master` AS `customer` ON customer.dealer_id=sales_invoice.dealer_id WHERE sales_invoice.invoice_status !=2 and (sales_invoice.tax_type='1' OR sales_invoice.tax_type1='1' OR sales_invoice.tax_type2='1') ".$where." GROUP BY sales_items.sales_invoice_id	
			
			ORDER BY date";
			
									
		}else{
			
			$select ="SELECT sales_invoice.sales_invoice_id, DATE_FORMAT(sales_invoice.invoice_date,'%Y-%m-%d') as date, sum(sales_items.total_price) AS `paid_amount`, ( IF(sales_invoice.operator1 = '0' && sales_invoice.tax_type='1', sales_invoice.price1, 0) + IF(sales_invoice.operator2 = '1' && sales_invoice.tax_type1='1', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '1' && sales_invoice.tax_type2='1', sales_invoice.price3, 0) ) AS add_amount, ( IF(sales_invoice.operator2 = '2' && sales_invoice.tax_type1='1', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '2' && sales_invoice.tax_type2='1', sales_invoice.price3, 0) ) AS sub_amount, `customer`.`dealer_company_name` as vendor_name, `sales_invoice`.`receipt_status` as payment_status, (CASE WHEN `sales_invoice`.`receipt_status` = '4' THEN 'SI' END) as payment_type, sales_invoice.invoice_increment_id, sales_invoice.name_of_transport, sales_invoice.no_of_packages, sales_invoice.despatched_through, sales_invoice.private_mark FROM `erp_sales_invoice` AS `sales_invoice` LEFT JOIN `erp_sales_invoice_items` AS `sales_items` ON sales_items.sales_invoice_id = sales_invoice.sales_invoice_id LEFT JOIN `erp_dealer_master` AS `customer` ON customer.dealer_id=sales_invoice.dealer_id WHERE sales_invoice.invoice_status !='2' and (sales_invoice.tax_type='1' OR sales_invoice.tax_type1='1' OR sales_invoice.tax_type2='1') and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."' GROUP BY sales_items.sales_invoice_id ORDER BY date";			
			
		}		
		//echo $select; die;
		$result = $this->getAdapter()
                ->fetchAll($select);
        return $result;	
	}
	
	//Sales Account
	public function getAccountStatementByDatesForSalesAccount($data)
	{
				
		if( !empty($data['party_id']) ){		
			
			$where = '';
			$where1 = '';
			if(!empty( $data['party_id'] )){				
				$where .= " and customer.dealer_id ='".$data['search_id']."' and cus_search_type='".$data['search_type']."'";
				$where1 .= " and erp_dealer_master.dealer_id ='".$data['search_id']."' and cus_search_type='".$data['search_type']."'";
			}
			if(!empty( $data['start_date'] )){				
				$where .= " and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."'";
				$where1 .= " and waybill_date >='".$data['start_date']."' and waybill_date <='".$data['end_date']."'";	
			}
			
			$select ="SELECT sales_invoice.sales_invoice_id, DATE_FORMAT(sales_invoice.invoice_date,'%Y-%m-%d') as date, sum(sales_items.total_price) AS `paid_amount`, ( IF(sales_invoice.operator2 = '1', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '1', sales_invoice.price3, 0) ) AS add_amount, ( IF(sales_invoice.operator2 = '2', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '2', sales_invoice.price3, 0) ) AS sub_amount, `customer`.`dealer_company_name` as vendor_name, `sales_invoice`.`receipt_status` as payment_status, (CASE WHEN `sales_invoice`.`receipt_status` = '4' THEN 'SI' END) as payment_type, sales_invoice.invoice_increment_id, sales_invoice.name_of_transport, sales_invoice.no_of_packages, sales_invoice.despatched_through, sales_invoice.private_mark FROM `erp_sales_invoice` AS `sales_invoice` LEFT JOIN `erp_sales_invoice_items` AS `sales_items` ON sales_items.sales_invoice_id = sales_invoice.sales_invoice_id LEFT JOIN `erp_dealer_master` AS `customer` ON customer.dealer_id=sales_invoice.dealer_id WHERE sales_invoice.invoice_status !=2 ".$where." GROUP BY sales_items.sales_invoice_id	
			UNION
			SELECT erp_sales_waybill.`waybill_id`, DATE_FORMAT(erp_sales_waybill.waybill_date,'%Y-%m-%d') as date, erp_sales_waybill.total_amount as paid_amount, null, null, erp_dealer_master.custom_name as vendor_name, erp_sales_waybill.`receipt_status` as payment_status, (CASE WHEN erp_sales_waybill.receipt_status = '4' THEN 'WB' END) as payment_type, null, null, null, null, null FROM `erp_sales_waybill` left join erp_dealer_master on erp_dealer_master.dealer_id=erp_sales_waybill.sales_dealer_id LEFT JOIN `finance_receipt_voucher` AS `receipt` ON receipt.waybill_id=erp_sales_waybill.waybill_id and receipt.payment_by = '1' WHERE `waybill_status` !='2' ".$where1." group by erp_sales_waybill.waybill_id
			
			ORDER BY date";
			
									
		}else{
			
			$select ="SELECT sales_invoice.sales_invoice_id, DATE_FORMAT(sales_invoice.invoice_date,'%Y-%m-%d') as date, sum(sales_items.total_price) AS `paid_amount`, ( IF(sales_invoice.operator2 = '1', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '1', sales_invoice.price3, 0) ) AS add_amount, ( IF(sales_invoice.operator2 = '2', sales_invoice.price2, 0) + IF(sales_invoice.operator3 = '2', sales_invoice.price3, 0) ) AS sub_amount, `customer`.`dealer_company_name` as vendor_name, `sales_invoice`.`receipt_status` as payment_status, (CASE WHEN `sales_invoice`.`receipt_status` = '4' THEN 'SI' END) as payment_type, sales_invoice.invoice_increment_id, sales_invoice.name_of_transport, sales_invoice.no_of_packages, sales_invoice.despatched_through, sales_invoice.private_mark FROM `erp_sales_invoice` AS `sales_invoice` LEFT JOIN `erp_sales_invoice_items` AS `sales_items` ON sales_items.sales_invoice_id = sales_invoice.sales_invoice_id LEFT JOIN `erp_dealer_master` AS `customer` ON customer.dealer_id=sales_invoice.dealer_id WHERE sales_invoice.invoice_status !='2' and invoice_date >='".$data['start_date']."' and invoice_date <='".$data['end_date']."' GROUP BY sales_items.sales_invoice_id
			UNION
			SELECT erp_sales_waybill.`waybill_id`, DATE_FORMAT(erp_sales_waybill.waybill_date,'%Y-%m-%d') as date, erp_sales_waybill.total_amount as paid_amount, null, null, erp_dealer_master.custom_name as vendor_name, `receipt_status` as payment_status, (CASE WHEN receipt_status = '4' THEN 'WB' END) as payment_type, null, null, null, null, null FROM `erp_sales_waybill` left join erp_dealer_master on erp_dealer_master.dealer_id=erp_sales_waybill.sales_dealer_id WHERE `waybill_status` !='2' and waybill_date >='".$data['start_date']."' and waybill_date <='".$data['end_date']."'	
			ORDER BY date";			
			
		}		
		//echo $select; die;
		$result = $this->getAdapter()
                ->fetchAll($select);
        return $result;	
	}
	
	/*23-12-16 public function getUsers()
	{
		/* $select ="SELECT `dealer_id`, dealer_name, dealer_company_name as com_name, dealer_company_name as `name` FROM erp_dealer_master WHERE dealer_master_status !='2' and dealer_type='0' UNION SELECT `dealer_id`, dealer_name, dealer_company_name as com_name, custom_name as `name` FROM erp_dealer_master WHERE dealer_master_status !='2' and dealer_type='1' group by erp_dealer_master.dealer_id UNION SELECT `bank_id`, `beneficiary_bank_name`, beneficiary_bank_name as com_name, `beneficiary_bank_name` as name FROM erp_bank_master WHERE status !='2' and user_id='2' UNION SELECT `vendor_id`, `vendor_name`, vendor_name as com_name, `vendor_name` as name FROM erp_vendor_master WHERE vendor_status !='2' UNION SELECT `account_id`, `status`, `account_name`as com_name, `account_name` as name FROM account_master WHERE status !='2'";		
		$result = $this->getAdapter()
                ->fetchAll($select);
		$data = array();
        foreach ($result as $val) {            
            $data[$val['com_name']] = $val['name'];            
        } 
		
		$select ="SELECT `dealer_id`, dealer_name, dealer_company_name as com_name, dealer_company_name as `name`, (CASE WHEN dealer_master_status != '2' THEN 'C' END) as type FROM erp_dealer_master WHERE dealer_master_status !='2' and dealer_type='0' UNION SELECT `dealer_id`, dealer_name, dealer_company_name as com_name, custom_name as `name`, (CASE WHEN dealer_master_status != '2' THEN 'C' END) as type FROM erp_dealer_master WHERE dealer_master_status !='2' and dealer_type='1' group by erp_dealer_master.dealer_id UNION SELECT `bank_id`, `beneficiary_bank_name`, beneficiary_bank_name as com_name, `beneficiary_bank_name` as name, (CASE WHEN status != '2' THEN 'B' END) as type FROM erp_bank_master WHERE status !='2' and user_id='2' UNION SELECT `vendor_id`, `vendor_name`, vendor_name as com_name, `vendor_name` as name, (CASE WHEN vendor_status != '2' THEN 'V' END) as type FROM erp_vendor_master WHERE vendor_status !='2' UNION SELECT `account_id`, `status`, `account_name`as com_name, `account_name` as name, (CASE WHEN status != '2' THEN 'A' END) as type FROM account_master WHERE status !='2'";		
		$result = $this->getAdapter()
                ->fetchAll($select);
		$data = array();
        foreach ($result as $val) {            
            $data[$val['com_name'].':;'.$val['dealer_id'].':;'.$val['type']] = $val['name'];            
        }
		
        return $data;	
	} 
	
	*/
	 public function getUsers()
	{
		/* $select ="SELECT `dealer_id`, dealer_name, dealer_company_name as com_name, dealer_company_name as `name` FROM erp_dealer_master WHERE dealer_master_status !='2' and dealer_type='0' UNION SELECT `dealer_id`, dealer_name, dealer_company_name as com_name, custom_name as `name` FROM erp_dealer_master WHERE dealer_master_status !='2' and dealer_type='1' group by erp_dealer_master.dealer_id UNION SELECT `bank_id`, `beneficiary_bank_name`, beneficiary_bank_name as com_name, `beneficiary_bank_name` as name FROM erp_bank_master WHERE status !='2' and user_id='2' UNION SELECT `vendor_id`, `vendor_name`, vendor_name as com_name, `vendor_name` as name FROM erp_vendor_master WHERE vendor_status !='2' UNION SELECT `account_id`, `status`, `account_name`as com_name, `account_name` as name FROM account_master WHERE status !='2'";		
		$result = $this->getAdapter()
                ->fetchAll($select);
		$data = array();
        foreach ($result as $val) {            
            $data[$val['com_name']] = $val['name'];            
        }  */
		
		$select =" SELECT `bank_id`, `beneficiary_bank_name`, beneficiary_bank_name as com_name, `beneficiary_bank_name` as name, (CASE WHEN status != '2' THEN 'B' END) as type FROM erp_bank_master WHERE status !='2' and user_id='2' UNION SELECT `vendor_id`, `vendor_name`, vendor_name as com_name, `vendor_name` as name, (CASE WHEN vendor_status != '2' THEN 'V' END) as type FROM erp_vendor_master WHERE vendor_status !='2' UNION SELECT `account_id`, `status`, `account_name`as com_name, `account_name` as name, (CASE WHEN status != '2' THEN 'A' END) as type FROM account_master WHERE status !='2'";		
		$result = $this->getAdapter()
                ->fetchAll($select);
		$data = array();
        foreach ($result as $val) {            
            $data[$val['com_name'].':;'.$val['dealer_id'].':;'.$val['type']] = $val['name'];            
        }
		
        return $data;	
	} 
	
	
	public function customerOpeningBalance($party_id = "", $search_id = "", $search_type = "") {
        $select = $this->_db->select()
                ->from('erp_dealer_master', array("sum( ABS(start_balance) ) as start_balance", "operator"))
				->where("dealer_id=?", $search_id)
				->where("cus_search_type=?", $search_type)
                ->where("dealer_master_status!=?", 2);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }
	
	public function vendorOpeningBalance($party_id = "", $search_id = "", $search_type = "") {
        $select = $this->_db->select()
                ->from('erp_vendor_master', array("sum( ABS(start_balance) ) as start_balance", "operator"))
				->where("vendor_id=?", $search_id)
				->where("vendor_search_type=?", $search_type)
                ->where("vendor_status!=?", 2);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }
	
	public function bankOpeningBalance($party_id = "", $search_id = "", $search_type = "") { 
        $select = $this->_db->select()
                ->from('erp_bank_master', array("sum( ABS(opening_balance) ) as start_balance", "operator"))
				->where("bank_id=?", $search_id)
				->where("bank_search_type=?", $search_type)
                ->where("status!=?", 2);
				//echo $select;die;
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }
	
	public function accountOpeningBalance($party_id = "", $search_id = "", $search_type = "") {
        $select = $this->_db->select()
                ->from('account_master', array("sum( ABS(opening_balance) ) as start_balance", "operator"))
				->where("account_id=?", $search_id)
				->where("account_search_type=?", $search_type)
                ->where("status!=?", 2);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }
	
	public function accountOpeningBalanceForCash($party_id = "", $search_id = "", $search_type = "") {
        $select = $this->_db->select()
                ->from('account_master', array("(CASE WHEN operator = '1' THEN opening_balance WHEN operator = '0' THEN opening_balance END) as debit_amount","(CASE WHEN operator = '2' THEN opening_balance END) as credit_amount", "sum( ABS(opening_balance) ) as start_balance", "operator"))
				//->where("account_name=?", $party_id)
				->where("cash_account=?", 1)
                ->where("status!=?", 2);
		//echo $select; die;
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }
	
	
	public function getUserEmail($party_name)
	{
		$select ="SELECT dealer_name, dealer_company_name as `name`, dealer_email_id as email FROM erp_dealer_master WHERE dealer_master_status !='2' and dealer_company_name='".$party_name."' UNION SELECT `vendor_name`, `vendor_name` as name, vendor_email_id as email FROM erp_vendor_master WHERE vendor_status !='2' and vendor_name='".$party_name."'";		
		$result = $this->getAdapter()
                ->fetchRow($select);		
        return $result;	
	}
	

}
