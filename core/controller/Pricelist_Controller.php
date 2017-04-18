<?php

/*
 * Контроллер для генерации прайс листа по ссылке в excel документ
 */

class Pricelist_Controller extends Base
{
	protected $objPHPExcel;  //здесь лежит объект PHPExcel
	protected $catalog;  //здесь лежит массив данных для excel документа

	protected function input()
	{
		parent::input();
		include(LIB."/PHPExcel.php");  //подключаем класс PHPExcel
		$this->objPHPExcel = new PHPExcel();

		$this->objPHPExcel->setActiveSheetIndex(0);  //задаемномер активного листа (для документа excel)
		$active_sheet = $this->objPHPExcel->getActiveSheet();   //получаем объект активного листа
		//$this->objPHPExcel->createSheet();  создать не нулевой лист,а какой-то свой
		$active_sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);  //в настройках указываем,что ориентация портретная
		$active_sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);  //задаем размер листа для печати А4
		/*
		 * указываем поля таблицы
		 */
		$active_sheet->getPageMargins()->setTop(0.5);
		$active_sheet->getPageMargins()->setRight(0.75);
		$active_sheet->getPageMargins()->setLeft(0.75);
		$active_sheet->getPageMargins()->setBottom(1);

		$active_sheet->getDefaultRowDimension()->setRowHeight(22);

		$title = $active_sheet->setTitle('“ПромСтройЭнерго” - Прайс лист');  //название активного листа
		$active_sheet->getHeaderFooter()->setOddFooter('&L&B'.$active_sheet->getTitle().'&RСтраница &P из &N');  //фиксированный футер для всех листов
		$this->objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');  //семейство шрифтов по-умолчанию
		$this->objPHPExcel->getDefaultStyle()->getFont()->setSize(8);  //размер шрифта
		/*
		 * указываем ширину для столбцов A,B,C
		 */
		$active_sheet->getColumnDimension('A')->setWidth(30);
		$active_sheet->getColumnDimension('B')->setWidth(70);
		$active_sheet->getColumnDimension('C')->setWidth(10);

		$active_sheet->mergeCells('A1:C1');  //объединяем ячейки с А1 до С1
		$active_sheet->getRowDimension('1')->setRowHeight(60);  //увеличиваем высту рядов
		$active_sheet->setCellValue('A1', 'ПромСтройЭнерго');  //добваляем значение для ячейки А1

		$active_sheet->mergeCells('A2:C2');
		$active_sheet->setCellValue('A2', "Все виды сварного, трубного и другого оборудования");

		$active_sheet->mergeCells('A4:B4');
		$active_sheet->setCellValue('A4', 'Дата создания прасйслиста:');
		/*
		 * указываем дату создания прайс-листа
		 */
		$date = date("d-m-Y");
		$active_sheet->setCellValue('C4', $date);
		$active_sheet->getStyle('C4')
			->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14);  //указываем каким способ она выводится

		/*
		 * шапка прайс-листа
		 */
		$active_sheet->setCellValue('A6', 'Название');
		$active_sheet->setCellValue('B6', 'Описание');
		$active_sheet->setCellValue('C6', 'Цена');
		$this->catalog = $this->ob_m->get_pricelist();
		print_r($this->catalog);

	}


	protected function output()
	{
		header("Content-Type:application/vnd.ms-excel");  //указали брайзеру,что хотим открыть excel документ
		header("Content-Disposition:attachment;filename='pricelist.xls'");  //документ необходимо отдать пользователю на скачивание
		/*
		 * $objWriter - объект класса, который сохраняет документ в указанной нами версии
		 */
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');  //создать документ в версии excel5
		$objWriter->save("php://output");  //сохраняем документ

		exit();
	}
}