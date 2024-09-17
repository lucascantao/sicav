var data = $('#date');
var current_value = data.val();
var ano = moment(data.val(), 'YYYY-MM-DD').format('YYYY');

$('#data_inicio').on('change', function () {

    if($('#data_inicio').val() != '') {

        if(moment($('#data_inicio').val(), 'YYYY-MM-DD').format('YYYY') != ano) {
            alert('A data de início da registro não pode exceder o ano atual da registro');
            $('#data_inicio').val(current_value);
        }

        $('#data_final').attr('disabled', false)
        if(moment($('#data_final').val()).isBefore(moment($('#data_inicio').val()))) {
            alert('A "Data Final" não pode ser menor que o início');
            $('#data_inicio').val($('#data_final').val());
        }

    } else {
        $('#data_final').attr('disabled', true);
        $('#data_final').val('');
    }
})

$('#data_final').on('change', function () {
    if(moment($('#data_final').val(), 'YYYY-MM-DD').format('YYYY') != ano) {
        alert('A data final da registro não pode exceder o ano atual da registro');
        $('#data_final').val(current_value);
    }

    if(moment($('#data_final').val()).isBefore(moment($('#data_inicio').val()))) {
        alert('A "Data Final" não pode ser menor que o início');
        $('#data_final').val($('#data_inicio').val());
    }
});
