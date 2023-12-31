<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/

/**
	Document blueprint use following parameters set in doctext.inc:

	$Addr1,	$Addr2 - address info
	$Payment_Terms - payment terms line
	$Footer - footer texts
	$this->company - company info
	$this->title - report title
	$this->formData - some other info
***/

		$this->row = $this->pageHeight - $this->topMargin;

		$upper = $this->row - 2 * $this->lineHeight;
               
		$lower = $this->bottomMargin + 7 * $this->lineHeight;
                // display_error($lower);
		$iline1 = $upper - 7.5 * $this->lineHeight;
		$iline2 = $iline1 - 8 * $this->lineHeight;
		$iline3 = $iline2 - 1.5 * $this->lineHeight;
		$iline4 = $iline3 - 1.5 * $this->lineHeight;
		$iline5 = $iline4 - 3 * $this->lineHeight;
		$iline6 = $iline5 - 1.5 * $this->lineHeight;
		$iline7 = $lower;
                $iline8 = $lower;
                $iline9 = $lower;
                $iline10 = $lower;
                $iline11 = $lower;
                $iline12 = $lower;
                $iline13 = $lower;
                $iline14 = $lower;
                $iline15 = $lower;
                $iline16 = $lower;
                $iline17 = $lower;
                $iline18 = $lower;
                $iline19 = $lower;
                $iline20 = $lower;
                $iline21 = $lower;
                
		$right = $this->pageWidth - $this->rightMargin;
		$width = ($right - $this->leftMargin) / 5;
		$icol = $this->pageWidth / 2;
		$ccol = $this->cols[0] + 4;
		$c2col = $ccol + 60;
		$ccol2 = $icol / 2;
		$mcol = $icol + 8;
		$mcol2 = $this->pageWidth - $ccol2;
		$cols = count($this->cols);
		$this->SetDrawColor(205, 205, 205);
		$this->Line($iline1, 3);
		$this->SetDrawColor(128, 128, 128);
		$this->Line($iline1);
		$this->rectangle($this->leftMargin, $iline2+50, $right - $this->leftMargin, $iline2 - $iline3, "F", null, array(222, 231, 236));   
		$this->Line($iline2+50);
		$this->Line($iline3+50);
		$this->Line($iline4+50);
               
		$this->rectangle($this->leftMargin, $iline5+50, $right - $this->leftMargin, $iline5 - $iline6, "F", null, array(222, 231, 236));   
		$this->Line($iline5+50);
		$this->Line($iline6+50);
		$this->Line($iline7);
              
                $this->LineTo($this->leftMargin, $iline2+50 ,$this->leftMargin, $iline4+50);
             
                
		$col = $this->leftMargin;
		for ($i = 0; $i < 5; $i++)
		{
			$this->LineTo($col += $width, $iline2+50,$col, $iline4+50);
		}
		$this->LineTo($this->leftMargin, $iline5+50 ,$this->leftMargin, $iline7);
                  // $this->Line($iline8+20);
		if ($this->l['a_meta_dir'] == 'rtl') // avoid line overwrite in rtl language
			$this->LineTo($this->cols[$cols - 2], $iline5 ,$this->cols[$cols - 2], $iline7);
		else	
                  
                $this->LineTo($this->cols[$cols-14]-15, $iline6+50 ,$this->cols[$cols-14]-15, $iline7);
                $this->LineTo($this->cols[$cols-13]+10 , $iline6+50 ,$this->cols[$cols-13]+10 , $iline7);
                $this->LineTo($this->cols[$cols-12]+10 , $iline6+50 ,$this->cols[$cols-12]+10 , $iline7);
                $this->LineTo($this->cols[$cols-11]-10 , $iline6+50 ,$this->cols[$cols-11]-10 , $iline7);
                $this->LineTo($this->cols[$cols-10]+1 , $iline6+50 ,$this->cols[$cols-10]+1 , $iline7);
                $this->LineTo($this->cols[$cols-9]+20 , $iline6+50 ,$this->cols[$cols-9]+20 , $iline7);
                $this->LineTo($this->cols[$cols-8]+50 , $iline6+50 ,$this->cols[$cols-7]-5 , $iline7);
                $this->LineTo($this->cols[$cols-7]+80 , $iline6+50 ,$this->cols[$cols-6]+45, $iline7);
                $this->LineTo($this->cols[$cols-5]+75 , $iline6+50 ,$this->cols[$cols-4]+40 , $iline7);
              //  $this->LineTo($this->cols[$cols-3]+45 , $iline6 ,$this->cols[$cols-2]-2 , $iline7);
                $this->LineTo($this->cols[$cols-1]-11 , $iline6+50 ,$this->cols[$cols-1]-11 , $iline7);
                
                
		$this->LineTo($right, $iline5+50 ,$right,$iline7);
                

		// Company Logo
		$this->NewLine();
		$logo = company_path() . "/images/" . $this->company['coy_logo'];
		if ($this->company['coy_logo'] != '' && file_exists($logo))
		{
			$this->AddImage($logo, $ccol, $this->row, 0, 40);
		}
		else
		{
			$this->fontSize += 4;
			$this->Font('bold');
			$this->Text($ccol, $this->company['coy_name'], $icol);
			$this->Font();
			$this->fontSize -= 4;
		}
                 $this->NewLine();
		// cument title
		$this->SetTextColor(190, 190, 190);
		$this->fontSize += 10;
		$this->Font('bold');
		$this->TextWrap($mcol, $this->row, $this->pageWidth - $this->rightMargin - $mcol - 20, $this->title, 'right');
		$this->Font();
		$this->fontSize -= 10;
		$this->NewLine();
		$this->SetTextColor(0, 0, 0);
		$adrline = $this->row-15;

		// Company data
		$this->TextWrapLines($ccol, $icol, $this->company['postal_address']);
                $this->row = $adrline;
                $this->Font('italic');
		if (@$this->company['phone'])
		{
			$this->Text($ccol, _("Phone"), $c2col);
			$this->Text($c2col, $this->company['phone'], $mcol);
			$this->NewLine();
		}
		if (@$this->company['fax'])
		{
			$this->Text($ccol, _("Fax"), $c2col);
			$this->Text($c2col, $this->company['fax'], $mcol);
			$this->NewLine();
		}
		if (@$this->company['email'])
		{
			$this->Text($ccol, _("Email"), $c2col);

			$url = "mailto:" . $this->company['email'];
			$this->SetTextColor(0, 0, 255);
			$this->Text($c2col, $this->company['email'], $mcol);
			$this->SetTextColor(0, 0, 0);
			$this->addLink($url, $c2col, $this->row, $mcol, $this->row + $this->lineHeight);

			$this->NewLine();
		}
		if (@$this->company['gst_no'])
		{
			$this->Text($ccol, _("GST NO."), $c2col);
			$this->Text($c2col, $this->company['gst_no'], $mcol);
			$this->NewLine();
		}
		if (@$this->formData['domicile'])
		{
			$this->Text($ccol, _("Domicile"), $c2col);
			$this->Text($c2col, $this->company['domicile'], $mcol);
			$this->NewLine();
		}
		$this->Font();
		$this->row = $adrline;
		$this->NewLine();
		$this->Text($mcol + 300, _("Date"));
		$this->Text($mcol + 325, sql2date($this->formData['document_date']));

		$this->NewLine();
		$this->Text($mcol + 300, $this->formData['document_name']);
		$this->Text($mcol + 350, $this->formData['document_number']);
		$this->NewLine(2);
	
		if ($this->pageNumber > 1)
			$this->Text($mcol + 180, _("Page") . ' ' . $this->pageNumber);
		$this->row = $iline1 - $this->lineHeight-5;
		//$this->fontSize -= 2;
             
                $this->Text($ccol, $Addr1['title'], $icol);
                $this->Text($ccol+45, ':', $icol);
                $this->Text($ccol+55, $Addr1['name'], $icol);
                $this->TextWrapLines($ccol+100,  $icol-$ccol,$Addr1['address']);
                $this->row = $iline1 - $this->lineHeight-5;
                $this->Text($mcol, $Addr2['title']);
                $this->Text($mcol+55, ':');
                $this->Text($mcol+60, $Addr2['name']);
                $this->TextWrapLines($mcol+110, $this->rightMargin - $mcol, $Addr2['address'], 'left', 0, 0, NULL, 1);

		 
		$col = $this->leftMargin;
		foreach($aux_info as $info_header => $info_content)
		{

			$this->row = $iline2 - $this->lineHeight + 50;
			$this->TextWrap($col, $this->row, $width, $info_header, 'C');
			$this->row = $iline3 - $this->lineHeight + 50 ;
			$this->TextWrap($col, $this->row, $width, $info_content, 'C');
			$col += $width;
		}
		// Payment terms
		$this->row -= (2 * $this->lineHeight);
		$this->Font('italic');
		$this->TextWrap($ccol, $this->row, $right-$ccol, $Payment_Terms);
		$this->Font();

		// Line headers
		$this->row = $iline5 - $this->lineHeight + 50;
		$this->Font('bold');
		$count = count($this->headers);
		$this->cols[$count] = $right - 3;
		for ($i = 0; $i < $count; $i++)
			$this->TextCol($i, $i + 1, $this->headers[$i], -2);
		$this->Font();

		// Footer
		$this->Font('italic');
		$this->row = $iline7 - $this->lineHeight - 6;
                //$this->row = $iline7 - $this->lineHeight - 6;
                 $this->Line($iline8+20);
               
               foreach($tot_info as $info_header => $info_content)
		{
                     //print_r($tot_info);
                 //  die();
                        $this->row = $iline7+5;
			$this->Text(330, $tot_info['0'].'.00');
			$this->row = $iline7+5;
			$this->Text(420, $tot_info['1']);
                        $this->row = $iline7+5;
			$this->Text(510, $tot_info['2']);
                        $this->row = $iline7+5;
			$this->Text(600, $tot_info['3'].'.00');
                        $this->row = $iline7+5;
			$this->Text(690, $tot_info['4'].'.00');
                        $this->row = $iline7+5;
                        //$this->Text(690, $tot_info['5'].'.00');
                        //$this->row = $iline7+5;
			$this->Text(750, $tot_info['5'].'.00');
			$col += $width;
//                       $this->Text(150, $info_content);
//                       $this->Text(200, $info_content);
//                        $this->Text(300, $info_content);
                       // $this->TextCol(400,500, $info_content);
			
			
		}
		foreach ($Footer as $line => $txt)
		{
                    
			if (!is_numeric($line))	// title => link
			{
				$this->fontSize -= 2;
				$this->TextWrap($ccol, $this->row, $right - $ccol, $line, 'C');
				$this->row -= $this->lineHeight;
				$this->SetTextColor(0, 0, 255);
				$this->TextWrap($ccol, $this->row, $right - $ccol, $txt, 'C');
				$this->SetTextColor(0, 0, 0);
				$this->addLink($txt, $ccol, $this->row, $this->pageWidth - $this->rightMargin, $this->row + $this->lineHeight);
				$this->fontSize += 2;
			}
			else
                            
				//$this->TextWrap($ccol, $this->row, $right - $ccol, $txt, 'C');
			$this->row -= $this->lineHeight;

		}

		$this->Font();
		$temp = $iline6 - $this->lineHeight - 2;
