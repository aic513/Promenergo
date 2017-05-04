<?php
defined('PROM') or exit('Access denied');
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

		$this->objPHPExcel->setActiveSheetIndex(0);  //задаем номер активного листа (для документа excel)
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

		$active_sheet->getDefaultRowDimension()->setRowHeight(22);  //устанавливаем новую высоту строк по-умолчанию

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
		/*
		 * стилизуем header
		 */
		$style_header = array(

			'font' => array(  //стиль для шрифта
				'bold' => true,
				'name' => 'Times New Roman',
				'size' => 20,
				'color' => array('rgb' => 'ffffff')
			),
			'alignment' => array(  //стиль для выравнивания текста
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'fill' => array(  //стиль фона заливки ячейки
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '2e778f')
			)

		);
		$active_sheet->getStyle('A1:C1')->applyFromArray($style_header);  //применить стили из массива

		/*
		 * устанавливаем логотип
		 */

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setPath('images/price_logo.png');
		$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());  //указываем рабочий лист для отображения логотипа
		$objDrawing->setCoordinates('A1');  //ячейка, где будет логотип
		$objDrawing->setOffsetX(5);  //смещение по Х
		$objDrawing->setOffsetY(3);  //смещение по Y


		$active_sheet->mergeCells('A2:C2');
		$active_sheet->setCellValue('A2', "Все виды сварного, трубного и другого оборудования");
		/*
		 * стилизуем слоган
		 */
		$style_slogan = array(

			'font' => array(
				'size' => 11,
				'color' => array('rgb' => 'ffffff'),
				'italic' => TRUE
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '2e778f')
			),
			'borders' => array(
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK
				)

			)

		);
		$active_sheet->getStyle('A2:C2')->applyFromArray($style_slogan);

		$active_sheet->mergeCells('A4:B4');
		$active_sheet->setCellValue('A4', 'Дата создания прасйслиста:');

		$style_tdate = array(


			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,

			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'CFCFCF')
			),
			'borders' => array(
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_NONE
				)

			)

		);

		$active_sheet->getStyle('A4:B4')->applyFromArray($style_tdate);
		/*
		 * указываем дату создания прайс-листа
		 */
		$date = date("d-m-Y");
		$active_sheet->setCellValue('C4', $date);
		$active_sheet->getStyle('C4')
			->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14);  //указываем каким способ она выводится

		$style_date = array(

			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'CFCFCF')
			),
			'borders' => array(
				'left' => array(
					'style' => PHPExcel_Style_Border::BORDER_NONE
				)
			)

		);

		$active_sheet->getStyle('C4')->applyFromArray($style_date);

		/*
		 * шапка прайс-листа
		 */
		$active_sheet->setCellValue('A6', 'Название');
		$active_sheet->setCellValue('B6', 'Описание');
		$active_sheet->setCellValue('C6', 'Цена');

		$style_hprice = array(


			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,

			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '2e778f')
			),
			'font' => array(
				'bold' => true,
				'italic' => true,
				'name' => 'Times New Roman',
				'size' => 10,
				'color' => array('rgb' => 'ffffff')
			)

		);

		$active_sheet->getStyle('A6:C6')->applyFromArray($style_hprice);

		/*
		 * Стилизуем данные из массива $catalog
		 */
		$style_parent = array(


			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,

			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'CFCFCF')
			),
			'font' => array(
				'bold' => true,
				'italic' => false,
				'name' => 'Times New Roman',
				'size' => 14,
				'color' => array('rgb' => '000000')
			)

		);

		$style_category = array(


			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,

			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'CFCFCF')
			),
			'font' => array(
				'bold' => true,
				'italic' => true,
				'name' => 'Times New Roman',
				'size' => 11,
				'color' => array('rgb' => '432332')
			)

		);


		$style_cell = array(


			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'wrap' => true,

			),
			'font' => array(
				'color' => array('rgb' => '432332')
			)

		);

		$style_wrap = array(

			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '696969')
				),
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK)
			)


		);

		$this->catalog = $this->ob_m->get_pricelist();

		$row_start = 6;  //начало отчета, с какой строки в документе будет заполнение данных
		$curent_row = $row_start;  //здесь хранится текущий ряд
		foreach ($this->catalog as $val) {

			if ($val['sub']) {  //здесь показываем родительскую категорию,ее дочерние категории и товары в этих дочерних категориях
				foreach ($val as $parent => $goods) {
					if ($parent != 'sub') {  //если на данной итерации цикла мы находмися в родительской категории
						$curent_row++;
						$active_sheet->mergeCells('A'.$curent_row.':C'.$curent_row);  //объединяем ячейки
						$active_sheet->setCellValue('A'.$curent_row, $parent);  //пишем в них название
						$active_sheet->getStyle('A'.$curent_row.':C'.$curent_row)->applyFromArray($style_parent);

						if (count($goods) > 0) {  //есть ли товары в родительской категории?
							foreach ($goods as $tovar) {
								$curent_row++;
								$active_sheet->setCellValue('A'.$curent_row, $tovar['title']);
								$active_sheet->setCellValue('B'.$curent_row, $tovar['anons']);
								$active_sheet->setCellValue('C'.$curent_row, $tovar['price']);

								$active_sheet->getStyle('A'.$curent_row.':C'.$curent_row)->applyFromArray($style_cell);
							}
						}
					} else {  //иначе на данной итерации цикла мы находмися в дочерней категории
						foreach ($goods as $category => $tovars) {
							$curent_row++;
							$active_sheet->mergeCells('A'.$curent_row.':C'.$curent_row);
							$active_sheet->setCellValue('A'.$curent_row, $category);
							$active_sheet->getStyle('A'.$curent_row.':C'.$curent_row)->applyFromArray($style_category);

							foreach ($tovars as $item) {
								$curent_row++;
								$active_sheet->setCellValue('A'.$curent_row, $item['title']);
								$active_sheet->setCellValue('B'.$curent_row, $item['anons']);
								$active_sheet->setCellValue('C'.$curent_row, $item['price']);
								$active_sheet->getStyle('A'.$curent_row.':C'.$curent_row)->applyFromArray($style_cell);
							}
						}


					}
				}
			} else {  //здесь выводим только родительскую категорию, у которой есть какие-то товары
				foreach ($val as $parent1 => $goods1) {
					$curent_row++;
					$active_sheet->mergeCells('A'.$curent_row.':C'.$curent_row);
					$active_sheet->setCellValue('A'.$curent_row, $parent1);
					$active_sheet->getStyle('A'.$curent_row.':C'.$curent_row)->applyFromArray($style_parent);
					if (count($goods1) > 0) {
						foreach ($goods1 as $tovar1) {
							$curent_row++;
							$active_sheet->setCellValue('A'.$curent_row, $tovar1['title']);
							$active_sheet->setCellValue('B'.$curent_row, $tovar1['anons']);
							$active_sheet->setCellValue('C'.$curent_row, $tovar1['price']);
							$active_sheet->getStyle('A'.$curent_row.':C'.$curent_row)->applyFromArray($style_cell);
						}
					}
				}
			}
		}


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