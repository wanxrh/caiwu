<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 读取excel过滤器
 */
class PHPExcelReadFilter implements PHPExcel_Reader_IReadFilter {

    public $startRow = 1;
    public $endRow;

    public function readCell($column, $row, $worksheetName = '') {
        //如果endRow没有设置表示读取全部
        if (!$this->endRow) {
            return true;
        }
        //只读取指定的行
        if ($row >= $this->startRow && $row <= $this->endRow) {
            return true;
        }

        return false;
    }

}


class Test extends M_controller{
	/**
	 * [__construct 构造函数]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-15T14:07:28+0800
	 */
	public function __construct()
	{
	    parent::__construct();

	}
	//读取公告列表
	public function index(){
        header("Content-Type: text/html; charset=utf-8");
        set_time_limit(90);
        ini_set("memory_limit", "1024M");
        $startRow  = 1;
        $endRow    = 50;
        $excelFile = FR_ROOT . '/upload/777.xlsx';
        $result = $this->readFromExcel($excelFile, null, $startRow, $endRow);


        echo memory_get_usage();
        echo "<br />";
        echo 666;exit;


	}
    /**
     * 读取excel转换成数组
     *
     * @param string $excelFile 文件路径
     * @param string $excelType excel后缀格式
     * @param int $startRow 开始读取的行数
     * @param int $endRow 结束读取的行数
     * @retunr array
     */
    function readFromExcel($excelFile, $excelType = null, $startRow = 1, $endRow = null) {
        require_once(FR_ROOT.'/application/helpers/PHPExcel.php');

        $excelReader = \PHPExcel_IOFactory::createReader("Excel2007");
        $excelReader->setReadDataOnly(true);

        //如果有指定行数，则设置过滤器
        if ($startRow && $endRow) {
            $perf           = new PHPExcelReadFilter();
            $perf->startRow = $startRow;
            $perf->endRow   = $endRow;
            $excelReader->setReadFilter($perf);
        }

        $phpexcel    = $excelReader->load($excelFile);
        $activeSheet = $phpexcel->getActiveSheet();
        if (!$endRow) {
            $endRow = $activeSheet->getHighestRow(); //总行数
        }

        $highestColumn      = $activeSheet->getHighestColumn(); //最后列数所对应的字母，例如第2行就是B
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn); //总列数

        $data = array();
        for ($row = $startRow; $row <= $endRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $data[$row][] = (string) $activeSheet->getCellByColumnAndRow($col, $row)->getValue();
            }
        }
        return $data;
    }

}