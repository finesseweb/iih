/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 var oTable = ''; 
var dt = { _datatablesSettings : {
    _colvis:false,
    _colvis_name:false,
    _pageLength:-1,
    _image_pr:false,
    _logo:false,
    _buttons:1,
    _range: 0,
    _startMenuLength:1,
    _endMenuLength:1000,
    _batch:'',
    _dept:'',
    _session:'',
    _examyear:'',
    _resultdate:'',
    _degree_id:'',
    _non_col:false,
   
    _createtable: function () {
  var  batchcode = this._batch;
   var department = this._dept;
  var session_name = this._session;
    var examyear = this._examyear;
    var resultDate = this._resultdate;
    var degree_id = this._degree_id;
    var non_col = this._non_col;
   var  logo = this._logo;
  var range = parseInt(this._range);
     $.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = parseInt( $('#min').val(), 10 );
        var max = parseInt( $('#max').val(), 10 );
        var age = parseFloat(data[range]) || 0; // use data for the age column
 
        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && age <= max ) ||
             ( min <= age   && isNaN( max ) ) ||
             ( min <= age   && age <= max ) )
        {
            return true;
        }
        return false;          
    }
);

                var valarr = [];
                var name = [];
                let pageinc = 1;
                for (x = this._startMenuLength; x <= this._endMenuLength; x++) {
                    valarr.push(x);
                    name.push(x);
                }
                valarr.push('-1');
                name.push('All');
                    var pageLength = 10;
                    var lists = [valarr, name];

                
                    
                var title = $('.page-title>i,.page-title>div>i').text();
                 oTable = $('#datatable-responsive,#dataTable').DataTable({
                    "retrieve": true,
                    "paging": true,
                    "responsive": false,
                    "bScrollCollapse": true,      
                    "lengthChange": true,
                    "pageLength":this._pageLength,
                     fixedHeader: {
            header: true,
            },
                    dom: 'lBfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            text: '<b class="btn btn-xs text-primary"><strong><span class="fa fa-files-o"></span> Copy</strong> </b>',
                            filename: title + '(' + day + '-' + month + '-' + year + ')',
                            exportOptions: {
                                columns: "thead th:not(.no_print)",
                                modifier: {
                                    page: 'current'
                                }
                            },
                        },
                        {
                            extend: 'csv',
                            text: '<b class="btn  btn-xs text-primary"><strong><span class="fa fa-file-excel-o"></span> Excel </strong></b>',
                            customize: function (xlsx) {
                                var totalLen = parseInt(($('.complex').length ));
                                 var multiple = 1;
                                 var str = [];
                                 if(totalLen>1){
                                $('.complex').each(function (index, tr) {
                                    if (index < (totalLen)) {
                                             if($(this).data('id')!=='no_print'){
                                            if($(this).data('id')=='hide'){
                                                str.push('""'); 
                                            }
                                            else{
                                                str.push('"'+$(this).text()+'"');
                                            }
                                        }
                                        
                                    }
                                });
                            }
                            str.join(',');
                          return str+'\n'+xlsx;     
                        },
                            filename: title + '(' + day + '-' + month + '-' + year + ')',
                            exportOptions: {
                                columns: "thead th:not(.no_print)",
                                "columnDefs": [
                                    {"width": "20%", "targets": 0}
                                ],
                                modifier: {
                                    page: 'current'
                                }
                            }
                        },
                        {
                            extend: 'print',
                            text: '<b  class="btn  btn-xs text-primary"><strong><span class="fa fa-print"></span> Print </strong></b>',
                            title: "",
                             orientation: 'landscape', //landscape /portrait
                            pageSize: 'A3',
                            autoPrint: true,
                            customize: function (win) {
                                $(win.document.body)
                                        .css('font-size', '10pt')
                                        .prepend(
                                                '<img src="'+logo+'" style="position:fixed; top:30%; left:40%;   opacity: 0.08; height:50%" />'
                                                );

                                $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                 $(win.document.body ).find('.no_print').css('display', 'none');
                                 $(win.document.body ).find('table tbody td').css({'text-align':'center','font-size':'1.8em','vertical-align':'middle'});
                                $(win.document.body).find('thead').prepend("<tr id='firstHeader'></tr>");
                                $(win.document.body).find('th p:nth-child(1)').after("<hr/>")
                                $(win.document.body).find('th p').css("white-space","nowrap")
                                
                                var totalLen = parseInt(($('.complex').length ));
                                var colspan = parseInt($('thead>tr>th').length/2);
              $(win.document.body).find('thead').prepend("<tr><th style='text-align:center;' colspan ='"+(colspan+5)+"' id='pwcprintheader'></th></tr>");
              $(win.document.body).find('table').append("<tfoot id='pwcprintfooter' ></tfoot>")
//                            
                                if(totalLen>1){
                                   
                                $('.complex').each(function (index, tr) {
                                    if (index < (totalLen )) {
                                                if($(this).data('id')!=='no_print'){
                                                    
                                                 if( $(this).data('id')=='hide'){
                                                      $(win.document.body).find('#firstHeader').append('<th></th>');
                                                 }else{
                                                        $(win.document.body).find('#firstHeader').append('<th>' + $(this).text() + '</th>');
                                                }
                                              }
                                        
                                    }
                                    
                                });
                                
                             var principal = "";
                             var controller = "";
                             if(($('#term_id>option').length - 1)>$('#term_id>option:selected').index()){
                                 principal = "https://pwcadmissions.in/academic/public/images/principal.png";
                                 controller = "https://pwcadmissions.in/academic/public/images/controler.jpg";
                                 blank = "https://pwcadmissions.in/academic/public/images/Sister_Tanisha.jpg"
                             }
                                
                                //=======[For Header]=====================//
                  $(win.document.body).find("#pwcprintheader").append("<span style='font-size:2.5em'><b>PATNA WOMEN'S COLLEGE</b></span><br/>");
                  $(win.document.body).find("#pwcprintheader").append("<span style='font-size:2em'>AUTONOMOUS</span><br/>");
                  $(win.document.body).find("#pwcprintheader").append("<span style='font-size:2em'>PATNA UNIVERSITY</span><br/>");
                  if(non_col)
                  $(win.document.body).find("#pwcprintheader").append("<span style='font-size:2em'>NON COLLEGIATE TABULATION REGISTER</span><br/>");
                  else
                  $(win.document.body).find("#pwcprintheader").append("<span style='font-size:2em'>TABULATION REGISTER</span><br/>");
                  $(win.document.body).find("#pwcprintheader").append("<span style='font-size:2em'> "+batchcode+"</span><br/>");
                   $(win.document.body).find("#pwcprintheader").append("<span style='font-size:2em'> "+department+"</span><br/>");
                  $(win.document.body).find("#pwcprintheader").append("<span style='font-size:2em'> "+$('#term_id>option:selected').text()+" (Session "+session_name+") Examination held in the month of : "+examyear+"</span><br/>");
                  //$(win.document.body).find("#pwcprintheader").append("<span style='font-size:2em'>Semester : "+$('#term_id>option:selected').text()+"</span><br/>");
                  //$(win.document.body).find("#pwcprintheader").append("<span style='font-size:2em'>Examination held in the month of : "+examyear+"</span><br/>");
                  $(win.document.body).find("#pwcprintheader").append("<span style='font-size:2em'>Date of Result: "+resultDate+"</span><br/>");
             
                                //=============[For footer]===================//
                                if(degree_id==1)
$(win.document.body).find("#pwcprintfooter").append("<tr style='border:0px solid #000;'><th style='border:0px solid #000;font-size:1.5em !important;text-align:left !important' colspan ='"+(colspan+5)+"'>*=Fail</th></tr>");   
else
$(win.document.body).find("#pwcprintfooter").append("<tr style='border:0px solid #000;'><th style='border:0px solid #000;font-size:1.5em !important;text-align:left !important' colspan ='"+(colspan+5)+"'>*=Fail / **=Qualifying Only</th></tr>");  
 
$(win.document.body).find("#pwcprintfooter").append("<tr style=' border:0px solid #000;'><th style='border:0px solid #000; text-align:center; font-size:1.5em !important; ' colspan ='"+Math.round((colspan+5)/3)+"'><img src='"+blank+"' style='height:130px;' ><br/>Tabulator</th><th style='border:0px solid #000; text-align:center;font-size:1.5em !important;' colspan ='"+Math.round((colspan+5)/3)+"'><br/><img src='"+controller+"' style='height:100px;' ><br/><span>Controller of Examinations</span></th><th style='border:0px solid #000;  font-size:1.5em !important; text-align:center;' colspan ='"+Math.round((colspan+5)/3)+"'><br/><img src='"+principal+"' style='height:90px;,weight:90px;' ><br/><span>Principal</span></th></tr>");
$(win.document.body).find("#pwcprintfooter").append("<tr style='border:0px solid #000;'><td style='border:0px solid #000;font-size:1.5em !important;' colspan ='"+(colspan+5)+"'><span class='afterfooter'></span>  </td></tr>");        
                            }

                            },
                            exportOptions: {
                                columns: "thead tr th:not(.no_print)",
                                modifier: {
                                    page: 'current'
                                }
                            }
                        }, {
                            extend: 'pdf',
                            orientation: 'portrait', //landscape /portrait
                            pageSize: 'A3',
                            text: '<b class="btn btn-xs text-primary"><strong><span class="fa fa-file-pdf-o"></span> PDF </strong></b>',
                            filename: title + '(' + day + '-' + month + '-' + year + ')',
                            exportOptions: {
                                columns: "thead th:not(.no_print)",
                                search: 'applied',
                                order: 'applied',
                                modifier: {
                                    page: 'current',
                                    alignment: 'center'
                                }
                            }
                        },
                        {
                                                     extend: this._colvis,
                            text: this._colvis_name,
                            columnText: function ( dt, idx, title) {
                                    return dt+title;
                                 }
                        }

                    ],
                    "lengthMenu": lists
                });

              

// $( colvis.button() ).insertAfter('div.info');
// //or try this
// // $( colvis.button() ).prependTo('#dataTable_wrapper');
     
    // Event listener to the two range filtering inputs to redraw on input
   
 $('<div class="row" id="moved-visibility"  style="float:left;border:1px solid #000"></div>').appendTo('#datatable-responsive_filter,#dataTable_filter');
            $('a.buttons-colvis').appendTo("#moved-visibility");
            $('<div class="row" id="moved-buttons" style="margin-top:1em; margin-right:.09em;"></div>').appendTo('#datatable-responsive_filter,#dataTable_filter');
$('div[class="dt-buttons btn-group"]').appendTo('#moved-buttons');
$('select[name="dataTable_length"],select[name="datatable-responsive_length"]').select2();
if(this._buttons == '0'){
   $('#moved-buttons').remove();
}

            }
            
            }
        };


