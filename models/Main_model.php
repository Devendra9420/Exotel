<?php


/*
 *	@author : Chintan Desai
 *  @support: chintz2806@gmail.com
 *	date	: 01 November, 2019
 *	GarageWorks Inventory Management System
 * website: garageworks.in
 *  version: 1.0
 */
class Main_model extends MY_Model
{

    public $cms_db;
    public function __construct()
    {
        parent::__construct();
       // $this->cms_db = $this->load->database('forum', TRUE);
    }

    public function test()
    {
        $sql = "select * from usr_users";
        $query = $this->cms_db->query($sql);
        return $query->result_array();
    }
    function bps_table($table, $pr_key)
    {


        $this->_table_name = $table;
        $this->_primary_key = $pr_key;

    }

    //fetch max id
    public function fetch_maxid($tbl)
    {

        $this->db->select()->from($tbl);
        $query = $this->db->get();

        return $query->result();
    }

    //select
    public function select($table)
    {
        $this->db->select();
        $this->db->from($table);
        $query = $this->db->get();
        return $query->result();

    }

    // add record
    function add_record($table, $array_data)
    {
        $query = $this->db->insert($table, $array_data);
        if ($query == 1)
            return $query;
        else
            return false;
    }

    //update record
    function update_record($table, $update, $id)
    {
        $this->db->where($id);
        $query = $this->db->update($table, $update);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    //delete record
    function delete_record($table, $field_name, $id)
    {
        $query = $this->db->where($field_name, $id);
        $this->db->delete($table);
        if ($query != NULL)
            return $query;
        else
            return false;
    }

    //select where
    function select_wher($table, $where = NULL)
    {

        $this->db->select('*');
        if ($where)
            $this->db->where($where);

        $query = $this->db->get($table);


        return $query->result();
    }

    //single row record
    function single_row($table, $where = NULL, $return = 's')
    {
        $this->db->select('*');
        if ($where)
            $this->db->where($where);

        $q = $this->db->get($table);


        return $q->row_array();

    }

    //get user details
    public function getUserDetails($user_id)
    {
        $this->db->select("u.NAME,u.EMP_NO,u.GROUP_ID");
        $this->db->from('usr_user as u');
      //  $this->db->where('u.MECHANIC_ID = e.mechanic_id');
        $this->db->where('u.USER_ID', $user_id);
        $query = $this->db->get();
        return $query->row();
    }

    // Users List
    public function users_list()
    {
        $this->db->select("uu.USER_ID, uu.logged_in, uu.CREATED_DATE,
                    uu.USER_NAME,uu.USER_ID, ug.GROUP_NAME,ug.GROUP_ID, uu.IS_ACTIVE")->from("usr_group  as ug,
                    usr_user as uu")->WHERE("ug.GROUP_ID	= uu.GROUP_ID");
        $query = $this->db->get();

        return $query->result_array();
    }

    
	//get same name products
    public function select_samestock($item_id)
    {
        $this->db->select('*');
        $this->db->where('item_id', $item_id);
       // $this->db->where('sub_product', $sub_product);
        //$this->db->where('brand', $brand);
        //$this->db->where('hsn_no', $hsn_no);
        $query = $this->db->get("stock");
        //echo $this->db->last_query();
        $result = $query->num_rows();
        if ($result > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	//get same name products
    public function select_same($item_name, $sub_product, $brand, $gstn_rate, $hsn_no)
    {
        $this->db->select('*');
        $this->db->where('item_name', $item_name);
        $this->db->where('sub_product', $sub_product);
		
        $this->db->where('brand', $brand);
        $this->db->where('gstn_rate', $gstn_rate);
        $this->db->where('hsn_no', $hsn_no);
        $query = $this->db->get("item");
        //echo $this->db->last_query();
        $result = $query->num_rows();
        if ($result > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // get items by id
    public function all_item()
    {
        $sql = $this->db->select("i.item_id,
i.item_name,
i.sub_product,
i.brand,
i.hsn_no,
i.category_id,
i.gstn_rate,
i.flag,
i.purchase_rate")
            ->FROM('item AS i')
           // ->where('i.category_id = c.category_id')
            //->where('i.item_id = i.item_id')
			//->where('c.category_id = s.category_id')
            //->where('i.category_id = c.category_id')
            ->get();

        return $sql->result();
    }
	
	// get items by category
	 public function item_cat()
    {
        $sql = $this->db->select("i.item_id,
i.item_name,
i.sub_product,
i.brand,
i.hsn_no,
i.category_id,
i.gstn_rate,
i.flag,
i.purchase_rate,
c.category_name,
s.stock_no,
s.item_id,
s.stock_qty,
s.purchase_rate,
s.stock_rate,
c.category_id,
s.category_id")
            ->FROM('item AS i,category as c, stock as s')
            ->where('i.category_id = c.category_id')
            ->where('s.item_id = i.item_id')->where('c.category_id = s.category_id')
            ->where('i.category_id = c.category_id')
            ->get();

        return $sql->result();
    }

    // get max sales no
    public function get_sales_max()
    {
        $this->db->select_max('sales_no');
        $q = $this->db->get('sales');
        $data = $q->row();
        return $data;
    }
	// get max sales no
    public function get_salesreturn_max()
    {
        $this->db->select_max('return_no');
        $q = $this->db->get('sales_return');
        $data = $q->row();
        return $data;
    }
	
	
// get purchased product bu id
    public function get_this_item_qty($item_id)
    {
        $sql = $this->db->query("SELECT
 stock_qty  
FROM
stock WHERE item_id=$item_id
");
        return $sql->row();
    }
	
    // get purchased product bu id
    public function get_purchased($item_id)
    {
        $sql = $this->db->query("SELECT
item.item_id,
item.item_name,
item.gstn_rate,
item.sub_product,
item.flag,
item.brand 
FROM
item WHERE item.item_id=$item_id
");
        return $sql->row();
    }
	
	// get purchased product bu id
    public function get_procure($item_id)
    {
        $sql = $this->db->query("SELECT
item.item_id,
item.item_name,
item.gstn_rate,
item.flag,
item.brand,
item.sub_product
FROM
item WHERE item.item_id=$item_id
");
        return $sql->row();
    }
	
	

    // get product details via ajax
    public function get_product_details_v2($item_id)
    {
        $sql = $this->db->query("SELECT
item.item_id,
item.item_name,
item.gstn_rate,
item.hsn_no,
item.flag,
item.brand,
item.sub_product,
stock.stock_no,
stock.stock_qty,
stock.purchase_rate,
stock.stock_rate
FROM
item
INNER JOIN stock ON stock.item_id = item.item_id 
WHERE item.item_id=$item_id
");
        // echo $this->db->last_query();
        return $sql->row();
    }

    // get sales history
    public function getSales_history($sales_id)
    {

        $query = $this->db->query("SELECT * FROM `sales`
                    join `sales_detail` on `sales_detail`.`sales_no`=`sales`.`sales_no`
                    join `item` on `item`.`item_id` = `sales_detail`.`item_id`
                    join `mechanic` on `mechanic`.`mechanic_id`= `sales`.`mechanic_id`
                    where `sales`.`sales_no`=$sales_id
");
        //echo $this->db->last_query();
        return $query->result();
    }
	
	
	
	// get sales history
    public function getSalesreturn_history($sales_id)
    {

        $query = $this->db->query("SELECT * FROM `sales_return`
                    join `sales_return_detail` on `sales_return_detail`.`return_no`=`sales_return`.`return_no`
                    join `item` on `item`.`item_id` = `sales_return_detail`.`item_id`
                    join `mechanic` on `mechanic`.`mechanic_id`= `sales_return`.`mechanic_id`
                    where `sales_return`.`return_no`=$sales_id
");
        //echo $this->db->last_query();
        return $query->result();
    }
	
	
	

    /*==== GET EMAIL SETTINGS ====*/
    public function getEmailSettings()
    {
        return $this->db->select('*')->from('email_settings')->WHERE('id', 1)->get()->row();
    }

    // check stock
    public function check_stock_record($item)
    {
        $query = $this->db->select('*');
        $this->db->from('stock');
        $this->db->where('item_id', $item);
       // $this->db->where('category_id', $category);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // get stock quantity
    public function get_stock_qty($item)
    {
        $this->db->select('*');
        $this->db->from('stock');
        $this->db->where('item_id', $item);
       // $this->db->where('category_id', $category);
        $query = $this->db->get();
        return $query->row();

    }
	
	
	
	
	///////////////////FOR RETURNS
	
	
	// check stock
    public function check_returnstock_record($item)
    {
        $query = $this->db->select('*');
        $this->db->from('stock');
        $this->db->where('item_id', $item);
        //$this->db->where('category_id', $category);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // get stock quantity
    public function get_returnstock_qty($item)
    {
        $this->db->select('*');
        $this->db->from('stock');
        $this->db->where('item_id', $item);
        //$this->db->where('category_id', $category);
        $query = $this->db->get();
        return $query->row();

    }
	
	////////////////////END FOR RETURNS

	
	
	
	 public function check_allprocure_inward($procure_no)
    {
        $this->db->select('*');
        $this->db->from('procure');
        $this->db->where('inward_status', 0);
        $this->db->where('procure_no', $procure_no);
        $query = $this->db->get();
        return $query->num_rows();

    }
	
	
	
	public function select_procures()
    {
        $query = $this->db->select("
procure_company.procure_no,
procure_company.procure_date,
procure_company.vendor_id,
procure_company.procure_status,
vendor.vendor_id,
vendor.vendor_name,
usr_user.USER_NAME,
procure_company.grand_total,procure_company.due_amount")
            ->from('vendor,procure_company, usr_user')
            ->where('procure_company.vendor_id = vendor.vendor_id')
            ->where('usr_user.USER_ID` = procure_company.procure_user_id')->get();
			
        return $query->result();
    }
    // get all purchases
    public function select_purchases()
    {
        $query = $this->db->select("
purchase_company.purchase_no,
purchase_company.purchase_date,
purchase_company.vendor_id,
purchase_company.bill_picture,
vendor.vendor_id,
vendor.vendor_name,
usr_user.USER_NAME,
purchase_company.grand_total,purchase_company.due_amount")
            ->from('vendor,purchase_company, usr_user')
            ->where('purchase_company.vendor_id = vendor.vendor_id')
            ->where('usr_user.USER_ID` = purchase_company.purchase_user_id')->get();
			
        return $query->result();
    }

    // get maximum purchase no
    public function get_purchase_max()
    {
        $this->db->select_max('purchase_no');
        $q = $this->db->get('purchase_company');
        $data = $q->row();
        return $data;
    }
	
	// get maximum purchase no
    public function get_procure_max()
    {
        $this->db->select_max('procure_no');
        $q = $this->db->get('procure_company');
        $data = $q->row();
        return $data;
    }
	
	// get max purchase id
    public function get_procure_max1()
    {
        $this->db->select_max('procure_id');
        $q = $this->db->get('procure');
        $data = $q->row();
        return $data;
    }

    // get max purchase id
    public function get_purchase_max1()
    {
        $this->db->select_max('purchase_id');
        $q = $this->db->get('purchase');
        $data = $q->row();
        return $data;
    }

    // get history of purchases
    public function get_purchaseHistory($purchaseNO)
    {
        $this->db->select('purchase.purchase_no,
purchase.purchase_qty,
purchase.purchase_amount,
item.item_id,
item.item_name,
item.sub_product,
item.brand,
vendor.vendor_id,
vendor.vendor_name,
purchase.purchase_id,
purchase.purchase_qty,
purchase.purchase_amount,
stock.purchase_rate,
stock.stock_rate as sales_rate,
purchase_company.purchase_date,
purchase_company.purchase_amount_total,
purchase_company.vendor_id,
`purchase_company`.`due_amount`,
`purchase_company`.`grand_total`')
            ->from('item,stock,purchase,purchase_company,vendor')
            ->where('item.item_id = purchase.item_id')
			->where('item.item_id = stock.item_id')
            ->where('purchase_company.purchase_no=purchase.purchase_no')
            ->where('purchase_company.vendor_id=vendor.vendor_id')
            ->where('purchase.purchase_no', $purchaseNO);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
	
	
	
	
	
	
	
	
	public function get_procureHistory($procureNO)
    {
        $this->db->select('procure.procure_no,
procure.procure_qty,
procure.procure_amount,
item.item_id,
item.item_name,
item.sub_product,
item.brand,
vendor.vendor_id,
vendor.vendor_name,
city.cityname,
channel.channelname,
procure.procure_id,
procure.procure_qty,
procure.procure_amount, 
procure_company.procure_date,
procure_company.procure_amount_total,
procure_company.vendor_id,
procure_company.due_amount,
procure_company.grand_total')
            ->from('item,procure,procure_company,vendor,city,channel')
            ->where('item.item_id = procure.item_id')
			//->where('item.item_id = stock.item_id')
            ->where('procure_company.procure_no=procure.procure_no')
            ->where('procure_company.vendor_id=vendor.vendor_id')
			->where('procure_company.city_id=city.city_id')
			->where('procure_company.channel_id=channel.channel_id')
            ->where('procure.procure_no', $procureNO);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
	
	

    // get items
    public function items($item)
    {
        $sql = $this->db->select("
i.item_id,
i.item_name,
i.sub_product,
i.brand,
i.hsn_no,
i.category_id,
i.gstn_rate,
i.flag,
i.purchase_rate,
c.category_name,
s.stock_no,
s.item_id,
s.stock_qty,
s.purchase_rate,
s.stock_rate,
c.category_id,
s.category_id")
            ->from('item AS i, stock as s')
            //->where('i.category_id = c.category_id')
            ->where('s.item_id = i.item_id')
			//->where('c.category_id = s.category_id')
            ->where('i.category_id = c.category_id')
            ->where("i.item_id = '$item'")->get();
        return $sql->row();
    }

    // get item wise stock
    public function stock_item()
    {
        $query = $this->db->select("i.item_id,
i.item_name,
i.sub_product,
i.brand,
i.hsn_no, 
i.gstn_rate, 
s.stock_no,
s.item_id,
s.stock_qty,
s.purchase_rate,
s.stock_rate")->FROM('stock as s,item as i')
            ->WHERE('s.item_id=i.item_id')->get();
            //->where('s.category_id=i.category_id')
            //->where("i.category_id=c.category_id")
        return $query->result();
    }
	
	// get category wise stock
    public function stock_cat()
    {
        $query = $this->db->select()->FROM('stock as s,item as i, category as c')
            ->WHERE('s.item_id=i.item_id')
            ->where('s.category_id=i.category_id')
            ->where("i.category_id=c.category_id")->get();
        return $query->result();
    }

    // get current day invoices
    public function today_invoices()
    {
        $to_date = date('Y-m-d');
        $query = $this->db->select('COUNT(*) as count')->from('sales')
            ->where('sales_date', $to_date)->get()->row();
        return $query;
    }

    // get current month invoices
    public function thisMonth_invoices()
    {
        $to_date = date('m');
        $query = $this->db->select('COUNT(*) as count')->from('sales')
            ->where('MONTH(sales_date)', $to_date)->get()->row();
        return $query;
    }

    // get daily sales for dashboard
    public function daily_dash_board_sales($today)
    {
        $this->db->select('sales_date');
        $this->db->select_sum('sales_amount_total');
        $this->db->from('sales');
        $this->db->where('sales_status', "1");
        $this->db->where('sales_date', $today);
        $this->db->group_by("sales_date");
        $this->db->order_by("sales.sales_no", "DESC");
        $query = $this->db->get();
		
		if(!empty($query)) {
               $results = $query->result();
               return  $results;
            }
            else{
                 return false;
            }
		
      //  return $query->result();
    }

    // get daily sales
    public function get_daily_sales()
    {

        $this->db->select('sales_date');
        $this->db->select_sum('sales_amount_total');
        $this->db->from('sales');
        $this->db->where('sales_status', "1");
        $this->db->limit(5);
        $this->db->group_by("sales_date");
        $this->db->order_by("sales.sales_no", "DESC");
        $query = $this->db->get();

        return $query->result();
    }

    // get recent purchases
    public function recent_purchases()
    {
        $query = $this->db->select('purchase_company.purchase_no,
purchase_company.purchase_date,
purchase_company.vendor_id,
vendor.vendor_id,
vendor.vendor_name,
usr_user.USER_NAME,
purchase_company.grand_total')->from('vendor, purchase_company,usr_user')
            ->where('purchase_company.vendor_id = vendor.vendor_id')
            ->where('usr_user.USER_ID = purchase_company.purchase_user_id')
            ->order_by('purchase_company.purchase_no', 'DESC')->get();
        return $query->result();
    }
	
	
	
	
	// get recent purchases
    public function recent_procures()
    {
        $query = $this->db->select('procure_company.procure_no,
procure_company.procure_date,
procure_company.vendor_id,
vendor.vendor_id,
vendor.vendor_name,
usr_user.USER_NAME,
procure_company.grand_total')->from('vendor, procure_company,usr_user')
            ->where('procure_company.vendor_id = vendor.vendor_id')
            ->where('usr_user.USER_ID = procure_company.procure_user_id')
            ->order_by('procure_company.procure_no', 'DESC')->get();
        return $query->result();
    }
	
	
	

    // get daily stock
    public function get_daily_stock()
    {
        $this->db->select('*');
        $this->db->from('stock');
        $this->db->join('item', 'stock.item_id = item.item_id');
        $this->db->limit(10);
        $this->db->order_by("stock.stock_qty", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    // get date wise purchases
    public function purchases($start_date1, $end_date1)
    {
        $query = $this->db->query("SELECT pc.purchase_date, SUM(pc.purchase_amount_total) AS purchase_amount_total,
SUM(p.purchase_qty) AS qty, pc.grand_total,pc.pur_no
FROM purchase_company AS pc, purchase AS p
WHERE pc.purchase_status =  '1'
AND pc.purchase_date BETWEEN '$start_date1' AND '$end_date1'
AND pc.purchase_no = p.purchase_no
GROUP BY pc.purchase_date
ORDER BY pc.purchase_no DESC");
///echo $this->db->last_query();
        return $query->result();
    }
	
public function procures($start_date1, $end_date1)
    {
        $query = $this->db->query("SELECT pc.procure_date, SUM(pc.procure_amount_total) AS procure_amount_total,
SUM(p.procure_qty) AS qty, pc.grand_total,pc.proc_no
FROM procure_company AS pc, procure AS p
WHERE pc.procure_status =  '1'
AND pc.procure_date BETWEEN '$start_date1' AND '$end_date1'
AND pc.procure_no = p.procure_no
GROUP BY pc.procure_date
ORDER BY pc.procure_no DESC");
///echo $this->db->last_query();
        return $query->result();
    }
    // get date wise sales
    public function getSales($start_date1, $end_date1)
    {
        $query = $this->db->query("SELECT 
  pc.sales_date,
  SUM(pc.sales_amount_total) AS sales_amount_total,
  SUM(p.sales_qty) AS sales_qty,
  pc.grand_total,
  pc.invoice_no,
  st.`purchase_rate`,st.`stock_rate`, i.`item_name`,p.sales_no
FROM
  sales AS pc,
  sales_detail AS p,stock AS st,item AS i 
WHERE pc.sales_status = '1' 
  AND pc.sales_date BETWEEN '$start_date1' 
  AND '$end_date1' 
  AND pc.sales_no = p.sales_no
  AND st.`item_id` = p.`item_id` 
  AND i.`item_id` = p.`item_id`
  AND i.`item_id` = st.`item_id`
GROUP BY pc.sales_date 

ORDER BY pc.sales_no DESC ")->result();
        return $query;
    }

    // get sale details by sale id
    public function getSale_Details($id)
    {
        $query = $this->db->select()
            ->from('sales as s,mechanic as c')
            ->where("sales_no", $id)
            ->where('s.mechanic_id=c.mechanic_id')
            //->where('s.company_id = co.company_id')
            ->get();
        return $query->row();

    }
	
	
	
	// get sale details by sale id
    public function getSalereturn_Details($id)
    {
        $query = $this->db->select()
            ->from('sales_return as s,mechanic as c')
            ->where("return_no", $id)
            ->where('s.mechanic_id=c.mechanic_id')
            //->where('s.company_id = co.company_id')
            ->get();
        return $query->row();

    }
	
	

    // get invoice by dates
    public function get_invoice_by_date($start_date, $end_date)
    {
        $this->db->select('sales.*', false);
        // $this->db->select('sales_detail.*', false);
        $this->db->from('sales');
        //$this->db->join('sales_detail', 'sales_detail.sales_no  =  sales.sales_no', 'left');
        if ($start_date == $end_date) {
            $this->db->like('sales.sales_date', $start_date);
        } else {
            $this->db->where('sales.sales_date >=', $start_date);
            $this->db->where('sales.sales_date <=', $end_date);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }
	public function get_stocktrans_by_date($start_date,$end_date){
	 	
		$this->db->select('stock_trans.*,item.item_name, 
item.sub_product, 
item.brand');
        // $this->db->select('sales_detail.*', false);
        $this->db->from('stock_trans');
        $this->db->join('item', 'item.item_id  =  stock_trans.item_id', 'left');
        if ($start_date == $end_date) {
            $this->db->like('stock_trans.date', $start_date);
        } else {
            $this->db->where('stock_trans.date >=', $start_date);
            $this->db->where('stock_trans.date <=', $end_date);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
	}
	 public function get_stocktransitemdetails($item_id)
    {
        $sql = $this->db->query("SELECT
item.item_id,
item.item_name,
item.gstn_rate,
item.sub_product,
item.flag,
item.brand 
FROM
item WHERE item.item_id=$item_id
");
        return $sql->row();
    }
	public function get_purchase_by_date($start_date,$end_date){
	 $this->db->select('purchase_company.*', false);
        // $this->db->select('sales_detail.*', false);
        $this->db->from('purchase_company');
        //$this->db->join('sales_detail', 'sales_detail.sales_no  =  sales.sales_no', 'left');
        if ($start_date == $end_date) {
            $this->db->like('purchase_company.purchase_date', $start_date);
        } else {
            $this->db->where('purchase_company.purchase_date >=', $start_date);
            $this->db->where('purchase_company.purchase_date <=', $end_date);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
	}
	public function get_purchase_item_detail($purchase_no)
    {
        $query = $this->db->select()->from('purchase as sd,item as i, stock as s')
            ->where('sd.item_id = i.item_id')
            ->where('s.item_id = i.item_id')
            ->where($purchase_no)
            ->get();
        //echo $this->db->last_query();
        return $query->result();
    }
	public function get_invoice_by_date1($start_date, $end_date)
    {
        $this->db->select('purchase_company.*', false);
        // $this->db->select('sales_detail.*', false);
        $this->db->from('purchase_company');
        //$this->db->join('sales_detail', 'sales_detail.sales_no  =  sales.sales_no', 'left');
        if ($start_date == $end_date) {
            $this->db->like('purchase_company.purchase_date', $start_date);
        } else {
            $this->db->where('purchase_company.purchase_date >=', $start_date);
            $this->db->where('purchase_company.purchase_date <=', $end_date);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    // get sales detail by sales no
    public function sales_detail($sales_no)
    {
        $query = $this->db->select()->from('sales_detail as sd,item as i, stock as s')
            ->where('sd.item_id = i.item_id')
            ->where('s.item_id = i.item_id')
            ->where($sales_no)
            ->get();
        //echo $this->db->last_query();
        return $query->result();
    }
	public function p_detail($sales_no)
    {
        $query = $this->db->select()->from('purchase as sd,item as i, stock as s')
            ->where('sd.item_id = i.item_id')
            ->where('s.item_id = i.item_id')
            ->where($sales_no)
            ->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    // get top sales
    public function topsales()
    {
        $this->db->select("c.`item_name`,c.item_id");
        $this->db->select_sum("s.sales_qty")
            ->from('sales_detail AS s,item AS c')
            ->WHERE('s.item_id = c.item_id')
            ->GROUP_BY('c.item_id')
            ->ORDER_BY('s.sales_qty', 'DESC')
            ->LIMIT(5);
        $query = $this->db->get();
		
		if(!empty($query)) {
               $results = $query->result();
               return  $results;
            }
            else{
                 return false;
            }
		
       // return $query;
    }

    // get top sales of year
    public function topSalesYear()
    {
        $date = date('Y-m-d');
        $this->db->select("c.item_name,
  c.item_id,
  YEAR(ss.sales_date)");
        $this->db->select_sum('s.sales_qty');
        $this->db->from('sales_detail AS s,
  sales AS ss,
  item AS c');
        $this->db->where('s.item_id = c.item_id');
        $this->db->where("YEAR(ss.`sales_date`) = YEAR(DATE('$date'))");
        $this->db->where('s.sales_no = ss.sales_no');

        $this->db->GROUP_BY('c.item_id');
        $this->db->ORDER_BY('s.sales_qty', 'DESC');
        $this->db->LIMIT(5);
        $query = $this->db->get();
        
		if(!empty($query)) {
               $results = $query->result();
               return  $results;
            }
            else{
                 return false;
            }
		
		//return $query;
    }
	
	
	
	
	// INSURANCE FUNCTIONS _ 
	
	// get all survey items
    public function all_survey()
    {
        $sql = $this->db->select("survey.id,
		survey.name,
		survey.mobile,
		survey.email,
		survey.address,
		survey.make,
		survey.model,
		survey.yom,
		survey.color,
		survey.regno,
		survey.km,
		survey.v_address,
		survey.engine_no,
		survey.chasis_no,
		survey.created_on,
		survey.created_by,
		survey.gic,
		survey.claim_no,
		survey.city,
		survey.surveyed_on,
		survey.surveyor_id,
		survey.customer_repair,
		survey.status,
		vehicle_make.make_name,
		vehicle_model.model_name,
		gic.GIC_NAME,
		city.cityname,
		usr_user.USER_NAME")
            ->FROM('survey')
            ->join('vehicle_make' , 'survey.make = vehicle_make.make_id')
            ->join('vehicle_model' , 'survey.model = vehicle_model.model_id')
			->join('gic' , 'survey.gic = gic.GIC_ID')
            ->join('city' , 'survey.city = city.city_id')		
			->join('usr_user' , 'survey.created_by = usr_user.USER_ID')
            ->get();
 
        return $sql->result();
    }
	
	 public function get_insuredmobile($cid){
		 $sql = $this->db->query("SELECT
 mobile
FROM
claims WHERE id=$cid
");
        return $sql->row();
	 }
	// get all survey items
    public function all_claims()
    {
        $sql = $this->db->select("claims.id,
		claims.name,
		claims.mobile,
		claims.email,
		claims.address,
		claims.make,
		claims.model,
		claims.yom,
		claims.color,
		claims.regno,
		claims.km,
		claims.v_address,
		claims.engine_no,
		claims.chasis_no,
		claims.created_on,
		claims.created_by,
		claims.gic,
		claims.claim_no,
		claims.city, 
		claims.active,
		claims.close_type,
		claim_status.status,
		claim_status.stage, 
		gic.GIC_NAME,
		city.cityname,
		usr_user.USER_NAME")
            ->FROM('claims')
           	 ->join('claim_status' , 'claims.id = claim_status.claim_id') 
			->join('gic' , 'claims.gic = gic.GIC_ID')
            ->join('city' , 'claims.city = city.city_id')		
			->join('usr_user' , 'claims.created_by = usr_user.USER_ID')
			->order_by("claims.id", "DESC")
            ->get();
 
        return $sql->result();
    }
	
	
	//INSURANCE FUNCTIONS END _
	
	// STATUS BASED BOOKINGS LIST
	function getBookingItems($postData=null, $bkTypeRaw){

     $response = array();
		 
		
		if($bkTypeRaw=='New'){
			$bkType = 'New Booking';
			$newclause = '';
		}elseif($bkTypeRaw=='UnapprovedJobcard'){
			$bkType = 'Ongoing';
			$newclause = 'Unapproved';
		}else{
			$bkType = $bkTypeRaw;
			$newclause = '';
		}
		
		
		
     ## Read value
     $draw = $postData['draw'];
     $start = $postData['start'];
     $rowperpage = $postData['length']; // Rows display per page
     $columnIndex = $postData['order'][0]['column']; // Column index
     $columnName = $postData['columns'][$columnIndex]['data']; // Column name
     $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
     $searchValue = $postData['search']['value']; // Search value

     ## Search 
     $searchQuery = "";
     if($searchValue != ''){
        $searchQuery = " (customer_channel like '%".$searchValue."%' or customer_city like '%".$searchValue."%' or booking_id like '%".$searchValue."%' or customer_name like '%".$searchValue."%' or customer_phone like '%".$searchValue."%' or service_date like '%".$searchValue."%' ) ";
     }

     ## Total number of records without filtering
     $this->db->select('count(*) as allcount');
	 $this->db->where("status = '".$bkType."'");	
     $records = $this->db->get('bookings')->result();
     $totalRecords = $records[0]->allcount;

     ## Total number of record with filtering
     $this->db->select('count(*) as allcount');
     if($searchQuery != '')
        $this->db->where($searchQuery);
	 $this->db->where("status = '".$bkType."'");		
     $records = $this->db->get('bookings')->result();
     $totalRecordwithFilter = $records[0]->allcount;

     ## Fetch records
     $this->db->select('*');
     if($searchQuery != '')
        $this->db->where($searchQuery);
	$this->db->where("status = '".$bkType."'");		
     $this->db->order_by($columnName, $columnSortOrder);
     $this->db->limit($rowperpage, $start);
     $records = $this->db->get('bookings')->result();

     $data = array();
		
     foreach($records as $record ){
		 	
		 
		 $showlist = '1';
		 
		 
		 if($newclause == 'Unapproved'){
			 
			 if($record->stage == 'Inspection Done'){
				 
				 
				 
				 $getJobcards   = $this->db->query("SELECT customer_approval FROM jobcard WHERE booking_id='".$record->booking_id."'")->row();
				 
				 if(!empty($getJobcards)){ 
					 $getJobcard_approval  = $getJobcards->customer_approval;
				 }else{
					 $getJobcard_approval  = 'No';
				 }
				 
				 if($getJobcard_approval=='No'){
					  $showlist = '1';
				 }else{
					 $showlist = '0';
				 }
			
			 }
		 }
		 
		 $getmake_name   = $this->db->query("SELECT make_name FROM vehicle_make WHERE make_id='".$record->vehicle_make."'")->row();
							$make_name  = $getmake_name->make_name;
		 
		 $getmodel_name   = $this->db->query("SELECT model_name FROM vehicle_model WHERE model_id='".$record->vehicle_model."'")->row();
							$model_name  = $getmodel_name->model_name;
		 
		 $getservice_category   = $this->db->query("SELECT service_name FROM service_category WHERE id='".$record->service_category_id."'")->row();
							$service_category  = $getservice_category->service_name;
		 
		 
						 
						$mechanicname_q  = $this->db->query("SELECT name FROM mechanic WHERE mechanic_id='".$record->assigned_mechanic."'")->row();
						if(!empty($mechanicname_q)){ 
						$mechanicname  = $mechanicname_q-> name;
							}else{
							$mechanicname  = 'Not Assigned';
						}
						 
		 if($record->stage == 'Not Started' && $record->rescheduled==1){
			$color = '<span style="color:#4a5cf2;">';
			$colorclose = '</span>'; 
		 }else{
			$color = '<span style="color:black;">';
			$colorclose = '</span>'; 
		 }

		 	if($showlist == '1'){ 
        $data[] = array( 
         "booking_no" =>  $color.$record->booking_id.$colorclose,
		 "customer_name" =>  $color.$record->customer_name.$colorclose, 
		 "customer_phone" => $color.$record->customer_phone.$colorclose, 
		 "service_date" => $color.date('d-m-Y', strtotime($record->service_date)).$colorclose, 
         "customer_area" =>  $color.$record->customer_area.$colorclose,  
         "time_slot" => $color.$record->time_slot.$colorclose, 
		 "make_name" => $color.$make_name.$colorclose, 
         "model_name" => $color.$model_name.$colorclose,
		 "customer_channel" => $color.$record->customer_channel.$colorclose, 
		 "service_category" => $color.$service_category.$colorclose, 
		"assigned_mechanic" => $color.$mechanicname.$colorclose,	
         "details"=> "<a href='".base_url()."bookings/booking_details/".$record->booking_id."' class=''><i class='fa fa-file-text'></i></a>",
        );
			}
				
				
				
				
				
     }
		
     ## Response
     $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
     );

     return $response; 
   }
	
	// ALL BOOKINGS LIST
	function getEngagementBookingItems($postData=null){

     $response = array();
		 
		
		 
		
		
		
     ## Read value
     $draw = $postData['draw'];
     $start = $postData['start'];
     $rowperpage = $postData['length']; // Rows display per page
     $columnIndex = $postData['order'][0]['column']; // Column index
     $columnName = $postData['columns'][$columnIndex]['data']; // Column name
     $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
     $searchValue = $postData['search']['value']; // Search value

     ## Search 
     $searchQuery = "";
     if($searchValue != ''){
        $searchQuery = " (customer_channel like '%".$searchValue."%' or customer_city like '%".$searchValue."%' or booking_id like '%".$searchValue."%' or customer_name like '%".$searchValue."%' or customer_phone like '%".$searchValue."%' or service_date like '%".$searchValue."%' ) ";
     }

     ## Total number of records without filtering
     $this->db->select('count(*) as allcount'); 
     $records = $this->db->get('bookings')->result();
     $totalRecords = $records[0]->allcount;

     ## Total number of record with filtering
     $this->db->select('count(*) as allcount');
     if($searchQuery != '')
        $this->db->where($searchQuery); 		
     $records = $this->db->get('bookings')->result();
     $totalRecordwithFilter = $records[0]->allcount;

     ## Fetch records
     $this->db->select('*');
     if($searchQuery != '')
        $this->db->where($searchQuery); 	
     $this->db->order_by($columnName, $columnSortOrder);
     $this->db->limit($rowperpage, $start);
     $records = $this->db->get('bookings')->result();

     $data = array();
		
     foreach($records as $record ){
		 	
		 
		 
		 
		 
		 
		 $getmake_name   = $this->db->query("SELECT make_name FROM vehicle_make WHERE make_id='".$record->vehicle_make."'")->row();
							$make_name  = $getmake_name->make_name;
		 
		 $getmodel_name   = $this->db->query("SELECT model_name FROM vehicle_model WHERE model_id='".$record->vehicle_model."'")->row();
							$model_name  = $getmodel_name->model_name;
		 
		 $getservice_category   = $this->db->query("SELECT service_name FROM service_category WHERE id='".$record->service_category_id."'")->row();
							$service_category  = $getservice_category->service_name;
		 
		 
						 
						$mechanicname_q  = $this->db->query("SELECT name FROM mechanic WHERE mechanic_id='".$record->assigned_mechanic."'")->row();
						if(!empty($mechanicname_q)){ 
						$mechanicname  = $mechanicname_q-> name;
							}else{
							$mechanicname  = 'Not Assigned';
						}
						 

		 	 
        $data[] = array( 
         "booking_no" =>  $record->booking_id,
		 "customer_name" =>  $record->customer_name, 
		 "customer_phone" => $record->customer_phone, 
		 "service_date" => date('d-m-Y', strtotime($record->service_date)), 
         "customer_area" =>  $record->customer_area,  
         "time_slot" => $record->time_slot, 
		 "make_name" => $make_name, 
         "model_name" => $model_name,
		 "customer_channel" => $record->customer_channel, 
		 "service_category" => $service_category, 
		"assigned_mechanic" => $mechanicname,	
         "details"=> "<a href='".base_url()."bookings/engagement_resources/".$record->booking_id."' class=''><i class='fa fa-file-text'></i></a>",
        );
			 
				
				
				
				
				
     }
		
     ## Response
     $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
     );

     return $response; 
   }
	
	
	 
	// STATUS BASED BOOKINGS LIST
	function getBookingInvoices($postData=null, $bkTypeRaw){

     $response = array();
		 
		
		if($bkTypeRaw=='New'){
			$bkType = 'New Booking';
			$newclause = '';
		}elseif($bkTypeRaw=='UnapprovedJobcard'){
			$bkType = 'Ongoing';
			$newclause = 'Unapproved';
		}else{
			$bkType = $bkTypeRaw;
			$newclause = '';
		}
		
		
		
     ## Read value
     $draw = $postData['draw'];
     $start = $postData['start'];
     $rowperpage = $postData['length']; // Rows display per page
     $columnIndex = $postData['order'][0]['column']; // Column index
     $columnName = $postData['columns'][$columnIndex]['data']; // Column name
     $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
     $searchValue = $postData['search']['value']; // Search value

     ## Search 
     $searchQuery = "";
     if($searchValue != ''){
        $searchQuery = " (customer_city like '%".$searchValue."%' or booking_id like '%".$searchValue."%' or customer_name like '%".$searchValue."%' or customer_phone like '%".$searchValue."%' or service_date like '%".$searchValue."%' ) ";
     }

     ## Total number of records without filtering
     $this->db->select('count(*) as allcount');
	 $this->db->where("status = '".$bkType."'");	
     $records = $this->db->get('bookings')->result();
     $totalRecords = $records[0]->allcount;

     ## Total number of record with filtering
     $this->db->select('count(*) as allcount');
     if($searchQuery != '')
        $this->db->where($searchQuery);
	 $this->db->where("status = '".$bkType."'");		
     $records = $this->db->get('bookings')->result();
     $totalRecordwithFilter = $records[0]->allcount;

     ## Fetch records
     $this->db->select('*');
     if($searchQuery != '')
        $this->db->where($searchQuery);
	$this->db->where("status = '".$bkType."'");		
     $this->db->order_by($columnName, $columnSortOrder);
     $this->db->limit($rowperpage, $start);
     $records = $this->db->get('bookings')->result();

     $data = array();
		
     foreach($records as $record ){
		 	
		 
		 $showlist = '1';
		 
		  $booking_pay   = $this->db->query("SELECT * FROM booking_payments WHERE booking_id='".$record->booking_id."'")->row();
		 
		 if(!empty($booking_pay->payment_status) && $booking_pay->payment_status='Paid'){ 
		 
			 if($newclause == 'Unapproved'){
			 
			 if($record->stage == 'Inspection Done'){
				 
				 
				 
				 $getJobcards   = $this->db->query("SELECT customer_approval FROM jobcard WHERE booking_id='".$record->booking_id."'")->row();
				 
				 if(!empty($getJobcards)){ 
					 $getJobcard_approval  = $getJobcards->customer_approval;
				 }else{
					 $getJobcard_approval  = 'No';
				 }
				 
				 if($getJobcard_approval=='No'){
					  $showlist = '1';
				 }else{
					 $showlist = '0';
				 }
			
			 }
		 }
		 
		 $getmake_name   = $this->db->query("SELECT make_name FROM vehicle_make WHERE make_id='".$record->vehicle_make."'")->row();
							$make_name  = $getmake_name->make_name;
		 
		 $getmodel_name   = $this->db->query("SELECT model_name FROM vehicle_model WHERE model_id='".$record->vehicle_model."'")->row();
							$model_name  = $getmodel_name->model_name;
		 
		 $getservice_category   = $this->db->query("SELECT service_name FROM service_category WHERE id='".$record->service_category_id."'")->row();
							$service_category  = $getservice_category->service_name;
		 
		 
							 
						 
						$mechanicname_q  = $this->db->query("SELECT name FROM mechanic WHERE mechanic_id='".$record->assigned_mechanic."'")->row();
						if(!empty($mechanicname_q)){ 
						$mechanicname  = $mechanicname_q-> name;
							}else{
							$mechanicname  = 'Not Assigned';
						}
						 

		 	if($showlist == '1'){ 
        $data[] = array( 
         "booking_id" =>  $record->booking_id,
		 "customer_name" =>  $record->customer_name, 
		 "customer_phone" => $record->customer_phone, 
		// "service_date" => date('d-m-Y', strtotime($record->service_date)), 
         "customer_area" =>  $record->customer_area,  
         "payment_date" => date('d-m-Y', strtotime($booking_pay->payment_date)), 
		 "payment_mode" => $booking_pay->payment_mode, 
         "payment_amount" => $booking_pay->total_amount,
		 "customer_channel" => $record->customer_channel, 
		 "service_category" => $service_category,  
         "details"=> "<a href='".base_url()."api/invoices/".$record->booking_id."' target='_blank' class='text-sucess'><i class='fa fa-paper-plane'></i></a>",
        );
			}
				
				
	 }
				
				
     }
		
     ## Response
     $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
     );

     return $response; 
   }
	
	public function Thisbooking_CheckRS_PaymentStatus($rz_payment_id){ 
			$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payment_links/'.$rz_payment_id);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "rzp_live_8UbYFNwis1oK8D:4zHnXIzYfc3lHHoCCBM76hx6"); 
    $data = curl_exec($ch);
    if (empty($data) OR (curl_getinfo($ch, CURLINFO_HTTP_CODE != 200))) {
       $data = FALSE;
    } else {
        //return json_decode($data, TRUE);
		$rs_data = json_decode($data, TRUE);
    }
    curl_close($ch); 
		if(!empty($rs_data['status'])){ 
		if($rs_data['status'] == 'paid'){ 
		    $response['payment_status'] = $rs_data['status'];
			$response['amount_collected'] = $rs_data['amount_paid'];
			$response['payment_mode'] = $rs_data['payments'][0]['method'];
			$response['payment_date'] = date('Y-m-d', $rs_data['payments'][0]['created_at']);
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS END
		}else{ 
			$response['payment_status'] = $rs_data['status'];
			$response['amount_collected'] = '';
			$response['payment_mode'] = '';
			$response['payment_date'] = '';
		}
	}else{ 
		    $response['payment_status'] = 'No payment processed';
			$response['amount_collected'] = '';
			$response['payment_mode'] = '';
			$response['payment_date'] = '';
		}
  echo json_encode($response); 
       }
	
	
	function getCustomers($postData=null){

     $response = array();
		 
		
     ## Read value
     $draw = $postData['draw'];
     $start = $postData['start'];
     $rowperpage = $postData['length']; // Rows display per page
     $columnIndex = $postData['order'][0]['column']; // Column index
     $columnName = $postData['columns'][$columnIndex]['data']; // Column name
     $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
     $searchValue = $postData['search']['value']; // Search value

     ## Search 
     $searchQuery = "";
     if($searchValue != ''){
        $searchQuery = " (customer_name like '%".$searchValue."%' or  phone like '%".$searchValue."%' or alternate_no like '%".$searchValue."%' ) ";
     }

     ## Total number of records without filtering
     $this->db->select('count(*) as allcount'); 
     $records = $this->db->get('customer')->result();
     $totalRecords = $records[0]->allcount;

     ## Total number of record with filtering
     $this->db->select('count(*) as allcount');
     if($searchQuery != '')
        $this->db->where($searchQuery); 		
     $records = $this->db->get('customer')->result();
     $totalRecordwithFilter = $records[0]->allcount;

     ## Fetch records
     $this->db->select('*');
     if($searchQuery != '')
        $this->db->where($searchQuery); 
     $this->db->order_by($columnName, $columnSortOrder);
     $this->db->limit($rowperpage, $start);
     $records = $this->db->get('customer')->result();

     $data = array();
		
     foreach($records as $record ){
		 	 
        $data[] = array( 
         "customer_id" =>  $record->customer_id,
		 "customer_name" =>  $record->customer_name, 
		 "phone" => $record->phone, 
		 "alternate_no" => $record->alternate_no, 
		"email" => $record->email, 	
         "area" =>  $record->area,  
         "city" => $record->city,  
		 "channel" => $record->channel,  
         "details"=> "<a href='".base_url()."customer/customer_details/".$record->customer_id."' class=''><i class='fa fa-file-text'></i></a>",
        );
			 
		 
     }
		
     ## Response
     $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
     );

     return $response; 
   }
	
	// STATUS BASED BOOKINGS LIST
	function getCampBookingItems($postData=null, $bkTypeRaw, $camp_no){

        $response = array();
            
           
           if($bkTypeRaw=='New'){
               $bkType = 'New Booking';
               $newclause = '';
           }elseif($bkTypeRaw=='UnapprovedJobcard'){
               $bkType = 'Ongoing';
               $newclause = 'Unapproved';
           }else{
               $bkType = $bkTypeRaw;
               $newclause = '';
           }
           
           
           
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
   
        ## Search 
        $searchQuery = "";
        if($searchValue != ''){
           $searchQuery = " (customer_name like '%".$searchValue."%' or customer_phone like '%".$searchValue."%' or service_date like '%".$searchValue."%' ) ";
        }
   
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->where("status = '".$bkType."'");
        if(isset($camp_no) && $camp_no != null)
        {
           $this->db->where("camp_id = '".$camp_no."'");
        }	
        $records = $this->db->get('bookings')->result();
        $totalRecords = $records[0]->allcount;
   
        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if($searchQuery != '')
           $this->db->where($searchQuery);
        $this->db->where("status = '".$bkType."'");
        if(isset($camp_no) && $camp_no != null)
        {
           $this->db->where("camp_id = '".$camp_no."'");
        }		
        $records = $this->db->get('bookings')->result();
        $totalRecordwithFilter = $records[0]->allcount;
   
        ## Fetch records
        $this->db->select('*');
        if($searchQuery != '')
           $this->db->where($searchQuery);
           $this->db->where("status = '".$bkType."'");	
           if(isset($camp_no) && $camp_no != null)
           {
               $this->db->where("camp_id = '".$camp_no."'");
           }	
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('bookings')->result();
   
        $data = array();
           
        foreach($records as $record ){
                
            
            $showlist = '1';
            
            
            if($newclause == 'Unapproved'){
                
                if($record->stage == 'Inspection Done'){
                    
                    
                    
                    $getJobcards   = $this->db->query("SELECT customer_approval FROM jobcard WHERE booking_id='".$record->booking_id."'")->row();
                    
                    if(!empty($getJobcards)){ 
                        $getJobcard_approval  = $getJobcards->customer_approval;
                    }else{
                        $getJobcard_approval  = 'No';
                    }
                    
                    if($getJobcard_approval=='No'){
                         $showlist = '1';
                    }else{
                        $showlist = '0';
                    }
               
                }
            }
            
            $getmake_name   = $this->db->query("SELECT make_name FROM vehicle_make WHERE make_id='".$record->vehicle_make."'")->row();
                               $make_name  = $getmake_name->make_name;
            
            $getmodel_name   = $this->db->query("SELECT model_name FROM vehicle_model WHERE model_id='".$record->vehicle_model."'")->row();
                               $model_name  = $getmodel_name->model_name;
            
            $getservice_category   = $this->db->query("SELECT service_name FROM service_category WHERE id='".$record->service_category_id."'")->row();
                               $service_category  = $getservice_category->service_name;
            
            
                            
                           $mechanicname_q  = $this->db->query("SELECT name FROM mechanic WHERE mechanic_id='".$record->assigned_mechanic."'")->row();
                           if(!empty($mechanicname_q)){ 
                           $mechanicname  = $mechanicname_q-> name;
                               }else{
                               $mechanicname  = 'Not Assigned';
                           }
                            
   
                if($showlist == '1'){ 
           $data[] = array( 
            "booking_no" =>  $record->booking_id,
            "customer_name" =>  $record->customer_name, 
            "customer_phone" => $record->customer_phone, 
            "service_date" => date('d-m-Y', strtotime($record->service_date)), 
            "customer_area" =>  $record->customer_area,  
            "time_slot" => $record->time_slot, 
            "make_name" => $make_name, 
            "model_name" => $model_name,
            "customer_channel" => $record->customer_channel, 
            "service_category" => $service_category, 
           "assigned_mechanic" => $mechanicname,	
            "details"=> "<a href='".base_url()."bookings/booking_details/".$record->booking_id."' class=''><i class='fa fa-file-text'></i></a>",
           );
               }
                   
                   
                   
                   
                   
        }
           
        ## Response
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordwithFilter,
           "aaData" => $data
        );
   
        return $response; 
    }

   // STATUS BASED BOOKINGS LIST
	function getCampList($postData=null){

        $response = array();
           
           
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
   
        ## Search 
        $searchQuery = "";
        if($searchValue != ''){
           $searchQuery = " (customer_name like '%".$searchValue."%' or customer_phone like '%".$searchValue."%' or service_date like '%".$searchValue."%' ) ";
        }
   
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        // $this->db->where("status = '".$bkType."'");	
        $records = $this->db->get('camps')->result();
        $totalRecords = $records[0]->allcount;
   
        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if($searchQuery != '')
           $this->db->where($searchQuery);
        // $this->db->where("status = '".$bkType."'");		
        $records = $this->db->get('camps')->result();
        $totalRecordwithFilter = $records[0]->allcount;
   
        ## Fetch records
        $this->db->select('*');
        if($searchQuery != '')
           $this->db->where($searchQuery);
    //    $this->db->where("status = '".$bkType."'");		
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('camps')->result();
   
        $data = array();
           
        foreach($records as $record ){
                
            
            $showlist = '1';
            
              if(!empty($record->mechanics)){ 
				  
				  $eachmech = explode(',', $record->mechanics);
				  $mechanicname = '';
				  foreach($eachmech as $mech){ 
            $mechanicname_q  = $this->db->query("SELECT name FROM mechanic WHERE mechanic_id='".$mech."'")->row();
            if(!empty($mechanicname_q)){ 
            $mechanicname  .= $mechanicname_q->name. ' | ';
                } 
            
				  
				  }
				  
				  
			  }else{
   				$mechanicname  = 'Not Assigned';
			  }
			
			$salespartner_q  = $this->db->query("SELECT name FROM sales_partner WHERE sales_partner_id='".$record->sales_partner."'")->row();
            if(!empty($salespartner_q)){ 
            $salespartnername  = $salespartner_q-> name;
                }else{
                $salespartnername  = 'Not Assigned';
            }
                            
   
                if($showlist == '1'){ 
           $data[] = array( 
            "camp_no" =>  $record->camp_no,
            "sales_partner" =>  $salespartnername, 
            "society_name" => $record->society_name, 
            "camp_address" => $record->camp_address,  
            "camp_city" =>  $record->camp_city,  
            "camp_area" => $record->camp_area, 
            "camp_pincode" => $record->camp_pincode, 
            "camp_google_map" => $record->camp_google_map,
            "mechanics" => $mechanicname, 
            "camp_date" =>  date('d-m-Y', strtotime($record->camp_date)), 
           "created_on" => date('d-m-Y', strtotime($record->created_on)),	
            "details"=> "<a href='".base_url()."bookings/camp_details/".$record->camp_no."' class=''><i class='fa fa-file-text'></i></a>",
           );
               }
                   
                   
                   
                   
                   
        }
           
        ## Response
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordwithFilter,
           "aaData" => $data
        );
   
        return $response; 
      }
	
	
	
	// RZ DASHBOARD
	function getRzPaymentLinks($postData=null){

        $response = array();
           
           
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
   
        ## Search 
        $searchQuery = "";
        if($searchValue != ''){
           $searchQuery = " (bookings.booking_id like '%".$searchValue."%' or bookings.customer_name like '%".$searchValue."%' or bookings.customer_phone like '%".$searchValue."%' or bookings.customer_email like '%".$searchValue."%' or bookings.service_date like '%".$searchValue."%' ) ";
        }
   
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        // $this->db->where("status = '".$bkType."'");	
		$this->db->from('bookings');
		$this->db->join('booking_payments', 'bookings.booking_id = booking_payments.booking_id');
		$this->db->where("booking_payments.rz_payment_id != '' AND booking_payments.rz_payment_link != ''");	
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;
   
        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
		$this->db->from('bookings');
		$this->db->join('booking_payments', 'bookings.booking_id = booking_payments.booking_id');
		$this->db->where("booking_payments.rz_payment_id != '' AND booking_payments.rz_payment_link != ''");	
        if($searchQuery != '')
           $this->db->where($searchQuery);
        // $this->db->where("status = '".$bkType."'");		
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;
   
        ## Fetch records
        $this->db->select('bookings.booking_id, bookings.customer_name, bookings.customer_phone, bookings.customer_email, bookings.service_date, bookings.service_category_id, booking_payments.rz_payment_id, booking_payments.payment_status,  booking_payments.rz_payment_link, booking_payments.created_on, booking_payments.estimated_amount');
		$this->db->from('bookings');
		$this->db->join('booking_payments', 'bookings.booking_id = booking_payments.booking_id');
		$this->db->where("booking_payments.rz_payment_id != '' AND booking_payments.rz_payment_link != ''");	
        if($searchQuery != '')
           $this->db->where($searchQuery);
    //    $this->db->where("status = '".$bkType."'");		
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
   
        $data = array();
           
        foreach($records as $record ){
                
            
             $getservice_category   = $this->db->query("SELECT service_name FROM service_category WHERE id='".$record->service_category_id."'")->row();
							$service_category  = $getservice_category->service_name;
            
               
               if(!empty($record->payment_status)){ 
	 	
		 if( ($record->payment_status == 'Paid' || $record->payment_status == 'Issued') && !empty($record->rz_payment_id)){
			 
			 
			 $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payment_links/'.$record->rz_payment_id);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "rzp_live_8UbYFNwis1oK8D:4zHnXIzYfc3lHHoCCBM76hx6"); 
    $data = curl_exec($ch);
    if (empty($data) OR (curl_getinfo($ch, CURLINFO_HTTP_CODE != 200))) {
       $data = FALSE;
    } else {
        //return json_decode($data, TRUE);
		$rs_data = json_decode($data, TRUE);
    }
    curl_close($ch); 
	if(!empty($rs_data['status'])){ 
		if($rs_data['status'] == 'paid'){ 
		    $response['payment_status'] = $rs_data['status'];
			$response['amount_collected'] = ($rs_data['amount_paid']/100);  
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS END
		}else{ 
			$response['payment_status'] = $rs_data['status'];
			$response['amount_collected'] = $record->estimated_amount;
		}
	}else{ 
		    $response['payment_status'] = 'No payment processed';
			$response['amount_collected'] = $record->estimated_amount;
		}
			 
			$payment_status = $response['payment_status'];
			$amount_collected = $response['amount_collected'];
			 
			 
		 }else{
		    $payment_status = $record->payment_status;
			$amount_collected = $record->estimated_amount; 
			 
			 
			 
			 
				 
		 }
			 
		 }else{
		    $payment_status = $record->payment_status;
			$amount_collected = $record->estimated_amount;
				   
				   
		 }              
   				
			$payment_created = date('d-m-Y', strtotime($record->created_on));
                
           $dataTablesdata[] = array( 
            "booking_id" =>  $record->booking_id,
            "customer" =>  $record->customer_name.'('.$record->customer_phone . ' | '. $record->customer_email .')', 
            "service_date" => date('d-m-Y', strtotime($record->service_date)), 
            "service" => $service_category,  
            "pay_status" =>  $payment_status,  
            "invoice_amount" => $amount_collected, 
           // "created_on" => $payment_created, 
            "pay_link" => $record->rz_payment_link,
           );
              
                   
                   
                   
                   
                   
        }
           
        ## Response
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordwithFilter,
           "aaData" => $dataTablesdata
        );
   
        return $response; 
      }
	
	
	 //FEEDBACK LIST
	function getFeedback($postData=null){

        $response = array();
           
           
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
   
        ## Search 
        $searchQuery = "";
        if($searchValue != ''){
           $searchQuery = " (booking_id like '%".$searchValue."%' or feedback_date like '%".$searchValue."%') ";
        }
   
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        // $this->db->where("status = '".$bkType."'");	
        $records = $this->db->get('feedback')->result();
        $totalRecords = $records[0]->allcount;
   
        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if($searchQuery != '')
           $this->db->where($searchQuery);
        // $this->db->where("status = '".$bkType."'");		
        $records = $this->db->get('feedback')->result();
        $totalRecordwithFilter = $records[0]->allcount;
   
        ## Fetch records
        $this->db->select('*');
        if($searchQuery != '')
           $this->db->where($searchQuery);
    //    $this->db->where("status = '".$bkType."'");		
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('feedback')->result();
   
        $data = array();
           
        foreach($records as $record ){
		 
			
	 
	$feedback = '&nbsp;';
    	if(!empty($record->feedback))
        $feedback = $record->feedback;
	
		 
	  $where = array('booking_id' => $record->booking_id);
	  $bookings =$this->Main_model->single_row('bookings', $where, 's');
			
		$where2 = array('id' => $bookings['service_category_id']);
	  $service_category =$this->Main_model->single_row('service_category', $where2, 's');		
			
			$where3= array('mechanic_id' => $bookings['assigned_mechanic']);
	  $mechanic =$this->Main_model->single_row('mechanic', $where3, 's');	
			
	 $feedbackdate = date('d-m-Y', strtotime($record->feedback_date));
			
           $data[] = array( 
            "booking_id" =>  $record->booking_id,
			"customer_name" => $bookings['customer_name'], 
			"channel" => $bookings['customer_channel'], 
            "city" =>  $bookings['customer_city'], 
            "service_category" => $service_category['service_name'], 
            "rating" => $feedback,  
            "mechanic_name" =>  $mechanic['name'],  
            "details"=> "<a href='".base_url()."bookings/feedback_details/".$record->feedback_id."' class=''><i class='fa fa-file-text'></i></a>",
           );
                   
        }
        
		
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordwithFilter,
           "aaData" => $data
        );
   
        return $response; 
      }
	
	
	 //FEEDBACK LIST
	function getReferral($postData=null){

        $response = array();
           
           
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
   
        ## Search 
        $searchQuery = "";
        if($searchValue != ''){
           $searchQuery = " (booking_id like '%".$searchValue."%' or feedback_date like '%".$searchValue."%' or referral_name_1 like '%".$searchValue."%' or referral_mobile_1 like '%".$searchValue."%' or referral_name_2 like '%".$searchValue."%' or referral_mobile_2 like '%".$searchValue."%' or referral_name_3 like '%".$searchValue."%' or referral_mobile_3 like '%".$searchValue."%') ";
        }
   
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
         $this->db->where("referral_name_1 <> ''");	
        $records = $this->db->get('feedback')->result();
        $totalRecords = $records[0]->allcount;
   
        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if($searchQuery != '')
           $this->db->where($searchQuery);
        $this->db->where("referral_name_1 <> ''");		
        $records = $this->db->get('feedback')->result();
        $totalRecordwithFilter = $records[0]->allcount;
   
        ## Fetch records
        $this->db->select('*');
        if($searchQuery != '')
           $this->db->where($searchQuery);
         $this->db->where("referral_name_1 <> ''");		
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('feedback')->result();
   
        $data = array();
           
        foreach($records as $record ){
                
            
            // $showlist = '1';
        $feedbackdate = date('d-m-Y', strtotime($record->feedback_date));
            //     if($showlist == '1'){ 
           $data[] = array( 
            "booking_id" =>  $record->booking_id,
            "referral_name_1" => $record->referral_name_1, 
            "referral_name_2" =>  $record->referral_name_2,
           "referral_name_3" => $record->referral_name_3,
           "referral_mobile_1" => $record->referral_mobile_1,
            "referral_mobile_2" =>  $record->referral_mobile_2,
            "referral_mobile_3" =>  $record->referral_mobile_3,
           "feedback_date" =>  $feedbackdate,	
           );
            //    }
                   
			 
                   
                   
                   
        }
           
        ## Response
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordwithFilter,
           "aaData" => $data
        );
   
        return $response; 
      }
	
	
	 //FEEDBACK LIST
	function list_dealers_packages($postData=null){

        $response = array();
           
           
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
   		$dealers_id =  $this->session->userdata('user_id');
        ## Search 
        $searchQuery = "";
        if($searchValue != ''){
           $searchQuery = " (customer_name like '%".$searchValue."%' or customer_phone like '%".$searchValue."%' or policy_no like '%".$searchValue."%' ) ";
        }
   
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
		if($this->session->userdata('group_id') != 1){ 
        $this->db->where("dealers_id = '".$dealers_id."'");	
		}
        $records = $this->db->get('dealers_packages')->result();
        $totalRecords = $records[0]->allcount;
   
        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if($searchQuery != '')
           $this->db->where($searchQuery);
        if($this->session->userdata('group_id') != 1){ 
        $this->db->where("dealers_id = '".$dealers_id."'");	
		}	
        $records = $this->db->get('dealers_packages')->result();
        $totalRecordwithFilter = $records[0]->allcount;
   
        ## Fetch records
        $this->db->select('*');
        if($searchQuery != '')
           $this->db->where($searchQuery);
        if($this->session->userdata('group_id') != 1){ 
        $this->db->where("dealers_id = '".$dealers_id."'");	
		}			
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('dealers_packages')->result();
   
        $data = array();
           
        foreach($records as $record ){
                
            
            
        if($this->session->userdata('group_id') != 1 && $this->session->userdata('group_id') != 14){ 
        
            //     if($showlist == '1'){ 
           $data[] = array( 
            "package_id" =>  $record->package_id, 			   
            "policy_no" => $record->policy_no, 
            "insurance_company" =>  $record->gic,
           "customer_name" => $record->customer_name,
           "customer_mobile" => $record->customer_mobile,
            "created_on" =>  $record->created_on,
            "expiry_date" =>  $record->expiry_date,
           "details"=> "<a href='".base_url()."dealers/package_details/".$record->id."' class=''><i class='fa fa-file-text'></i></a>",
           );
            //    }
		}else{
			 //     if($showlist == '1'){ 
			
			$dealers_name = $this->db->query("SELECT dealers_id, name FROM dealers WHERE dealers_id = '".$record->dealers_id."'")->row();
			if(!empty($dealers_name->name)){
				$dealername = $dealers_name->name;
				$dealerID = $dealers_name->dealers_id;
			}else{
			$dealers_name = $this->db->query("SELECT * FROM usr_user WHERE USER_ID = '".$record->dealers_id."'")->row();	
				$dealername = $dealers_name->USER_NAME;
				$dealerID = $dealers_name->USER_ID;
			}	
			
			if(empty($dealername)){
				$dealername = ' '; 
				$dealerID = ' ';
			}
			
           $data[] = array( 
            "dealer_id" =>  $dealername.'('.$dealerID.')', 
			 "package_id" =>  $record->package_id,   
            "policy_no" => $record->policy_no, 
            "insurance_company" =>  $record->gic,
           "customer_name" => $record->customer_name,
           "customer_mobile" => $record->customer_mobile,
            "created_on" =>  $record->created_on,
            "expiry_date" =>  $record->expiry_date,
           "details"=> "<a href='".base_url()."dealers/package_details/".$record->id."' class=''><i class='fa fa-file-text'></i></a>",
           );
            //    }
		}
                   
                   
                   
                   
        }
           
        ## Response
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordwithFilter,
           "aaData" => $data
        );
   
        return $response; 
      }
	
	public function GetDrivingDistance_Mech($lat1, $long1, $lat2, $long2)
{
		$apiKey = 'AIzaSyBgW3kze70q1ov1DO0DMUDsZd3f8CUUOBw'; // Google maps now requires an API key.
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&units=metric&sensor=false&key=".$apiKey;
  
	$geocode=file_get_contents($url);

     
		
		 
    $output= json_decode($geocode, TRUE);	
	if(!empty($output['rows'][0]['elements'][0]['distance']) && !empty($output['rows'][0]['elements'][0]['duration'])){ 
    $dist = $output['rows'][0]['elements'][0]['distance']['value'];
    $time =  $output['rows'][0]['elements'][0]['duration']['text'];
 	
    return $dist;
	}else{
	return false;	
	}
}
	
	
	function getJobcardSpares($postData=null, $bkTypeRaw){

     $response = array();
		  
		
     ## Read value
     $draw = $postData['draw'];
     $start = $postData['start'];
     $rowperpage = $postData['length']; // Rows display per page
     $columnIndex = $postData['order'][0]['column']; // Column index
     $columnName = $postData['columns'][$columnIndex]['data']; // Column name
     $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
     $searchValue = $postData['search']['value']; // Search value

     ## Search 
     $searchQuery = "";
     if($searchValue != ''){
        $searchQuery = " (bookings.booking_id like '%".$searchValue."%' or bookings.customer_channel like '%".$searchValue."%' or bookings.customer_city like '%".$searchValue."%' or bookings.booking_id like '%".$searchValue."%' or bookings.customer_name like '%".$searchValue."%' or bookings.customer_phone like '%".$searchValue."%' or bookings.service_date like '%".$searchValue."%' ) ";
     }
		
		

     ## Total number of records without filtering
     $this->db->select('count(*) as allcount');
	  $this->db->join('jobcard', 'jobcard.booking_id = bookings.booking_id');	
	 $this->db->where("bookings.status != 'Ongoing' AND bookings.status != 'Completed' AND bookings.status != 'Cancelled' AND bookings.customer_city='".$bkTypeRaw."'");	
     $records = $this->db->get('bookings')->result();
     $totalRecords = $records[0]->allcount;

     ## Total number of record with filtering
     $this->db->select('count(*) as allcount');
     if($searchQuery != '')
        $this->db->where($searchQuery);
	 $this->db->join('jobcard', 'jobcard.booking_id = bookings.booking_id');	
	 $this->db->where("bookings.status != 'Ongoing' AND bookings.status != 'Completed' AND bookings.status != 'Cancelled' AND bookings.customer_city='".$bkTypeRaw."'");	
     $records = $this->db->get('bookings')->result();
     $totalRecordwithFilter = $records[0]->allcount;

     ## Fetch records
     $this->db->select('*');
     if($searchQuery != '')
        $this->db->where($searchQuery);
	 $this->db->join('jobcard', 'jobcard.booking_id = bookings.booking_id');	
	 $this->db->where("bookings.status != 'Ongoing' AND bookings.status != 'Completed' AND bookings.status != 'Cancelled' AND bookings.customer_city='".$bkTypeRaw."'");	
     $this->db->order_by($columnName, $columnSortOrder);
     $this->db->limit($rowperpage, $start);
     $records = $this->db->get('bookings')->result();

     $data = array();
		
     foreach($records as $record ){
		 	
		 
		 $showlist = '1';
		 
		 			 
		 				  
							
		 		 $getJobcards   = $this->db->query("SELECT * FROM jobcard_details WHERE complaints!='Additional Repair' AND complaints!='Service Category'  AND booking_id='".$record->booking_id."'")->result();
		 
		  	$i = 1;
		 	$sparesLists = '';
		 foreach($getJobcards as $getspare){ 
			 if(!empty($getspare->item)){ 
			 	if($i > 1){ 
				$sparesLists .= '<br>'.$getspare->item.' ('.$getspare->item_id.')';	
				}else{ 
					$sparesLists .= $getspare->item.' ('.$getspare->item_id.')';
				 }
		 		$i++;
			 }
		 }
				 
				 
			 
				 
		 $getmake_name   = $this->db->query("SELECT make_name FROM vehicle_make WHERE make_id='".$record->vehicle_make."'")->row();
							$make_name  = $getmake_name->make_name;
		 
		 $getmodel_name   = $this->db->query("SELECT model_name FROM vehicle_model WHERE model_id='".$record->vehicle_model."'")->row();
							$model_name  = $getmodel_name->model_name;
		 
		 $getservice_category   = $this->db->query("SELECT service_name FROM service_category WHERE id='".$record->service_category_id."'")->row();
							$service_category  = $getservice_category->service_name;
		 
		 
					$spares_assigned_q   = $this->db->query("SELECT COUNT(id) AS assigned FROM spares_recon WHERE booking_id='".$record->booking_id."'")->row();
				    if($spares_assigned_q->assigned>0){
						$assign_link = '-';
					}else{
						$assign_link ="<a href='".base_url()."bookings/spares_recon/".$record->booking_id."' class=''>Assign</a>";
					}

		 	if($showlist == '1'){ 
        $data[] = array( 
         "booking_no" =>   "<a href='".base_url()."bookings/booking_details/".$record->booking_id."' class=''>".$record->booking_id."</a>", 
		 "service_date" =>  date('d-m-Y', strtotime($record->service_date)),  
		 "customer_channel" =>  $record->customer_channel, 
		 "make_name" =>  $make_name, 
         "model_name" =>  $model_name,
		 "service_category" =>  $service_category,  
         "spares_list"=> $sparesLists,
         "assign" => $assign_link,
        );
			}
				
				
	  
				
				
     }
		
     ## Response
     $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
     );

     return $response; 
   }
	
//MAIN_MODEL END
}


?>

