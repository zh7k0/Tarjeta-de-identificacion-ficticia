var $ = require('jquery');

function insertFirstRow() {
    //Agrega la primera fila
    $('<div/>', {
        'class' : 'table__row extra-row', html: getHtml()
    }).appendTo('#servicioData .table');

    $('#num_detalles').val(1);
    
    //Agrega una nueva fila cada vez que es clickeado
    $('#addRow').click(function () {
        $('<div/>', {
            'class' : 'table__row extra-row', html: getHtml()
        }).hide().appendTo('#servicioData .table').slideDown('slow');
        var num_items = $('.extra-row').length;
        $('#num_detalles').val(num_items);
    });

    $('#delRow').click(function(){
        var num_items = $('.extra-row').length;
        if(num_items > 1){
            $('.extra-row:last-child').slideUp('slow', (e)=>{
                $('.extra-row:last-child').remove();
                $('#num_detalles').val(num_items - 1);
            });
        }
    });
}

function getHtml()
{
    var len = $('.extra-row').length;
    var $html = $('.template-row').clone();
    $html.find('[name=detalle]')[0].name="detalle" + len;
    $html.find('[name=cantidad]')[0].name="cantidad" + len;
    $html.find('[name=porc_precio]')[0].name="porc_precio" + len;
    return $html.html();    
}

$(document).ready(function (){
if (document.querySelector('#servicioData')){
    insertFirstRow();
    console.log('Columna insertada');
}
});